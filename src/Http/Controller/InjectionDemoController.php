<?php

declare(strict_types=1);

namespace Http\Controller;

use Http\Support\InjectionDemoGreeting;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 构造器注入 Demo：依赖由 FastD Container::make() + routing resolver 提供。
 */
final class InjectionDemoController implements MiddlewareInterface
{
    public function __construct(private InjectionDemoGreeting $greeting)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return json([
            'message' => $this->greeting->message(),
            'controller' => self::class,
            'dependency' => InjectionDemoGreeting::class,
        ]);
    }
}
