<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirm Password — Wismilak Premium Cigars</title>
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
    background: url('/images/forgot-bg.png') center/cover no-repeat;
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
    max-width: 460px;
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
  .form-subtitle { font-size: 1rem; color: rgba(245,235,224,.4); font-weight: 300; }

  /* Premium Inputs */
  .input-wrapper { position: relative; margin-bottom: 2.5rem; }
  .form-input {
    width: 100%; padding: 1.2rem 1.4rem;
    background: rgba(255,255,255,.02);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 16px; color: var(--cream);
    font-size: 1.1rem; font-family: 'Inter', sans-serif;
    transition: all 0.4s; outline: none;
  }
  .form-input:focus {
    border-color: var(--gold);
    background: rgba(212,175,55,.04);
    box-shadow: 0 0 0 1px var(--gold);
  }
  .input-label {
    position: absolute; left: 1.4rem; top: 50%;
    transform: translateY(-50%);
    color: rgba(245,235,224,.4);
    font-size: 1rem; pointer-events: none;
    transition: all 0.3s ease;
    text-transform: uppercase; letter-spacing: .1em;
  }
  .form-input:focus ~ .input-label,
  .form-input:not(:placeholder-shown) ~ .input-label {
    top: -10px; left: 1rem; font-size: .65rem; color: var(--gold);
    background: var(--charcoal); padding: 0 0.5rem;
  }

  .btn-submit {
    width: 100%; padding: 1.2rem;
    background: linear-gradient(135deg, #B8860B 0%, var(--gold) 50%, var(--gold-light) 100%);
    color: #000; border: none; border-radius: 16px;
    font-size: 1.1rem; font-weight: 800; letter-spacing: .15em;
    font-family: 'Inter', sans-serif; cursor: pointer;
    transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
    text-transform: uppercase;
    position: relative; overflow: hidden;
  }
  .btn-submit:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(212,175,55,0.4); }

  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  @keyframes fadeInRight {
    from { opacity: 0; transform: translateX(40px); }
    to { opacity: 1; transform: translateX(0); }
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
    <p class="brand-tag">Security Area</p>
    <h1 class="brand-headline">
      Confirm Your<br>
      <em>Identity</em>
    </h1>
    <p class="brand-desc">
      For your security, please verify your credentials before accessing this exclusive section.
    </p>
  </div>
</div>

<!-- RIGHT -->
<div class="right-panel">
  <div class="form-container">
    <div class="form-header">
      <p class="form-tag">Verification</p>
      <h2 class="form-title">Security</h2>
      <p class="form-subtitle">Please confirm your password to continue</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
      @csrf

      <div class="input-wrapper">
        <input id="password" name="password" type="password" required autocomplete="current-password"
               class="form-input {{ $errors->has('password') ? 'is-error' : '' }}" placeholder=" ">
        <label class="input-label" for="password">Password</label>
        @error('password')<p style="color:#EF4444;font-size:.75rem;margin-top:.5rem;">{{ $message }}</p>@enderror
      </div>

      <button type="submit" class="btn-submit">Confirm Password</button>
    </form>
  </div>
</div>


</body>
</html>


