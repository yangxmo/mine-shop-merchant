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

use Hyperf\Database\Model\Relations\hasOne;
use Mine\MineModel;

class UsersBalanceLog extends MineModel
{
    public bool $timestamps = false;

    public static array $selectField = ['id', 'user_id', 'amount', 'type', 'status', 'before_balance', 'after_balance', 'remark', 'created_at'];

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'users_balance_log';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'user_id', 'amount', 'type', 'status', 'before_balance', 'after_balance', 'remark', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [];

    /**
     * 定义 userInfo 关联.
     */
    public function userInfo(): hasOne
    {
        return $this->hasOne(UsersBase::class, 'id', 'user_id')->select(['id', 'nickname']);
    }
}
