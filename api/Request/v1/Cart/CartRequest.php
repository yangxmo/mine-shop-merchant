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

namespace Api\Request\v1\Cart;

use Hyperf\Validation\Rule;
use Mine\MineApiFormRequest;

class CartRequest extends MineApiFormRequest
{
    /**
     * 公共规则.
     */
    public function commonRules(): array
    {
        return [];
    }

    /**
     * 获取列表.
     */
    public function listRules(): array
    {
        return [
            'page' => 'required|integer|min:1|max:50',
            'pageSize' => 'nullable|integer|min:1|max:50',
        ];
    }

    /**
     * 新增.
     */
    public function saveCartRules(): array
    {
        return [
            'pid' => ['required', Rule::exists('goods', 'id'), 'integer'],
            'sku_id' => ['nullable', 'integer', Rule::exists('goods_sku', 'id')],
            'num' => 'nullable|integer|min:1|max:9999',
        ];
    }

    /**
     * 减少.
     */
    public function reduceCartRules(): array
    {
        return [
            'pid' => ['required', Rule::exists('goods', 'id'), 'integer'],
            'sku_id' => ['nullable', 'integer', Rule::exists('goods_sku', 'id')],
            'num' => 'nullable|integer|min:1|max:9999',
        ];
    }

    /*
     * 验证消息.
     */
    public function attributes(): array
    {
        return [
            'mobile' => '手机号',
            'email' => '邮箱',
            'nickname' => '昵称',
            'password' => '密码',
            'avatar' => '头像',
            'sex' => '性别',
            'real_name' => '真实名称',
        ];
    }
}
