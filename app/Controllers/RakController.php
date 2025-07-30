<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Rak;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class RakController extends BaseController
{
    protected $rakModel;

    public function __construct()
    {
        $this->rakModel = new Rak();
    }

    public function index()
    {
        $raks = $this->rakModel->orderBy('kode_rak', 'ASC')->findAll();
        return view('admin\rak\index', [
            'title' => 'Data Rak',
            'raks' => $raks
        ]);
    }

    public function create()
    {
        return view(
            'admin\rak\create',
            [
                'title' => 'Data Rak'
            ]
        );
    }

    public function store()
    {
        $validation = Services::validation();
        $rules = [
            'kode_rak' => [
                'label' => 'Kode Rak Perpustakaan',
                'rules' => 'required|min_length[3]|is_unique[rak.kode_rak]',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'min_length'  => '{field} minimal harus 3 karakter.',
                    'is_unique'   => '{field} sudah ada.',
                ]
            ],
            'nama_rak' => [
                'label' => 'Nama Rak Perpustakaan',
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'min_length'  => '{field} minimal harus 3 karakter.',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        $model = $this->rakModel;

        $data = [
            'kode_rak'   => $this->request->getPost('kode_rak'),
            'nama_rak'   => $this->request->getPost('nama_rak'),
        ];

        $model->insert($data);

        return redirect()->to('rak')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $rak = $this->rakModel->find($id);
        return view('admin\rak\edit', [
            'title' => 'Data Rak',
            'rak' => $rak
        ]);
    }
    public function update($id)
    {
        $validation = Services::validation();
        $rules = [
            'kode_rak' => [
                'label' => 'Kode Rak Perpustakaan',
                'rules' => "required|min_length[3]|is_unique[rak.kode_rak,id,{$id}]",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'min_length'  => '{field} minimal harus 3 karakter.',
                    'is_unique'   => '{field} sudah ada.',
                ]
            ],
            'nama_rak' => [
                'label' => 'Nama Rak Perpustakaan',
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'min_length'  => '{field} minimal harus 3 karakter.',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        $model = $this->rakModel;

        $data = [
            'kode_rak'   => $this->request->getPost('kode_rak'),
            'nama_rak'   => $this->request->getPost('nama_rak'),
        ];

        $model->update($id, $data);

        return redirect()->to('rak')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        try {
            $this->rakModel->delete($id);
            return redirect()->to('rak')->with('success', 'Data berhasil dihapus.');
        } catch (DatabaseException $e) {
            return redirect()->to('rak')->with('error', 'Data gagal dihapus. Pastikan tidak ada data yang terkait.');
        }
    }
}
