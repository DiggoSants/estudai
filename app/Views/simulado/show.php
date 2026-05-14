<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(APP_NAME) ?> - Responder Simulado</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
<style>
:root{--bg:#060b18;--card:#0d1628;--accent:#00e5a0;--accent2:#00b8ff;--text:#eef2ff;--muted:#6b7ba8;--border:rgba(255,255,255,.08);--grad:linear-gradient(135deg,#00e5a0,#00b8ff)}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--bg);color:var(--text);font-family:'DM Sans',sans-serif;padding:28px}
h1,h2,.btn,.tag{font-family:'Syne',sans-serif}
.wrap{max-width:980px;margin:0 auto}
.top{display:flex;justify-content:space-between;gap:18px;align-items:center;margin-bottom:26px}
.top a{color:var(--accent);text-decoration:none;font-weight:800}
h1{font-size:clamp(36px,6vw,62px);line-height:1;margin-bottom:8px}
.muted{color:var(--muted);overflow-wrap:anywhere}
.question{background:rgba(13,22,40,.88);border:1px solid var(--border);border-radius:22px;padding:clamp(18px,3vw,24px);margin:18px 0;overflow:hidden}
.tag{display:inline-flex;color:var(--accent);font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.12em;margin-bottom:12px;max-width:100%;overflow-wrap:anywhere}
.enunciado{font-size:18px;line-height:1.65;margin-bottom:18px;overflow-wrap:anywhere}
.opt{display:grid;grid-template-columns:auto 28px minmax(0,1fr);gap:10px;align-items:flex-start;border:1px solid var(--border);border-radius:14px;padding:13px;margin-top:10px;background:rgba(255,255,255,.035);cursor:pointer;min-height:54px}
.opt:hover{border-color:rgba(0,229,160,.35)}
.opt input{margin-top:4px;accent-color:var(--accent)}
.letter{font-weight:800;color:var(--accent);min-width:22px}
.opt span:last-child{overflow-wrap:anywhere}
.btn{border:0;border-radius:12px;background:var(--grad);color:#060b18;padding:16px 26px;font-weight:800;cursor:pointer;box-shadow:0 0 34px rgba(0,229,160,.22);font-size:16px;min-height:50px}
.notice{background:rgba(0,184,255,.1);border:1px solid rgba(0,184,255,.28);color:#a7e9ff;border-radius:14px;padding:13px;margin:18px 0;line-height:1.55}
.actions{position:sticky;bottom:0;background:linear-gradient(to top,var(--bg),rgba(6,11,24,.82));padding:22px 0;text-align:right}
@media(max-width:560px){body{padding:16px}.top{display:block}.btn{width:100%}.actions{text-align:stretch}.opt{grid-template-columns:auto 24px minmax(0,1fr)}}
</style>
</head>
<body>
<main class="wrap">
  <div class="top"><a href="<?= url('simulado') ?>">Novo simulado</a><span class="muted">Simulado #<?= (int) $simulado['id'] ?> - <?= count($questoes) ?> questões</span></div>
  <h1>Responda com calma.</h1>
  <p class="muted">Ao finalizar, seu resultado alimenta a rota individual de estudos.</p>
  <?php if ($aviso): ?><div class="notice"><?= e($aviso) ?></div><?php endif; ?>

  <form action="<?= url('simulado/' . (int) $simulado['id'] . '/finalizar') ?>" method="POST">
    <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
    <?php foreach ($questoes as $index => $questao): ?>
      <section class="question">
        <div class="tag"><?= e($questao['materia_icone']) ?> <?= e($questao['materia_nome']) ?> - <?= e($questao['dificuldade']) ?></div>
        <div class="enunciado"><strong><?= $index + 1 ?>.</strong> <?= e($questao['enunciado']) ?></div>
        <?php foreach (['a', 'b', 'c', 'd', 'e'] as $letra): $campo = 'alternativa_' . $letra; ?>
          <label class="opt">
            <input type="radio" name="respostas[<?= (int) $questao['id'] ?>]" value="<?= $letra ?>" required>
            <span class="letter"><?= strtoupper($letra) ?></span>
            <span><?= e($questao[$campo]) ?></span>
          </label>
        <?php endforeach; ?>
      </section>
    <?php endforeach; ?>
    <div class="actions"><button class="btn" type="submit">Finalizar e ver resultado</button></div>
  </form>
</main>
</body>
</html>
