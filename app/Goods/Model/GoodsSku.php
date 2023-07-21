<?php

declare(strict_types=1);

namespace App\Goods\Model;

use Mine\MineModel;

/**
 * @property int $id 
 * @property string $goods_no
 * @property string $goods_attr_no
 * @property int $goods_sku_id
 * @property string $goods_sku_name
 * @property string $goods_plat_sku_name
 * @property string $goods_sku_value
 * @property string $goods_plat_sku_value
 * @property string $goods_sku_image
 * @property string $goods_plat_sku_image
 * @property int $goods_sku_sale
 * @property string $goods_sku_price
 * @property string $goods_sku_market_price
 * @property int $goods_sku_status
 * @property int $goods_sku_sort
 */
class GoodsSku extends MineModel
{
    public bool $timestamps = false;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'goods_sku';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'goods_no', 'goods_attr_no', 'goods_sku_id', 'goods_sku_name', 'goods_plat_sku_name', 'goods_sku_value', 'goods_plat_sku_value', 'goods_sku_image', 'goods_plat_sku_image', 'goods_sku_sale', 'goods_sku_price', 'goods_sku_market_price', 'goods_sku_status', 'goods_sku_sort'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'goods_sku_id' => 'integer', 'goods_sku_sale' => 'integer', 'goods_sku_status' => 'integer', 'goods_sku_sort' => 'integer'];
}
