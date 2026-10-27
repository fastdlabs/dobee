<?php

// 自定义进程配置：php bin/process
//
// Demo 包安装后，DemoServiceProvider 会在注册时把 Worker / 信号监听写入
// process 配置；Process 使用 new 实例化，宿主不需要在这里列类名。
return [
    'worker' => [],
    'listener' => [],
];
