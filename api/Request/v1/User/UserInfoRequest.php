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

namespace Api\Request\v1\User;

use Mine\MineApiFormRequest;

class UserInfoRequest extends MineApiFormRequest
{
    /**
     * 公共规则.
     */
    public function commonRules(): array
    {
        return [];
    }

    /**
     * 修改用户信息.
     */
    public function upInfoRules(): array
    {
        return [
            'mobile' => 'required|integer',
            'email' => 'nullable|string',
            'nickname' => 'nullable|string|min:1|max:8',
            'password' => 'nullable|string|min:1|max:8',
            'avatar' => 'nullable|string',
            'sex' => 'nullable|integer|in:0,1',
            'real_name' => 'nullable|string',
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
