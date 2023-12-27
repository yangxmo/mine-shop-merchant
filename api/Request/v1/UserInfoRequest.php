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
namespace Api\Request\v1;

use Hyperf\Validation\Request\FormRequest;

class UserInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 验证规则.
     */
    public function rules(): array
    {
        return [
            'id' => 'required|numeric',
        ];
    }

    /*
     * 验证消息.
     */
    // public function messages(): array
    // {
    //     return [
    //         'id.required' => 'id参数缺失',
    //         'id.numeric' => 'id必须是数字',
    //     ];
    // }
}
