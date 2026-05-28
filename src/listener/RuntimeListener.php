<?php

declare(strict_types=1);

namespace listener;

use FastD\Event\BootedEvent;
use FastD\Event\EventListener;
use FastD\Event\FinishEvent;

class RuntimeListener extends EventListener
{
    public function process(object $event): void
    {
        // 此处会写入日志，不管是什么环境服务下，可以分别测试 cgf，server，console，process，Runtime 上可以查看日志记录
        info('demo 监听', [
            'runtime' => container()->getRuntime(),
            'event' => get_class($event),
        ]);
    }

    public function listen(): iterable
    {
        return [
            BootedEvent::class,
            FinishEvent::class,
        ];
    }
}