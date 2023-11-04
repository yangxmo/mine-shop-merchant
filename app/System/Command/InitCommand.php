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

namespace App\System\Command;

use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Hyperf\DbConnection\Db;
use Symfony\Component\Console\Input\InputArgument;

#[Command]
class InitCommand extends HyperfCommand
{
    /**
     * 执行的命令行.
     */
    protected ?string $name = 'init:system';

    private string $tenant = '';

    public function handle()
    {
        $this->tenant = $this->input->getArgument('tenant');

        // 初始化系统用户
        $this->initUserData();
    }

    protected function initUserData(): void
    {
        // 清理数据
        Db::connection($this->tenant)->table('system_user')->truncate();
        Db::connection($this->tenant)->table('system_role')->truncate();
        Db::connection($this->tenant)->table('system_user_role')->truncate();

        if (\Hyperf\Database\Schema\Schema::hasTable('system_user_dept')) {
            Db::connection($this->tenant)->table('system_user_dept')->truncate();
        }

        // 创建超级管理员
        Db::connection($this->tenant)->table('system_user')->insert([
            'id' => env('SUPER_ADMIN', 1),
            'username' => 'superAdmin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'user_type' => '100',
            'nickname' => '创始人',
            'email' => 'admin@adminmine.com',
            'phone' => '16858888988',
            'signed' => '广阔天地，大有所为',
            'dashboard' => 'statistics',
            'created_by' => 0,
            'updated_by' => 0,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        // 创建管理员角色
        Db::connection($this->tenant)->table('system_role')->insert([
            'id' => env('ADMIN_ROLE', 1),
            'name' => '超级管理员（创始人）',
            'code' => 'superAdmin',
            'data_scope' => 0,
            'sort' => 0,
            'created_by' => env('SUPER_ADMIN', 0),
            'updated_by' => 0,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'remark' => '系统内置角色，不可删除',
        ]);
        Db::connection($this->tenant)->table('system_user_role')->insert([
            'user_id' => env('SUPER_ADMIN', 1),
            'role_id' => env('ADMIN_ROLE', 1),
        ]);
    }

    protected function getArguments(): array
    {
        return [
            ['tenant', InputArgument::REQUIRED, '租户名称'],
        ];
    }
}
