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

namespace App\System\Service;

use App\System\Cache\UserCache;
use App\System\JsonRpc\SystemContract;
use App\System\Mapper\SystemUserMapper;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Cache\Annotation\CacheEvict;
use Hyperf\Contract\ContainerInterface;
use Hyperf\Di\Annotation\Inject;
use Mine\Abstracts\AbstractService;
use Mine\Annotation\DependProxy;
use Mine\Cache\MineCache;
use Mine\Exception\MineException;
use Mine\Exception\NormalStatusException;
use Mine\Interfaces\ServiceInterface\UserServiceInterface;
use Mine\MineRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\InvalidArgumentException;
use RedisException;

/**
 * 用户业务
 * Class SystemUserService.
 */
#[DependProxy(values: [UserServiceInterface::class])]
class SystemUserService extends AbstractService implements UserServiceInterface
{
    /**
     * @var SystemUserMapper
     */
    public $mapper;

    #[Inject]
    protected MineRequest $request;

    protected ContainerInterface $container;

    #[Inject]
    protected SystemContract $systemContract;
    #[Inject]
    protected SystemMenuService $systemMenuService;
    #[Inject]
    protected SystemRoleService $systemRoleService;

    #[Inject]
    protected UserCache $userCache;

    #[Inject]
    protected MineCache $mineCache;

    /**
     * SystemUserService constructor.
     */
    public function __construct(ContainerInterface $container, SystemUserMapper $mapper)
    {
        $this->mapper = $mapper;
        $this->container = $container;
    }

    /**
     * 获取用户信息.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getInfo(): array
    {
        if ($uid = user()->getId()) {
            return $this->getCacheInfo($uid);
        }
        throw new MineException(t('system.unable_get_userinfo'), 500);
    }

    /**
     * 新增用户.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function save(array $data): int
    {
        if ($this->mapper->existsByUsername($data['username'])) {
            throw new NormalStatusException(t('system.username_exists'));
        }
        return $this->systemContract->save($data);
    }

    /**
     * 更新用户信息.
     */
    public function update(int $id, array $data): bool
    {
        if (isset($data['username'])) {
            unset($data['username']);
        }
        if (isset($data['password'])) {
            unset($data['password']);
        }
        return $this->systemContract->update($id, $data);
    }

    /**
     * 获取在线用户.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getOnlineUserPageList(array $params = []): array
    {
        $userIds = [];
        $iterator = null;
        $key = $this->userCache->getScanOnlineUserKey();
        while (false !== ($users = $this->userCache->scanOnlineUser($iterator, 100))) {
            foreach ($users as $user) {
                if (preg_match("/{$key}(\\d+)$/", $user, $match) && isset($match[1])) {
                    $userIds[] = $match[1];
                }
            }
            unset($users);
        }

        if (empty($userIds)) {
            return [];
        }

        return $this->getPageList(array_merge(['userIds' => $userIds], $params));
    }

    /**
     * 删除用户.
     */
    public function delete(array $ids): bool
    {
        return $this->systemContract->delete($ids);
    }

    /**
     * 真实删除用户.
     */
    public function realDelete(array $ids): bool
    {
        return $this->systemContract->realDelete($ids);
    }

    /**
     * 强制下线用户.
     * @throws InvalidArgumentException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface|RedisException
     */
    public function kickUser(string $id): bool
    {
        user()->getJwt()->logout($this->userCache->getUserTokenCache((int) $id), 'default');
        $this->userCache->delUserTokenCache((int) $id);
        return true;
    }

    /**
     * 初始化用户密码
     */
    public function initUserPassword(int $id, string $password = '123456'): bool
    {
        return $this->systemContract->initUserPassword($id, $password);
    }

    /**
     * 清除用户缓存.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface|RedisException
     */
    public function clearCache(int $userId = 0): bool
    {
        $iterator = null;
        while (false !== ($configKey = $this->mineCache->scan($iterator, 'config:*'))) {
            $this->mineCache->delScanKey($configKey);
        }
        while (false !== ($dictKey = $this->mineCache->scan($iterator, 'Dict:*'))) {
            $this->mineCache->delScanKey($dictKey);
        }
        $this->mineCache->delCrontabCache();
        $this->mineCache->delModuleCache();

        $userId && $this->userCache->delUserCache($userId);

        return true;
    }

    /**
     * 设置用户首页.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface|RedisException
     */
    #[CacheEvict(prefix: 'user', value: 'userInfo_#{params.id}', group: 'user')]
    public function setHomePage(array $params): bool
    {
        $res = ($this->mapper->getModel())::query()
            ->where('id', $params['id'])
            ->update(['dashboard' => $params['dashboard']]) > 0;

        $this->clearCache();
        return $res;
    }

    /**
     * 用户更新个人资料.
     */
    public function updateInfo(array $params): bool
    {
        if (! isset($params['id'])) {
            return false;
        }

        return $this->systemContract->updateInfo($params);
    }

    /**
     * 用户修改密码
     */
    public function modifyPassword(array $params): bool
    {
        return $this->systemContract->initUserPassword(user()->getId(), $params['newPassword']);
    }

    /**
     * 通过 id 列表获取用户基础信息.
     */
    public function getUserInfoByIds(array $ids): array
    {
        return $this->systemContract->getUserInfoByIds($ids);
    }

    /**
     * 获取缓存用户信息.
     */
    #[Cacheable(prefix: 'user', value: 'userInfo_#{id}', ttl: 0, group: 'user')]
    protected function getCacheInfo(int $id): array
    {
        $user = $this->mapper->getModel()->find($id);
        $user->addHidden('deleted_at', 'password');
        $data['user'] = $user->toArray();

        if (user()->isSuperAdmin()) {
            $data['roles'] = ['superAdmin'];
            $data['routers'] = $this->systemMenuService->mapper->getSuperAdminRouters();
            $data['codes'] = ['*'];
        } else {
            $roles = $this->systemRoleService->mapper->getMenuIdsByRoleIds($user->roles()->pluck('id')->toArray());
            $ids = $this->filterMenuIds($roles);
            $data['roles'] = $user->roles()->pluck('code')->toArray();
            $data['routers'] = $this->systemMenuService->mapper->getRoutersByIds($ids);
            $data['codes'] = $this->systemMenuService->mapper->getMenuCode($ids);
        }

        return $data;
    }

    /**
     * 过滤通过角色查询出来的菜单id列表，并去重.
     */
    protected function filterMenuIds(array &$roleData): array
    {
        $ids = [];
        foreach ($roleData as $val) {
            foreach ($val['menus'] as $menu) {
                $ids[] = $menu['id'];
            }
        }
        unset($roleData);
        return array_unique($ids);
    }
}
