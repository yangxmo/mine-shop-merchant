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

namespace App\Goods\Mapper;

use App\Goods\Model\Goods;
use Mine\Abstracts\AbstractMapper;

/**
 * 商品Mapper类
 */
class GoodsMapper extends AbstractMapper
{
    /**
     * @var Goods
     */
    public $model;

    public function assignModel(): void
    {
        $this->model = Goods::class;
    }

}