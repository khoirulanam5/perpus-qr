<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm mb-4">
    <div class="card-header text-dark d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark">Laporan Buku Keluar</h5>
    </div>

    <div class="card-body">
        <!-- Filter -->
        <form method="GET" action="<?= base_url('report/buku_keluar') ?>" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label for="start" class="form-label">Tanggal Awal</label>
                <input type="date" id="start" name="start" value="<?= esc($start ?? '') ?>" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="end" class="form-label">Tanggal Akhir</label>
                <input type="date" id="end" name="end" value="<?= esc(data: $end ?? '') ?>" class="form-control">
            </div>
            <div class="col-md-2">
                <label for="jenis_keluar" class="form-label">Jenis Keluar</label>
                <select id="jenis_keluar" name="jenis_keluar" class="form-control">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="hilang" <?= $jenis_keluar == 'hilang' ? 'selected' : ''; ?>>Hilang</option>
                    <option value="rusak" <?= $jenis_keluar == 'rusak' ? 'selected' : ''; ?>>Rusak</option>
                    <option value="donasi" <?= $jenis_keluar == 'donasi' ? 'selected' : ''; ?>>Donasi</option>
                    <option value="musnahkan" <?= $jenis_keluar == 'musnahkan' ? 'selected' : ''; ?>>Musnahkan</option>
                </select>

            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary"><i class="bx bx-filter"></i> Filter</button>
                <a href="<?= base_url('report/buku_keluar') ?>" class="btn btn-secondary"><i class="bx bx-reset"></i> Reset</a>
                <a href="<?= base_url('report/buku_keluar/export?start=' . ($start ?? '') . '&end=' . ($end ?? '') . '&jenis_keluar=' . ($jenis_keluar ?? '')) ?>" target="_blank" class="btn btn-danger">
                    <i class="bx bx-download"></i> Export PDF
                </a>
            </div>

        </form>

        <!-- Table -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped" id="laporanTable">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Jumlah Keluar</th>
                        <th>Tanggal Keluar</th>
                        <th>Jenis</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bukuKeluars)) : $no = 1; ?>
                        <?php foreach ($bukuKeluars as $data) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($data->kode_buku) ?></td>
                                <td><?= esc($data->judul) ?></td>
                                <td><?= esc($data->jumlah_keluar) ?></td>
                                <td><?= formatTanggalIndo($data->tanggal_keluar) ?></td>
                                <td><?= esc($data->jenis_keluar) ?></td>
                                <td><?= esc($data->keterangan ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>