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
namespace Api\Listener;

use Api\Event\LoginAfterEvent;
use App\Users\Domain\LoginServiceDomain;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * 登陆后续.
 */
#[Listener]
class LoginAfterListener implements ListenerInterface
{
    /**
     * 监听事件.
     * @return string[]
     */
    public function listen(): array
    {
        return [
            LoginAfterEvent::class,
        ];
    }

    /**
     * 事件处理.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function process(object $event): void
    {
        $userId = $event->getUserId();
    }
}
