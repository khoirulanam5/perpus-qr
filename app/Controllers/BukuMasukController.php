<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Buku;
use App\Models\BukuMasuk;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class BukuMasukController extends BaseController
{
    protected $bukuMasukModel;
    protected $bukuModel;

    public function __construct()
    {
        $this->bukuMasukModel = new BukuMasuk();
        $this->bukuModel = new Buku();
    }

    public function index()
    {
        $bukuMasuks = $this->bukuMasukModel->getAllWithBuku();
        // var_dump($bukuMasuks);
        return view('admin\buku_masuk\index', [
            'title' => 'Data Buku Masuk',
            'bukuMasuks' => $bukuMasuks
        ]);
    }

    public function create()
    {

        $bukus = $this->bukuModel->orderBy('judul', 'ASC')->findAll();
        return view('admin\buku_masuk\create', [
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
            'tanggal_masuk' => [
                'label' => 'Tanggal Masuk',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'jumlah_masuk' => [
                'label' => 'Jumlah Masuk',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'diperoleh_dari' => [
                'label' => 'Diperoleh Dari',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ]
        ];


        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        $bukuMasuk = $this->bukuMasukModel;
        $bukuMasuk->insert([
            'buku_id' => $this->request->getPost('buku_id'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'jumlah_masuk' => $this->request->getPost('jumlah_masuk'),
            'diperoleh_dari' => $this->request->getPost('diperoleh_dari'),
            'keterangan' => $this->request->getPost('keterangan')
        ]);
        $buku = $this->bukuModel->find($this->request->getPost('buku_id'));
        $stokBaru =  $buku->stok + $this->request->getPost('jumlah_masuk');
        $this->bukuModel->update($buku->id, ['stok' => $stokBaru]);

        return redirect()->to('buku_masuk')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $bukuMasuk = $this->bukuMasukModel->find($id);
        $bukus = $this->bukuModel->orderBy('judul', 'ASC')->findAll();
        return view('admin\buku_masuk\edit', [
            'title' => 'Data Buku Masuk',
            'bukus' => $bukus,
            'bukuMasuk' => $bukuMasuk
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
            'tanggal_masuk' => [
                'label' => 'Tanggal Masuk',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'jumlah_masuk' => [
                'label' => 'Jumlah Masuk',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'diperoleh_dari' => [
                'label' => 'Diperoleh Dari',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ]
        ];


        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        $bukuModel = $this->bukuMasukModel;

        $buku = $this->bukuModel->find($this->request->getPost('buku_id'));
        $bukuMasuk = $this->bukuMasukModel->find($id);
        // var_dump($this->request->getPost('jumlah_masuk') - $bukuMasuk->jumlah_masuk);
        $stokBaru =  $buku->stok + ($this->request->getPost('jumlah_masuk') - $bukuMasuk->jumlah_masuk);

        $bukuModel->update($id, [
            'buku_id' => $this->request->getPost('buku_id'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'jumlah_masuk' => $this->request->getPost('jumlah_masuk'),
            'diperoleh_dari' => $this->request->getPost('diperoleh_dari'),
            'keterangan' => $this->request->getPost('keterangan')
        ]);
        $this->bukuModel->update($buku->id, ['stok' => $stokBaru]);

        return redirect()->to('buku_masuk')->with('success', 'Data berhasil ditambahkan.');
    }

    public function destroy($id)
    {

        try {
            $this->bukuModel->delete($id);
            $bukuMasuk = $this->bukuMasukModel->find($id);
            $buku = $this->bukuModel->find($bukuMasuk->buku_id);
            $this->bukuMasukModel->delete($id);
            $bukuStok = $buku->stok - $bukuMasuk->jumlah_masuk;
            $this->bukuModel->update($buku->id, ['stok' => $bukuStok]);
            return redirect()->to('buku_masuk')->with('success', 'Data berhasil dihapus.');
        } catch (DatabaseException $e) {
            return redirect()->to('buku_masuk')->with('error', 'Data gagal dihapus. Pastikan tidak ada data yang terkait.');
        }
    }
}
