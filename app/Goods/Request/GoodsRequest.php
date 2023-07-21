<?php
declare(strict_types=1);
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

namespace App\Goods\Request;

use Hyperf\Validation\Rule;
use Mine\MineFormRequest;

/**
 * 商品分类验证数据类
 */
class GoodsRequest extends MineFormRequest
{
    /**
     * 公共规则
     */
    public function commonRules(): array
    {
        return [];
    }


    /**
     * 新增数据验证规则
     * return array
     */
    public function saveRules(): array
    {
        return [
            //商品编号 验证
            'goods_no' => 'nullable',
            //商品名称
            'goods_name' => 'required|string|between:2,50',
            //分类排序 验证
            'goods_category_id' => ['required','integer',Rule::exists('goods_category', 'id')],
            //产品价格
            'goods_price' => 'required|numeric|min:0.01|max:9999999',
            //市场价
            'goods_market_price' => 'required|numeric|min:0.01|max:9999999',
            //总库存
            'goods_sale' => 'required|integer|min:0|max:9999999',
            //图片
            'goods_images' => 'required|array',
            //视频
            'goods_video' => 'nullable|string',
            //商品状态（1上架2下架）
            'goods_status' => 'required|integer|in:1,2',
            //语言（1中文2英文）
            'goods_language' => 'required|integer|in:1,2',
            //说明
            'goods_description' => 'required',
        ];
    }

    /**
     * 更新数据验证规则
     * return array
     */
    public function updateCategoryRules(): array
    {
        return [
            //商品名称
            'goods_name' => 'required|string|between:2,50',
            //分类排序 验证
            'goods_category_id' => ['required','integer',Rule::exists('product_category', 'id')],
            //产品价格
            'goods_price' => 'required|numeric|min:0.01|max:9999999',
            //市场价
            'goods_market_price' => 'required|numeric|min:0.01|max:9999999',
            //总库存
            'goods_sale' => 'required|integer|min:0|max:9999999',
            //图片
            'goods_images' => 'required|array',
            //视频
            'goods_video' => 'nullable|string',
            //商品状态（1上架2下架）
            'goods_status' => 'required|integer|in:1,2',
            //语言（1中文2英文）
            'goods_language' => 'required|integer|in:1,2',
            //说明
            'goods_description' => 'required',
        ];
    }


    /**
     * 字段映射名称
     * return array
     */
    public function attributes(): array
    {
        return [
            'goods_no' => '商品编号',
            'goods_id' => '商品ID',
            'goods_category_id' => '商品分组',
        ];
    }

}