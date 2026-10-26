<?php

// 数组解析
// [method, path, mixed callback, array middleware, array variables]
return [
    ['GET', '/', \http\Welcome::class,],
    ['GET', '/session', \http\SessionDemo::class,],

    // SSE 演示
    ['GET', '/sse', \http\SseStream::class,],
    ['GET', '/demo/sse', \http\SseDemoPage::class,],
    ['POST', '/ai/mock-stream', \http\AiMockStream::class,],
    ['GET', '/demo/ai', \http\AiChatDemoPage::class,],
];
