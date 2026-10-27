<?php

// 服务提供者配置。
//
// 在 $services 中追加自定义 ServiceProvider；demo 只维护 marker 区块。
$services = [
    // 自定义 ServiceProvider 示例：
    // \App\ServiceProvider\DemoServiceProvider::class,
];

// demo:service:start
// demo:service:end

return array_values(array_filter(
    $services,
    static fn (mixed $service): bool => class_exists($service),
));
