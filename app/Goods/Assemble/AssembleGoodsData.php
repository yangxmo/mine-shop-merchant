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

namespace App\Goods\Assemble;

use Hyperf\Collection\Arr;

class AssembleGoodsData
{
    public static function buildGoodsAttribute(array $params, array &$skuData): array
    {
        return Arr::where(
            $params['attributes_data'],
            function (&$value) use (&$skuData, $params) {
                $attributesNo = snowflake_id();
                $value['attr_no'] = rand(10000, (int) $attributesNo);
                $value['goods_category_id'] = $params['goods_category_id'];

                // build 属性
                $value['value'] = Arr::where($value['value'], function (&$values) use ($value, &$skuData) {
                    $values['attr_no'] = $value['attr_no'];
                    $values['attr_value_no'] = (int) snowflake_id();
                    // build sku
                    $skuData = Arr::where($values['sku_data'], function (&$sku) use ($values) {
                        $sku['goods_attr_no'] = $values['attr_no'];
                        $sku['goods_sku_id'] = (int) snowflake_id();
                        return $sku;
                    });

                    unset($values['sku_data']);

                    return $values;
                });

                return $value;
            }
        );
    }

    public static function buildUpdateGoodsAttribute(array $params, array &$skuData): array
    {
        return Arr::where(
            $params['attributes_data'],
            function (&$value) use (&$skuData, $params) {
                $value['goods_category_id'] = $params['goods_category_id'];
                // 处理新增
                empty($value['attr_no']) && $value['attr_no'] = rand(10000, (int) snowflake_id());

                // build 属性
                $value['value'] = Arr::where($value['value'], function (&$values) use ($value, &$skuData) {
                    $values['attr_no'] = $value['attr_no'];
                    // 新增
                    empty($value['attr_no']) && $value['attr_no'] = (int) snowflake_id();

                    // build sku
                    $skuData = Arr::where($values['sku_data'], function (&$sku) use ($values) {
                        $sku['goods_attr_no'] = $values['attr_value_no'];
                        empty($sku['goods_sku_id']) && $sku['goods_sku_id'] = (int) snowflake_id();
                        return $sku;
                    });

                    unset($values['sku_data']);

                    return $values;
                });

                return $value;
            }
        );
    }

    public static function buildGoodsAffiliate(array $data): array
    {
        return [
            'goods_is_presell' => $data['goods_is_presell'],
            'goods_is_purchase' => $data['goods_is_purchase'],
            'goods_purchase_type' => $data['goods_purchase_type'],
            'goods_purchase_num' => $data['goods_purchase_num'],
            'goods_is_vip' => $data['goods_is_vip'],
            'goods_buy_point' => $data['goods_buy_point'],
            'goods_sales' => $data['goods_sales'],
            'goods_unit' => $data['goods_unit'],
            'goods_logistics_type' => $data['goods_logistics_type'],
            'goods_freight_type' => $data['goods_freight_type'],
            'goods_recommend' => $data['goods_recommend'],
        ];
    }
}
