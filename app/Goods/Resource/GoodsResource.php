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
namespace App\Goods\Resource;

use Hyperf\Resource\Json\JsonResource;

/**
 * This file is part of Hyperf.
 *
 * @see     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
class GoodsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(): array
    {
        $data = $this->resource;

        if (empty($data['items'])) {
            return $this->resource;
        }

        $newData = [];

        foreach ($data['items'] as $datum) {
            $newData[] = [
                'id' => $datum['id'] ?? '',
                'goods_name' => $datum['goods_name'] ?? '',
                'goods_images' => $datum['goods_images'] ?? [],
                'goods_status' => $datum['goods_status'] ?? 2,
                'goods_sale' => $datum['goods_sale'] ?? 0,
                'goods_language' => $datum['goods_language'],
                'goods_price' => $datum['goods_price'],
                'goods_market_price' => $datum['goods_market_price'],
                'goods_category_name' => $datum->category->title ?? '-',
                'created_at' => $datum['created_at']->toDateTimeString(),
            ];
        }

        $data['items'] = $newData;

        return $data;
    }
}
