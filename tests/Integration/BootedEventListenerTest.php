<?php

declare(strict_types=1);

namespace tests\Integration;

use FastD\Application;
use FastD\Cache\Listener\BootedEventListener as CacheBootedEventListener;
use FastD\Event\BootedEvent;
use FastD\MedooDB\Listener\BootedEventListener as MedooDbBootedEventListener;
use FastD\Runtime;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * Swoole 启动时 cache/medoodb 的 BootedEvent 监听器必须能初始化连接。
 * 回归：曾使用 Container 不存在的 got()，在真实 Swoole 启动时 fatal。
 */
class BootedEventListenerTest extends TestCase
{
    public function testSwooleBootInitializesCacheAndMedooDb(): void
    {
        $cache = new class {
            public bool $initialized = false;

            public function initConnections(): void
            {
                $this->initialized = true;
            }
        };

        $medooDb = new class {
            public bool $initialized = false;

            public function initConnections(): void
            {
                $this->initialized = true;
            }
        };

        $app = new Application([
            'name' => 'fastd8',
            'root' => dirname(__DIR__),
            'timezone' => 'PRC',
            'runtime' => 'swoole',
        ]);
        $app->add('cache', $cache);
        $app->add('medoodb', $medooDb);

        $runtime = new class('swoole', $app) extends Runtime {
            public function input(): mixed
            {
                return null;
            }

            public function output(mixed $output): void
            {
            }

            public function abort(Throwable $throwable): void
            {
            }
        };

        $event = new BootedEvent($runtime);

        (new CacheBootedEventListener())->process($event);
        (new MedooDbBootedEventListener())->process($event);

        $this->assertTrue($cache->initialized);
        $this->assertTrue($medooDb->initialized);
    }
}
