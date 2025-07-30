<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
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
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        .info {
            margin-top: 10px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center;">Laporan Peminjaman</h2>

    <p><strong>Periode:</strong> <?= $start ?? '-' ?> s.d <?= $end ?? '-' ?></p>
    <?php if ($anggota_id): ?>
        <p><strong>Anggota:</strong> <?= $peminjamans[0]->anggota_nama ?? '-' ?></p>
    <?php endif; ?>
    <?php if ($status): ?>
        <p><strong>Status:</strong> <?= ucfirst($status) ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Anggota</th>
                <th>Nama</th>
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
            <?php
            function formatTanggal($tgl)
            {
                return $tgl ? date('d/m/Y', strtotime($tgl)) : '-';
            }

            function estimasiDenda($data, $pengaturan)
            {
                $due = new \CodeIgniter\I18n\Time($data->tanggal_due);
                $now = $data->tanggal_kembali ? new \CodeIgniter\I18n\Time($data->tanggal_kembali) : \CodeIgniter\I18n\Time::now();
                $selisih = $now->difference($due)->getDays();

                $telat = max(0, $selisih - $pengaturan->maksimal_telat);
                $biaya = $pengaturan->denda_per_hari * ($pengaturan->tipe_telat === 'Per Buku' ? $data->jumlah_buku : 1);
                return $data->total_denda ?: ($telat * $biaya);
            }

            $no = 1;
            foreach ($peminjamans as $data): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $data->kode_anggota ?></td>
                    <td><?= $data->anggota_nama ?></td>
                    <td><?= $data->user_nama ?></td>
                    <td><?= $data->buku_dipinjam ?></td>
                    <td><?= formatTanggal($data->tanggal_pinjam) ?></td>
                    <td><?= formatTanggal($data->tanggal_due) ?></td>
                    <td><?= $data->tanggal_kembali ? formatTanggal($data->tanggal_kembali) : 'Belum' ?></td>
                    <td>Rp <?= number_format(estimasiDenda($data, $pengaturanDenda), 0, ',', '.') ?></td>
                    <td><?= ucfirst($data->status) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="info">
        Dicetak pada: <?= date('d-m-Y H:i') ?>
    </div>
</body>

</html>