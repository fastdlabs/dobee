<?php

declare(strict_types=1);

namespace http;

use FastD\Http\Response\Text;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Welcome implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $env = config()->parsed->get('app.env', 'production');
        return text("Hello FastD [{$env}]");
    }
}
