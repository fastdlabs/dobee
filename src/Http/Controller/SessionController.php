<?php

declare(strict_types=1);

namespace Http\Controller;

use FastD\Http\Session\SessionMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 会话示例：同一会话内累加访问次数，并演示 flash 与 CSRF token。
 */
final class SessionController implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var \FastD\Http\Session\SessionInterface $session */
        $session = $request->getAttribute(SessionMiddleware::ATTRIBUTE);

        $visits = (int) $session->get('visits', 0) + 1;
        $session->set('visits', $visits);
        $session->flash('notice', 'saved');

        return json([
            'visits' => $visits,
            'session_id' => $session->getId(),
            'token' => $session->getToken(),
        ]);
    }
}
