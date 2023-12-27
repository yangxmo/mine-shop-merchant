<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Mine\Abstracts\AbstractMigration;

class CreateUsersAddress extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_address', function (Blueprint $table) {
            // 创建索引
            $table->unsignedBigInteger('user_id')->comment('用户ID');
            // 创建外键
            $table->foreign('user_id')->references('id')->on('users_base')->onDelete('cascade');
            // 收货人
            $table->string('name', 25)->default('')->comment('收货人');
            // 收货人手机号
            $table->string('mobile', 11)->default('')->comment('收货人手机号');
            // 省份编码
            $table->string('province_code', 25)->default(0)->comment('省份');
            // 市区编码
            $table->string('city_code', 25)->default(0)->comment('市区');
            // 地区编码
            $table->string('area_code', 25)->default(0)->comment('地区');
            // 详细地址
            $table->string('address', 255)->default('')->comment('详细地址');
            // 是否默认地址
            $table->tinyInteger('is_default')->default(0)->comment('是否默认地址');

            $table->comment('【用户】地址库');
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_address');
    }
}
