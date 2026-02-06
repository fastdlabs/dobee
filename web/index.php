<?php

declare(strict_types=1);

include __DIR__ . '/../vendor/autoload.php';

use FastD\Application;
use FastD\Server\CgiServer;

$cgi = new CgiServer('fastcgi', new Application(include __DIR__ . '/../src/bootstrap.php'));

$cgi->run();
