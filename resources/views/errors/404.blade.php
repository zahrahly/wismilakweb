<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>404 — Page Not Found | Wismilak</title>
<link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,300;0,400;0,600;1,300&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  *{box-sizing:border-box;margin:0;padding:0;}
  body{font-family:'Inter',sans-serif;background:#0D0805;color:#F5EBE0;min-height:100vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:2rem;}
  .code{font-family:'Crimson Pro',serif;font-size:8rem;font-weight:300;color:rgba(212,175,55,.12);line-height:1;margin-bottom:1rem;}
  .title{font-family:'Crimson Pro',serif;font-size:2rem;color:#D4AF37;margin-bottom:.75rem;}
  .desc{color:rgba(245,235,224,.5);font-size:.9rem;margin-bottom:2rem;line-height:1.7;}
  .btn{display:inline-block;background:linear-gradient(135deg,#D4AF37,#B8860B);color:#000;padding:.75rem 2rem;border-radius:50px;text-decoration:none;font-weight:700;font-size:.85rem;transition:all .3s;}
  .btn:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(212,175,55,.3);}
</style>
</head>
<body>
  <div>
    <div class="code">404</div>
    <h1 class="title">Page Not Found</h1>
    <p class="desc">The page you are looking for does not exist<br>or has been moved.</p>
    <a href="{{ url('/') }}" class="btn">← Back to Home</a>
  </div>
</body>
</html>

