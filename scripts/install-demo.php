<?php

declare(strict_types=1);

/**
 * Composer install/update 钩子：同步 dobee-demo 的 ServiceProvider 配置。
 *
 * Demo 包存在时调用其 scripts/install.php；不存在时移除残留的 Provider，
 * 保证 `composer install --no-dev` 后不会加载不存在的类。
 */

$project = getcwd() ?: dirname(__DIR__);
$configFile = $project . '/config/service.php';
$installer = $project . '/vendor/fastd/dobee-demo/scripts/install.php';
$provider = 'FastD\\Demo\\DemoServiceProvider';
$providerClass = '\\FastD\\Demo\\DemoServiceProvider::class';

if (is_file($installer)) {
    require $installer;
    exit(0);
}

if (!is_file($configFile)) {
    exit(0);
}

$services = include $configFile;

if (!is_array($services)) {
    exit(0);
}

$filtered = array_values(array_filter(
    $services,
    static fn (mixed $service): bool => $service !== $provider && $service !== $providerClass,
));

if (count($filtered) === count($services)) {
    exit(0);
}

$lines = [
    '<?php',
    '',
    '// 服务提供者配置。',
    '//',
    '// 安装 fastd/dobee-demo 后，Composer 安装脚本会自动把 DemoServiceProvider 写入这里。',
    'return [',
];
foreach ($filtered as $service) {
    $lines[] = '    ' . var_export($service, true) . ',';
}
$lines[] = '];';

file_put_contents($configFile, implode(PHP_EOL, $lines) . PHP_EOL);
