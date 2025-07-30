<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb fw-semibold fs-5 text-white">
        <li class="breadcrumb-item">
            <a href="<?= base_url('/peminjaman') ?>" class="text-white text-decoration-none">Data Peminjaman</a>
        </li>
        <li class="breadcrumb-item active text-white" aria-current="page">Create</li>
    </ol>
</nav>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-semibold text-dark text-uppercase mb-0">Create Peminjaman</h5>
            </div>
            <div>
                <a href="<?= base_url('peminjaman') ?>" class="btn btn-secondary">
                    <i class="bx bx-arrow-back"></i> Kembali
                </a>
            </div>
        </div>
        <form action="<?= base_url('peminjaman') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="POST">
            <!-- Notif -->
            <?= view('components/notification') ?>

            <div class="form-group row mb-3">
                <label for="anggota_id" class="col-sm-2 col-form-label text-dark" style="font-weight: 600; font-size: 14px" style="font-weight: 600">Anggota <span class="text-danger">*</span>
                </label>
                <div class="col-sm-10">
                    <select id="anggota_id" name="anggota_id"
                        class="select2 form-control text-dark <?= session('errors.anggota_id') ? 'is-invalid' : '' ?>"
                        required autofocus>
                        <option value="">Pilih Anggota</option>
                        <?php foreach ($anggotas as $anggota) : ?>
                            <option value="<?= $anggota->id; ?>" <?= old('anggota_id') == $anggota->id ? 'selected' : ''; ?>><?= $anggota->kode_anggota . ' | ' . $anggota->nama; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (session('errors.anggota_id')) : ?>
                        <div class="invalid-feedback"><?= session('errors.anggota_id') ?></div>
                    <?php endif ?>
                </div>
            </div>


            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="tanggal_pinjam">Tanggal Pinjam<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                        class="form-control text-dark <?= session('errors.tanggal_pinjam') ? 'is-invalid' : '' ?>"
                        value="<?= old('tanggal_pinjam') ?>"
                        placeholder="Masukkan Tanggal Pinjam " required>
                    <?php if (session('errors.tanggal_pinjam')) : ?>
                        <div class="invalid-feedback"><?= session('errors.tanggal_pinjam') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="tanggal_due">Tanggal Kembali<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="date" name="tanggal_due" id="tanggal_due"
                        class="form-control text-dark <?= session('errors.tanggal_due') ? 'is-invalid' : '' ?>"
                        value="<?= old('tanggal_due') ?>"
                        placeholder="Masukkan Tanggal Pinjam " required>
                    <?php if (session('errors.tanggal_due')) : ?>
                        <div class="invalid-feedback"><?= session('errors.tanggal_due') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="status" class="col-sm-2 col-form-label text-dark" style="font-weight: 600; font-size: 14px" style="font-weight: 600">Status <span class="text-danger">*</span>
                </label>
                <div class="col-sm-10">
                    <select id="status" name="status"
                        class="select2 form-control text-dark <?= session('errors.status') ? 'is-invalid' : '' ?>"
                        required autofocus>
                        <option value="">Pilih Status</option>
                        <option value="dipinjam" <?= old('status') == "dipinjam" ? 'selected' : ''; ?>>Dipinjam</option>
                        <option value="dikembalikan" <?= old('status') == "dikembalikan" ? 'selected' : ''; ?>>Dikembalikan</option>
                        <option value="terlambat" <?= old('status') == "terlambat" ? 'selected' : ''; ?>>terlambat</option>
                    </select>
                    <?php if (session('errors.status')) : ?>
                        <div class="invalid-feedback"><?= session('errors.status') ?></div>
                    <?php endif ?>
                </div>
            </div>
            <hr>
            <div>
                <h5 class="fw-semibold text-dark text-uppercase ">Pilih Buku</h5>
            </div>
            <div class="table-responsive  rounded">
                <table class="table table-hover shadow-sm" id="dataTable">
                    <thead class="bg-primary rounded">
                        <tr>
                            <th class="text-white">#</th>
                            <th class="text-white">No</th>
                            <th class=" text-white">Sampul</th>
                            <th class=" text-white">Judul</th>
                            <th class=" text-white">Kode</th>
                            <th class=" text-white">Tema</th>
                            <th class=" text-white">Rak</th>
                            <th class=" text-white">Penulis</th>
                            <th class=" text-white">Terbit</th>
                            <th class=" text-white">Halaman</th>
                            <th class=" text-white">Stok</th>
                            <th class=" text-white">Dipinjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($bukus as $data): ?>
                            <tr class="text-dark">
                                <td class="text-center checkbox-col">
                                    <input type="checkbox" name="buku[]" value="<?= $data->id ?>" class="form-check-input border-secondary">
                                </td>
                                <td class="text-center"><?= $no++ ?></td>
                                <td>
                                    <img src="<?= base_url('images/buku/' . $data->sampul) ?>" alt="" class="img-thumbnail" width="100">
                                </td>
                                <td><?= esc($data->judul) ?></td>
                                <td><?= esc($data->kode_buku) ?></td>
                                <td><?= esc($data->tema_nama) ?></td>
                                <td><?= esc($data->nama_rak) ?></td>
                                <td><?= esc($data->penerbit) ?></td>
                                <td class="text-center"><?= esc($data->tahun_terbit) ?></td>
                                <td class="text-center"><?= esc($data->total_halaman) ?></td>
                                <td class="text-center"><?= esc($data->stok) ?></td>
                                <td class="text-center"><?= esc($data->stok_pinjam) ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <!-- Tombol -->
            <div class="d-flex mt-4 gap-2">
                <button type="submit" class="btn btn-primary fw-bold" style="width: 25%">Create</button>
                <button type="reset" class="btn btn-outline-secondary text-dark">Reset</button>
            </div>
        </form>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts'); ?>
<script>
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Select an option',
    });
    $.fn.dataTable.ext.order['dom-checkbox'] = function(settings, col) {
        return this.api().column(col, {
            order: 'index'
        }).nodes().map(function(td, i) {
            return $('input[type="checkbox"]', td).prop('checked') ? 1 : 0;
        });
    };

    $('#dataTable').DataTable({

        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        columnDefs: [{
            targets: 0,
            orderDataType: 'dom-checkbox' // kolom 0 (checkbox)
        }],
        initComplete: function() {
            $('.dataTables_filter input').css({
                'width': '300px',
                'display': 'inline-block',
            });
        }
    });
</script>
<?= $this->endSection() ?>