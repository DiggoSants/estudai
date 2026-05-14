<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(APP_NAME) ?> — Plataforma Inteligente de Estudo</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Syne:wght@400;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--bg:#09090f;--surface:#111120;--card:#15152a;--gold:#e8c547;--violet:#6b4de6;--coral:#e85d4a;--mint:#4ab89a;--sky:#4a90d9;--text:#e8e8f0;--muted:#6b6b8a;--border:#1e1e38}
html{scroll-behavior:smooth}body{font-family:'Syne',sans-serif;background:var(--bg);color:var(--text);overflow-x:hidden}
body::after{content:'';position:fixed;inset:0;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.05'/%3E%3C/svg%3E");pointer-events:none;z-index:999}
a{color:inherit;text-decoration:none}nav{position:fixed;top:0;left:0;right:0;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:20px 40px;background:rgba(9,9,15,.85);backdrop-filter:blur(12px);border-bottom:1px solid var(--border)}
.nav-logo,.footer-logo{font-family:'Bebas Neue';letter-spacing:2px;color:var(--gold)}.nav-logo{font-size:28px}.nav-logo span{color:var(--text)}.nav-links{display:flex;align-items:center;gap:32px}.nav-links a{color:var(--muted);font-size:14px;font-weight:700}.nav-links a:hover{color:var(--text)}.btn-nav{background:var(--violet);color:#fff!important;padding:10px 24px;border-radius:6px;border:1px solid transparent}.btn-nav:hover{background:transparent;color:var(--violet)!important;border-color:var(--violet)}
.hero{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:100px 40px 60px;position:relative;overflow:hidden}.hero-bg{position:absolute;inset:0;background:radial-gradient(ellipse 80% 60% at 50% 40%,rgba(107,77,230,.18),transparent 70%),radial-gradient(ellipse 50% 40% at 80% 80%,rgba(232,197,71,.08),transparent 60%)}
.hero-inner{max-width:920px;text-align:center;position:relative;z-index:2}.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(107,77,230,.2);border:1px solid rgba(107,77,230,.4);border-radius:20px;padding:6px 16px;font-size:12px;font-family:'DM Mono';letter-spacing:1.5px;text-transform:uppercase;color:var(--violet);margin-bottom:28px}.hero-badge span{width:6px;height:6px;border-radius:50%;background:var(--violet);animation:pulse 1.5s infinite}@keyframes pulse{0%,100%{opacity:1}50%{opacity:.3}}
.hero h1{font-family:'Bebas Neue';font-size:clamp(60px,11vw,130px);line-height:.95;letter-spacing:2px;margin-bottom:24px}.hero h1 .accent{color:var(--gold);display:block}.hero p{font-size:clamp(16px,2vw,20px);color:var(--muted);max-width:580px;margin:0 auto 40px;line-height:1.7}
.hero-cta{display:flex;gap:16px;justify-content:center;flex-wrap:wrap}.btn-primary{background:var(--gold);color:#09090f;padding:16px 40px;border-radius:8px;font-weight:800;font-size:15px;transition:all .25s;display:inline-flex;align-items:center;gap:8px}.btn-primary:hover{transform:translateY(-3px);box-shadow:0 16px 40px rgba(232,197,71,.3)}.btn-secondary{background:transparent;color:var(--text);padding:16px 40px;border-radius:8px;font-weight:700;border:1.5px solid var(--border);transition:all .25s}.btn-secondary:hover{border-color:var(--text);transform:translateY(-3px)}
.hero-stats{display:flex;gap:48px;justify-content:center;margin-top:64px;padding-top:40px;border-top:1px solid var(--border)}.stat-item{text-align:center}.stat-num{font-family:'Bebas Neue';font-size:42px;letter-spacing:2px;color:var(--gold);display:block}.stat-label{font-size:12px;color:var(--muted);letter-spacing:1.5px;text-transform:uppercase}
.section{padding:100px 40px;max-width:1200px;margin:0 auto}.section-label{font-family:'DM Mono';font-size:11px;letter-spacing:3px;text-transform:uppercase;color:var(--violet);margin-bottom:12px}.section-title{font-family:'Bebas Neue';font-size:clamp(40px,6vw,72px);letter-spacing:2px;line-height:1;margin-bottom:16px}.section-sub{color:var(--muted);max-width:520px;font-size:16px;line-height:1.7;margin-bottom:60px}
.features-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}.feat-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:32px;transition:border-color .3s,transform .3s}.feat-card:hover{border-color:var(--violet);transform:translateY(-4px)}.feat-icon{font-size:36px;margin-bottom:20px;display:block}.feat-card h3{font-size:18px;margin-bottom:10px}.feat-card p{color:var(--muted);font-size:14px;line-height:1.7}.feat-tag{display:inline-block;margin-top:16px;background:rgba(107,77,230,.15);color:var(--violet);border-radius:4px;padding:3px 10px;font-size:11px;font-family:'DM Mono';letter-spacing:1px}
.steps{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:60px}.step{text-align:center;padding:0 20px}.step-num{width:72px;height:72px;border-radius:50%;background:var(--card);border:2px solid var(--border);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-family:'Bebas Neue';font-size:28px;color:var(--gold)}.step h4{font-size:15px;margin-bottom:8px}.step p{color:var(--muted);font-size:13px;line-height:1.6}
.ai-section{padding:100px 40px;background:var(--surface);border-top:1px solid var(--border);border-bottom:1px solid var(--border)}.ai-inner{max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}.ai-mock{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:28px}.ai-mock-header{display:flex;align-items:center;gap:10px;margin-bottom:24px;padding-bottom:16px;border-bottom:1px solid var(--border)}.ai-dot{width:10px;height:10px;border-radius:50%}.ai-mock-body{display:flex;flex-direction:column;gap:12px}.ai-msg{padding:12px 16px;border-radius:8px;font-size:13px;line-height:1.6;max-width:85%}.ai-msg.ai{background:rgba(107,77,230,.15);border:1px solid rgba(107,77,230,.2);align-self:flex-start}.ai-msg.user{background:rgba(74,184,154,.1);border:1px solid rgba(74,184,154,.2);align-self:flex-end}.ai-typing{display:flex;gap:4px;padding:12px 16px}.ai-typing span{width:6px;height:6px;border-radius:50%;background:var(--muted);animation:typing .8s ease-in-out infinite alternate}.ai-typing span:nth-child(2){animation-delay:.15s}.ai-typing span:nth-child(3){animation-delay:.3s}@keyframes typing{from{opacity:.2;transform:translateY(0)}to{opacity:1;transform:translateY(-4px)}}
.cta-section{padding:120px 40px;text-align:center}.cta-section h2{font-family:'Bebas Neue';font-size:clamp(48px,8vw,96px);letter-spacing:2px;line-height:1;margin-bottom:24px}.cta-section p{color:var(--muted);font-size:18px;margin-bottom:48px}footer{background:var(--surface);border-top:1px solid var(--border);padding:40px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px}footer p{color:var(--muted);font-size:13px}.footer-logo{font-size:24px}
.reveal{opacity:0;transform:translateY(30px);transition:opacity .7s ease,transform .7s ease}.reveal.visible{opacity:1;transform:translateY(0)}
@media(max-width:900px){nav{padding:16px 20px}.nav-links a:not(.btn-nav){display:none}.hero-stats,.features-grid,.steps,.ai-inner{grid-template-columns:1fr}.hero-stats{display:grid;gap:20px}.section,.ai-section{padding:72px 20px}}
</style>
</head>
<body>
<nav>
  <a href="<?= url() ?>" class="nav-logo">Estud<span>ai</span></a>
  <div class="nav-links">
    <a href="#features">Recursos</a>
    <a href="#como-funciona">Como funciona</a>
    <a href="#ia">IA Inteligente</a>
    <a href="<?= url('login') ?>" class="btn-nav">Entrar</a>
  </div>
