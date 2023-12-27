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

namespace App\Users\Model;

use Mine\MineModel;

/**
 * @property int $id
 * @property string $avatar
 * @property string $nickname
 * @property string $truename
 * @property string $mobile
 * @property string $phone
 * @property string $sex
 * @property string $email
 * @property string $password
 * @property string $pay_password
 * @property string $ipv4
 * @property string $ipv6
 * @property int $province_code
 * @property int $city_code
 * @property int $area_code
 * @property string $address
 * @property string $birthday
 * @property string $status
 * @property string $register_time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class UsersBase extends MineModel
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'users_base';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'avatar', 'nickname', 'truename', 'mobile', 'phone', 'sex', 'email', 'password', 'pay_password', 'ipv4', 'ipv6', 'province_code', 'city_code', 'area_code', 'address', 'birthday', 'status', 'register_time', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'province_code' => 'integer', 'city_code' => 'integer', 'area_code' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
