<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use Mine\Abstracts\AbstractMigration;

class CreateUsersBase extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_base', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键');
            // 头像
            $table->string('avatar', 255)->default('')->comment('头像');
            // 昵称
            $table->string('nickname', 25)->default('')->comment('昵称');
            // 真实姓名
            $table->string('truename', 10)->default('')->comment('真实姓名');
            // 手机号
            $table->string('mobile', 11)->default('')->comment('手机号');
            // 座机
            $table->string('phone', 30)->default('')->comment('电话（座机）');
            // 性别
            $table->enum('sex', [1, 2, 3])->default(1)->comment('性别：（1未知2男3女）');
            // 邮箱
            $table->string('email', 50)->default('')->comment('邮箱');
            // 登陆密码
            $table->string('password', 100)->default('')->comment('密码');
            // 支付密码
            $table->string('pay_password', 100)->default('')->comment('支付密码');
            // IPv4地址
            $table->string('ipv4', 35)->default('')->comment('IPv4地址');
            // IPv6地址
            $table->string('ipv6', 35)->default('')->comment('IPv6地址');
            // 用户省份
            $table->smallInteger('province_code')->default(0)->comment('省份编码');
            // 用户市区
            $table->smallInteger('city_code')->default(0)->comment('市区编码');
            // 用户地区
            $table->smallInteger('area_code')->default(0)->comment('地区编码');
            // 用户地址
            $table->string('address', 255)->default('')->comment('地址');
            // 用户生日
            $table->date('birthday')->default('1970-01-01')->comment('生日');
            // 用户状态
            $table->enum('status', [1, 2, 3])->default(1)->comment('状态：（1正常2禁用3删除）');
            // 注册时间
            $table->timestamp('register_time')->comment('注册时间');

            $table->datetimes();

            $table->index('status', 'idx_status');
            $table->index('mobile', 'idx_mobile');
            $table->index(['mobile', 'status'], 'idx_mobile_status');

            $table->comment('【用户】用户基础信息');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_base');
    }
}
