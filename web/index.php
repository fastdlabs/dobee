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

use FastD\Application;
use FastD\Runtime\FPM\FastCGI;

$cgi = new FastCGI(new Application(__DIR__ . '/..'));

$cgi->run();
