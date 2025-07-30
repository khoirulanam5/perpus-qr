<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-6 col-md-6 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <div class="bg-warning text-dark d-flex justify-content-center align-items-center rounded p-2"
                                        style="width: 40px; height: 40px;">
                                        <i class="bi bi-people-fill" style="font-size: 1rem;"></i>
                                    </div>
                                </div>

                            </div>
                            <span class="fw-semibold d-block mb-1">User</span>
                            <h3 class="card-title mb-2 text-dark"><?= $user; ?></h3>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <div class="bg-success text-white d-flex justify-content-center align-items-center rounded p-2"
                                        style="width: 40px; height: 40px;">
                                        <i class="bi bi-person-lines-fill" style="font-size: 1rem;"></i>
                                    </div>
                                </div>

                            </div>
                            <span class="fw-semibold d-block mb-1">Anggota</span>
                            <h3 class="card-title mb-2 text-dark"><?= $anggota; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <div class="bg-primary text-white d-flex justify-content-center align-items-center rounded p-2"
                                        style="width: 40px; height: 40px;">
                                        <i class=" bx bxs-book-add" style="font-size: 1rem;"></i>
                                    </div>
                                </div>

                            </div>
                            <span class="fw-semibold d-block mb-1">Buku</span>
                            <h3 class="card-title mb-2 text-dark">1</h3>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <div class="bg-info text-white d-flex justify-content-center align-items-center rounded p-2"
                                        style="width: 40px; height: 40px;">
                                        <i class="bx bx-transfer-alt" style="font-size: 1rem;"></i>
                                    </div>
                                </div>

                            </div>
                            <span class="fw-semibold d-block mb-1">Peminjaman</span>
                            <h3 class="card-title mb-2 text-dark"><?= $peminjaman; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<?= $this->endSection() ?>