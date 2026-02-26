<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - <?= esc($trx['no_invoice']) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 13px;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        .struk {
            background: #fff;
            width: 300px;
            padding: 16px;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        .divider { border-top: 1px dashed #333; margin: 8px 0; }
        .row { display: flex; justify-content: space-between; margin-bottom: 2px; }
        .items-table { width: 100%; }
        .items-table td { padding: 2px 0; vertical-align: top; }
        .items-table .td-right { text-align: right; white-space: nowrap; }
        .total-row { font-weight: bold; font-size: 14px; }
        .footer { text-align: center; margin-top: 10px; font-size: 12px; color: #555; }
        .btn-print {
            display: block;
            width: 100%;
            margin-top: 16px;
            padding: 8px;
            background: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
        .btn-print:hover { background: #555; }
        @media print {
            body { background: #fff; padding: 0; }
            .struk { box-shadow: none; border-radius: 0; width: 100%; }
            .btn-print { display: none; }
        }
    </style>
</head>
<body>
<div class="struk">
    <div class="text-center bold" style="font-size:15px;">RESTORAN</div>
    <div class="text-center" style="margin-bottom:4px;">Struk Pembayaran</div>
    <div class="divider"></div>

    <div class="row"><span>No. Invoice</span><span><?= esc($trx['no_invoice']) ?></span></div>
    <div class="row"><span>Tanggal</span><span><?= esc(date('d/m/Y H:i', strtotime($trx['created_at'] ?? 'now'))) ?></span></div>
    <div class="row"><span>Pelanggan</span><span><?= esc($trx['nama_pelanggan'] ?? '-') ?></span></div>
    <div class="row"><span>Tipe Order</span><span><?= esc(ucfirst($trx['tipe_order'] ?? '-')) ?></span></div>
    <div class="row"><span>Metode Bayar</span><span><?= esc(ucfirst($trx['metode_bayar'] ?? '-')) ?></span></div>

    <div class="divider"></div>

    <table class="items-table">
        <?php foreach ($trx['detail'] as $item): ?>
        <tr>
            <td><?= esc($item['nama_menu']) ?></td>
            <td class="td-right">
                <?= esc($item['qty']) ?> x <?= number_format($item['harga'], 0, ',', '.') ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td class="td-right"><?= number_format($item['subtotal'], 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="divider"></div>

    <div class="row"><span>Subtotal</span><span>Rp <?= number_format($trx['subtotal'], 0, ',', '.') ?></span></div>
    <?php if (!empty($trx['diskon']) && $trx['diskon'] > 0): ?>
    <div class="row"><span>Diskon <?= $trx['promo_code'] ? '(' . esc($trx['promo_code']) . ')' : '' ?></span><span>- Rp <?= number_format($trx['diskon'], 0, ',', '.') ?></span></div>
    <?php endif; ?>
    <div class="row total-row"><span>TOTAL</span><span>Rp <?= number_format($trx['total'], 0, ',', '.') ?></span></div>

    <div class="divider"></div>

    <div class="row"><span>Bayar</span><span>Rp <?= number_format($trx['bayar'], 0, ',', '.') ?></span></div>
    <div class="row"><span>Kembalian</span><span>Rp <?= number_format($trx['kembalian'], 0, ',', '.') ?></span></div>

    <?php if (!empty($trx['catatan'])): ?>
    <div class="divider"></div>
    <div>Catatan: <?= esc($trx['catatan']) ?></div>
    <?php endif; ?>

    <div class="divider"></div>
    <div class="footer">Terima kasih telah berkunjung!<br>Selamat menikmati.</div>

    <button class="btn-print" onclick="window.print()">Cetak Struk</button>
</div>
</body>
</html>