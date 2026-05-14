<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(APP_NAME) ?> - Oficina de Redação</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
<style>
:root{--bg:#060b18;--card:#0d1628;--card2:#111e38;--accent:#00e5a0;--accent2:#00b8ff;--warn:#ffd166;--danger:#ff6b6b;--text:#eef2ff;--muted:#6b7ba8;--border:rgba(255,255,255,.08);--grad:linear-gradient(135deg,#00e5a0,#00b8ff)}
*{box-sizing:border-box;margin:0;padding:0}
body{min-height:100vh;background:var(--bg);color:var(--text);font-family:'DM Sans',sans-serif;line-height:1.6;padding:28px}
h1,h2,h3,.logo-text,.btn,.metric strong{font-family:'Syne',sans-serif}
a{text-decoration:none;color:inherit}
.atmo{position:fixed;inset:0;pointer-events:none;background:radial-gradient(ellipse 900px 600px at -10% 10%,rgba(0,229,160,.06),transparent 65%),radial-gradient(ellipse 800px 560px at 110% 80%,rgba(0,184,255,.06),transparent 65%)}
.wrap{position:relative;max-width:1280px;margin:0 auto}
.top{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:30px}
.logo{display:flex;align-items:center;gap:10px;min-width:0}
.logo-icon{width:40px;height:40px;border-radius:11px;background:var(--grad);display:grid;place-items:center;font-weight:800;color:#060b18;flex:0 0 auto}
.logo-text{font-size:22px;font-weight:800;background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.top-actions{display:flex;gap:10px;flex-wrap:wrap;justify-content:flex-end}
.btn{display:inline-flex;align-items:center;justify-content:center;min-height:46px;border:0;border-radius:12px;background:var(--grad);color:#060b18;padding:13px 20px;font-weight:800;cursor:pointer;box-shadow:0 0 34px rgba(0,229,160,.2);text-align:center}
.ghost{background:rgba(255,255,255,.04);color:var(--text);border:1px solid var(--border);box-shadow:none}
.hero{background:linear-gradient(160deg,rgba(0,229,160,.08),rgba(0,184,255,.04));border:1px solid rgba(0,229,160,.18);border-radius:26px;padding:clamp(22px,4vw,34px);margin-bottom:20px;overflow:hidden}
h1{font-size:clamp(42px,7vw,74px);line-height:1;letter-spacing:-.03em;margin-bottom:12px}
.hero p,.muted{color:var(--muted);overflow-wrap:anywhere}
.metrics{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin-top:22px}
.metric{background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:16px;padding:16px}
.metric strong{display:block;font-size:28px;color:var(--accent)}
.grid{display:grid;grid-template-columns:minmax(0,1.05fr) minmax(340px,.95fr);gap:20px;align-items:start}
.panel{background:rgba(13,22,40,.88);border:1px solid var(--border);border-radius:22px;padding:clamp(18px,3vw,24px);overflow:hidden}
.panel-title{color:var(--muted);font-size:12px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;margin-bottom:14px;display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap}
.field{margin-bottom:16px}
.field label{display:block;color:var(--muted);font-weight:800;font-size:12px;text-transform:uppercase;letter-spacing:.12em;margin-bottom:8px}
input,textarea,select{width:100%;border:1px solid var(--border);border-radius:14px;background:#0b1426;color:var(--text);padding:14px;font:500 15px 'DM Sans';outline:none}
textarea{min-height:150px;resize:vertical;line-height:1.65}
textarea#texto{min-height:520px}
input:focus,textarea:focus,select:focus{border-color:rgba(0,229,160,.45);box-shadow:0 0 0 4px rgba(0,229,160,.08)}
.essay-tools{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;margin-bottom:16px}
.structure{display:grid;gap:10px}
.step{background:rgba(255,255,255,.035);border:1px solid var(--border);border-radius:16px;padding:14px}
.step strong{display:block;margin-bottom:4px}
.competencias{display:grid;gap:10px}
.comp{display:grid;grid-template-columns:auto minmax(0,1fr);gap:10px;border:1px solid var(--border);border-radius:15px;padding:13px;background:rgba(255,255,255,.035);cursor:pointer}
.comp input{width:auto;margin-top:4px;accent-color:var(--accent)}
.comp b{display:block}
.comp span{display:block;color:var(--muted);font-size:13px}
.progress{height:9px;background:rgba(255,255,255,.06);border-radius:10px;overflow:hidden;margin:12px 0 18px}
.progress div{height:100%;width:0;background:var(--grad);border-radius:10px;transition:.2s}
.chips{display:flex;gap:8px;flex-wrap:wrap;margin-top:12px}
.chip{border:1px solid var(--border);border-radius:999px;padding:6px 10px;color:var(--muted);font-size:12px}
.chip.ok{color:var(--accent);border-color:rgba(0,229,160,.35);background:rgba(0,229,160,.08)}
.tip{border-left:3px solid var(--warn);background:rgba(255,209,102,.08);border-radius:14px;padding:14px;margin-top:14px;color:#ffe6a3}
@media(max-width:940px){body{padding:18px}.grid{grid-template-columns:1fr}.top{display:block}.top-actions{justify-content:stretch;margin-top:14px}.top-actions .btn{flex:1}.essay-tools{grid-template-columns:1fr}textarea#texto{min-height:420px}}
@media(max-width:520px){body{padding:14px}.panel,.hero{border-radius:18px}.btn{width:100%}}
</style>
</head>
<body>
<div class="atmo"></div>
<main class="wrap">
  <div class="top">
    <a class="logo" href="<?= url('dashboard') ?>"><div class="logo-icon">E</div><span class="logo-text">Estudai</span></a>
    <div class="top-actions">
      <a class="btn ghost" href="<?= url('dashboard') ?>">Dashboard</a>
      <a class="btn ghost" href="<?= url('simulado') ?>">Simulado</a>
    </div>
  </div>

  <section class="hero">
    <h1>Oficina de redação</h1>
    <p>Planeje, escreva e revise sua redação no modelo ENEM com foco nas 5 competências. O rascunho fica salvo neste navegador enquanto você trabalha.</p>
    <div class="metrics">
      <div class="metric"><strong id="palavras">0</strong><span class="muted">palavras</span></div>
      <div class="metric"><strong id="linhas">0</strong><span class="muted">linhas estimadas</span></div>
      <div class="metric"><strong id="checkScore">0/5</strong><span class="muted">competências revisadas</span></div>
    </div>
  </section>

  <section class="grid">
    <div class="panel">
      <div class="panel-title">Produção textual <span>modelo ENEM</span></div>
      <div class="essay-tools">
        <div class="field">
          <label>Tema</label>
          <input id="tema" type="text" value="Desafios para a democratização do acesso à educação de qualidade no Brasil">
        </div>
        <div class="field">
          <label>Área de repertório</label>
          <select id="repertorio">
            <option>Educação</option>
            <option>Tecnologia</option>
            <option>Cidadania</option>
            <option>Meio ambiente</option>
            <option>Saúde pública</option>
            <option>Cultura e sociedade</option>
          </select>
        </div>
      </div>
      <div class="field">
        <label>Rascunho</label>
        <textarea id="texto" placeholder="Escreva sua redação aqui. Pense em introdução, dois desenvolvimentos e conclusão com proposta de intervenção."></textarea>
      </div>
      <div class="chips">
        <span class="chip" id="chipMin">Meta: 250+ palavras</span>
        <span class="chip" id="chipIntervencao">Proposta de intervenção</span>
        <span class="chip" id="chipConectivos">Conectivos</span>
      </div>
      <div class="tip">Dica rápida: uma boa conclusão ENEM explicita agente, ação, meio, finalidade e detalhamento.</div>
    </div>

    <aside class="panel">
      <div class="panel-title">Checklist de revisão</div>
      <div class="progress"><div id="progressBar"></div></div>
      <div class="competencias">
        <label class="comp"><input type="checkbox" class="check"><span><b>Competência 1</b><span>Domínio da norma-padrão e clareza gramatical.</span></span></label>
        <label class="comp"><input type="checkbox" class="check"><span><b>Competência 2</b><span>Compreensão do tema e uso produtivo de repertório sociocultural.</span></span></label>
        <label class="comp"><input type="checkbox" class="check"><span><b>Competência 3</b><span>Projeto de texto, argumentação e organização das ideias.</span></span></label>
        <label class="comp"><input type="checkbox" class="check"><span><b>Competência 4</b><span>Coesão, conectivos e encadeamento entre períodos e parágrafos.</span></span></label>
        <label class="comp"><input type="checkbox" class="check"><span><b>Competência 5</b><span>Proposta de intervenção completa, respeitando direitos humanos.</span></span></label>
      </div>

      <div class="panel-title" style="margin-top:24px">Estrutura sugerida</div>
      <div class="structure">
        <div class="step"><strong>Introdução</strong><span class="muted">Contextualize o problema, delimite o tema e apresente a tese.</span></div>
        <div class="step"><strong>Desenvolvimento 1</strong><span class="muted">Defenda a primeira causa ou consequência com repertório.</span></div>
        <div class="step"><strong>Desenvolvimento 2</strong><span class="muted">Aprofunde outro eixo argumentativo e conecte com a tese.</span></div>
        <div class="step"><strong>Conclusão</strong><span class="muted">Construa uma intervenção concreta com agente, ação, meio e finalidade.</span></div>
      </div>
    </aside>
  </section>
</main>

<script>
const fields = ['tema', 'repertorio', 'texto'];
const checks = [...document.querySelectorAll('.check')];
const texto = document.getElementById('texto');
const palavras = document.getElementById('palavras');
const linhas = document.getElementById('linhas');
const checkScore = document.getElementById('checkScore');
const progressBar = document.getElementById('progressBar');
const chipMin = document.getElementById('chipMin');
const chipIntervencao = document.getElementById('chipIntervencao');
const chipConectivos = document.getElementById('chipConectivos');
const storageKey = 'estudai.redacao.oficina';

function restore() {
  const saved = JSON.parse(localStorage.getItem(storageKey) || '{}');
  fields.forEach(id => {
    if (saved[id]) document.getElementById(id).value = saved[id];
  });
  checks.forEach((check, index) => check.checked = Boolean(saved.checks?.[index]));
}

function save() {
  localStorage.setItem(storageKey, JSON.stringify({
    tema: document.getElementById('tema').value,
    repertorio: document.getElementById('repertorio').value,
    texto: texto.value,
    checks: checks.map(check => check.checked)
  }));
}

function update() {
  const raw = texto.value.trim();
  const words = raw ? raw.split(/\s+/).filter(Boolean).length : 0;
  const lineCount = raw ? Math.max(1, Math.ceil(words / 10)) : 0;
  const checked = checks.filter(check => check.checked).length;
  const lower = raw.toLowerCase();

  palavras.textContent = words;
  linhas.textContent = lineCount;
  checkScore.textContent = `${checked}/5`;
  progressBar.style.width = `${checked * 20}%`;
  chipMin.classList.toggle('ok', words >= 250);
  chipIntervencao.classList.toggle('ok', /(governo|estado|escola|ministério|sociedade|família|mídia).*(deve|precisa|pode|promover|garantir|realizar)/i.test(raw));
  chipConectivos.classList.toggle('ok', ['portanto', 'ademais', 'além disso', 'entretanto', 'desse modo', 'sob essa perspectiva'].some(term => lower.includes(term)));
  save();
}

restore();
fields.forEach(id => document.getElementById(id).addEventListener('input', update));
checks.forEach(check => check.addEventListener('change', update));
update();
</script>
</body>
</html>
