<?php

namespace http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Welcome implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $db = container()->get('database')->getDatabase('default');
        $cache = container()->get('cache')->getCache('file');

        return json([
            'foo' => 'bar',
            'connection' => $db,
            'cache' => $cache,
        ]);
    }
}
