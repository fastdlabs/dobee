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