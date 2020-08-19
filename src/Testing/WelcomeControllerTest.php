<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */
namespace Testing;


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
