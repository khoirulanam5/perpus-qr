<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb fw-semibold fs-5 text-white">
        <li class="breadcrumb-item">
            <a href="<?= base_url('/buku') ?>" class="text-white text-decoration-none">Data Buku</a>
        </li>
        <li class="breadcrumb-item active text-white" aria-current="page">Edit</li>
    </ol>
</nav>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-semibold text-dark text-uppercase mb-0">Edit Buku</h5>
            </div>
            <div>
                <a href="<?= base_url('buku') ?>" class="btn btn-secondary">
                    <i class="bx bx-arrow-back"></i> Kembali
                </a>
            </div>
        </div>
        <form action="<?= base_url('buku/' . $buku->id) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="kode_buku" value="<?= $buku->kode_buku ?>">

            <!-- Notif -->
            <?= view('components/notification') ?>
            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="judul">Judul <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="judul" id="judul"
                        class="form-control text-dark <?= session('errors.judul') ? 'is-invalid' : '' ?>"
                        value="<?= old('judul', $buku->judul) ?>"
                        placeholder="Masukkan tema judul buku " required autofocus>
                    <?php if (session('errors.judul')) : ?>
                        <div class="invalid-feedback"><?= session('errors.judul') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="penulis">Penulis <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="penulis" id="penulis"
                        class="form-control text-dark <?= session('errors.penulis') ? 'is-invalid' : '' ?>"
                        value="<?= old('penulis', $buku->penulis) ?>"
                        placeholder="Masukkan penulis buku " required>
                    <?php if (session('errors.penulis')) : ?>
                        <div class="invalid-feedback"><?= session('errors.penulis') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="penerbit">Penerbit <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="penerbit" id="penerbit"
                        class="form-control text-dark <?= session('errors.penerbit') ? 'is-invalid' : '' ?>"
                        value="<?= old('penerbit', $buku->penerbit) ?>"
                        placeholder="Masukkan penerbit buku " required>
                    <?php if (session('errors.penerbit')) : ?>
                        <div class="invalid-feedback"><?= session('errors.penerbit') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="tahun_terbit">Tahun Terbit <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="number" name="tahun_terbit" id="tahun_terbit"
                        class="form-control text-dark <?= session('errors.tahun_terbit') ? 'is-invalid' : '' ?>"
                        value="<?= old('tahun_terbit', $buku->tahun_terbit) ?>"
                        placeholder="Masukkan tahun terbit buku " required>
                    <?php if (session('errors.tahun_terbit')) : ?>
                        <div class="invalid-feedback"><?= session('errors.tahun_terbit') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="isbn">ISBN <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" name="isbn" id="isbn"
                        class="form-control text-dark <?= session('errors.isbn') ? 'is-invalid' : '' ?>"
                        value="<?= old('isbn', $buku->isbn) ?>"
                        placeholder="Masukkan tahun terbit buku " required>
                    <?php if (session('errors.isbn')) : ?>
                        <div class="invalid-feedback"><?= session('errors.isbn') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="total_halaman">Total Halaman <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="number" name="total_halaman" id="total_halaman"
                        class="form-control text-dark <?= session('errors.total_halaman') ? 'is-invalid' : '' ?>"
                        value="<?= old('total_halaman', $buku->total_halaman) ?>"
                        placeholder="Masukkan total halaman buku " required>
                    <?php if (session('errors.total_halaman')) : ?>
                        <div class="invalid-feedback"><?= session('errors.total_halaman') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="stok">Stok <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="number" name="stok" id="stok"
                        class="form-control text-dark <?= session('errors.stok') ? 'is-invalid' : '' ?>"
                        value="<?= old('stok', $buku->stok) ?>"
                        placeholder="Masukkan stok buku " required>
                    <?php if (session('errors.stok')) : ?>
                        <div class="invalid-feedback"><?= session('errors.stok') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="stok_pinjam">Stok Dipinjam <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="number" name="stok_pinjam" id="stok_pinjam"
                        class="form-control text-dark <?= session('errors.stok_pinjam') ? 'is-invalid' : '' ?>"
                        value="<?= old('stok_pinjam', $buku->stok_pinjam) ?>"
                        placeholder="Masukkan stok buku yang dipinjam " required>
                    <?php if (session('errors.stok_pinjam')) : ?>
                        <div class="invalid-feedback"><?= session('errors.stok_pinjam') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="rak_id" class="col-sm-2 col-form-label text-dark" style="font-weight: 600; font-size: 14px" style="font-weight: 600"> Rak <span class="text-danger">*</span>
                </label>
                <div class="col-sm-10">
                    <select id="rak_id" name="rak_id"
                        class="select2 form-control text-dark <?= session('errors.rak_id') ? 'is-invalid' : '' ?>"
                        required>
                        <option value="">Pilih Rak</option>
                        <?php foreach ($raks as $r) : ?>
                            <option value="<?= $r->id ?>" <?= old('rak_id', $buku->rak_id) == $r->id ? 'selected' : ''; ?>><?= esc($r->kode_rak . ' | ' . $r->nama_rak) ?></option>
                        <?php endforeach ?>
                    </select>
                    <?php if (session('errors.rak_id')) : ?>
                        <div class="invalid-feedback"><?= session('errors.stok_pinjam') ?></div>
                    <?php endif ?>
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="tema_id" class="col-sm-2 col-form-label text-dark" style="font-weight: 600; font-size: 14px">
                    Tema <span class="text-danger">*</span>
                </label>
                <?php
                $selectedTemaIds = array_map(fn($item) => $item->tema_id, $bookTema);
                ?>

                <div class="col-sm-10">
                    <select id="tema_id" name="tema_id[]"
                        class="select2 js-example-basic-multiple form-control text-dark <?= session('errors.tema_id') ? 'is-invalid' : '' ?>"
                        multiple="multiple" required>
                        <?php foreach ($temas as $t) : ?>
                            <option value="<?= $t->id ?>"
                                <?= in_array($t->id, old('tema_id') ?? $selectedTemaIds ?? []) ? 'selected' : '' ?>>
                                <?= esc($t->nama) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <?php if (session('errors.tema_id')) : ?>
                        <div class="invalid-feedback"><?= session('errors.tema_id') ?></div>
                    <?php endif ?>
                </div>

            </div>

            <div class="form-group row mb-3">
                <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
                    style="font-weight: 600; font-size: 14px" for="sampul">Sampul <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="file" name="sampul" id="sampul" accept="image/*"
                        class="form-control text-dark <?= session('errors.sampul') ? 'is-invalid' : '' ?>"
                        onchange="previewSampul(this)">
                    <?php if (session('errors.sampul')) : ?>
                        <div class="invalid-feedback"><?= session('errors.sampul') ?></div>
                    <?php endif ?>

                    <div class="mt-2">
                        <img id="sampul-preview" src="<?= base_url('images/buku/' . $buku->sampul); ?>" alt="Preview Sampul" class="img-fluid rounded shadow-sm" width="150">
                    </div>
                </div>
            </div>

            <script>
                function previewSampul(input) {
                    const preview = document.getElementById('sampul-preview');
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>

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