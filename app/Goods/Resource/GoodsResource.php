<?php

declare(strict_types=1);

namespace App\Goods\Resource;

use Hyperf\Codec\Json;
use Hyperf\Resource\Json\JsonResource;

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
class GoodsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(): array
    {
        $data = $this->resource;

        if (empty($data['items'])) {
            return $this->resource;
        }

        $newData = [];

        foreach ($data['items'] as $dataKey => &$datum) {
            $productInfo = $datum['product_data'] ?? [];
            $productImages = !empty($productInfo['product_images']) ? Json::decode($productInfo['product_images']) : [];
            // 代发价格
            [$productAgentPrice, $skuMinPrice] = $this->getSkuPrice($datum);
            // 市场价格
            [$productMarketPrice, $skuMinMarketPrice] = $this->getSkuMarketPrice($datum);

            /**
             * 成本 = 销售价 = 供货价
             * 利润=市场价-供货价
             * 利润率 = 利润÷成本×100%
             * 毛利率 =（市场价－成本）÷市场价价×100%
             * 折扣 = 成本÷市场价X10
             */

            if (empty($skuMinPrice) || empty($skuMinMarketPrice)) {
                $profit = $productProfit = $productGrossProfit = $productDiscount = 0;
            } else {
                // 计算利润
                $profit = bcsub((string)$skuMinMarketPrice, (string)$skuMinPrice, 2);
                // 计算利润率
                $productProfit = $profit ? bcmul(bcdiv($profit, (string)$skuMinPrice, 2), '100') : 0;
                // 计算毛利率
                $productGrossProfit = bcmul(bcdiv(bcsub((string)$skuMinMarketPrice, (string)$skuMinPrice, 2), (string)$skuMinMarketPrice, 2), '100');
                // 计算折扣
                $productDiscount = bcmul(bcdiv((string)$skuMinMarketPrice, (string)$skuMinPrice, 2), '10');
            }


            $newData[] = [
                'product_no' => $productInfo['product_no'] ?? '',
                'product_name' => $productInfo['product_name'] ?? '',
                'product_images' => $productImages['images'][0] ?? '',
                'product_status' => $productInfo['product_status'] ?? 2,
                'product_stock' => $productInfo['product_sale'] ?? 0,
                'product_agent_price' => $productAgentPrice,
                'product_market_price' => $productMarketPrice,
                'product_profit' => $productProfit . '%',
                'product_gross_profit' => $productGrossProfit . '%',
                'product_discount' => $productDiscount . '%',
                'created_at' => $productInfo['created_at'],
            ];
        }

        $data['items'] = $newData;

        return $data;
    }

    public function infoToArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'feed_count' => $this->feed_count,
            'status' => $this->status,
            'sort' => $this->sort,
        ];
    }


    private function getSkuPrice($product)
    {
        if (!empty($productSku = $product['product_sku_data'])) {
            $skuMinPrice = min(array_column($productSku, 'product_sku_price'));
            $skuMaxPrice = max(array_column($productSku, 'product_sku_price'));
            if ($skuMinPrice == $skuMaxPrice) {
                $productAgentPrice = floatval($skuMinPrice);
            } else {
                $productAgentPrice = floatval($skuMinPrice) . '~' . floatval($skuMaxPrice);
            }

        } else {
            $skuMinPrice = floatval($product['product_data']['product_price']);
            $productAgentPrice = floatval($skuMinPrice);
        }

        return [$productAgentPrice, $skuMinPrice];
    }

    private function getSkuMarketPrice($product)
    {
        if (!empty($productSku = $product['product_sku_data'])) {
            $skuMinMarketPrice = min(array_column($productSku, 'product_sku_market_price'));
            $skuMaxMarketPrice = max(array_column($productSku, 'product_sku_market_price'));
            if ($skuMinMarketPrice == $skuMaxMarketPrice) {
                $productMarketPrice = floatval($skuMinMarketPrice);
            } else {
                $productMarketPrice = floatval($skuMinMarketPrice) . '~' . floatval($skuMaxMarketPrice);
            }

        } else {
            $skuMinMarketPrice = floatval($product['product_data']['product_price']);
            $productMarketPrice = floatval($skuMinMarketPrice);
        }

        return [$productMarketPrice, $skuMinMarketPrice];
    }
}
