<?php $this->extend('layouts/admin'); ?>
<?php $this->section('content'); ?>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
  <div>
    <h2 style="font-size:20px;font-weight:700;color:var(--text);">Daftar Menu</h2>
    <p style="font-size:13px;color:var(--muted);"><?= count($menu) ?> item menu</p>
  </div>
  <a href="/admin/menu/tambah" class="btn btn-primary">+ Tambah Menu</a>
</div>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Gambar</th>
          <th>Nama Menu</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Stok</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($menu as $m): ?>
        <tr>
          <td>
            <?php if ($m['gambar']): ?>
              <img src="/uploads/menu/<?= esc($m['gambar']) ?>" style="width:48px;height:48px;border-radius:50%;object-fit:cover;">
            <?php else: ?>
              <div style="width:48px;height:48px;border-radius:50%;background:var(--bg);display:flex;align-items:center;justify-content:center;font-size:22px;"><?= getMenuEmojiAdmin($m['nama']) ?></div>
            <?php endif; ?>
          </td>
          <td>
            <div style="font-weight:600;color:var(--text);"><?= esc($m['nama']) ?></div>
            <?php if ($m['deskripsi']): ?>
            <div style="font-size:12px;color:var(--muted);"><?= esc(substr($m['deskripsi'], 0, 40)) ?>...</div>
            <?php endif; ?>
          </td>
          <td><span class="badge badge-blue"><?= esc($m['kategori_nama'] ?? '-') ?></span></td>
          <td style="font-weight:700;">Rp <?= number_format($m['harga'], 0, ',', '.') ?></td>
          <td>
            <span class="badge <?= $m['stok'] > 10 ? 'badge-green' : 'badge-red' ?>"><?= $m['stok'] ?></span>
          </td>
          <td>
            <span class="badge <?= $m['tersedia'] ? 'badge-green' : 'badge-gray' ?>">
              <?= $m['tersedia'] ? 'Tersedia' : 'Nonaktif' ?>
            </span>
          </td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="/admin/menu/edit/<?= $m['id'] ?>" class="btn btn-ghost btn-sm">✏️ Edit</a>
              <a href="/admin/menu/toggle/<?= $m['id'] ?>" class="btn btn-ghost btn-sm" 
                 onclick="return confirm('Ubah status menu?')">
                <?= $m['tersedia'] ? '🚫 Nonaktif' : '✅ Aktif' ?>
              </a>
              <a href="/admin/menu/hapus/<?= $m['id'] ?>" class="btn btn-danger btn-sm"
                 onclick="return confirm('Hapus menu ini?')">🗑️</a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($menu)): ?>
        <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:24px;">Belum ada menu. <a href="/admin/menu/tambah">Tambah sekarang</a></td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php function getMenuEmojiAdmin($nama) {
  $nama = strtolower($nama);
  if (strpos($nama,'coffee')!==false||strpos($nama,'latte')!==false||strpos($nama,'americano')!==false) return '☕';
  if (strpos($nama,'tea')!==false) return '🍵';
  if (strpos($nama,'pizza')!==false) return '🍕';
  if (strpos($nama,'ramen')!==false) return '🍜';
  if (strpos($nama,'mie')!==false||strpos($nama,'indomie')!==false||strpos($nama,'kwetiau')!==false) return '🍝';
  if (strpos($nama,'chicken')!==false||strpos($nama,'nugget')!==false) return '🍗';
  if (strpos($nama,'chips')!==false||strpos($nama,'wedges')!==false) return '🍟';
  if (strpos($nama,'matcha')!==false) return '🍵';
  if (strpos($nama,'chocolate')!==false) return '🍫';
  if (strpos($nama,'tahu')!==false) return '🟨';
  return '🍽️';
} ?>

<?php $this->endSection(); ?>