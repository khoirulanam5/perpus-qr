<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengaturanDenda;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\ResponseInterface;

class PengaturanDendaController extends BaseController
{
    protected $pengaturanDendaModel;

    public function __construct()
    {
        $this->pengaturanDendaModel = new PengaturanDenda();
    }
    public function index()
    {
        $pengaturanDenda = $this->pengaturanDendaModel->first();
        return view('admin\pengaturan_denda\index', [
            'title' => 'Pengaturan Denda',
            'pengaturanDenda' => $pengaturanDenda
        ]);
    }

    public function update($id)
    {
        // Ambil data dari form
        $validation = Services::validation();

        $rules = [
            'denda_per_hari' => [
                'label' => 'Denda Per Hari',
                'rules'  => 'required|greater_than_equal_to[0]|numeric',
                'errors' => [
                    'required'               => '{field} wajib diisi.',
                    'numeric'                => '{field} harus berupa angka.',
                    'greater_than_equal_to'  => '{field} tidak boleh negatif.',
                ]
            ],
            'denda_buku_hilang' => [
                'label' => 'Denda Buku Hilang',
                'rules' => 'required|greater_than_equal_to[0]|numeric',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'numeric'  => '{field} harus angka.',
                    'greater_than_equal_to'  => '{field} tidak boleh negatif.',
                ]
            ],
            'maksimal_telat' => [
                'label' => 'Maksimum Telat (Hari)',
                'rules' => 'required|greater_than_equal_to[0]|numeric',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'numeric'  => '{field} harus angka.',
                    'greater_than_equal_to'  => '{field} tidak boleh negatif.',
                ]
            ],
            'tipe_telat' => [
                'label' => 'Tipe Denda',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ]

        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $model = $this->pengaturanDendaModel;

        $data = [
            'denda_per_hari' => $this->request->getPost('denda_per_hari'),
            'denda_buku_hilang' => $this->request->getPost('denda_buku_hilang'),
            'maksimal_telat' => $this->request->getPost('maksimal_telat'),
            'tipe_telat' => $this->request->getPost('tipe_telat')
        ];

        $model->update($id, $data);

        return redirect()->to('pengaturan-denda')->with('success', 'Data berhasil diperbarui');
    }
}
