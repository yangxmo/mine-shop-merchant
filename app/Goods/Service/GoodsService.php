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

namespace App\Goods\Service;

use App\Goods\Mapper\GoodsMapper;
use Hyperf\Collection\Arr;
use Mine\Abstracts\AbstractService;

/**
 * 商品分类服务类.
 */
class GoodsService extends AbstractService
{
    /**
     * @var GoodsMapper
     */
    public $mapper;

    public function __construct(GoodsMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 保存商品
     */
    public function save(array $data): int
    {
        $skuData = [];
        // build 属性
        $data['attributes_data'] = Arr::where($data['attributes_data'], function (&$value) use (&$skuData) {
            $attributesNo = snowflake_id();
            $value['attr_no'] = rand(10000, (int)$attributesNo);

            // build 属性
            $value['value'] = Arr::where($value['value'], function (&$values) use ($value, &$skuData) {
                $values['attr_no'] = $value['attr_no'];
                $values['attr_value_no'] = (int)snowflake_id();

                // build sku
                $skuData = Arr::where($values['sku_data'], function (&$sku) use ($values) {
                    $sku['goods_attr_no'] = $values['attr_value_no'];
                    $sku['goods_sku_id'] = (int)snowflake_id();
                    return $sku;
                });

                unset($values['sku_data']);

                return $values;
            });

            return $value;
        }
        );

        // build 属性值
        $data['attributes_value'] = Arr::collapse(array_column($data['attributes_data'], 'value'));
        $data['sku_data'] = $skuData;

        return $this->mapper->save($data);
    }

    /**
     * 修改商品
     */
    public function update(int $id, array $data): bool
    {
        // build 属性
        $data['attributes_data'] = Arr::where($data['attributes_data'], function (&$value) use (&$skuData) {
            // 处理新增
            empty($value['attr_no']) && $value['attr_no'] = rand(10000, (int)snowflake_id());

            // build 属性
            $value['value'] = Arr::where($value['value'], function (&$values) use ($value, &$skuData) {
                $values['attr_no'] = $value['attr_no'];
                // 新增
                empty($value['attr_value_no']) && $value['attr_value_no'] = (int)snowflake_id();

                // build sku
                $skuData = Arr::where($values['sku_data'], function (&$sku) use ($values) {
                    $sku['goods_attr_no'] = $values['attr_value_no'];
                    empty($sku['goods_sku_id']) && $sku['goods_sku_id'] = (int)snowflake_id();
                    return $sku;
                });

                unset($values['sku_data']);

                return $values;
            });

            return $value;
        }
        );

        // build 属性值
        $data['attributes_value'] = Arr::collapse(array_column($data['attributes_data'], 'value'));
        $data['sku_data'] = $skuData;

        return $this->mapper->update($id, $data);
    }
}
