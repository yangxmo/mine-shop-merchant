<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Mine\Abstracts\AbstractMigration;

class CreateGoodsAttributesValue extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods_attributes_value', function (Blueprint $table) {
            $table->integerIncrements('id')->autoIncrement();
            $table->string('goods_no', 32)->comment('商品编号');
            $table->bigInteger('attr_no')->comment('商品属性编号');
            $table->bigInteger('attr_value_no')->comment('商品属性值编号');
            $table->string('attr_value', 100)->comment('商品属性值');
            $table->comment('产品属性值');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_attributes_value');
    }
}
