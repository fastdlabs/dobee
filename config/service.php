<?php

 return [
     // 会话放在最前：push 到 matcher 后先于缓存等中间件执行
     \FastD\ServiceProvider\SessionServiceProvider::class,
     \FastD\MedooDB\ServiceProvider\DatabaseServiceProvider::class,
     \FastD\Cache\ServiceProvider\CacheServiceProvider::class,
     \FastD\Cache\ServiceProvider\ServerRequestCacheProvider::class,
     \ServiceProvider\InjectionDemoServiceProvider::class,
 ];
