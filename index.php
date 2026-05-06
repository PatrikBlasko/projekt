<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TaskFlow – Prihlásenie</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg:      #0f1117;
      --bg2:     #181c27;
      --bg3:     #1e2235;
      --border:  #2a2f45;
      --accent:  #5b7fff;
      --accent2: #7c5cfc;
      --green:   #3ecf8e;
      --red:     #f87171;
      --text:    #e2e8f0;
      --muted:   #64748b;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 15px;
    }

    .card {
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 36px 32px;
      width: 100%;
      max-width: 420px;
      animation: fadeUp 0.4s ease both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .auth-logo {
      text-align: center;
      margin-bottom: 28px;
    }
    .auth-logo h2 {
      font-family: 'DM Mono', monospace;
      font-size: 22px;
      color: var(--accent);
      margin-bottom: 6px;
    }
    .auth-logo p { font-size: 14px; color: var(--muted); }

    .form-group { margin-bottom: 16px; }

    label {
      display: block;
      font-size: 13px;
      font-weight: 500;
      color: var(--muted);
      margin-bottom: 6px;
    }

    input {
      width: 100%;
      background: var(--bg);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 11px 14px;
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    input:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(91,127,255,0.15);
    }
    input::placeholder { color: var(--muted); }

    .btn {
      width: 100%;
      padding: 11px;
      border-radius: 10px;
      border: none;
      font-family: 'DM Sans', sans-serif;
      font-size: 15px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.18s;
    }
    .btn-primary { background: var(--accent); color: #fff; }
    .btn-primary:hover { background: #4a6ef0; transform: translateY(-1px); }

    .btn-ghost {
      background: transparent;
      color: var(--muted);
      border: 1px solid var(--border);
      margin-top: 10px;
    }
    .btn-ghost:hover { border-color: var(--accent); color: var(--accent); }

    .divider {
      display: flex;
      align-items: center;
      gap: 12px;
      margin: 20px 0;
      color: var(--muted);
      font-size: 13px;
    }
    .divider::before, .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--border);
    }

    .demo-box {
      background: var(--bg3);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 12px 16px;
      font-family: 'DM Mono', monospace;
      font-size: 13px;
      color: var(--muted);
      margin-top: 20px;
      text-align: center;
    }
    .demo-box span { color: var(--accent); }
  </style>
</head>
<body>

  <div class="card">
    <div class="auth-logo">
      <h2>taskflow</h2>
      <p>Prihláste sa do svojho účtu</p>
    </div>

    <div class="form-group">
      <label>Užívateľské meno</label>
      <input type="text" placeholder="napr. john">
    </div>

    <div class="form-group">
      <label>Heslo</label>
      <input type="password" placeholder="••••••••">
    </div>

    <button class="btn btn-primary">Prihlásiť sa</button>

    <div class="divider">alebo</div>

    <button class="btn btn-ghost">Vytvoriť nový účet</button>

    <div class="demo-box">
      demo: <span>test</span> / <span>password123</span>
    </div>
  </div>

</body>
</html>