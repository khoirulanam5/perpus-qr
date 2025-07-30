<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Anggota;
use App\Models\BukuKeluar;
use App\Models\BukuMasuk;
use App\Models\Denda;
use App\Models\Peminjaman;
use App\Models\PengaturanDenda;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Dompdf\Dompdf;

class ReportController extends BaseController
{
    protected $bukuMasukModel;
    protected $bukuKeluarModel;
    protected $dendaModel;
    protected $anggotaModel;
    protected $pengaturanDendaModel;
    protected $peminjamanModel;

    public function __construct()
    {
        $this->bukuMasukModel = new BukuMasuk();
        $this->bukuKeluarModel = new BukuKeluar();
        $this->dendaModel = new Denda();
        $this->anggotaModel = new Anggota();
        $this->pengaturanDendaModel = new PengaturanDenda();
        $this->peminjamanModel = new Peminjaman();
    }

    public function bukuMasuk()
    {
        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');

        $bukuMasuks = $this->bukuMasukModel->getLaporan($start, $end);

        return view('admin\report\bukuMasuk', [
            'title' => 'Laporan Buku Masuk',
            'bukuMasuks' => $bukuMasuks,
            'start' => $start,
            'end' => $end
        ]);
    }

    public function exportBukuMasuk()
    {
        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');

        $bukuMasuks = $this->bukuMasukModel->getLaporan($start, $end);

        $data = [
            'bukuMasuks' => $bukuMasuks,
            'start' => $start,
            'end' => $end,
            'title' => 'Laporan Buku Masuk'
        ];

        $dompdf = new Dompdf();
        $html = view('admin\report\pdf_bukuMasuk', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan_buku_masuk.pdf', ['Attachment' => true]);
    }
    public function bukuKeluar()
    {
        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');
        $jenis_keluar = $this->request->getGet('jenis_keluar');

        $bukuKeluars = $this->bukuKeluarModel->getLaporan($start, $end, $jenis_keluar);

        return view('admin/report/bukuKeluar', [
            'title' => 'Laporan Buku Keluar',
            'bukuKeluars' => $bukuKeluars,
            'start' => $start,
            'end' => $end,
            'jenis_keluar' => $jenis_keluar
        ]);
    }


    public function exportBukuKeluar()
    {
        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');
        $jenis_keluar = $this->request->getGet('jenis_keluar');

        $bukuKeluars = $this->bukuKeluarModel->getLaporan($start, $end, $jenis_keluar);

        $data = [
            'bukuKeluars' => $bukuKeluars,
            'start' => $start,
            'end' => $end,
            'jenis_keluar' => $this->request->getGet('jenis_keluar'),
            'title' => 'Laporan Buku Keluar'
        ];
        // var_dump($data);

        $dompdf = new Dompdf();
        $html = view('admin/report/pdf_bukuKeluar', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan_buku_keluar.pdf', ['Attachment' => true]);
    }

    public function denda()
    {
        $anggota_id = $this->request->getGet('anggota_id');
        $status = $this->request->getGet('status');
        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');
        $pengaturanDenda = new PengaturanDenda();

        $pengaturanDenda = $pengaturanDenda->first();

        $dendas = $this->dendaModel->getFilteredDenda($anggota_id, $status, $start, $end);
        $anggotaList = $this->anggotaModel->findAll();

        return view('admin/report/denda', [
            'title' => 'Laporan Denda',
            'dendas' => $dendas,
            'anggotaList' => $anggotaList,
            'anggota_id' => $anggota_id,
            'status' => $status,
            'start' => $start,
            'end' => $end,
            'pengaturanDenda' => $pengaturanDenda
        ]);
    }

    public function exportDenda()
    {
        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');
        $anggota_id = $this->request->getGet('anggota_id');
        $status = $this->request->getGet('status');

        $dendas = $this->dendaModel->getFilteredDenda($start, $end, $anggota_id, $status);
        $pengaturanModel = new PengaturanDenda();
        $pengaturanDenda = $pengaturanModel->first();

        $data = [
            'title' => 'Laporan Denda',
            'dendas' => $dendas,
            'start' => $start,
            'end' => $end,
            'pengaturanDenda' => $pengaturanDenda,
        ];

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('admin/report/pdf_denda', $data));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan_denda.pdf', ['Attachment' => true]);
    }
    public function peminjaman()
    {
        $filters = [
            'start' => $this->request->getGet('start'),
            'end' => $this->request->getGet('end'),
            'anggota_id' => $this->request->getGet('anggota_id'),
            'status' => $this->request->getGet('status')
        ];

        $peminjamans = $this->peminjamanModel->getLaporanPeminjamanWithFilter($filters);
        $pengaturanDenda = $this->pengaturanDendaModel->first();
        $anggotaList = $this->anggotaModel->findAll();

        return view('admin/report/peminjaman', [
            'title' => 'Laporan Peminjaman',
            'peminjamans' => $peminjamans,
            'pengaturanDenda' => $pengaturanDenda,
            'anggotaList' => $anggotaList,
            'start' => $filters['start'],
            'end' => $filters['end'],
            'anggota_id' => $filters['anggota_id'],
            'status' => $filters['status'],
        ]);
    }


    public function exportPeminjaman()
    {
        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');
        $anggota_id = $this->request->getGet('anggota_id');
        $status = $this->request->getGet('status');

        $peminjamans = $this->peminjamanModel->getLaporan($start, $end, $anggota_id, $status);
        $pengaturanDenda = $this->pengaturanDendaModel->first();
        $tanggalCetak = Time::now()->toLocalizedString('d MMMM yyyy HH:mm');

        $data = [
            'title' => 'Laporan Peminjaman',
            'peminjamans' => $peminjamans,
            'pengaturanDenda' => $pengaturanDenda,
            'start' => $start,
            'end' => $end,
            'anggota_id' => $anggota_id,
            'status' => $status,
            'tanggalCetak' => $tanggalCetak,
        ];

        $html = view('admin/report/pdf_peminjaman', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("laporan_peminjaman_" . date('Ymd_His') . ".pdf", ["Attachment" => true]);
    }
}
