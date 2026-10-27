<?php

// 自定义进程配置：php bin/process
$workers = [];
$listeners = [];

// Demo Worker / 信号监听由可选包提供；未安装时保持空配置。
if (class_exists(\FastD\Demo\Process\DemoWorker::class)) {
    $workers['demo'] = \FastD\Demo\Process\DemoWorker::class;
    $listeners[] = \FastD\Demo\Listener\Process\DemoSignalListener::class;
}

return [
    'worker' => $workers,
    'listener' => $listeners,
];
