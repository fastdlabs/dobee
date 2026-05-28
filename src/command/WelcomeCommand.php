<?php

declare(strict_types=1);

namespace command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WelcomeCommand extends Command
{
    public function configure(): void
    {
        $this->setName('welcome');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('FastD Health Check');
        $output->writeln('');
        
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
        $output->writeln($cacheStatus);
        
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
        $output->writeln($dbStatus);
        
        return 0;
    }
}
