<?php

declare(strict_types=1);

namespace Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 为每个请求生成/透传 X-Request-Id，并记录处理耗时。
 */
final class RequestIdMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $requestId = trim($request->getHeaderLine('X-Request-Id'));
        if ($requestId === '') {
            $requestId = bin2hex(random_bytes(8));
        }

        $startedAt = hrtime(true);
        $response = $handler->handle($request->withHeader('X-Request-Id', $requestId));
        $duration = (hrtime(true) - $startedAt) / 1_000_000;

        return $response
            ->withHeader('X-Request-Id', $requestId)
            ->withHeader('X-Response-Time', sprintf('%.2fms', $duration));
    }
}
