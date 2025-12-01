<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb fw-semibold fs-5 text-white">
        <li class="breadcrumb-item">
            <a href="<?= base_url('/user') ?>" class="text-white text-decoration-none">Data User</a>
        </li>
        <!-- <li class="breadcrumb-item active text-white" aria-current="page">Update</li> -->
    </ol>
</nav>

<?= view('components/notification'); ?>

<div class="card shadow">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <p class="fw-semibold text-dark fs-4 col-6">Data User</p>
            <?php if (session()->get('user_role') == 'pustakawan') { ?>
                <a href="<?= base_url('user/create') ?>" class="btn btn-primary fw-semibold col-lg-2 col-4">Tambah</a>
            <?php } ?>
        </div>

        <div class="table-responsive text-nowrap rounded">
            <table class="table table-hover shadow-sm" id="dataTable">
                <thead class="bg-primary rounded">
                    <tr>
                        <th class="text-white" width="5%">No</th>
                        <th class="text-white">Nama</th>


                        <!-- kolom dibawah contoh crud tambah nomor telepon -->
                        <!-- <th class="text-white">Telepon</th> -->


                        <th class=" text-white">Username</th>
                        <th class=" text-white">Role</th>
                        <th class=" text-white">Aktif</th>
                        <?php if (session()->get('user_role') == 'pustakawan') { ?>
                            <th class="text-white" width="15%">Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($users as $data): ?>
                        <tr class="text-dark">
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($data->nama) ?></td>


                            <!-- kolom dibawah contoh crud tambah nomor telepon -->
                            <!-- <td><?= esc($data->no_hp) ?></td> -->


                            <td><?= esc($data->username) ?></td>
                            <td><?= esc($data->role) ?></td>
                            <td>
                                <?php
                                $status = $data->aktif;
                                $badgeClass = match ($status) {
                                    '1'     => 'success',
                                    '0'   => 'warning',
                                    default     => 'dark',
                                };
                                ?>
                                <span class="badge bg-<?= $badgeClass ?>"><?= ucfirst($status == 1 ? 'Aktif' : 'Tidak Aktif') ?></span>
                            </td>
                            <?php if (session()->get('user_role') == 'pustakawan') { ?>
                                <td class="d-flex gap-1">
                                    <a href="<?= base_url('user/edit/' . $data->id) ?>" class="btn btn-info btn-sm">
                                        <i class="bx bx-pencil" style="font-size: 1rem"></i>
                                    </a>
                                    <form action="<?= base_url('user/' . $data->id) ?>" method="POST" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class=" bx bx-trash" style="font-size: 1rem"></i>
                                        </button>
                                    </form>
                                </td>
                            <?php } ?>
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