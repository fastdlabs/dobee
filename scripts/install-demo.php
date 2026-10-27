<?php

declare(strict_types=1);

/**
 * Composer install/update 钩子：同步 dobee-demo 的配置。
 *
 * Demo 包存在时调用其 scripts/install.php（写入 service + swoole 配置）；
 * 不存在时移除残留 Provider 和 Demo Swoole 监听端口。
 */

$project = getcwd() ?: dirname(__DIR__);
$installer = $project . '/vendor/fastd/dobee-demo/scripts/install.php';

if (is_file($installer)) {
    require $installer;
    exit(0);
}

$provider = 'FastD\\Demo\\DemoServiceProvider';
$providerClass = '\\FastD\\Demo\\DemoServiceProvider::class';

$serviceFile = $project . '/config/service.php';
if (is_file($serviceFile)) {
    $services = include $serviceFile;

    if (is_array($services)) {
        $filtered = array_values(array_filter(
            $services,
            static fn (mixed $service): bool => $service !== $provider && $service !== $providerClass,
        ));

        if (count($filtered) !== count($services)) {
            $lines = [
                '<?php',
                '',
                '// 服务提供者配置。',
                '//',
                '// 默认保持为空；安装 fastd/dobee-demo 后，Composer 安装脚本会自动把',
                '// DemoServiceProvider 写入这里。',
                'return [',
            ];
            foreach ($filtered as $service) {
                $lines[] = '    ' . var_export($service, true) . ',';
            }
            $lines[] = '];';

            file_put_contents($serviceFile, implode(PHP_EOL, $lines) . PHP_EOL);
        }
    }
}

$swooleFile = $project . '/config/swoole.php';
if (is_file($swooleFile)) {
    $content = (string) file_get_contents($swooleFile);
    $pattern = '/(\/\/ demo:swoole:start\n)(.*?)(\/\/ demo:swoole:end)/s';

    if (preg_match($pattern, $content) === 1) {
        $updated = preg_replace($pattern, '$1$3', $content, 1);
        if (is_string($updated) && $updated !== $content) {
            file_put_contents($swooleFile, $updated);
            fwrite(STDOUT, "removed demo listeners from config/swoole.php\n");
        }
    }
}
