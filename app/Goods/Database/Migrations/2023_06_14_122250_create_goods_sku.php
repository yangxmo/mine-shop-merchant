<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Mine\Abstracts\AbstractMigration;

class CreateGoodsSku extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods_sku', function (Blueprint $table) {
            $table->integerIncrements('id')->autoIncrement();
            $table->string('goods_no')->comment('商品唯一标识');
            $table->string('goods_attr_no')->comment('商品属性唯一标识');
            $table->string('goods_sku_id', 50)->default('')->comment('商品sku唯一标识');
            // 商品名称
            $table->string('goods_sku_name', 150)->default('')->comment('商品sku名称');
            $table->string('goods_sku_value', 150)->default('')->comment('sku属性ID所对应的显示名，比如颜色，尺码');
            $table->string('goods_sku_image', 255)->default('')->comment('商品sku图片');
            // 价格
            $table->bigInteger('goods_sku_sale')->default(0)->comment('商品sku库存');
            $table->decimal('goods_sku_price')->default(0.00)->comment('商品sku销售价格');
            // 建议价格
            $table->decimal('goods_sku_market_price')->default(0.00)->comment('商品sku 市场价');
            $table->tinyInteger('goods_sku_status')->default(1)->comment('sku状态(1上架2下架3删除)');
            $table->integer('goods_sku_sort')->default(1)->comment('sku排序');

            $table->index(['goods_no', 'goods_sku_id'], 'idx_goods_no_id');

            $table->comment('商品sku表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_sku');
    }
}
