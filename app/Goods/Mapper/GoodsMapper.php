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
use Mine\Abstracts\AbstractMapper;
use Mine\Annotation\Transaction;

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
}
