<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(APP_NAME) ?> — Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Syne:wght@400;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--bg:#09090f;--surface:#0d0d1a;--card:#111120;--card2:#13132a;--gold:#e8c547;--violet:#6b4de6;--coral:#e85d4a;--mint:#4ab89a;--sky:#4a90d9;--text:#e8e8f0;--muted:#6b6b8a;--border:#1e1e38}
body{font-family:'Syne',sans-serif;background:var(--bg);color:var(--text);display:flex;min-height:100vh}
body::after{content:'';position:fixed;inset:0;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.04'/%3E%3C/svg%3E");pointer-events:none;z-index:999}
a{text-decoration:none}.sidebar{width:240px;flex-shrink:0;background:var(--surface);border-right:1px solid var(--border);padding:28px 20px;display:flex;flex-direction:column;position:sticky;top:0;height:100vh;overflow-y:auto}.logo{font-family:'Bebas Neue';font-size:28px;letter-spacing:2px;color:var(--gold);margin-bottom:32px;display:block}.nav-section{font-family:'DM Mono';font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--muted);margin:24px 0 10px}.nav-link{display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:8px;color:var(--muted);font-size:14px;font-weight:600;transition:all .2s;margin-bottom:2px}.nav-link:hover,.nav-link.active{background:rgba(107,77,230,.12);color:var(--text)}.nav-link.active{color:var(--violet)}.sidebar-bottom{margin-top:auto;padding-top:20px;border-top:1px solid var(--border)}.user-info{display:flex;align-items:center;gap:10px;padding:10px;border-radius:8px;background:var(--card)}.avatar{width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:15px;flex-shrink:0}.user-info-text{overflow:hidden}.user-info-text strong{display:block;font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.user-info-text span{font-size:11px;color:var(--muted);font-family:'DM Mono'}.btn-logout{display:block;text-align:center;margin-top:10px;padding:9px;border-radius:8px;color:var(--muted);font-size:13px;font-weight:600;border:1px solid var(--border)}.btn-logout:hover{border-color:var(--coral);color:var(--coral)}
.main{flex:1;padding:40px;overflow-x:hidden;max-width:calc(100vw - 240px)}.page-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:36px;gap:20px;flex-wrap:wrap}.page-title h1{font-family:'Bebas Neue';font-size:40px;letter-spacing:1px;line-height:1}.page-title p{color:var(--muted);font-size:14px;margin-top:4px}.btn-simulado{background:var(--gold);color:#09090f;border-radius:10px;padding:14px 28px;font-size:15px;font-weight:800;display:inline-flex;align-items:center;gap:8px;letter-spacing:.3px;transition:all .25s}.btn-simulado:hover{transform:translateY(-2px);box-shadow:0 12px 28px rgba(232,197,71,.25)}
.nivel-card{background:linear-gradient(135deg,rgba(107,77,230,.15),rgba(107,77,230,.05));border:1px solid rgba(107,77,230,.3);border-radius:12px;padding:24px;margin-bottom:20px}.nivel-top{display:flex;align-items:center;gap:16px;margin-bottom:16px}.nivel-badge{width:56px;height:56px;border-radius:50%;border:3px solid;display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0}.nivel-info strong{font-family:'Bebas Neue';font-size:24px;letter-spacing:1px;display:block;line-height:1}.nivel-info span{font-size:12px;color:var(--muted);font-family:'DM Mono'}.xp-bar-wrap{background:rgba(255,255,255,.06);border-radius:6px;height:8px;overflow:hidden}.xp-bar{height:100%;border-radius:6px;background:linear-gradient(90deg,var(--violet),#9b70ff)}.xp-text{display:flex;justify-content:space-between;font-size:11px;font-family:'DM Mono';color:var(--muted);margin-top:8px}
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px}.stat-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:22px;position:relative;overflow:hidden;transition:border-color .3s}.stat-card:hover{border-color:rgba(107,77,230,.4)}.stat-icon{font-size:24px;margin-bottom:12px;display:block}.stat-val{font-family:'Bebas Neue';font-size:38px;letter-spacing:1px;color:var(--text);line-height:1;display:block}.stat-label{color:var(--muted);font-size:12px;font-family:'DM Mono';letter-spacing:.5px;margin-top:4px}.stat-delta{font-size:11px;font-family:'DM Mono';margin-top:6px;padding:2px 8px;border-radius:4px;display:inline-block}.delta-up{background:rgba(74,184,154,.15);color:var(--mint)}.delta-down{background:rgba(232,93,74,.15);color:var(--coral)}
.panel{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:24px}.panel-title{font-size:13px;font-weight:700;font-family:'DM Mono';letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:20px;display:flex;align-items:center;justify-content:space-between}.panel-title a{color:var(--violet);font-size:11px}.two-col{display:grid;grid-template-columns:1.6fr 1fr;gap:20px;margin-bottom:20px}.stack{display:flex;flex-direction:column;gap:16px}
.ai-insight{background:linear-gradient(135deg,rgba(107,77,230,.1),rgba(74,144,217,.05));border:1px solid rgba(107,77,230,.25);border-radius:12px;padding:20px;margin-bottom:20px}.ai-insight-header{display:flex;align-items:center;gap:10px;margin-bottom:14px}.ai-dot-pulse{width:8px;height:8px;border-radius:50%;background:var(--violet);animation:pulse 1.5s infinite}@keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(.8)}}.ai-insight-title{font-size:12px;font-family:'DM Mono';letter-spacing:1px;text-transform:uppercase;color:var(--violet)}.ai-rec{font-size:14px;color:var(--text);line-height:1.6;margin-bottom:12px}.ai-chips{display:flex;flex-wrap:wrap;gap:6px}.ai-chip{padding:4px 10px;border-radius:20px;font-size:11px;font-family:'DM Mono';border:1px solid}
.mat-list,.sim-list{display:flex;flex-direction:column;gap:12px}.mat-item{display:flex;align-items:center;gap:12px}.mat-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0}.mat-info{flex:1;min-width:0}.mat-top{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:5px}.mat-name{font-size:13px;font-weight:600}.mat-pct{font-family:'DM Mono';font-size:12px;font-weight:700}.mat-bar-bg{background:rgba(255,255,255,.06);border-radius:4px;height:5px;overflow:hidden}.mat-bar{height:100%;border-radius:4px}
.streak-widget{display:flex;align-items:center;gap:16px;background:rgba(232,197,71,.06);border:1px solid rgba(232,197,71,.2);border-radius:10px;padding:16px;margin-bottom:16px}.streak-info strong{display:block;font-size:14px;margin-bottom:2px}.streak-info span{font-size:12px;color:var(--muted)}.heatmap{display:grid;grid-template-columns:repeat(7,1fr);gap:6px}.hmap-cell{aspect-ratio:1;border-radius:4px;display:flex;flex-direction:column;align-items:center;justify-content:center;font-size:9px;font-family:'DM Mono';color:var(--muted);gap:3px;border:1px solid var(--border)}.hmap-cell.active{background:rgba(107,77,230,.3);border-color:rgba(107,77,230,.4);color:var(--text)}.hmap-cell.hot{background:rgba(107,77,230,.6);border-color:var(--violet)}.hmap-day{font-size:8px;text-transform:uppercase}
.sim-item{display:flex;align-items:center;justify-content:space-between;padding:14px 16px;background:var(--card2);border:1px solid var(--border);border-radius:10px}.sim-left{display:flex;align-items:center;gap:12px}.sim-circle{width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Bebas Neue';font-size:17px;font-weight:700;flex-shrink:0;border:2px solid}.sim-details strong{display:block;font-size:14px;margin-bottom:2px}.sim-details span{font-size:12px;color:var(--muted);font-family:'DM Mono'}.sim-xp{font-family:'Bebas Neue';font-size:18px;color:var(--gold);letter-spacing:1px}.sim-xp small{font-family:'DM Mono';font-size:10px;color:var(--muted)}
.badges-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:10px}.badge-item{aspect-ratio:1;border-radius:12px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:5px;border:1.5px solid var(--border);position:relative}.badge-item.unlocked{border-color:rgba(232,197,71,.3);background:rgba(232,197,71,.06)}.badge-item.locked{opacity:.3;filter:grayscale(1)}.badge-icon{font-size:22px}.badge-name{font-size:9px;font-family:'DM Mono';color:var(--muted);text-align:center;padding:0 4px;line-height:1.3}.badge-item.unlocked .badge-name{color:var(--gold)}.erro-item{padding:14px;background:var(--card2);border:1px solid var(--border);border-left:3px solid var(--coral);border-radius:8px;margin-bottom:8px}.erro-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:6px}.erro-mat{font-size:11px;font-family:'DM Mono';color:var(--muted)}.erro-pct{font-family:'Bebas Neue';font-size:20px;color:var(--coral)}.erro-txt{font-size:13px;color:var(--text);line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}.empty-state{text-align:center;padding:40px;color:var(--muted);font-size:14px}.empty-state p{margin-bottom:16px}.empty-state a{color:var(--violet);font-weight:700}
@media(max-width:1200px){.stats-grid{grid-template-columns:repeat(2,1fr)}.two-col{grid-template-columns:1fr}}@media(max-width:768px){.sidebar{display:none}.main{max-width:100vw;padding:20px}.badges-grid{grid-template-columns:repeat(3,1fr)}}
</style>
</head>
<body>
<aside class="sidebar">
  <a href="<?= url('dashboard') ?>" class="logo">Estudai</a>
  <span class="nav-section">Principal</span>
  <a href="<?= url('dashboard') ?>" class="nav-link active"><span>📊</span> Dashboard</a>
  <a href="<?= url('simulado') ?>" class="nav-link"><span>📝</span> Novo Simulado</a>
  <span class="nav-section">Histórico</span>
  <a href="#historico" class="nav-link"><span>📁</span> Meus Simulados</a>
  <a href="#conquistas" class="nav-link"><span>🏆</span> Conquistas</a>
  <div class="sidebar-bottom">
    <div class="user-info">
      <div class="avatar" style="background:<?= e($user['avatar_cor']) ?>20;color:<?= e($user['avatar_cor']) ?>;border:2px solid <?= e($user['avatar_cor']) ?>"><?= e(strtoupper(substr($user['nome'], 0, 1))) ?></div>
      <div class="user-info-text"><strong><?= e($primeiroNome) ?></strong><span><?= e($nivel['icone']) ?> <?= e($nivel['nome']) ?></span></div>
    </div>
    <a href="<?= url('logout') ?>" class="btn-logout">↩ Sair</a>
  </div>
