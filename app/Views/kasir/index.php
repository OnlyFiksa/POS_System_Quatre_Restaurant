<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kasir - POS Restoran</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --bg: #f5f4f2;
  --white: #ffffff;
  --primary: #2563eb;
  --primary-light: #eff6ff;
  --text: #1e1b18;
  --muted: #6b7280;
  --border: #e5e3df;
  --green: #16a34a;
  --red: #dc2626;
  --amber: #d97706;
  --sidebar-w: 320px;
}

body {
  font-family: 'Plus Jakarta Sans', sans-serif;
  background: var(--bg);
  height: 100vh;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

/* TOPBAR */
.topbar {
  background: var(--white);
  border-bottom: 1px solid var(--border);
  padding: 0 24px;
  height: 58px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-shrink: 0;
  z-index: 10;
}

.topbar-left { display: flex; align-items: center; gap: 16px; }
.brand { font-size: 17px; font-weight: 700; color: var(--text); }
.brand span { color: var(--primary); }
.date-time { font-size: 13px; color: var(--muted); }

.topbar-right { display: flex; align-items: center; gap: 12px; }
.kasir-badge {
  background: var(--primary-light);
  color: var(--primary);
  padding: 6px 12px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 600;
}
.btn-logout {
  background: none;
  border: 1px solid var(--border);
  color: var(--muted);
  padding: 6px 14px;
  border-radius: 8px;
  font-size: 13px;
  cursor: pointer;
  font-family: inherit;
  transition: all 0.15s;
}
.btn-logout:hover { border-color: var(--red); color: var(--red); }

/* MAIN LAYOUT */
.main-wrap {
  display: flex;
  flex: 1;
  overflow: hidden;
}

/* MENU AREA */
.menu-area {
  flex: 1;
  overflow-y: auto;
  padding: 20px;
}

/* KATEGORI TABS */
.kategori-tabs {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  margin-bottom: 20px;
}

.tab-btn {
  background: var(--white);
  border: 1px solid var(--border);
  color: var(--muted);
  padding: 7px 16px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  font-family: inherit;
  transition: all 0.15s;
}
.tab-btn:hover, .tab-btn.active {
  background: var(--primary);
  border-color: var(--primary);
  color: white;
}

/* SEARCH */
.search-wrap {
  position: relative;
  margin-bottom: 20px;
}
.search-wrap input {
  width: 100%;
  background: var(--white);
  border: 1px solid var(--border);
  padding: 10px 16px 10px 38px;
  border-radius: 10px;
  font-family: inherit;
  font-size: 14px;
  outline: none;
  transition: border-color 0.15s;
}
.search-wrap input:focus { border-color: var(--primary); }
.search-icon {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--muted);
  font-size: 16px;
}

/* MENU GRID */
.menu-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(145px, 1fr));
  gap: 12px;
}

.menu-card {
  background: var(--white);
  border: 2px solid transparent;
  border-radius: 14px;
  padding: 14px 12px;
  cursor: pointer;
  transition: all 0.15s;
  text-align: center;
  position: relative;
}

.menu-card:hover {
  border-color: var(--primary);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(37,99,235,0.12);
}

.menu-card.tidak-tersedia {
  opacity: 0.4;
  cursor: not-allowed;
}

.menu-img {
  width: 70px; height: 70px;
  border-radius: 50%;
  object-fit: cover;
  margin: 0 auto 10px;
  display: block;
  background: var(--bg);
}

.menu-emoji {
  width: 70px; height: 70px;
  border-radius: 50%;
  background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  margin: 0 auto 10px;
}

.menu-nama {
  font-size: 13px;
  font-weight: 600;
  color: var(--text);
  margin-bottom: 4px;
  line-height: 1.3;
}

.menu-harga {
  font-size: 12px;
  color: var(--primary);
  font-weight: 700;
}

.menu-stok {
  font-size: 11px;
  color: var(--muted);
  margin-top: 2px;
}

.badge-qty {
  position: absolute;
  top: -8px; right: -8px;
  background: var(--primary);
  color: white;
  width: 22px; height: 22px;
  border-radius: 50%;
  font-size: 11px;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  display: none;
}
.menu-card.in-cart .badge-qty { display: flex; }

