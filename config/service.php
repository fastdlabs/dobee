<?php

$providers = [];

// Demo 包是可选依赖：生产环境 --no-dev 安装时自动跳过。
if (class_exists(\FastD\Demo\DemoServiceProvider::class)) {
    $providers[] = \FastD\Demo\DemoServiceProvider::class;
}

return $providers;
