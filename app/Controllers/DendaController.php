<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\BukuKeluar;
use App\Models\Denda;
use App\Models\DendaDetail;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\PengaturanDenda;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class DendaController extends BaseController
{
    protected $dendaModel;
    protected $dendaDetail;
    protected $anggotaModel;
    protected $bukuModel;
    protected $peminjamanModel;
    protected $peminjamanDetailModel;
    protected $pengaturanDendaModel;
    protected $bukuKeluarModel;

    public function __construct()
    {
        $this->dendaModel = new Denda();
        $this->dendaDetail = new DendaDetail();
        $this->anggotaModel = new Anggota();
        $this->bukuModel = new Buku();
        $this->peminjamanModel = new Peminjaman();
        $this->peminjamanDetailModel = new PeminjamanDetail();
        $this->pengaturanDendaModel = new PengaturanDenda();
        $this->bukuKeluarModel = new BukuKeluar();
    }

    public function index()
    {
        $pengaturanDenda = $this->pengaturanDendaModel->first();
        $dendas = $this->dendaModel->getAllWithPeminjaman();
        if (session()->get('user_role') == 'anggota') {
            $dendas = $this->dendaModel->getAllWithPeminjamanByUser();
        }
        return view('admin\denda\index', [
            'title' => 'Data Denda',
            'dendas' => $dendas,
            'pengaturanDenda' => $pengaturanDenda
        ]);
        // var_dump($dendas);
    }

    public function create($id)
    {
        $pengaturanDenda = $this->pengaturanDendaModel->first();
        $peminjaman = $this->peminjamanModel->find($id);
        $anggota = $this->anggotaModel->find($peminjaman->anggota_id);

        $detailWithBuku = [];
        $peminjamanDetails = $this->peminjamanDetailModel->where('peminjaman_id', $id)->findAll();
        $count = $this->peminjamanDetailModel
            ->where('peminjaman_id', $id)
            ->countAllResults();


        foreach ($peminjamanDetails as $detail) {
            $buku = $this->bukuModel->find($detail->buku_id);
            $detailWithBuku[] = [
                'detail' => $detail,
                'buku'   => $buku,
                'count'  => $count
            ];
        }
        return view('admin\denda\create', [
            'title' => 'Data Denda',
            'anggota' => $anggota,
            'peminjaman' => $peminjaman,
            'pengaturanDenda' => $pengaturanDenda,
            'detailWithBuku' => $detailWithBuku
        ]);
    }

    public function store()
    {
        $validation = Services::validation();

        $rules = [
            'anggota_id' => [
                'label' => 'Anggota',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.',
                ]
            ],
            'peminjaman_id' => [
                'label' => 'Peminjaman',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.',
                ]
            ],
            'tanggal_denda' => [
                'label' => 'Tanggal Denda',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.',
                ]
            ],
            'status' => [
                'label' => 'Status',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.',
                ]
            ],
            'keterangan' => [
                'label' => 'Keterangan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.',
                ]
            ]
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'anggota_id' => $this->request->getPost('anggota_id'),
            'user_id' => session()->get('user_id'),
            'peminjaman_id' => $this->request->getPost('peminjaman_id'),
            'tanggal_denda' => $this->request->getPost('tanggal_denda'),
            'status' => $this->request->getPost('status'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        $dendaId = $this->dendaModel->insert($data);

        $peminjaman = $this->peminjamanModel->update(
            $this->request->getPost('peminjaman_id'),
            [
                'tanggal_kembali' => $this->request->getPost('tanggal_denda'),
                'status' => 'terlambat'
            ]
        );
        $totalDenda = 0;
        $peminjamanDetails = $this->peminjamanDetailModel->where('peminjaman_id', $this->request->getPost('peminjaman_id'))->findAll();
        foreach ($peminjamanDetails as $detail) {
            $this->dendaDetail->insert([
                'denda_id' => $dendaId,
                'buku_id' => $detail->buku_id,
                'jenis' => $this->request->getPost("jenis_[$detail->buku_id]"),
                'subtotal' => (int) $this->request->getPost("denda_telat_[$detail->buku_id]") + (int) $this->request->getPost("denda_hilang_[$detail->buku_id]"),
            ]);

            $denda = (int) $this->request->getPost("denda_telat_[$detail->buku_id]") + (int) $this->request->getPost("denda_hilang_[$detail->buku_id]") ?? 0;
            $totalDenda += $denda;
            $buku = $this->bukuModel->find($detail->buku_id);
            $this->bukuModel->update($buku->id, [
                'stok' => $this->request->getPost("jenis_[$detail->buku_id]") == 'hilang' ? $buku->stok - $detail->jumlah : $buku->stok,
                'stok_pinjam' =>  $buku->stok_pinjam - $detail->jumlah
            ]);
            if ($this->request->getPost("jenis_[$detail->buku_id]") == 'hilang') {
                $this->bukuKeluarModel->insert([
                    'buku_id' => $detail->buku_id,
                    'tanggal_keluar' => $this->request->getPost('tanggal_denda'),
                    'jenis_keluar' => 'hilang',
                    'jumlah_keluar' => $detail->jumlah,
                    'keterangan' => $this->request->getPost('keterangan')
                ]);
            }
        }
        $this->dendaModel->update($dendaId, [
            'total_denda' => $totalDenda
        ]);
        return redirect()->to(base_url('admin/denda'))->with('success', 'Data denda berhasil disimpan.');
    }

    public function destroy($id)
    {
        try {
            $denda = $this->dendaModel->find($id);
            $dendaDetails = $this->dendaDetail->where('denda_id', $id)->findAll();
            foreach ($dendaDetails as $detail) {
                $buku = $this->bukuModel->find($detail->buku_id);
                $this->bukuModel->update($buku->id, [
                    'stok' => $detail->jenis == 'hilang' ? $buku->stok + 1 : $buku->stok,
                    'stok_pinjam' => $buku->stok_pinjam + 1
                ]);
                $bukuKeluar = $this->bukuKeluarModel->where('buku_id', $detail->buku_id)->where('jenis_keluar', 'hilang')->where('tanggal_keluar', $denda->tanggal_denda)->first();
                if ($bukuKeluar) {
                    $this->bukuKeluarModel->delete($bukuKeluar->id);
                }
                $this->dendaDetail->delete($detail->id);
            }
            $this->dendaModel->delete($id);
            return redirect()->to('denda')->with('success', 'Data berhasil dihapus.');
        } catch (DatabaseException $e) {
            return redirect()->to('denda')->with('error', 'Data gagal dihapus. Pastikan tidak ada data yang terkait.');
        }
    }
}