/* SIDEBAR */
.sidebar {
  width: var(--sidebar-w);
  background: var(--white);
  border-left: 1px solid var(--border);
  display: flex;
  flex-direction: column;
  flex-shrink: 0;
}

.sidebar-header {
  padding: 18px 20px 14px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.sidebar-title {
  font-size: 15px;
  font-weight: 700;
  color: var(--text);
}

.cart-count {
  background: var(--primary);
  color: white;
  border-radius: 20px;
  padding: 2px 10px;
  font-size: 12px;
  font-weight: 600;
}

.cart-items {
  flex: 1;
  overflow-y: auto;
  padding: 12px;
}

.cart-empty {
  text-align: center;
  color: var(--muted);
  padding: 40px 20px;
  font-size: 13px;
}
.cart-empty .icon { font-size: 40px; margin-bottom: 8px; }

.cart-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px;
  border-radius: 10px;
  margin-bottom: 6px;
  transition: background 0.1s;
}
.cart-item:hover { background: var(--bg); }

.cart-item-name {
  flex: 1;
  font-size: 13px;
  font-weight: 600;
  color: var(--text);
}
.cart-item-price {
  font-size: 12px;
  color: var(--muted);
}

.qty-control {
  display: flex;
  align-items: center;
  gap: 8px;
}
.qty-btn {
  width: 26px; height: 26px;
  border: 1px solid var(--border);
  background: var(--white);
  border-radius: 6px;
  cursor: pointer;
  font-size: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.1s;
  font-family: inherit;
}
.qty-btn:hover { background: var(--primary); border-color: var(--primary); color: white; }
.qty-num {
  font-size: 14px;
  font-weight: 700;
  color: var(--text);
  min-width: 20px;
  text-align: center;
}

.cart-item-total {
  font-size: 13px;
  font-weight: 700;
  color: var(--primary);
  min-width: 70px;
  text-align: right;
}

/* SIDEBAR FOOTER */
.sidebar-footer {
  padding: 16px 20px;
  border-top: 1px solid var(--border);
}

.summary-row {
  display: flex;
  justify-content: space-between;
  font-size: 13px;
  color: var(--muted);
  margin-bottom: 6px;
}

.total-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 10px;
  border-top: 1px solid var(--border);
  margin-top: 6px;
}
.total-label {
  font-size: 15px;
  font-weight: 700;
  color: var(--text);
}
.total-val {
  font-size: 18px;
  font-weight: 800;
  color: var(--text);
}

.btn-checkout {
  width: 100%;
  background: var(--primary);
  color: white;
  border: none;
  padding: 14px;
  border-radius: 12px;
  font-family: inherit;
  font-size: 15px;
  font-weight: 700;
  cursor: pointer;
  margin-top: 14px;
  transition: all 0.15s;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}
.btn-checkout:hover { background: #1d4ed8; }
.btn-checkout:disabled { opacity: 0.5; cursor: not-allowed; }

.btn-clear {
  width: 100%;
  background: none;
  border: 1px solid var(--border);
  color: var(--muted);
  padding: 9px;
  border-radius: 10px;
  font-family: inherit;
  font-size: 13px;
  cursor: pointer;
  margin-top: 8px;
  transition: all 0.15s;
}
.btn-clear:hover { border-color: var(--red); color: var(--red); }

/* ====== MODAL CHECKOUT ====== */
.overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  z-index: 100;
  align-items: center;
  justify-content: center;
}
.overlay.show { display: flex; }

.modal {
  background: white;
  border-radius: 20px;
  width: 480px;
  max-width: 95vw;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 24px 80px rgba(0,0,0,0.25);
  animation: slideUp 0.2s ease;
}

