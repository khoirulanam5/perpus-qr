<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb fw-semibold fs-5 text-white">
        <li class="breadcrumb-item">
            <a href="<?= base_url('/perpustakaan') ?>" class="text-white text-decoration-none">PERPUSTAKAAN</a>
        </li>
        <!-- <li class="breadcrumb-item active text-white" aria-current="page">Update</li> -->
    </ol>
</nav>

<?= view('components/notification') ?>


<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center ">
            <p class=" fw-semibold text-dark  col-6 text-uppercase">Edit Perpustakaan</p>
        </div>
        <form action="<?= base_url('perpustakaan/' . $perpustakaan->id) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <!-- Notif -->
            <!-- Nama -->
            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="nama">Nama <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="nama" id="nama" <?= session()->get('user_role') == 'pustakawan' ? '' : ('disabled'); ?>
                        class="form-control text-dark <?= session('errors.nama') ? 'is-invalid' : '' ?>"
                        value="<?= old('nama', $perpustakaan->nama) ?>"
                        placeholder="Masukkan nama perpustakaan" required autofocus>
                    <?php if (session('errors.nama')) : ?>
                        <div class="invalid-feedback"><?= session('errors.nama') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <!-- Alamat -->
            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="alamat">Alamat <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <textarea name="alamat" id="alamat" <?= session()->get('user_role') == 'pustakawan' ? '' : ('disabled'); ?>
                        class="form-control text-dark <?= session('errors.alamat') ? 'is-invalid' : '' ?>"
                        placeholder="Masukkan alamat"><?= old('alamat', $perpustakaan->alamat) ?></textarea>
                    <?php if (session('errors.alamat')) : ?>
                        <div class="invalid-feedback"><?= session('errors.alamat') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <!-- Kontak -->
            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="kontak">Kontak <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="kontak" id="kontak"
                        class="form-control text-dark <?= session('errors.kontak') ? 'is-invalid' : '' ?>"
                        value="<?= old('kontak', $perpustakaan->kontak) ?>"
                        placeholder="Masukkan kontak" <?= session()->get('user_role') == 'pustakawan' ? '' : ('disabled'); ?>>
                    <?php if (session('errors.kontak')) : ?>
                        <div class="invalid-feedback"><?= session('errors.kontak') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <!-- Kepala -->
            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="kepala">Kepala <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="kepala" id="kepala"
                        class="form-control text-dark <?= session('errors.kepala') ? 'is-invalid' : '' ?>"
                        value="<?= old('kepala', $perpustakaan->kepala) ?>"
                        placeholder="Masukkan nama kepala perpustakaan" <?= session()->get('user_role') == 'pustakawan' ? '' : ('disabled'); ?>>
                    <?php if (session('errors.kepala')) : ?>
                        <div class="invalid-feedback"><?= session('errors.kepala') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <!-- Tombol -->
            <div class="d-flex mt-4 gap-2">
                <button type="submit" class="btn btn-primary fw-bold" style="width: 25%" <?= session()->get('user_role') == 'pustakawan' ? '' : ('disabled'); ?>>Update</button>
                <button type="reset" class="btn btn-outline-secondary text-dark" <?= session()->get('user_role') == 'pustakawan' ? '' : ('disabled'); ?>>Reset</button>
            </div>
        </form>

    </div>
</div>

<?= $this->endSection() ?>