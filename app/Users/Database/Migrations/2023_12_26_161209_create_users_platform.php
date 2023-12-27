<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Mine\Abstracts\AbstractMigration;

class CreateUsersPlatform extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_platform', function (Blueprint $table) {
            // 创建索引
            $table->unsignedBigInteger('user_id')->comment('用户ID');
            // 创建外键
            $table->foreign('user_id')->references('id')->on('users_base')->onDelete('cascade');
            // 用户唯一ID
            $table->string('open_id')->comment('用户唯一openID');
            // 用户来源平台
            $table->string('platform_id')->default(1)->comment('用户来源平台(1:微信 2:QQ 3:微博 4:支付宝 5:钉钉 6:抖音 7:快手 8:企业微信)');
            // 用户uninid
            $table->string('unionid')->default('')->comment('用户unionid（微信下存在）');
            // 用户昵称
            $table->string('nickname', 25)->default('')->comment('用户昵称');
            // 用户头像
            $table->string('avatar', 255)->default('')->comment('用户头像');
            // 用户性别
            $table->tinyInteger('gender')->default(0)->comment('用户性别(0:未知 1:男 2:女)');
            // 用户生日
            $table->date('birthday')->default('1970-01-01')->comment('用户生日');
            // 用户所在城市
            $table->string('city', 25)->default('')->comment('用户所在城市');
            // 用户所在省份
            $table->string('province', 25)->default('')->comment('用户所在省份');
            // 用户所在国家
            $table->string('country', 25)->default('')->comment('用户所在国家');
            // 用户手机号
            $table->string('phone', 25)->default('')->comment('用户手机号');

            $table->comment('【用户】开放平台信息');

            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_platform');
    }
}
