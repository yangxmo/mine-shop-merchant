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
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;
use Mine\Abstracts\AbstractMigration;

class CreateSystemUserDeptTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_user_dept', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('用户与部门关联表');
            $table->addColumn('bigInteger', 'user_id', ['unsigned' => true, 'comment' => '用户主键']);
            $table->addColumn('bigInteger', 'dept_id', ['unsigned' => true, 'comment' => '部门主键']);
            $table->primary(['user_id', 'dept_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_user_dept');
    }
}
