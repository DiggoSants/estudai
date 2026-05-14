<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(APP_NAME) ?> — Simulado</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Syne:wght@400;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}:root{--bg:#09090f;--card:#111120;--gold:#e8c547;--violet:#6b4de6;--text:#e8e8f0;--muted:#6b6b8a;--border:#1e1e38}body{min-height:100vh;display:grid;place-items:center;background:var(--bg);color:var(--text);font-family:'Syne',sans-serif;padding:24px}.box{width:min(680px,100%);background:var(--card);border:1px solid var(--border);border-radius:12px;padding:36px}.logo{font-family:'Bebas Neue';font-size:32px;color:var(--gold);letter-spacing:2px;margin-bottom:28px;display:inline-block;text-decoration:none}h1{font-family:'Bebas Neue';font-size:56px;line-height:1;margin-bottom:14px;letter-spacing:1px}p{color:var(--muted);line-height:1.7;margin-bottom:28px}.actions{display:flex;gap:12px;flex-wrap:wrap}a.btn{padding:13px 22px;border-radius:8px;text-decoration:none;font-weight:800}.primary{background:var(--gold);color:#09090f}.secondary{border:1px solid var(--border);color:var(--text)}
</style>
</head>
<body>
<section class="box">
  <a class="logo" href="<?= url('dashboard') ?>">Estudai</a>
  <h1>Simulado em preparação</h1>
  <p>Já deixei esta rota conectada ao MVC para receber a próxima parte do sistema. Quando você enviar o arquivo do simulado, eu encaixo aqui com banco, questões, respostas, XP e finalização.</p>
  <div class="actions">
    <a class="btn primary" href="<?= url('dashboard') ?>">Voltar ao dashboard</a>
    <a class="btn secondary" href="<?= url('logout') ?>">Sair</a>
  </div>
</section>
</body>
</html>
