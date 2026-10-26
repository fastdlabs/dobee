<?php

declare(strict_types=1);

namespace Http\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * RequestIdMiddleware 演示端点：响应头由中间件补充，Body 回显请求 ID。
 */
final class MiddlewareDemoController implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return json([
            'message' => 'RequestIdMiddleware demo',
            'request_id' => $request->getHeaderLine('X-Request-Id'),
            'method' => $request->getMethod(),
            'path' => $request->getUri()->getPath(),
        ]);
    }
}
