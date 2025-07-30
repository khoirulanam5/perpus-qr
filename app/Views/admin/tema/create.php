<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb fw-semibold fs-5 text-white">
        <li class="breadcrumb-item">
            <a href="<?= base_url('/tema') ?>" class="text-white text-decoration-none">Data Tema</a>
        </li>
        <li class="breadcrumb-item active text-white" aria-current="page">Create</li>
    </ol>
</nav>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-semibold text-dark text-uppercase mb-0">Create Tema</h5>
            </div>
            <div>
                <a href="<?= base_url('tema') ?>" class="btn btn-secondary">
                    <i class="bx bx-arrow-back"></i> Kembali
                </a>
            </div>
        </div>
        <form action="<?= base_url('tema') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="POST">
            <!-- Notif -->
            <?= view('components/notification') ?>
            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="nama">Tema <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="nama" id="nama"
                        class="form-control text-dark <?= session('errors.nama') ? 'is-invalid' : '' ?>"
                        value="<?= old('nama') ?>"
                        placeholder="Masukkan tema buku " required autofocus>
                    <?php if (session('errors.nama')) : ?>
                        <div class="invalid-feedback"><?= session('errors.nama') ?></div>
                    <?php endif ?>
                </div>
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