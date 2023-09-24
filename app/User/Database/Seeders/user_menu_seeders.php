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

use App\System\Model\SystemMenu;
use Hyperf\DbConnection\Db;
use Mine\Abstracts\AbstractSeeder;

class UserMenuSeeders extends AbstractSeeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach ($this->getData() as $item) {
            Db::insert($item);
        }
    }

    public function getData(): array
    {
        $model = env('DB_PREFIX') . SystemMenu::getModel()->getTable();
        return [
            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (0, '0', '用户', 'user', 'IconUser', 'user', '', NULL, '2', 'M', '1', 999, 1, NULL, now(), now(), NULL, NULL)",

            "SET @pid := LAST_INSERT_ID()",
            "SET @plevel := CONCAT('0', ',', @pid)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@pid, @plevel, '用户管理', 'user:data', 'IconUser', 'user/data', 'user/data/index', NULL, '2', 'M', '1', 999, 1, NULL, now(), now(), NULL, NULL)",

            "SET @id := LAST_INSERT_ID()",
            "SET @level := CONCAT('0', ',', @id)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('用户数据表', '列表'), CONCAT('user:data',':index'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('用户数据表', '保存'), CONCAT('user:data',':save'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('用户数据表', '更新'), CONCAT('user:data',':update'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('用户数据表', '读取'), CONCAT('user:data',':read'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('用户数据表', '删除'), CONCAT('user:data',':delete'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('用户数据表', '回收站'), CONCAT('user:data',':recycle'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('用户数据表', '恢复'), CONCAT('user:data',':recovery'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('用户数据表', '真实删除'), CONCAT('user:data',':realDelete'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('用户数据表', '导出'), CONCAT('user:data',':export'), NULL, NULL, NULL, NULL, '2', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",


        ];
    }
}
