<?php

declare(strict_types=1);

namespace process;

use FastD\Swoole\Process\Worker;

class WelcomeWorker extends Worker
{
    public function process(Worker $worker): void
    {
        echo "FastD Health Check\n";
        echo "\n";
        
        // ===== 缓存状态 =====
        $cacheStatus = 'Cache: ';
        try {
            $cachePool = container()->get('cache');
            $fileCache = $cachePool->getCache('file');
            
            // 测试缓存写入和读取
            $testKey = 'health_check_' . time();
            $cacheItem = $fileCache->getItem($testKey);
            $cacheItem->set('OK');
            $cacheItem->expiresAfter(60);
            $fileCache->save($cacheItem);
            
            // 读取验证
            $readItem = $fileCache->getItem($testKey);
            if ($readItem->isHit() && $readItem->get() === 'OK') {
                $cacheStatus .= '✓ Connected';
            } else {
                $cacheStatus .= '✗ Read failed';
            }
        } catch (\Exception $e) {
            $cacheStatus .= '✗ Error: ' . $e->getMessage();
        }
        echo $cacheStatus . "\n";
        
        // ===== 数据库状态 =====
        $dbStatus = 'Database: ';
        try {
            $dbPool = container()->get('medoodb');
            $db = $dbPool->getDatabase('default');
            
            // 测试数据库连接
            $pdo = $db->pdo;
            if ($pdo && $pdo->getAttribute(\PDO::ATTR_CONNECTION_STATUS)) {
                $dbStatus .= '✓ Connected';
            } else {
                $dbStatus .= '✗ Connection failed';
            }
        } catch (\Exception $e) {
            $dbStatus .= '✗ Error: ' . $e->getMessage();
        }
        echo $dbStatus . "\n";
    }
}
