<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */
namespace Testing;


use FastD\TestCase;


class WelcomeControllerTest extends TestCase
{
    public function testSayHello()
    {
        $request = $this->request('GET', '/');
        $response = $this->app->handleRequest($request);
        $this->equalsJson($response, (['msg' => 'welcome fastd']));
        $this->isSuccessful($response);
    }
}
