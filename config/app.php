<?php

return [
    /*
     * The application name.
     */
    'name' => 'fast-d',

    /*
     * The application timezone.
     */
    'timezone' => 'PRC',

    /*
     * Bootstrap default service provider
     */
    'services' => [
        \FastD\Service\RouteService::class,
    ],

    'logger' => [
        [
            'handle' => \Monolog\Handler\StreamHandler::class,
            'level' => \Monolog\Logger::WARNING,
            'path' => '',
        ]
    ]
];
