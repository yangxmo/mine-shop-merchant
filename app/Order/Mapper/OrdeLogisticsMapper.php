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
namespace App\Order\Mapper;

use App\OrderModule\Public\Model\OrderLogistic;
use Mine\Abstracts\AbstractMapper;

class OrdeLogisticsMapper extends AbstractMapper
{
    /**
     * @var OrderLogistic
     */
    public $model;

    public function assignModel(): void
    {
        $this->model = OrderLogistic::class;
    }
}
