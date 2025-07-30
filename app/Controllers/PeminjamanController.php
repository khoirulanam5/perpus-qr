<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\PengaturanDenda;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class PeminjamanController extends BaseController
{

    protected $peminjamanModel;
    protected $peminjamanDetailModel;
    protected $pengaturanDendaModel;
    protected $bukuModel;
    protected $anggotaModel;

    public function __construct()
    {
        $this->peminjamanModel = new Peminjaman();
        $this->peminjamanDetailModel = new PeminjamanDetail();
        $this->pengaturanDendaModel = new PengaturanDenda();
        $this->bukuModel = new Buku();
        $this->anggotaModel = new Anggota();
    }

    public function index()
    {
        $pengaturanDenda = $this->pengaturanDendaModel->first();
        $peminjamans = $this->peminjamanModel->getAllPeminjamanWithDetails();
        if (session()->get('user_role') == 'anggota') {
            $peminjamans = $this->peminjamanModel->getAllPeminjamanWithDetailsByUser();
        }
        return view('admin\peminjaman\index', [
            'title' => 'Data Peminjaman',
            'peminjamans' => $peminjamans,
            'pengaturanDenda' => $pengaturanDenda
        ]);
    }

    public function create()
    {
        $bukus = $this->bukuModel->getAllWithRakAndTema();
        $anggotas = $this->anggotaModel->orderBy('id', 'DESC')->findAll();
        return view('admin\peminjaman\create', [
            'title' => 'Data Peminjaman',
            'bukus' => $bukus,
            'anggotas' => $anggotas
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
            'tanggal_pinjam' => [
                'label' => 'Tanggal Pinjam',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.',
                ]
            ],
            'tanggal_due' => [
                'label' => 'Tanggal Due',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.',
                ]
            ],
            'buku' => [
                'label' => 'Buku',
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
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'user_id' => session('user_id'),
            'anggota_id' => $this->request->getPost('anggota_id'),
            'tanggal_pinjam' => $this->request->getPost('tanggal_pinjam'),
            'tanggal_due' => $this->request->getPost('tanggal_due'),
            'status' => $this->request->getPost('status'),
        ];

        $modal = $this->peminjamanModel->insert($data);
        $bukus = $this->request->getPost('buku');
        $bukus = $this->bukuModel->whereIn('id', $bukus)->findAll();
        foreach ($bukus as $buku) {
            $data = [
                'peminjaman_id' => $modal,
                'buku_id' => $buku->id,
                'jumlah' => 1
            ];
            $this->peminjamanDetailModel->insert($data);
            $this->bukuModel->update($buku->id, ['stok_pinjam' => $buku->stok_pinjam + 1]);
        }

        return redirect()->to('peminjaman')->with('success', 'Data berhasil disimpan.');
    }

    public function edit($id)
    {
        $peminjaman = $this->peminjamanModel->find($id);
        $peminjamanDetails = $this->peminjamanDetailModel->where('peminjaman_id', $id)->findAll();
        $bukus = $this->bukuModel->getAllWithRakAndTema();
        $bukuDipinjam = array_column($peminjamanDetails, 'buku_id');
        $anggotas = $this->anggotaModel->orderBy('id', 'DESC')->findAll();
        return view('admin\peminjaman\edit', [
            'title' => 'Data Peminjaman',
            'bukus' => $bukus,
            'anggotas' => $anggotas,
            'peminjaman' => $peminjaman,
            'bukuDipinjam' => $bukuDipinjam
        ]);
    }

    public function update($id)
    {
        $validation = Services::validation();
        $peminjaman = $this->peminjamanModel->find($id);
        $peminjamanDetails = $this->peminjamanDetailModel->where('peminjaman_id', $id)->findAll();
        $rules = [
            'anggota_id' => [
                'label' => 'Anggota',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.',
                ]
            ],
            'tanggal_pinjam' => [
                'label' => 'Tanggal Pinjam',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.',
                ]
            ],
            'tanggal_due' => [
                'label' => 'Tanggal Due',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.',
                ]
            ],
            'buku' => [
                'label' => 'Buku',
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
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            // 'user_id' => session('user_id'),
            'anggota_id' => $this->request->getPost('anggota_id'),
            'tanggal_pinjam' => $this->request->getPost('tanggal_pinjam'),
            'tanggal_due' => $this->request->getPost('tanggal_due'),
            'status' => $this->request->getPost('status'),
        ];
        if ($this->request->getPost('tanggal_kembali') != null) {
            $data['tanggal_kembali'] = $this->request->getPost('tanggal_kembali');
        }
        // var_dump($data);

        $this->peminjamanModel->update($id, $data);


        $pinjamDetail = $this->peminjamanDetailModel->where('peminjaman_id', $id)->findAll();
        foreach ($pinjamDetail as $pinjam) {
            $buku = $this->bukuModel->find($pinjam->buku_id);
            $this->bukuModel->update($pinjam->buku_id, ['stok_pinjam' => $buku->stok_pinjam - 1]);
            $this->peminjamanDetailModel->delete($pinjam->id);
        }

        $bukus = $this->request->getPost('buku');
        $bukus = $this->bukuModel->whereIn('id', $bukus)->findAll();
        foreach ($bukus as $buku) {
            $data = [
                'peminjaman_id' => $id,
                'buku_id' => $buku->id,
                'jumlah' => 1
            ];
            $this->peminjamanDetailModel->insert($data);
            $this->bukuModel->update($buku->id, ['stok_pinjam' => $buku->stok_pinjam + 1]);
        }

        return redirect()->to('peminjaman')->with('success', 'Data berhasil disimpan.');
    }

    public function destroy($id)
    {
        try {
            $bukus = $this->peminjamanDetailModel->where('peminjaman_id', $id)->findAll();
            foreach ($bukus as $pinjam) {
                $buku = $this->bukuModel->find($pinjam->buku_id);
                $this->bukuModel->update($pinjam->buku_id, ['stok_pinjam' => $buku->stok_pinjam - 1]);
                $this->peminjamanDetailModel->delete($pinjam->id);
            }
            $this->peminjamanModel->delete($id);
            return redirect()->to('peminjaman')->with('success', 'Data berhasil dihapus.');
        } catch (DatabaseException $e) {
            return redirect()->to('peminjaman')->with('error', 'Data gagal dihapus. Pastikan tidak ada data yang terkait.');
        }
    }
}
