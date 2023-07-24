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
        $goods = $this->model::create($data['goods_data']);
        // 写入sku
        $goods->sku()->createMany($data['sku_data']);
        // 写入属性
        $goods->attribute()->createMany($data['attributes_data']);
        // 写入属性值
        $goods->attributeValue()->createMany($data['attributes_value']);

        return $goods->id;
    }

    /**
     * 修改商品
     */
    #[CacheEvict(prefix: 'goodsInfo', value: '#{id}', group: 'goods'), Transaction]
    public function update(int $id, array $data): bool
    {
        $goods = $this->read($id);

        $goods->save($data['goods_data']);

        Arr::where($data['sku_data'], function ($sku) use ($goods) {
            $goods->sku()->updateOrCreate(['goods_sku_id' => $sku['goods_sku_id']], $sku);
        });
        Arr::where($data['attributes_data'], function ($attribute) use ($goods) {
            $goods->attribute()->updateOrCreate(['attributes_no' => $attribute['attributes_no']], $attribute);
        });
        Arr::where($data['attributes_value'], function ($attributeValue) use ($goods) {
            $goods->attributeValue()->updateOrCreate(['attr_no' => $attributeValue['attr_no']], $attributeValue);
        });

        // 删除其他数据
        $goods->sku()->whereNotIn('goods_sku_id', array_column($data['sku_data'], 'goods_sku_id'))->delete();
        $goods->attribute()->whereNotIn('attributes_no', array_column($data['attributes_data'], 'attributes_no'))->delete();
        $goods->attributeValue()->whereNotIn('attr_no', array_column($data['attributes_value'], 'attr_no'))->delete();

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
