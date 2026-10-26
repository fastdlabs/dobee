<?php

declare(strict_types=1);

namespace http;

use FastD\Http\Response\Text;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * SSE 交互演示页（浏览器 EventSource）。
 */
final class SseDemoPage implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new Text(200, self::html(), ['content-type' => 'text/html; charset=UTF-8']);
    }

    private static function html(): string
    {
        return <<<'HTML'
<!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>FastD SSE Demo</title>
<style>
  :root { color-scheme: light dark; --bg:#0f172a; --card:#111827; --line:#1f2937; --text:#e5e7eb; --muted:#94a3b8; --ok:#22c55e; --err:#ef4444; --wait:#f59e0b; --accent:#38bdf8; }
  * { box-sizing: border-box; }
  body { margin:0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "PingFang SC", sans-serif; background:var(--bg); color:var(--text); }
  header { padding:24px 20px 8px; }
  h1 { margin:0 0 6px; font-size:20px; }
  p.lead { margin:0; color:var(--muted); font-size:13px; }
  main { display:grid; grid-template-columns: 1fr; gap:16px; padding:16px 20px 32px; max-width: 980px; }
  @media (min-width: 900px) { main { grid-template-columns: 360px 1fr; align-items:start; } }
  .card { background:var(--card); border:1px solid var(--line); border-radius:12px; padding:16px; }
  .row { display:flex; flex-wrap:wrap; gap:8px; align-items:center; margin-bottom:10px; }
  button { border:1px solid var(--line); background:#1d4ed8; color:white; border-radius:8px; padding:8px 14px; font-size:13px; cursor:pointer; }
  button.secondary { background:transparent; color:var(--text); }
  button:disabled { opacity:.5; cursor:not-allowed; }
  input { background:#0b1220; color:var(--text); border:1px solid var(--line); border-radius:8px; padding:7px 10px; font-size:13px; width:120px; }
  label { color:var(--muted); font-size:12px; display:flex; align-items:center; gap:8px; }
  .status { margin:4px 0 10px; padding:8px 10px; border-radius:8px; font-size:13px; background:#0b1220; border:1px solid var(--line); }
  .status.ok { border-color:#166534; color:#4ade80; }
  .status.error { border-color:#7f1d1d; color:#f87171; }
  .status.waiting { border-color:#78350f; color:#fbbf24; }
  .meta { color:var(--muted); font-size:12px; }
  .meta b { color:var(--text); font-weight:600; }
  ol#events { list-style:none; margin:0; padding:0; max-height:520px; overflow:auto; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size:12px; }
  li.event { display:flex; gap:10px; padding:6px 4px; border-bottom:1px dashed var(--line); align-items:baseline; }
  li.event .badge { flex:0 0 auto; padding:1px 7px; border-radius:999px; background:#1e293b; color:var(--accent); font-size:11px; }
  li.event.notice .badge { color:#a78bfa; }
  li.event.done .badge { color:var(--ok); }
  li.event .when { margin-left:auto; color:var(--muted); white-space:nowrap; }
  code { background:#0b1220; padding:1px 6px; border-radius:6px; }
</style>
</head>
<body>
<header>
  <h1>FastD SSE Demo</h1>
  <p class="lead">EventSource 连接 <code>/sse</code>，服务端按秒推送 <code>tick</code> 事件；支持 Last-Event-ID 续传与心跳。</p>
</header>
<main>
  <section class="card">
    <div class="row">
      <button id="connect">连接</button>
      <button id="disconnect" class="secondary">断开</button>
      <button id="clear" class="secondary">清空</button>
    </div>
    <div class="row">
      <label>Last-Event-ID <input id="lastId" placeholder="例如 5"></label>
      <button id="resume" class="secondary">按 ID 重连</button>
    </div>
    <div id="status" class="status">未连接</div>
    <div class="meta">事件数 <b id="count">0</b> · 最后 ID <b id="lastSeen">-</b> · 连接时长 <b id="uptime">0s</b></div>
    <p class="meta" style="margin-top:12px">连接后观察事件逐条出现；心跳（注释帧）浏览器不可见，用于保持连接。</p>
  </section>
  <section class="card">
    <ol id="events"></ol>
  </section>
</main>
<script>
(function () {
  var byId = function (id) { return document.getElementById(id); };
  var source = null, count = 0, connectedAt = 0, timer = null;

  function setStatus(text, kind) {
    var el = byId('status');
    el.textContent = text;
    el.className = 'status' + (kind ? ' ' + kind : '');
  }

  function append(kind, text, id) {
    var li = document.createElement('li');
    li.className = 'event ' + kind;

    var badge = document.createElement('span');
    badge.className = 'badge';
    badge.textContent = kind;

    var body = document.createElement('span');
    body.textContent = text;

    var when = document.createElement('span');
    when.className = 'when';
    when.textContent = new Date().toLocaleTimeString() + (id ? ' · id=' + id : '');

    li.appendChild(badge);
    li.appendChild(body);
    li.appendChild(when);

    var list = byId('events');
    list.appendChild(li);
    list.scrollTop = list.scrollHeight;
  }

  function stop() {
    if (source) { source.close(); source = null; }
    if (timer) { clearInterval(timer); timer = null; }
  }

  function connect(lastId) {
    stop();
    count = 0;
    byId('count').textContent = '0';
    byId('lastSeen').textContent = '-';

    var params = new URLSearchParams({ limit: '30', interval: '1000' });
    if (lastId) { params.set('last_id', lastId); }

    source = new EventSource('/sse?' + params.toString());
    connectedAt = Date.now();

    setStatus('连接中…', 'waiting');
    timer = setInterval(function () {
      byId('uptime').textContent = Math.floor((Date.now() - connectedAt) / 1000) + 's';
    }, 1000);

    source.onopen = function () { setStatus('已连接（服务端每 5s 发送心跳）', 'ok'); };
    source.onerror = function () {
      setStatus('连接中断：浏览器会自动携带 Last-Event-ID 重连', 'error');
    };

    source.addEventListener('notice', function (e) {
      append('notice', e.data, e.lastEventId);
    });

    source.addEventListener('tick', function (e) {
      count++;
      byId('count').textContent = String(count);
      byId('lastSeen').textContent = e.lastEventId;
      byId('lastId').value = e.lastEventId;
      append('tick', e.data, e.lastEventId);
    });

    source.addEventListener('done', function (e) {
      append('done', e.data, e.lastEventId);
      setStatus('流已结束', 'ok');
      stop();
    });
  }

  byId('connect').addEventListener('click', function () { connect(''); });
  byId('disconnect').addEventListener('click', function () { stop(); setStatus('已断开', ''); });
  byId('clear').addEventListener('click', function () {
    byId('events').innerHTML = '';
    count = 0;
    byId('count').textContent = '0';
  });
  byId('resume').addEventListener('click', function () { connect(byId('lastId').value.trim()); });
})();
</script>
</body>
</html>
HTML;
    }
}
