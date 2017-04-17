<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Controller;


use FastD\Http\ServerRequest;

class WelcomeController
{
    public function welcome(ServerRequest $request)
    {
        return json([
            'msg' => 'hello dobee',
        ]);
    }

    public function sayHello(ServerRequest $request)
    {
        return json([
            'msg' => 'hello ' . $request->getAttribute('name', 'dobee'),
        ]);
    }
}