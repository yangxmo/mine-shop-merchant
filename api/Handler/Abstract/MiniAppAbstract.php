<?php

namespace Api\Handler\Abstract;

use Api\Handler\Interface\MiniAppInterface;
use EasyWeChat\MiniProgram\Application;
use Mine\Exception\NormalStatusException;

abstract class MiniAppAbstract implements MiniAppInterface
{
    public static Application $application;

    public function __construct(array $params)
    {
        // 实例化应用
        /** @var Application $application */
        $application = make(Application::class, [$params]);

        self::$application = $application;
    }

    /**
     * 构建返回数据.
     * @param mixed $result
     * @return mixed
     */
    public static function returnResult(mixed $result): mixed
    {
        if (is_array($result) && !empty($result['errmsg'])) {

            throw new NormalStatusException($result['errmsg']);
        }

        return $result;
    }
}