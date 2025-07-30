<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Laporan Denda' ?></title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .info {
            margin-top: 10px;
            font-size: 12px;
        }
    </style>
</head>
<?php

use CodeIgniter\I18n\Time;

function hitungSelisihHari(string $tanggalDue, string $tanggalDenda): int
{
    $dueDate = Time::parse($tanggalDue);
    $dendaDate = Time::parse($tanggalDenda);

    // Jika denda dibuat sebelum tanggal jatuh tempo, maka tidak telat
    if ($dendaDate->isBefore($dueDate)) {
        return 0;
    }

    // Hitung selisih hari (positif)
    return $dueDate->difference($dendaDate)->getDays();
}
?>

<body>

    <h2 style="text-align: center;"><?= $title ?></h2>

    <?php if ($start || $end): ?>
        <p style="text-align: center;">Periode: <?= formatTanggalIndo($start) ?> s/d <?= formatTanggalIndo($end) ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Anggota</th>
                <th>Nama Anggota</th>
                <th>Petugas</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Jatuh Tempo</th>
                <th>Tgl Kembali</th>
                <th>Denda</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($dendas)): $no = 1; ?>
                <?php foreach ($dendas as $data): ?>
                    <?php
                    $selisihHari = hitungSelisihHari($data->tanggal_due, $data->tanggal_denda) - $pengaturanDenda->maksimal_telat;
                    $selisihHari = max(0, $selisihHari);
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($data->kode_anggota) ?></td>
                        <td><?= esc($data->anggota_nama) ?></td>
                        <td><?= esc($data->user_nama) ?></td>
                        <td style="text-align: left;"><?= esc($data->buku_dipinjam) ?></td>
                        <td><?= formatTanggalIndo($data->tanggal_pinjam) ?></td>
                        <td><?= formatTanggalIndo($data->tanggal_due) ?></td>
                        <td><?= $data->tanggal_kembali ? formatTanggalIndo($data->tanggal_kembali) : 'Belum Kembali' ?></td>
                        <td>
                            Rp <?= number_format($data->total_denda, 0, ',', '.') ?><br>
                            (<?= $selisihHari ?> Hari)
                        </td>
                        <td><?= ucfirst($data->status) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">Data tidak ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="info">
        Dicetak pada: <?= date('d-m-Y H:i') ?>
    </div>

</body>

</html>