<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account — Wismilak Premium Cigars</title>
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
      --glass: rgba(13, 8, 5, 0.85);
      --glass-border: rgba(212, 175, 55, 0.2);
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--charcoal);
      color: var(--cream);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      position: relative;
      overflow-x: hidden;
    }

    /* Background */
    .page-bg {
      position: fixed;
      inset: 0;
      background: url('/images/register-bg.png') center/cover no-repeat;
      z-index: 0;
      filter: brightness(0.7);
      transition: transform 10s ease-out;
    }

    body:hover .page-bg {
      transform: scale(1.05);
    }

    .page-overlay {
      position: fixed;
      inset: 0;
      background: radial-gradient(circle at center, rgba(13, 8, 5, 0.4) 0%, rgba(13, 8, 5, 0.9) 100%);
      z-index: -1;
    }

    /* Progress indicator */
    .progress-bar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: rgba(255, 255, 255, .05);
      z-index: 100;
    }

    .progress-fill {
      height: 100%;
      background: linear-gradient(90deg, var(--gold), var(--gold-light));
      box-shadow: 0 0 15px var(--gold);
      transition: width .6s cubic-bezier(0.65, 0, 0.35, 1);
    }

    /* Layout */
    .register-container {
      max-width: 600px;
      margin: auto;
      width: 100%;
      padding: 4rem 2rem;
      animation: fadeInUp 0.8s ease-out;
    }

    .form-glass {
      background: var(--glass);
      backdrop-filter: blur(25px);
      -webkit-backdrop-filter: blur(25px);
      border: 1px solid var(--glass-border);
      border-radius: 40px;
      padding: 4.5rem;
      box-shadow: 0 50px 120px -30px rgba(0, 0, 0, 0.9);
      animation: fadeInUp 1s ease-out forwards;
    }

    /* Header */
    .reg-header {
      text-align: center;
      margin-bottom: 3rem;
    }

    .reg-logo {
      font-size: .7rem;
      letter-spacing: .5em;
      color: var(--gold);
      text-transform: uppercase;
      margin-bottom: 1rem;
      opacity: 0.8;
    }

    .reg-title {
      font-family: 'Crimson Pro', serif;
      font-size: 2.5rem;
      font-weight: 400;
      margin-bottom: .5rem;
      letter-spacing: -0.01em;
    }

    .reg-sub {
      font-size: .9rem;
      color: rgba(245, 235, 224, .5);
    }

    .reg-sub a {
      color: var(--gold);
      text-decoration: none;
      font-weight: 600;
    }

    /* Step indicator */
    .steps {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0;
      margin-bottom: 3rem;
    }

    .step-item {
      display: flex;
      align-items: center;
    }

    .step-dot {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .8rem;
      font-weight: 700;
      border: 2px solid rgba(255, 255, 255, .1);
      color: rgba(245, 235, 224, .3);
      background: rgba(255, 255, 255, .03);
      transition: all .4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .step-dot.active {
      border-color: var(--gold);
      color: var(--gold);
      background: rgba(212, 175, 55, .1);
      box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
    }

    .step-dot.done {
      border-color: var(--gold);
      background: var(--gold);
      color: #000;
    }

    .step-line {
      width: 60px;
      height: 1px;
      background: rgba(255, 255, 255, .1);
      transition: all .4s;
    }

    .step-line.done {
      background: var(--gold);
    }

    /* Form panels */
    .step-panel {
      display: none;
    }

    .step-panel.active {
      display: block;
      animation: fadeIn 0.5s ease-out;
    }

    /* Inputs */
    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-label {
      display: block;
      font-size: .75rem;
      letter-spacing: .1em;
      color: rgba(245, 235, 224, .5);
      text-transform: uppercase;
      margin-bottom: .6rem;
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
      outline: none;
      transition: all 0.3s;
    }

    .form-input:focus {
      border-color: var(--gold);
      background: rgba(212, 175, 55, .05);
      box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
    }

    .form-input option {
      background: #1C0F06;
      color: var(--cream);
    }

    .form-input.is-error {
      border-color: #EF4444;
    }

    .error-msg {
      color: #EF4444;
      font-size: .75rem;
      margin-top: .4rem;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
    }

    /* Age notice */
    .age-notice {
      background: rgba(212, 175, 55, .08);
      border: 1px solid rgba(212, 175, 55, 0.2);
      border-radius: 16px;
      padding: 1.2rem;
      margin-bottom: 2rem;
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .age-icon {
      font-size: 1.5rem;
    }

    .age-text {
      font-size: .85rem;
      color: rgba(245, 235, 224, .7);
      line-height: 1.6;
    }

    .age-text strong {
      color: var(--gold);
      display: block;
      font-size: .95rem;
      margin-bottom: 2px;
    }

    /* Buttons */
    .btn-next {
      width: 100%;
      padding: 1.1rem;
      background: linear-gradient(135deg, var(--gold), var(--gold-light));
      color: #000;
      border: none;
      border-radius: 12px;
      font-size: 1rem;
      font-weight: 700;
      font-family: 'Inter', sans-serif;
      cursor: pointer;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      text-transform: uppercase;
      letter-spacing: .1em;
    }

    .btn-next:hover {
      transform: translateY(-4px);
      box-shadow: 0 15px 30px rgba(212, 175, 55, 0.4);
    }

    .btn-back {
      background: none;
      border: 1px solid rgba(255, 255, 255, .1);
      color: rgba(245, 235, 224, .5);
      border-radius: 12px;
      padding: 1.1rem;
      font-family: 'Inter', sans-serif;
      cursor: pointer;
      font-size: 1rem;
      transition: all 0.3s;
      width: 100%;
      margin-bottom: 1rem;
      font-weight: 500;
    }

    .btn-back:hover {
      border-color: var(--gold);
      color: var(--gold);
    }

    .alert-error {
      background: rgba(239, 68, 68, .1);
      border: 1px solid rgba(239, 68, 68, .2);
      border-radius: 12px;
      padding: 1rem;
      margin-bottom: 1.5rem;
      color: #fca5a5;
      font-size: .85rem;
    }

    /* Review Step */
    .review-card {
      background: rgba(212, 175, 55, .03);
      border: 1px solid rgba(212, 175, 55, .1);
      border-radius: 20px;
      padding: 2rem;
      margin-bottom: 2rem;
    }

    .review-item {
      display: flex;
      justify-content: space-between;
      padding: 0.75rem 0;
      border-bottom: 1px solid rgba(255, 255, 255, .05);
    }

    .review-item:last-child {
      border: none;
    }

    .review-label {
      font-size: .8rem;
      color: rgba(245, 235, 224, .4);
      text-transform: uppercase;
      letter-spacing: .1em;
    }

    .review-value {
      font-size: .95rem;
      color: var(--cream);
      font-weight: 500;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(40px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    @media (max-width: 640px) {
      .form-row {
        grid-template-columns: 1fr;
        gap: 0;
      }

      .form-glass {
        padding: 2rem;
      }

      .register-container {
        padding: 2rem 1rem;
      }
    }
  </style>
</head>

<body>

  <div class="page-bg"></div>
  <div class="page-overlay"></div>

  <div class="progress-bar">
    <div class="progress-fill" id="progress" style="width:33%"></div>
  </div>

  <div class="register-container">
    <div class="form-glass">
      <div class="reg-header">
        <p class="reg-logo">Wismilak Premium Cigars</p>
        <h1 class="reg-title">Create Account</h1>
        <p class="reg-sub">Already a member? <a href="{{ route('login') }}">Sign in →</a></p>
      </div>

      <!-- Step Indicators -->
      <div class="steps">
        <div class="step-item">
          <div class="step-dot active" id="dot-1">1</div>
        </div>
        <div class="step-line" id="line-1"></div>
        <div class="step-item">
          <div class="step-dot" id="dot-2">2</div>
        </div>
        <div class="step-line" id="line-2"></div>
        <div class="step-item">
          <div class="step-dot" id="dot-3">3</div>
        </div>
      </div>

      @if($errors->any())
        <div class="alert-error">
          @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}" id="reg-form">
        @csrf

        <!-- STEP 1: Account -->
        <div class="step-panel active" id="step-1">
          <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe"
              class="form-input {{ $errors->has('name') ? 'is-error' : '' }}" required>
            @error('name')<p class="error-msg">{{ $message }}</p>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="john@example.com"
              class="form-input {{ $errors->has('email') ? 'is-error' : '' }}" required>
            @error('email')<p class="error-msg">{{ $message }}</p>@enderror
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Password</label>
              <input type="password" name="password" placeholder="••••••••"
                class="form-input {{ $errors->has('password') ? 'is-error' : '' }}" required>
            </div>
            <div class="form-group">
              <label class="form-label">Confirm Password</label>
              <input type="password" name="password_confirmation" placeholder="••••••••" class="form-input" required>
            </div>
          </div>
          <button type="button" class="btn-next" onclick="goStep(2)">Continue to Details</button>
        </div>

        <!-- STEP 2: Personal Info -->
        <div class="step-panel" id="step-2">
          <div class="age-notice">
            <div class="age-icon">🔞</div>
            <div class="age-text">
              <strong>Age Requirement</strong>
              Our products and services are exclusively for individuals aged 21 and above.
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Phone Number</label>
              <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxx"
                class="form-input {{ $errors->has('phone') ? 'is-error' : '' }}">
            </div>
            <div class="form-group">
              <label class="form-label">Gender</label>
              <select name="gender" class="form-input">
                <option value="">Select Gender</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Date of Birth</label>
              <input type="date" name="date_of_birth" id="dob-input" value="{{ old('date_of_birth') }}"
                class="form-input {{ $errors->has('date_of_birth') ? 'is-error' : '' }}"
                max="{{ now()->subYears(21)->format('Y-m-d') }}">
              <div id="age-error" style="display:none; color:#EF4444; font-size:0.75rem; margin-top:0.4rem; display:flex; align-items:center; gap:0.25rem;">
                 <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                 <span id="age-error-text">Anda harus berusia minimal 21 tahun.</span>
              </div>
              @error('date_of_birth')<p class="error-msg">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
              <label class="form-label">City</label>
              <input type="text" name="city" value="{{ old('city') }}" placeholder="Your City" class="form-input">
            </div>
          </div>
          <button type="button" class="btn-back" onclick="goStep(1)">Back</button>
          <button type="button" class="btn-next" onclick="goStep(3)">Review Application</button>
        </div>

        <!-- STEP 3: Review & Submit -->
        <div class="step-panel" id="step-3">
          <div class="review-card">
            <div class="review-item"><span class="review-label">Name</span><span class="review-value"
                id="review-name"></span></div>
            <div class="review-item"><span class="review-label">Email</span><span class="review-value"
                id="review-email"></span></div>
            <div class="review-item"><span class="review-label">Phone</span><span class="review-value"
                id="review-phone"></span></div>
            <div class="review-item"><span class="review-label">Location</span><span class="review-value"
                id="review-city"></span></div>
          </div>

          <div style="margin-bottom:2.5rem;">
            <label style="display:flex;align-items:flex-start;gap:1rem;cursor:pointer;">
              <input type="checkbox" name="terms" required
                style="margin-top:4px;width:18px;height:18px;accent-color:var(--gold);">
              <span style="font-size:.85rem;color:rgba(245,235,224,.6);line-height:1.6;">
                I certify that I am at least 21 years of age and I agree to the <a href="#"
                  style="color:var(--gold);">Terms of Service</a> and <a href="#" style="color:var(--gold);">Privacy Policy</a>.
              </span>
            </label>
          </div>

          <button type="button" class="btn-back" onclick="goStep(2)">Back</button>
          <button type="submit" class="btn-next">Complete Registration</button>
        </div>

      </form>
    </div>
  </div>

  <script>
    const steps = [null, 'step-1', 'step-2', 'step-3'];
    const dots = [null, 'dot-1', 'dot-2', 'dot-3'];
    const lines = [null, 'line-1', 'line-2'];
    const progs = { 1: '33%', 2: '66%', 3: '100%' };
    let current = 1;

    @if($errors->has('name') || $errors->has('email') || $errors->has('password'))
      current = 1;
    @elseif($errors->has('phone') || $errors->has('date_of_birth'))
      current = 2;
    @endif

      function goStep(n) {
        if (current === 2 && n === 3) {
            const dob = document.getElementById('dob-input').value;
            const errorEl = document.getElementById('age-error');
            const inputEl = document.getElementById('dob-input');
            if (!dob) {
                errorEl.style.display = 'flex';
                document.getElementById('age-error-text').textContent = 'Tanggal lahir harus diisi.';
                inputEl.classList.add('is-error');
                return;
            }
            
            const birthDate = new Date(dob);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            if (age < 21) {
                errorEl.style.display = 'flex';
                document.getElementById('age-error-text').textContent = 'Anda harus berusia minimal 21 tahun.';
                inputEl.classList.add('is-error');
                return;
            }
            
            errorEl.style.display = 'none';
            inputEl.classList.remove('is-error');
        }

        // Hide current
        document.getElementById(steps[current]).classList.remove('active');
        document.getElementById(dots[current]).classList.remove('active');

        if (current < n) {
          document.getElementById(dots[current]).classList.add('done');
          document.getElementById(dots[current]).innerHTML = '✓';
          if (lines[current]) document.getElementById(lines[current]).classList.add('done');
        } else {
          document.getElementById(dots[current]).classList.remove('done');
          document.getElementById(dots[current]).innerHTML = current;
          if (lines[current - 1]) document.getElementById(lines[current - 1]).classList.remove('done');
        }

        current = n;
        document.getElementById(steps[current]).classList.add('active');
        document.getElementById(dots[current]).classList.add('active');
        document.getElementById('progress').style.width = progs[n];

        if (n === 3) updateReview();
      }

    function updateReview() {
      const f = document.getElementById('reg-form');
      document.getElementById('review-name').textContent = f.name.value;
      document.getElementById('review-email').textContent = f.email.value;
      document.getElementById('review-phone').textContent = f.phone.value || '—';
      document.getElementById('review-city').textContent = f.city.value || '—';
    }

    if (current > 1) goStep(current);
  </script>

</body>

</html>