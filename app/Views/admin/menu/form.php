<?php $this->extend('layouts/admin'); ?>
<?php $this->section('content'); ?>

<div style="max-width:600px;">
  <div style="margin-bottom:20px;">
    <a href="/admin/menu" style="color:var(--muted);font-size:13px;text-decoration:none;">← Kembali ke Menu</a>
    <h2 style="font-size:20px;font-weight:700;color:var(--text);margin-top:4px;"><?= $title ?></h2>
  </div>

  <div class="card">
    <form method="POST" action="<?= $menu ? '/admin/menu/update/'.$menu['id'] : '/admin/menu/simpan' ?>" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <div style="margin-bottom:16px;">
        <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:6px;">Nama Menu *</label>
        <input type="text" name="nama" required value="<?= esc($menu['nama'] ?? '') ?>"
          placeholder="Contoh: Cheese Pizza"
          style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;font-family:inherit;font-size:14px;outline:none;">
      </div>

      <div style="margin-bottom:16px;">
        <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:6px;">Kategori *</label>
        <select name="kategori_id" required
          style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;font-family:inherit;font-size:14px;outline:none;background:white;">
          <option value="">-- Pilih Kategori --</option>
          <?php foreach ($kategori as $k): if($k['nama']==='Semua') continue; ?>
          <option value="<?= $k['id'] ?>" <?= ($menu['kategori_id'] ?? '') == $k['id'] ? 'selected' : '' ?>>
            <?= esc($k['nama']) ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
        <div>
          <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:6px;">Harga (Rp) *</label>
          <input type="number" name="harga" required value="<?= $menu['harga'] ?? '' ?>"
            placeholder="15000" min="0"
            style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;font-family:inherit;font-size:14px;outline:none;">
        </div>
        <div>
          <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:6px;">Stok</label>
          <input type="number" name="stok" value="<?= $menu['stok'] ?? 100 ?>"
            placeholder="100" min="0"
            style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;font-family:inherit;font-size:14px;outline:none;">
        </div>
      </div>

      <div style="margin-bottom:16px;">
        <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:6px;">Deskripsi</label>
        <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat menu..."
          style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;font-family:inherit;font-size:14px;outline:none;resize:vertical;"><?= esc($menu['deskripsi'] ?? '') ?></textarea>
      </div>

      <div style="margin-bottom:24px;">
        <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:6px;">Gambar Menu</label>
        <?php if (!empty($menu['gambar'])): ?>
        <div style="margin-bottom:8px;">
          <img src="/uploads/menu/<?= esc($menu['gambar']) ?>" style="width:80px;height:80px;border-radius:50%;object-fit:cover;">
          <p style="font-size:11px;color:var(--muted);margin-top:4px;">Upload baru untuk mengganti gambar lama</p>
        </div>
        <?php endif; ?>
        <input type="file" name="gambar" accept="image/*"
          style="width:100%;padding:8px;border:1px dashed var(--border);border-radius:10px;font-size:13px;">
        <p style="font-size:11px;color:var(--muted);margin-top:4px;">JPG, PNG, WebP. Jika kosong, akan digunakan emoji default.</p>
      </div>

      <div style="display:flex;gap:12px;">
        <button type="submit" class="btn btn-primary">💾 Simpan Menu</button>
        <a href="/admin/menu" class="btn btn-ghost">Batal</a>
      </div>
    </form>
  </div>
</div>

<?php $this->endSection(); ?>