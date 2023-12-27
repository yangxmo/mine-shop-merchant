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
 * @property string $open_id
 * @property string $platform_id
 * @property string $unionid
 * @property string $nickname
 * @property string $avatar
 * @property int $gender
 * @property string $birthday
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $phone
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class UserPlatform extends MineModel
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'user_platform';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['user_id', 'open_id', 'platform_id', 'unionid', 'nickname', 'avatar', 'gender', 'birthday', 'city', 'province', 'country', 'phone', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['user_id' => 'integer', 'gender' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];


    public function user()
    {
        return $this->hasOne(UsersBase::class, 'user_id', 'user_id');
    }
}
