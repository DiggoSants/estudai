<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(APP_NAME) ?> - Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
<style>
:root{--bg:#060b18;--bg2:#080e1c;--card:#0d1628;--card2:#111e38;--accent:#00e5a0;--accent2:#00b8ff;--danger:#ff6b6b;--warn:#ffd166;--text:#eef2ff;--muted:#6b7ba8;--border:rgba(255,255,255,.08);--grad:linear-gradient(135deg,#00e5a0,#00b8ff)}
*{box-sizing:border-box;margin:0;padding:0}body{background:var(--bg);color:var(--text);font-family:'DM Sans',sans-serif;line-height:1.6;min-height:100vh;display:flex}h1,h2,h3,.logo-text,.value,.nav-section,.panel-title{font-family:'Syne',sans-serif}a{text-decoration:none;color:inherit}.atmo{position:fixed;inset:0;pointer-events:none;z-index:0;background:radial-gradient(ellipse 900px 600px at -10% 10%,rgba(0,229,160,.055),transparent 65%),radial-gradient(ellipse 800px 560px at 110% 80%,rgba(0,184,255,.055),transparent 65%)}
.sidebar{position:sticky;top:0;z-index:2;width:250px;height:100vh;background:rgba(8,14,28,.9);border-right:1px solid var(--border);padding:28px 20px;display:flex;flex-direction:column}.logo{display:flex;align-items:center;gap:10px;margin-bottom:34px}.logo-icon{width:40px;height:40px;border-radius:11px;background:var(--grad);display:grid;place-items:center;font-weight:800;color:#060b18}.logo-text{font-size:22px;font-weight:800;background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent}.nav-section{color:var(--muted);font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.15em;margin:24px 0 10px}.nav-link{display:flex;gap:10px;align-items:center;color:var(--muted);font-weight:700;padding:11px 12px;border-radius:12px;margin-bottom:4px}.nav-link:hover,.nav-link.active{background:rgba(0,229,160,.08);color:var(--text)}.bottom{margin-top:auto;border-top:1px solid var(--border);padding-top:18px}.userbox{display:flex;gap:10px;align-items:center;background:rgba(255,255,255,.035);border:1px solid var(--border);border-radius:14px;padding:10px}.avatar{width:38px;height:38px;border-radius:12px;display:grid;place-items:center;font-weight:800}.userbox strong{display:block;font-size:14px}.userbox span{color:var(--muted);font-size:12px}.logout{display:block;text-align:center;color:var(--muted);border:1px solid var(--border);border-radius:12px;padding:10px;margin-top:10px;font-weight:800}.logout:hover{border-color:var(--danger);color:var(--danger)}
.main{position:relative;z-index:1;flex:1;padding:38px;max-width:calc(100vw - 250px)}.header{display:flex;justify-content:space-between;gap:20px;align-items:flex-start;margin-bottom:28px}.header h1{font-size:42px;line-height:1;letter-spacing:-.02em}.header p{color:var(--muted);margin-top:6px}.btn{display:inline-flex;align-items:center;justify-content:center;border-radius:12px;padding:14px 22px;background:var(--grad);color:#060b18;font-family:'Syne';font-weight:800;box-shadow:0 0 34px rgba(0,229,160,.24)}
.level{background:linear-gradient(160deg,rgba(0,229,160,.08),rgba(0,184,255,.04));border:1px solid rgba(0,229,160,.18);border-radius:24px;padding:24px;margin-bottom:20px}.level-top{display:flex;align-items:center;gap:16px;margin-bottom:15px}.level-badge{width:58px;height:58px;border-radius:16px;display:grid;place-items:center;font-size:24px;border:2px solid}.level h2{font-size:26px}.level span,.xptext{color:var(--muted);font-size:13px}.progress{height:9px;background:rgba(255,255,255,.06);border-radius:10px;overflow:hidden}.progress div{height:100%;background:var(--grad);border-radius:10px}.xptext{display:flex;justify-content:space-between;margin-top:8px}
.grid{display:grid;gap:18px}.stats{grid-template-columns:repeat(auto-fit,minmax(190px,1fr));margin-bottom:20px}.card,.panel{background:rgba(13,22,40,.86);border:1px solid var(--border);border-radius:22px;padding:clamp(18px,3vw,22px);min-width:0;overflow:hidden}.card small{color:var(--muted);font-weight:800;text-transform:uppercase;letter-spacing:.08em}.value{display:block;font-size:clamp(30px,5vw,38px);font-weight:800;line-height:1;margin:12px 0 6px;background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent;overflow-wrap:anywhere}.delta{display:inline-block;font-size:12px;border-radius:100px;padding:3px 9px;background:rgba(0,229,160,.1);color:var(--accent)}.delta.bad{background:rgba(255,107,107,.1);color:var(--danger)}
.ai{background:linear-gradient(160deg,rgba(0,229,160,.08),rgba(0,184,255,.045));border-color:rgba(0,229,160,.18);margin-bottom:20px}.ai-list{display:grid;gap:10px;margin-top:16px}.ai-list li{list-style:none;background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:14px;padding:12px;color:var(--text);overflow-wrap:anywhere}.panel-title{color:var(--muted);font-size:12px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;margin-bottom:18px;display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap}.two{grid-template-columns:minmax(0,1.55fr) minmax(300px,1fr);margin-bottom:20px}.mat-item{display:flex;gap:12px;align-items:center;margin-bottom:14px;min-width:0}.mat-icon{width:36px;height:36px;border-radius:12px;display:grid;place-items:center;background:rgba(255,255,255,.05);flex:0 0 auto}.mat-info{flex:1;min-width:0}.mat-top{display:flex;justify-content:space-between;gap:12px;font-weight:800;font-size:14px;overflow-wrap:anywhere}.bar{height:7px;background:rgba(255,255,255,.06);border-radius:10px;overflow:hidden;margin-top:7px}.bar div{height:100%;border-radius:10px}.stack{display:grid;gap:18px;min-width:0}.streak{display:flex;gap:14px;align-items:center;background:rgba(0,229,160,.07);border:1px solid rgba(0,229,160,.14);border-radius:16px;padding:16px;margin-bottom:14px}.heat{display:grid;grid-template-columns:repeat(7,minmax(34px,1fr));gap:7px;overflow-x:auto;padding-bottom:2px}.day{aspect-ratio:1;border:1px solid var(--border);border-radius:10px;display:grid;place-items:center;color:var(--muted);font-size:11px;min-width:34px}.day.active{background:rgba(0,229,160,.16);border-color:rgba(0,229,160,.3);color:var(--text)}.day.hot{background:rgba(0,184,255,.2);border-color:rgba(0,184,255,.4)}
.sim{display:flex;justify-content:space-between;gap:14px;align-items:center;background:rgba(255,255,255,.035);border:1px solid var(--border);border-radius:16px;padding:15px;margin-bottom:10px;min-width:0}.circle{width:48px;height:48px;border-radius:16px;display:grid;place-items:center;border:2px solid;font-weight:800;flex:0 0 auto}.sim-left{display:flex;gap:12px;align-items:center;min-width:0}.sim-left>div:last-child{min-width:0;overflow-wrap:anywhere}.muted{color:var(--muted);font-size:13px;overflow-wrap:anywhere}.badges{display:grid;grid-template-columns:repeat(auto-fit,minmax(92px,1fr));gap:10px}.badge{min-height:96px;border:1px solid var(--border);border-radius:16px;display:grid;place-items:center;text-align:center;padding:8px;color:var(--muted);font-size:11px;overflow:hidden}.badge span{font-size:22px}.badge.unlocked{background:rgba(0,229,160,.08);border-color:rgba(0,229,160,.22);color:var(--accent)}.badge.locked{opacity:.38;filter:grayscale(1)}.empty{text-align:center;color:var(--muted);padding:32px}.error-item{border-left:3px solid var(--danger);background:rgba(255,255,255,.035);border-radius:14px;padding:14px;margin-bottom:10px;overflow-wrap:anywhere}
@media(max-width:1120px){.stats,.two{grid-template-columns:1fr 1fr}.badges{grid-template-columns:repeat(4,1fr)}}@media(max-width:780px){body{display:block}.sidebar{display:none}.main{max-width:none;padding:22px}.header,.level-top{display:block}.stats,.two{grid-template-columns:1fr}.badges{grid-template-columns:repeat(3,1fr)}}
</style>
</head>
<body>
<div class="atmo"></div>
<aside class="sidebar">
  <a href="<?= url('dashboard') ?>" class="logo"><div class="logo-icon">E</div><span class="logo-text">Estudai</span></a>
  <div class="nav-section">Principal</div>
  <a href="<?= url('dashboard') ?>" class="nav-link active">Dashboard</a>
  <a href="<?= url('simulado') ?>" class="nav-link">Novo simulado</a>
  <div class="nav-section">Historico</div>
  <a href="#historico" class="nav-link">Meus simulados</a>
  <a href="#conquistas" class="nav-link">Conquistas</a>
  <div class="bottom">
    <div class="userbox">
      <div class="avatar" style="background:<?= e($user['avatar_cor']) ?>22;color:<?= e($user['avatar_cor']) ?>;border:1px solid <?= e($user['avatar_cor']) ?>"><?= e(strtoupper(substr($user['nome'],0,1))) ?></div>
      <div><strong><?= e($primeiroNome) ?></strong><span><?= e($nivel['nome']) ?></span></div>
    </div>
    <a class="logout" href="<?= url('logout') ?>">Sair</a>
  </div>
</aside>

<main class="main">
  <header class="header">
    <div><h1><?= e($saudacao) ?>, <?= e($primeiroNome) ?>.</h1><p>Seu mapa de desempenho esta pronto para guiar o proximo estudo.</p></div>
    <a class="btn" href="<?= url('simulado') ?>">Iniciar simulado</a>
  </header>

  <section class="level">
    <div class="level-top">
      <div class="level-badge" style="border-color:<?= e($nivel['cor']) ?>;background:<?= e($nivel['cor']) ?>18"><?= e($nivel['icone']) ?></div>
      <div><h2 style="color:<?= e($nivel['cor']) ?>"><?= e($nivel['nome']) ?></h2><span>Nivel <?= (int)$nivel['nivel'] ?> - <?= number_format((int)$user['xp']) ?> XP total</span></div>
      <div style="margin-left:auto"><h2><?= (int)$nivel['progresso'] ?>%</h2><span>para o proximo nivel</span></div>
    </div>
    <div class="progress"><div style="width:<?= (int)$nivel['progresso'] ?>%"></div></div>
    <div class="xptext"><span><?= number_format((int)$nivel['min']) ?> XP</span><span><?= $nivel['max'] === PHP_INT_MAX ? 'infinito' : number_format((int)$nivel['max']) . ' XP' ?></span></div>
  </section>

  <?php $totalSimulados=(int)($stats['total']??0);$totalAcertos=(int)($stats['acertos']??0);$totalQuestoes=(int)($stats['questoes']??0);$media=$stats['media']!==null?(float)$stats['media']:0.0; ?>
  <section class="grid stats">
    <div class="card"><small>Simulados</small><span class="value"><?= $totalSimulados ?></span><?php if($totalSimulados>0):?><span class="delta">+<?= $totalSimulados ?> total</span><?php endif;?></div>
    <div class="card"><small>Acertos</small><span class="value"><?= $totalAcertos ?></span><?php if($totalQuestoes>0):?><span class="delta"><?= round($totalAcertos/$totalQuestoes*100) ?>% taxa</span><?php endif;?></div>
    <div class="card"><small>Media geral</small><span class="value"><?= $media>0?round($media).'%':'-' ?></span><?php if($media>=70):?><span class="delta">otimo ritmo</span><?php elseif($media>0):?><span class="delta bad">pode melhorar</span><?php endif;?></div>
    <div class="card"><small>Dias seguidos</small><span class="value"><?= (int)$user['streak'] ?></span><?php if((int)$user['streak']>=3):?><span class="delta">sequencia ativa</span><?php endif;?></div>
  </section>

  <?php $piorMateria=count($materias)>0?$materias[0]:null;$melhorMateria=count($materias)>0?$materias[count($materias)-1]:null; ?>
  <section class="panel ai">
    <div class="panel-title">IA - rota de estudos individual</div>
    <h2><?= e($rotaEstudos['titulo']) ?></h2>
    <p><?= e($rotaEstudos['resumo']) ?></p>
    <ul class="ai-list">
      <?php foreach ($rotaEstudos['tarefas'] as $tarefa): ?>
        <li><?= e($tarefa) ?></li>
      <?php endforeach; ?>
    </ul>
    <div style="margin-top:18px"><a class="btn" href="<?= url('simulado') ?>">Gerar novo diagnostico</a></div>
  </section>

  <section class="grid two">
    <div class="panel">
      <div class="panel-title">Desempenho por materia <span>ultimos 30 dias</span></div>
      <?php if(count($materias)>0): foreach($materias as $m): $pct=(int)$m['pct'];$cor=$pct>=70?'var(--accent)':($pct>=50?'var(--warn)':'var(--danger)'); ?>
        <div class="mat-item"><div class="mat-icon"><?= e($m['icone']) ?></div><div class="mat-info"><div class="mat-top"><span><?= e($m['nome']) ?></span><span style="color:<?= $cor ?>"><?= $pct ?>%</span></div><div class="bar"><div style="width:<?= $pct ?>%;background:<?= $cor ?>"></div></div></div></div>
      <?php endforeach; else: ?><div class="empty">Nenhum dado ainda. <a href="<?= url('simulado') ?>" style="color:var(--accent)">Fazer primeiro simulado</a></div><?php endif; ?>
    </div>
    <div class="stack">
      <div class="panel">
        <div class="panel-title">Atividade da semana</div>
        <div class="streak"><strong style="font-size:30px;color:var(--accent)"><?= (int)$user['streak'] ?></strong><div><strong>dia<?= (int)$user['streak']!==1?'s':'' ?> seguido<?= (int)$user['streak']!==1?'s':'' ?></strong><div class="muted">Continue estudando todo dia.</div></div></div>
        <div class="heat"><?php foreach($semana as $dia): ?><div class="day <?= $dia['cnt']>1?'hot':($dia['cnt']===1?'active':'') ?>"><?= e(strtoupper(substr($dia['label'],0,2))) ?><br><?= $dia['cnt']>0?(int)$dia['cnt']:'.' ?></div><?php endforeach; ?></div>
      </div>
      <?php if(count($erros)>0): ?><div class="panel"><div class="panel-title">Questoes mais erradas</div><?php foreach($erros as $erro): ?><div class="error-item"><strong><?= e($erro['icone']) ?> <?= e($erro['materia']) ?> - <?= (int)$erro['tentativas'] ?> erros</strong><div class="muted"><?= e($erro['enunciado']) ?></div></div><?php endforeach; ?></div><?php endif; ?>
    </div>
  </section>

  <section class="panel" id="historico" style="margin-bottom:20px">
    <div class="panel-title">Ultimos simulados <a href="<?= url('simulado') ?>" style="color:var(--accent)">Novo</a></div>
    <?php if(count($ultimos)>0): foreach($ultimos as $sim): $pct=(int)$sim['total']>0?round((int)$sim['acertos']/(int)$sim['total']*100):0;$cor=$pct>=70?'var(--accent)':($pct>=50?'var(--warn)':'var(--danger)');$min=floor((int)$sim['tempo_gasto']/60);$seg=(int)$sim['tempo_gasto']%60; ?>
      <div class="sim"><div class="sim-left"><div class="circle" style="border-color:<?= $cor ?>;color:<?= $cor ?>;background:color-mix(in srgb, <?= $cor ?> 12%, transparent)"><?= $pct ?>%</div><div><strong><?= (int)$sim['acertos'] ?>/<?= (int)$sim['total'] ?> acertos</strong><div class="muted"><?= e($sim['data_fmt']) ?> - <?= $min ?>m<?= $seg ?>s</div></div></div><strong style="color:var(--accent)">+<?= (int)$sim['xp_ganho'] ?> XP</strong></div>
    <?php endforeach; else: ?><div class="empty">Voce ainda nao fez nenhum simulado. <a href="<?= url('simulado') ?>" style="color:var(--accent)">Comecar agora</a></div><?php endif; ?>
  </section>

  <section class="panel" id="conquistas">
    <div class="panel-title">Conquistas (<?= count($conquistas) ?>/<?= count($todasConquistas) ?>)</div>
    <div class="badges"><?php foreach($todasConquistas as $c): $unlocked=in_array($c['chave'],$conquistasIds,true); ?><div class="badge <?= $unlocked?'unlocked':'locked' ?>" title="<?= e($c['nome']) ?>: <?= e($c['descricao']??'') ?>"><span><?= e($c['icone']??'*') ?></span><small><?= e($c['nome']) ?></small></div><?php endforeach; ?></div>
  </section>
</main>
</body>
</html>
