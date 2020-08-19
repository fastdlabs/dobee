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
use FastD\Middleware\DelegateInterface;
use FastD\Routing\Handle\RouteHandleInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class WelcomeController
 * @package Controller
 */
class WelcomeController implements RouteHandleInterface
{
    public function handle(ServerRequest $request, DelegateInterface $delegate): ResponseInterface
    {
        return json([
            'msg' => 'welcome fastd'
        ]);
    }
}
