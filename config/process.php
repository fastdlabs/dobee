<?php

// 自定义进程配置：php bin/process
//
// Demo 包安装后，Worker / 信号监听由 DemoServiceProvider 注册到
// ProcessRegistry，宿主不需要在这里列类名。
return [
    'worker' => [],
    'listener' => [],
];
