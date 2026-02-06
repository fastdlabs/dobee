# DoBee

[![Build Status](https://travis-ci.org/JanHuang/dobee.svg?branch=master)](https://travis-ci.org/JanHuang/dobee)
[![PHP Require Version](https://img.shields.io/badge/php-%3E%3D5.6-8892BF.svg)](https://secure.php.net/)
[![Swoole Require Version](https://img.shields.io/badge/swoole-%3E%3D1.9.6-8892BF.svg)](http://www.swoole.com/)
[![Latest Stable Version](https://poser.pugx.org/fastd/dobee/v/stable)](https://packagist.org/packages/fastd/dobee)
[![Latest Unstable Version](https://poser.pugx.org/fastd/dobee/v/unstable)](https://packagist.org/packages/fastd/dobee)
[![License](https://poser.pugx.org/fastd/dobee/license)](https://packagist.org/packages/fastd/dobee)
[![composer.lock](https://poser.pugx.org/fastd/dobee/composerlock)](https://packagist.org/packages/fastd/dobee)

FastD API 开发骨架

### 文档

* [中文文档](https://fastdlabs.com/)

### Support

如果你在使用中遇到问题，请联系: [bboyjanhuang@gmail.com](mailto:bboyjanhuang@gmail.com). 微博: [编码侠](http://weibo.com/ecbboyjan)

## License MIT

## 致 fastd：一段开发旅程的温柔落幕

时光流转，工作环境已然更迭，我与 PHP 开发的交集也渐渐变少，那些曾在代码世界里与字符并肩作战的日常，慢慢沉淀成了过往。
而 AI 技术的迅猛发展，更带来了各行业的深刻变革，未来的舞台，或许更属于那些能够驾驭 AI 的前行者。

技术浪潮滚滚向前，趋势不可逆，但在我心里，始终为 fastd 这个作品留存着一方专属天地。它承载着我过往的开发热忱与心血，是一段青春与热爱的见证。纠结良久，我终于下定决心，为它画上一个圆满的句号。

落幕不代表遗忘，这段与 fastd 相伴的旅程，早已成为我职业道路上珍贵的印记，照亮往后的前行之路。



[![Latest Stable Version](https://poser.pugx.org/fastd/cache/v/stable)](https://packagist.org/packages/fastd/cache)
[![Total Downloads](https://poser.pugx.org/fastd/cache/downloads)](https://packagist.org/packages/fastd/cache)
[![License](https://poser.pugx.org/fastd/cache/license)](https://packagist.org/packages/fastd/cache)

FastD Cache 是一个高性能的 PHP 缓存库，专为 [FastD PHP 框架](https://github.com/fastdlabs/fastd) 设计。它参考了 Varnish 架构中的缓存机制，提供了从底层缓存到 HTTP 层面的完整缓存解决方案。

## 🚀 主要特性

- **高性能缓存** - 基于 Symfony Cache 组件，支持多种缓存适配器
- **灵活配置** - 支持文件系统、Redis、Memcached 等多种缓存后端
- **连接池管理** - 自动管理缓存连接，提高性能
- **HTTP 中间件** - 内置 HTTP 缓存中间件，支持页面级缓存
- **服务提供者** - 完整的服务容器集成
- **辅助函数** - 简洁的 `cache()` 辅助函数调用

## 📖 文档

完整的文档请查看 [docs/](docs/) 目录：

待办组件
"fastd/cache": "dev-develop",
"fastd/container": "dev-develop",
"fastd/config": "dev-develop",
"fastd/http": "dev-develop",
"fastd/event": "dev-develop",
"fastd/routing": "dev-develop",
"fastd/medoodb": "dev-develop",
"fastd/swoole": "dev-develop",
"fastd/fastd": "dev-develop",

标准待办：

1. 统一测试用例风格。

```json
"require-dev": {
    "phpunit/phpunit": "^10.0",
    "phpstan/phpstan": "^1.0"
},
"scripts": {
    "test": "phpunit",
    "test-coverage": "phpunit --coverage-html=coverage"
}
```

2. 新增组件 example.php 用例

3. 增加统一wiki 文档

请根据现有代码库内容，重新组织和优化 wiki 文档结构。将文档按照以下三大主目录进行组织：

1. 项目概述
2. API 参考
3. 安装与使用
   每个主目录下需要包含具体详细的子章节，确保文档结构清晰、内容完整、易于查阅。参考现有的 README.md、源代码文件和测试文件来完善文档内容。生成对应的 markdown 文档到 docs 目录

4. 更新统一 readme.md 风格
更新 readme.md 文件，符合简介，环境依赖说明，基础使用说明，文档详细引导，隐藏联系方式，用简洁直观的方式呈现