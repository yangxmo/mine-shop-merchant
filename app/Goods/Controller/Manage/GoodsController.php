<?php
declare(strict_types=1);
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

namespace App\Goods\Controller\Manage;

use App\Goods\Request\GoodsRequest;
use App\Goods\Resource\GoodsResource;
use App\goods\Service\goodsService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Mine\Annotation\Auth;
use Mine\Annotation\OperationLog;
use Mine\Annotation\Permission;
use Mine\Annotation\RemoteState;
use Mine\MineController;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * 商品分类控制器
 * Class GoodsController
 */
#[Controller(prefix: "goods/manage"), Auth]
class GoodsController extends MineController
{
    /**
     * 业务处理服务
     * goodsCategoryService
     */
    #[Inject]
    protected GoodsService $service;

    
    /**
     * 获取列表
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping("index"), Permission("goods:manage, goods:manage:index")]
    public function index(): ResponseInterface
    {
        $result = $this->service->getPageList($this->request->all());

        return $this->success(GoodsResource::make($result)->toArray());
    }

    /**
     * 新增
     * @param GoodsRequest $request
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping("save"), Permission("goods:manage:save"), OperationLog]
    public function save(GoodsRequest $request): ResponseInterface
    {
        return $this->success(['id' => $this->service->save($request->validated())]);
    }

    /**
     * 读取数据
     * @param int $id
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping("read/{id}"), Permission("goods:manage:read")]
    public function read(int $id): ResponseInterface
    {
        return $this->success($this->service->read($id));
    }

    /**
     * 更新
     * @param int $id
     * @param GoodsRequest $request
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PutMapping("update/{id}"), Permission("goods:manage:update"), OperationLog]
    public function update(int $id, GoodsRequest $request): ResponseInterface
    {
        return $this->service->update($id, $request->all()) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量删除数据到回收站
     * @param int $id
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[DeleteMapping("delete/{id}"), Permission("goods:manage:delete"), OperationLog]
    public function delete(int $id): ResponseInterface
    {
        return $this->service->delete([$id]) ? $this->success() : $this->error();
    }

    /**
     * 回收站列表
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping("recycle"), Permission("goods:manage:recycle")]
    public function recycle(): ResponseInterface
    {
        return $this->success($this->service->getPageListByRecycle($this->request->all()));
    }

    /**
     * 单个或批量真实删除数据 （清空回收站）
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[DeleteMapping("realDelete"), Permission("goods:manage:realDelete"), OperationLog]
    public function realDelete(): ResponseInterface
    {
        return $this->service->realDelete((array) $this->request->input('ids', [])) ? $this->success() : $this->error();
    }

    /**
     * 单个或批量恢复在回收站的数据
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PutMapping("recovery"), Permission("goods:manage:recovery"), OperationLog]
    public function recovery(): ResponseInterface
    {
        return $this->service->recovery((array) $this->request->input('ids', [])) ? $this->success() : $this->error();
    }

    /**
     * 更改数据状态
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PutMapping("changeStatus"), Permission("goods:manage:update"), OperationLog]
    public function changeStatus(): ResponseInterface
    {
        return $this->service->changeStatus(
            (int) $this->request->input('id'),
            (string) $this->request->input('statusValue'),
            (string) $this->request->input('statusName', 'status')
        ) ? $this->success() : $this->error();
    }

    /**
     * 数据导入
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    #[PostMapping("import"), Permission("goods:manage:import")]
    public function import(): ResponseInterface
    {
        return $this->service->import(\App\Goods\Dto\GoodsDto::class) ? $this->success() : $this->error();
    }

    /**
     * 下载导入模板
     * @return ResponseInterface
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping("downloadTemplate")]
    public function downloadTemplate(): ResponseInterface
    {
        return (new \Mine\MineCollection)->export(\App\Goods\Dto\GoodsDto::class, '模板下载', []);
    }

    /**
     * 数据导出
     * @return ResponseInterface
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping("export"), Permission("goods:manage:export"), OperationLog]
    public function export(): ResponseInterface
    {
        return $this->service->export($this->request->all(), \App\Goods\Dto\GoodsDto::class, '导出数据列表');
    }


    /**
     * 远程万能通用列表接口
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[PostMapping("remote"), RemoteState(true)]
    public function remote(): ResponseInterface
    {
        return $this->success($this->service->getRemoteList($this->request->all()));
    }
}