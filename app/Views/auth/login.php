<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(APP_NAME) ?> - <?= $tab === 'register' ? 'Criar conta' : 'Entrar' ?></title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
<style>
:root{--bg:#060b18;--bg2:#080e1c;--card:#0d1628;--card2:#111e38;--accent:#00e5a0;--accent2:#00b8ff;--danger:#ff6b6b;--text:#eef2ff;--muted:#6b7ba8;--border:rgba(255,255,255,.08);--grad:linear-gradient(135deg,#00e5a0,#00b8ff)}
*{box-sizing:border-box;margin:0;padding:0}body{min-height:100vh;background:var(--bg);color:var(--text);font-family:'DM Sans',sans-serif;line-height:1.6}h1,h2,h3,.logo-text,.tab,button{font-family:'Syne',sans-serif}a{text-decoration:none;color:inherit}.atmo,.stars{position:fixed;inset:0;pointer-events:none;z-index:0}.atmo:before{content:"";position:absolute;inset:0;background:radial-gradient(ellipse 900px 600px at 0% 20%,rgba(0,229,160,.07),transparent 65%),radial-gradient(ellipse 800px 560px at 110% 80%,rgba(0,184,255,.07),transparent 65%)}.stars{background-image:radial-gradient(1px 1px at 15% 20%,rgba(255,255,255,.35),transparent),radial-gradient(1px 1px at 72% 8%,rgba(255,255,255,.25),transparent),radial-gradient(1.5px 1.5px at 92% 62%,rgba(0,229,160,.5),transparent)}
.page{position:relative;z-index:1;display:grid;grid-template-columns:minmax(0,1fr) minmax(360px,1fr);min-height:100vh}.left{padding:58px 7vw;display:flex;flex-direction:column;justify-content:space-between;gap:36px;background:linear-gradient(160deg,rgba(0,229,160,.08),rgba(0,184,255,.03) 45%,transparent);border-right:1px solid var(--border);min-width:0;overflow:hidden}.logo{display:flex;align-items:center;gap:10px;min-width:0}.logo-icon{width:40px;height:40px;border-radius:11px;background:var(--grad);display:grid;place-items:center;font-weight:800;color:#060b18;box-shadow:0 0 20px rgba(0,229,160,.3);flex:0 0 auto}.logo-text{font-size:22px;font-weight:800;background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent}.left h1{font-size:clamp(46px,6vw,78px);line-height:1;letter-spacing:-.03em;margin-bottom:24px;overflow-wrap:anywhere}.left h1 em{font-style:normal;background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent}.left p{max-width:440px;color:var(--muted);font-size:18px;overflow-wrap:anywhere}.feature-list{display:grid;gap:14px}.feature{display:flex;gap:12px;align-items:flex-start;color:var(--muted);min-width:0;overflow-wrap:anywhere}.feature b{color:var(--text)}.dot{width:10px;height:10px;margin-top:8px;border-radius:50%;background:var(--accent);box-shadow:0 0 18px rgba(0,229,160,.55);flex:0 0 auto}
.right{display:grid;place-items:center;padding:40px 24px;min-width:0}.box{width:min(460px,100%);background:rgba(13,22,40,.82);border:1px solid var(--border);border-radius:24px;padding:clamp(24px,4vw,34px);box-shadow:0 40px 100px rgba(0,0,0,.35);backdrop-filter:blur(16px);overflow:hidden}.back{display:inline-flex;color:var(--muted);font-size:14px;margin-bottom:28px}.back:hover{color:var(--text)}.tabs{display:flex;background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:12px;padding:4px;margin-bottom:30px}.tab{flex:1;text-align:center;padding:11px;border-radius:9px;color:var(--muted);font-weight:800;font-size:14px;min-width:0}.tab.active{background:var(--grad);color:#060b18}.form-title{font-size:32px;letter-spacing:-.02em;margin-bottom:8px;overflow-wrap:anywhere}.form-sub{color:var(--muted);font-size:15px;margin-bottom:24px;overflow-wrap:anywhere}.field{margin-bottom:17px}.field label{display:block;color:var(--muted);font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.12em;margin-bottom:8px}.field input{width:100%;min-height:50px;background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:12px;padding:15px 16px;color:var(--text);font:500 15px 'DM Sans';outline:none}.field input:focus{border-color:rgba(0,229,160,.55);box-shadow:0 0 0 4px rgba(0,229,160,.08)}.btn{width:100%;min-height:50px;border:0;border-radius:12px;background:var(--grad);color:#060b18;padding:16px;font-weight:800;font-size:16px;cursor:pointer;box-shadow:0 0 36px rgba(0,229,160,.25);transition:.22s}.btn:hover{transform:translateY(-2px)}.alert{padding:13px 15px;border-radius:12px;margin-bottom:18px;font-size:14px;overflow-wrap:anywhere}.error{background:rgba(255,107,107,.1);border:1px solid rgba(255,107,107,.25);color:#ffb1b1}.success{background:rgba(0,229,160,.1);border:1px solid rgba(0,229,160,.25);color:var(--accent)}.switch{text-align:center;color:var(--muted);font-size:14px;margin-top:22px}.switch a{color:var(--accent);font-weight:800}
@media(max-width:820px){.page{grid-template-columns:1fr}.left{display:none}.right{min-height:100vh}.box{padding:26px}}
</style>
</head>
<body>
<div class="atmo"></div><div class="stars"></div>
<main class="page">
  <section class="left">
    <a href="<?= url() ?>" class="logo"><div class="logo-icon">E</div><span class="logo-text">Estudai</span></a>
    <div>
      <h1><?= $tab === 'register' ? 'Comece sua jornada no <em>Estudai.</em>' : 'Continue de onde voce <em>parou.</em>' ?></h1>
      <p>Entre direto no sistema para fazer simulados, acompanhar XP, ver seus pontos fracos e transformar erro em rota de estudo.</p>
    </div>
    <div class="feature-list">
      <div class="feature"><span class="dot"></span><div><b>Acesso direto:</b> cadastro criado, dashboard liberado.</div></div>
      <div class="feature"><span class="dot"></span><div><b>Diagnostico real:</b> desempenho por materia e recomendacao diaria.</div></div>
      <div class="feature"><span class="dot"></span><div><b>Gamificacao:</b> XP, streaks e conquistas para manter ritmo.</div></div>
    </div>
  </section>

  <section class="right">
    <div class="box">
      <a href="<?= url() ?>" class="back">Voltar ao inicio</a>
      <div class="tabs">
        <a href="<?= url('login?tab=login') ?>" class="tab <?= $tab === 'login' ? 'active' : '' ?>">Entrar</a>
        <a href="<?= url('login?tab=register') ?>" class="tab <?= $tab === 'register' ? 'active' : '' ?>">Criar conta</a>
      </div>
      <?php if ($erro): ?><div class="alert error"><?= e($erro) ?></div><?php endif; ?>
      <?php if ($ok): ?><div class="alert success"><?= e($ok) ?></div><?php endif; ?>

      <?php if ($tab === 'login'): ?>
        <h2 class="form-title">Bem-vindo de volta</h2>
        <p class="form-sub">Acesse seu dashboard e continue evoluindo.</p>
        <form action="<?= url('login') ?>" method="POST">
          <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
          <div class="field"><label>E-mail</label><input type="email" name="email" placeholder="seu@email.com" value="<?= e($_POST['email'] ?? '') ?>" required autofocus></div>
          <div class="field"><label>Senha</label><input type="password" name="senha" placeholder="Sua senha" required></div>
          <button class="btn" type="submit">Entrar</button>
        </form>
        <div class="switch">Nao tem conta? <a href="<?= url('login?tab=register') ?>">Criar gratuitamente</a></div>
      <?php else: ?>
        <h2 class="form-title">Criar conta gratis</h2>
        <p class="form-sub">Sem confirmacao manual. Voce entra e ja pode estudar.</p>
        <form action="<?= url('register') ?>" method="POST">
          <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
          <div class="field"><label>Nome completo</label><input type="text" name="nome" placeholder="Joao Silva" value="<?= e($_POST['nome'] ?? '') ?>" required autofocus></div>
          <div class="field"><label>E-mail</label><input type="email" name="email" placeholder="seu@email.com" value="<?= e($_POST['email'] ?? '') ?>" required></div>
          <div class="field"><label>Senha</label><input type="password" name="senha" placeholder="Minimo 6 caracteres" required></div>
          <div class="field"><label>Confirmar senha</label><input type="password" name="confirmar" placeholder="Repita a senha" required></div>
          <button class="btn" type="submit">Criar conta</button>
        </form>
        <div class="switch">Ja tem conta? <a href="<?= url('login') ?>">Fazer login</a></div>
      <?php endif; ?>
    </div>
  </section>
</main>
</body>
</html>
