<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(APP_NAME) ?> — <?= $tab === 'register' ? 'Criar conta' : 'Entrar' ?></title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Syne:wght@400;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--bg:#09090f;--card:#111120;--gold:#e8c547;--violet:#6b4de6;--coral:#e85d4a;--mint:#4ab89a;--text:#e8e8f0;--muted:#6b6b8a;--border:#1e1e38;--input:#15152a}
body{font-family:'Syne',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex;flex-direction:column}
body::after{content:'';position:fixed;inset:0;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.05'/%3E%3C/svg%3E");pointer-events:none;z-index:999}
a{text-decoration:none}.page{flex:1;display:grid;grid-template-columns:1fr 1fr;min-height:100vh}
.left{background:var(--card);border-right:1px solid var(--border);padding:60px;display:flex;flex-direction:column;justify-content:space-between;position:relative;overflow:hidden}.left-bg{position:absolute;inset:0;background:radial-gradient(ellipse 80% 60% at 20% 60%,rgba(107,77,230,.2),transparent 70%)}.left-logo{font-family:'Bebas Neue';font-size:36px;letter-spacing:2px;color:var(--gold);position:relative;z-index:2}.left-hero{position:relative;z-index:2}.left-hero h2{font-family:'Bebas Neue';font-size:64px;letter-spacing:2px;line-height:.95;margin-bottom:20px}.left-hero h2 span{color:var(--gold)}.left-hero p{color:var(--muted);font-size:16px;line-height:1.7;max-width:380px}.left-features{display:flex;flex-direction:column;gap:16px;position:relative;z-index:2}.lf-item{display:flex;align-items:center;gap:12px;font-size:14px;color:var(--muted)}.lf-item span:first-child{font-size:20px}.lf-item strong{color:var(--text)}
.right{padding:60px;display:flex;align-items:center;justify-content:center}.auth-box{width:100%;max-width:440px}.auth-logo-mobile{font-family:'Bebas Neue';font-size:32px;letter-spacing:2px;color:var(--gold);display:none;margin-bottom:32px}.tabs{display:flex;background:var(--input);border:1px solid var(--border);border-radius:10px;padding:4px;margin-bottom:36px}.tab{flex:1;padding:10px;text-align:center;border-radius:7px;font-size:14px;font-weight:700;cursor:pointer;border:none;background:transparent;color:var(--muted);transition:all .2s;letter-spacing:.3px}.tab.active{background:var(--violet);color:#fff}
.form-title{font-family:'Bebas Neue';font-size:36px;letter-spacing:1px;margin-bottom:8px}.form-sub{color:var(--muted);font-size:14px;margin-bottom:28px}.field{margin-bottom:18px}.field label{display:block;font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:8px;font-family:'DM Mono'}.field input{width:100%;background:var(--input);border:1.5px solid var(--border);border-radius:8px;padding:14px 16px;color:var(--text);font-size:15px;font-family:'Syne',sans-serif;transition:border-color .2s,box-shadow .2s;outline:none}.field input:focus{border-color:var(--violet);box-shadow:0 0 0 3px rgba(107,77,230,.15)}.field input::placeholder{color:var(--muted)}
.btn-submit{width:100%;background:var(--gold);color:#09090f;border:none;border-radius:8px;padding:16px;font-size:16px;font-weight:800;font-family:'Syne',sans-serif;cursor:pointer;transition:all .25s;letter-spacing:.5px;margin-top:8px}.btn-submit:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(232,197,71,.25)}.alert{padding:14px 16px;border-radius:8px;font-size:14px;margin-bottom:20px;display:flex;align-items:center;gap:10px}.alert.error{background:rgba(232,93,74,.12);border:1px solid rgba(232,93,74,.3);color:#f0a090}.alert.success{background:rgba(74,184,154,.12);border:1px solid rgba(74,184,154,.3);color:#7be0c4}.switch-link{text-align:center;margin-top:24px;font-size:13px;color:var(--muted)}.switch-link a{color:var(--violet);font-weight:700}.back-link{display:inline-flex;align-items:center;gap:6px;color:var(--muted);font-size:13px;margin-bottom:32px;transition:color .2s}.back-link:hover{color:var(--text)}
@media(max-width:768px){.page{grid-template-columns:1fr}.left{display:none}.right{padding:32px 20px}.auth-logo-mobile{display:block}}
</style>
</head>
<body>
<div class="page">
  <div class="left">
    <div class="left-bg"></div>
    <a href="<?= url() ?>" class="left-logo">Estudai</a>
    <div class="left-hero">
      <h2>Sua jornada<br>começa <span>aqui.</span></h2>
      <p>Entre na plataforma que ajuda estudantes a conquistar aprovação com método, simulado e inteligência.</p>
    </div>
    <div class="left-features">
      <div class="lf-item"><span>🎯</span><div><strong>Estudo direcionado</strong> — só o que você precisa</div></div>
      <div class="lf-item"><span>🔥</span><div><strong>Streaks e XP</strong> — gamificação real</div></div>
      <div class="lf-item"><span>🤖</span><div><strong>IA que analisa</strong> — seus pontos fracos</div></div>
      <div class="lf-item"><span>🆓</span><div><strong>100% gratuito</strong> — comece agora</div></div>
    </div>
  </div>

  <div class="right">
    <div class="auth-box">
      <a href="<?= url() ?>" class="back-link">← Voltar ao início</a>
      <a href="<?= url() ?>" class="auth-logo-mobile">Estudai</a>

      <div class="tabs">
        <a href="<?= url('login?tab=login') ?>" class="tab <?= $tab === 'login' ? 'active' : '' ?>">Entrar</a>
        <a href="<?= url('login?tab=register') ?>" class="tab <?= $tab === 'register' ? 'active' : '' ?>">Criar conta</a>
      </div>

      <?php if ($erro): ?><div class="alert error">⚠ <?= e($erro) ?></div><?php endif; ?>
      <?php if ($ok): ?><div class="alert success">✓ <?= e($ok) ?></div><?php endif; ?>

      <?php if ($tab === 'login'): ?>
        <h2 class="form-title">Bem-vindo de volta!</h2>
        <p class="form-sub">Entre para continuar de onde parou.</p>
        <form action="<?= url('login') ?>" method="POST">
          <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
          <div class="field">
            <label>E-mail</label>
            <input type="email" name="email" placeholder="seu@email.com" value="<?= e($_POST['email'] ?? '') ?>" required autofocus>
          </div>
          <div class="field">
            <label>Senha</label>
            <input type="password" name="senha" placeholder="••••••••" required>
          </div>
          <button type="submit" class="btn-submit">Entrar →</button>
        </form>
        <div class="switch-link">Não tem conta? <a href="<?= url('login?tab=register') ?>">Criar gratuitamente</a></div>
      <?php else: ?>
        <h2 class="form-title">Criar sua conta</h2>
        <p class="form-sub">Grátis para sempre. Comece em 60 segundos.</p>
        <form action="<?= url('register') ?>" method="POST">
          <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
          <div class="field">
            <label>Nome completo</label>
            <input type="text" name="nome" placeholder="João Silva" value="<?= e($_POST['nome'] ?? '') ?>" required autofocus>
          </div>
          <div class="field">
            <label>E-mail</label>
            <input type="email" name="email" placeholder="seu@email.com" value="<?= e($_POST['email'] ?? '') ?>" required>
          </div>
          <div class="field">
            <label>Senha</label>
            <input type="password" name="senha" placeholder="Mínimo 6 caracteres" required>
          </div>
          <div class="field">
            <label>Confirmar senha</label>
            <input type="password" name="confirmar" placeholder="Repita a senha" required>
          </div>
          <button type="submit" class="btn-submit">Criar conta grátis ✦</button>
        </form>
        <div class="switch-link">Já tem conta? <a href="<?= url('login') ?>">Fazer login</a></div>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
