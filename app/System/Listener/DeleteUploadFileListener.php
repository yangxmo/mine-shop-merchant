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
namespace App\System\Listener;

use App\System\Model\SystemUploadfile;
use Exception;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use League\Flysystem\FilesystemException;
use Mine\Event\RealDeleteUploadFile;

/**
 * Class DeleteUploadFileListener.
 */
#[Listener]
class DeleteUploadFileListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            RealDeleteUploadFile::class,
        ];
    }

    /**
     * @throws FilesystemException
     */
    public function process(object $event): void
    {
        $filePath = $this->getFilePath($event->getModel());
        try {
            $event->getFilesystem()->delete($filePath);
        } catch (Exception $e) {
            // 文件删除失败，跳过删除数据
            $event->setConfirm(false);
        }
    }

    /**
     * 获取文件路径.
     */
    public function getFilePath(SystemUploadfile $model): string
    {
        return $model->storage_path . '/' . $model->object_name;
    }
}
