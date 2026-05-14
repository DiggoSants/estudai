<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Estudai — Sua direção de estudo inteligente</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
<style>
  :root {
    --bg: #060b18;
    --bg2: #080e1c;
    --card: #0d1628;
    --card2: #111e38;
    --accent: #00e5a0;
    --accent2: #00b8ff;
    --accent3: #ff6b6b;
    --text: #eef2ff;
    --muted: #6b7ba8;
    --border: rgba(255,255,255,0.06);
    --border2: rgba(255,255,255,0.1);
    --grad: linear-gradient(135deg, #00e5a0, #00b8ff);
    --grad-r: linear-gradient(135deg, #00b8ff, #00e5a0);
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  html { scroll-behavior: smooth; }

  body {
    background: var(--bg);
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    overflow-x: hidden;
    line-height: 1.6;
  }

  h1, h2, h3, h4, .logo-text, nav a { font-family: 'Syne', sans-serif; }

  /* ---- ATMOSPHERE ---- */
  .atmo {
    position: fixed; inset: 0; pointer-events: none; z-index: 0;
  }
  .atmo::before {
    content: '';
    position: absolute; inset: 0;
    background:
      radial-gradient(ellipse 1200px 700px at -10% 10%, rgba(0,229,160,0.055) 0%, transparent 65%),
      radial-gradient(ellipse 900px 600px at 110% 80%, rgba(0,184,255,0.055) 0%, transparent 65%),
      radial-gradient(ellipse 600px 400px at 50% 50%, rgba(0,100,255,0.025) 0%, transparent 70%);
  }

  /* Stars / particles */
  .stars {
    position: fixed; inset: 0; pointer-events: none; z-index: 0;
    background-image:
      radial-gradient(1px 1px at 15% 20%, rgba(255,255,255,0.35) 0%, transparent 100%),
      radial-gradient(1px 1px at 72% 8%, rgba(255,255,255,0.25) 0%, transparent 100%),
      radial-gradient(1px 1px at 38% 55%, rgba(255,255,255,0.2) 0%, transparent 100%),
      radial-gradient(1px 1px at 85% 35%, rgba(255,255,255,0.3) 0%, transparent 100%),
      radial-gradient(1px 1px at 5% 75%, rgba(255,255,255,0.2) 0%, transparent 100%),
      radial-gradient(1px 1px at 60% 90%, rgba(255,255,255,0.25) 0%, transparent 100%),
      radial-gradient(1.5px 1.5px at 92% 62%, rgba(0,229,160,0.5) 0%, transparent 100%),
      radial-gradient(1.5px 1.5px at 28% 40%, rgba(0,184,255,0.4) 0%, transparent 100%),
      radial-gradient(1px 1px at 50% 15%, rgba(255,255,255,0.3) 0%, transparent 100%),
      radial-gradient(1px 1px at 78% 78%, rgba(255,255,255,0.2) 0%, transparent 100%);
  }

  /* ---- NAV ---- */
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 100;
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 7%;
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    background: rgba(6,11,24,0.82);
    border-bottom: 1px solid var(--border);
  }

  .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }

  .logo-icon {
    width: 40px; height: 40px; border-radius: 11px;
    background: var(--grad);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif; font-weight: 800;
    color: #060b18; font-size: 18px;
    box-shadow: 0 0 20px rgba(0,229,160,0.3);
  }

  .logo-text {
    font-size: 22px; font-weight: 800;
    background: var(--grad); -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  }

  nav ul { list-style: none; display: flex; gap: 36px; }
  nav a { color: var(--muted); text-decoration: none; font-size: 14px; font-weight: 600; letter-spacing: 0.03em; transition: color 0.2s; }
  nav a:hover { color: var(--text); }

  .nav-cta {
    background: transparent;
    border: 1px solid rgba(0,229,160,0.4);
    padding: 10px 22px;
    border-radius: 8px; font-family: 'Syne', sans-serif; font-weight: 700;
    font-size: 14px; color: var(--accent); cursor: pointer;
    transition: all 0.25s;
  }
  .nav-cta:hover {
    background: rgba(0,229,160,0.1);
    border-color: var(--accent);
    box-shadow: 0 0 20px rgba(0,229,160,0.15);
  }

  /* ---- HERO ---- */
  .hero {
    position: relative; z-index: 1;
    min-height: 100vh;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    padding: 140px 6% 100px;
    text-align: center;
    overflow: hidden;
  }

  /* Large decorative orbs */
  .hero::before {
    content: '';
    position: absolute;
    width: 800px; height: 800px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(0,229,160,0.04) 0%, transparent 70%);
    top: 50%; left: 50%;
    transform: translate(-50%, -60%);
    pointer-events: none;
    animation: orbPulse 8s ease-in-out infinite;
  }

  .hero::after {
    content: '';
    position: absolute;
    width: 1200px; height: 400px;
    bottom: -200px; left: 50%; transform: translateX(-50%);
    background: radial-gradient(ellipse, rgba(0,184,255,0.06) 0%, transparent 70%);
    pointer-events: none;
  }

  @keyframes orbPulse {
    0%, 100% { opacity: 0.5; transform: translate(-50%, -60%) scale(1); }
    50% { opacity: 1; transform: translate(-50%, -60%) scale(1.05); }
  }

  .hero-inner { position: relative; z-index: 2; max-width: 860px; }

  .hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(0,229,160,0.08);
    border: 1px solid rgba(0,229,160,0.25);
    border-radius: 100px; padding: 7px 18px;
    font-size: 13px; color: var(--accent); font-weight: 500;
    margin-bottom: 36px;
    animation: fadeUp 0.7s ease both;
  }
  .hero-badge .dot { width: 7px; height: 7px; border-radius: 50%; background: var(--accent); display: block; animation: pulse 1.8s infinite; }

  .hero h1 {
    font-size: clamp(48px, 8vw, 96px);
    font-weight: 800; line-height: 1.0;
    margin-bottom: 28px; letter-spacing: -0.02em;
    animation: fadeUp 0.7s ease 0.1s both;
  }

  .hero h1 em {
    font-style: normal;
    background: var(--grad); -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  }

  .hero h1 .ghost {
    -webkit-text-fill-color: transparent;
    -webkit-text-stroke: 1px rgba(255,255,255,0.15);
    font-style: normal;
  }

  .hero p {
    font-size: clamp(17px, 2.2vw, 21px); color: var(--muted);
    max-width: 580px; margin: 0 auto 52px;
    line-height: 1.7;
    animation: fadeUp 0.7s ease 0.2s both;
  }

  .hero-actions {
    display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;
    animation: fadeUp 0.7s ease 0.3s both;
  }

  .btn-primary {
    background: var(--grad); border: none;
    padding: 18px 40px; border-radius: 12px;
    font-family: 'Syne', sans-serif; font-weight: 700; font-size: 16px;
    color: #060b18; cursor: pointer;
    transition: transform 0.25s, box-shadow 0.25s;
    box-shadow: 0 0 40px rgba(0,229,160,0.3), 0 4px 20px rgba(0,0,0,0.4);
    position: relative; overflow: hidden;
  }
  .btn-primary::after {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 60%);
  }
  .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 0 60px rgba(0,229,160,0.45), 0 8px 30px rgba(0,0,0,0.4); }

  .btn-secondary {
    background: rgba(255,255,255,0.04);
    border: 1px solid var(--border2);
    padding: 18px 40px; border-radius: 12px;
    font-family: 'Syne', sans-serif; font-weight: 700; font-size: 16px;
    color: var(--text); cursor: pointer;
    transition: all 0.25s;
    backdrop-filter: blur(8px);
  }
  .btn-secondary:hover { border-color: rgba(0,184,255,0.5); background: rgba(0,184,255,0.06); transform: translateY(-3px); }

  /* hero divider line */
  .hero-divider {
    width: 1px; height: 80px;
    background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.15), transparent);
    margin: 60px auto;
    animation: fadeUp 0.7s ease 0.4s both;
  }

  /* stats bar */
  .hero-stats {
    display: flex; gap: 0; justify-content: center;
    border: 1px solid var(--border);
    border-radius: 20px;
    background: rgba(13,22,40,0.8);
    backdrop-filter: blur(16px);
    overflow: hidden;
    animation: fadeUp 0.7s ease 0.45s both;
    max-width: 640px; margin: 0 auto;
  }

  .stat-item {
    flex: 1; padding: 28px 32px; text-align: center;
    border-right: 1px solid var(--border);
    position: relative;
  }
  .stat-item:last-child { border-right: none; }
  .stat-item::before {
    content: '';
    position: absolute; top: 0; left: 50%; transform: translateX(-50%);
    width: 60%; height: 1px;
    background: linear-gradient(to right, transparent, rgba(0,229,160,0.4), transparent);
  }

  .stat-num {
    font-family: 'Syne', sans-serif; font-size: 38px; font-weight: 800;
    background: var(--grad); -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    line-height: 1;
  }
  .stat-label { font-size: 12px; color: var(--muted); margin-top: 6px; line-height: 1.4; }

  /* scroll cue */
  .scroll-cue {
    position: absolute; bottom: 40px; left: 50%; transform: translateX(-50%);
    display: flex; flex-direction: column; align-items: center; gap: 8px;
    animation: fadeUp 1s ease 1s both;
    color: var(--muted); font-size: 11px; letter-spacing: 0.15em; text-transform: uppercase;
  }
  .scroll-cue-line {
    width: 1px; height: 48px;
    background: linear-gradient(to bottom, var(--muted), transparent);
    animation: scrollLine 2s ease-in-out infinite;
  }
  @keyframes scrollLine {
    0% { transform: scaleY(0); transform-origin: top; }
    50% { transform: scaleY(1); transform-origin: top; }
    51% { transform: scaleY(1); transform-origin: bottom; }
    100% { transform: scaleY(0); transform-origin: bottom; }
  }

  /* ---- SECTION COMMON ---- */
  section { position: relative; z-index: 1; padding: 130px 7%; }

  .section-tag {
    font-size: 11px; font-weight: 700; letter-spacing: 0.15em;
    text-transform: uppercase; color: var(--accent);
    margin-bottom: 16px;
    display: flex; align-items: center; gap: 10px;
  }
  .section-tag::before {
    content: '';
    display: inline-block; width: 24px; height: 1px;
    background: var(--accent);
  }

  .section-title {
    font-size: clamp(32px, 4.5vw, 56px); font-weight: 800;
    line-height: 1.08; margin-bottom: 20px; letter-spacing: -0.02em;
  }
  .section-title em { font-style: normal; background: var(--grad); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

  .section-sub { color: var(--muted); font-size: 18px; max-width: 520px; line-height: 1.7; }

  .section-header { margin-bottom: 80px; }
  .section-header.center { text-align: center; }
  .section-header.center .section-sub { margin: 0 auto; }
  .section-header.center .section-tag { justify-content: center; }
  .section-header.center .section-tag::before { display: none; }

  /* ---- HOW IT WORKS ---- */
  .how {
    background: var(--bg2);
    position: relative; overflow: hidden;
  }
  .how::before {
    content: '';
    position: absolute; right: -200px; top: -200px;
    width: 600px; height: 600px; border-radius: 50%;
    background: radial-gradient(circle, rgba(0,184,255,0.05) 0%, transparent 70%);
    pointer-events: none;
  }

  .steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1px; }

  .step {
    background: var(--card);
    padding: 52px 36px;
    position: relative; overflow: hidden;
    transition: background 0.3s;
  }
  .step::after {
    content: '';
    position: absolute; bottom: 0; left: 0; right: 0; height: 2px;
    background: var(--grad); transform: scaleX(0); transform-origin: left;
    transition: transform 0.4s ease;
  }
  .step:hover { background: var(--card2); }
  .step:hover::after { transform: scaleX(1); }
  .step:first-child { border-radius: 20px 0 0 20px; }
  .step:last-child { border-radius: 0 20px 20px 0; }

  .step-num {
    font-family: 'Syne', sans-serif; font-size: 80px; font-weight: 800;
    color: rgba(255,255,255,0.03); position: absolute; top: 16px; right: 16px;
    line-height: 1;
  }

  .step-icon {
    width: 56px; height: 56px; border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; margin-bottom: 28px;
  }

  .step-connector {
    display: none;
  }

  .step h3 { font-size: 19px; font-weight: 700; margin-bottom: 14px; line-height: 1.3; }
  .step p { font-size: 14px; color: var(--muted); line-height: 1.75; }

  /* ---- FEATURES ---- */
  .features-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: auto auto;
    gap: 20px;
  }

  .feature-card {
    background: var(--card); border: 1px solid var(--border);
    border-radius: 24px; padding: 44px 40px;
    transition: border-color 0.3s, transform 0.3s;
    cursor: default;
    position: relative; overflow: hidden;
  }
  .feature-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 1px;
    background: linear-gradient(to right, transparent, rgba(0,229,160,0.2), transparent);
    opacity: 0; transition: opacity 0.3s;
  }
  .feature-card:hover { border-color: rgba(0,229,160,0.2); transform: translateY(-4px); }
  .feature-card:hover::before { opacity: 1; }

  .feature-card.big {
    grid-row: span 2;
    background: linear-gradient(160deg, var(--card2) 0%, var(--card) 60%);
    border-color: rgba(0,229,160,0.12);
    display: flex; flex-direction: column; justify-content: space-between;
  }

  .feature-icon {
    width: 54px; height: 54px; border-radius: 15px;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; margin-bottom: 24px;
  }

  .feature-card h3 { font-size: 22px; font-weight: 700; margin-bottom: 12px; line-height: 1.3; }
  .feature-card p { font-size: 15px; color: var(--muted); line-height: 1.75; }

  .feature-demo {
    margin-top: 32px;
    background: rgba(0,0,0,0.35);
    border: 1px solid rgba(0,229,160,0.12);
    border-radius: 16px;
    padding: 24px 22px;
    font-family: 'DM Sans', monospace;
    font-size: 13px;
  }

  .demo-label { font-size: 11px; color: var(--muted); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 16px; }

  .demo-row { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
  .demo-row:last-child { margin-bottom: 0; }
  .demo-subject { width: 100px; font-size: 12px; color: var(--muted); flex-shrink: 0; }
  .demo-bar-bg { flex: 1; height: 6px; background: rgba(255,255,255,0.06); border-radius: 3px; overflow: hidden; }
  .demo-bar-fill { height: 100%; border-radius: 3px; background: var(--grad); }
  .demo-pct { font-size: 12px; color: var(--accent); width: 36px; text-align: right; flex-shrink: 0; }
  .demo-flag { font-size: 11px; width: 80px; text-align: right; flex-shrink: 0; }

  .feature-link {
    margin-top: 32px; font-size: 14px; color: var(--accent);
    display: flex; align-items: center; gap: 8px; cursor: pointer;
    font-weight: 600; transition: gap 0.2s;
  }
  .feature-link:hover { gap: 12px; }

  /* ---- QUIZ DEMO ---- */
  .quiz-section {
    background: var(--bg2);
    position: relative; overflow: hidden;
  }
  .quiz-section::after {
    content: '';
    position: absolute; left: -200px; bottom: -200px;
    width: 600px; height: 600px; border-radius: 50%;
    background: radial-gradient(circle, rgba(0,229,160,0.05) 0%, transparent 70%);
    pointer-events: none;
  }

  .quiz-wrapper {
    display: grid; grid-template-columns: 1fr 1.3fr; gap: 80px; align-items: center;
  }

  .quiz-text .section-sub { max-width: 380px; }

  .quiz-highlights { margin-top: 40px; display: flex; flex-direction: column; gap: 20px; }
  .quiz-hl {
    display: flex; align-items: flex-start; gap: 16px;
    padding: 20px; border-radius: 14px;
    background: var(--card); border: 1px solid var(--border);
  }
  .quiz-hl-icon { font-size: 20px; flex-shrink: 0; margin-top: 2px; }
  .quiz-hl-text h4 { font-size: 15px; font-weight: 700; margin-bottom: 4px; }
  .quiz-hl-text p { font-size: 13px; color: var(--muted); line-height: 1.6; }

  .quiz-card {
    background: var(--card2);
    border: 1px solid rgba(0,184,255,0.15);
    border-radius: 24px; padding: 36px;
    position: relative; z-index: 1;
    box-shadow: 0 40px 80px rgba(0,0,0,0.4), 0 0 60px rgba(0,184,255,0.05);
  }

  .quiz-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
  .quiz-tag-label { font-size: 12px; font-weight: 700; color: var(--accent2); letter-spacing: 0.1em; text-transform: uppercase; }
  .quiz-progress-badge {
    background: rgba(255,255,255,0.06); border-radius: 100px;
    padding: 4px 12px; font-size: 12px; color: var(--muted);
  }

  .quiz-bar { height: 3px; background: rgba(255,255,255,0.07); border-radius: 2px; margin-bottom: 32px; }
  .quiz-bar-fill { height: 100%; width: 60%; background: var(--grad); border-radius: 2px; }

  .quiz-question { font-size: 16px; font-weight: 500; margin-bottom: 24px; line-height: 1.65; }
  .quiz-options { display: flex; flex-direction: column; gap: 10px; }

  .quiz-opt {
    padding: 14px 18px; border-radius: 12px; font-size: 14px; cursor: pointer;
    border: 1px solid var(--border); background: var(--card);
    transition: all 0.2s; display: flex; align-items: center; gap: 12px;
  }
  .quiz-opt:hover { border-color: rgba(0,184,255,0.4); background: rgba(0,184,255,0.05); }
  .quiz-opt.correct { border-color: var(--accent); background: rgba(0,229,160,0.08); }
  .quiz-opt.wrong { border-color: var(--accent3); background: rgba(255,107,107,0.08); }
  .quiz-letter {
    width: 28px; height: 28px; border-radius: 8px;
    background: rgba(255,255,255,0.07);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif; font-weight: 700; font-size: 11px; flex-shrink: 0;
    letter-spacing: 0;
  }

  #quiz-feedback {
    display: none; margin-top: 20px; padding: 18px 20px;
    border-radius: 12px; font-size: 14px; line-height: 1.7;
    background: rgba(0,229,160,0.06); border: 1px solid rgba(0,229,160,0.18);
    color: var(--accent);
  }

  /* ---- PLANS ---- */
  .plans { background: var(--bg2); position: relative; }
  .plans-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; max-width: 820px; margin: 0 auto; }

  .plan-card {
    background: var(--card); border: 1px solid var(--border);
    border-radius: 24px; padding: 48px 40px;
    transition: transform 0.3s;
    position: relative;
  }
  .plan-card:hover { transform: translateY(-6px); }

  .plan-card.featured {
    border-color: rgba(0,229,160,0.3);
    background: linear-gradient(160deg, rgba(0,229,160,0.06) 0%, var(--card) 50%);
  }
  .plan-card.featured::before {
    content: '';
    position: absolute; inset: 0; border-radius: 24px;
    background: linear-gradient(160deg, rgba(0,229,160,0.06) 0%, transparent 60%);
    pointer-events: none;
  }

  .plan-badge {
    position: absolute; top: -16px; left: 50%; transform: translateX(-50%);
    background: var(--grad); color: #060b18;
    font-family: 'Syne', sans-serif; font-weight: 700; font-size: 12px;
    padding: 6px 20px; border-radius: 100px; white-space: nowrap;
    box-shadow: 0 4px 20px rgba(0,229,160,0.35);
    letter-spacing: 0.04em;
  }

  .plan-name { font-size: 13px; font-weight: 700; color: var(--muted); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 20px; }
  .plan-price {
    font-family: 'Syne', sans-serif; font-size: 60px; font-weight: 800; line-height: 1;
    margin-bottom: 8px; letter-spacing: -0.03em;
  }
  .plan-price sup { font-size: 22px; vertical-align: super; }
  .plan-price .period { font-size: 18px; color: var(--muted); font-weight: 400; }
  .plan-desc { font-size: 15px; color: var(--muted); margin-bottom: 36px; }
  .plan-divider { border: none; border-top: 1px solid var(--border); margin: 28px 0; }
  .plan-features { list-style: none; display: flex; flex-direction: column; gap: 14px; margin-bottom: 40px; }
  .plan-features li {
    display: flex; align-items: flex-start; gap: 12px;
    font-size: 14px; color: var(--muted); line-height: 1.5;
  }
  .plan-features li .check {
    width: 18px; height: 18px; border-radius: 50%;
    background: rgba(0,229,160,0.12); border: 1px solid rgba(0,229,160,0.3);
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; color: var(--accent); flex-shrink: 0; margin-top: 1px;
  }
  .plan-features li.off { color: rgba(107,123,168,0.4); }
  .plan-features li.off .check {
    background: rgba(255,255,255,0.04); border-color: rgba(255,255,255,0.08);
    color: rgba(107,123,168,0.4);
  }

  .btn-plan {
    width: 100%; padding: 16px; border-radius: 12px;
    font-family: 'Syne', sans-serif; font-weight: 700; font-size: 15px;
    cursor: pointer; transition: all 0.25s; border: none;
    letter-spacing: 0.02em;
  }
  .btn-plan-outline {
    background: transparent; border: 1px solid var(--border2); color: var(--text);
  }
  .btn-plan-outline:hover { border-color: rgba(0,229,160,0.4); color: var(--accent); }
  .btn-plan-filled {
    background: var(--grad); color: #060b18;
    box-shadow: 0 0 40px rgba(0,229,160,0.25), 0 4px 20px rgba(0,0,0,0.3);
  }
  .btn-plan-filled:hover { box-shadow: 0 0 60px rgba(0,229,160,0.45), 0 8px 30px rgba(0,0,0,0.4); transform: translateY(-2px); }

  /* ---- TESTIMONIALS ---- */
  .testimonials-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }

  .tcard {
    background: var(--card); border: 1px solid var(--border);
    border-radius: 20px; padding: 36px 32px;
    transition: border-color 0.3s, transform 0.3s;
    position: relative; overflow: hidden;
  }
  .tcard::before {
    content: '"';
    position: absolute; top: 16px; right: 24px;
    font-size: 80px; color: rgba(0,229,160,0.06);
    font-family: 'Syne', sans-serif; font-weight: 800;
    line-height: 1;
  }
  .tcard:hover { border-color: rgba(0,229,160,0.2); transform: translateY(-4px); }

  .tcard-stars { color: #ffd700; font-size: 12px; margin-bottom: 18px; letter-spacing: 3px; }
  .tcard-text { font-size: 15px; color: var(--muted); line-height: 1.75; margin-bottom: 28px; font-style: italic; }
  .tcard-author { display: flex; align-items: center; gap: 14px; }
  .tcard-avatar {
    width: 42px; height: 42px; border-radius: 50%;
    background: var(--grad); display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif; font-weight: 800; font-size: 15px; color: #060b18;
    flex-shrink: 0;
  }
  .tcard-name { font-size: 14px; font-weight: 700; }
  .tcard-role { font-size: 12px; color: var(--muted); margin-top: 2px; }

  /* ---- TRUST BAR ---- */
  .trust-bar {
    border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
    padding: 36px 7%; position: relative; z-index: 1;
    display: flex; align-items: center; justify-content: center; gap: 60px; flex-wrap: wrap;
  }
  .trust-item { display: flex; align-items: center; gap: 10px; color: var(--muted); font-size: 14px; font-weight: 500; }
  .trust-icon { font-size: 20px; }

  /* ---- CTA ---- */
  .cta-section {
    text-align: center; padding: 160px 6%;
    position: relative; z-index: 1;
    background: radial-gradient(ellipse 100% 80% at 50% 50%, rgba(0,229,160,0.055) 0%, transparent 70%);
  }

  .cta-section::before {
    content: '';
    position: absolute; inset: 0;
    background:
      radial-gradient(ellipse 500px 200px at 20% 100%, rgba(0,184,255,0.04) 0%, transparent 70%),
      radial-gradient(ellipse 500px 200px at 80% 0%, rgba(0,229,160,0.04) 0%, transparent 70%);
    pointer-events: none;
  }

  .cta-inner { max-width: 680px; margin: 0 auto; }

  .cta-section h2 {
    font-size: clamp(36px, 5.5vw, 68px); font-weight: 800;
    line-height: 1.05; margin-bottom: 24px; letter-spacing: -0.02em;
  }
  .cta-section h2 em { font-style: normal; background: var(--grad); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
  .cta-section > .cta-inner > p { color: var(--muted); font-size: 19px; margin-bottom: 48px; line-height: 1.7; }

  .email-form {
    display: flex; gap: 10px;
    background: rgba(13,22,40,0.9);
    border: 1px solid var(--border2);
    border-radius: 16px; padding: 8px 8px 8px 24px;
    box-shadow: 0 0 60px rgba(0,229,160,0.08);
    max-width: 520px; margin: 0 auto;
  }
  .email-form input {
    flex: 1; background: transparent; border: none; outline: none;
    font-family: 'DM Sans', sans-serif; font-size: 16px; color: var(--text);
  }
  .email-form input::placeholder { color: var(--muted); }
  .email-form button {
    background: var(--grad); border: none; padding: 14px 28px;
    border-radius: 10px; font-family: 'Syne', sans-serif; font-weight: 700;
    font-size: 14px; color: #060b18; cursor: pointer; white-space: nowrap;
    transition: opacity 0.2s, transform 0.2s;
  }
  .email-form button:hover { opacity: 0.88; transform: scale(1.02); }

  .cta-note { font-size: 12px; color: var(--muted); margin-top: 16px; }

  /* ---- FOOTER ---- */
  footer {
    border-top: 1px solid var(--border);
    padding: 64px 7% 40px;
    position: relative; z-index: 1;
  }

  .footer-top {
    display: flex; justify-content: space-between; align-items: flex-start;
    flex-wrap: wrap; gap: 48px; margin-bottom: 56px;
  }

  .footer-brand .logo-text { font-size: 24px; }
  .footer-tagline { font-size: 14px; color: var(--muted); margin-top: 12px; line-height: 1.7; max-width: 260px; }

  .footer-links { display: flex; gap: 64px; flex-wrap: wrap; }
  .footer-col h4 { font-size: 12px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--text); margin-bottom: 20px; }
  .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 12px; }
  .footer-col a { color: var(--muted); text-decoration: none; font-size: 14px; transition: color 0.2s; }
  .footer-col a:hover { color: var(--text); }

  .footer-bottom {
    display: flex; justify-content: space-between; flex-wrap: wrap; gap: 8px;
    border-top: 1px solid var(--border); padding-top: 28px;
  }
  .footer-bottom p { font-size: 13px; color: var(--muted); }

  /* ---- ANIMATIONS ---- */
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
  }
  @keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(0.7); }
  }

  .reveal {
    opacity: 0; transform: translateY(36px);
    transition: opacity 0.7s ease, transform 0.7s ease;
  }
  .reveal.visible { opacity: 1; transform: none; }

  /* ---- MODAL ---- */
  .modal-overlay {
    display: none; position: fixed; inset: 0; z-index: 200;
    background: rgba(0,0,0,0.75); backdrop-filter: blur(12px);
    align-items: center; justify-content: center;
  }
  .modal-overlay.open { display: flex; }
  .modal {
    background: var(--card2); border: 1px solid rgba(0,229,160,0.2);
    border-radius: 28px; padding: 52px 44px; max-width: 440px; width: 90%;
    text-align: center; position: relative;
    box-shadow: 0 40px 80px rgba(0,0,0,0.6), 0 0 60px rgba(0,229,160,0.08);
    animation: fadeUp 0.4s ease both;
  }
  .modal h2 { font-size: 28px; margin-bottom: 10px; letter-spacing: -0.01em; }
  .modal p { color: var(--muted); font-size: 15px; margin-bottom: 32px; line-height: 1.6; }
  .modal-close {
    position: absolute; top: 22px; right: 22px;
    background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 8px;
    color: var(--muted); font-size: 16px; cursor: pointer;
    width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
  }
  .modal-close:hover { color: var(--text); background: rgba(255,255,255,0.1); }
  .modal-input {
    width: 100%; background: var(--card); border: 1px solid var(--border);
    border-radius: 12px; padding: 15px 18px;
    font-family: 'DM Sans', sans-serif; font-size: 15px; color: var(--text);
    outline: none; margin-bottom: 12px; transition: border-color 0.2s;
  }
  .modal-input:focus { border-color: var(--accent); }
  .modal-btn {
    width: 100%; background: var(--grad); border: none;
    padding: 16px; border-radius: 12px;
    font-family: 'Syne', sans-serif; font-weight: 700; font-size: 16px;
    color: #060b18; cursor: pointer; transition: opacity 0.2s, transform 0.2s;
    box-shadow: 0 0 30px rgba(0,229,160,0.25);
    margin-top: 4px;
  }
  .modal-btn:hover { opacity: 0.88; transform: translateY(-1px); }
  .modal-note { font-size: 12px; color: var(--muted); margin-top: 16px; }

  .modal-success { display: none; }
  .modal-success .checkmark { font-size: 52px; margin-bottom: 16px; }

  /* ---- RESPONSIVE ---- */
  @media (max-width: 900px) {
    .steps { grid-template-columns: 1fr 1fr; }
    .step:first-child { border-radius: 20px 0 0 0; }
    .step:nth-child(2) { border-radius: 0 20px 0 0; }
    .step:nth-child(3) { border-radius: 0 0 0 20px; }
    .step:last-child { border-radius: 0 0 20px 0; }
    .features-grid { grid-template-columns: 1fr; }
    .feature-card.big { grid-row: auto; }
    .quiz-wrapper { grid-template-columns: 1fr; gap: 48px; }
    .testimonials-grid { grid-template-columns: 1fr; }
    .plans-grid { grid-template-columns: 1fr; max-width: 480px; }
    nav ul { display: none; }
  }

  @media (max-width: 600px) {
    section { padding: 80px 5%; }
    .hero { padding: 120px 5% 80px; }
    .steps { grid-template-columns: 1fr; }
    .step { border-radius: 20px !important; }
    .hero-stats { flex-direction: column; border-radius: 20px; }
    .stat-item { border-right: none; border-bottom: 1px solid var(--border); }
    .stat-item:last-child { border-bottom: none; }
  }
