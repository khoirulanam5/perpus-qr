<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('content') ?>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb fw-semibold fs-5 text-white">
        <li class="breadcrumb-item">
            <a href="<?= base_url('/buku') ?>" class="text-white text-decoration-none">Data Buku</a>
        </li>
        <!-- <li class="breadcrumb-item active text-white" aria-current="page">Update</li> -->
    </ol>
</nav>

<?= view('components/notification'); ?>

<div class="card shadow">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <p class="fw-semibold text-dark fs-4 col-6">Data Buku</p>
            <?php if (session()->get('user_role') == 'pustakawan') { ?>
                <a href="<?= base_url('buku/create') ?>" class="btn btn-primary fw-semibold col-lg-2 col-4">Tambah</a>
            <?php } ?>
        </div>

        <div class="table-responsive  rounded">
            <table class="table table-hover shadow-sm" id="dataTable">
                <thead class="bg-primary rounded">
                    <tr>
                        <th class="text-white" width="5%">No</th>
                        <th class=" text-white text-center">QR</th>
                        <th class=" text-white">Sampul</th>
                        <th class=" text-white">Judul</th>
                        <th class=" text-white">Kode</th>
                        <th class=" text-white">Tema</th>
                        <th class=" text-white">Rak</th>
                        <th class=" text-white">Penulis</th>
                        <th class=" text-white">Terbit</th>
                        <th class=" text-white">Halaman</th>
                        <th class=" text-white">Stok</th>
                        <th class=" text-white">Dipinjam</th>
                        <?php if (session()->get('user_role') == 'pustakawan') { ?>
                            <th class="text-white" width="15%">Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    foreach ($bukus as $data): ?>
                        <tr class="text-dark">
                            <td class="text-center"><?= $no++ ?></td>
                            <?php
                            // Contoh data (bisa diganti dengan data asli dari DB)

                            // Generate URL QR code
                            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=" . urlencode($data->kode_buku);
                            ?>

                            <!-- Thumbnail QR kecil yang membuka modal -->
                            <td>
                                <img src="<?= $qrUrl ?>" alt="QR buku"
                                    width="70"
                                    style="cursor:pointer;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#qrModal<?= $data->id; ?>">
                            </td>

                            <!-- Modal QR -->
                            <div class="modal fade" id="qrModal<?= $data->id; ?>" tabindex="-1" aria-labelledby="qrModalLabel<?= $data->id; ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content text-center">
                                        <div class="modal-header position-relative">
                                            <h5 class="modal-title w-100 text-center" id="qrModalLabel<?= $data->id; ?>">QR Kode Buku</h5>
                                            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- QR Besar -->
                                            <img src="<?= $qrUrl ?>" alt="QR besar" class="img-fluid mb-3" width="300"
                                                id="qrImage<?= $data->id ?>">
                                            <!-- Kode Buku -->
                                            <p class="fw-bold"><?= htmlspecialchars($data->kode_buku); ?></p>

                                            <!-- Tombol Download -->
                                            <button class="btn btn-primary"
                                                onclick="downloadQR(
                                                    'qrImage<?= $data->id ?>',
                                                    'qr_<?= preg_replace('/[^a-zA-Z0-9_-]/', '', $data->kode_buku) ?>.png',
                                                    '<?= addslashes($data->kode_buku) ?>'
                                                    )">
                                                Download QR
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <td>
                                <img src="<?= base_url('images/buku/' . $data->sampul) ?>" alt="" class="img-thumbnail" width="100">
                            </td>
                            <td><?= esc($data->judul) ?></td>
                            <td><?= esc($data->kode_buku) ?></td>
                            <td><?= esc($data->tema_nama) ?></td>
                            <td><?= esc($data->nama_rak) ?></td>
                            <td><?= esc($data->penerbit) ?></td>
                            <td class="text-center"><?= esc($data->tahun_terbit) ?></td>
                            <td class="text-center"><?= esc($data->total_halaman) ?></td>
                            <td class="text-center"><?= esc($data->stok) ?></td>
                            <td class="text-center"><?= esc($data->stok_pinjam) ?></td>
                            <?php if (session()->get('user_role') == 'pustakawan') { ?>
                                <td>
                                    <div class=" d-flex gap-1">
                                        <a href="<?= base_url('buku/edit/' . $data->id) ?>" class="btn btn-info btn-sm">
                                            <i class="bx bx-pencil" style="font-size: 1rem"></i>
                                        </a>
                                        <form action="<?= base_url('buku/' . $data->id) ?>" method="POST" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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


<!-- JavaScript untuk download QR -->
<script>
    function downloadQR(imageId, fileName, kodeBuku) {
        const img = document.getElementById(imageId);
        if (!img) {
            alert("Gambar QR tidak ditemukan.");
            return;
        }

        const canvas = document.createElement("canvas");
        const ctx = canvas.getContext("2d");
        const qrImage = new Image();

        qrImage.crossOrigin = "anonymous";

        qrImage.onload = function() {
            const padding = 20; // jarak antara QR dan teks
            const fontSize = 24;

            canvas.width = qrImage.width;
            canvas.height = qrImage.height + padding + fontSize + 10; // tambah ruang buat teks

            // Gambar QR
            ctx.drawImage(qrImage, 0, 0);

            // Set style teks
            ctx.font = `${fontSize}px Arial`;
            ctx.fillStyle = "black";
            ctx.textAlign = "center";

            // Gambar teks di bawah QR
            ctx.fillText(kodeBuku, canvas.width / 2, qrImage.height + padding + fontSize / 1.5);

            // Download
            const dataURL = canvas.toDataURL("image/png");
            const a = document.createElement("a");
            a.href = dataURL;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        };

        qrImage.onerror = function() {
            alert("Gagal memuat gambar QR untuk download.");
        };

        qrImage.src = img.src;
    }
</script>

<?= $this->endSection() ?>