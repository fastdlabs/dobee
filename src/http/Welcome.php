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
        $db = app()->get('database')->getDatabase('default');
        $cache = app()->get('cache')->getCache('file');

        return json([
            'foo' => 'bar',
            'connection' => $db,
            'cache' => $cache,
        ]);
    }
}
