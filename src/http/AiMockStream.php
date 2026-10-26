<?php

declare(strict_types=1);

namespace http;

use FastD\Http\Response\SseResponse;
use FastD\Http\Sse\EmitterInterface;
use FastD\Http\Sse\Event;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 模拟 AI 流式输出（无需真实模型/密钥）。
 *
 * POST /ai/mock-stream，表单字段 prompt；返回 meta / delta / done 事件，
 * 前端可用 fetch + ReadableStream 逐 token 渲染（见 /demo/ai）。
 */
final class AiMockStream implements MiddlewareInterface
{
    /**
     * 本地模拟的固定回答（逐字符输出）。
     */
    private const REPLY = 'FastD 是一个基于 PSR 标准与 Swoole 扩展的高性能 PHP 框架。'
        . '这段文字来自本地模拟的 AI 流式输出，用于验证 SSE 的逐 token 渲染、心跳、停止与错误展示。';

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $prompt = $this->prompt($request);
        $reply = $prompt === '' ? self::REPLY : self::REPLY . ' 你问的是：' . $prompt;

        /** @var list<string> $tokens */
        $tokens = preg_split('//u', $reply, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        return new SseResponse(function (EmitterInterface $emitter) use ($tokens): void {
            $emitter->send(Event::data([
                'model' => 'fastd-mock-1',
                'tokens' => count($tokens),
            ], 'meta'));

            $index = 0;

            foreach ($tokens as $token) {
                if ($emitter->isClosed()) {
                    return;
                }

                $emitter->send(Event::data([
                    'delta' => $token,
                    'index' => $index++,
                ], 'delta'));

                self::sleep(20);
            }

            $emitter->send(Event::data([
                'message' => 'done',
                'usage' => ['completion_tokens' => count($tokens)],
            ], 'done'));
        }, [
            'heartbeat' => 5,
            'max_duration' => 180,
        ]);
    }

    private function prompt(ServerRequestInterface $request): string
    {
        $parsed = $request->getParsedBody();

        if (is_array($parsed)) {
            $prompt = trim((string) ($parsed['prompt'] ?? ''));
            if ($prompt !== '') {
                return $prompt;
            }
        }

        // Swoole 请求保留原始 body；CGI 场景请使用表单提交（见 Demo 页面实现）
        $raw = (string) $request->getBody();
        if ($raw === '') {
            return '';
        }

        try {
            $json = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return '';
        }

        return is_array($json) ? trim((string) ($json['prompt'] ?? '')) : '';
    }

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
