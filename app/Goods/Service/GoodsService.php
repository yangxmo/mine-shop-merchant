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

namespace App\Goods\Service;


use App\Goods\Mapper\GoodsMapper;
use Mine\Abstracts\AbstractService;

/**
 * 商品分类服务类
 */
class GoodsService extends AbstractService
{
    /**
     * @var GoodsMapper
     */
    public $mapper;

    public function __construct(GoodsMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    // 商品保存
    public function save(array $data): int
    {
        $data['goods_no'] = snowflake_id();
        $data['goods_images'] = array_column($data['goods_images'], 'url');

        return $this->mapper->save($data);
    }
}