<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm mb-4">
    <div class="card-header text-dark d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark">Laporan Buku Masuk</h5>
    </div>

    <div class="card-body">
        <!-- Filter -->
        <form method="GET" action="<?= base_url('report/buku_masuk') ?>" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label for="start" class="form-label">Tanggal Awal</label>
                <input type="date" id="start" name="start" value="<?= esc($start ?? '') ?>" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="end" class="form-label">Tanggal Akhir</label>
                <input type="date" id="end" name="end" value="<?= esc($end ?? '') ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary"><i class="bx bx-filter"></i> Filter</button>
                <a href="<?= base_url('laporan/buku_masuk') ?>" class="btn btn-secondary"><i class="bx bx-reset"></i> Reset</a>
                <a href="<?= base_url('report/buku_masuk/export?start=' . ($start ?? '') . '&end=' . ($end ?? '')) ?>" target="_blank" class="btn btn-danger">
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
                        <th>Jumlah Masuk</th>
                        <th>Tanggal Masuk</th>
                        <th>Diperoleh Dari</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bukuMasuks)) : $no = 1; ?>
                        <?php foreach ($bukuMasuks as $data) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($data->kode_buku) ?></td>
                                <td><?= esc($data->judul) ?></td>
                                <td><?= esc($data->jumlah_masuk) ?></td>
                                <td><?= formatTanggalIndo($data->tanggal_masuk) ?></td>
                                <td><?= esc($data->diperoleh_dari) ?></td>
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