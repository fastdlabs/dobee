<?php

declare(strict_types=1);

namespace tests\Feature;

use FastD\Testing\TestCase;

/**
 * 会话 E2E：两次请求共享同一会话（Cookie 回传），访问计数递增。
 */
class SessionControllerTest extends TestCase
{
    protected function setUp(): void
    {
        if (!class_exists(\FastD\Http\Session\SessionMiddleware::class)) {
            $this->markTestSkipped('fastd/http with session support (>= 8.1) is required.');
        }

        parent::setUp();
    }

    protected function tearDown(): void
    {
        foreach (glob(__DIR__ . '/../runtime/session/*') ?: [] as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }

        parent::tearDown();
    }

    public function testSessionPersistsAcrossRequests(): void
    {
        $first = $this->handleRequest('GET', '/session');
        $this->isSuccessful($first);

        $firstBody = json_decode((string) $first->getBody(), true);
        $this->assertIsArray($firstBody);
        $this->assertSame(1, $firstBody['visits']);
        $this->assertMatchesRegularExpression('/^[a-f0-9]{32}$/', $firstBody['session_id']);

        preg_match('/FASTD_SESSID=([a-f0-9]{32})/', $first->getHeaderLine('Set-Cookie'), $matches);
        $this->assertArrayHasKey(1, $matches, 'The session cookie is missing from the response.');

        $second = $this->handleRequest('GET', '/session', [], ['Cookie' => 'FASTD_SESSID=' . $matches[1]]);
        $this->isSuccessful($second);

        $secondBody = json_decode((string) $second->getBody(), true);
        $this->assertIsArray($secondBody);
        $this->assertSame(2, $secondBody['visits']);
        $this->assertSame($matches[1], $secondBody['session_id']);
    }
}
