<?php

declare(strict_types=1);

namespace tests;

use FastD\Application;
use FastD\Http\Request\ServerRequest;
use FastD\Http\Response\SseResponse;
use FastD\Http\Sse\EmitterInterface;
use FastD\Http\Sse\Event;
use PHPUnit\Framework\TestCase;

/**
 * SSE 路由与交互页测试（不启动 HTTP 服务，直接分发并执行生产者）。
 */
class SseControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $application = new Application(include __DIR__ . '/../src/bootstrap.php');
        $application->bootstrap('testcase');
    }

    public function testSseEndpointStreamsNoticeTicksAndDone(): void
    {
        $response = container()->dispatch(
            (new ServerRequest('GET', '/sse'))
                ->withQueryParams(['limit' => '2', 'interval' => '0'])
        );

        $this->assertInstanceOf(SseResponse::class, $response);

        $emitter = $this->collectingEmitter();
        ($response->getProducer())($emitter);

        $frames = $emitter->frames;

        $this->assertGreaterThanOrEqual(4, count($frames));
        $this->assertStringContainsString("event: notice\n", $frames[1]);
        $this->assertStringContainsString('"seq":1', $frames[2]);
        $this->assertStringContainsString("id: 1\n", $frames[2]);
        $this->assertStringContainsString('"seq":2', $frames[3]);
        $this->assertStringContainsString("event: done\n", $frames[4]);
    }

    public function testSseEndpointResumesFromLastEventId(): void
    {
        $response = container()->dispatch(
            (new ServerRequest('GET', '/sse', ['Last-Event-ID' => '7']))
                ->withQueryParams(['limit' => '1', 'interval' => '0'])
        );

        $emitter = $this->collectingEmitter();
        ($response->getProducer())($emitter);

        $this->assertStringContainsString('"seq":8', $emitter->frames[2]);
        $this->assertStringContainsString("id: 8\n", $emitter->frames[2]);
    }

    public function testAiMockStreamEmitsMetaDeltasAndDone(): void
    {
        $response = container()->dispatch(
            (new ServerRequest('POST', '/ai/mock-stream'))
                ->withParsedBody(['prompt' => 'ping'])
        );

        $this->assertInstanceOf(SseResponse::class, $response);

        $emitter = $this->collectingEmitter();
        ($response->getProducer())($emitter);

        $frames = $emitter->frames;
        $this->assertStringContainsString("event: meta\n", $frames[0]);
        $this->assertStringContainsString('"model":"fastd-mock-1"', $frames[0]);
        $this->assertStringContainsString("event: delta\n", $frames[1]);
        $this->assertStringContainsString("event: done\n", $frames[count($frames) - 1]);
    }

    public function testInteractivePagesAreServed(): void
    {
        $ssePage = container()->dispatch(new ServerRequest('GET', '/demo/sse'));
        $this->assertSame(200, $ssePage->getStatusCode());
        $this->assertStringContainsString('new EventSource', (string) $ssePage->getBody());

        $aiPage = container()->dispatch(new ServerRequest('GET', '/demo/ai'));
        $this->assertSame(200, $aiPage->getStatusCode());
        $this->assertStringContainsString("/ai/mock-stream", (string) $aiPage->getBody());
    }

    private function collectingEmitter(): EmitterInterface
    {
        return new class implements EmitterInterface {
            /** @var list<string> */
            public array $frames = [];

            public function send(Event|string|array $event): void
            {
                $this->frames[] = ($event instanceof Event ? $event : Event::data($event))->format();
            }

            public function comment(string $text): void
            {
                $this->frames[] = ': ' . $text . "\n\n";
            }

            public function retry(int $milliseconds): void
            {
                $this->frames[] = 'retry: ' . $milliseconds . "\n\n";
            }

            public function isClosed(): bool
            {
                return false;
            }

            public function close(): void
            {
            }
        };
    }
}
