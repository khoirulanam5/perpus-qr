<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb fw-semibold fs-5 text-white">
        <li class="breadcrumb-item">
            <a href="<?= base_url('/buku_masuk') ?>" class="text-white text-decoration-none">Data Buku Masuk</a>
        </li>
        <li class="breadcrumb-item active text-white" aria-current="page">Create</li>
    </ol>
</nav>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-semibold text-dark text-uppercase mb-0">Create Buku Masuk</h5>
            </div>
            <div>
                <a href="<?= base_url('buku_masuk') ?>" class="btn btn-secondary">
                    <i class="bx bx-arrow-back"></i> Kembali
                </a>
            </div>
        </div>
        <form action="<?= base_url('buku_masuk') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="POST">
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
                            <option value="<?= $buku->id ?>" <?= old('buku_id') == $buku->id ? 'selected' : ''; ?>><?= esc($buku->kode_buku . ' | ' . $buku->judul) ?></option>
                        <?php endforeach ?>
                    </select>
                    <?php if (session('errors.buku_id')) : ?>
                        <div class="invalid-feedback"><?= session('errors.buku_id') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="jumlah_masuk">Jumlah Stok Masuk <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="number" name="jumlah_masuk" id="jumlah_masuk"
                        class="form-control text-dark <?= session('errors.jumlah_masuk') ? 'is-invalid' : '' ?>"
                        value="<?= old('jumlah_masuk') ?>"
                        placeholder="Masukkan stok buku baru " required>
                    <?php if (session('errors.jumlah_masuk')) : ?>
                        <div class="invalid-feedback"><?= session('errors.jumlah_masuk') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="tanggal_masuk">Tanggal Masuk Buku <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                        class="form-control text-dark <?= session('errors.tanggal_masuk') ? 'is-invalid' : '' ?>"
                        value="<?= old('tanggal_masuk') ?>"
                        placeholder="Masukkan tanggal masuk buku " required>
                    <?php if (session('errors.tanggal_masuk')) : ?>
                        <div class="invalid-feedback"><?= session('errors.tanggal_masuk') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="diperoleh_dari">Diperoleh Dari <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="diperoleh_dari" id="diperoleh_dari"
                        class="form-control text-dark <?= session('errors.diperoleh_dari') ? 'is-invalid' : '' ?>"
                        value="<?= old('diperoleh_dari') ?>"
                        placeholder="Buku diperoleh dari siapa " required>
                    <?php if (session('errors.diperoleh_dari')) : ?>
                        <div class="invalid-feedback"><?= session('errors.diperoleh_dari') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="keterangan">Keterangan </label>
                <div class="col-sm-10">
                    <input type="text" name="keterangan" id="keterangan"
                        class="form-control text-dark <?= session('errors.keterangan') ? 'is-invalid' : '' ?>"
                        value="<?= old('keterangan') ?>"
                        placeholder="Masukkan tanggal masuk buku ">
                    <?php if (session('errors.keterangan')) : ?>
                        <div class="invalid-feedback"><?= session('errors.keterangan') ?></div>
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