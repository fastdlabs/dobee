# DoBee Framework

[![CI](https://github.com/fastdlabs/dobee/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/fastdlabs/dobee/actions/workflows/ci.yml)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.4.1-8892BF.svg)](https://secure.php.net/)
[![Latest Stable Version](https://poser.pugx.org/fastd/dobee/v/stable)](https://packagist.org/packages/fastd/dobee)
[![License](https://poser.pugx.org/fastd/dobee/license)](https://packagist.org/packages/fastd/dobee)

DoBee 是基于 FastD 组件生态构建的最小 PHP API 框架骨架，支持 Swoole 与 FastCGI 运行。

## 特性

- 最小可运行骨架：安装后只有欢迎接口
- PSR-7 / PSR-15 / PSR-17 标准
- Swoole HTTP Server 与 FastCGI 双运行时
- 可选 Demo 包：`fastd/dobee-demo`
- 构造器注入 / 路由 resolver 由 FastD 核心提供

## 环境要求

- PHP >= 8.4.1
- ext-json
- ext-pdo
- Swoole（可选，用于 Swoole 运行时）

## 安装

```bash
composer create-project fastd/dobee myapp
cd myapp
```

## 快速开始

### 启动 Swoole

```bash
php bin/server start
curl http://127.0.0.1:9527/
```

### 启动 FastCGI

```bash
php -S 127.0.0.1:8099 -t web
curl http://127.0.0.1:8099/
```

响应：

```text
Hello FastD and goodbye FastD [fastcgi]
```

方括号中为当前执行环境（如 `fastcgi`、`swoole`、`testcase`），用于区分运行时。

## 项目结构

```text
dobee/
├── config/
│   ├── cache.php          # 缓存池 / HTTP 缓存配置（含注释示例）
│   ├── command.php        # 控制台命令（按需加载 demo）
│   ├── database.php       # SQLite/MySQL 配置（含注释示例）
│   ├── listener.php       # 事件监听
│   ├── process.php        # 自定义进程 / 信号监听
│   ├── service.php        # 服务提供者（按需加载 demo）
│   ├── session.php        # Session 配置
│   └── swoole.php         # Swoole 服务配置
├── routes/
│   └── web.php            # 路由（仅欢迎接口）
├── src/
│   ├── bootstrap.php      # 应用引导
│   └── Http/Controller/   # 应用 Controller
├── tests/Feature/         # 欢迎接口测试
├── web/index.php          # FastCGI 入口
├── bin/server             # Swoole 启动脚本
└── composer.json
```

## Demo 包

Demo 能力已拆分到独立包：

```text
https://github.com/fastdlabs/dobee-demo
```

默认作为 `require-dev` 安装，包含：

- Session
- SSE / AI Mock Stream
- RequestId Middleware
- 构造器注入 / Resolver
- Cache（file adapter）
- Database（SQLite / MedooDB）
- Swoole Server / 自定义 Listener
- Console Command
- Process / Signal
- 演示页面 `/demo/*.html`

生产环境使用 `--no-dev` 安装时不会引入 Demo 路由、中间件或代码：

```bash
composer install --no-dev
```

如果使用 `composer create-project`，默认会安装 dev 依赖；不需要 Demo 时可直接移除：

```bash
composer remove --dev fastd/dobee-demo
```

## 开发

```bash
composer install
bin/phpunit --no-coverage
bin/phpstan analyse --no-progress
```

## License

MIT

## 配置示例

`config/` 下保留了完整的配置示例与注释：

- `cache.php`：文件、PHP、Redis、Memcached、HTTP 缓存中间件
- `database.php`：SQLite（默认）、MySQL、PostgreSQL
- `session.php`：Session handler、Cookie、TTL、Swoole Table
- `command.php`：控制台命令注册（Demo 条件加载）
- `process.php`：Worker 与信号监听（Demo 条件加载）
- `swoole.php`：多端口 Listener、Stats、Swoole 设置
- `service.php` / `listener.php`：服务与事件监听

Demo 命令：

```bash
php bin/console demo:hello
# Hello from fastd/dobee-demo command: Hello FastD from constructor injection
php bin/process
# [demo] worker started: demo (pid=...) Hello FastD from constructor injection
```
