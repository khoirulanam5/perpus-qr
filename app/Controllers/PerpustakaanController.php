<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Perpustakaan;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\ResponseInterface;

class PerpustakaanController extends BaseController
{
    protected $perpustakaan;
    public function __construct()
    {
        $this->perpustakaan = new Perpustakaan();
    }
    public function index()
    {
        $perpustakaan = $this->perpustakaan->first();
        return view('admin\perpustakaan\index', [
            'title' => 'Perpustakaan',
            'perpustakaan' => $perpustakaan
        ]);
    }

    public function update($id)
    {
        // Ambil data dari form
        $validation = Services::validation();

        $rules = [
            'nama' => [
                'label' => 'Nama Perpustakaan',
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'min_length'  => '{field} minimal harus 3 karakter.',
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ]
            ],
            'kontak' => [
                'label' => 'Kontak',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                    'numeric'  => '{field} harus berupa angka.',
                ]
            ],
            'kepala' => [
                'label' => 'Nama Kepala Perpustakaan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $model = $this->perpustakaan;

        $data = [
            'nama'   => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'kontak' => $this->request->getPost('kontak'),
            'kepala' => $this->request->getPost('kepala'),
        ];

        $model->update($id, $data);

        return redirect()->to('perpustakaan')->with('success', 'Data berhasil diperbarui');
    }
}
