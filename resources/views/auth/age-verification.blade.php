<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Access Verification — Wismilak Premium Cigars</title>
<link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --gold: #D4AF37; --gold-light: #F4D03F; --charcoal: #0D0805;
    --tobacco: #1C0F06; --cream: #F5EBE0;
    --glass: rgba(13, 8, 5, 0.8);
    --glass-border: rgba(212, 175, 55, 0.25);
  }
  html, body { height: 100%; overflow: hidden; background: var(--charcoal); }
  body {
    font-family: 'Inter', sans-serif;
    color: var(--cream);
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    position: relative;
  }

  /* Cinematic Overlays */
  .noise {
    position: fixed; inset: 0; z-index: 1;
    background: url('https://grainy-gradients.vercel.app/noise.svg');
    opacity: 0.04; pointer-events: none; mix-blend-mode: overlay;
  }
  .vignette {
    position: fixed; inset: 0; z-index: 2;
    background: radial-gradient(circle, transparent 30%, rgba(0,0,0,0.9) 100%);
    pointer-events: none;
  }
  .page-bg {
    position: fixed; inset: 0;
    background: url('/images/age-bg.png') center/cover no-repeat;
    z-index: 0; filter: brightness(0.6);
    transition: transform 10s ease-out;
  }
  body:hover .page-bg { transform: scale(1.05); }

  .verification-card {
    position: relative; z-index: 10;
    max-width: 500px; width: 90%;
    background: var(--glass);
    backdrop-filter: blur(40px);
    -webkit-backdrop-filter: blur(40px);
    border: 1px solid var(--glass-border);
    padding: 3.5rem 2.5rem;
    border-radius: 40px;
    text-align: center;
    box-shadow: 0 50px 120px -30px rgba(0,0,0,0.9);
    animation: fadeInUp 1.2s ease-out forwards;
  }

  .logo-wrapper {
    margin-bottom: 1.5rem;
    display: flex;
    justify-content: center;
  }
  .logo-wrapper img {
    height: 60px;
    width: auto;
    filter: drop-shadow(0 0 15px rgba(212,175,55,0.3));
  }

  .logo-tag {
    font-size: .75rem; letter-spacing: .6em; color: var(--gold);
    text-transform: uppercase; margin-bottom: 1.5rem;
  }
  .title {
    font-family: 'Crimson Pro', serif;
    font-size: 3rem; font-weight: 300; margin-bottom: 1.5rem;
    letter-spacing: -0.02em; line-height: 1.1;
  }
  .title em { font-style: italic; color: var(--gold); font-weight: 400; }
  .desc {
    font-size: 1rem; color: rgba(245,235,224,0.5);
    line-height: 1.7; margin-bottom: 2.5rem; font-weight: 300;
  }

  .btn-group {
    display: flex; flex-direction: column; gap: 1.2rem;
  }
  .btn-verify {
    padding: 1.2rem;
    background: linear-gradient(135deg, #B8860B, var(--gold), var(--gold-light));
    color: #000; border: none; border-radius: 16px;
    font-size: 1.1rem; font-weight: 800; text-transform: uppercase;
    letter-spacing: .15em; cursor: pointer; transition: all 0.5s;
    position: relative; overflow: hidden;
  }
  .btn-verify:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(212,175,55,0.4); }
  
  .btn-reject {
    padding: 1.2rem;
    background: none; border: 1px solid rgba(255,255,255,.1);
    color: rgba(245,235,224,.4); border-radius: 16px;
    font-size: 1rem; text-transform: uppercase;
    letter-spacing: .1em; cursor: pointer; transition: all 0.4s;
  }
  .btn-reject:hover { border-color: #EF4444; color: #EF4444; }

  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @media (max-width: 480px) {
    .verification-card { padding: 3rem 2rem; }
    .title { font-size: 2.2rem; }
  }
</style>
</head>
<body>

<div class="noise"></div>
<div class="vignette"></div>
<div class="page-bg" id="heroBg"></div>

<div class="verification-card">
  <div class="logo-wrapper">
    <img src="{{ asset('images/logo.png') }}" alt="Wismilak Logo">
  </div>
  <p class="logo-tag">Heritage of Excellence</p>
  <h1 class="title">Are you of<br><em>Legal Age?</em></h1>
  <p class="desc">
    Wismilak Premium Cigars is intended for adults of legal smoking age (21+). By entering, you certify that you meet this requirement.
  </p>

  <form action="{{ route('age.verify') }}" method="POST" class="btn-group">
    @csrf
    <button type="submit" name="verified" value="1" class="btn-verify">I am 21 or older</button>
    <button type="submit" name="verified" value="0" class="btn-reject">Exit Website</button>
  </form>
</div>


</body>
</html>
