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
namespace App\Goods\Cache;

use Hyperf\Config\Annotation\Value;
use Mine\Abstracts\AbstractRedis;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use RedisException;

class GoodsStockCache extends AbstractRedis
{
    #[value('redis.goods.prefix')]
    protected ?string $prefix;

    protected string $typeName = 'stock';

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RedisException
     */
    public function setStockCache(int $goodsNo, ?int $skuId, int $sale): void
    {
        $key = $this->getKey($skuId ? $goodsNo . '_' . $skuId : $goodsNo);
        $this->redis('goods')->incrBy($key, $sale);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RedisException
     */
    public function getStockCache(int $goodsNo, ?int $skuId): int
    {
        $key = $this->getKey($skuId ? $goodsNo . '_' . $skuId : $goodsNo);
        return (int) $this->redis('goods')->get($key);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RedisException
     */
    public function delStockCache(int $goodsNo, ?int $skuId): void
    {
        $key = $this->getKey($skuId ? $goodsNo . '_' . $skuId : $goodsNo);
        $this->redis('goods')->del($key);
    }
}