</style>
</head>
<body>

<div class="atmo"></div>
<div class="stars"></div>

<!-- NAV -->
<nav>
  <a href="#" class="logo">
    <div class="logo-icon">E</div>
    <span class="logo-text">Estudai</span>
  </a>
  <ul>
    <li><a href="#como-funciona">Como funciona</a></li>
    <li><a href="#funcionalidades">Funcionalidades</a></li>
    <li><a href="#planos">Planos</a></li>
    <li><a href="#depoimentos">Depoimentos</a></li>
  </ul>
  <button class="nav-cta" onclick="openModal()">Começar grátis</button>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-inner">
    <div class="hero-badge">
      <span class="dot"></span>
      Plataforma com IA para vestibulares
    </div>
    <h1>Pare de estudar no<br><em>escuro.</em></h1>
    <p>O Estudai analisa seu desempenho e indica exatamente o que você precisa revisar. Nada de tempo perdido. Só evolução real.</p>
    <div class="hero-actions">
      <button class="btn-primary" onclick="openModal()">Criar conta grátis →</button>
      <a href="#como-funciona"><button class="btn-secondary">Ver como funciona</button></a>
    </div>
    <div class="hero-divider"></div>
    <div class="hero-stats">
      <div class="stat-item">
        <div class="stat-num">87%</div>
        <div class="stat-label">de aprovação<br>em simulados</div>
      </div>
      <div class="stat-item">
        <div class="stat-num">3×</div>
        <div class="stat-label">mais eficiência<br>nos estudos</div>
      </div>
      <div class="stat-item">
        <div class="stat-num">10k+</div>
        <div class="stat-label">questões na<br>plataforma</div>
      </div>
    </div>
  </div>
  <div class="scroll-cue">
    <div class="scroll-cue-line"></div>
  </div>