</aside>

<main class="main">
  <div class="page-header">
    <div class="page-title">
      <h1><?= e($saudacao) ?>, <?= e($primeiroNome) ?>! <?= (int) $user['streak'] >= 3 ? '🔥' : '👋' ?></h1>
      <p>Aqui está seu resumo de desempenho.</p>
    </div>
    <a href="<?= url('simulado') ?>" class="btn-simulado">✦ Iniciar Simulado</a>
  </div>

  <div class="nivel-card">
    <div class="nivel-top">
      <div class="nivel-badge" style="border-color:<?= e($nivel['cor']) ?>;background:<?= e($nivel['cor']) ?>18"><?= e($nivel['icone']) ?></div>
      <div class="nivel-info"><strong style="color:<?= e($nivel['cor']) ?>"><?= e($nivel['nome']) ?></strong><span>Nível <?= (int) $nivel['nivel'] ?> · <?= number_format((int) $user['xp']) ?> XP total</span></div>
      <div style="margin-left:auto;text-align:right"><span style="font-family:'Bebas Neue';font-size:28px;color:var(--gold)"><?= (int) $nivel['progresso'] ?>%</span><span style="display:block;font-size:11px;color:var(--muted);font-family:'DM Mono'">para próx. nível</span></div>
    </div>
    <div class="xp-bar-wrap"><div class="xp-bar" style="width:<?= (int) $nivel['progresso'] ?>%"></div></div>
    <div class="xp-text"><span><?= number_format((int) $nivel['min']) ?> XP</span><span><?= $nivel['max'] === PHP_INT_MAX ? '∞' : number_format((int) $nivel['max']) . ' XP' ?></span></div>
  </div>

  <?php
    $totalSimulados = (int) ($stats['total'] ?? 0);
    $totalAcertos = (int) ($stats['acertos'] ?? 0);
    $totalQuestoes = (int) ($stats['questoes'] ?? 0);
    $media = $stats['media'] !== null ? (float) $stats['media'] : 0.0;
  ?>
  <div class="stats-grid">
    <div class="stat-card"><span class="stat-icon">📝</span><span class="stat-val"><?= $totalSimulados ?></span><div class="stat-label">Simulados</div><?php if ($totalSimulados > 0): ?><span class="stat-delta delta-up">+<?= $totalSimulados ?> total</span><?php endif; ?></div>
    <div class="stat-card"><span class="stat-icon">✅</span><span class="stat-val"><?= $totalAcertos ?></span><div class="stat-label">Acertos</div><?php if ($totalQuestoes > 0): ?><span class="stat-delta delta-up"><?= round($totalAcertos / $totalQuestoes * 100) ?>% taxa</span><?php endif; ?></div>
    <div class="stat-card"><span class="stat-icon">🎯</span><span class="stat-val"><?= $media > 0 ? round($media) . '%' : '—' ?></span><div class="stat-label">Média Geral</div><?php if ($media >= 70): ?><span class="stat-delta delta-up">Ótimo ritmo</span><?php elseif ($media > 0): ?><span class="stat-delta delta-down">Pode melhorar</span><?php endif; ?></div>
    <div class="stat-card"><span class="stat-icon">🔥</span><span class="stat-val"><?= (int) $user['streak'] ?></span><div class="stat-label">Dias seguidos</div><?php if ((int) $user['streak'] >= 7): ?><span class="stat-delta delta-up">🏆 Semana perfeita!</span><?php elseif ((int) $user['streak'] >= 3): ?><span class="stat-delta delta-up">🔥 Em chama!</span><?php endif; ?></div>
  </div>

  <?php $piorMateria = count($materias) > 0 ? $materias[0] : null; $melhorMateria = count($materias) > 0 ? $materias[count($materias) - 1] : null; ?>
  <div class="ai-insight">
    <div class="ai-insight-header"><div class="ai-dot-pulse"></div><span class="ai-insight-title">🤖 Análise IA — Recomendação do dia</span></div>
    <?php if ($piorMateria): ?>
      <div class="ai-rec">Com base no seu histórico, você está com <strong style="color:var(--coral)"><?= (int) $piorMateria['pct'] ?>% de acertos em <?= e($piorMateria['nome']) ?></strong>. <?php if ($melhorMateria && $melhorMateria !== $piorMateria): ?>Seu ponto forte é <strong style="color:var(--mint)"><?= e($melhorMateria['nome']) ?> (<?= (int) $melhorMateria['pct'] ?>%)</strong>.<?php endif; ?> Recomendo focar hoje em <strong><?= e($piorMateria['nome']) ?></strong>.</div>
      <div class="ai-chips"><span class="ai-chip" style="background:rgba(232,93,74,.1);border-color:rgba(232,93,74,.3);color:var(--coral)">⚠ <?= e($piorMateria['nome']) ?> — prioridade alta</span><span class="ai-chip" style="background:rgba(74,184,154,.1);border-color:rgba(74,184,154,.3);color:var(--mint)">✓ Streak de <?= (int) $user['streak'] ?> dia(s)</span></div>
    <?php else: ?>
      <div class="ai-rec">Faça seu primeiro simulado para ativar as recomendações personalizadas.</div>
      <div class="ai-chips"><span class="ai-chip" style="background:rgba(107,77,230,.1);border-color:rgba(107,77,230,.3);color:var(--violet)">✦ Inicie agora para desbloquear insights</span></div>
    <?php endif; ?>
  </div>

  <div class="two-col">
    <div class="panel">
      <div class="panel-title">📊 Desempenho por Matéria <span style="color:var(--muted);font-size:10px">últimos 30 dias</span></div>
      <?php if (count($materias) > 0): ?>
        <div class="mat-list">
        <?php foreach ($materias as $m): $pct = (int) $m['pct']; $cor = $pct >= 70 ? 'var(--mint)' : ($pct >= 50 ? 'var(--gold)' : 'var(--coral)'); ?>
          <div class="mat-item"><div class="mat-icon" style="background:<?= e($m['cor']) ?>18;color:<?= e($m['cor']) ?>"><?= e($m['icone']) ?></div><div class="mat-info"><div class="mat-top"><span class="mat-name"><?= e($m['nome']) ?></span><span class="mat-pct" style="color:<?= $cor ?>"><?= $pct ?>%</span></div><div class="mat-bar-bg"><div class="mat-bar" style="width:<?= $pct ?>%;background:<?= $cor ?>"></div></div></div></div>
        <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="empty-state"><p>Nenhum dado ainda.</p><a href="<?= url('simulado') ?>">Fazer primeiro simulado →</a></div>
      <?php endif; ?>
    </div>

    <div class="stack">
      <div class="panel">
        <div class="panel-title">🔥 Atividade da Semana</div>
        <div class="streak-widget"><div style="font-size:32px">🔥</div><div class="streak-info"><strong><?= (int) $user['streak'] ?> dia<?= (int) $user['streak'] !== 1 ? 's' : '' ?> seguido<?= (int) $user['streak'] !== 1 ? 's' : '' ?></strong><span>Continue estudando todo dia!</span></div></div>
        <div class="heatmap">
          <?php foreach ($semana as $dia): ?><div class="hmap-cell <?= $dia['cnt'] > 1 ? 'hot' : ($dia['cnt'] === 1 ? 'active' : '') ?>"><span class="hmap-day"><?= e(strtoupper(substr($dia['label'], 0, 2))) ?></span><span><?= $dia['cnt'] > 0 ? (int) $dia['cnt'] : '·' ?></span></div><?php endforeach; ?>
        </div>
      </div>
      <?php if (count($erros) > 0): ?>
      <div class="panel">
        <div class="panel-title">🔴 Questões Mais Erradas</div>
        <?php foreach ($erros as $erro): ?><div class="erro-item"><div class="erro-top"><span class="erro-mat"><?= e($erro['icone']) ?> <?= e($erro['materia']) ?> · <?= (int) $erro['tentativas'] ?> erros</span><span class="erro-pct"><?= (int) $erro['erro_pct'] ?>%</span></div><div class="erro-txt"><?= e($erro['enunciado']) ?></div></div><?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="panel" id="historico" style="margin-bottom:20px">
    <div class="panel-title">📁 Últimos Simulados <a href="<?= url('simulado') ?>">+ Novo</a></div>
    <?php if (count($ultimos) > 0): ?>
      <div class="sim-list">
      <?php foreach ($ultimos as $sim): $pct = (int) $sim['total'] > 0 ? round((int) $sim['acertos'] / (int) $sim['total'] * 100) : 0; $cor = $pct >= 70 ? 'var(--mint)' : ($pct >= 50 ? 'var(--gold)' : 'var(--coral)'); $min = floor((int) $sim['tempo_gasto'] / 60); $seg = (int) $sim['tempo_gasto'] % 60; ?>
        <div class="sim-item"><div class="sim-left"><div class="sim-circle" style="background:<?= $cor ?>18;color:<?= $cor ?>;border-color:<?= $cor ?>"><?= $pct ?>%</div><div class="sim-details"><strong><?= (int) $sim['acertos'] ?>/<?= (int) $sim['total'] ?> acertos (<?= $pct ?>%)</strong><span><?= e($sim['data_fmt']) ?> · <?= $min ?>m<?= $seg ?>s</span></div></div><div class="sim-xp">+<?= (int) $sim['xp_ganho'] ?> <small>XP</small></div></div>
      <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="empty-state"><p>Você ainda não fez nenhum simulado.</p><a href="<?= url('simulado') ?>">Começar agora →</a></div>
    <?php endif; ?>
  </div>

  <div class="panel" id="conquistas">
    <div class="panel-title">🏆 Conquistas (<?= count($conquistas) ?>/<?= count($todasConquistas) ?>)</div>
    <div class="badges-grid">
      <?php foreach ($todasConquistas as $c): $unlocked = in_array($c['chave'], $conquistasIds, true); ?>
        <div class="badge-item <?= $unlocked ? 'unlocked' : 'locked' ?>" title="<?= e($c['nome']) ?>: <?= e($c['descricao'] ?? '') ?>"><span class="badge-icon"><?= e($c['icone'] ?? '🏆') ?></span><span class="badge-name"><?= e($c['nome']) ?></span><?php if ($unlocked): ?><span style="font-family:'DM Mono';font-size:8px;color:var(--gold)">+<?= (int) $c['xp_bonus'] ?>XP</span><?php endif; ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</main>
</body>
</html>
