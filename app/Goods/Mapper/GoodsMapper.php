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

namespace App\Goods\Mapper;

use App\Goods\Model\Goods;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Annotation\CacheEvict;
use Hyperf\Collection\Arr;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;
use Mine\Annotation\Transaction;
use Mine\MineModel;

/**
 * 商品Mapper类.
 */
class GoodsMapper extends AbstractMapper
{
    /**
     * @var Goods
     */
    public $model;

    public function assignModel(): void
    {
        $this->model = Goods::class;
    }

    /**
     * 商品详情.
     */
    #[Cacheable(prefix: 'goods', value: '#{id}', group: 'goods')]
    public function read(int $id, array $column = ['*']): ?MineModel
    {
        return $this->model::with(['attribute', 'affiliate', 'attribute.attributeValue', 'sku'])->first($column);
    }

    /**
     * 新增商品
     */
    #[Transaction]
    public function save(array $data): int
    {
        $skuData = $data['sku_data'] ?? [];
        $affiliateData = $data['affiliate_data'] ?? [];
        $attributesData = $data['attributes_data'] ?? [];
        $attributesValueData = $data['attributes_value'] ?? [];

        // 移除其他数据
        $data = Arr::except($data, 'sku_data');
        $data = Arr::except($data, 'affiliate_data');
        $data = Arr::except($data, 'attributes_data');
        $data = Arr::except($data, 'attributes_value');

        // 过滤其他字段
        $this->filterExecuteAttributes($data, $this->getModel()->incrementing);

        $goods = $this->model::create($data);
        // 写入sku
        !empty($skuData) && $goods->sku()->createMany($skuData);
        // 写入属性
        !empty($attributesData) && $goods->attribute()->createMany($attributesData);
        // 写入附属属性
        !empty($affiliateData) && $goods->affiliate()->create($affiliateData);
        // 写入属性值
        !empty($attributesValueData) && $goods->attributeValue()->createMany($attributesValueData);

        return $goods->id;
    }

    /**
     * 修改商品
     */
    #[CacheEvict(prefix: 'goodsInfo', value: '#{id}', group: 'goods'), Transaction]
    public function update(int $id, array $data): bool
    {
        $goods = $this->read($id);

        $skuData = $data['sku_data'] ?? [];
        $affiliateData = $data['affiliate_data'] ?? [];
        $attributesData = $data['attributes_data'] ?? [];
        $attributesValueData = $data['attributes_value'] ?? [];

        $data = Arr::except($data, 'sku_data');
        $data = Arr::except($data, 'attributes_data');
        $data = Arr::except($data, 'attributes_value');

        $nowAttrIds = array_column($skuData, 'attr_no');
        $nowAttrValueIds = array_column($skuData, 'attr_value_no');
        $nowSkuIds = array_column($skuData, 'goods_sku_id');

        // 删除其他数据
        $nowSkuIds && $goods->sku()->whereNotIn('goods_sku_id', $nowSkuIds)->delete();
        $nowAttrIds && $goods->attribute()->whereNotIn('attr_no', $nowAttrIds)->delete();
        $nowAttrValueIds && $goods->attributeValue()->whereNotIn('attr_value_no', $nowAttrValueIds)->delete();

        // 过滤
        $this->filterExecuteAttributes($data, true);

        $goods->save($data);
        $goods->affiliate()->update($affiliateData);

        Arr::where($skuData, function ($sku) use ($goods) {
            $goods->sku()->updateOrCreate(['goods_sku_id' => $sku['goods_sku_id']], $sku);
        });
        Arr::where($attributesData, function ($attribute) use ($goods) {
            $goods->attribute()->updateOrCreate(['attr_no' => $attribute['attr_no']], $attribute);
        });
        Arr::where($attributesValueData, function ($attributeValue) use ($goods) {
            $goods->attributeValue()->updateOrCreate(['attr_value_no' => $attributeValue['attr_value_no']], $attributeValue);
        });

        return true;
    }

    /**
     * 删除.
     */
    #[CacheEvict(prefix: 'goodsInfo', value: '#{ids.id}', group: 'goods')]
    public function delete(array $ids): bool
    {
        return parent::delete([$ids['id']]);
    }

    /**
     * 分页
     */
    public function getPageList(?array $params, bool $isScope = true, string $pageName = 'page'): array
    {
        $query = $this->listQuerySetting($params, $isScope);
        // 筛选
        $query->with(['affiliate' => function ($query) use ($params){ $this->handleAffiliateSearch($query, $params); }]);
        // 分页
        $paginate = $query->paginate((int)$params['pageSize'] ?? $this->model::PAGE_SIZE, ['*'], $pageName, (int)$params[$pageName] ?? 1);

        return $this->setPaginate($paginate, $params);
    }

    /**
     * 查询附属信息
     */
    function handleAffiliateSearch( $query, array $params)
    {
        // 是否预售商品（1否2是）
        if (!empty($params['goods_is_presell'])) {
            $query->where('goods_is_presell', '=', $params['goods_is_presell']);
        }

        // 是否限购商品（1否2是）
        if (!empty($params['goods_is_purchase'])) {
            $query->where('goods_is_purchase', '=', $params['goods_is_purchase']);
        }

        // 限购商品类型（1单次限购2全部限购）
        if (!empty($params['goods_purchase_type'])) {
            $query->where('goods_purchase_type', '=', $params['goods_purchase_type']);
        }

        // 是否会员商品（1否2是）
        if (!empty($params['goods_is_vip'])) {
            $query->where('goods_is_vip', '=', $params['goods_is_vip']);
        }

        // 商品物流方式，（1物流2到店核销）
        if (!empty($params['goods_logistics_type'])) {
            $query->where('goods_logistics_type', '=', $params['goods_logistics_type']);
        }

        // 商品运费方式，（1固定邮费2运费模板）
        if (!empty($params['goods_freight_type'])) {
            $query->where('goods_freight_type', '=', $params['goods_freight_type']);
        }

        return $query;
    }

    public function handleSearch(Builder $query, array $params): Builder
    {
        if (!empty($params['id']) && is_array($params['id'])) {
            $query->whereIn('id', $params['id']);
        }

        if (!empty($params['goods_status'])) {
            $query->where('goods_status', $params['goods_status']);
        }

        if (!empty($params['goods_category_id'])) {
            $query->where('goods_category_id', $params['goods_category_id']);
        }

        if (!empty($params['goods_sale'])) {
            $query->where('goods_sale', $params['goods_sale']);
        }

        if (!empty($params['goods_lock_sale'])) {
            $query->where('goods_lock_sale', $params['goods_lock_sale']);
        }

        if (!empty($params['goods_name'])) {
            $query->where('goods_name', 'like', $params['goods_name'] . '%');
        }

        return $query;
    }
}
