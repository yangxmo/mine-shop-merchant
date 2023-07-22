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
namespace App\Goods\Request;

use Hyperf\Validation\Rule;
use Mine\MineFormRequest;

/**
 * 商品分类验证数据类.
 */
class GoodsRequest extends MineFormRequest
{
    /**
     * 公共规则.
     */
    public function commonRules(): array
    {
        return [];
    }

    /**
     * 新增数据验证规则
     * return array.
     */
    public function saveRules(): array
    {
        return [
            'goods_data' => 'required|array',
            // 商品名称 验证
            'goods_data.goods_name' => 'required_with:goods_data|between:2,50',
            // 分类排序 验证
            'goods_data.goods_category_id' => ['required', 'integer'], // Rule::exists('goods_category', 'id')
            // 产品价格
            'goods_data.goods_price' => 'required|numeric|min:0.01|max:9999999',
            // 市场价
            'goods_data.goods_market_price' => 'required|numeric|min:0.01|max:9999999',
            // 总库存
            'goods_data.goods_sale' => 'required|integer|min:0|max:9999999',
            // 商品图片 验证
            'goods_data.goods_images' => 'required_with:goods_data|array',
            // 商品状态(2下架1上架) 验证
            'goods_data.goods_status' => 'required_with:goods_data|integer|in:1,2',
            // 语言（1中文2英文）
            'goods_data.goods_language' => 'required|integer|in:1,2',
            // 商品详情描述，可包含图片中心的图片URL 验证
            'goods_data.goods_description' => 'required_with:goods_data',

            // 商品属性数据
            'attributes_data' => 'nullable|array',
            // 商品属性数据名称
            'attributes_data.*.attributes_name' => ['required_with:attributes_data', 'between:1,20'],
            // 商品分类ID
            'attributes_data.*.goods_category_id' => ['required_with:attributes_data', 'integer', 'between:1,20'],
            // 商品属性值数据
            'attributes_data.*.value' => 'required_with:attributes_data|array',
            // 商品属性值数据
            'attributes_data.*.value.*.attr_value_data' => ['required_with:attributes_data', 'between:1,20'],
            // 商品sku
            'sku_data' => 'nullable|array',
            // 商品sku名称
            'sku_data.*.goods_sku_name' => ['required_with:sku_data', 'between:1,20'],
            // 商品sku值
            'sku_data.*.goods_sku_value' => ['required_with:sku_data', 'between:1,20'],
            // 商品sku价格
            'sku_data.*.goods_sku_price' => ['required_with:sku_data', 'numeric', 'between:0,500'],
            // 商品sku图片
            'sku_data.*.goods_sku_image' => ['required_with:sku_data', 'string', 'url'],
            // 商品sku库存
            'sku_data.*.goods_sku_sale' => ['required_with:sku_data', 'integer', 'between:0,99999'],
            // 商品市场价
            'sku_data.*.goods_sku_market_price' => ['required_with:sku_data', 'numeric', 'between:0,99999'],
        ];
    }

