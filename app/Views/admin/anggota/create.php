<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb fw-semibold fs-5 text-white">
        <li class="breadcrumb-item">
            <a href="<?= base_url('/anggota') ?>" class="text-white text-decoration-none">Data Anggota</a>
        </li>
        <li class="breadcrumb-item active text-white" aria-current="page">Create</li>
    </ol>
</nav>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-semibold text-dark text-uppercase mb-0">Create Anggota</h5>
            </div>
            <div>
                <a href="<?= base_url('anggota') ?>" class="btn btn-secondary">
                    <i class="bx bx-arrow-back"></i> Kembali
                </a>
            </div>
        </div>
        <form action="<?= base_url('anggota') ?>" method="POST" enctype="multipart/form-data">
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
                        placeholder="Masukkan nama anggota baru " required>
                    <?php if (session('errors.nama')) : ?>
                        <div class="invalid-feedback"><?= session('errors.nama') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="telepon">telepon</label>
                <div class="col-sm-10">
                    <input type="tel" name="telepon" id="telepon"
                        class="form-control text-dark <?= session('errors.telepon') ? 'is-invalid' : '' ?>"
                        value="<?= old('telepon') ?>"
                        placeholder="Masukkan telepon anggota baru ">
                    <?php if (session('errors.telepon')) : ?>
                        <div class="invalid-feedback"><?= session('errors.telepon') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="alamat">Alamat <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="alamat" id="alamat"
                        class="form-control text-dark <?= session('errors.alamat') ? 'is-invalid' : '' ?>"
                        value="<?= old('alamat') ?>"
                        placeholder="Masukkan alamat anggota baru " required>
                    <?php if (session('errors.alamat')) : ?>
                        <div class="invalid-feedback"><?= session('errors.alamat') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="tanggal_daftar">Tanggal Daftar<span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="date" name="tanggal_daftar" id="tanggal_daftar"
                        class="form-control text-dark <?= session('errors.tanggal_daftar') ? 'is-invalid' : '' ?>"
                        value="<?= old('tanggal_daftar') ?>"
                        placeholder="Masukkan tanggal masuk buku " required>
                    <?php if (session('errors.tanggal_daftar')) : ?>
                        <div class="invalid-feedback"><?= session('errors.tanggal_daftar') ?></div>
                    <?php endif ?>
                </div>
            </div>


            <div class="form-group row mb-3">
                <label for="jenis_kelamin" class="col-sm-2 col-form-label text-dark" style="font-weight: 600; font-size: 14px" style="font-weight: 600">
                    Jenis Kelamin <span class="text-danger">*</span>
                </label>
                <div class="col-sm-10">
                    <select id="jenis_kelamin" name="jenis_kelamin"
                        class="select2 form-control text-dark <?= session('errors.jenis_kelamin') ? 'is-invalid' : '' ?>"
                        required autofocus>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" <?= old('jenis_kelamin') == "L" ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="P" <?= old('jenis_kelamin') == "P" ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                    <?php if (session('errors.jenis_kelamin')) : ?>
                        <div class="invalid-feedback"><?= session('errors.jenis_kelamin') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="status" class="col-sm-2 col-form-label text-dark" style="font-weight: 600; font-size: 14px" style="font-weight: 600">
                    Status <span class="text-danger">*</span>
                </label>
                <div class="col-sm-10">
                    <select id="status" name="status"
                        class="select2 form-control text-dark <?= session('errors.status') ? 'is-invalid' : '' ?>"
                        required autofocus>
                        <option value="">Pilih Status</option>
                        <option value="aktif" <?= old('status') == "aktif" ? 'selected' : ''; ?>>aktif</option>
                        <option value="suspend" <?= old('status') == "suspend" ? 'selected' : ''; ?>>suspend</option>
                        <option value="nonaktif" <?= old('status') == "nonaktif" ? 'selected' : ''; ?>>nonaktif</option>
                    </select>
                    <?php if (session('errors.status')) : ?>
                        <div class="invalid-feedback"><?= session('errors.status') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="foto">Foto</label>
                <div class="col-sm-10">
                    <input type="file" name="foto" id="foto" accept="image/*"
                        class="form-control text-dark <?= session('errors.foto') ? 'is-invalid' : '' ?>"
                        onchange="previewfoto(this)">
                    <?php if (session('errors.foto')) : ?>
                        <div class="invalid-feedback"><?= session('errors.foto') ?></div>
                    <?php endif ?>

                    <div class="mt-2">
                        <img id="foto-preview" src="#" alt="Preview foto" class="img-fluid rounded shadow-sm d-none" width="150">
                    </div>
                </div>
            </div>

            <script>
                function previewfoto(input) {
                    const preview = document.getElementById('foto-preview');
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.classList.remove('d-none');
                            preview.src = e.target.result;
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>
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