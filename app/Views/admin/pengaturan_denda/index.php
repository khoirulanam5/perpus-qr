<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb fw-semibold fs-5 text-white">
        <li class="breadcrumb-item">
            <a href="<?= base_url('/perpustakaan') ?>" class="text-white text-decoration-none">Pengaturan Denda</a>
        </li>
        <!-- <li class="breadcrumb-item active text-white" aria-current="page">Update</li> -->
    </ol>
</nav>

<?= view('components/notification') ?>


<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center ">
            <p class=" fw-semibold text-dark  col-6 text-uppercase">Edit Pengaturan Denda</p>
        </div>
        <form action="<?= base_url('pengaturan-denda/' . $pengaturanDenda->id) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <!-- Notif -->
            <!-- Nama -->
            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="denda_per_hari">Denda Per Hari (Rp) <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="number" name="denda_per_hari" id="denda_per_hari" <?= session()->get('user_role') == 'pustakawan' ? '' : ('disabled'); ?>
                        class="form-control text-dark <?= session('errors.denda_per_hari') ? 'is-invalid' : '' ?>"
                        value="<?= old('denda_per_hari', $pengaturanDenda->denda_per_hari) ?>"
                        placeholder="Masukkan nominal denda per hari" required autofocus>
                    <?php if (session('errors.denda_per_hari')) : ?>
                        <div class="invalid-feedback"><?= session('errors.denda_per_hari') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="denda_buku_hilang">Denda Buku Hilang (RP) <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="number" name="denda_buku_hilang" id="denda_buku_hilang" <?= session()->get('user_role') == 'pustakawan' ? '' : ('disabled'); ?>
                        class="form-control text-dark <?= session('errors.denda_buku_hilang') ? 'is-invalid' : '' ?>"
                        value="<?= old('denda_buku_hilang', $pengaturanDenda->denda_buku_hilang) ?>"
                        placeholder="Masukkan nominal denda buku hilang" required>
                    <?php if (session('errors.denda_buku_hilang')) : ?>
                        <div class="invalid-feedback"><?= session('errors.denda_buku_hilang') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="maksimal_telat">Maksimal Telat (Hari) <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="number" name="maksimal_telat" id="maksimal_telat" <?= session()->get('user_role') == 'pustakawan' ? '' : ('disabled'); ?>
                        class="form-control text-dark <?= session('errors.maksimal_telat') ? 'is-invalid' : '' ?>"
                        value="<?= old('maksimal_telat', $pengaturanDenda->maksimal_telat) ?>"
                        placeholder="Masukkan maksimal telat" required>
                    <?php if (session('errors.maksimal_telat')) : ?>
                        <div class="invalid-feedback"><?= session('errors.maksimal_telat') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="tipe_telat" class="col-sm-2 col-form-label text-dark" style="font-weight: 600; font-size: 14px">
                    Tipe Denda Telat <span class="text-danger">*</span>
                </label>
                <div class="col-sm-10">
                    <select id="tipe_telat" name="tipe_telat" <?= session()->get('user_role') == 'pustakawan' ? '' : ('disabled'); ?>
                        class="select2  form-control text-dark <?= session('errors.tipe_telat') ? 'is-invalid' : '' ?>"
                        required>
                        <option value="Per Buku" <?= old('tipe_telat', $pengaturanDenda->tipe_telat) == 'Per Buku'  ? 'selected' : ''; ?>>Per Buku</option>
                        <option value="Semua Buku" <?= old('tipe_telat', $pengaturanDenda->tipe_telat) ==  'Semua Buku' ? 'selected' : ''; ?>>Semua Buku</option>
                    </select>
                    <?php if (session('errors.tipe_telat')) : ?>
                        <div class="invalid-feedback"><?= session('errors.tipe_telat') ?></div>
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


<?= $this->section('scripts'); ?>
<script>
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Select an option',
    });
</script>
<?= $this->endSection() ?>