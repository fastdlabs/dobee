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

class IndexController
{
    public function sayHello(ServerRequest $request)
    {
        return json([
            'msg' => 'hello dobee',
        ]);
    }

    public function dynamic(ServerRequest $request)
    {
        return json([
            'name' => $request->getAttribute('name'),
            'query' => $request->getQueryParams()
        ]);
    }
}