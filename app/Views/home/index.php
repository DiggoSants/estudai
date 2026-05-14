<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(APP_NAME) ?> - Sua direção de estudo inteligente</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
<style>
:root{--bg:#060b18;--bg2:#080e1c;--card:#0d1628;--card2:#111e38;--accent:#00e5a0;--accent2:#00b8ff;--danger:#ff6b6b;--text:#eef2ff;--muted:#6b7ba8;--border:rgba(255,255,255,.08);--grad:linear-gradient(135deg,#00e5a0,#00b8ff)}
*{box-sizing:border-box;margin:0;padding:0}html{scroll-behavior:smooth}body{background:var(--bg);color:var(--text);font-family:'DM Sans',sans-serif;line-height:1.6;overflow-x:hidden}h1,h2,h3,.logo-text,nav a,.btn{font-family:'Syne',sans-serif}a{color:inherit;text-decoration:none}.atmo,.stars{position:fixed;inset:0;pointer-events:none;z-index:0}.atmo:before{content:"";position:absolute;inset:0;background:radial-gradient(ellipse 1100px 650px at -10% 10%,rgba(0,229,160,.06),transparent 65%),radial-gradient(ellipse 850px 550px at 110% 80%,rgba(0,184,255,.06),transparent 65%)}.stars{background-image:radial-gradient(1px 1px at 15% 20%,rgba(255,255,255,.35),transparent),radial-gradient(1px 1px at 72% 8%,rgba(255,255,255,.25),transparent),radial-gradient(1px 1px at 38% 55%,rgba(255,255,255,.2),transparent),radial-gradient(1.5px 1.5px at 92% 62%,rgba(0,229,160,.5),transparent)}
nav{position:fixed;top:0;left:0;right:0;z-index:20;display:flex;align-items:center;justify-content:space-between;padding:20px 7%;background:rgba(6,11,24,.82);backdrop-filter:blur(24px);border-bottom:1px solid var(--border)}.logo{display:flex;align-items:center;gap:10px}.logo-icon{width:40px;height:40px;border-radius:11px;background:var(--grad);display:grid;place-items:center;font-weight:800;color:#060b18;box-shadow:0 0 20px rgba(0,229,160,.3)}.logo-text{font-size:22px;font-weight:800;background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent}nav ul{list-style:none;display:flex;gap:34px}nav a{color:var(--muted);font-size:14px;font-weight:700}nav a:hover{color:var(--text)}.nav-cta{border:1px solid rgba(0,229,160,.4);padding:10px 22px;border-radius:8px;color:var(--accent);font-weight:800}.nav-cta:hover{background:rgba(0,229,160,.1);color:var(--accent)}
.hero{position:relative;z-index:1;min-height:100vh;display:grid;place-items:center;text-align:center;padding:140px 6% 90px}.hero:before{content:"";position:absolute;width:760px;height:760px;border-radius:50%;background:radial-gradient(circle,rgba(0,229,160,.045),transparent 70%);top:50%;left:50%;transform:translate(-50%,-60%);animation:orb 8s ease-in-out infinite}@keyframes orb{50%{transform:translate(-50%,-60%) scale(1.05);opacity:.9}}.hero-inner{position:relative;z-index:2;max-width:880px}.badge{display:inline-flex;align-items:center;gap:8px;background:rgba(0,229,160,.08);border:1px solid rgba(0,229,160,.25);border-radius:100px;padding:7px 18px;color:var(--accent);font-weight:700;margin-bottom:34px}.badge span{width:7px;height:7px;border-radius:50%;background:var(--accent);animation:pulse 1.8s infinite}@keyframes pulse{50%{opacity:.35}}h1{font-size:clamp(48px,8vw,96px);font-weight:800;line-height:1;letter-spacing:-.02em;margin-bottom:28px}em{font-style:normal;background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent}.hero p{font-size:clamp(17px,2.2vw,21px);color:var(--muted);max-width:620px;margin:0 auto 46px}.actions{display:flex;justify-content:center;gap:14px;flex-wrap:wrap}.btn{display:inline-flex;align-items:center;justify-content:center;border-radius:12px;padding:17px 34px;font-weight:800;transition:.25s}.btn-primary{background:var(--grad);color:#060b18;box-shadow:0 0 40px rgba(0,229,160,.28)}.btn-secondary{background:rgba(255,255,255,.04);border:1px solid var(--border);color:var(--text)}.btn:hover{transform:translateY(-3px)}.stats{display:flex;max-width:680px;margin:70px auto 0;border:1px solid var(--border);border-radius:20px;background:rgba(13,22,40,.8);overflow:hidden}.stat{flex:1;padding:26px 24px;border-right:1px solid var(--border)}.stat:last-child{border-right:0}.stat strong{display:block;font:800 36px 'Syne';background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent}.stat span{display:block;color:var(--muted);font-size:12px;margin-top:6px}
section{position:relative;z-index:1;padding:110px 7%}.bg2{background:var(--bg2)}.section-head{max-width:760px;margin-bottom:64px}.center{text-align:center;margin-left:auto;margin-right:auto}.tag{display:flex;align-items:center;gap:10px;color:var(--accent);font-size:11px;font-weight:800;letter-spacing:.15em;text-transform:uppercase;margin-bottom:16px}.center .tag{justify-content:center}.tag:before{content:"";width:24px;height:1px;background:var(--accent)}.center .tag:before{display:none}h2{font-size:clamp(34px,4.5vw,58px);line-height:1.08;letter-spacing:-.02em;margin-bottom:18px}.section-head p{color:var(--muted);font-size:18px;overflow-wrap:anywhere}.steps,.cards{display:grid;gap:18px}.steps{grid-template-columns:repeat(auto-fit,minmax(210px,1fr))}.step,.card,.quiz-card,.plan{background:var(--card);border:1px solid var(--border);border-radius:22px;padding:clamp(22px,3vw,32px);min-width:0;overflow:hidden}.step-num{font:800 54px 'Syne';color:rgba(255,255,255,.05);margin-bottom:12px}.step h3,.card h3{font-size:19px;margin-bottom:10px}.step p,.card p,.plan li{color:var(--muted);font-size:14px;overflow-wrap:anywhere}.cards{grid-template-columns:minmax(280px,1.2fr) minmax(220px,1fr) minmax(220px,1fr)}.card.big{grid-row:span 2;background:linear-gradient(160deg,var(--card2),var(--card) 65%)}.icon{width:54px;height:54px;border-radius:15px;display:grid;place-items:center;margin-bottom:20px;background:rgba(0,229,160,.1);font-size:24px}.demo{margin-top:26px;background:rgba(0,0,0,.26);border:1px solid rgba(0,229,160,.13);border-radius:16px;padding:20px;overflow:hidden}.demo-row{display:grid;grid-template-columns:minmax(80px,100px) minmax(0,1fr) 44px;gap:12px;align-items:center;margin-top:12px;color:var(--muted);font-size:13px;overflow-wrap:anywhere}.bar{height:7px;background:rgba(255,255,255,.07);border-radius:4px;overflow:hidden}.fill{height:100%;background:var(--grad);border-radius:4px}
.quiz{display:grid;grid-template-columns:minmax(0,1fr) minmax(320px,1.25fr);gap:64px;align-items:center}.quiz-card{background:var(--card2);box-shadow:0 40px 80px rgba(0,0,0,.35)}.quiz-top{display:flex;justify-content:space-between;gap:12px;color:var(--accent2);font-size:12px;font-weight:800;text-transform:uppercase;margin-bottom:20px;flex-wrap:wrap}.question{font-size:17px;margin-bottom:20px;overflow-wrap:anywhere}.opt{padding:14px 16px;border:1px solid var(--border);background:var(--card);border-radius:12px;margin-top:10px;cursor:pointer;overflow-wrap:anywhere}.opt:hover,.opt.correct{border-color:var(--accent);background:rgba(0,229,160,.08)}.plans{display:grid;grid-template-columns:repeat(2,minmax(280px,410px));justify-content:center;gap:24px}.plan.featured{border-color:rgba(0,229,160,.32);background:linear-gradient(160deg,rgba(0,229,160,.06),var(--card) 55%)}.price{font:800 clamp(38px,6vw,54px) 'Syne';margin:10px 0;overflow-wrap:anywhere}.plan ul{list-style:none;display:grid;gap:10px;margin:22px 0}.cta{text-align:center;background:radial-gradient(ellipse at center,rgba(0,229,160,.08),transparent 70%)}.footer{position:relative;z-index:1;border-top:1px solid var(--border);padding:42px 7%;display:flex;justify-content:space-between;gap:22px;flex-wrap:wrap;color:var(--muted);overflow-wrap:anywhere}
.reveal{opacity:0;transform:translateY(24px);transition:.65s}.reveal.visible{opacity:1;transform:none}@media(max-width:900px){nav ul{display:none}.steps,.cards,.quiz,.plans{grid-template-columns:1fr}.stats{flex-direction:column}.stat{border-right:0;border-bottom:1px solid var(--border)}.stat:last-child{border-bottom:0}section{padding:82px 5%}}
</style>
</head>
<body>
<div class="atmo"></div><div class="stars"></div>
<nav>
  <a href="<?= url() ?>" class="logo"><div class="logo-icon">E</div><span class="logo-text">Estudai</span></a>
  <ul>
    <li><a href="#como-funciona">Como funciona</a></li>
    <li><a href="#funcionalidades">Funcionalidades</a></li>
    <li><a href="#planos">Planos</a></li>
  </ul>
  <a class="nav-cta" href="<?= url('login?tab=register') ?>">Começar grátis</a>
</nav>

<main>
  <section class="hero">
    <div class="hero-inner">
      <div class="badge"><span></span> Plataforma com IA para vestibulares</div>
      <h1>Pare de estudar no<br><em>escuro.</em></h1>
      <p>O Estudai analisa seu desempenho e indica exatamente o que você precisa revisar. Nada de tempo perdido. Só evolução real.</p>
      <div class="actions">
        <a class="btn btn-primary" href="<?= url('login?tab=register') ?>">Criar conta grátis</a>
        <a class="btn btn-secondary" href="#como-funciona">Ver como funciona</a>
      </div>
      <div class="stats">
        <div class="stat"><strong>100+</strong><span>questões iniciais</span></div>
        <div class="stat"><strong>16</strong><span>matérias ENEM</span></div>
        <div class="stat"><strong>IA</strong><span>diagnóstico inteligente</span></div>
      </div>
    </div>
  </section>

  <section class="bg2" id="como-funciona">
    <div class="section-head center reveal">
      <div class="tag">Como funciona</div>
      <h2>Simples assim<br>em <em>4 passos</em></h2>
    </div>
    <div class="steps">
      <div class="step reveal"><div class="step-num">01</div><h3>Crie sua conta</h3><p>Cadastro direto no sistema, sem fila de espera e sem confirmação manual por e-mail.</p></div>
      <div class="step reveal"><div class="step-num">02</div><h3>Faça simulados</h3><p>Resolva questões por matéria e dificuldade, no ritmo certo para sua preparação.</p></div>
      <div class="step reveal"><div class="step-num">03</div><h3>Receba diagnóstico</h3><p>A plataforma identifica seus erros e transforma desempenho em prioridade de estudo.</p></div>
      <div class="step reveal"><div class="step-num">04</div><h3>Siga evoluindo</h3><p>Acompanhe XP, streak, conquistas e desempenho por matéria no dashboard.</p></div>
    </div>
  </section>

  <section id="funcionalidades">
    <div class="section-head reveal">
      <div class="tag">Funcionalidades</div>
      <h2>Tudo que você precisa<br><em>em um lugar</em></h2>
      <p>Ferramentas inteligentes pensadas para quem quer estudar com direção.</p>
    </div>
    <div class="cards">
      <div class="card big reveal">
        <div class="icon">M</div>
        <h3>Mapa inteligente de aprendizado</h3>
        <p>Veja quais matérias estão fortes, quais precisam de revisão e onde vale colocar energia agora.</p>
        <div class="demo">
          <div class="demo-row"><span>Funções</span><div class="bar"><div class="fill" style="width:94%"></div></div><strong>94%</strong></div>
          <div class="demo-row"><span>Geometria</span><div class="bar"><div class="fill" style="width:41%;background:linear-gradient(135deg,#ffd166,#ff9f1c)"></div></div><strong>41%</strong></div>
          <div class="demo-row"><span>Probabilidade</span><div class="bar"><div class="fill" style="width:22%;background:linear-gradient(135deg,#ff6b6b,#ff3b3b)"></div></div><strong>22%</strong></div>
        </div>
      </div>
      <div class="card reveal"><div class="icon">Q</div><h3>Simulados objetivos</h3><p>Questões organizadas para medir desempenho e gerar histórico útil.</p></div>
      <div class="card reveal"><div class="icon">XP</div><h3>Gamificação</h3><p>XP, níveis, streaks e conquistas mantêm o estudo vivo sem virar bagunça.</p></div>
      <div class="card reveal"><div class="icon">IA</div><h3>Recomendação do dia</h3><p>O dashboard aponta a matéria mais urgente com base no seu histórico.</p></div>
      <div class="card reveal"><div class="icon">R</div><h3>Oficina de redação</h3><p>Planeje, escreva e revise seu texto com checklist das 5 competências do ENEM.</p></div>
    </div>
  </section>

  <section class="quiz bg2">
    <div class="section-head reveal">
      <div class="tag">Experimente</div>
      <h2>O estudo fica melhor<br><em>quando o erro vira rota</em></h2>
      <p>Ao terminar um simulado, você entende onde perdeu ponto e o que estudar em seguida.</p>
    </div>
    <div class="quiz-card reveal">
      <div class="quiz-top"><span>Matemática - ENEM</span><span>Questão 3 de 5</span></div>
      <div class="question">Uma progressão aritmética tem primeiro termo 3 e razão 4. Qual é o 10º termo?</div>
      <div class="opt">A) 35</div>
      <div class="opt">B) 40</div>
      <div class="opt correct">C) 39</div>
      <div class="opt">D) 43</div>
    </div>
  </section>

  <section class="bg2" id="planos">
    <div class="section-head center reveal">
      <div class="tag">Acesso</div>
      <h2>Comece <em>grátis</em><br>pelo sistema real</h2>
      <p>Sem pré-cadastro por e-mail. Criou a conta, entrou no dashboard.</p>
    </div>
    <div class="plans">
      <div class="plan reveal"><h3>Gratuito</h3><div class="price">R$0</div><ul><li>Simulados iniciais</li><li>Dashboard de desempenho</li><li>XP, streaks e conquistas</li></ul><a class="btn btn-secondary" href="<?= url('login?tab=register') ?>">Criar conta</a></div>
      <div class="plan featured reveal"><h3>Premium futuro</h3><div class="price">Em breve</div><ul><li>Mais questões</li><li>Trilhas personalizadas</li><li>Relatórios avançados</li></ul><a class="btn btn-primary" href="<?= url('login?tab=register') ?>">Entrar agora</a></div>
    </div>
  </section>

  <section class="cta">
    <div class="section-head center reveal">
      <h2>Sua aprovação<br>começa <em>hoje.</em></h2>
      <p>Crie sua conta grátis e faça o primeiro diagnóstico.</p>
      <div class="actions" style="margin-top:30px"><a class="btn btn-primary" href="<?= url('login?tab=register') ?>">Começar grátis</a><a class="btn btn-secondary" href="<?= url('login') ?>">Já tenho conta</a></div>
    </div>
  </section>
</main>

<footer class="footer">
  <a href="<?= url() ?>" class="logo"><div class="logo-icon">E</div><span class="logo-text">Estudai</span></a>
  <p>© <?= date('Y') ?> Estudai. Plataforma inteligente de estudo para vestibular.</p>
</footer>
<script>
const observer=new IntersectionObserver(entries=>entries.forEach((e,i)=>{if(e.isIntersecting){setTimeout(()=>e.target.classList.add('visible'),i*70);observer.unobserve(e.target)}}),{threshold:.1});
document.querySelectorAll('.reveal').forEach(el=>observer.observe(el));
</script>
</body>
</html>
