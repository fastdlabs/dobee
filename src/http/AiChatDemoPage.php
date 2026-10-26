<?php

declare(strict_types=1);

namespace http;

use FastD\Http\Response\Text;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * AI 流式对话演示页：fetch + ReadableStream 读取 SSE（POST /ai/mock-stream）。
 */
final class AiChatDemoPage implements MiddlewareInterface
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
<title>FastD AI Stream Demo</title>
<style>
  :root { color-scheme: light dark; --bg:#0f172a; --card:#111827; --line:#1f2937; --text:#e5e7eb; --muted:#94a3b8; --ok:#22c55e; --err:#ef4444; --accent:#38bdf8; }
  * { box-sizing: border-box; }
  body { margin:0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "PingFang SC", sans-serif; background:var(--bg); color:var(--text); }
  header { padding:24px 20px 8px; }
  h1 { margin:0 0 6px; font-size:20px; }
  p.lead { margin:0; color:var(--muted); font-size:13px; }
  main { max-width: 860px; padding:16px 20px 32px; display:grid; gap:16px; }
  .card { background:var(--card); border:1px solid var(--line); border-radius:12px; padding:16px; }
  textarea { width:100%; min-height:76px; resize:vertical; background:#0b1220; color:var(--text); border:1px solid var(--line); border-radius:10px; padding:10px 12px; font-size:14px; font-family:inherit; }
  .row { display:flex; gap:10px; align-items:center; margin-top:10px; flex-wrap:wrap; }
  button { border:1px solid var(--line); background:#1d4ed8; color:white; border-radius:8px; padding:9px 16px; font-size:13px; cursor:pointer; }
  button.secondary { background:transparent; color:var(--text); }
  button:disabled { opacity:.5; cursor:not-allowed; }
  .status { font-size:13px; padding:8px 10px; border-radius:8px; background:#0b1220; border:1px solid var(--line); }
  .status.ok { border-color:#166534; color:#4ade80; }
  .status.error { border-color:#7f1d1d; color:#f87171; }
  #answer { white-space:pre-wrap; line-height:1.75; font-size:14px; min-height:120px; }
  .meta { color:var(--muted); font-size:12px; margin-top:8px; }
  .meta b { color:var(--text); }
  .cursor::after { content:"▍"; color:var(--accent); animation: blink 1s steps(2, start) infinite; }
  @keyframes blink { to { visibility: hidden; } }
</style>
</head>
<body>
<header>
  <h1>FastD AI 流式 Demo</h1>
  <p class="lead">POST <code>/ai/mock-stream</code>，由 <code>fetch</code> 读取 SSE，逐 token 渲染；无需真实模型与密钥。</p>
</header>
<main>
  <section class="card">
    <textarea id="prompt" placeholder="输入问题，例如：介绍一下 FastD 的 SSE 能力">介绍一下 FastD 的 SSE 能力</textarea>
    <div class="row">
      <button id="send">发送</button>
      <button id="stop" class="secondary" disabled>停止生成</button>
      <button id="clear" class="secondary">清空</button>
    </div>
  </section>
  <section class="card">
    <div id="status" class="status">等待输入</div>
    <div id="answer"></div>
    <div class="meta">事件 <b id="events">0</b> · 字符 <b id="chars">0</b> · 耗时 <b id="elapsed">0.0s</b> · 模型 <b id="model">-</b></div>
  </section>
</main>
<script>
(function () {
  var byId = function (id) { return document.getElementById(id); };
  var controller = null, generating = false, timer = null, startedAt = 0;
  var events = 0, chars = 0;

  function setStatus(text, kind) {
    var el = byId('status');
    el.textContent = text;
    el.className = 'status' + (kind ? ' ' + kind : '');
  }

  function setGenerating(value) {
    generating = value;
    byId('send').disabled = value;
    byId('stop').disabled = !value;
    byId('answer').classList.toggle('cursor', value);
  }

  function handleFrame(raw) {
    var event = 'message';
    var dataLines = [];

    raw.split('\n').forEach(function (line) {
      if (line.indexOf('event:') === 0) {
        event = line.slice(6).trim();
      } else if (line.indexOf('data:') === 0) {
        dataLines.push(line.slice(5).trimStart());
      }
    });

    if (!dataLines.length) { return; }

    var data = dataLines.join('\n');
    var payload = null;
    try { payload = JSON.parse(data); } catch (e) { payload = { raw: data }; }

    events++;
    byId('events').textContent = String(events);

    if (event === 'meta') {
      byId('model').textContent = payload.model || '-';
    } else if (event === 'delta') {
      byId('answer').textContent += payload.delta || '';
      chars += (payload.delta || '').length;
      byId('chars').textContent = String(chars);
    } else if (event === 'done') {
      setStatus('生成完成 · completion_tokens=' + ((payload.usage || {}).completion_tokens || '-'), 'ok');
      finish();
    } else if (event === 'error') {
      setStatus('服务端错误：' + (payload.message || data), 'error');
      finish();
    }
  }

  function finish() {
    setGenerating(false);
    if (timer) { clearInterval(timer); timer = null; }
    byId('elapsed').textContent = ((Date.now() - startedAt) / 1000).toFixed(1) + 's';
  }

  function reset() {
    byId('answer').textContent = '';
    events = 0; chars = 0;
    byId('events').textContent = '0';
    byId('chars').textContent = '0';
    byId('elapsed').textContent = '0.0s';
    byId('model').textContent = '-';
  }

  async function send() {
    var prompt = byId('prompt').value.trim();
    if (!prompt || generating) { return; }

    reset();
    controller = new AbortController();
    startedAt = Date.now();
    setGenerating(true);
    setStatus('连接中…', '');
    timer = setInterval(function () {
      byId('elapsed').textContent = ((Date.now() - startedAt) / 1000).toFixed(1) + 's';
    }, 100);

    try {
      var response = await fetch('/ai/mock-stream', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' },
        body: new URLSearchParams({ prompt: prompt }),
        signal: controller.signal,
      });

      if (!response.ok) {
        throw new Error('HTTP ' + response.status);
      }

      setStatus('正在接收流…', 'ok');

      var reader = response.body.getReader();
      var decoder = new TextDecoder('utf-8');
      var buffer = '';

      while (true) {
        var chunk = await reader.read();
        if (chunk.done) { break; }

        buffer += decoder.decode(chunk.value, { stream: true });

        var index;
        while ((index = buffer.indexOf('\n\n')) !== -1) {
          var frame = buffer.slice(0, index);
          buffer = buffer.slice(index + 2);
          if (frame.trim() !== '') { handleFrame(frame); }
        }
      }

      if (generating) {
        setStatus('流已结束', 'ok');
        finish();
      }
    } catch (error) {
      if (error.name === 'AbortError') {
        setStatus('已停止生成', '');
      } else {
        setStatus('请求失败：' + error.message, 'error');
      }
      finish();
    } finally {
      controller = null;
    }
  }

  byId('send').addEventListener('click', send);
  byId('stop').addEventListener('click', function () {
    if (controller) { controller.abort(); }
  });
  byId('clear').addEventListener('click', function () {
    reset();
    setStatus('等待输入', '');
  });
  byId('prompt').addEventListener('keydown', function (event) {
    if ((event.metaKey || event.ctrlKey) && event.key === 'Enter') { send(); }
  });
})();
</script>
</body>
</html>
HTML;
    }
}
