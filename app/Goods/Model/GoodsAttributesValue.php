<?php

declare(strict_types=1);

namespace App\Goods\Model;

use Mine\MineModel;

/**
 * @property int $id
 * @property string $goods_no
 * @property int $attr_no
 * @property string $attr_value
 * @property int $attr_value_no
 */
class GoodsAttributesValue extends MineModel
{
    public bool $timestamps = false;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'goods_attributes_value';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'goods_no', 'attr_no', 'attr_value', 'attr_value_no'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['attr_no' => 'integer', 'attr_value_no' => 'integer'];

}
