<?php

declare(strict_types=1);

namespace App\Goods\Model;

use Mine\MineModel;

/**
 * @property int $id
 * @property string $product_no
 * @property string $attr_no
 * @property string $attributes_name
 */
class GoodsAttribute extends MineModel
{
    public bool $timestamps = false;
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'goods_attributes';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [ 'id' ,'goods_no', 'attr_no', 'attributes_name'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [];
}
