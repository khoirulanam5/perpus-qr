<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Anggota;
use App\Models\User;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class AnggotaController extends BaseController
{
    protected $anggotaModel;
    protected $userModel;

    public function __construct()
    {
        $this->anggotaModel = new Anggota();
        $this->userModel = new User();
    }
    public function index()
    {
        $anggotas = $this->anggotaModel->orderBy('id', 'DESC')->findAll();
        return view('admin\anggota\index', [
            'title' => 'Data Anggota',
            'anggotas' => $anggotas
        ]);
    }


    public function create()
    {
        return view('admin\anggota\create', [
            'title' => 'Data Anggota',
        ]);
    }

    public function store()
    {
        $validation = Services::validation();

        $rules = [
            'nama' => [
                'label' => 'Kode Rak Buku',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'alamat' => [
                'label' => 'Judul Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'tanggal_daftar' => [
                'label' => 'Penulis Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'jenis_kelamin' => [
                'label' => 'Penerbit Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'status' => [
                'label' => 'Tahun Terbit Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'foto' => [
                'label' => 'Foto Anggota',
                'rules' => 'mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
                'errors' => [
                    'uploaded'    => '{field} wajib diisi.',
                    'mime_in'     => '{field} harus berupa gambar.',
                    'max_size'    => '{field} maksimal 2MB.',
                ]
            ]
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $anggota = $this->anggotaModel->generateKodeAnggota();

        $angg = $this->anggotaModel->insert([
            'kode_anggota' => $anggota,
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'status' => $this->request->getPost('status'),
            'tanggal_daftar' => $this->request->getPost('tanggal_daftar'),
        ]);

        $file = $this->request->getFile('foto');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext = $file->getExtension(); // Dapatkan ekstensi file (jpg/png/dll)
            $namaFile = $anggota . '.' . $ext;

            // Pindahkan file ke folder uploads/sampul/
            $file->move('images/anggota/', $namaFile);
        } else {
            $namaFile = null; // atau default image
        }

        $hashPass = password_hash($anggota, PASSWORD_BCRYPT);
        $user = $this->userModel->insert([
            'nama' => $this->request->getPost('nama'),
            'username' => $anggota,
            'password' => $hashPass,
            'role' => 'anggota',
            'aktif' => 1
        ]);

        $this->anggotaModel->update($angg, [
            'foto' => $namaFile,
            'user_id' => $user
        ]);

        return redirect()->to('/anggota')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        return view('admin/anggota/edit', [
            'title' => 'Data Anggota',
            'anggota' => $this->anggotaModel->find($id)
        ]);
    }

    public function update($id)
    {
        $validation = Services::validation();

        $rules = [
            'nama' => [
                'label' => 'Kode Rak Buku',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'alamat' => [
                'label' => 'Judul Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'tanggal_daftar' => [
                'label' => 'Penulis Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'jenis_kelamin' => [
                'label' => 'Penerbit Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'status' => [
                'label' => 'Tahun Terbit Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'foto' => [
                'label' => 'Foto Anggota',
                'rules' => 'mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
                'errors' => [
                    'uploaded'    => '{field} wajib diisi.',
                    'mime_in'     => '{field} harus berupa gambar.',
                    'max_size'    => '{field} maksimal 2MB.',
                ]
            ]
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $anggota = $this->anggotaModel->find($id);

        $angg = $this->anggotaModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'status' => $this->request->getPost('status'),
            'tanggal_daftar' => $this->request->getPost('tanggal_daftar'),
        ]);
        $file = $this->request->getFile('foto');

        $user = $this->userModel->update($anggota->user_id, [
            'nama' => $this->request->getPost('nama'),
        ]);

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus file lama (jika ada)
            if ($anggota->foto && file_exists(FCPATH . 'images/anggota/' . $anggota->foto)) {
                unlink(FCPATH . 'images/anggota/' . $anggota->foto);
            }

            // Simpan file baru dengan nama berdasarkan kode_buku
            $ext = $file->getExtension();
            $namaFile = $anggota->kode_anggota . '.' . $ext;
            $file->move('images/anggota/', $namaFile);
        }

        $this->anggotaModel->update($id, [
            'foto' => $namaFile
        ]);

        return redirect()->to('/anggota')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $anggota = $this->anggotaModel->find($id);
            $this->anggotaModel->delete($id);
            if ($anggota->foto) {
                // Hapus file lama (jika ada)
                if ($anggota->foto && file_exists(FCPATH . 'images/anggota/' . $anggota->foto)) {
                    unlink(FCPATH . 'images/anggota/' . $anggota->foto);
                }
            }
            return redirect()->to('/anggota')->with('success', 'Data berhasil dihapus.');
        } catch (DatabaseException $e) {
            return redirect()->to('/anggota')->with('error', 'Data gagal dihapus. Pastikan tidak ada data yang terkait.');
        }
    }
}
