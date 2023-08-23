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
namespace App\Goods\Controller\Manage;

use App\Goods\Request\GoodsClauseRequest;
use App\goods\Service\GoodsClauseService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Mine\Annotation\OperationLog;
use Mine\Annotation\Permission;
use Mine\MineController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * 商品服务控制器
 * Class GoodsController.
 */
#[Controller(prefix: 'goods/clause')]
class ClauseController extends MineController
{
    /**
     * 业务处理服务
     * GoodsClauseService.
     */
    #[Inject]
    protected GoodsClauseService $service;

    /**
     * 获取列表.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('index'), Permission('goods:clause, goods:clause:index')]
    public function index(): ResponseInterface
    {
        $result = $this->service->getList($this->request->all());

        return $this->success($result);
    }

    /**
     * 新增.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping('save'), Permission('goods:clause:save')]
    public function save(GoodsClauseRequest $request): ResponseInterface
    {
        return $this->success(['id' => $this->service->save($request->validated())]);
    }

    /**
     * 读取数据.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('read/{id}'), Permission('goods:clause:read')]
    public function read(int $id): ResponseInterface
    {
        return $this->success($this->service->read($id));
    }

    /**
     * 更新.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PutMapping('update/{id}'), Permission('goods:clause:update'), OperationLog]
    public function update(int $id, GoodsClauseRequest $request): ResponseInterface
    {
        return $this->service->update($id, $request->validated()) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量删除数据到回收站.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[DeleteMapping('delete/{id}'), Permission('goods:clause:delete'), OperationLog]
    public function delete(int $id): ResponseInterface
    {
        return $this->service->delete(['id' => $id]) ? $this->success() : $this->error();
    }
}
