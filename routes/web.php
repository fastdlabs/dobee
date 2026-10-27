<?php

// Web 路由：[method, path, handler, middleware, variables]
$routes = [
    ['GET', '/', \Http\Controller\WelcomeController::class],
];

// Demo 包是可选依赖：未安装（--no-dev）时不注册任何 demo 路由。
if (class_exists(\FastD\Demo\Routes::class)) {
    $routes = array_merge($routes, \FastD\Demo\Routes::all());
}

return $routes;
