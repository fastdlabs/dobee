<?php

declare(strict_types=1);

namespace tests\Feature;

use FastD\Testing\TestCase;

class WelcomeControllerTest extends TestCase
{
    public function testSayHello(): void
    {
        $response = $this->handleRequest('GET', '/');

        $this->isSuccessful($response);
        $this->equalsResponse($response, 'Hello FastD and goodbye FastD [testcase]');
    }
}
