<?php

// API 路由：[method, path, handler, middleware, variables]
return [
    ['GET', '/', \Http\Controller\WelcomeController::class],
    ['GET', '/session', \Http\Controller\SessionController::class],

    // SSE 演示
    ['GET', '/sse', \Http\Controller\SseStreamController::class],
    ['POST', '/ai/mock-stream', \Http\Controller\AiMockStreamController::class],
];
