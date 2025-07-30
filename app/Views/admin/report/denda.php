<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>
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
<div class="card shadow-sm mb-4">
    <div class="card-header text-dark d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark">Laporan Denda</h5>
    </div>

    <div class="card-body">
        <!-- Filter -->
        <form method="GET" action="<?= base_url('report/denda') ?>" class="row g-2 align-items-end">
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
                <select name="anggota_id" id="anggota_id" class="form-control">
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
                <select name="status" id="status" class="form-control">
                    <option value="">-- Semua --</option>
                    <option value="bayar" <?= ($status ?? '') == 'bayar' ? 'selected' : '' ?>>bayar</option>
                    <option value="belum" <?= ($status ?? '') == 'belum' ? 'selected' : '' ?>>belum</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-filter"></i> Filter
                    </button>
                </div>
                <div>
                    <a href="<?= base_url('report/denda') ?>" class="btn btn-secondary"><i class="bx bx-reset"></i> Reset</a>
                </div>
                <div>
                    <a href="<?= base_url('report/denda/export?start=' . ($start ?? '') . '&end=' . ($end ?? '') . '&anggota_id=' . ($anggota_id ?? '') . '&status=' . ($status ?? '')) ?>" target="_blank" class="btn btn-danger">
                        <i class="bx bx-download"></i> Export PDF
                    </a>
                </div>
            </div>
        </form>

        <!-- Table -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead class="table-primary rounded">
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode Anggota</th>
                        <th>Nama Anggota</th>
                        <th>Petugas</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Jatuh Tempo</th>
                        <th>Tgl Kembali</th>
                        <th>Denda</th>
                        <th>Status Bayar</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    foreach ($dendas as $data): ?>
                        <tr class="text-dark">
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($data->kode_anggota ?? '-') ?></td>
                            <td><?= esc($data->anggota_nama) ?></td>
                            <td><?= esc($data->user_nama) ?></td>
                            <td><?= esc($data->buku_dipinjam) ?></td>
                            <td><?= formatTanggalIndo($data->tanggal_pinjam) ?></td>
                            <td><?= formatTanggalIndo($data->tanggal_due) ?></td>
                            <td>
                                <?= $data->tanggal_kembali ? formatTanggalIndo($data->tanggal_kembali) : '<span class="badge bg-warning">Belum</span>' ?>
                            </td>
                            <td>
                                <?php
                                $selisihHari = hitungSelisihHari($data->tanggal_due, $data->tanggal_denda) - $pengaturanDenda->maksimal_telat;
                                $selisihHari = $selisihHari > 0 ? $selisihHari : 0;
                                ?>
                                <span class='badge bg-danger text-white'>
                                    Rp <?= number_format($data->total_denda, 0, ',', '.') ?>
                                </span>
                                <br>
                                <span class="badge bg-<?= $selisihHari > 0 ? 'danger' : 'success' ?> text-white">
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
                    <?php if (empty($dendas)): ?>
                        <tr>
                            <td colspan="10" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>