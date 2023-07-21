<?php

declare(strict_types=1);

namespace App\Goods\Model;

use Hyperf\Codec\Json;
use Hyperf\Database\Model\Relations\HasMany;
use Hyperf\Database\Model\SoftDeletes;
use Hyperf\Snowflake\Concern\Snowflake;
use Mine\MineModel;

/**
 * @property int $id
 * @property int $goods_plat_no
 * @property string $goods_name
 * @property string $goods_plat_name
 * @property string $goods_price
 * @property string $goods_market_price
 * @property int $goods_sale
 * @property string $goods_images
 * @property string $goods_plat_images
 * @property string $goods_video
 * @property string $goods_plat_video
 * @property string $goods_type
 * @property int $goods_category_id
 * @property int $goods_source
 * @property int $goods_status
 * @property int $goods_language
 * @property string $goods_sell_start_time
 * @property string $goods_description
 * @property string $goods_plat_description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 */
class Goods extends MineModel
{
    use SoftDeletes;
    use Snowflake;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'goods';

    protected array $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function setGoodsImagesAttribute($value)
    {
        $this->attributes['goods_images'] = Json::encode(($value));
    }

    public function getGoodsImagesAttribute($value)
    {
        $this->attributes['goods_images'] = Json::decode(($value));
    }

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'goods_plat_no', 'goods_name', 'goods_plat_name', 'goods_price', 'goods_market_price', 'goods_sale', 'goods_images', 'goods_plat_images', 'goods_video', 'goods_plat_video', 'goods_category_id', 'goods_source', 'goods_status', 'goods_language', 'goods_sell_start_time', 'goods_description', 'goods_plat_description', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'goods_plat_no' => 'integer', 'goods_sale' => 'integer', 'goods_category_id' => 'string', 'goods_source' => 'integer', 'goods_status' => 'integer', 'goods_language' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function attribute(): HasMany
    {
        return $this->hasMany(GoodsAttribute::class, 'id', 'goods_no');
    }

    public function sku(): HasMany
    {
        return $this->hasMany(GoodsSku::class, 'id', 'goods_no');
    }
}
