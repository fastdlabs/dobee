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

/**
 * Class WelcomeController
 * @package Controller
 */
class WelcomeController
{
    /**
     * @param ServerRequest $request
     * @return $this
     */
    public function welcome(ServerRequest $request)
    {
        return json([
            'msg' => 'welcome fastd'
        ]);
    }
}