<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verify Email — Wismilak Premium Cigars</title>
<link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --gold: #D4AF37; --gold-light: #F4D03F; --charcoal: #0D0805;
    --tobacco: #1C0F06; --cream: #F5EBE0;
    --glass: rgba(13, 8, 5, 0.75);
    --glass-border: rgba(212, 175, 55, 0.25);
  }
  html, body { height: 100%; overflow: hidden; background: var(--charcoal); }
  body {
    font-family: 'Inter', sans-serif;
    color: var(--cream);
    display: flex;
    min-height: 100vh;
  }

  /* Cinematic Overlays */
  .noise {
    position: fixed; inset: 0; z-index: 10;
    background: url('https://grainy-gradients.vercel.app/noise.svg');
    opacity: 0.05; pointer-events: none; mix-blend-mode: overlay;
  }
  .vignette {
    position: fixed; inset: 0; z-index: 11;
    background: radial-gradient(circle, transparent 40%, rgba(0,0,0,0.8) 100%);
    pointer-events: none;
  }

  /* LEFT PANEL */
  .left-panel {
    flex: 1.3;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 5rem;
  }
  .parallax-bg {
    position: absolute; inset: 0;
    background: url('/images/verify-bg.png') center/cover no-repeat;
    z-index: 0;
    filter: brightness(0.7) contrast(1.1);
    transition: transform 10s ease-out;
  }
  .left-panel:hover .parallax-bg { transform: scale(1.05); }
  .left-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, rgba(13,8,5,0.1) 0%, rgba(13,8,5,0.9) 100%);
    z-index: 1;
  }
  .left-content { position: relative; z-index: 2; }
  
  .brand-tag {
    font-size: .8rem; letter-spacing: .5em; color: var(--gold);
    text-transform: uppercase; margin-bottom: 2rem;
    animation: fadeInUp 0.8s ease-out forwards;
  }
  .brand-headline {
    font-family: 'Crimson Pro', serif;
    font-size: clamp(3.5rem, 6vw, 5rem); font-weight: 300;
    line-height: 1; color: var(--cream); margin-bottom: 2rem;
    letter-spacing: -0.02em;
    animation: fadeInUp 0.8s ease-out 0.2s forwards;
    opacity: 0;
  }
  .brand-headline em { font-style: italic; color: var(--gold); font-weight: 400; }
  .brand-desc {
    font-size: 1.1rem; color: rgba(245,235,224,0.6);
    line-height: 1.8; max-width: 550px; font-weight: 300;
    animation: fadeInUp 0.8s ease-out 0.4s forwards;
    opacity: 0;
  }

  /* RIGHT PANEL */
  .right-panel {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem;
    background: #0D0805;
    position: relative;
    z-index: 20;
  }
  .form-container {
    width: 100%;
    max-width: 480px;
    background: var(--glass);
    backdrop-filter: blur(30px);
    -webkit-backdrop-filter: blur(30px);
    border: 1px solid var(--glass-border);
    padding: 4rem;
    border-radius: 32px;
    box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.8);
    animation: fadeInRight 1s ease-out 0.3s forwards;
    opacity: 0;
  }

  .form-header { text-align: center; margin-bottom: 3.5rem; }
  .form-tag {
    font-size: .7rem; letter-spacing: .4em; color: var(--gold);
    text-transform: uppercase; margin-bottom: 1.2rem;
  }
  .form-title {
    font-family: 'Crimson Pro', serif;
    font-size: 2.8rem; font-weight: 400; margin-bottom: .5rem;
    letter-spacing: -0.02em;
  }
  .form-subtitle { font-size: 1rem; color: rgba(245,235,224,.4); font-weight: 300; line-height: 1.7; }

  .btn-primary {
    width: 100%; padding: 1.2rem;
    background: linear-gradient(135deg, #B8860B 0%, var(--gold) 50%, var(--gold-light) 100%);
    color: #000; border: none; border-radius: 16px;
    font-size: 1rem; font-weight: 800; letter-spacing: .1em;
    font-family: 'Inter', sans-serif; cursor: pointer;
    transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
    text-transform: uppercase;
    position: relative; overflow: hidden;
  }
  .btn-primary:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(212,175,55,0.4); }

  .btn-logout {
    background: none; border: 1px solid rgba(255,255,255,.1); color: rgba(245,235,224,.4);
    border-radius: 16px; padding: 1.2rem; font-family: 'Inter', sans-serif;
    cursor: pointer; font-size: 1rem; transition: all 0.4s;
    width: 100%; margin-top: 1.2rem; font-weight: 500;
    text-transform: uppercase; letter-spacing: .1em;
  }
  .btn-logout:hover { border-color: #EF4444; color: #EF4444; }

  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  @keyframes fadeInRight {
    from { opacity: 0; transform: translateX(40px); }
    to { opacity: 1; transform: translateX(0); }
  }

  /* Alert */
  .status-msg {
    background: rgba(16, 185, 129, 0.1); border-left: 3px solid #10B981;
    border-radius: 4px; padding: 1rem; margin-bottom: 2rem;
    color: #6ee7b7; font-size: .9rem;
  }

  @media (max-width: 1024px) {
    .left-panel { display: none; }
    .right-panel { flex: 1; padding: 1.5rem; background: var(--charcoal); }
    .vignette { display: none; }
  }
</style>
</head>
<body>

<div class="noise"></div>
<div class="vignette"></div>

<!-- LEFT -->
<div class="left-panel">
  <div class="parallax-bg" id="heroBg"></div>
  <div class="left-overlay"></div>
  <div class="left-content">
    <p class="brand-tag">Excellence Awaits</p>
    <h1 class="brand-headline">
      Finalize Your<br>
      <em>Circle</em>
    </h1>
    <p class="brand-desc">
      A formal invitation has been sent to your email. Please verify your address to unlock the full Wismilak experience.
    </p>
  </div>
</div>

<!-- RIGHT -->
<div class="right-panel">
  <div class="form-container">
    <div class="form-header">
      <p class="form-tag">Correspondence</p>
      <h2 class="form-title">Verification</h2>
      <p class="form-subtitle">Thanks for signing up! Before getting started, please confirm your email address via the link we just sent.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
      <div class="status-msg">
        {{ __('A new verification link has been sent to your humidor (email address).') }}
      </div>
    @endif

    <div class="actions">
      <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn-primary">
          {{ __('Resend Verification') }}
        </button>
      </form>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">
          {{ __('Log Out') }}
        </button>
      </form>
    </div>
  </div>
</div>


</body>
</html>


