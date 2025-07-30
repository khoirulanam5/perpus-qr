<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb fw-semibold fs-5 text-white">
        <li class="breadcrumb-item">
            <a href="<?= base_url('/presensi') ?>" class="text-white text-decoration-none">Data Presensi</a>
        </li>
        <!-- <li class="breadcrumb-item active text-white" aria-current="page">Update</li> -->
    </ol>
</nav>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span class="fw-semibold" style="color: #be1c00 !important">
            <?= session()->getFlashdata('error') ?>
        </span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span class="fw-semibold" style="color: #276e00 !important">
            <?= session()->getFlashdata('success') ?>
        </span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>


<div class="card shadow">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">
            <p class="fw-semibold text-dark fs-4 col-6">Data Presensi</p>
        </div>

        <?php if (session()->get('user_role') == 'admin') { ?>
            <div class="mb-4">
                <form method="POST" action="<?= base_url('presensi') ?>" class="row g-2 align-items-end">
                    <?= csrf_field(); ?>
                    <div class="col-md-8">
                        <!-- <label for="start" class="form-label">Tanggal Awal</label> -->
                        <input type="text" name="kode_anggota" id="kode_anggota"
                            class="form-control text-dark <?= session('errors.kode_anggota') ? 'is-invalid' : '' ?>"
                            value="<?= old('kode_anggota') ?>"
                            placeholder="Masukkan kode anggota" required>
                        <?php if (session('errors.kode_anggota')) : ?>
                            <div class="invalid-feedback"><?= session('errors.kode_anggota') ?></div>
                        <?php endif ?>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="bx bx-check-circle"></i> Presensi</button>

                    </div>
                    <div class="col-md-1 d-flex gap-2">
                        <a href="<?= base_url('presensi') ?>" class="btn btn-secondary"><i class="bx bx-reset"></i> Reset</a>
                    </div>
                </form>
            </div>
        <?php } ?>
        <div class="table-responsive text-nowrap rounded">
            <table class="table table-hover shadow-sm" id="dataTable">
                <thead class="bg-primary rounded">
                    <tr>
                        <th class="text-white" width="5%">No</th>
                        <th class="text-white" width="15%">Kode</th>
                        <th class="text-white" width="15%">Nama Anggota</th>
                        <th class="text-white" width="40%">Tanggal</th>
                        <th class="text-white" width="40%">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($presensis as $data): ?>
                        <tr class="text-dark">
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($data->kode_anggota) ?></td>
                            <td><?= esc($data->nama) ?></td>
                            <td><?= esc($data->tanggal) ?></td>
                            <td><?= esc($data->waktu) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?= $this->endSection() ?>
<?= $this->section('scripts'); ?>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            pageLength: 25,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            columnDefs: [{
                targets: -1,
                orderable: false
            }]
        });
    });
</script>
<?= $this->endSection() ?>