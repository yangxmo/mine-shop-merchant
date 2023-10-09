<?php

namespace Api\Handler\Interface;

use EasyWeChat\Kernel\Support\Collection;
use Psr\Http\Message\ResponseInterface;

interface MiniAppInterface
{
    public static function getSessionKey(string $code): Collection|array|string|ResponseInterface;
    public static function getUserInfo(string $sessionKey, string $iv, string $encryptedData): array;
}