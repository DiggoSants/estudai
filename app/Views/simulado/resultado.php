<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(APP_NAME) ?> - Resultado</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
<style>
:root{--bg:#060b18;--card:#0d1628;--accent:#00e5a0;--danger:#ff6b6b;--text:#eef2ff;--muted:#6b7ba8;--border:rgba(255,255,255,.08);--grad:linear-gradient(135deg,#00e5a0,#00b8ff)}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--bg);color:var(--text);font-family:'DM Sans',sans-serif;padding:28px}
h1,h2,.value,.btn{font-family:'Syne',sans-serif}
a{text-decoration:none;color:inherit}
.wrap{max-width:980px;margin:0 auto}
.hero{background:linear-gradient(160deg,rgba(0,229,160,.08),rgba(0,184,255,.04));border:1px solid rgba(0,229,160,.18);border-radius:24px;padding:clamp(22px,4vw,28px);margin-bottom:22px;overflow:hidden}
h1{font-size:clamp(40px,7vw,72px);line-height:1;margin-bottom:12px}
.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:14px;margin-top:20px}
.stat{background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:16px;padding:18px;min-width:0}
.value{display:block;font-size:clamp(30px,6vw,38px);background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent;overflow-wrap:anywhere}
.muted{color:var(--muted);overflow-wrap:anywhere}
.btns{display:flex;gap:12px;flex-wrap:wrap;margin-top:22px}
.btn{border-radius:12px;background:var(--grad);color:#060b18;padding:14px 22px;font-weight:800;text-align:center}
.ghost{background:rgba(255,255,255,.04);color:var(--text);border:1px solid var(--border)}
.question{background:rgba(13,22,40,.88);border:1px solid var(--border);border-radius:20px;padding:clamp(18px,3vw,22px);margin:14px 0;overflow:hidden}
.question p,.exp{overflow-wrap:anywhere}
.ok{color:var(--accent)}
.bad{color:var(--danger)}
.exp{margin-top:12px;color:var(--muted);line-height:1.65}
@media(max-width:520px){body{padding:16px}.hero{border-radius:18px}.btn{width:100%}}
</style>
</head>
<body>
<main class="wrap">
  <?php $total = max(1, (int) $simulado['total']); $pct = round((int) $simulado['acertos'] / $total * 100); ?>
  <section class="hero">
    <h1>Resultado: <?= $pct ?>%</h1>
    <p class="muted">Seu desempenho ja foi registrado no dashboard e usado para atualizar a rota individual de estudos.</p>
    <div class="stats">
      <div class="stat"><span class="value"><?= (int) $simulado['acertos'] ?>/<?= (int) $simulado['total'] ?></span><span class="muted">acertos</span></div>
      <div class="stat"><span class="value">+<?= (int) $simulado['xp_ganho'] ?></span><span class="muted">XP ganho</span></div>
      <div class="stat"><span class="value"><?= floor((int) $simulado['tempo_gasto'] / 60) ?>m</span><span class="muted">tempo gasto</span></div>
    </div>
    <div class="btns"><a class="btn" href="<?= url('dashboard') ?>">Ver rota no dashboard</a><a class="btn ghost" href="<?= url('simulado') ?>">Novo simulado</a></div>
  </section>

  <?php foreach ($questoes as $index => $questao): $certa = (int) $questao['correta'] === 1; ?>
    <section class="question">
      <h2><?= $index + 1 ?>. <?= e($questao['materia_nome']) ?> <span class="<?= $certa ? 'ok' : 'bad' ?>"><?= $certa ? 'correta' : 'revisar' ?></span></h2>
      <p><?= e($questao['enunciado']) ?></p>
      <p class="muted">Sua resposta: <?= e(strtoupper((string) ($questao['resposta'] ?? '-'))) ?> | Gabarito: <?= e(strtoupper((string) $questao['gabarito'])) ?></p>
      <?php if ($questao['explicacao']): ?><div class="exp"><?= e($questao['explicacao']) ?></div><?php endif; ?>
    </section>
  <?php endforeach; ?>
</main>
</body>
</html>
