<?php

// Web 路由：[method, path, handler, middleware, variables]
return [
    ['GET', '/', \Http\Controller\WelcomeController::class],
];
