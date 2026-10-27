# DoBee Framework

[![CI](https://github.com/fastdlabs/dobee/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/fastdlabs/dobee/actions/workflows/ci.yml)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.2-8892BF.svg)](https://secure.php.net/)
[![Swoole Version](https://img.shields.io/badge/swoole-%3E%3E4.5-8892BF.svg)](http://www.swoole.com/)
[![Latest Stable Version](https://poser.pugx.org/fastd/dobee/v/stable)](https://packagist.org/packages/fastd/dobee)
[![License](https://poser.pugx.org/fastd/dobee/license)](https://packagist.org/packages/fastd/dobee)

DoBee 是基于 FastD 组件生态构建的高性能 PHP API 框架骨架，完全支持 Swoole 协程运行，提供简洁优雅的开发体验。

## ✨ 特性

- 🚀 **高性能** - 基于 Swoole 协程，性能远超传统 PHP-FPM
- 📦 **组件化** - 完全采用 FastD 8.0 组件，松耦合设计
- 🎯 **PSR 标准** - 遵循 PSR-7/11/15/17/18 标准
- 🔧 **简洁配置** - 清晰的配置文件结构，易于理解和扩展
- 🌐 **HTTP 服务** - 支持 Swoole HTTP 服务器和传统 FastCGI
- 💾 **缓存支持** - 集成文件系统、Redis 等多种缓存后端
- 🗄️ **数据库** - 基于 Medoo 的轻量级数据库操作，支持连接池
- 🎭 **中间件** - PSR-15 中间件支持，灵活扩展
- 📡 **事件驱动** - 完整的事件监听器机制

## 📋 环境要求

- **PHP**: >= 8.2
- **Swoole**: >= 4.5 (可选，用于协程模式)
- **扩展**: 
  - ext-swoole (可选)
  - ext-pdo
  - ext-json
  - ext-curl

## 📦 安装

### 方式一：使用 Composer 创建项目（推荐）

```bash
composer create-project fastd/dobee myapp
cd myapp
```

### 方式二：克隆仓库后安装

```bash
git clone https://github.com/fastdlabs/dobee.git
cd dobee
composer install
```

### 方式三：手动添加到现有项目

```bash
composer require fastd/dobee
```

## 🚀 快速开始

### 1. 项目结构

```
dobee/
├── config/                  # 运行时配置
│   ├── cache.php
│   ├── command.php
│   ├── database.php
│   ├── listener.php
│   ├── process.php
│   ├── service.php
│   ├── session.php
│   └── swoole.php
├── routes/
│   └── api.php              # API 路由
├── src/                     # 应用代码（根命名空间映射到 src/）
│   ├── bootstrap.php        # 引导文件（FastD bin 固定读取）
│   ├── Http/
│   │   ├── Controller/      # API Controller
│   │   └── Middleware/      # API 中间件（预留）
│   ├── Terminal/
│   │   ├── Command/         # 控制台命令
│   │   └── Process/         # 自定义进程 Worker
│   └── Listener/
│       ├── RuntimeListener.php
│       ├── Server/          # Swoole Server 监听器
│       └── Process/         # Swoole Process 监听器
├── tests/
│   ├── Feature/             # HTTP API 端到端测试
│   ├── Integration/         # 应用启动/事件集成测试
│   └── Unit/
├── web/
│   ├── index.php            # Web 入口
│   └── demo/                # 静态演示页面（非应用代码）
├── runtime/                 # 运行时目录（gitignored）
└── composer.json
```

### 2. 配置数据库

编辑 `config/database.php`:

```php
return [
    'default' => [
        'type' => 'mysql',
        'host' => '127.0.0.1',
        'database' => 'dobee',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'port' => 3306,
    ],
];
```

### 3. 配置缓存

编辑 `config/cache.php`:

```php
return [
    'file' => [
        'adapter' => [
            'class' => \Symfony\Component\Cache\Adapter\FilesystemAdapter::class,
            'dsn' => null,
        ],
        'namespace' => 'dobee',
        'lifetime' => 3600,
        'directory' => __DIR__ . '/../runtime/cache',
    ],
];
```

### 4. 定义路由

编辑 `routes/api.php`:

```php
return [
    ['GET', '/', \Http\Controller\WelcomeController::class],
    ['GET', '/users', \Http\Controller\UserController::class],
    ['POST', '/users', \Http\Controller\UserController::class],
];
```

### 5. 创建 HTTP 处理器

创建 `src/Http/Controller/UserController.php`:

```php
<?php

declare(strict_types=1);

namespace Http\Controller;

use FastD\Http\Response\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UserController implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $db = container()->get('medoodb')->getDatabase('default');
        $users = $db->select('users', '*');
        
        return new Json(200, [
            'status' => 'success',
            'data' => $users,
        ]);
    }
}
```

### 5.1 HTTP 中间件

路由第 4 个参数可传入中间件类列表，按路由独立生效：

```php
// routes/api.php
['GET', '/middleware-demo', \Http\Controller\MiddlewareDemoController::class, [
    \Http\Middleware\RequestIdMiddleware::class,
]],
```

`RequestIdMiddleware` 会透传或生成 `X-Request-Id`，并在响应中附加 `X-Response-Time`；
对应联调页面：`/demo/middleware.html`，API：`/middleware-demo`。

### 6. 会话管理

会话能力由 `config/session.php` 与 `FastD\ServiceProvider\SessionServiceProvider` 提供，
默认在 `config/service.php` 中启用；CGI 使用文件存储，Swoole 使用共享内存 `Swoole\Table`。

```php
// config/session.php
return [
    'enabled' => true,
    'handler' => 'auto',        // auto | file | swoole_table
    'ttl'     => 1440,
    'cookie'  => ['name' => 'FASTD_SESSID', 'http_only' => true, 'same_site' => 'Lax', 'secure' => false],
    'file'    => ['path' => __DIR__ . '/../runtime/session'],
];
```

```php
// src/Http/Controller/SessionController.php —— 通过请求属性取会话
use FastD\Http\Session\SessionMiddleware;

public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
{
    /** @var \FastD\Http\Session\SessionInterface $session */
    $session = $request->getAttribute(SessionMiddleware::ATTRIBUTE);

    $session->set('user_id', 1);          // 写入
    $session->flash('notice', '保存成功');  // 仅下一次请求可读
    $session->getToken();                 // CSRF token
    $session->regenerateId();             // 登录后轮换会话 ID

    return json(['ok' => true]);
}
```

示例路由：`GET /session`（同一会话内访问计数递增），可直接 curl 验证 Cookie 回传。

### 7. SSE 流式输出（AI 交互 Demo）

框架提供 `FastD\Http\Response\SseResponse`（`sse()` 助手）与双运行时输出：CGI 直接 flush，Swoole 走协程 + 心跳 + 背压。仓库内置两个可直接体验的页面：

| 地址 | 说明 |
|------|------|
| `/demo/sse.html` | EventSource 演示：逐条事件、序号、Last-Event-ID 续传、断开/重连 |
| `/demo/ai.html` | AI 对话演示：POST + fetch 流式读取，逐 token 渲染，支持停止生成 |
| `/demo/middleware.html` | 中间件演示：展示 `X-Request-Id`、`X-Response-Time` 与响应 JSON |
| `/sse?limit=5&interval=500` | 演示端点（GET，支持 `Last-Event-ID`） |
| `/ai/mock-stream` | 模拟 AI 流式端点（POST 表单 `prompt`，返回 meta/delta/done） |
| `/middleware-demo` | 路由级 `RequestIdMiddleware` 演示端点 |

启动（两种运行时任选其一）：

```bash
# CGI：浏览器打开 http://127.0.0.1:8099/demo/sse.html 与 /demo/ai
php -S 127.0.0.1:8099 -t web

# Swoole 入口只提供 API；静态演示页请用 CGI 或独立静态服务器
php server start
```

终端验证：

```bash
curl -N 'http://127.0.0.1:8099/sse?limit=3&interval=500'
curl -N -H 'Last-Event-ID: 2' 'http://127.0.0.1:8099/sse?limit=2'
curl -N -X POST -d 'prompt=介绍一下 FastD' http://127.0.0.1:8099/ai/mock-stream
```

说明：

- 事件格式为 `event:` / `id:` / `data:` 帧，`data` 自动 JSON 编码，心跳为注释帧（浏览器不可见）。
- Swoole 必须在 `config/swoole.php` 中保持 `enable_coroutine=true`、`http_compression=false`（仓库已默认配置）。
- 反向代理需关闭缓冲：配置见「运行方式 → Nginx 部署」。
- `/ai/mock-stream` 为本地模拟输出，接入真实 AI 时替换生产者即可（上游流式客户端见后续计划）。

## 🛠️ 运行方式

### 开发环境 (FastCGI)

```bash
# 使用 PHP 内置服务器
php -S localhost:8080 -t web/
```

### 生产环境 (Swoole)

```bash
# 启动 Swoole 服务器
php bin/server start

# 查看状态
php bin/server status

# 停止服务器
php bin/server stop

# 重启服务器
php bin/server restart
```

### Nginx 部署

#### FastCGI / FPM

```nginx
server {
    listen    80;
    index index.php;
    server_name fastd;
    root /path/to/dobee/web;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php {
        fastcgi_pass 127.0.0.1:9000;

        # SSE：关闭 FastCGI 缓冲并延长超时，保证事件实时下发
        fastcgi_buffering off;
        fastcgi_read_timeout 3600s;
        gzip off;

        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include       fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

#### Swoole 反向代理

```nginx
server {
    listen     80;
    server_name fastd;

    location / {
        proxy_pass http://127.0.0.1:9527;

        # SSE：HTTP/1.1 + 关闭代理缓冲/缓存 + 延长读超时
        proxy_http_version 1.1;
        proxy_set_header Connection '';
        proxy_buffering off;
        proxy_cache off;
        proxy_read_timeout 3600s;
        gzip off;
        chunked_transfer_encoding on;
    }
}
```

> SSE 场景必须关闭对应中间层的缓冲与压缩，并按需延长读超时；Swoole 服务本身保持 `config/swoole.php` 中 `enable_coroutine=true`、`http_compression=false`。

## 📝 使用示例

### HTTP 健康检查示例

所有示例统一输出服务状态：

```
FastD Health Check

Cache: ✓ Connected
Database: ✓ Connected
```

查看 `src/Http/Controller/WelcomeController.php` 了解完整实现。

### 使用缓存

```php
$cachePool = container()->get('cache');
$fileCache = $cachePool->getCache('file');

// 写入缓存
$cacheItem = $fileCache->getItem('user_1');
$cacheItem->set(['name' => 'John']);
$cacheItem->expiresAfter(3600);
$fileCache->save($cacheItem);

// 读取缓存
$item = $fileCache->getItem('user_1');
if ($item->isHit()) {
    $user = $item->get();
}
```

### 使用数据库

```php
$dbPool = container()->get('medoodb');
$db = $dbPool->getDatabase('default');

// 查询
$users = $db->select('users', '*', ['status' => 1]);

// 插入
$db->insert('users', [
    'name' => 'John',
    'email' => 'john@example.com',
]);

// 更新
$db->update('users', ['status' => 0], ['id' => 1]);

// 删除
$db->delete('users', ['id' => 1]);
```

### 命令行命令

创建 `src/Terminal/Command/GreetCommand.php`:

```php
<?php

declare(strict_types=1);

namespace Terminal\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GreetCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('greet');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Hello from DoBee!');
        return 0;
    }
}
```

运行命令：

```bash
php bin/console greet
```

## 🧪 测试

```bash
composer install
bin/phpunit
```

## 📚 依赖组件

DoBee 基于 FastD 8.0 组件生态：

```json
{
    "require": {
        "fastd/fastd": "^8.1"
    }
}
```

具体组件版本由 `fastd/fastd` 统一约束，dobee 不再单独维护组件版本矩阵。

所有组件均遵循 PSR 标准，完全兼容 PHP 8.4+。

## 📖 文档

- **FastD 框架**: https://github.com/fastdlabs/fastd
- **组件文档**: 各组件仓库 README
- **Swoole 文档**: https://www.swoole.com/

## 🤝 贡献

欢迎提交 Issue 和 Pull Request！

## 📄 License

MIT License
