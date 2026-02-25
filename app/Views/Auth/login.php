<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - POS Restoran</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap');
  
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  
  :root {
    --bg: #0f0e0d;
    --card: #1a1917;
    --gold: #c9a96e;
    --gold2: #e8c98a;
    --text: #f0ebe3;
    --muted: #7a7368;
    --border: #2e2b26;
    --red: #e05252;
  }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
  }

  body::before {
    content: '';
    position: absolute;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(201,169,110,0.08) 0%, transparent 70%);
    top: -200px; right: -200px;
    border-radius: 50%;
  }

  body::after {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(201,169,110,0.05) 0%, transparent 70%);
    bottom: -100px; left: -100px;
    border-radius: 50%;
  }

  .card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 48px 44px;
    width: 420px;
    position: relative;
    z-index: 1;
    box-shadow: 0 24px 80px rgba(0,0,0,0.6);
  }

  .logo {
    text-align: center;
    margin-bottom: 36px;
  }

  .logo-icon {
    width: 60px; height: 60px;
    background: linear-gradient(135deg, var(--gold), var(--gold2));
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin-bottom: 16px;
  }

  .logo h1 {
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    color: var(--text);
    letter-spacing: -0.3px;
  }

  .logo p {
    color: var(--muted);
    font-size: 13px;
    margin-top: 4px;
  }

  .alert {
    background: rgba(224,82,82,0.12);
    border: 1px solid rgba(224,82,82,0.3);
    color: #f87878;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 13px;
    margin-bottom: 24px;
  }

  label {
    display: block;
    color: var(--muted);
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 8px;
  }

  .form-group { margin-bottom: 20px; }

  input {
    width: 100%;
    background: var(--bg);
    border: 1px solid var(--border);
    color: var(--text);
    padding: 12px 16px;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s;
  }

  input:focus {
    border-color: var(--gold);
  }

  input::placeholder { color: var(--muted); }

  button[type="submit"] {
    width: 100%;
    background: linear-gradient(135deg, var(--gold), var(--gold2));
    color: #1a1510;
    border: none;
    padding: 14px;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: opacity 0.2s, transform 0.1s;
    margin-top: 8px;
  }

  button[type="submit"]:hover { opacity: 0.9; }
  button[type="submit"]:active { transform: scale(0.99); }

  .hint {
    text-align: center;
    color: var(--muted);
    font-size: 12px;
    margin-top: 24px;
  }
  .hint span { color: var(--gold); }
</style>
</head>
<body>
<div class="card">
  <div class="logo">
    <div class="logo-icon">🍽️</div>
    <h1>Quatre Restaurant</h1>
    <p>Point of Sale System</p>
  </div>

  <?php if (session()->getFlashdata('error')): ?>
  <div class="alert"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <form method="POST" action="/login">
    <?= csrf_field() ?>
    <div class="form-group">
      <label>Username</label>
      <input type="text" name="username" placeholder="Masukkan username" required autocomplete="off">
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" placeholder="••••••••" required>
    </div>
    <button type="submit">Masuk →</button>
  </form>

  <p class="hint">Login sebagai <span>admin</span> atau <span>kasir</span> · password: <span>password</span></p>
</div>
</body>
</html>