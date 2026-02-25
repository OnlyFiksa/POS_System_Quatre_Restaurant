<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?? 'Admin Panel' ?> - POS Restoran</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --sidebar: #111827;
  --sidebar-hover: #1f2937;
  --sidebar-active: #2563eb;
  --bg: #f9fafb;
  --white: #ffffff;
  --primary: #2563eb;
  --primary-light: #eff6ff;
  --text: #111827;
  --muted: #6b7280;
  --border: #e5e7eb;
  --green: #16a34a;
  --red: #dc2626;
  --amber: #d97706;
  --purple: #7c3aed;
  --sidebar-w: 240px;
}

body {
  font-family: 'Plus Jakarta Sans', sans-serif;
  background: var(--bg);
  min-height: 100vh;
  display: flex;
}

/* SIDEBAR */
.sidebar {
  width: var(--sidebar-w);
  background: var(--sidebar);
  min-height: 100vh;
  position: fixed;
  top: 0; left: 0;
  display: flex;
  flex-direction: column;
  z-index: 50;
}

.sidebar-logo {
  padding: 24px 20px;
  border-bottom: 1px solid rgba(255,255,255,0.08);
  display: flex;
  align-items: center;
  gap: 12px;
}
.logo-icon {
  width: 36px; height: 36px;
  background: var(--primary);
  border-radius: 9px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
}
.logo-text {
  font-size: 16px;
  font-weight: 700;
  color: white;
}
.logo-sub { font-size: 11px; color: rgba(255,255,255,0.4); }

.sidebar-nav {
  flex: 1;
  padding: 16px 12px;
}

.nav-section {
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: rgba(255,255,255,0.3);
  padding: 8px 8px 4px;
  margin-top: 8px;
}

.nav-link {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 12px;
  border-radius: 8px;
  text-decoration: none;
  color: rgba(255,255,255,0.65);
  font-size: 14px;
  font-weight: 500;
  transition: all 0.15s;
  margin-bottom: 2px;
}
.nav-link:hover { background: var(--sidebar-hover); color: white; }
.nav-link.active { background: var(--primary); color: white; }
.nav-link .icon { font-size: 18px; width: 22px; text-align: center; }

.sidebar-footer {
  padding: 16px 12px;
  border-top: 1px solid rgba(255,255,255,0.08);
}

.user-card {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 12px;
  background: rgba(255,255,255,0.06);
  border-radius: 10px;
}
.user-avatar {
  width: 34px; height: 34px;
  background: var(--primary);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  color: white;
  font-weight: 700;
}
.user-name { font-size: 13px; font-weight: 600; color: white; }
.user-role { font-size: 11px; color: rgba(255,255,255,0.4); }

.btn-logout-side {
  display: flex;
  align-items: center;
  gap: 8px;
  width: 100%;
  padding: 9px 12px;
  margin-top: 8px;
  background: none;
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 8px;
  color: rgba(255,255,255,0.5);
  font-family: inherit;
  font-size: 13px;
  cursor: pointer;
  transition: all 0.15s;
  text-decoration: none;
}
.btn-logout-side:hover { border-color: var(--red); color: #f87171; }

/* MAIN CONTENT */
.main-content {
  margin-left: var(--sidebar-w);
  flex: 1;
  min-height: 100vh;
}

.topbar {
  background: var(--white);
  border-bottom: 1px solid var(--border);
  padding: 0 28px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: sticky;
  top: 0;
  z-index: 10;
}

.page-title {
  font-size: 17px;
  font-weight: 700;
  color: var(--text);
}

.content {
  padding: 28px;
}

/* Cards */
.card {
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 14px;
  padding: 24px;
}

/* Alert */
.alert {
  padding: 12px 16px;
  border-radius: 10px;
  font-size: 14px;
  margin-bottom: 20px;
}
.alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: var(--green); }
.alert-error { background: #fef2f2; border: 1px solid #fecaca; color: var(--red); }

/* Table */
.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; font-size: 14px; }
th {
  background: var(--bg);
  text-align: left;
  padding: 12px 16px;
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: var(--muted);
  border-bottom: 1px solid var(--border);
}
td { padding: 14px 16px; border-bottom: 1px solid var(--border); color: var(--text); }
tr:last-child td { border-bottom: none; }
tr:hover td { background: #fafafa; }

/* Badges */
.badge {
  display: inline-flex;
  align-items: center;
  padding: 3px 10px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
}
.badge-green { background: #dcfce7; color: var(--green); }
.badge-red { background: #fee2e2; color: var(--red); }
.badge-amber { background: #fef3c7; color: var(--amber); }
.badge-blue { background: #dbeafe; color: var(--primary); }
.badge-gray { background: #f3f4f6; color: var(--muted); }

/* Buttons */
.btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 9px 16px;
  border-radius: 8px;
  font-family: inherit;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.15s;
  text-decoration: none;
  border: none;
}
.btn-primary { background: var(--primary); color: white; }
.btn-primary:hover { background: #1d4ed8; }
.btn-danger { background: var(--red); color: white; }
.btn-danger:hover { background: #b91c1c; }
.btn-ghost { background: none; border: 1px solid var(--border); color: var(--muted); }
.btn-ghost:hover { border-color: var(--primary); color: var(--primary); }
.btn-sm { padding: 6px 12px; font-size: 12px; }

</style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon">🍽️</div>
    <div>
      <div class="logo-text">Quatre Restaurant</div>
      <div class="logo-sub">Admin Panel</div>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section">Overview</div>
    <a href="/admin/dashboard" class="nav-link <?= str_contains(current_url(), '/dashboard') ? 'active' : '' ?>">
      <span class="icon">📊</span> Dashboard
    </a>

    <div class="nav-section">Manajemen</div>
    <a href="/admin/menu" class="nav-link <?= str_contains(current_url(), '/admin/menu') ? 'active' : '' ?>">
      <span class="icon">🍽️</span> Menu
    </a>
    <a href="/admin/transaksi" class="nav-link <?= str_contains(current_url(), '/transaksi') ? 'active' : '' ?>">
      <span class="icon">📋</span> Transaksi
    </a>
    <a href="/admin/promo" class="nav-link <?= str_contains(current_url(), '/promo') ? 'active' : '' ?>">
      <span class="icon">🏷️</span> Promo
    </a>

    <div class="nav-section">Kasir</div>
    <a href="/kasir" class="nav-link">
      <span class="icon">🖥️</span> Buka Kasir
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="user-card">
      <div class="user-avatar"><?= strtoupper(substr(session()->get('nama'), 0, 1)) ?></div>
      <div>
        <div class="user-name"><?= esc(session()->get('nama')) ?></div>
        <div class="user-role"><?= esc(session()->get('role')) ?></div>
      </div>
    </div>
    <a href="/logout" class="btn-logout-side">🚪 Keluar</a>
  </div>
</aside>

<!-- MAIN -->
<div class="main-content">
  <div class="topbar">
    <div class="page-title"><?= $title ?? 'Admin' ?></div>
    <div style="font-size:13px;color:var(--muted)" id="adminTime"></div>
  </div>
  <div class="content">

    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">✅ <?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error">❌ <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
  </div>
</div>

<script>
function updateTime() {
  const el = document.getElementById('adminTime');
  if(el) el.textContent = new Date().toLocaleString('id-ID');
}
setInterval(updateTime, 1000); updateTime();
</script>
</body>
</html>