<?php

declare(strict_types=1);

namespace http;

use FastD\Http\Response\Text;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Welcome implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
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
        
        return text("FastD Health Check\n" . $cacheStatus . "\n" . $dbStatus);
    }
}
