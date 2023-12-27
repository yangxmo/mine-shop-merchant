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

use App\System\JsonRpc\LoginContract;
use App\System\JsonRpc\SystemContract;

$registry = [
    'protocol' => 'nacos',
    'address' => 'http://' . \Hyperf\Support\env('NACOS_HOST') . ':' . \Hyperf\Support\env('NACOS_PORT'),
];
$options = [
    'connect_timeout' => 5.0,
    'recv_timeout' => 5.0,
    'settings' => [
        // 根据协议不同，区分配置
        'open_eof_split' => true,
        'package_eof' => "\r\n",
        // 'open_length_check' => true,
        // 'package_length_type' => 'N',
        // 'package_length_offset' => 0,
        // 'package_body_offset' => 4,
    ],
    // 重试次数，默认值为 2，收包超时不进行重试。暂只支持 JsonRpcPoolTransporter
    'retry_count' => 2,
    // 重试间隔，毫秒
    'retry_interval' => 100,
    // 使用多路复用 RPC 时的心跳间隔，null 为不触发心跳
    'heartbeat' => 30,
    // 当使用 JsonRpcPoolTransporter 时会用到以下配置
    'pool' => [
        'min_connections' => 2,
        'max_connections' => 32,
        'connect_timeout' => 15.0,
        'wait_timeout' => 3.0,
        'heartbeat' => -1,
        'max_idle_time' => 60.0,
    ],
];

$config = [
    'enable' => [
        'discovery' => true,
        'register' => true,
    ],
    'consumers' => \Hyperf\Support\value(function () use ($registry, $options) {
        $consumers = [];
        // 这里示例自动创建代理消费者类的配置形式，顾存在 name 和 service 两个配置项，这里的做法不是唯一的，仅说明可以通过 PHP 代码来生成配置
        // 下面的 FooServiceInterface 和 BarServiceInterface 仅示例多服务，并不是在文档示例中真实存在的
        $services = [
            'user.merchant' => SystemContract::class,
            'login.merchant' => LoginContract::class,
        ];
        foreach ($services as $name => $interface) {
            $consumers[] = [
                'id' => $interface,
                'name' => $name,
                'service' => $interface,
                'registry' => $registry,
                'protocol' => 'jsonrpc-http',
                'load_balancer' => 'random',
                'options' => $options,
            ];
        }
        return $consumers;
    }),
    'providers' => [],
    'drivers' => [
        'nacos' => [
            'host' => \Hyperf\Support\env('NACOS_HOST', '127.0.0.1'),
            'port' => (int) \Hyperf\Support\env('NACOS_PORT', 8848),
            'username' => \Hyperf\Support\env('NACOS_USERNAME'),
            'password' => \Hyperf\Support\env('NACOS_PASSWORD'),
            'group_name' => \Hyperf\Support\env('NACOS_GROUP', 'DEFAULT_GROUP'),
            'namespace_id' => \Hyperf\Support\env('NACOS_NAMESPACE_ID', 'public'),
            'heartbeat' => 5,
        ],
    ],
];

return $config;
