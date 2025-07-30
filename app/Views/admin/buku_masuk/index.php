<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb fw-semibold fs-5 text-white">
        <li class="breadcrumb-item">
            <a href="<?= base_url('/buku_masuk') ?>" class="text-white text-decoration-none">Data Buku Masuk</a>
        </li>
        <!-- <li class="breadcrumb-item active text-white" aria-current="page">Update</li> -->
    </ol>
</nav>

<?= view('components/notification'); ?>

<div class="card shadow">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <p class="fw-semibold text-dark fs-4 col-6">Data Buku</p>
            <?php if (session()->get('user_role') == 'admin') { ?>
                <a href="<?= base_url('buku_masuk/create') ?>" class="btn btn-primary fw-semibold col-lg-2 col-4">Tambah</a>
            <?php } ?>
        </div>

        <div class="table-responsive no-wrap  rounded">
            <table class="table table-hover shadow-sm" id="dataTable">
                <thead class="bg-primary rounded">
                    <tr>
                        <th class="text-white" width="5%">No</th>
                        <th class=" text-white">Sampul</th>
                        <th class=" text-white">Judul</th>
                        <th class=" text-white">Kode</th>
                        <th class=" text-white">Masuk</th>
                        <th class=" text-white">Tanggal</th>
                        <th class=" text-white">Dari</th>
                        <th class=" text-white">Ket.</th>
                        <?php if (session()->get('user_role') == 'admin') { ?>
                            <th class="text-white" width="15%">Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    foreach ($bukuMasuks as $data): ?>
                        <tr class="text-dark">
                            <td class="text-center"><?= $no++ ?></td>
                            <td>
                                <img src="<?= base_url('images/buku/' . $data->sampul) ?>" alt="" class="img-thumbnail" width="100">
                            </td>
                            <td><?= esc($data->kode_buku) ?></td>
                            <td><?= esc($data->judul) ?></td>
                            <td class="text-center"><?= esc($data->jumlah_masuk) ?></td>
                            <td><?= formatTanggalIndo($data->tanggal_masuk) ?></td>
                            <td><?= esc($data->diperoleh_dari) ?></td>
                            <td><?= esc($data->keterangan ?? "-") ?></td>
                            <?php if (session()->get('user_role') == 'admin') { ?>
                                <td>
                                    <div class=" d-flex gap-1">
                                        <a href="<?= base_url('buku_masuk/edit/' . $data->id) ?>" class="btn btn-info btn-sm">
                                            <i class="bx bx-pencil" style="font-size: 1rem"></i>
                                        </a>
                                        <form action="<?= base_url('buku_masuk/' . $data->id) ?>" method="POST" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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