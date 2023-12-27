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
 * @property string $last_login_ip
 * @property string $last_login_time
 * @property int $login_days
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class UserLoginLog extends MineModel
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'user_login_log';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['user_id', 'last_login_ip', 'last_login_time', 'login_days', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['user_id' => 'integer', 'login_days' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