</section>

<!-- TRUST BAR -->
<div class="trust-bar">
  <div class="trust-item"><span class="trust-icon">🎓</span> ENEM & vestibulares</div>
  <div class="trust-item"><span class="trust-icon">🔒</span> Dados seguros</div>
  <div class="trust-item"><span class="trust-icon">⚡</span> Diagnóstico em minutos</div>
  <div class="trust-item"><span class="trust-icon">🆓</span> Grátis para começar</div>
</div>

<!-- COMO FUNCIONA -->
<section class="how" id="como-funciona">
  <div class="section-header center reveal">
    <div class="section-tag">Como funciona</div>
    <h2 class="section-title">Simples assim<br>em <em>4 passos</em></h2>
  </div>
  <div class="steps">
    <div class="step reveal">
      <div class="step-num">01</div>
      <div class="step-icon" style="background:rgba(0,229,160,0.1)">🎯</div>
      <h3>Defina seu objetivo</h3>
      <p>Informe para qual vestibular você está se preparando e quando é a prova. A IA cria seu plano personalizado em segundos.</p>
    </div>
    <div class="step reveal">
      <div class="step-num">02</div>
      <div class="step-icon" style="background:rgba(0,184,255,0.1)">📝</div>
      <h3>Faça os simulados</h3>
      <p>Simulados organizados por matéria e nível de dificuldade, com questões de provas reais dos últimos anos.</p>
    </div>
    <div class="step reveal">
      <div class="step-num">03</div>
      <div class="step-icon" style="background:rgba(255,107,107,0.1)">🧠</div>
      <h3>Receba o diagnóstico</h3>
      <p>A plataforma identifica exatamente onde você erra e por quê, criando um mapa preciso das suas lacunas.</p>
    </div>
    <div class="step reveal">
      <div class="step-num">04</div>
      <div class="step-icon" style="background:rgba(0,229,160,0.1)">📈</div>
      <h3>Siga a trilha</h3>
      <p>Receba conteúdo direcionado apenas para os seus pontos fracos. Sem desperdício de tempo. Só evolução real.</p>
    </div>
  </div>
