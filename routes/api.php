<?php

// API 路由：[method, path, handler, middleware, variables]
return [
    ['GET', '/', \Http\Controller\WelcomeController::class],
    ['GET', '/session', \Http\Controller\SessionController::class],

    // Middleware 演示（路由级 RequestIdMiddleware）
    ['GET', '/middleware-demo', \Http\Controller\MiddlewareDemoController::class, [\Http\Middleware\RequestIdMiddleware::class]],

    // SSE 演示
    ['GET', '/sse', \Http\Controller\SseStreamController::class],
    ['POST', '/ai/mock-stream', \Http\Controller\AiMockStreamController::class],
];
