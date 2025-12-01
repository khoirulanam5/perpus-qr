<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<?php

use CodeIgniter\I18n\Time;

function hitungSelisihHari(string $tanggalDue, string $tanggalDenda): int
{
    $dueDate = Time::parse($tanggalDue);
    $dendaDate = Time::parse($tanggalDenda);

    // Jika denda dibuat sebelum tanggal jatuh tempo, maka tidak telat
    if ($dendaDate->isBefore($dueDate)) {
        return 0;
    }

    // Hitung selisih hari (positif)
    return $dueDate->difference($dendaDate)->getDays();
}

?>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb fw-semibold fs-5 text-white">
        <li class="breadcrumb-item">
            <a href="<?= base_url('/peminjaman') ?>" class="text-white text-decoration-none">Data Denda</a>
        </li>
        <!-- <li class="breadcrumb-item active text-white" aria-current="page">Update</li> -->
    </ol>
</nav>

<?= view('components/notification'); ?>

<div class="card shadow">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <p class="fw-semibold text-dark fs-4 col-6">Data Denda</p>
            <!-- <a href="<?= base_url('peminjaman/create') ?>" class="btn btn-primary fw-semibold col-lg-2 col-4">Tambah</a> -->
        </div>

        <div class="table-responsive rounded">
            <table class="table table-hover shadow-sm" id="dataTable">
                <thead class="bg-primary rounded">
                    <tr>
                        <th class="text-white" width="5%">No</th>
                        <th class="text-white">Kode Anggota</th>
                        <th class="text-white">Nama Anggota</th>
                        <th class="text-white">Petugas</th>
                        <th class="text-white">Buku</th>
                        <th class="text-white">Tgl Pinjam</th>
                        <th class="text-white">Tgl Jatuh Tempo</th>
                        <th class="text-white">Tgl Kembali</th>
                        <th class="text-white">Denda</th>
                        <th class="text-white">Status Bayar</th>
                        <?php if (session()->get('user_role') == 'pustakawan') { ?>
                            <th class="text-white" width="10%">Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    foreach ($dendas as $data): ?>
                        <tr class="text-dark">
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($data->kode_anggota ?? '-') ?></td>
                            <td><?= esc($data->anggota_nama) ?></td>
                            <td><?= esc($data->user_nama) ?></td>
                            <td><?= esc($data->buku_dipinjam) ?></td>
                            <td><?= formatTanggalIndo($data->tanggal_pinjam) ?></td>
                            <td><?= formatTanggalIndo($data->tanggal_due) ?></td>
                            <td>
                                <?= $data->tanggal_kembali ? formatTanggalIndo($data->tanggal_kembali) : '<span class="badge bg-warning">Belum</span>' ?>
                            </td>
                            <td>
                                <?php
                                $selisihHari = hitungSelisihHari($data->tanggal_due, $data->tanggal_denda) - $pengaturanDenda->maksimal_telat;
                                $selisihHari = $selisihHari > 0 ? $selisihHari : 0;
                                ?>
                                <span class='badge bg-danger text-white'>
                                    <div><?= number_format($data->total_denda, 0, ',', '.') ?></div>
                                </span>
                                <br>
                                <span class="badge bg-<?= $selisihHari > 0 ? 'danger' : 'success' ?> text-white">
                                    <?= $selisihHari ?> Hari
                                </span>
                            </td>
                            <td>
                                <?php
                                $badgeClass = match ($data->status) {
                                    'dipinjam'     => 'primary',
                                    'dikembalikan' => 'success',
                                    'terlambat'    => 'danger',
                                    default        => 'secondary',
                                };
                                ?>
                                <span class="badge bg-<?= $badgeClass ?>"><?= ucfirst($data->status) ?></span>
                            </td>
                            <?php if (session()->get('user_role') == 'pustakawan') { ?>
                                <td>
                                    <div class="d-block">
                                        <div class="d-flex gap-1">
                                            <form action="<?= base_url('denda/' . $data->id) ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?');">
                                                    <i class="bx bx-trash" style="font-size: 1rem"></i>
                                                </button>
                                            </form>
                                        </div>
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