</section>

<!-- FUNCIONALIDADES -->
<section id="funcionalidades">
  <div class="section-header reveal">
    <div class="section-tag">Funcionalidades</div>
    <h2 class="section-title">Tudo que você precisa<br><em>em um lugar</em></h2>
    <p class="section-sub">Ferramentas inteligentes pensadas para quem quer resultado de verdade.</p>
  </div>
  <div class="features-grid">
    <div class="feature-card big reveal">
      <div>
        <div class="feature-icon" style="background:rgba(0,229,160,0.1)">🗺️</div>
        <h3>Mapa Inteligente de Aprendizado</h3>
        <p>Visualize em tempo real quais matérias e tópicos estão fracos, em progresso ou dominados. A IA recomenda o próximo passo com base no seu histórico e no calendário da prova.</p>
        <div class="feature-demo">
          <div class="demo-label">// Análise atual — Matemática</div>
          <div class="demo-row">
            <div class="demo-subject" style="color:var(--text)">Funções</div>
            <div class="demo-bar-bg"><div class="demo-bar-fill" style="width:94%"></div></div>
            <div class="demo-pct">94%</div>
            <div class="demo-flag" style="color:var(--accent);font-size:11px">✓ ok</div>
          </div>
          <div class="demo-row">
            <div class="demo-subject" style="color:#ffd700">Geometria</div>
            <div class="demo-bar-bg"><div class="demo-bar-fill" style="width:41%; background:linear-gradient(135deg,#ffd700,#ff9500)"></div></div>
            <div class="demo-pct" style="color:#ffd700">41%</div>
            <div class="demo-flag" style="color:#ffd700;font-size:11px">⚠ revisar</div>
          </div>
          <div class="demo-row">
            <div class="demo-subject" style="color:var(--accent3)">Probabilidade</div>
            <div class="demo-bar-bg"><div class="demo-bar-fill" style="width:22%; background:linear-gradient(135deg,#ff6b6b,#ff4444)"></div></div>
            <div class="demo-pct" style="color:var(--accent3)">22%</div>
            <div class="demo-flag" style="color:var(--accent3);font-size:11px">← urgente</div>
          </div>
        </div>
      </div>
      <div class="feature-link" onclick="openModal()">
        Ver meu mapa →
      </div>
    </div>

    <div class="feature-card reveal">
      <div class="feature-icon" style="background:rgba(0,184,255,0.1)">⚡</div>
      <h3>Feedback imediato</h3>
      <p>Após cada questão, você recebe a explicação detalhada do erro com a resolução passo a passo. Aprende na hora, sem deixar dúvida acumular.</p>
    </div>

    <div class="feature-card reveal">
      <div class="feature-icon" style="background:rgba(255,107,107,0.1)">🔔</div>
      <h3>Acompanhamento contínuo</h3>
      <p>Notificações e relatórios semanais de evolução. Veja quanto você melhorou em cada matéria ao longo do tempo.</p>
    </div>

    <div class="feature-card reveal">
      <div class="feature-icon" style="background:rgba(0,229,160,0.1)">📊</div>
      <h3>Relatórios detalhados</h3>
      <p>Gráficos claros de desempenho por matéria, por período e comparado com outros alunos do mesmo objetivo.</p>
    </div>
  </div>
