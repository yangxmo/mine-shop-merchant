<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Mine\Abstracts\AbstractMigration;

class CreateGoods extends AbstractMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            // 商品名称
            $table->string('goods_name', 150)->comment('商品名称');
            // 商品价格
            $table->decimal('goods_price')->default(0.00)->comment('商品建议销售价');
            $table->decimal('goods_market_price')->default(0.00)->comment('参考价格，返回价格区间，可能为空');
            //商品库存（无sku时取这里的库存，有sku时取sku的库存）
            $table->bigInteger('goods_sale')->default(0)->comment('商品库存');
            // 商品图片/视频
            $table->json('goods_images')->nullable()->comment('商品图片');
            $table->string('goods_video', 255)->nullable()->comment('商品视频');
            // 商品类型
            $table->integer('goods_category_id')->default(0)->comment('分组ID');
            $table->tinyInteger('goods_status')->default(1)->comment('商品状态(1上架2下架)');
            $table->tinyInteger('goods_language')->default(1)->comment('商品语言（1中文2英文）');
            $table->text('goods_description')->nullable()->comment('商品详情描述，可包含图片中心的图片URL');
            $table->datetimes();
            $table->dateTime('deleted_at')->nullable();
            $table->index(['goods_no'], 'idx_no');
            $table->index(['goods_category_id'], 'idx_cid_source');

            $table->comment('商品表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods');
    }
}
