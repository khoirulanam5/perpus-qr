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
?>

<?= $this->section('content') ?>


<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb fw-semibold fs-5 text-white">
        <li class="breadcrumb-item">
            <a href="<?= base_url('/peminjaman') ?>" class="text-white text-decoration-none">Data Denda</a>
        </li>
        <li class="breadcrumb-item active text-white" aria-current="page">Create</li>
    </ol>
</nav>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-semibold text-dark text-uppercase mb-0">Create Denda</h5>
            </div>
            <div>
                <a href="<?= base_url('peminjaman') ?>" class="btn btn-secondary">
                    <i class="bx bx-arrow-back"></i> Kembali
                </a>
            </div>
        </div>
        <form action="<?= base_url('denda') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" name="anggota_id" value="<?= $anggota->id ?>">
            <input type="hidden" name="peminjaman_id" value="<?= $peminjaman->id ?>">
            <!-- Notif -->
            <?= view('components/notification') ?>
            <h5 class="fw-semibold text-dark mb-2">Data Peminjaman</h5>
            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="anggota">Anggota <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="anggota" id="anggota"
                        class="form-control text-dark <?= session('errors.anggota') ? 'is-invalid' : '' ?>"
                        value="<?= old('anggota', "$anggota->kode_anggota | $anggota->nama") ?>"
                        placeholder="Masukkan Tanggal Pinjam " readonly>
                    <?php if (session('errors.anggota')) : ?>
                        <div class="invalid-feedback"><?= session('errors.anggota') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="tanggal_pinjam">Tanggal Pinjam<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                        class="form-control text-dark <?= session('errors.tanggal_pinjam') ? 'is-invalid' : '' ?>"
                        value="<?= old('tanggal_pinjam', $peminjaman->tanggal_pinjam) ?>"
                        placeholder="Masukkan Tanggal Pinjam " readonly>
                    <?php if (session('errors.tanggal_pinjam')) : ?>
                        <div class="invalid-feedback"><?= session('errors.tanggal_pinjam') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="tanggal_due">Tanggal Due<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="date" name="tanggal_due" id="tanggal_due"
                        class="form-control text-dark <?= session('errors.tanggal_due') ? 'is-invalid' : '' ?>"
                        value="<?= old('tanggal_due', $peminjaman->tanggal_due) ?>"
                        placeholder="Masukkan Tanggal Pinjam " readonly>
                    <?php if (session('errors.tanggal_due')) : ?>
                        <div class="invalid-feedback"><?= session('errors.tanggal_due') ?></div>
                    <?php endif ?>
                </div>
            </div>


            <div class="form-group row mb-3">
                <label for="status" class="col-sm-2 col-form-label text-dark" style="font-weight: 600; font-size: 14px" style="font-weight: 600">Status Bayar<span class="text-danger">*</span>
                </label>
                <div class="col-sm-10">
                    <select id="status" name="status"
                        class="select2 form-control text-dark <?= session('errors.status') ? 'is-invalid' : '' ?>"
                        required>
                        <option value="belum" <?= old('status') == "belum" ? 'selected' : ''; ?>>belum</option>
                        <option value="sudah" <?= old('status') == "sudah" ? 'selected' : ''; ?>>sudah</option>
                    </select>
                    <?php if (session('errors.status')) : ?>
                        <div class="invalid-feedback"><?= session('errors.status') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="tanggal_denda">Tanggal Denda<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="date" name="tanggal_denda" id="tanggal_denda"
                        class="form-control text-dark <?= session('errors.tanggal_denda') ? 'is-invalid' : '' ?>"
                        value="<?= old('tanggal_denda', date('Y-m-d')) ?>"
                        placeholder="Masukkan Tanggal Pinjam " required>
                    <?php if (session('errors.tanggal_denda')) : ?>
                        <div class="invalid-feedback"><?= session('errors.tanggal_denda') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="keterangan">Keterangan<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="keterangan" id="keterangan"
                        class="form-control text-dark <?= session('errors.keterangan') ? 'is-invalid' : '' ?>"
                        value="<?= old('keterangan') ?>"
                        placeholder="Masukkan keterangan " required>
                    <?php if (session('errors.keterangan')) : ?>
                        <div class="invalid-feedback"><?= session('errors.keterangan') ?></div>
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
                            <th class="text-white">No</th>
                            <th class=" text-white">Sampul</th>
                            <th class=" text-white">Judul</th>
                            <th class=" text-white">Kode</th>
                            <th class=" text-white">Penerbit</th>
                            <th class=" text-white">Terbit</th>
                            <th class=" text-white">Telat/Hari</th>
                            <th class=" text-white">Denda Telat</th>
                            <th class=" text-white">Denda Hilang</th>
                            <th class="text-white">Tipe Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($detailWithBuku as $data): ?>
                            <?php
                            // MAKSIMAL TELAT BELUM DI IMPLEMENT
                            $selisihHari = hitungSelisihHari($peminjaman->tanggal_due) - $pengaturanDenda->maksimal_telat;
                            $selisihHari = $selisihHari > 0 ? $selisihHari : 0;
                            $aturanDenda = $pengaturanDenda->denda_per_hari * ($pengaturanDenda->tipe_telat == 'Per Buku' ? $data['count'] : 1);
                            $denda = $selisihHari * $aturanDenda;
                            ?>
                            <tr class="text-dark">
                                <td class="text-center"><?= $no++ ?></td>
                                <td>
                                    <img src="<?= base_url('images/buku/' . $data['buku']->sampul) ?>" alt="" class="img-thumbnail" width="100">
                                </td>
                                <td><?= esc($data['buku']->judul) ?></td>
                                <td><?= esc($data['buku']->kode_buku) ?></td>
                                <td><?= esc($data['buku']->penerbit) ?></td>
                                <td class="text-center"><?= esc($data['buku']->tahun_terbit) ?></td>
                                <td>
                                    <span class="badge bg-<?= $selisihHari > 0 ? 'danger' : 'success'; ?> text-white">
                                        <div><?= $selisihHari ?> Hari</div>
                                    </span>
                                </td>
                                <td>
                                    <input
                                        type="number"
                                        name="denda_telat_[<?= $data['buku']->id ?>]"
                                        class="form-control form-control-sm text-end border-secondary text-dark"
                                        min="0"
                                        style="width: 100px"
                                        value="<?= $denda / $data['count'] ?? '' ?>">
                                </td>
                                <td class="text-center">
                                    <input
                                        type="number"
                                        name="denda_hilang_[<?= $data['buku']->id ?>]"
                                        style="width: 100px"
                                        class="form-control form-control-sm text-end border-secondary text-dark"
                                        min="0">
                                </td>
                                <td>
                                    <select name="jenis_[<?= $data['buku']->id ?>]" id="jenis_[<?= $data['buku']->id ?>]" class="form-control form-control-sm border-secondary text-dark">
                                        <option value="telat">Telat</option>
                                        <option value="hilang">Hilang</option>
                                        <option value="tepat">Tepat</option>
                                    </select>
                                </td>
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