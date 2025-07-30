<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .info {
            margin-top: 10px;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <h2><?= esc($title) ?></h2>
    <?php if ($start && $end): ?>
        <h4>Periode: <?= date('d-m-Y', strtotime($start)) ?> s/d <?= date('d-m-Y', strtotime($end)) ?></h4>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Buku</th>
                <th>Judul</th>
                <th>Jumlah Masuk</th>
                <th>Tanggal Masuk</th>
                <th>Diperoleh Dari</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($bukuMasuks)): $no = 1; ?>
                <?php foreach ($bukuMasuks as $data): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($data->kode_buku) ?></td>
                        <td><?= esc($data->judul) ?></td>
                        <td><?= esc($data->jumlah_masuk) ?></td>
                        <td><?= date('d-m-Y', strtotime($data->tanggal_masuk)) ?></td>
                        <td><?= esc($data->diperoleh_dari) ?></td>
                        <td><?= esc($data->keterangan ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">Tidak ada data ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="info">
        Dicetak pada: <?= date('d-m-Y H:i') ?>
    </div>

</body>

</html>