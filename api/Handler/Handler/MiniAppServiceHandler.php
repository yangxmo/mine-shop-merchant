<?php

namespace Api\Handler\Handler;

use Api\Handler\Abstract\MiniAppAbstract;
use EasyWeChat\Kernel\Exceptions\DecryptException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use EasyWeChat\Kernel\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class MiniAppServiceHandler extends MiniAppAbstract
{

    /**
     * 获取sessionKey
     * @throws InvalidConfigException
     */
    public static function getSessionKey(string $code): Collection|array|string|ResponseInterface
    {
        return self::returnResult(self::$application->auth->session($code));
    }

    /**
     * 获取用户信息.
     * @throws DecryptException
     */
    public static function getUserInfo(string $sessionKey, string $iv, string $encryptedData): array
    {
        return self::returnResult(self::$application->encryptor->decryptData($sessionKey, $iv, $encryptedData));
    }

    /**
     * 获取用户手机号.
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public static function getPhoneNumber(string $code): Collection|array|string|ResponseInterface
    {
        return self::returnResult(self::$application->phone_number->getUserPhoneNumber($code));
    }
}