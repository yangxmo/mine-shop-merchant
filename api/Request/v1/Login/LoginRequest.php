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

namespace Api\Request\v1\Login;

use Hyperf\Validation\Rule;
use Mine\MineApiFormRequest;

class LoginRequest extends MineApiFormRequest
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
    public function miniAppRules(): array
    {
        return [
            'code' => 'required|string',
            'iv' => 'required|string',
            'encrypted_data' => 'required|string',
        ];
    }

    /**
     * @return string[]
     */
    public function wapAppRules(): array
    {
        return [
            'mobile' => ['required', 'integer', Rule::exists('users_user', 'mobile')],
            'password' => 'required|string',
        ];
    }

    /**
     * 字段映射名称
     * return array.
     */
    public function attributes(): array
    {
        return [
            'code' => '小程序登陆code',
            'iv' => '小程序登陆iv',
            'encrypted_data' => '小程序登陆加密信息',
            'mobile' => '账号',
            'password' => '密码',
        ];
    }
}
