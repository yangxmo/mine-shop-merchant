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

class GoodsMenuSeeders extends AbstractSeeder
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
            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (0, '0', '商品', 'goods', 'icon-home', 'goods', 'goods/index', NULL, '2', 'M', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            'SET @id := LAST_INSERT_ID()',
            "SET @level := CONCAT('0', ',', @id)",
            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '列表'), CONCAT('goods',':index'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '保存'), CONCAT('goods',':save'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '更新'), CONCAT('goods',':update'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '读取'), CONCAT('goods',':read'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '删除'), CONCAT('goods',':delete'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '回收站'), CONCAT('goods',':recycle'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '恢复'), CONCAT('goods',':recovery'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '真实删除'), CONCAT('goods',':realDelete'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '导入'), CONCAT('goods',':import'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",

            "INSERT INTO `{$model}`(`parent_id`, `level`, `name`, `code`, `icon`, `route`, `component`, `redirect`, `is_hidden`, `type`, `status`, `sort`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `remark`) VALUES (@id, @level, CONCAT('商品', '导出'), CONCAT('goods',':export'), NULL, NULL, NULL, NULL, '1', 'B', '1', 0, 1, NULL, now(), now(), NULL, NULL)",
        ];
    }
}
