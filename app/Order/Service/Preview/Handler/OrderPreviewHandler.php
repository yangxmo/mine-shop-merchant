<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Order\Service\Preview\Handler;

use App\Goods\Constants\GoodsConstants;
use App\Goods\Model\Goods;
use App\Goods\Service\Domain\GoodsDomainService;
use App\Goods\Service\Domain\GoodsSkuDomainService;
use App\Order\Cache\GoodsCartCache;
use App\Order\Cache\GoodsStockLuaCache;
use App\Order\Cache\OrderCache;
use App\Order\Service\Preview\Abstract\OrderPreviewAbstract;
use App\Order\Trait\OrderPriceTrait;
use Hyperf\Collection\Arr;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use RedisException;

class OrderPreviewHandler extends OrderPreviewAbstract
{
    use OrderPriceTrait;

    #[Inject]
    protected GoodsDomainService $goodsDomainService;
    #[Inject]
    protected GoodsSkuDomainService $goodsSkuDomainService;
    #[Inject]
    protected GoodsStockLuaCache $goodsStockLuaCache;

    // 检查订单产品信息
    public function checkOrderProduct(): OrderPreviewAbstract
    {
        // 检查产品库存
        $checkStock = $this->goodsStockLuaCache->checkStock($this->orderVo->getProductData());
        // 库存不足
        if (!$checkStock) {
            $this->setOrderError(t('order.product_stock_no_free'));
        }
        // 检查商品状态
        Arr::where($this->orderVo->getProductData(), function ($goods) {
            /** @var Goods $goodsInfo */
            $goodsInfo = $this->goodsDomainService->read($goods['goods_id']);
            if (!empty($goods['goods_sku_id'])) {
                $goodsSkuInfo = $this->goodsDomainService->read($goods['goods_id']);
            }
            // 产品不存在
            if(empty($goodsInfo) || (!empty($goodsInfo['goods_sku_id']) && empty($goodsSkuInfo))) {
                $this->setOrderError(t('order.product_not_found'));
            }
            // 产品状态异常
            if($goodsInfo->goods_status != GoodsConstants::GOODS_STATUS_USE) {
                $this->setOrderError(t('order.goods_use_fail') . $goodsInfo->goods_name);
            }
        });

        return $this;
    }

    // 计算订单产品价格
    public function checkOrderProductPayPrice(): OrderPreviewAbstract
    {
        // 初始化金额
        $allProductPrice = $allFreightPrice = 0;

        Arr::where($this->orderVo->getProductData(), function ($goods) use (&$allProductPrice, &$allFreightPrice){
            // 计算产品金额
            $this->calculateOrderPrice($allProductPrice, $goods['goods_num'], $goods['goods_price']);
            // 计算运费
            $this->calculateOrderFreightPrice($allProductPrice, $goods['goods_num'], $goods['goods_price']);
        });

        // 合并总订单金额
        $allOrderPrice = floatval(bcadd((string)$allFreightPrice, (string)$allProductPrice, 2));
        // 合并支付金额
        $allOrderPayPrice = floatval(bcadd((string)$allFreightPrice, (string)$allProductPrice, 2));
        // 设置订单金额
        $this->orderVo->setOrderPrice($allOrderPrice);
        // 设置订单支付金额
        $this->orderVo->setOrderPayPrice($allOrderPayPrice);
        // 设置运费
        $this->orderVo->setOrderFreightPrice($allFreightPrice);

        return $this;
    }

    //构建所需产品信息
    public function buildGoodsInfo(): OrderPreviewAbstract
    {
        $newProductData = [];
        $productData = $this->orderVo->getProductData();

        // 定义rpc调用时候租户
        Arr::where($productData, function ($value) use (&$newProductData) {
            // 获取信息
            $productInfo = $this->goodsDomainService->read($value['id']);
            // 获取sku信息
            $productSkuInfo = $this->goodsSkuDomainService->read($value['goods_sku_id'] ?? null);
            // 产品不存在
            if (empty($productInfo) || !empty($productSkuId) && empty($productSkuInfo)) {
                $this->setOrderError(t('order.product_not_found'));
            }
            // 产品sku信息
            $productName = $productInfo['goods_name'] ?? '';
            $productSkuName = $productSkuInfo['goods_sku_name'] ?? '';
            $productSkuValue = $productSkuInfo['goods_sku_value'] ?? '';
            $productPrice = $productSkuInfo['goods_sku_price'] ?? $productInfo['goods_price'] ?? 0.00;
            $productImage = $productSkuInfo['goods_images'][0] ?? $productInfo['goods_sku_images'] ?? '';
            // 组装产品
            $newProductData[] = [
                'goods_id' => (int)$value['id'],
                'goods_name' => $productName,
                'goods_sku_name' => $productSkuName ?? $productName ?? '',
                'goods_sku_value' => $productSkuValue ?? '',
                'goods_image' => $productImage,
                'goods_price' => (float)$productPrice,
                'goods_num' => (int)$value['goods_num'],
                'goods_sku_id' => (int)$value['goods_sku_id'],
                'goods_freight_price' => 0,
                'goods_discount_price' => 0,
                'goods_pay_price' => 0,
            ];
        });

        $this->orderVo->productData = $newProductData;

        return $this;
    }

    /**
     * 订单后续操作.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RedisException
     */
    public function after(string $orderNo, array $confirmOrder): void
    {
        $orderCache = container()->get(OrderCache::class);
        $orderCartCache = container()->get(GoodsCartCache::class);
        $orderCache->setConfirmCache($orderNo, $confirmOrder);

        // 如果是购物车购买，则删除购物车指定商品
        if ($this->orderVo->isCart) {
            Arr::where($this->orderVo->productData, function ($product) use ($orderCartCache) {
                $orderCartCache->delCartData((int)$product['goods_id'], (int)$product['goods_sku_id'] ?? null);
            });
        }
    }
}