</nav>

<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-inner">
    <div class="hero-badge"><span></span> Plataforma com IA para vestibular</div>
    <h1>Estude Menos.<br><span class="accent">Acerte Mais.</span></h1>
    <p>A Estudai analisa seus erros e entrega exatamente o conteúdo que você precisa estudar, funcionando como um mapa inteligente do seu aprendizado.</p>
    <div class="hero-cta">
      <a href="<?= url('login?tab=register') ?>" class="btn-primary">✦ Começar Grátis</a>
      <a href="#como-funciona" class="btn-secondary">Ver como funciona</a>
    </div>
    <div class="hero-stats">
      <div class="stat-item"><span class="stat-num">100+</span><span class="stat-label">Questões</span></div>
      <div class="stat-item"><span class="stat-num">10</span><span class="stat-label">Matérias</span></div>
      <div class="stat-item"><span class="stat-num">IA</span><span class="stat-label">Adaptativa</span></div>
      <div class="stat-item"><span class="stat-num">7</span><span class="stat-label">Níveis de XP</span></div>
    </div>
  </div>
</section>

<div class="section" id="features">
  <p class="section-label reveal">Por que a Estudai?</p>
  <h2 class="section-title reveal">Recursos que<br>fazem a diferença</h2>
  <p class="section-sub reveal">Cada funcionalidade foi pensada para maximizar seu desempenho no vestibular sem desperdiçar tempo.</p>
  <div class="features-grid">
    <div class="feat-card reveal"><span class="feat-icon">🎯</span><h3>Estudo Direcionado por IA</h3><p>Após cada simulado, a IA analisa seu desempenho e recomenda exatamente os tópicos que você precisa revisar.</p><span class="feat-tag">IA Adaptativa</span></div>
    <div class="feat-card reveal"><span class="feat-icon">📊</span><h3>Dashboard de Desempenho</h3><p>Visualize sua evolução em cada matéria, compare simulados e identifique padrões de erro.</p><span class="feat-tag">Analytics</span></div>
    <div class="feat-card reveal"><span class="feat-icon">🔥</span><h3>Sistema de XP e Níveis</h3><p>Ganhe experiência a cada simulado, suba de Calouro a Lendário e desbloqueie conquistas.</p><span class="feat-tag">Gamificação</span></div>
    <div class="feat-card reveal"><span class="feat-icon">⚡</span><h3>Streaks de Estudo</h3><p>Mantenha a sequência de dias estudados e ganhe bônus de XP por consistência.</p><span class="feat-tag">Hábito</span></div>
    <div class="feat-card reveal"><span class="feat-icon">🏆</span><h3>Conquistas e Badges</h3><p>Desbloqueie conquistas exclusivas conforme você evolui, com bônus de XP.</p><span class="feat-tag">Recompensas</span></div>
    <div class="feat-card reveal"><span class="feat-icon">⏱️</span><h3>Modo Cronômetro</h3><p>Simule a pressão real do vestibular com tempo ativo e bônus por velocidade.</p><span class="feat-tag">Realismo</span></div>
  </div>
