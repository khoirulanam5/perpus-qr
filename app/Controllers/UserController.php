<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index()
    {
        return view('admin\user\index', [
            'title' => 'Data Admin',
            'users' => $this->userModel->findAll()
        ]);
    }

    public function create()
    {
        return view('admin\user\create', [
            'title' => 'Data Admin'
        ]);
    }

    public function store()
    {
        $validation = Services::validation();

        $rules = [
            'nama' => [
                'label' => 'Nama',
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'min_length'  => '{field} minimal harus 3 karakter.',
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[3]|is_unique[users.username]',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'min_length'  => '{field} minimal harus 3 karakter.',
                    'is_unique'   => '{field} sudah ada.',
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'min_length'  => '{field} minimal harus 3 karakter.',
                ]
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                ]
            ],
            'aktif' => [
                'label' => 'Status',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                ]
            ]
        ];
        if (!$this->validate($rules)) {
            return redirect()->to('user/create')->withInput()->with('errors', $this->validator->getErrors());
        }

        $password = $this->request->getPost('password');
        $hashPass = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => $hashPass,
            'role' => $this->request->getPost('role'),
            'aktif' => $this->request->getPost('aktif'),
        ];
        $this->userModel->insert($data);
        return redirect()->to('user')->with('success', 'Data berhasil disimpan.');
    }

    public function edit($id)
    {
        return view('admin\user\edit', [
            'title' => 'Data Admin',
            'user' => $this->userModel->find($id)
        ]);
    }


    public function update($id)
    {
        $validation = Services::validation();

        $rules = [
            'nama' => [
                'label' => 'Nama',
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'min_length'  => '{field} minimal harus 3 karakter.',
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => "required|min_length[3]|is_unique[users.username,id,{$id}]",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'min_length'  => '{field} minimal harus 3 karakter.',
                    'is_unique'   => '{field} sudah ada.',
                ]
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                ]
            ],
            'aktif' => [
                'label' => 'Status',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                ]
            ]
        ];
        $password = $this->request->getPost('password');
        if ($password !== null && trim($password) !== '') {
            $rules['password'] = [
                'label' => 'Password',
                'rules' => 'permit_empty|min_length[3]',
                'errors' => [
                    'min_length' => '{field} minimal harus 3 karakter.',
                ]
            ];
        }
        if (!$this->validate($rules)) {
            return redirect()->to('user/create')->withInput()->with('errors', $validation->getErrors());
        }


        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'role' => $this->request->getPost('role'),
            'aktif' => $this->request->getPost('aktif'),
        ];
        if (!empty($password) && strlen($password) >= 3) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT); // hash password baru
        }
        $this->userModel->update($id, $data);

        return redirect()->to('user')->with('success', 'Data berhasil disimpan.');
    }

    public function destroy($id)
    {
        try {
            $this->userModel->delete($id);
            return redirect()->to('user')->with('success', 'Data berhasil dihapus.');
        } catch (DatabaseException $e) {
            return redirect()->to('user')->with('error', 'Data gagal dihapus. Pastikan tidak ada data yang terkait.');
        }
    }
}
