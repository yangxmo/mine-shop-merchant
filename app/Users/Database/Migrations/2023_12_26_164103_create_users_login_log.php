<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Mine\Abstracts\AbstractMigration;

class CreateUsersLoginLog extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_login_log', function (Blueprint $table) {
            // 创建索引
            $table->unsignedBigInteger('user_id')->comment('用户ID');
            // 创建外键
            $table->foreign('user_id')->references('id')->on('users_base')->onDelete('cascade');
            // 最后登录IP
            $table->string('last_login_ip', 15)->comment('最后登录IP');
            // 最后登录时间
            $table->timestamp('last_login_time')->comment('最后登录时间');
            // 用户连续登陆天数
            $table->tinyInteger('login_days')->default(0)->comment('用户连续登陆天数');

            $table->comment('【用户】登录日志');

            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_login_log');
    }
}
