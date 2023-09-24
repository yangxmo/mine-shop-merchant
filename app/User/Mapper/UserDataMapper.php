<?php
declare(strict_types=1);
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

namespace App\User\Mapper;

use App\User\Model\UserData;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 用户数据表Mapper类
 */
class UserDataMapper extends AbstractMapper
{
    /**
     * @var UserData
     */
    public $model;

    public function assignModel()
    {
        $this->model = UserData::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        
        // 手机号
        if (!empty($params['mobile'])) {
            $query->where('mobile', 'like', '%'.$params['mobile'].'%');
        }

        // 邮箱
        if (!empty($params['email'])) {
            $query->where('email', 'like', '%'.$params['email'].'%');
        }

        // 用户名
        if (!empty($params['username'])) {
            $query->where('username', 'like', '%'.$params['username'].'%');
        }

        // 用户昵称
        if (!empty($params['nickname'])) {
            $query->where('nickname', 'like', '%'.$params['nickname'].'%');
        }

        // 用户性别
        if (!empty($params['sex'])) {
            $query->where('sex', '=', $params['sex']);
        }

        // 用户真实姓名
        if (!empty($params['real_name'])) {
            $query->where('real_name', 'like', '%'.$params['real_name'].'%');
        }

        // 用户连续签到天数
        if (!empty($params['sign_in_days'])) {
            $query->where('sign_in_days', '=', $params['sign_in_days']);
        }

        // 用户会员经验进度
        if (!empty($params['experience'])) {
            $query->where('experience', '=', $params['experience']);
        }

        // 用户状态，含（正常，封禁）两种状态
        if (!empty($params['status'])) {
            $query->where('status', '=', $params['status']);
        }

        // 用户会员等级
        if (!empty($params['level'])) {
            $query->where('level', '=', $params['level']);
        }

        // 用户邀请码
        if (!empty($params['invite_code'])) {
            $query->where('invite_code', 'like', '%'.$params['invite_code'].'%');
        }

        // 用户邀请人
        if (!empty($params['invite_code_by'])) {
            $query->where('invite_code_by', 'like', '%'.$params['invite_code_by'].'%');
        }

        return $query;
    }
}