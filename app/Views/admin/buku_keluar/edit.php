<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb fw-semibold fs-5 text-white">
        <li class="breadcrumb-item">
            <a href="<?= base_url('/buku_keluar') ?>" class="text-white text-decoration-none">Data Buku Keluar</a>
        </li>
        <li class="breadcrumb-item active text-white" aria-current="page">Edit</li>
    </ol>
</nav>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-semibold text-dark text-uppercase mb-0">Edit Buku Keluar</h5>
            </div>
            <div>
                <a href="<?= base_url('buku_keluar') ?>" class="btn btn-secondary">
                    <i class="bx bx-arrow-back"></i> Kembali
                </a>
            </div>
        </div>
        <form action="<?= base_url('buku_keluar/' . $bukuKeluar->id) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <!-- Notif -->
            <?= view('components/notification') ?>

            <div class="form-group row mb-3">
                <label for="buku_id" class="col-sm-2 col-form-label text-dark" style="font-weight: 600; font-size: 14px" style="font-weight: 600">
                    Buku <span class="text-danger">*</span>
                </label>
                <div class="col-sm-10">
                    <select id="buku_id" name="buku_id"
                        class="select2 form-control text-dark <?= session('errors.buku_id') ? 'is-invalid' : '' ?>"
                        required autofocus>
                        <option value="">Pilih Buku</option>
                        <?php foreach ($bukus as $buku) : ?>
                            <option value="<?= $buku->id ?>" <?= old('buku_id', $bukuKeluar->buku_id) == $buku->id ? 'selected' : ''; ?>><?= esc($buku->kode_buku . ' | ' . $buku->judul) ?></option>
                        <?php endforeach ?>
                    </select>
                    <?php if (session('errors.buku_id')) : ?>
                        <div class="invalid-feedback"><?= session('errors.buku_id') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="jumlah_keluar">Jumlah Stok Keluar <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="number" name="jumlah_keluar" id="jumlah_keluar"
                        class="form-control text-dark <?= session('errors.jumlah_keluar') ? 'is-invalid' : '' ?>"
                        value="<?= old('jumlah_keluar', $bukuKeluar->jumlah_keluar) ?>"
                        placeholder="stok buku keluar " required>
                    <?php if (session('errors.jumlah_keluar')) : ?>
                        <div class="invalid-feedback"><?= session('errors.jumlah_keluar') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="tanggal_keluar">Tanggal Keluar Buku <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="date" name="tanggal_keluar" id="tanggal_keluar"
                        class="form-control text-dark <?= session('errors.tanggal_keluar') ? 'is-invalid' : '' ?>"
                        value="<?= old('tanggal_keluar', $bukuKeluar->tanggal_keluar) ?>"
                        placeholder="tanggal buku keluar " required>
                    <?php if (session('errors.tanggal_keluar')) : ?>
                        <div class="invalid-feedback"><?= session('errors.tanggal_keluar') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="jenis_keluar" class="col-sm-2 col-form-label text-dark" style="font-weight: 600; font-size: 14px" style="font-weight: 600">
                    Buku <span class="text-danger">*</span>
                </label>
                <div class="col-sm-10">
                    <select id="jenis_keluar" name="jenis_keluar"
                        class="select2 form-control text-dark <?= session('errors.jenis_keluar') ? 'is-invalid' : '' ?>"
                        required autofocus>
                        <option value="">Pilih Jenis Keluar</option>
                        <option value="hilang" <?= old('jenis_keluar', $bukuKeluar->jenis_keluar) == 'hilang' ? 'selected' : ''; ?>>Hilang</option>
                        <option value="rusak" <?= old('jenis_keluar', $bukuKeluar->jenis_keluar) == 'rusak' ? 'selected' : ''; ?>>Rusak</option>
                        <option value="donasi" <?= old('jenis_keluar', $bukuKeluar->jenis_keluar) == 'donasi' ? 'selected' : ''; ?>>Donasi</option>
                        <option value="musnahkan" <?= old('jenis_keluar', $bukuKeluar->jenis_keluar) == 'musnahkan' ? 'selected' : ''; ?>>Musnahkan</option>
                    </select>
                    <?php if (session('errors.jenis_keluar')) : ?>
                        <div class="invalid-feedback"><?= session('errors.jenis_keluar') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="keterangan">Keterangan </label>
                <div class="col-sm-10">
                    <input type="text" name="keterangan" id="keterangan"
                        class="form-control text-dark <?= session('errors.keterangan') ? 'is-invalid' : '' ?>"
                        value="<?= old('keterangan', $bukuKeluar->keterangan) ?>"
                        placeholder="keterangan ">
                    <?php if (session('errors.keterangan')) : ?>
                        <div class="invalid-feedback"><?= session('errors.keterangan') ?></div>
                    <?php endif ?>
                </div>
            </div>


            <!-- Tombol -->
            <div class="d-flex mt-4 gap-2">
                <button type="submit" class="btn btn-primary fw-bold" style="width: 25%">Update</button>
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