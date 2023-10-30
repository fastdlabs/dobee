<?php
declare(strict_types=1);
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2020
 *
 * @see      https://www.github.com/fastdlabs
 * @see      http://www.fastdlabs.com/
 */

include __DIR__ . '/../vendor/autoload.php';

use FastD\Server\FastCGI;

$cgi = new FastCGI(__DIR__ . '/..');

$cgi->run();
