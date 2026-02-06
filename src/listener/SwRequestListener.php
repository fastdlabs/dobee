<?php

declare(strict_types=1);

namespace listener;

use FastD\Event\BootedEvent;
use FastD\Swoole\Event\Server\RequestEvent;
use FastD\Swoole\Listener\Server\RequestListener;
use FastD\Swoole\Listener\SwooleEventListener;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SwRequestListener extends RequestListener
{
    public function onRequest(ServerRequestInterface $serverRequest): ResponseInterface
    {
        debug('swoole request', [
            'runtime' => container()->getRuntime(),
        ]);
        return container()->dispatch($serverRequest);
    }
}