@keyframes slideUp {
  from { transform: translateY(20px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

.modal-header {
  padding: 24px 28px 16px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid var(--border);
}
.modal-title {
  font-size: 18px;
  font-weight: 700;
  color: var(--text);
}
.modal-close {
  width: 32px; height: 32px;
  border: none;
  background: var(--bg);
  border-radius: 8px;
  cursor: pointer;
  font-size: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal-close:hover { background: var(--border); }

.modal-body { padding: 24px 28px; }

.modal-section-label {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.8px;
  color: var(--muted);
  margin-bottom: 10px;
}

/* Tipe Order */
.tipe-group {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 8px;
  margin-bottom: 20px;
}
.tipe-btn {
  border: 2px solid var(--border);
  background: white;
  border-radius: 10px;
  padding: 10px 8px;
  text-align: center;
  cursor: pointer;
  transition: all 0.15s;
  font-family: inherit;
}
.tipe-btn .icon { font-size: 20px; display: block; margin-bottom: 4px; }
.tipe-btn .lbl { font-size: 12px; font-weight: 600; color: var(--text); }
.tipe-btn.selected {
  border-color: var(--primary);
  background: var(--primary-light);
}
.tipe-btn.selected .lbl { color: var(--primary); }

/* Metode Bayar */
.bayar-group {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
  margin-bottom: 20px;
}
.bayar-btn {
  border: 2px solid var(--border);
  background: white;
  border-radius: 10px;
  padding: 12px;
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  transition: all 0.15s;
  font-family: inherit;
  text-align: left;
}
.bayar-btn .b-icon { font-size: 22px; }
.bayar-btn .b-label { font-size: 13px; font-weight: 600; color: var(--text); }
.bayar-btn.selected { border-color: var(--primary); background: var(--primary-light); }
.bayar-btn.selected .b-label { color: var(--primary); }

/* Form fields */
.field-group { margin-bottom: 16px; }
.field-group label {
  font-size: 12px;
  font-weight: 600;
  color: var(--muted);
  display: block;
  margin-bottom: 6px;
}
.field-group input, .field-group textarea {
  width: 100%;
  border: 1px solid var(--border);
  border-radius: 10px;
  padding: 10px 14px;
  font-family: inherit;
  font-size: 14px;
  outline: none;
  transition: border-color 0.15s;
  background: white;
}
.field-group input:focus, .field-group textarea:focus { border-color: var(--primary); }

.promo-row {
  display: flex;
  gap: 8px;
  margin-bottom: 16px;
}
.promo-row input { flex: 1; }
.btn-promo {
  background: var(--primary);
  color: white;
  border: none;
  padding: 10px 16px;
  border-radius: 10px;
  font-family: inherit;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  white-space: nowrap;
}

.promo-info {
  background: #f0fdf4;
  border: 1px solid #bbf7d0;
  color: var(--green);
  padding: 10px 14px;
  border-radius: 8px;
  font-size: 13px;
  margin-bottom: 16px;
  display: none;
}

/* Tunai input */
.tunai-section { display: none; margin-bottom: 16px; }
.tunai-section.show { display: block; }

/* Summary checkout */
.checkout-summary {
  background: var(--bg);
  border-radius: 12px;
  padding: 16px;
  margin-bottom: 20px;
}
.cs-row {
  display: flex;
  justify-content: space-between;
  font-size: 13px;
  color: var(--muted);
  margin-bottom: 6px;
}
.cs-total {
  display: flex;
  justify-content: space-between;
  font-size: 16px;
  font-weight: 800;
  color: var(--text);
  padding-top: 10px;
  border-top: 1px solid var(--border);
  margin-top: 6px;
}

.btn-bayar {
  width: 100%;
  background: var(--green);
  color: white;
  border: none;
  padding: 15px;
  border-radius: 12px;
  font-family: inherit;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.15s;
}
.btn-bayar:hover { background: #15803d; }

/* STRUK MODAL */
.struk-modal {
  background: white;
  border-radius: 20px;
  width: 380px;
  max-width: 95vw;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 24px 80px rgba(0,0,0,0.25);
  animation: slideUp 0.2s ease;
}

.struk-body {
  padding: 28px;
  font-family: 'Courier New', monospace;
  font-size: 13px;
  color: #1a1a1a;
}

.struk-header { text-align: center; margin-bottom: 16px; }
.struk-header h2 { font-size: 18px; font-weight: bold; }
.struk-header p { font-size: 11px; color: #555; margin-top: 2px; }

.struk-divider { border-top: 1px dashed #ccc; margin: 12px 0; }

.struk-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 4px;
}

.struk-item { margin-bottom: 6px; }
.struk-item-name { font-weight: bold; }
.struk-item-detail { display: flex; justify-content: space-between; color: #555; }

.struk-total-box {
  background: #1e1e1e;
  color: white;
  padding: 12px;
  border-radius: 8px;
  margin: 12px 0;
}
.struk-total-box .label { font-size: 11px; color: #aaa; }
.struk-total-box .amount { font-size: 20px; font-weight: bold; }

.struk-thanks {
  text-align: center;
  font-size: 11px;
  color: #777;
  margin-top: 16px;
}

.struk-actions {
  padding: 0 28px 24px;
  display: flex;
  gap: 10px;
}
.btn-print {
  flex: 1;
  background: var(--primary);
  color: white;
  border: none;
  padding: 12px;
  border-radius: 10px;
  font-family: inherit;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
}
.btn-new {
  flex: 1;
  background: var(--bg);
  border: 1px solid var(--border);
  color: var(--text);
  padding: 12px;
  border-radius: 10px;
  font-family: inherit;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
}

@media print {
  body * { visibility: hidden; }
  .struk-print, .struk-print * { visibility: visible; }
  .struk-print { position: fixed; left: 0; top: 0; width: 100%; }
  .struk-actions { display: none; }
}
</style>
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
  <div class="topbar-left">
    <div class="brand">🍽️ Quatre <span> Restaurant</span></div>
    <div class="date-time" id="datetime"></div>
  </div>
  <div class="topbar-right">
    <span class="kasir-badge">👤 <?= esc($kasir) ?></span>
    <a href="/logout" class="btn-logout">Keluar</a>
    <?php if(session()->get('role') === 'admin'): ?>
    <a href="/admin" class="btn-logout" style="color:var(--primary);border-color:var(--primary)">Admin ↗</a>
    <?php endif; ?>
  </div>
</div>

<!-- MAIN -->
<div class="main-wrap">

  <!-- MENU AREA -->
  <div class="menu-area">
    <!-- Kategori Tabs -->
    <div class="kategori-tabs">
      <button class="tab-btn active" onclick="filterKategori('semua', this)">Semua</button>
      <?php foreach ($kategori as $k): if($k['nama']==='Semua') continue; ?>
      <button class="tab-btn" onclick="filterKategori('<?= esc($k['nama']) ?>', this)"><?= esc($k['nama']) ?></button>
      <?php endforeach; ?>
    </div>

    <!-- Search -->
    <div class="search-wrap">
      <span class="search-icon">🔍</span>
      <input type="text" placeholder="Cari menu..." id="searchInput" oninput="searchMenu()">
    </div>

    <!-- Menu Grid -->
    <div class="menu-grid" id="menuGrid">
      <?php foreach ($menu as $m): ?>
      <div class="menu-card <?= $m['tersedia'] ? '' : 'tidak-tersedia' ?>"
           data-id="<?= $m['id'] ?>"
           data-nama="<?= esc($m['nama']) ?>"
           data-harga="<?= $m['harga'] ?>"
           data-kategori="<?= esc($m['kategori_nama']) ?>"
           onclick="<?= $m['tersedia'] ? 'addToCart(this)' : '' ?>">
        <div class="badge-qty" id="badge-<?= $m['id'] ?>">0</div>
        <?php if ($m['gambar']): ?>
          <img class="menu-img" src="/uploads/menu/<?= esc($m['gambar']) ?>" alt="<?= esc($m['nama']) ?>">
        <?php else: ?>
          <div class="menu-emoji"><?= getMenuEmoji($m['nama']) ?></div>
        <?php endif; ?>
        <div class="menu-nama"><?= esc($m['nama']) ?></div>
        <div class="menu-harga">Rp <?= number_format($m['harga'], 0, ',', '.') ?></div>
        <div class="menu-stok"><?= $m['stok'] ?> tersedia</div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- SIDEBAR -->
  <div class="sidebar">
    <div class="sidebar-header">
      <span class="sidebar-title">🛒 Pesanan</span>
      <span class="cart-count" id="cartCountBadge">0 item</span>
    </div>

    <div class="cart-items" id="cartItems">
      <div class="cart-empty">
        <div class="icon">🛍️</div>
        Belum ada pesanan.<br>Pilih menu di sebelah kiri.
      </div>
    </div>

    <div class="sidebar-footer">
      <div class="summary-row">
        <span>Subtotal</span>
        <span id="subtotalVal">Rp 0</span>
      </div>
      <div class="total-row">
        <span class="total-label">Total</span>
        <span class="total-val" id="totalVal">Rp 0</span>
      </div>
      <button class="btn-checkout" id="btnCheckout" onclick="openCheckout()" disabled>
        💳 Bayar Sekarang
      </button>
      <button class="btn-clear" onclick="clearCart()">🗑️ Hapus Semua</button>
    </div>
  </div>
</div>

<!-- ====== MODAL CHECKOUT ====== -->
<div class="overlay" id="checkoutOverlay">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">💳 Checkout</span>
      <button class="modal-close" onclick="closeCheckout()">✕</button>
    </div>
    <div class="modal-body">

      <!-- Tipe Order -->
      <div class="modal-section-label">Tipe Order</div>
      <div class="tipe-group">
        <button class="tipe-btn selected" data-val="dine_in" onclick="selectTipe(this)">
          <span class="icon">🍽️</span><span class="lbl">Dine In</span>
        </button>
        <button class="tipe-btn" data-val="takeaway" onclick="selectTipe(this)">
          <span class="icon">🥡</span><span class="lbl">Takeaway</span>
        </button>
        <button class="tipe-btn" data-val="delivery" onclick="selectTipe(this)">
          <span class="icon">🛵</span><span class="lbl">Delivery</span>
        </button>
      </div>
      <input type="hidden" id="selectedTipe" value="dine_in">

      <!-- Metode Bayar -->
      <div class="modal-section-label">Metode Pembayaran</div>
      <div class="bayar-group">
        <button class="bayar-btn selected" data-val="tunai" onclick="selectBayar(this)">
          <span class="b-icon">💵</span><span class="b-label">Tunai</span>
        </button>
        <button class="bayar-btn" data-val="transfer" onclick="selectBayar(this)">
          <span class="b-icon">🏦</span><span class="b-label">Transfer Bank</span>
        </button>
        <button class="bayar-btn" data-val="qris" onclick="selectBayar(this)">
          <span class="b-icon">📱</span><span class="b-label">QRIS</span>
        </button>
      </div>
      <input type="hidden" id="selectedBayar" value="tunai">

      <!-- QRIS Image -->
      <div id="qrisSection" style="display:none;text-align:center;margin-bottom:16px;">
        <p style="font-size:12px;color:var(--muted);margin-bottom:8px;">Scan QRIS untuk membayar:</p>
        <div style="width:180px;height:180px;background:#f0f0f0;border-radius:12px;margin:0 auto;display:flex;align-items:center;justify-content:center;font-size:60px;border:3px dashed #ccc;">📱</div>
        <p style="font-size:11px;color:var(--muted);margin-top:8px;">QRIS - Quatre Restaurant</p>
      </div>

      <!-- Tunai -->
      <div class="tunai-section show" id="tunaiSection">
        <div class="field-group">
          <label>Jumlah Uang Diterima</label>
          <input type="number" id="inputBayar" placeholder="0" oninput="hitungKembalian()">
        </div>
        <div style="display:flex;justify-content:space-between;font-size:13px;">
          <span style="color:var(--muted)">Kembalian</span>
          <span id="kembalianVal" style="font-weight:700;color:var(--green)">Rp 0</span>
        </div>
      </div>

      <!-- Nama Pelanggan -->
      <div class="field-group">
        <label>Nama Pelanggan (opsional)</label>
        <input type="text" id="inputNama" placeholder="Kosongkan untuk Umum">
      </div>

      <!-- Promo -->
      <div class="modal-section-label">Kode Promo</div>
      <div class="promo-row">
        <input type="text" id="inputPromo" placeholder="Masukkan kode promo" style="text-transform:uppercase">
        <button class="btn-promo" onclick="cekPromo()">Pakai</button>
      </div>
      <div class="promo-info" id="promoInfo"></div>

      <!-- Catatan -->
      <div class="field-group">
        <label>Catatan Pesanan</label>
        <textarea id="inputCatatan" rows="2" placeholder="Catatan tambahan..." style="resize:none"></textarea>
      </div>

      <!-- Summary -->
      <div class="checkout-summary">
        <div class="cs-row"><span>Subtotal</span><span id="co-subtotal">Rp 0</span></div>
        <div class="cs-row" id="co-diskon-row" style="display:none;color:var(--green)">
          <span>Diskon</span><span id="co-diskon">- Rp 0</span>
        </div>
        <div class="cs-total">
          <span>TOTAL</span><span id="co-total">Rp 0</span>
        </div>
      </div>

      <button class="btn-bayar" onclick="prosesCheckout()">✅ Bayar Sekarang</button>
    </div>
  </div>
</div>

<!-- ====== STRUK MODAL ====== -->
<div class="overlay" id="strukOverlay">
  <div class="struk-modal">
    <div class="struk-body struk-print" id="strukContent">
      <!-- Diisi via JS -->
    </div>
    <div class="struk-actions">
      <button class="btn-print" onclick="printStruk()">🖨️ Print</button>
      <button class="btn-new" onclick="closeStruk()">Pesanan Baru</button>
    </div>
  </div>
</div>

<script>
// ======= DATA =======
let cart = {};
let diskon = 0;
let promoCode = '';

// Update datetime
function updateDateTime() {
  const now = new Date();
  const opts = { weekday:'long', year:'numeric', month:'long', day:'numeric', hour:'2-digit', minute:'2-digit' };
  document.getElementById('datetime').textContent = now.toLocaleDateString('id-ID', opts);
}
setInterval(updateDateTime, 1000); updateDateTime();

// Format rupiah
function rp(n) {
  return 'Rp ' + parseInt(n).toLocaleString('id-ID');
}

// ======= MENU FUNCTIONS =======
function filterKategori(kat, btn) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.menu-card').forEach(card => {
    if (kat === 'semua' || card.dataset.kategori === kat) {
      card.style.display = '';
    } else {
      card.style.display = 'none';
    }
  });
}

function searchMenu() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  document.querySelectorAll('.menu-card').forEach(card => {
    card.style.display = card.dataset.nama.toLowerCase().includes(q) ? '' : 'none';
  });
}

// ======= CART =======
function addToCart(el) {
  const id = el.dataset.id;
  const nama = el.dataset.nama;
  const harga = parseInt(el.dataset.harga);

  if (!cart[id]) {
    cart[id] = { id, nama, harga, qty: 0 };
  }
  cart[id].qty++;
  el.classList.add('in-cart');
  document.getElementById('badge-' + id).textContent = cart[id].qty;
  renderCart();
}

function changeQty(id, delta) {
  if (!cart[id]) return;
  cart[id].qty += delta;
  if (cart[id].qty <= 0) {
    delete cart[id];
    const card = document.querySelector(`[data-id="${id}"]`);
    if (card) {
      card.classList.remove('in-cart');
      document.getElementById('badge-' + id).textContent = 0;
    }
  } else {
    document.getElementById('badge-' + id).textContent = cart[id].qty;
  }
  renderCart();
}

function clearCart() {
  cart = {};
  diskon = 0; promoCode = '';
  document.querySelectorAll('.menu-card').forEach(c => {
    c.classList.remove('in-cart');
  });
  document.querySelectorAll('.badge-qty').forEach(b => b.textContent = 0);
  renderCart();
}

function renderCart() {
  const container = document.getElementById('cartItems');
  const items = Object.values(cart);

  if (items.length === 0) {
    container.innerHTML = `<div class="cart-empty"><div class="icon">🛍️</div>Belum ada pesanan.<br>Pilih menu di sebelah kiri.</div>`;
    document.getElementById('btnCheckout').disabled = true;
    document.getElementById('cartCountBadge').textContent = '0 item';
    document.getElementById('subtotalVal').textContent = rp(0);
    document.getElementById('totalVal').textContent = rp(0);
    return;
  }

  let subtotal = 0;
  let html = '';
  let totalItems = 0;
  items.forEach(item => {
    subtotal += item.harga * item.qty;
    totalItems += item.qty;
    html += `
    <div class="cart-item">
      <div style="flex:1">
        <div class="cart-item-name">${item.nama}</div>
        <div class="cart-item-price">${rp(item.harga)}</div>
      </div>
      <div class="qty-control">
        <button class="qty-btn" onclick="changeQty('${item.id}', -1)">−</button>
        <span class="qty-num">${item.qty}</span>
        <button class="qty-btn" onclick="changeQty('${item.id}', 1)">+</button>
      </div>
      <div class="cart-item-total">${rp(item.harga * item.qty)}</div>
    </div>`;
  });

  container.innerHTML = html;
  const total = subtotal - diskon;
  document.getElementById('cartCountBadge').textContent = totalItems + ' item';
  document.getElementById('subtotalVal').textContent = rp(subtotal);
  document.getElementById('totalVal').textContent = rp(total);
  document.getElementById('btnCheckout').disabled = false;

  // Update checkout summary too
  updateCheckoutSummary(subtotal);
}

function getSubtotal() {
  return Object.values(cart).reduce((s, i) => s + i.harga * i.qty, 0);
}

function updateCheckoutSummary(subtotal) {
  if (!subtotal) subtotal = getSubtotal();
  const total = subtotal - diskon;
  document.getElementById('co-subtotal').textContent = rp(subtotal);
  document.getElementById('co-total').textContent = rp(total);
  if (diskon > 0) {
    document.getElementById('co-diskon-row').style.display = 'flex';
    document.getElementById('co-diskon').textContent = '- ' + rp(diskon);
  } else {
    document.getElementById('co-diskon-row').style.display = 'none';
  }
}

// ======= CHECKOUT MODAL =======
function openCheckout() {
  updateCheckoutSummary();
  document.getElementById('checkoutOverlay').classList.add('show');
}

function closeCheckout() {
  document.getElementById('checkoutOverlay').classList.remove('show');
}

function selectTipe(btn) {
  document.querySelectorAll('.tipe-btn').forEach(b => b.classList.remove('selected'));
  btn.classList.add('selected');
  document.getElementById('selectedTipe').value = btn.dataset.val;
}

function selectBayar(btn) {
  document.querySelectorAll('.bayar-btn').forEach(b => b.classList.remove('selected'));
  btn.classList.add('selected');
  const val = btn.dataset.val;
  document.getElementById('selectedBayar').value = val;
  document.getElementById('tunaiSection').classList.toggle('show', val === 'tunai');
  document.getElementById('qrisSection').style.display = val === 'qris' ? 'block' : 'none';
}

function hitungKembalian() {
  const total = getSubtotal() - diskon;
  const bayar = parseInt(document.getElementById('inputBayar').value) || 0;
  const kembalian = Math.max(0, bayar - total);
  document.getElementById('kembalianVal').textContent = rp(kembalian);
}

async function cekPromo() {
  const kode = document.getElementById('inputPromo').value.trim();
  if (!kode) return;
  const subtotal = getSubtotal();

  const res = await fetch('/kasir/cek-promo', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
    body: `kode=${encodeURIComponent(kode)}&subtotal=${subtotal}&<?= csrf_token() ?>=<?= csrf_hash() ?>`
  });
  const data = await res.json();

  const infoEl = document.getElementById('promoInfo');
  if (data.success) {
    diskon = data.diskon;
    promoCode = kode;
    infoEl.style.display = 'block';
    infoEl.textContent = `✅ Promo "${data.nama}" berhasil! Diskon ${rp(diskon)}`;
    updateCheckoutSummary(subtotal);
    renderCart();
  } else {
    diskon = 0; promoCode = '';
    infoEl.style.display = 'block';
    infoEl.style.background = '#fef2f2';
    infoEl.style.borderColor = '#fecaca';
    infoEl.style.color = 'var(--red)';
    infoEl.textContent = '❌ ' + data.message;
  }
}

async function prosesCheckout() {
  const items = Object.values(cart);
  if (!items.length) return;

  const metodeBayar = document.getElementById('selectedBayar').value;
  const bayar = metodeBayar === 'tunai'
    ? parseInt(document.getElementById('inputBayar').value) || 0
    : getSubtotal() - diskon;

  const total = getSubtotal() - diskon;
  if (metodeBayar === 'tunai' && bayar < total) {
    alert('Jumlah uang kurang! Total: ' + rp(total));
    return;
  }

  const payload = new URLSearchParams({
    items: JSON.stringify(items),
    tipe_order: document.getElementById('selectedTipe').value,
    metode_bayar: metodeBayar,
    bayar: bayar,
    promo_code: promoCode,
    nama_pelanggan: document.getElementById('inputNama').value,
    catatan: document.getElementById('inputCatatan').value,
    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
  });

  const res = await fetch('/kasir/checkout', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
    body: payload
  });

  const data = await res.json();
  if (data.success) {
    closeCheckout();
    showStruk(data.transaksi_id, data.no_invoice, items, bayar, metodeBayar);
  } else {
    alert(data.message || 'Gagal memproses pembayaran.');
  }
}

function showStruk(trxId, noInvoice, items, bayar, metode) {
  const subtotal = getSubtotal();
  const total = subtotal - diskon;
  const kembalian = Math.max(0, bayar - total);
  const tipe = document.getElementById('selectedTipe').value;
  const tipeLabel = { dine_in:'Dine In', takeaway:'Takeaway', delivery:'Delivery' }[tipe];
  const metodeLabel = { tunai:'Tunai', qris:'QRIS', transfer:'Transfer Bank' }[metode];
  const now = new Date();
  const tgl = now.toLocaleDateString('id-ID', {day:'2-digit',month:'2-digit',year:'numeric'}) + ' ' + now.toLocaleTimeString('id-ID');

  let itemsHtml = '';
  items.forEach(i => {
    itemsHtml += `
    <div class="struk-item">
      <div class="struk-item-name">${i.nama}</div>
      <div class="struk-item-detail">
        <span>${i.qty} x ${rp(i.harga)}</span>
        <span>${rp(i.harga * i.qty)}</span>
      </div>
    </div>`;
  });

  document.getElementById('strukContent').innerHTML = `
    <div class="struk-header">
      <h2>🍽️ Quatre Restaurant</h2>
      <p>Jl. Contoh No. 123, Jakarta</p>
      <p>Telp: 021-12345678</p>
    </div>
    <div class="struk-divider"></div>
    <div class="struk-row"><span>No. Invoice</span><span>${noInvoice}</span></div>
    <div class="struk-row"><span>Tanggal</span><span>${tgl}</span></div>
    <div class="struk-row"><span>Kasir</span><span>${'<?= esc($kasir) ?>'}</span></div>
    <div class="struk-row"><span>Tipe Order</span><span>${tipeLabel}</span></div>
    <div class="struk-divider"></div>
    ${itemsHtml}
    <div class="struk-divider"></div>
    <div class="struk-row"><span>Subtotal</span><span>${rp(subtotal)}</span></div>
    ${diskon > 0 ? `<div class="struk-row"><span>Diskon (${promoCode})</span><span>- ${rp(diskon)}</span></div>` : ''}
    <div class="struk-total-box">
      <div class="label">TOTAL PEMBAYARAN</div>
      <div class="amount">${rp(total)}</div>
    </div>
    <div class="struk-row"><span>Metode Bayar</span><span>${metodeLabel}</span></div>
    ${metode === 'tunai' ? `<div class="struk-row"><span>Bayar</span><span>${rp(bayar)}</span></div>
    <div class="struk-row"><span>Kembalian</span><span>${rp(kembalian)}</span></div>` : ''}
    <div class="struk-divider"></div>
    <div class="struk-thanks">
      Terima kasih atas kunjungan Anda! 😊<br>
      Selamat menikmati pesanan Anda.
    </div>
  `;
  document.getElementById('strukOverlay').classList.add('show');
}

function printStruk() {
  window.print();
}

function closeStruk() {
  document.getElementById('strukOverlay').classList.remove('show');
  clearCart();
}
</script>

<?php
function getMenuEmoji($nama) {
  $nama = strtolower($nama);
  if (strpos($nama, 'coffee') !== false || strpos($nama, 'kopi') !== false || strpos($nama, 'latte') !== false || strpos($nama, 'americano') !== false) return '☕';
  if (strpos($nama, 'tea') !== false || strpos($nama, 'teh') !== false) return '🍵';
  if (strpos($nama, 'pizza') !== false) return '🍕';
  if (strpos($nama, 'ramen') !== false) return '🍜';
  if (strpos($nama, 'indomie') !== false || strpos($nama, 'mie') !== false || strpos($nama, 'kwetiau') !== false) return '🍝';
  if (strpos($nama, 'nugget') !== false || strpos($nama, 'chicken') !== false) return '🍗';
  if (strpos($nama, 'chips') !== false || strpos($nama, 'potato') !== false) return '🍟';
  if (strpos($nama, 'matcha') !== false) return '🍵';
  if (strpos($nama, 'chocolate') !== false) return '🍫';
  if (strpos($nama, 'tahu') !== false) return '🟨';
  if (strpos($nama, 'breakfast') !== false) return '🍳';
  return '🍽️';
}
?>

</body>
</html>