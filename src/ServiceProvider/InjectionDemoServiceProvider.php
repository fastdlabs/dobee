<?php

declare(strict_types=1);

namespace ServiceProvider;

use FastD\Container\Container;
use FastD\Container\ServiceProviderInterface;
use Http\Support\InjectionDemoGreeting;

/**
 * 把 Demo 服务绑定到容器，供路由 resolver 构造 Controller/Middleware。
 */
final class InjectionDemoServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        $container->add(InjectionDemoGreeting::class, new InjectionDemoGreeting('Hello FastD'));
    }
}