    /**
     * 更新数据验证规则
     * return array.
     */
    public function updateRules(): array
    {
        return [
            'goods_data' => 'required|array',
            // 商品名称 验证
            'goods_data.goods_name' => 'required_with:goods_data|between:2,50',
            // 分类排序 验证
            'goods_data.goods_category_id' => ['required', 'integer', Rule::exists('goods_category', 'id')],
            // 产品价格
            'goods_data.goods_price' => 'required|numeric|min:0.01|max:9999999',
            // 市场价
            'goods_data.goods_market_price' => 'required|numeric|min:0.01|max:9999999',
            // 总库存
            'goods_data.goods_sale' => 'required|integer|min:0|max:9999999',
            // 商品图片 验证
            'goods_data.goods_images' => 'required_with:goods_data|array',
            // 商品状态(2下架1上架) 验证
            'goods_data.goods_status' => 'required_with:goods_data|integer|in:1,2',
            // 语言（1中文2英文）
            'goods_data.goods_language' => 'required|integer|in:1,2',
            // 商品详情描述，可包含图片中心的图片URL 验证
            'goods_data.goods_description' => 'required_with:goods_data',

            // 商品属性数据
            'attributes_data' => 'nullable|array',
            // 商品属性数据no
            'attributes_data.*.attributes_no' => ['required_with:attributes_data', 'integer'],
            // 商品分类ID
            'attributes_data.*.goods_category_id' => ['required_with:attributes_data', 'integer', 'between:1,20'],
            // 商品属性数据名称
            'attributes_data.*.attributes_name' => ['required_with:attributes_data', 'between:1,20'],
            // 商品属性值数据
            'attributes_data.*.value' => 'required_with:attributes_data|array',
            // 商品属性值数据
            'attributes_data.*.value.*.attr_value_data' => ['required_with:attributes_data', 'between:1,20'],
            // 商品sku
            'sku_data' => 'nullable|array',
            // 商品skuID
            'sku_data.*.goods_sku_id' => ['required_with:sku_data', 'integer', 'between:1,20'],
            // 商品sku名称
            'sku_data.*.goods_sku_name' => ['required_with:sku_data', 'between:1,20'],
            // 商品sku值
            'sku_data.*.goods_sku_value' => ['required_with:sku_data', 'between:1,20'],
            // 商品sku价格
            'sku_data.*.goods_sku_price' => ['required_with:sku_data', 'numeric', 'between:0,500'],
            // 商品sku图片
            'sku_data.*.goods_sku_image' => ['required_with:sku_data', 'string', 'url'],
            // 商品sku库存
            'sku_data.*.goods_sku_sale' => ['required_with:sku_data', 'integer', 'between:0,99999'],
            // 商品市场价
            'sku_data.*.goods_sku_market_price' => ['required_with:sku_data', 'numeric', 'between:0,99999'],
        ];
    }

    /**
     * 字段映射名称
     * return array.
     */
    public function attributes(): array
    {
        return [
            // 商品名称
            'goods_data.goods_name' => '商品名称',
            // 分类排序 验证
            'goods_data.goods_category_id' => '商品分类',
            // 产品价格
            'goods_data.goods_price' => '商品价格',
            // 市场价
            'goods_data.goods_market_price' => '市场价',
            // 总库存
            'goods_data.goods_sale' => '商品库存',
            // 图片
            'goods_data.goods_images' => '商品图片',
            // 视频
            'goods_data.goods_video' => '商品视频',
            // 商品状态（1上架2下架）
            'goods_data.goods_status' => '商品状态',
            // 语言（1中文2英文）
            'goods_data.goods_language' => '商品语言',
            // 说明
            'goods_data.goods_description' => '商品说明',

            // 商品属性数据
            'attributes_data' => '商品属性',
            // 商品属性数据数组
            'attributes_data.*.attributes_no' => '商品属性ID',
            // 商品属性分类ID
            'attributes_data.*.goods_category_id' => '商品分类ID',
            // 商品属性数据名称
            'attributes_data.*.attributes_name' => '商品属性名称',
            // 商品属性值数据
            'attributes_data.*.value' => '商品属性值',
            // 商品属性值数据编号
            'attributes_data.*.value.*.attr_no' => '商品属性值编号',
            // 商品属性值数据
            'attributes_value_data.*.attr_value_data' => '商品属性值数据',
            // 商品sku
            'sku_data' => '商品规格数据',
            // 商品skuID
            'sku_data.*.goods_sku_id' => '商品规格ID',
            // 商品sku名称
            'sku_data.*.goods_sku_name' => '商品规格名称',
            // 商品sku值
            'sku_data.*.goods_sku_value' => '商品规格值',
            // 商品sku排序
            'sku_data.*.goods_sku_sort' => '商品规格排序',
            // 商品sku价格
            'sku_data.*.goods_sku_price' => '商品规格价格',
            // 商品sku图片
            'sku_data.*.goods_sku_image' => '商品规格图片',
            // 商品sku库存
            'sku_data.*.goods_sku_sale' => '商品规格库存',
            // 商品市场价
            'sku_data.*.goods_sku_market_price' => '商品规格市场价',
        ];
    }
}