</section>

<!-- SIMULADO DEMO -->
<section class="quiz-section">
  <div class="quiz-wrapper">
    <div class="quiz-text reveal">
      <div class="section-tag">Experimente agora</div>
      <h2 class="section-title">Veja como é um<br><em>simulado real</em></h2>
      <p class="section-sub">Questões de provas reais com feedback instantâneo e explicação completa após cada resposta.</p>
      <div class="quiz-highlights">
        <div class="quiz-hl">
          <div class="quiz-hl-icon">🎯</div>
          <div class="quiz-hl-text">
            <h4>Nível adaptativo</h4>
            <p>A dificuldade das questões se ajusta automaticamente ao seu desempenho.</p>
          </div>
        </div>
        <div class="quiz-hl">
          <div class="quiz-hl-icon">💡</div>
          <div class="quiz-hl-text">
            <h4>Explicação completa</h4>
            <p>Cada acerto e erro vem acompanhado de resolução passo a passo.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="quiz-card reveal" id="quiz">
      <div class="quiz-header">
        <div class="quiz-tag-label">Matemática — ENEM 2023</div>
        <div class="quiz-progress-badge">Questão 3 de 5</div>
      </div>
      <div class="quiz-bar"><div class="quiz-bar-fill"></div></div>
      <div class="quiz-question">Uma sequência aritmética tem primeiro termo a₁ = 3 e razão r = 4. Qual é o valor do 10º termo dessa sequência?</div>
      <div class="quiz-options" id="quizOpts">
        <div class="quiz-opt" onclick="answer(this, false)">
          <span class="quiz-letter">A</span> 35
        </div>
        <div class="quiz-opt" onclick="answer(this, false)">
          <span class="quiz-letter">B</span> 40
        </div>
        <div class="quiz-opt" onclick="answer(this, true)">
          <span class="quiz-letter">C</span> 39
        </div>
        <div class="quiz-opt" onclick="answer(this, false)">
          <span class="quiz-letter">D</span> 43
        </div>
      </div>
      <div id="quiz-feedback">
        ✓ Correto! aₙ = a₁ + (n−1)·r → a₁₀ = 3 + 9×4 = 3 + 36 = <strong>39</strong>. A fórmula geral da PA é a chave aqui.
      </div>
    </div>
  </div>
