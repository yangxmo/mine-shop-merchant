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

use Api\Handler\Factory\MiniAppServiceFactory;
use Api\Handler\Interface\MiniAppInterface;
use Hyperf\JsonRpc\JsonRpcHttpTransporter;
use Hyperf\JsonRpc\JsonRpcPoolTransporter;
use Hyperf\JsonRpc\JsonRpcTransporter;

return [
    MiniAppInterface::class => MiniAppServiceFactory::class,
    JsonRpcHttpTransporter::class => \App\System\Kernel\Rpc\JsonRpcHttpTransporter::class,
    JsonRpcTransporter::class => JsonRpcPoolTransporter::class,
];
