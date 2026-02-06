<?php

declare(strict_types=1);

namespace tests;

use FastD\Testing\TestCase;

class WelcomeControllerTest extends TestCase
{
    public function testSayHello()
    {
        $response = $this->handleRequest('GET', '/');
        $this->equalsJson($response, (['msg' => 'welcome fastd']));
        $this->isSuccessful($response);
    }
}
