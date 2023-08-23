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
use Mine\MineModel;

/**
 * @property mixed $term 
 */
class GoodsClause extends MineModel
{
    public bool $timestamps = false;

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
    protected array $casts = ['id' => 'integer', 'sort' => 'integer'];

    public function setTermAttribute($value)
    {
        $this->attributes['term'] = Json::encode($value);
    }

    public function getTermAttribute($value)
    {
        return Json::decode($value);
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