</div>

<div class="section" id="como-funciona">
  <p class="section-label reveal">Simples e eficaz</p>
  <h2 class="section-title reveal">4 passos para<br>sua aprovação</h2>
  <div class="steps">
    <div class="step reveal"><div class="step-num">01</div><h4>Crie sua conta</h4><p>Registro gratuito em menos de 1 minuto.</p></div>
    <div class="step reveal"><div class="step-num">02</div><h4>Faça um simulado</h4><p>Escolha matérias e quantidade de questões.</p></div>
    <div class="step reveal"><div class="step-num">03</div><h4>Veja sua análise</h4><p>A IA mapeia pontos fracos e prioridades.</p></div>
    <div class="step reveal"><div class="step-num">04</div><h4>Evolua todo dia</h4><p>Acompanhe XP, streaks e conquistas.</p></div>
  </div>
</div>

<section class="ai-section" id="ia">
  <div class="ai-inner">
    <div class="reveal">
      <p class="section-label">Inteligência Artificial</p>
      <h2 class="section-title">Sua IA de<br>estudos pessoal</h2>
      <p style="color:var(--muted);font-size:16px;line-height:1.8;margin-bottom:24px">Após cada simulado, a IA analisa padrões de erro, identifica tópicos críticos e gera um plano de revisão personalizado.</p>
    </div>
    <div class="ai-mock reveal">
      <div class="ai-mock-header"><div class="ai-dot" style="background:#e85d4a"></div><div class="ai-dot" style="background:#e8c547"></div><div class="ai-dot" style="background:#4ab89a"></div><span style="font-family:'DM Mono';font-size:12px;color:var(--muted);margin-left:8px">estudai · analise-ia</span></div>
      <div class="ai-mock-body">
        <div class="ai-msg ai">🎯 Analisei seu simulado. Você acertou <strong>7/10</strong> questões.</div>
        <div class="ai-msg user">O que eu devo estudar agora?</div>
        <div class="ai-msg ai">📊 Recomendo focar em <strong>funções quadráticas</strong> hoje, onde você perdeu mais pontos.</div>
        <div class="ai-typing"><span></span><span></span><span></span></div>
      </div>
    </div>
  </div>
</section>

<section class="cta-section">
  <h2 class="reveal">Pronto para<br><span style="color:var(--gold)">ser aprovado?</span></h2>
  <p class="reveal">Transforme sua forma de estudar com simulados, análise e progresso visível.</p>
  <a href="<?= url('login?tab=register') ?>" class="btn-primary reveal" style="font-size:18px;padding:20px 56px">✦ Criar conta grátis</a>
</section>

<footer>
  <span class="footer-logo">Estudai</span>
  <p>© <?= date('Y') ?> Estudai · Plataforma Inteligente de Estudo para Vestibular</p>
  <p>ENEM · FUVEST · UNICAMP · ITA</p>
</footer>
<script>
const obs=new IntersectionObserver((entries)=>{entries.forEach((e,i)=>{if(e.isIntersecting){setTimeout(()=>e.target.classList.add('visible'),i*80);obs.unobserve(e.target)}})},{threshold:.1});
document.querySelectorAll('.reveal').forEach(el=>obs.observe(el));
</script>
</body>
</html>
