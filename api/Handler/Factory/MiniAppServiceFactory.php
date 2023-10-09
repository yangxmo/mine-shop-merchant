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

namespace Api\Handler\Factory;

use Api\Handler\Handler\MiniAppServiceHandler;
use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerInterface;

class MiniAppServiceFactory
{
    public function __invoke(ContainerInterface $container, array $parameters = [])
    {
        $config = $container->get(ConfigInterface::class);
        // 我们假设对应的配置的 key 为 cache.enable
        $config = $config->get('easywechat.mini_app', false);
        return make(MiniAppServiceHandler::class, [$config]);
    }
}
