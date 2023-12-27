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
 * @property int $user_id
 * @property string $name
 * @property string $mobile
 * @property string $province_code
 * @property string $city_code
 * @property string $area_code
 * @property string $address
 * @property int $is_default
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class UserAddress extends MineModel
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'user_address';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['user_id', 'name', 'mobile', 'province_code', 'city_code', 'area_code', 'address', 'is_default', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['user_id' => 'integer', 'is_default' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
