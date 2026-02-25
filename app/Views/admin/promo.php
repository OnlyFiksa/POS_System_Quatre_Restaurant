<?php $this->extend('layouts/admin'); ?>
<?php $this->section('content'); ?>

<div style="display:grid;grid-template-columns:1fr 380px;gap:24px;">

  <!-- Tabel Promo -->
  <div class="card">
    <div style="font-size:16px;font-weight:700;color:var(--text);margin-bottom:16px;">🏷️ Daftar Promo</div>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Nilai</th>
            <th>Min. Transaksi</th>
            <th>Expired</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($promo as $p): ?>
          <tr>
            <td><span style="font-family:monospace;font-weight:700;color:var(--primary);"><?= esc($p['kode']) ?></span></td>
            <td><?= esc($p['nama']) ?></td>
            <td>
              <?php if ($p['tipe'] === 'persen'): ?>
                <span class="badge badge-purple" style="background:#f5f3ff;color:#7c3aed;"><?= $p['nilai'] ?>%</span>
              <?php else: ?>
                <span class="badge badge-green">Rp <?= number_format($p['nilai'], 0, ',', '.') ?></span>
              <?php endif; ?>
            </td>
            <td>Rp <?= number_format($p['min_transaksi'], 0, ',', '.') ?></td>
            <td style="font-size:12px;"><?= $p['expired_at'] ? date('d/m/Y', strtotime($p['expired_at'])) : '∞ Selamanya' ?></td>
            <td><span class="badge <?= $p['aktif'] ? 'badge-green' : 'badge-gray' ?>"><?= $p['aktif'] ? 'Aktif' : 'Nonaktif' ?></span></td>
            <td>
              <a href="/admin/promo/hapus/<?= $p['id'] ?>" class="btn btn-danger btn-sm"
                 onclick="return confirm('Hapus promo ini?')">🗑️</a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($promo)): ?>
          <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:24px;">Belum ada promo.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Form Tambah Promo -->
  <div class="card" style="height:fit-content;">
    <div style="font-size:16px;font-weight:700;color:var(--text);margin-bottom:20px;">+ Tambah Promo</div>
    <form method="POST" action="/admin/promo/simpan">
      <?= csrf_field() ?>

      <div style="margin-bottom:14px;">
        <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:6px;">Kode Promo *</label>
        <input type="text" name="kode" required placeholder="MANTAP10" style="text-transform:uppercase;width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;font-family:inherit;font-size:14px;outline:none;">
      </div>

      <div style="margin-bottom:14px;">
        <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:6px;">Nama Promo *</label>
        <input type="text" name="nama" required placeholder="Diskon 10%" style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;font-family:inherit;font-size:14px;outline:none;">
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
        <div>
          <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:6px;">Tipe</label>
          <select name="tipe" style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;font-family:inherit;font-size:14px;outline:none;background:white;">
            <option value="persen">Persentase (%)</option>
            <option value="nominal">Nominal (Rp)</option>
          </select>
        </div>
        <div>
          <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:6px;">Nilai *</label>
          <input type="number" name="nilai" required placeholder="10" min="1" style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;font-family:inherit;font-size:14px;outline:none;">
        </div>
      </div>

      <div style="margin-bottom:14px;">
        <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:6px;">Min. Transaksi (Rp)</label>
        <input type="number" name="min_transaksi" placeholder="50000" min="0" style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;font-family:inherit;font-size:14px;outline:none;">
      </div>

      <div style="margin-bottom:20px;">
        <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:6px;">Expired (opsional)</label>
        <input type="date" name="expired_at" style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;font-family:inherit;font-size:14px;outline:none;">
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;">💾 Simpan Promo</button>
    </form>
  </div>
</div>

<?php $this->endSection(); ?>