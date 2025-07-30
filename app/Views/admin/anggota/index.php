<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb fw-semibold fs-5 text-white">
        <li class="breadcrumb-item">
            <a href="<?= base_url('/anggota') ?>" class="text-white text-decoration-none">Data Anggota Masuk</a>
        </li>
        <!-- <li class="breadcrumb-item active text-white" aria-current="page">Update</li> -->
    </ol>
</nav>

<?= view('components/notification'); ?>

<div class="card shadow">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <p class="fw-semibold text-dark fs-4 col-6">Data Anggota</p>
            <?php if (session()->get('user_role') == 'admin') { ?>
                <a href="<?= base_url('anggota/create') ?>" class="btn btn-primary fw-semibold col-lg-2 col-4">Tambah</a>
            <?php } ?>
        </div>

        <div class="table-responsive  rounded">
            <table class="table table-hover shadow-sm" id="dataTable">
                <thead class="bg-primary rounded">
                    <tr>
                        <th class="text-white" width="5%">No</th>
                        <th class=" text-white">Foto</th>
                        <th class=" text-white">Kode</th>
                        <th class=" text-white">Nama</th>
                        <th class=" text-white">JK</th>
                        <th class=" text-white">Alamat</th>
                        <th class=" text-white">Status</th>
                        <th class=" text-white">Tgl Daftar</th>
                        <?php if (session()->get('user_role') == 'admin') { ?>
                            <th class="text-white" width="15%">Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    foreach ($anggotas as $data): ?>
                        <tr class="text-dark">
                            <td class="text-center"><?= $no++ ?></td>
                            <td>
                                <img src="<?= base_url('images/anggota/' . ($data->foto != null ? $data->foto : 'default.png')) ?>" alt="" class="img-thumbnail" width="100">
                            </td>
                            <td><?= esc($data->kode_anggota) ?></td>
                            <td><?= esc($data->nama) ?></td>
                            <td><?= esc($data->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') ?></td>
                            <td><?= esc($data->alamat) ?></td>
                            <td>
                                <?php
                                $status = $data->status;
                                $badgeClass = match ($status) {
                                    'aktif'     => 'success',
                                    'nonaktif'  => 'secondary',
                                    'suspend'   => 'warning',
                                    default     => 'dark',
                                };
                                ?>
                                <span class="badge bg-<?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                            </td>
                            <td><?= formatTanggalIndo($data->tanggal_daftar) ?></td>
                            <?php if (session()->get('user_role') == 'admin') { ?>
                                <td>
                                    <div class=" d-flex gap-1">
                                        <a href="<?= base_url('anggota/edit/' . $data->id) ?>" class="btn btn-info btn-sm">
                                            <i class="bx bx-pencil" style="font-size: 1rem"></i>
                                        </a>
                                        <form action="<?= base_url('anggota/' . $data->id) ?>" method="POST" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class=" bx bx-trash" style="font-size: 1rem"></i>
                                            </button>
                                        </form>
                                    </div>
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