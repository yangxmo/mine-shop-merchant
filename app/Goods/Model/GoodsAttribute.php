<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Goods\Model;

use Mine\MineModel;

/**
 * @property int $id
 * @property string $goods_no
 * @property integer $goods_category_id
 * @property string $attributes_no
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
    protected array $fillable = ['id', 'goods_no', 'goods_category_id', 'attributes_no', 'attributes_name'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [];

    public function attributeValue(): \Hyperf\Database\Model\Relations\HasMany
    {
        return $this->hasMany(GoodsAttributesValue::class, 'attr_no', 'attributes_no');
    }
}
