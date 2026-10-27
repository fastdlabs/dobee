<?php

// 服务提供者配置。
//
// 默认保持为空；Demo 安装脚本只生成 config/service-demo.php，
// 不会改写用户自定义的 service.php。
$services = [];

$demoConfig = __DIR__ . '/service-demo.php';
if (is_file($demoConfig)) {
    $services = array_merge($services, require $demoConfig);
}

return array_values(array_filter(
    $services,
    static fn (mixed $service): bool => class_exists($service),
));
