<?php

return [
    /*
     * The application name.
     */
    'name' => 'fastd',

    /*
     * The application timezone.
     */
    'timezone' => 'PRC',

    /*
     * Bootstrap default service provider
     */
    'services' => [
        \FastD\Route\RouteService::class,
        \FastD\MedooDB\ServiceProvider\DatabaseServiceProvider::class,
        \FastD\Cache\ServiceProvider\CacheServiceProvider::class,
        \FastD\Cache\ServiceProvider\ServerRequestCacheProvider::class,
    ],
];