</section>

<!-- PLANOS -->
<section class="plans" id="planos">
  <div class="section-header center reveal">
    <div class="section-tag">Planos</div>
    <h2 class="section-title">Comece <em>grátis,</em><br>evolua quando quiser</h2>
  </div>
  <div class="plans-grid">
    <div class="plan-card reveal">
      <div class="plan-name">Gratuito</div>
      <div class="plan-price"><sup>R$</sup>0</div>
      <div class="plan-desc">Para conhecer a plataforma</div>
      <hr class="plan-divider">
      <ul class="plan-features">
        <li><span class="check">✓</span> 5 simulados por mês</li>
        <li><span class="check">✓</span> Feedback básico por questão</li>
        <li><span class="check">✓</span> Mapa de desempenho simplificado</li>
        <li><span class="check">✓</span> Acesso às matérias do ENEM</li>
        <li class="off"><span class="check">✕</span> Trilhas personalizadas</li>
        <li class="off"><span class="check">✕</span> Relatórios detalhados</li>
        <li class="off"><span class="check">✕</span> Suporte prioritário</li>
      </ul>
      <button class="btn-plan btn-plan-outline" onclick="openModal()">Criar conta grátis</button>
    </div>

    <div class="plan-card featured reveal">
      <div class="plan-badge">✦ Mais popular</div>
      <div class="plan-name">Premium</div>
      <div class="plan-price"><sup>R$</sup>29<span class="period">/mês</span></div>
      <div class="plan-desc">Para quem quer ser aprovado</div>
      <hr class="plan-divider">
      <ul class="plan-features">
        <li><span class="check">✓</span> Simulados ilimitados</li>
        <li><span class="check">✓</span> Feedback detalhado com resolução</li>
        <li><span class="check">✓</span> Mapa de aprendizado completo</li>
        <li><span class="check">✓</span> Acesso a todos os vestibulares</li>
        <li><span class="check">✓</span> Trilhas personalizadas por IA</li>
        <li><span class="check">✓</span> Relatórios semanais detalhados</li>
        <li><span class="check">✓</span> Suporte via chat</li>
      </ul>
      <button class="btn-plan btn-plan-filled" onclick="openModal()">Começar agora →</button>
    </div>
  </div>
