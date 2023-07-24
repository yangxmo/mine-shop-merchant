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
namespace App\Goods\Listener;

use App\Goods\Cache\GoodsStockCache;
use App\Goods\Event\GoodsEvent;
use App\Goods\Model\Goods;
use Hyperf\Database\Model\Events\Created;
use Hyperf\Database\Model\Events\Deleted;
use Hyperf\Database\Model\Events\Updated;
use Hyperf\Event\Annotation\Listener;
use Hyperf\ModelListener\AbstractListener;

#[Listener]
class GoodsListener extends AbstractListener
{
    public function listen(): array
    {
        return [
            GoodsEvent::class,
        ];
    }

    public function process(object $event): void
    {
        /** @var Created|Deleted|Updated $modelEvent */
        $modelEvent = $event->modelEvent;
        /** @var Goods $goods */
        $goods = $modelEvent->getModel();

        /** @var GoodsStockCache $stockCache */
        $stockCache = make(GoodsStockCache::class);

        if ($modelEvent instanceof Deleted) {
            if (! $goods->sku()->count()) {
                $stockCache->delStockCache($goods->id, null);
            }
        } else {
            if (! $goods->sku()->count()) {
                $stockCache->setStockCache($goods->id, null, $goods->goods_sale);
            }
        }
    }
}
