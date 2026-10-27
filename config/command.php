<?php

// 控制台命令注册：php bin/console <command>
$commands = [];

// Demo 命令由可选包提供；类名由 DemoServiceProvider 注册到容器，
// Console 通过 Application::make() 解析（构造器注入）；未安装时自动跳过。
if (class_exists(\FastD\Demo\Command\DemoCommand::class)) {
    $commands[] = \FastD\Demo\Command\DemoCommand::class;
}

return $commands;
