<?php

declare(strict_types=1);

namespace Listener\Server;

use FastD\Swoole\Listener\Server\RequestListener;
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