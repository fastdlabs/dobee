<?php

return [
    'worker' => [
        'welcome' => \process\WelcomeWorker::class
    ],
    // swoole 进程管理事件监听
    'listener' => [
        \process\listener\SignalListener::class
    ],
];
