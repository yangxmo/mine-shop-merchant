<?php
declare (strict_types=1);

namespace App\User\Model;

use Mine\MineModel;

class UserData extends MineModel
{
    /**
     * The table associated with the model.
     *
     * @var string|null
     */
    protected ?string $table = 'user_data';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected array $fillable = [
        'id', 'mobile', 'email', 'password', 'nickname', 'avatar', 'sex', 'real_name', 'ip', 'last_ip', 'sign_in_days', 'experience', 'status', 'level', 'invite_code', 'invite_code_by', 'created_at', 'updated_at', 'deleted_at', 'remark'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected array $casts = [];


}