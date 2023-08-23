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

use Hyperf\Codec\Json;
use Hyperf\Database\Model\SoftDeletes;
use Mine\MineModel;

/**
 * @property int $id
 * @property string $name 服务名称
 * @property string $term 服务条款
 * @property int $sort 排序
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 */
class GoodsClause extends MineModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'goods_clause';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'name', 'term', 'sort', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'sort' => 'integer','created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function setTermAttribute($value)
    {
        $this->attributes['term'] = Json::encode($value);
    }

    public function getTermAttribute($value)
    {
        $this->attributes['term'] = Json::decode($value);
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($value): static
    {
        $this->created_at = $value;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setUpdatedAt($value): static
    {
        $this->updated_at = $value;
        return $this;
    }

    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    public function setDeletedAt($deleted_at)
    {
        $this->deleted_at = $deleted_at;
        return $this;
    }
}
