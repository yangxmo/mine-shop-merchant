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

namespace App\System\JsonRpc;

interface SystemContract
{
    public function getInfoById(int $uid);

    /**
     * 获取列表.
     */
    public function getPageList(?array $params = null, bool $isScope = true): array;

    /**
     * 新增用户.
     */
    public function save(array $data);

    /**
     * 更新用户信息.
     */
    public function update(int $id, array $data);

    /**
     * 删除用户.
     */
    public function delete(array $ids);

    /**
     * 真实删除用户.
     */
    public function realDelete(array $ids);

    /**
     * 初始化用户密码
     */
    public function initUserPassword(int $id, string $password = '123456');

    /**
     * 用户更新个人资料.
     */
    public function updateInfo(array $params);

    /**
     * 用户修改密码
     */
    public function modifyPassword(array $params);

    /**
     * 通过 id 列表获取用户基础信息.
     */
    public function getUserInfoByIds(array $ids);
}
