<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @see      https://www.github.com/janhuang
 * @see      http://www.fast-d.cn/
 */

namespace Controller;


use FastD\Http\ServerRequest;

class UserController
{
    public function get(ServerRequest $request)
    {
        return json([__FUNCTION__, $request->getQueryParams()]);
    }

    public function post(ServerRequest $request)
    {
        return json([__FUNCTION__, $request->getQueryParams()]);
    }

    public function put(ServerRequest $request)
    {
        return json([__FUNCTION__, $request->getQueryParams()]);
    }

    public function delete(ServerRequest $request)
    {
        return json([__FUNCTION__, $request->getAttributes(), $request->getQueryParams()]);
    }
}