<?php
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Mine\Abstracts\AbstractMigration;

class CreateUserOpenPlatFormTable extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_open_plat_form', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('用户第三方表');
            $table->bigIncrements('id')->comment('主键');

            # 给user_id添加外键
            $table->unsignedBigInteger('user_id')->comment('用户ID');
            $table->foreign('user_id')->references('id')->on('user_data')->onDelete('cascade');
            $table->string('open_id', 100)->comment('openID');
            $table->string('union_id', 100)->comment('unionID');
            $table->tinyInteger('open_type', false, true)->default(1)->comment('类型(1微信2百度3抖音)');
            $table->string('avatar', 200)->nullable()->comment('头像');
            $table->string('nickname', 50)->default('')->comment('昵称');
            $table->tinyInteger('gender', false, true)->default(1)->comment('性别(0女1男)');
            $table->string('phone', 20)->comment('手机号');
            $table->string('email', 100)->comment('邮箱');

            $table->addColumn('bigInteger', 'created_by', ['comment' => '创建者'])->nullable();
            $table->addColumn('bigInteger', 'updated_by', ['comment' => '更新者'])->nullable();
            $table->addColumn('timestamp', 'created_at', ['precision' => 0, 'comment' => '创建时间'])->nullable();
            $table->addColumn('timestamp', 'updated_at', ['precision' => 0, 'comment' => '更新时间'])->nullable();
            $table->addColumn('timestamp', 'deleted_at', ['precision' => 0, 'comment' => '删除时间'])->nullable();
            $table->addColumn('string', 'remark', ['length' => 255, 'comment' => '备注'])->nullable();

            $table->index(['user_id', 'open_id'], 'idx_user_open_id');
            $table->index(['user_id','open_type'], 'idx_user_open_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_open_plat_form');
    }
}
