<?php

return [
    'worker' => [
        'welcome' => \Terminal\Process\WelcomeWorker::class
    ],
    // swoole 进程管理事件监听
    'listener' => [
        \Listener\Process\SignalListener::class
    ],
];
