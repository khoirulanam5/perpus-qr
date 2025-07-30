<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Buku;
use App\Models\BukuKeluar;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class BukuKeluarController extends BaseController
{
    protected $bukuKeluarModel;
    protected $bukuModel;

    public function __construct()
    {
        $this->bukuKeluarModel = new BukuKeluar();
        $this->bukuModel = new Buku();
    }

    public function index()
    {
        $bukuMasuks = $this->bukuKeluarModel->getAllWithBuku();
        return view('admin\buku_keluar\index', [
            'title' => 'Data Buku Masuk',
            'bukuMasuks' => $bukuMasuks
        ]);
    }

    public function create()
    {
        $bukus = $this->bukuModel->orderBy('judul', 'ASC')->findAll();
        return view('admin\buku_keluar\create', [
            'title' => 'Data Buku Masuk',
            'bukus' => $bukus
        ]);
    }

    public function store()
    {
        $validation = Services::validation();

        $rules = [
            'buku_id' => [
                'label' => 'Buku',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ],
            ],
            'tanggal_keluar' => [
                'label' => 'Tanggal Masuk',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'jumlah_keluar' => [
                'label' => 'Jumlah Masuk',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'jenis_keluar' => [
                'label' => 'Jenis Keluar',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ]
        ];


        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        $bukuKeluar = $this->bukuKeluarModel;
        $bukuKeluar->insert([
            'buku_id' => $this->request->getPost('buku_id'),
            'tanggal_keluar' => $this->request->getPost('tanggal_keluar'),
            'jumlah_keluar' => $this->request->getPost('jumlah_keluar'),
            'jenis_keluar' => $this->request->getPost('jenis_keluar'),
            'keterangan' => $this->request->getPost('keterangan')
        ]);
        $buku = $this->bukuModel->find($this->request->getPost('buku_id'));
        $stokBaru =  $buku->stok - $this->request->getPost('jumlah_keluar');
        $this->bukuModel->update($buku->id, ['stok' => $stokBaru]);

        return redirect()->to('buku_keluar')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $bukuKeluar = $this->bukuKeluarModel->find($id);
        $bukus = $this->bukuModel->orderBy('judul', 'ASC')->findAll();
        return view('admin\buku_keluar\edit', [
            'title' => 'Data Buku Masuk',
            'bukus' => $bukus,
            'bukuKeluar' => $bukuKeluar
        ]);
    }

    public function update($id)
    {
        $validation = Services::validation();

        $rules = [
            'buku_id' => [
                'label' => 'Buku',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ],
            ],
            'tanggal_keluar' => [
                'label' => 'Tanggal Masuk',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'jumlah_keluar' => [
                'label' => 'Jumlah Masuk',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'jenis_keluar' => [
                'label' => 'Jenis Keluar',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ]
        ];


        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        $bukuModel = $this->bukuKeluarModel;

        $buku = $this->bukuModel->find($this->request->getPost('buku_id'));
        $bukuMasuk = $this->bukuKeluarModel->find($id);
        // var_dump($this->request->getPost('jumlah_keluar') - $bukuMasuk->jumlah_keluar);
        $stokBaru =  $buku->stok - ($this->request->getPost('jumlah_keluar') - $bukuMasuk->jumlah_keluar);

        $bukuModel->update($id, [
            'buku_id' => $this->request->getPost('buku_id'),
            'tanggal_keluar' => $this->request->getPost('tanggal_keluar'),
            'jumlah_keluar' => $this->request->getPost('jumlah_keluar'),
            'jenis_keluar' => $this->request->getPost('jenis_keluar'),
            'keterangan' => $this->request->getPost('keterangan')
        ]);
        $this->bukuModel->update($buku->id, ['stok' => $stokBaru]);

        return redirect()->to('buku_keluar')->with('success', 'Data berhasil ditambahkan.');
    }

    public function destroy($id)
    {

        try {
            $this->bukuModel->delete($id);
            $bukuMasuk = $this->bukuKeluarModel->find($id);
            $buku = $this->bukuModel->find($bukuMasuk->buku_id);
            $this->bukuKeluarModel->delete($id);
            $bukuStok = $buku->stok + $bukuMasuk->jumlah_keluar;
            $this->bukuModel->update($buku->id, ['stok' => $bukuStok]);
            return redirect()->to('buku_keluar')->with('success', 'Data berhasil dihapus.');
        } catch (DatabaseException $e) {
            return redirect()->to('buku_keluar')->with('error', 'Data gagal dihapus. Pastikan tidak ada data yang terkait.');
        }
    }
}
