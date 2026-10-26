<?php

declare(strict_types=1);

namespace Http\Controller;

use FastD\Http\Response\SseResponse;
use FastD\Http\Sse\EmitterInterface;
use FastD\Http\Sse\Event;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * SSE 演示端点：按秒推送 tick 事件，支持 Last-Event-ID 续传。
 *
 * 浏览器：/demo/sse.html 页面；终端：curl -N 'http://127.0.0.1:8099/sse?limit=5'。
 */
final class SseStreamController implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $query = $request->getQueryParams();

        $limit = max(1, min(100, (int) ($query['limit'] ?? 30)));
        $interval = max(0, min(10000, (int) ($query['interval'] ?? 1000)));

        $lastEventId = (string) ($query['last_id'] ?? $request->getHeaderLine('Last-Event-ID'));
        $start = max(0, (int) $lastEventId);

        return new SseResponse(function (EmitterInterface $emitter) use ($start, $limit, $interval): void {
            $emitter->comment('connected');

            $emitter->send(Event::data([
                'message' => 'SSE stream started',
                'resume_from' => $start,
            ], 'notice'));

            for ($seq = $start + 1; $seq <= $start + $limit; $seq++) {
                if ($emitter->isClosed()) {
                    return;
                }

                $emitter->send(Event::data([
                    'seq' => $seq,
                    'time' => date('H:i:s'),
                    'memory' => round(memory_get_usage(true) / 1048576, 2) . ' MB',
                ], 'tick', (string) $seq));

                self::sleep($interval);
            }

            $emitter->send(Event::data([
                'message' => 'stream finished',
                'last_event_id' => (string) ($start + $limit),
            ], 'done'));
        }, [
            'heartbeat' => 5,
            'retry' => 3000,
            'max_duration' => 180,
        ]);
    }

    /**
     * Swoole 协程下让出 CPU；CGI 下直接 sleep。
     */
    private static function sleep(int $milliseconds): void
    {
        if ($milliseconds <= 0) {
            return;
        }

        if (class_exists(\Swoole\Coroutine::class) && \Swoole\Coroutine::getCid() > 0) {
            \Swoole\Coroutine::sleep($milliseconds / 1000);

            return;
        }

        usleep($milliseconds * 1000);
    }
}
