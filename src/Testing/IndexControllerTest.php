<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */
namespace Testing;


use FastD\Test\TestCase;


class IndexControllerTest extends TestCase
{
    public function testSayHello()
    {
        $request = $this->request('GET', '/foo');
        $response = $this->app->handleRequest($request);
        $this->response($response, ['name' => 'foo', 'query' => []]);

        $request = $this->request('GET', '/bar');
        $response = $this->app->handleRequest($request);
        $this->response($response, ['name' => 'bar', 'query' => []]);

        $request = $this->request('GET', '/foo?foo=bar');

        $response = $this->app->handleRequest($request);

        $this->response($response, ['name' => 'foo', 'query' => [
            'foo' => 'bar'
        ]]);
    }
}
