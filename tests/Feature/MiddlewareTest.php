<?php

declare(strict_types=1);

namespace tests\Feature;

use FastD\Testing\TestCase;

class MiddlewareTest extends TestCase
{
    public function testResponseCarriesRequestIdAndTimingHeaders(): void
    {
        $response = $this->handleRequest('GET', '/middleware-demo');

        $this->isSuccessful($response);
        $this->assertNotSame('', $response->getHeaderLine('X-Request-Id'));
        $this->assertMatchesRegularExpression(
            '/^\d+\.\d{2}ms$/',
            $response->getHeaderLine('X-Response-Time')
        );

        $body = json_decode((string) $response->getBody(), true);
        $this->assertSame('RequestIdMiddleware demo', $body['message']);
        $this->assertSame($response->getHeaderLine('X-Request-Id'), $body['request_id']);
    }

    public function testIncomingRequestIdIsPreserved(): void
    {
        $response = $this->handleRequest('GET', '/middleware-demo', [], ['X-Request-Id' => 'demo-request-123']);

        $this->isSuccessful($response);
        $this->assertSame('demo-request-123', $response->getHeaderLine('X-Request-Id'));

        $body = json_decode((string) $response->getBody(), true);
        $this->assertSame('demo-request-123', $body['request_id']);
    }
}
