<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Mine\Abstracts\AbstractMigration;

class CreateGoodsAttributes extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods_attributes', function (Blueprint $table) {
            $table->integerIncrements('id')->autoIncrement();
            $table->string('goods_no')->comment('商品编号');
            $table->string('attr_no')->comment('商品属性编号');
            $table->string('attributes_name')->comment('商品属性名');

            $table->comment('商品属性表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_attributes');
    }
}
