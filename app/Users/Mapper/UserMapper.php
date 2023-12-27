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

namespace App\Users\Mapper;

use App\Users\Model\UsersBase;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Annotation\CacheEvict;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;
use Mine\MineModel;

/**
 * 用户数据表Mapper类.
 */
class UserMapper extends AbstractMapper
{
    /**
     * @var UsersBase
     */
    public $model;

    public function assignModel()
    {
        $this->model = UsersBase::class;
    }

    /**
     * 根据手机号获取信息.
     * @return null|MineModel|mixed
     */
    #[Cacheable(prefix: 'UserInfo', value: '#{mobile}', ttl: 1200)]
    public function getInfoByMobile(string $mobile)
    {
        return $this->first(['mobile' => $mobile]);
    }

    /**
     * 更新用户信息.
     */
    #[CacheEvict(prefix: 'UserInfo', value: '#{mobile}')]
    public function upInfoByMobile(string $mobile, array $params): bool
    {
        $info = $this->first(['mobile' => $mobile]);

        return $info && $info->update($params);
    }

    /**
     * 检查是否重复.
     */
    public function checkUserMobile(string $mobile, int $id): bool
    {
        return $this->model::where('mobile', $mobile)->where('id', '<>', $id)->exists();
    }

    /**
     * 检查是否重复.
     */
    public function checkUserEmail(string $email, int $id): bool
    {
        return $this->model::where('email', $email)->where('id', '<>', $id)->exists();
    }

    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        // 手机号
        if (! empty($params['mobile'])) {
            $query->where('mobile', 'like', '%' . $params['mobile'] . '%');
        }

        // 邮箱
        if (! empty($params['email'])) {
            $query->where('email', 'like', '%' . $params['email'] . '%');
        }

        // 用户昵称
        if (! empty($params['nickname'])) {
            $query->where('nickname', 'like', '%' . $params['nickname'] . '%');
        }

        // 用户性别
        if (! empty($params['sex'])) {
            $query->where('sex', '=', $params['sex']);
        }

        // 用户真实姓名
        if (! empty($params['truename'])) {
            $query->where('truename', 'like', '%' . $params['truename'] . '%');
        }

        // 用户状态，含（正常，封禁）两种状态
        if (! empty($params['status'])) {
            $query->where('status', '=', $params['status']);
        }

        return $query;
    }
}
