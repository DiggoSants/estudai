<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(APP_NAME) ?> - Novo Simulado</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
<style>
:root{--bg:#060b18;--card:#0d1628;--accent:#00e5a0;--accent2:#00b8ff;--danger:#ff6b6b;--text:#eef2ff;--muted:#6b7ba8;--border:rgba(255,255,255,.08);--grad:linear-gradient(135deg,#00e5a0,#00b8ff)}
*{box-sizing:border-box;margin:0;padding:0}
body{min-height:100vh;background:var(--bg);color:var(--text);font-family:'DM Sans',sans-serif;padding:32px}
h1,h2,.logo-text,.btn{font-family:'Syne',sans-serif}
a{text-decoration:none;color:inherit}
.atmo{position:fixed;inset:0;pointer-events:none;background:radial-gradient(ellipse 900px 600px at -10% 10%,rgba(0,229,160,.065),transparent 65%),radial-gradient(ellipse 800px 560px at 110% 80%,rgba(0,184,255,.065),transparent 65%)}
.wrap{position:relative;max-width:1080px;margin:0 auto}
.top{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:34px}
.logo{display:flex;align-items:center;gap:10px;min-width:0}
.logo-icon{width:40px;height:40px;border-radius:11px;background:var(--grad);display:grid;place-items:center;font-weight:800;color:#060b18;flex:0 0 auto}
.logo-text{font-size:22px;font-weight:800;background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.panel{background:rgba(13,22,40,.88);border:1px solid var(--border);border-radius:24px;padding:clamp(22px,4vw,34px);box-shadow:0 40px 100px rgba(0,0,0,.25);overflow:hidden}
h1{font-size:clamp(42px,7vw,72px);line-height:1;letter-spacing:-.03em;margin-bottom:12px}
p{color:var(--muted);line-height:1.7;overflow-wrap:anywhere}
.sub{max-width:680px;margin-bottom:28px}
.grid{display:grid;grid-template-columns:minmax(0,1.1fr) minmax(280px,.9fr);gap:24px;align-items:start}
.materias{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:10px;margin-top:18px}
.materia{display:flex;align-items:flex-start;gap:10px;min-height:72px;border:1px solid var(--border);border-radius:14px;padding:12px;background:rgba(255,255,255,.035);cursor:pointer;overflow:hidden}
.materia input{accent-color:var(--accent);margin-top:4px;flex:0 0 auto}
.materia span{min-width:0}
.materia strong{display:block;overflow-wrap:anywhere}
.materia small{color:var(--muted);display:block}
.field{margin-bottom:18px}
.field label{display:block;font-weight:800;color:var(--muted);font-size:12px;text-transform:uppercase;letter-spacing:.12em;margin-bottom:8px}
.field select,.field input{width:100%;min-height:48px;border:1px solid var(--border);border-radius:12px;background:#0b1426;color:var(--text);padding:14px;font:500 15px 'DM Sans';outline:none}
.field select:focus,.field input:focus{border-color:rgba(0,229,160,.45);box-shadow:0 0 0 4px rgba(0,229,160,.08)}
.field option{background:#0b1426;color:var(--text)}
.btn{display:inline-flex;justify-content:center;align-items:center;min-height:48px;border:0;border-radius:12px;background:var(--grad);color:#060b18;padding:15px 24px;font-weight:800;cursor:pointer;box-shadow:0 0 34px rgba(0,229,160,.22);text-align:center}
.ghost{background:rgba(255,255,255,.04);color:var(--text);border:1px solid var(--border);box-shadow:none}
.hint{background:linear-gradient(160deg,rgba(0,229,160,.08),rgba(0,184,255,.04));border:1px solid rgba(0,229,160,.16);border-radius:18px;padding:18px;margin-bottom:16px}
.error,.notice{border-radius:14px;padding:13px;margin-bottom:18px;line-height:1.55}
.error{background:rgba(255,107,107,.1);border:1px solid rgba(255,107,107,.28);color:#ffb1b1}
.notice{background:rgba(0,184,255,.1);border:1px solid rgba(0,184,255,.28);color:#a7e9ff}
@media(max-width:860px){body{padding:20px}.grid{grid-template-columns:1fr}.top{display:block}.top .btn{margin-top:14px;width:100%}}
@media(max-width:520px){body{padding:14px}.panel{border-radius:18px}.materias{grid-template-columns:1fr}.btn{width:100%}}
</style>
</head>
<body>
<div class="atmo"></div>
<main class="wrap">
  <div class="top">
    <a class="logo" href="<?= url('dashboard') ?>"><div class="logo-icon">E</div><span class="logo-text">Estudai</span></a>
    <a class="btn ghost" href="<?= url('dashboard') ?>">Voltar ao dashboard</a>
  </div>

  <section class="panel">
    <h1>Novo simulado</h1>
    <p class="sub">Monte um diagnóstico rápido. Ao finalizar, o Estudai calcula XP, registra seu histórico e atualiza a rota individual de estudos.</p>

    <?php if ($erro): ?><div class="error"><?= e($erro) ?></div><?php endif; ?>
    <?php if ($aviso): ?><div class="notice"><?= e($aviso) ?></div><?php endif; ?>
    <?php if ((int) $totalQuestoes === 0): ?>
      <div class="error">Ainda não existem questões no banco. Rode <strong>composer run migrate</strong> para importar o seed inicial.</div>
    <?php endif; ?>

    <form action="<?= url('simulado/iniciar') ?>" method="POST" class="grid">
      <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
      <div>
        <h2>Matérias</h2>
        <p>Selecione uma ou mais. Se não escolher nenhuma, o simulado mistura tudo.</p>
        <div class="materias">
          <?php foreach ($materias as $materia): ?>
            <label class="materia">
              <input type="checkbox" name="materias[]" value="<?= (int) $materia['id'] ?>" <?= (int) $materia['total_questoes'] === 0 ? 'disabled' : '' ?>>
              <span><strong><?= e($materia['icone']) ?> <?= e($materia['nome']) ?></strong><small><?= (int) $materia['total_questoes'] ?> questões</small></span>
            </label>
          <?php endforeach; ?>
        </div>
      </div>
      <aside>
        <div class="hint"><strong>IA de rota</strong><p>Depois do simulado, a recomendação diária usa seus erros por matéria para sugerir o próximo bloco de estudo.</p></div>
        <div class="field"><label>Dificuldade</label><select name="dificuldade"><option value="todas" selected>Todas</option><option value="facil">Fácil</option><option value="medio">Médio</option><option value="dificil">Difícil</option></select></div>
        <div class="field"><label>Quantidade</label><input type="number" name="quantidade" min="3" max="20" value="10"></div>
        <button class="btn" type="submit" <?= (int) $totalQuestoes === 0 ? 'disabled' : '' ?>>Iniciar simulado</button>
      </aside>
    </form>
  </section>
</main>
</body>
</html>
