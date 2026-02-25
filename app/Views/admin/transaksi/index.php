<?php $this->extend('layouts/admin'); ?>
<?php $this->section('content'); ?>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
  <div>
    <h2 style="font-size:20px;font-weight:700;color:var(--text);">Riwayat Transaksi</h2>
    <p style="font-size:13px;color:var(--muted);"><?= count($list) ?> transaksi ditemukan</p>
  </div>
</div>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Invoice</th>
          <th>Tanggal</th>
          <th>Kasir</th>
          <th>Pelanggan</th>
          <th>Tipe</th>
          <th>Metode</th>
          <th>Promo</th>
          <th>Total</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($list as $t): ?>
        <tr>
          <td><span style="font-family:monospace;font-weight:600;font-size:12px;color:var(--primary);"><?= esc($t['no_invoice']) ?></span></td>
          <td style="font-size:12px;color:var(--muted);"><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
          <td><?= esc($t['kasir'] ?? '-') ?></td>
          <td><?= esc($t['nama_pelanggan'] ?? 'Umum') ?></td>
          <td>
            <?php $tipeMap = ['dine_in'=>['label'=>'Dine In','icon'=>'🍽️'], 'takeaway'=>['label'=>'Takeaway','icon'=>'🥡'], 'delivery'=>['label'=>'Delivery','icon'=>'🛵']]; ?>
            <?php $tipe = $tipeMap[$t['tipe_order']] ?? ['label'=>$t['tipe_order'],'icon'=>'📦']; ?>
            <span style="font-size:13px;"><?= $tipe['icon'] ?> <?= $tipe['label'] ?></span>
          </td>
          <td>
            <?php $metMap = ['tunai'=>'💵 Tunai','qris'=>'📱 QRIS','transfer'=>'🏦 Transfer']; ?>
            <span style="font-size:13px;"><?= $metMap[$t['metode_bayar']] ?? $t['metode_bayar'] ?></span>
          </td>
          <td>
            <?php if ($t['promo_code']): ?>
            <span class="badge badge-amber"><?= esc($t['promo_code']) ?></span>
            <?php else: ?>
            <span style="color:var(--muted);font-size:12px;">-</span>
            <?php endif; ?>
          </td>
          <td style="font-weight:700;">Rp <?= number_format($t['total'], 0, ',', '.') ?></td>
          <td>
            <?php $cls = ['lunas'=>'badge-green','batal'=>'badge-red','pending'=>'badge-amber'][$t['status']] ?? 'badge-gray'; ?>
            <span class="badge <?= $cls ?>"><?= ucfirst($t['status']) ?></span>
          </td>
          <td>
            <div style="display:flex;gap:6px;flex-wrap:wrap;">
              <a href="/admin/transaksi/struk/<?= $t['id'] ?>" class="btn btn-ghost btn-sm">🖨️ Struk</a>
              <?php if ($t['status'] === 'lunas'): ?>
              <a href="/admin/transaksi/batal/<?= $t['id'] ?>" class="btn btn-danger btn-sm"
                 onclick="return confirm('Batalkan transaksi ini?')">❌ Batal</a>
              <?php endif; ?>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($list)): ?>
        <tr><td colspan="10" style="text-align:center;color:var(--muted);padding:24px;">Belum ada transaksi.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php $this->endSection(); ?>