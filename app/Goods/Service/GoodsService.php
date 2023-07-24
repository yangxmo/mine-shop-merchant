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
        // build sku属性
        $data['sku_data'] = Arr::where($data['sku_data'], function (&$value) {
            $value['goods_sku_id'] = (int) snowflake_id();
            return $value;
        });
        // build 属性
        $data['attributes_data'] = Arr::where(
            $data['attributes_data'],
            function (&$value) {
                $attributesNo = snowflake_id();
                $value['attributes_no'] = rand(10000, (int) $attributesNo);
                $value['value'] = Arr::where($value['value'], function (&$values) use ($value) {
                    $values['attr_no'] = $value['attributes_no'];
                    return $values;
                });
                return $value;
            }
        );
        // build 属性值
        $data['attributes_value'] = Arr::collapse(array_column($data['attributes_data'], 'value'));

        return $this->mapper->save($data);
    }

    /**
     * 修改商品
     */
    public function update(int $id, array $data): bool
    {
        // build sku属性
        $data['sku_data'] = Arr::where($data['sku_data'], function (&$value) {
            empty($value['goods_sku_id']) && $value['goods_sku_id'] = (int) snowflake_id();
            return $value;
        });
        // build 属性
        $data['attributes_data'] = Arr::where(
            $data['attributes_data'],
            function (&$value) {
                $attributesNo = snowflake_id();
                empty($value['attributes_no']) && $value['attributes_no'] = rand(10000, (int) $attributesNo);
                $value['value'] = Arr::where($value['value'], function (&$values) use ($value) {
                    empty($values['attr_no']) && $values['attr_no'] = $value['attributes_no'];
                    return $values;
                });
                return $value;
            }
        );
        // build 属性值
        $data['attributes_value'] = Arr::collapse(array_column($data['attributes_data'], 'value'));

        return $this->mapper->update($id, $data);
    }
}
