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
        return $this->model::with(['attribute', 'attribute.attributeValue', 'sku'])->first($column);
    }

    /**
     * 新增商品
     */
    #[Transaction]
    public function save(array $data): int
    {
        $skuData = $data['sku_data'] ?? [];
        $attributesData = $data['attributes_data'] ?? [];
        $attributesValueData = $data['attributes_value'] ?? [];

        $data = Arr::except($data, 'sku_data');
        $data = Arr::except($data, 'attributes_data');
        $data = Arr::except($data, 'attributes_value');

        // 过滤其他字段
        $this->filterExecuteAttributes($data, $this->getModel()->incrementing);

        $goods = $this->model::create($data);
        // 写入sku
        !empty($skuData) && $goods->sku()->createMany($skuData);
        // 写入属性
        !empty($attributesData) && $goods->attribute()->createMany($attributesData);
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

    public function handleSearch(Builder $query, array $params): Builder
    {
        if (! empty($params['id']) && is_array($params['id'])) {
            $query->whereIn('id', $params['id']);
        }

        if (! empty($params['goods_status'])) {
            $query->where('goods_status', $params['goods_status']);
        }

        if (! empty($params['goods_category_id'])) {
            $query->where('goods_category_id', $params['goods_category_id']);
        }

        if (! empty($params['goods_sale'])) {
            $query->where('goods_sale', $params['goods_sale']);
        }

        if (! empty($params['goods_lock_sale'])) {
            $query->where('goods_lock_sale', $params['goods_lock_sale']);
        }

        if (! empty($params['goods_name'])) {
            $query->where('goods_name', 'like', $params['goods_name'] . '%');
        }

        return $query;
    }
}