</section>

<!-- DEPOIMENTOS -->
<section id="depoimentos">
  <div class="section-header center reveal">
    <div class="section-tag">Depoimentos</div>
    <h2 class="section-title">Alunos que<br><em>transformaram</em> seus estudos</h2>
  </div>
  <div class="testimonials-grid">
    <div class="tcard reveal">
      <div class="tcard-stars">★★★★★</div>
      <p class="tcard-text">"Em 3 meses usando o Estudai, minha nota em Matemática foi de 620 para 740 no ENEM. O mapa de desempenho é genial, sempre sabe o que eu preciso estudar."</p>
      <div class="tcard-author">
        <div class="tcard-avatar">A</div>
        <div>
          <div class="tcard-name">Ana Beatriz</div>
          <div class="tcard-role">Aprovada em Medicina — UFC</div>
        </div>
      </div>
    </div>
    <div class="tcard reveal">
      <div class="tcard-stars">★★★★★</div>
      <p class="tcard-text">"Tentei o FUVEST por 2 anos sem resultado. No terceiro ano usei o Estudai do zero e a diferença foi absurda. A plataforma me mostrou que eu perdia tempo com o que já sabia."</p>
      <div class="tcard-author">
        <div class="tcard-avatar">L</div>
        <div>
          <div class="tcard-name">Lucas Mendes</div>
          <div class="tcard-role">Aprovado em Engenharia — USP</div>
        </div>
      </div>
    </div>
    <div class="tcard reveal">
      <div class="tcard-stars">★★★★★</div>
      <p class="tcard-text">"Nunca gostei de estudar, mas o Estudai mudou isso. As trilhas são tão específicas que fica fácil de focar. Aprovada na primeira tentativa!"</p>
      <div class="tcard-author">
        <div class="tcard-avatar">M</div>
        <div>
          <div class="tcard-name">Marina Costa</div>
          <div class="tcard-role">Aprovada em Direito — UFCE</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA FINAL -->
