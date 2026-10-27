# Upgrading dobee

## 1.3.4 → 1.3.5

`1.3.4` 的依赖约束允许解析到 fastD 8.2，但它的 Swoole 配置仍是旧结构。

`1.3.5` 已锁定：

```json
"fastd/fastd": ">=8.1 <8.2",
"fastd/dobee-demo": ">=1.3 <1.4"
```

请使用 `1.3.5`，不要继续固定 `1.3.4`。

## 1.3.x → 1.4.x

`1.4` 是新主线：

```json
"fastd/fastd": "^8.2",
"fastd/dobee-demo": "^1.4"
```

主要变化：

- dobee 只保留最小欢迎接口与配置示例
- Demo 拆分到 `fastd/dobee-demo`
- 安装 demo 时由 Composer 安装脚本在原配置 return 数组内注入 demo 配置
- Swoole 配置使用 `servers` / `listeners` / `options`

## 兼容矩阵

| dobee | fastD | dobee-demo |
|---|---|---|
| 1.4.x | ^8.2 | ^1.4 |
| 1.3.5 | >=8.1 <8.2 | >=1.3 <1.4 |
| 1.3.4 | 仅 8.1.x | 1.3.x |
