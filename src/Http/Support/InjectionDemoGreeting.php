<?php

declare(strict_types=1);

namespace Http\Support;

/**
 * Demo service：用于验证 Controller/Middleware 的构造器注入。
 */
final class InjectionDemoGreeting
{
    public function __construct(private string $prefix = 'Hello')
    {
    }

    public function message(): string
    {
        return $this->prefix . ' from constructor injection';
    }
}