<section class="cta-section reveal">
  <div class="cta-inner">
    <h2>Sua aprovação<br>começa <em>hoje.</em></h2>
    <p>Crie sua conta grátis, faça seu primeiro diagnóstico e veja onde realmente está seu estudo.</p>
    <div class="email-form">
      <input type="email" placeholder="Seu melhor e-mail" id="heroEmail">
      <button onclick="openModalFromEmail()">Começar grátis →</button>
    </div>
    <p class="cta-note">Sem cartão de crédito. Começa em menos de 1 minuto.</p>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-top">
    <div class="footer-brand">
      <a href="#" class="logo" style="text-decoration:none">
        <div class="logo-icon">E</div>
        <span class="logo-text">Estudai</span>
      </a>
      <p class="footer-tagline">Plataforma inteligente que transforma desempenho em direção de estudo eficiente.</p>
    </div>
    <div class="footer-links">
      <div class="footer-col">
        <h4>Produto</h4>
        <ul>
          <li><a href="#como-funciona">Como funciona</a></li>
          <li><a href="#funcionalidades">Funcionalidades</a></li>
          <li><a href="#planos">Planos</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Empresa</h4>
        <ul>
          <li><a href="#">Sobre nós</a></li>
          <li><a href="#">Blog</a></li>
          <li><a href="#">Parcerias</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Suporte</h4>
        <ul>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Contato</a></li>
          <li><a href="#">Termos de uso</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <p>© 2026 Estudai. Todos os direitos reservados.</p>
    <p>Feito com ☕ para quem quer passar.</p>
  </div>
</footer>

<!-- MODAL -->
<div class="modal-overlay" id="modal" onclick="closeModalOutside(event)">
  <div class="modal">
    <button class="modal-close" onclick="closeModal()">✕</button>
    <div id="modal-form">
      <div style="font-size:40px; margin-bottom:18px;">🎯</div>
      <h2>Crie sua conta grátis</h2>
      <p>Comece hoje. Sem cartão de crédito necessário.</p>
      <input class="modal-input" type="text" placeholder="Seu nome" id="modalName">
      <input class="modal-input" type="email" placeholder="Seu e-mail" id="modalEmail">
      <button class="modal-btn" onclick="submitForm()">Começar minha jornada →</button>
      <p class="modal-note">Ao criar sua conta você concorda com os termos de uso.</p>
    </div>
    <div class="modal-success" id="modal-success">
      <div class="checkmark">✅</div>
      <h2>Tudo certo!</h2>
      <p>Sua conta foi criada. Você receberá um e-mail com o acesso em breve.</p>
    </div>
  </div>
</div>

<script>
  const revealEls = document.querySelectorAll('.reveal');
  const observer = new IntersectionObserver(entries => {
    entries.forEach((e, i) => {
      if (e.isIntersecting) {
        setTimeout(() => e.target.classList.add('visible'), i * 90);
        observer.unobserve(e.target);
      }
    });
  }, { threshold: 0.1 });
  revealEls.forEach(el => observer.observe(el));

  function answer(el, correct) {
    const opts = document.querySelectorAll('.quiz-opt');
    opts.forEach(o => { o.onclick = null; o.style.opacity = '0.45'; });
    el.style.opacity = '1';
    el.classList.add(correct ? 'correct' : 'wrong');
    if (!correct) { opts[2].classList.add('correct'); opts[2].style.opacity = '1'; }
    document.getElementById('quiz-feedback').style.display = 'block';
  }

  function openModal() { document.getElementById('modal').classList.add('open'); }
  function openModalFromEmail() {
    const email = document.getElementById('heroEmail').value;
    openModal();
    if (email) document.getElementById('modalEmail').value = email;
  }
  function closeModal() { document.getElementById('modal').classList.remove('open'); }
  function closeModalOutside(e) { if (e.target === document.getElementById('modal')) closeModal(); }
  function submitForm() {
    const name = document.getElementById('modalName').value;
    const email = document.getElementById('modalEmail').value;
    if (!name || !email) { alert('Preencha todos os campos!'); return; }
    document.getElementById('modal-form').style.display = 'none';
    document.getElementById('modal-success').style.display = 'block';
    setTimeout(closeModal, 3000);
  }
</script>
</body>
</html>