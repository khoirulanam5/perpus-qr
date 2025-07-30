<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Tema;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;
use SawaStacks\CodeIgniter\Slugify;

class TemaController extends BaseController
{
    protected $temaModel;

    public function __construct()
    {
        $this->temaModel = new Tema();
    }

    public function index()
    {
        $temas = $this->temaModel->orderBy('id', 'DESC')->findAll();
        return view('admin\tema\index', [
            'title' => 'Data Tema',
            'temas' => $temas
        ]);
    }

    public function create()
    {
        return view(
            'admin\tema\create',
            [
                'title' => 'Data Tema'
            ]
        );
    }

    public function store()
    {
        $validation = Services::validation();
        $rules = [
            'nama' => [
                'label' => 'Tema',
                'rules' => 'required|min_length[3]|is_unique[tema.nama]',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'min_length'  => '{field} minimal harus 3 karakter.',
                    'is_unique'   => '{field} sudah ada.',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        $model = $this->temaModel;

        $slug = Slugify::table('tema')->make($this->request->getPost('nama'), 'slug');
        $data = [
            'nama'   => $this->request->getPost('nama'),
            'slug'   => $slug
        ];

        $model->insert($data);

        return redirect()->to('tema')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $rak = $this->temaModel->find($id);
        return view('admin\tema\edit', [
            'title' => 'Data Tema',
            'rak' => $rak
        ]);
    }
    public function update($id)
    {
        $validation = Services::validation();
        $rules = [
            'nama' => [
                'label' => 'Tema',
                'rules' => "required|min_length[3]|is_unique[tema.nama,id,{$id}]",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'min_length'  => '{field} minimal harus 3 karakter.',
                    'is_unique'   => '{field} sudah ada.',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        $model = $this->temaModel;

        $slug = Slugify::table('tema')->sid($id)->make($this->request->getPost('nama'), 'slug');
        $data = [
            'nama'   => $this->request->getPost('nama'),
            'slug'   => $slug
        ];

        $model->update($id, $data);
        return redirect()->to('tema')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        try {
            $this->temaModel->delete($id);
            return redirect()->to('tema')->with('success', 'Data berhasil dihapus.');
        } catch (DatabaseException $e) {
            return redirect()->to('tema')->with('error', 'Data gagal dihapus. Pastikan tidak ada data yang terkait.');
        }
    }
}
