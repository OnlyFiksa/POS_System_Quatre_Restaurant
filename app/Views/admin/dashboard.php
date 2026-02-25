<?php $this->extend('layouts/admin'); ?>
<?php $this->section('content'); ?>

<!-- STAT CARDS -->
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;">

  <div class="card" style="position:relative;overflow:hidden;">
    <div style="font-size:12px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Pendapatan Hari Ini</div>
    <div style="font-size:24px;font-weight:800;color:var(--text);">Rp <?= number_format($today['total_pendapatan'] ?? 0, 0, ',', '.') ?></div>
    <div style="font-size:12px;color:var(--muted);margin-top:4px;"><?= $today['jumlah_transaksi'] ?? 0 ?> transaksi</div>
    <div style="position:absolute;right:20px;top:50%;transform:translateY(-50%);font-size:36px;opacity:0.12">💰</div>
  </div>

  <div class="card" style="position:relative;overflow:hidden;">
    <div style="font-size:12px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Transaksi Bulan Ini</div>
    <div style="font-size:24px;font-weight:800;color:var(--text);"><?= $bulanIni['jumlah'] ?? 0 ?></div>
    <div style="font-size:12px;color:var(--muted);margin-top:4px;">Rp <?= number_format($bulanIni['total'] ?? 0, 0, ',', '.') ?></div>
    <div style="position:absolute;right:20px;top:50%;transform:translateY(-50%);font-size:36px;opacity:0.12">📋</div>
  </div>

  <div class="card" style="position:relative;overflow:hidden;">
    <div style="font-size:12px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Total Menu</div>
    <div style="font-size:24px;font-weight:800;color:var(--text);"><?= $totalMenu ?></div>
    <div style="font-size:12px;color:var(--muted);margin-top:4px;">Item di menu</div>
    <div style="position:absolute;right:20px;top:50%;transform:translateY(-50%);font-size:36px;opacity:0.12">🍽️</div>
  </div>

  <div class="card" style="position:relative;overflow:hidden;">
    <div style="font-size:12px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Rata-rata Transaksi</div>
    <div style="font-size:24px;font-weight:800;color:var(--text);">Rp <?= number_format($today['rata_rata'] ?? 0, 0, ',', '.') ?></div>
    <div style="font-size:12px;color:var(--muted);margin-top:4px;">Per order hari ini</div>
    <div style="position:absolute;right:20px;top:50%;transform:translateY(-50%);font-size:36px;opacity:0.12">📈</div>
  </div>

</div>

<!-- CHART + TERLARIS -->
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-bottom:24px;">

  <!-- Chart Pendapatan -->
  <div class="card">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
      <div>
        <div style="font-size:15px;font-weight:700;color:var(--text);">Tren Pendapatan</div>
        <div style="font-size:12px;color:var(--muted);">14 hari terakhir</div>
      </div>
    </div>
    <canvas id="chartPendapatan" height="200"></canvas>
  </div>

  <!-- Produk Terlaris -->
  <div class="card">
    <div style="font-size:15px;font-weight:700;color:var(--text);margin-bottom:16px;">🏆 Produk Terlaris</div>
    <?php if (empty($terlaris)): ?>
      <p style="color:var(--muted);font-size:13px;">Belum ada data.</p>
    <?php else: ?>
    <?php $maxQty = max(array_column($terlaris, 'total_qty')); ?>
    <?php foreach ($terlaris as $i => $p): ?>
    <div style="margin-bottom:14px;">
      <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:4px;">
        <span style="font-weight:600;color:var(--text);"><?= esc($p['nama_menu']) ?></span>
        <span style="color:var(--primary);font-weight:700;"><?= $p['total_qty'] ?>x</span>
      </div>
      <div style="background:#f0f0f0;border-radius:4px;height:6px;overflow:hidden;">
        <div style="background:var(--primary);height:100%;width:<?= ($p['total_qty']/$maxQty*100) ?>%;border-radius:4px;"></div>
      </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<!-- TRANSAKSI TERAKHIR -->
<div class="card">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
    <div style="font-size:15px;font-weight:700;color:var(--text);">📋 Transaksi Terakhir</div>
    <a href="/admin/transaksi" class="btn btn-ghost btn-sm">Lihat Semua</a>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Invoice</th>
          <th>Waktu</th>
          <th>Kasir</th>
          <th>Tipe</th>
          <th>Metode</th>
          <th>Total</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($terakhir as $t): ?>
        <tr>
          <td><span style="font-family:monospace;font-weight:600;font-size:12px;"><?= esc($t['no_invoice']) ?></span></td>
          <td style="font-size:12px;color:var(--muted);"><?= date('d/m H:i', strtotime($t['created_at'])) ?></td>
          <td><?= esc($t['kasir'] ?? '-') ?></td>
          <td>
            <?php $tipe = ['dine_in'=>'Dine In','takeaway'=>'Takeaway','delivery'=>'Delivery'][$t['tipe_order']] ?? $t['tipe_order']; ?>
            <span class="badge badge-blue"><?= $tipe ?></span>
          </td>
          <td>
            <?php $met = ['tunai'=>'Tunai','qris'=>'QRIS','transfer'=>'Transfer'][$t['metode_bayar']] ?? $t['metode_bayar']; ?>
            <?= esc($met) ?>
          </td>
          <td style="font-weight:700;">Rp <?= number_format($t['total'], 0, ',', '.') ?></td>
          <td>
            <?php $cls = ['lunas'=>'badge-green','batal'=>'badge-red','pending'=>'badge-amber'][$t['status']] ?? 'badge-gray'; ?>
            <span class="badge <?= $cls ?>"><?= ucfirst($t['status']) ?></span>
          </td>
          <td>
            <a href="/admin/transaksi/struk/<?= $t['id'] ?>" class="btn btn-ghost btn-sm">🖨️</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($terakhir)): ?>
        <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:24px;">Belum ada transaksi.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const pendapatanData = <?= json_encode($pendapatan14) ?>;

const labels = [];
const values = [];
const now = new Date();
for (let i = 13; i >= 0; i--) {
  const d = new Date(now);
  d.setDate(d.getDate() - i);
  const str = d.toISOString().split('T')[0];
  const found = pendapatanData.find(p => p.tanggal === str);
  labels.push(d.toLocaleDateString('id-ID', {day:'2-digit', month:'short'}));
  values.push(found ? parseInt(found.total) : 0);
}

const ctx = document.getElementById('chartPendapatan').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels,
    datasets: [{
      label: 'Pendapatan',
      data: values,
      borderColor: '#2563eb',
      backgroundColor: 'rgba(37,99,235,0.08)',
      borderWidth: 2.5,
      fill: true,
      tension: 0.4,
      pointRadius: 4,
      pointBackgroundColor: '#2563eb',
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false },
      tooltip: {
        callbacks: {
          label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID')
        }
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          callback: v => 'Rp ' + (v/1000) + 'k',
          font: { size: 11 }
        },
        grid: { color: '#f0f0f0' }
      },
      x: {
        ticks: { font: { size: 11 } },
        grid: { display: false }
      }
    }
  }
});
</script>

<?php $this->endSection(); ?>