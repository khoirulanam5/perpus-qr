<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb fw-semibold fs-5 text-white">
        <li class="breadcrumb-item">
            <a href="<?= base_url('/user') ?>" class="text-white text-decoration-none">Data User</a>
        </li>
        <li class="breadcrumb-item active text-white" aria-current="page">Create</li>
    </ol>
</nav>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-semibold text-dark text-uppercase mb-0">Create User</h5>
            </div>
            <div>
                <a href="<?= base_url('user') ?>" class="btn btn-secondary">
                    <i class="bx bx-arrow-back"></i> Kembali
                </a>
            </div>
        </div>
        <form action="<?= base_url('user') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="POST">
            <!-- Notif -->
            <?= view('components/notification') ?>
            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="nama">Nama <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="nama" id="nama"
                        class="form-control text-dark <?= session('errors.nama') ? 'is-invalid' : '' ?>"
                        value="<?= old('nama') ?>"
                        placeholder="Masukkan nama " required autofocus>
                    <?php if (session('errors.nama')) : ?>
                        <div class="invalid-feedback"><?= session('errors.nama') ?></div>
                    <?php endif ?>
                </div>
            </div>


            <!-- kolom dibawah contoh crud tambah nomor telepon -->
            <!-- <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="no_hp">Telepon <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="no_hp" id="no_hp"
                        class="form-control text-dark <?= session('errors.no_hp') ? 'is-invalid' : '' ?>"
                        value="<?= old('no_hp') ?>"
                        placeholder="Masukkan nomor telepon " required autofocus>
                    <?php if (session('errors.no_hp')) : ?>
                        <div class="invalid-feedback"><?= session('errors.no_hp') ?></div>
                    <?php endif ?>
                </div>
            </div> -->


            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="username">Username <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="username" id="username"
                        class="form-control text-dark <?= session('errors.username') ? 'is-invalid' : '' ?>"
                        value="<?= old('username') ?>"
                        placeholder="Masukkan username (unique) " required>
                    <?php if (session('errors.username')) : ?>
                        <div class="invalid-feedback"><?= session('errors.username') ?></div>
                    <?php endif ?>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="password">Password <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="password" name="password" id="password"
                        class="form-control text-dark <?= session('errors.password') ? 'is-invalid' : '' ?>"
                        value="<?= old('password') ?>"
                        placeholder="Masukkan password " required>
                    <?php if (session('errors.password')) : ?>
                        <div class="invalid-feedback"><?= session('errors.password') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="aktif" class="col-sm-2 col-form-label text-dark" style="font-weight: 600; font-size: 14px" style="font-weight: 600">
                    Status <span class="text-danger">*</span>
                </label>
                <div class="col-sm-10">
                    <select id="aktif" name="aktif"
                        class="select2 form-control text-dark <?= session('errors.aktif') ? 'is-invalid' : '' ?>"
                        required>
                        <option value="">Pilih Status</option>
                        <option value="1" <?= old('aktif') == "1" ? 'selected' : ''; ?>>Aktif</option>
                        <option value="0" <?= old('aktif') == "0" ? 'selected' : ''; ?>>Tidak Aktif</option>
                    </select>
                    <?php if (session('errors.aktif')) : ?>
                        <div class="invalid-feedback"><?= session('errors.aktif') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="role" class="col-sm-2 col-form-label text-dark" style="font-weight: 600; font-size: 14px" style="font-weight: 600">
                    Role <span class="text-danger">*</span>
                </label>
                <div class="col-sm-10">
                    <select id="role" name="role"
                        class="select2 form-control text-dark <?= session('errors.role') ? 'is-invalid' : '' ?>"
                        required>
                        <option value="">Pilih Status</option>
                        <option value="kepala" <?= old('role') == "kepala" ? 'selected' : ''; ?>>Kepala</option>
                        <option value="pustakawan" <?= old('role') == "admin" ? 'selected' : ''; ?>>Pustakawan</option>
                    </select>
                    <?php if (session('errors.role')) : ?>
                        <div class="invalid-feedback"><?= session('errors.role') ?></div>
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

<?= $this->section('scripts'); ?>
<script>
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Select an option',
    });
</script>
<?= $this->endSection() ?>