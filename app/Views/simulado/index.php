<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(APP_NAME) ?> - Simulado</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
<style>
:root{--bg:#060b18;--card:#0d1628;--accent:#00e5a0;--accent2:#00b8ff;--text:#eef2ff;--muted:#6b7ba8;--border:rgba(255,255,255,.08);--grad:linear-gradient(135deg,#00e5a0,#00b8ff)}
*{box-sizing:border-box;margin:0;padding:0}body{min-height:100vh;display:grid;place-items:center;background:var(--bg);color:var(--text);font-family:'DM Sans',sans-serif;padding:24px}.atmo{position:fixed;inset:0;pointer-events:none;background:radial-gradient(ellipse 900px 600px at -10% 10%,rgba(0,229,160,.065),transparent 65%),radial-gradient(ellipse 800px 560px at 110% 80%,rgba(0,184,255,.065),transparent 65%)}.box{position:relative;width:min(720px,100%);background:rgba(13,22,40,.88);border:1px solid var(--border);border-radius:24px;padding:38px;box-shadow:0 40px 100px rgba(0,0,0,.35)}.logo{display:flex;align-items:center;gap:10px;text-decoration:none;margin-bottom:34px}.logo-icon{width:40px;height:40px;border-radius:11px;background:var(--grad);display:grid;place-items:center;font-weight:800;color:#060b18}.logo-text{font:800 22px 'Syne';background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent}h1{font:800 clamp(42px,7vw,70px) 'Syne';letter-spacing:-.03em;line-height:1;margin-bottom:16px}p{color:var(--muted);line-height:1.75;margin-bottom:28px;font-size:17px}.actions{display:flex;gap:12px;flex-wrap:wrap}.btn{display:inline-flex;align-items:center;justify-content:center;border-radius:12px;padding:14px 22px;text-decoration:none;font:800 15px 'Syne';transition:.22s}.primary{background:var(--grad);color:#060b18;box-shadow:0 0 34px rgba(0,229,160,.24)}.secondary{border:1px solid var(--border);color:var(--text);background:rgba(255,255,255,.04)}.btn:hover{transform:translateY(-2px)}
</style>
</head>
<body>
<div class="atmo"></div>
<section class="box">
  <a class="logo" href="<?= url('dashboard') ?>"><div class="logo-icon">E</div><span class="logo-text">Estudai</span></a>
  <h1>Simulado em preparacao</h1>
  <p>Esta rota ja esta dentro do MVC e pronta para receber a proxima parte do sistema: selecao de questoes, respostas, calculo de XP e historico no dashboard.</p>
  <div class="actions">
    <a class="btn primary" href="<?= url('dashboard') ?>">Voltar ao dashboard</a>
    <a class="btn secondary" href="<?= url('logout') ?>">Sair</a>
  </div>
</section>
</body>
</html>
