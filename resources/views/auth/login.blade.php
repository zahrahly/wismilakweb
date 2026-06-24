<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In — Wismilak Premium Cigars</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Inter:wght@300;400;500;600&display=swap"
    rel="stylesheet">
  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    :root {
      --gold: #D4AF37;
      --gold-light: #F4D03F;
      --charcoal: #0D0805;
      --tobacco: #1C0F06;
      --cream: #F5EBE0;
      --glass: rgba(13, 8, 5, 0.7);
      --glass-border: rgba(212, 175, 55, 0.2);
    }

    html,
    body {
      height: 100%;
      overflow-x: hidden;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--charcoal);
      color: var(--cream);
      display: flex;
      min-height: 100vh;
    }

    /* ── LEFT PANEL (Visual) ── */
    .left-panel {
      flex: 1.2;
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 4rem;
    }

    .parallax-bg {
      position: absolute;
      inset: 0;
      background: url('/images/login-bg.png') center/cover no-repeat;
      z-index: 0;
      filter: brightness(0.8) contrast(1.1);
      transition: transform 10s ease-out;
    }

    .left-panel:hover .parallax-bg {
      transform: scale(1.05);
    }

    .left-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to bottom, rgba(13, 8, 5, 0.2) 0%, rgba(13, 8, 5, 0.8) 100%);
      z-index: 1;
    }

    .left-content {
      position: relative;
      z-index: 2;
    }

    .brand-tag {
      font-size: .8rem;
      letter-spacing: .5em;
      color: var(--gold);
      text-transform: uppercase;
      margin-bottom: 2rem;
      animation: fadeInUp 0.8s ease-out forwards;
    }

    .brand-headline {
      font-family: 'Crimson Pro', serif;
      font-size: clamp(3.5rem, 6vw, 5.5rem);
      font-weight: 300;
      line-height: 1;
      color: var(--cream);
      margin-bottom: 2rem;
      letter-spacing: -0.02em;
      animation: fadeInUp 0.8s ease-out 0.2s forwards;
      opacity: 0;
    }

    .brand-headline em {
      font-style: italic;
      color: var(--gold);
      font-weight: 400;
    }

    .brand-desc {
      font-size: 1.1rem;
      color: rgba(245, 235, 224, 0.6);
      line-height: 1.8;
      max-width: 550px;
      font-weight: 300;
      animation: fadeInUp 0.8s ease-out 0.4s forwards;
      opacity: 0;
    }

    /* ── RIGHT PANEL (Form) ── */
    .right-panel {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 3rem;
      background: radial-gradient(circle at center, #1a100a 0%, #0d0805 100%);
      position: relative;
    }

    .form-container {
      width: 100%;
      max-width: 440px;
      background: var(--glass);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--glass-border);
      padding: 3rem;
      border-radius: 24px;
      box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.8);
      animation: fadeInRight 1s ease-out 0.3s forwards;
      opacity: 0;
    }

    .form-tag {
      font-size: .65rem;
      letter-spacing: .3em;
      color: var(--gold);
      text-transform: uppercase;
      margin-bottom: 1rem;
      text-align: center;
    }

    .form-title {
      font-family: 'Crimson Pro', serif;
      font-size: 2.5rem;
      font-weight: 400;
      margin-bottom: .75rem;
      text-align: center;
      letter-spacing: -0.02em;
    }

    .form-subtitle {
      font-size: .9rem;
      color: rgba(245, 235, 224, .5);
      margin-bottom: 2.5rem;
      text-align: center;
    }

    .form-subtitle a {
      color: var(--gold);
      text-decoration: none;
      font-weight: 600;
    }

    .form-group {
      margin-bottom: 1.5rem;
      position: relative;
    }

    .form-label {
      display: block;
      font-size: .7rem;
      letter-spacing: .12em;
      color: rgba(245, 235, 224, .5);
      text-transform: uppercase;
      margin-bottom: .5rem;
      transition: all 0.3s;
    }

    .form-input {
      width: 100%;
      padding: 1rem 1.2rem;
      background: rgba(255, 255, 255, .03);
      border: 1px solid rgba(255, 255, 255, .1);
      border-radius: 12px;
      color: var(--cream);
      font-size: 1rem;
      font-family: 'Inter', sans-serif;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      outline: none;
    }

    .form-input:focus {
      border-color: var(--gold);
      background: rgba(212, 175, 55, .05);
      box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
    }

    .form-input.is-error {
      border-color: #EF4444;
    }

    .error-msg {
      color: #EF4444;
      font-size: .75rem;
      margin-top: .5rem;
    }

    .remember-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 2rem;
    }

    .remember-label {
      display: flex;
      align-items: center;
      gap: .6rem;
      font-size: .85rem;
      color: rgba(245, 235, 224, .6);
      cursor: pointer;
    }

    .remember-label input[type=checkbox] {
      width: 18px;
      height: 18px;
      accent-color: var(--gold);
      cursor: pointer;
    }

    .forgot-link {
      font-size: .85rem;
      color: var(--gold);
      text-decoration: none;
      font-weight: 500;
    }

    .forgot-link:hover {
      text-decoration: underline;
    }

    .btn-login {
      width: 100%;
      padding: 1.1rem;
      background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
      color: #000;
      border: none;
      border-radius: 12px;
      font-size: 1rem;
      font-weight: 700;
      letter-spacing: .1em;
      font-family: 'Inter', sans-serif;
      cursor: pointer;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      text-transform: uppercase;
    }

    .btn-login:hover {
      transform: translateY(-4px);
      box-shadow: 0 15px 30px rgba(212, 175, 55, 0.4);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .divider {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin: 2rem 0;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: rgba(255, 255, 255, .1);
    }

    .divider span {
      font-size: .75rem;
      color: rgba(245, 235, 224, .3);
      text-transform: uppercase;
      letter-spacing: .2em;
    }

    /* Alert */
    .status-msg {
      background: rgba(16, 185, 129, 0.1);
      border-left: 3px solid #10B981;
      border-radius: 4px;
      padding: 1rem;
      margin-bottom: 2rem;
      color: #6ee7b7;
      font-size: .9rem;
    }

    .alert-error {
      background: rgba(239, 68, 68, .1);
      border: 1px solid rgba(239, 68, 68, .2);
      border-radius: 12px;
      padding: 1rem;
      margin-bottom: 1.5rem;
      color: #fca5a5;
      font-size: .85rem;
      line-height: 1.5;
    }

    /* Animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInRight {
      from {
        opacity: 0;
        transform: translateX(40px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @media (max-width: 1024px) {
      .left-panel {
        display: none;
      }

      .right-panel {
        flex: 1;
        padding: 1.5rem;
      }
    }

    .back-to-website-btn {
      position: absolute;
      top: 4rem;
      left: 4rem;
      z-index: 99;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      color: rgba(245, 235, 224, 0.45);
      text-decoration: none;
      font-size: 0.72rem;
      font-weight: 500;
      letter-spacing: 0.25em;
      text-transform: uppercase;
      transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .back-to-website-btn:hover {
      color: var(--gold);
      transform: translateX(-3px);
    }

    .back-to-website-btn svg {
      transition: transform 0.4s ease;
    }

    .back-to-website-btn:hover svg {
      transform: rotate(180deg) translateX(2px) !important;
    }

    .mobile-back-btn {
      display: none;
    }

    @media (max-width: 1024px) {
      .mobile-back-btn {
        display: inline-flex;
        position: relative;
        top: 0;
        left: 0;
        margin-bottom: 2rem;
        align-self: flex-start;
      }
      .right-panel {
        flex-direction: column !important;
        justify-content: center !important;
        align-items: center !important;
      }
    }
  </style>
</head>

<body>

  <!-- LEFT -->
  <div class="left-panel">
    <!-- Back button for desktop (floats top-left in left panel image side) -->
    <a href="{{ route('home') }}" class="back-to-website-btn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="transform: rotate(180deg);">
            <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
        Back to Website
    </a>
    <div class="parallax-bg"></div>
    <div class="left-overlay"></div>
    <div class="left-content">
      <p class="brand-tag">Excellence Since 1962</p>
      <h1 class="brand-headline">
        The Art of<br>
        <em>Timeless</em> Luxury
      </h1>
      <p class="brand-desc">
        Join our exclusive circle of connoisseurs and experience the heritage of Wismilak Premium Cigars.
      </p>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="right-panel">
    
    <!-- Back button for mobile/tablets only (stacked above card when left panel is hidden) -->
    <a href="{{ route('home') }}" class="back-to-website-btn mobile-back-btn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="transform: rotate(180deg);">
            <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
        Back to Website
    </a>

    <div class="form-container">
      <p class="form-tag">Member Authentication</p>
      <h2 class="form-title">Welcome</h2>
      <p class="form-subtitle">Enter your credentials to continue</p>

      @if($errors->any() || session('status'))
        <div class="alert-error">
          @if(session('status')) {{ session('status') }} @endif
          @foreach($errors->getMessages() as $msgs)
            @foreach($msgs as $msg)<div>{{ $msg }}</div>@endforeach
          @endforeach
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
          <label class="form-label" for="email">Email Address</label>
          <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"
            class="form-input {{ $errors->has('email') ? 'is-error' : '' }}" placeholder="name@domain.com">
          @error('email')<p class="error-msg">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <input id="password" name="password" type="password" required autocomplete="current-password"
            class="form-input {{ $errors->has('password') ? 'is-error' : '' }}" placeholder="••••••••">
          @error('password')<p class="error-msg">{{ $message }}</p>@enderror
        </div>

        <div class="remember-row">
          <label class="remember-label">
            <input type="checkbox" name="remember"> Remember me
          </label>
          @if(Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-link">Forgot?</a>
          @endif
        </div>

        <button type="submit" class="btn-login">Sign In</button>

        <div class="divider"><span>OR</span></div>

        <p style="text-align:center;font-size:.9rem;color:rgba(245,235,224,.5);">
          New to Wismilak? <a href="{{ route('register') }}"
            style="color:var(--gold);text-decoration:none;font-weight:600;">Create Account</a>
        </p>
      </form>
    </div>
  </div>

</body>

</html>