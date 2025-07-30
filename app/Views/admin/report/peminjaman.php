<?= $this->extend('admin/layouts/main') ?>
<?php

use CodeIgniter\I18n\Time;

function hitungSelisihHari(string $tanggalDue): int
{
    // Parsing tanggal due dan sekarang
    $dueDate = Time::parse($tanggalDue);
    $now = Time::now();

    // Jika sekarang masih sebelum due, maka tidak telat
    if ($now->isBefore($dueDate)) {
        return 0;
    }

    // Hitung selisih hari
    return $now->difference($dueDate)->getDays() * -1;
}

function hitungSelisihHariDenda(string $tanggalDue, string $tanggalDenda): int
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
<?= $this->section('content') ?>


<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark"><?= $title ?></h5>
    </div>

    <div class="card-body">
        <!-- Filter -->
        <form method="GET" action="<?= base_url('report/peminjaman') ?>" class="row gy-2 gx-3 align-items-end mb-3">
            <div class="col-md-2">
                <label for="start" class="form-label">Tanggal Awal</label>
                <input type="date" id="start" name="start" value="<?= esc($start ?? '') ?>" class="form-control">
            </div>

            <div class="col-md-2">
                <label for="end" class="form-label">Tanggal Akhir</label>
                <input type="date" id="end" name="end" value="<?= esc($end ?? '') ?>" class="form-control">
            </div>

            <div class="col-md-2">
                <label for="anggota_id" class="form-label">Anggota</label>
                <select name="anggota_id" id="anggota_id" class="form-select">
                    <option value="">-- Semua Anggota --</option>
                    <?php foreach ($anggotaList as $anggota): ?>
                        <option value="<?= $anggota->id ?>" <?= ($anggota_id ?? '') == $anggota->id ? 'selected' : '' ?>>
                            <?= esc($anggota->nama) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">-- Semua --</option>
                    <option value="dipinjam" <?= ($status ?? '') == 'dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                    <option value="dikembalikan" <?= ($status ?? '') == 'dikembalikan' ? 'selected' : '' ?>>Dikembalikan</option>
                    <option value="terlambat" <?= ($status ?? '') == 'terlambat' ? 'selected' : '' ?>>Terlambat</option>
                </select>
            </div>

            <div class="col-md-4 d-flex gap-2">
                <div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-filter"></i> Filter
                    </button>
                </div>
                <a href="<?= base_url('report/peminjaman') ?>" class="btn btn-secondary"><i class="bx bx-reset"></i> Reset</a>

                <div>
                    <a href="<?= base_url('report/peminjaman/export?start=' . ($start ?? '') . '&end=' . ($end ?? '') . '&anggota_id=' . ($anggota_id ?? '') . '&status=' . ($status ?? '')) ?>" target="_blank" class="btn btn-danger w-100">
                        <i class="bx bx-download"></i> Export PDF
                    </a>
                </div>
            </div>
        </form>
        <div class="table-responsive rounded">
            <table class="table table-bordered table-hover table-sm">
                <thead class="table-primary text-white">
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
                    <?php $no = 1;
                    foreach ($peminjamans as $data): ?>
                        <?php
                        $selisihHari = !empty($data->tanggal_kembali)
                            ? hitungSelisihHariDenda($data->tanggal_due, $data->tanggal_kembali) - $pengaturanDenda->maksimal_telat
                            : hitungSelisihHari($data->tanggal_due) - $pengaturanDenda->maksimal_telat;

                        $selisihHari = max(0, $selisihHari);
                        $aturanDenda = $pengaturanDenda->denda_per_hari * ($pengaturanDenda->tipe_telat == 'Per Buku' ? $data->jumlah_buku : 1);
                        $estimasiDenda = $data->total_denda ?: ($selisihHari * $aturanDenda);
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($data->kode_anggota) ?></td>
                            <td><?= esc($data->anggota_nama) ?></td>
                            <td><?= esc($data->user_nama) ?></td>
                            <td><?= esc($data->buku_dipinjam) ?></td>
                            <td><?= formatTanggalIndo($data->tanggal_pinjam) ?></td>
                            <td><?= formatTanggalIndo($data->tanggal_due) ?></td>
                            <td><?= $data->tanggal_kembali ? formatTanggalIndo($data->tanggal_kembali) : '<span class="badge bg-warning">Belum</span>' ?></td>
                            <td>
                                Rp <?= number_format($estimasiDenda, 0, ',', '.') ?><br>
                                <span class="badge bg-<?= $selisihHari > 0 ? 'danger' : 'success' ?>">
                                    <?= $selisihHari ?> Hari
                                </span>
                            </td>
                            <td>
                                <?php
                                $badgeClass = match ($data->status) {
                                    'dipinjam'     => 'primary',
                                    'dikembalikan' => 'success',
                                    'terlambat'    => 'danger',
                                    default        => 'secondary',
                                };
                                ?>
                                <span class="badge bg-<?= $badgeClass ?>"><?= ucfirst($data->status) ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>