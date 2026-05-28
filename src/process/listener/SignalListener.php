<?php

declare(strict_types=1);

namespace process\listener;

use FastD\Swoole\Listener\Process\SignalEventListener;

class SignalListener extends SignalEventListener
{
    protected function onUserSignal(object $event): void
    {
        echo "接收到用户自定义信号: " . ($event->event ?? 'unknown') . "\n";
        if (isset($event->args['pid'])) {
            echo "PID: " . $event->args['pid'] . "\n";
        }
        if (isset($event->args['code'])) {
            echo "Code: " . $event->args['code'] . "\n";
        }
        if (isset($event->args['signal'])) {
            echo "Signal: " . $event->args['signal'] . "\n";
        }
    }
}