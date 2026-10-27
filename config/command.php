<?php

// 控制台命令注册：php bin/console <command>
$commands = [];

// Demo 命令由可选包提供；未安装 fastd/dobee-demo 时自动跳过。
if (class_exists(\FastD\Demo\Command\DemoCommand::class)) {
    $commands[] = \FastD\Demo\Command\DemoCommand::class;
}

return $commands;
