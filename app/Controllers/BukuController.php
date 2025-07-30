<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookTema;
use App\Models\Buku;
use App\Models\Rak;
use App\Models\Tema;
use CodeIgniter\Config\Services;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class BukuController extends BaseController
{
    protected $bukuModel;
    protected $temaModel;
    protected $rakModel;
    protected $bookTemaModel;

    public function __construct()
    {
        $this->bukuModel = new Buku();
        $this->temaModel = new Tema();
        $this->rakModel = new Rak();
        $this->bookTemaModel = new BookTema();
    }
    public function index()
    {
        $bukus = $this->bukuModel->getAllWithRakAndTema();
        return view('admin\buku\index', [
            'title' => 'Data Buku',
            'bukus' => $bukus
        ]);
    }


    public function create()
    {
        $temas = $this->temaModel->findAll();
        $raks = $this->rakModel->orderBy('kode_rak', 'ASC')->findAll();
        return view('admin\buku\create', [
            'title' => 'Data Buku',
            'temas' => $temas,
            'raks' => $raks
        ]);
    }

    public function store()
    {
        $validation = Services::validation();

        $rules = [
            'rak_id' => [
                'label' => 'Kode Rak Buku',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'judul' => [
                'label' => 'Judul Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'penulis' => [
                'label' => 'Penulis Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'penerbit' => [
                'label' => 'Penerbit Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'tahun_terbit' => [
                'label' => 'Tahun Terbit Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'isbn' => [
                'label' => 'Penulis Buku',
                'rules' => 'required|is_unique[buku.isbn]',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'is_unique'   => '{field} sudah ada.',
                ]
            ],
            'total_halaman' => [
                'label' => 'Total Halaman Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'stok' => [
                'label' => 'Stok Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'stok_pinjam' => [
                'label' => 'Stok Dipinjam Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'tema_id' => [
                'label' => 'Tema Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'sampul' => [
                'label' => 'Sampul Buku',
                'rules' => 'uploaded[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]|max_size[sampul,2048]',
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
        $buku = $this->bukuModel;

        $kodeBuku = $buku->generateKodeBuku();

        $bukuNew = $buku->insert([
            'kode_buku' => $kodeBuku,
            'rak_id' => $this->request->getPost('rak_id'),
            'judul' => $this->request->getPost('judul'),
            'penulis' => $this->request->getPost('penulis'),
            'penerbit' => $this->request->getPost('penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'isbn' => $this->request->getPost('isbn'),
            'total_halaman' => $this->request->getPost('total_halaman'),
            'stok' => $this->request->getPost('stok'),
            'stok_pinjam' => $this->request->getPost('stok_pinjam') ?? 0,
        ]);

        $file = $this->request->getFile('sampul');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext = $file->getExtension(); // Dapatkan ekstensi file (jpg/png/dll)
            $namaFile = $kodeBuku . '.' . $ext;

            // Pindahkan file ke folder uploads/sampul/
            $file->move('images/buku/', $namaFile);
        } else {
            $namaFile = null; // atau default image
        }

        $buku->update($bukuNew, [
            'sampul' => $namaFile
        ]);

        $tema_ids = $this->request->getPost('tema_id');
        if ($tema_ids && is_array($tema_ids)) {
            foreach ($tema_ids as $tema) {
                $this->bookTemaModel->insert([
                    'buku_id' => $bukuNew,
                    'tema_id' => $tema
                ]);
            }
        }

        return redirect()->to('buku')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Data Buku',
            'buku' => $this->bukuModel->find($id),
            'raks' => $this->rakModel->orderBy('kode_rak', 'ASC')->findAll(),
            'temas' => $this->temaModel->findAll(),
            'bookTema' => $this->bookTemaModel->where('buku_id', $id)->findAll(),
        ];
        return view('admin/buku/edit', $data);
    }

    public function update($id)
    {
        $validation = Services::validation();

        $rules = [
            'rak_id' => [
                'label' => 'Kode Rak Buku',
                'rules' => "required",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'judul' => [
                'label' => 'Judul Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'penulis' => [
                'label' => 'Penulis Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'penerbit' => [
                'label' => 'Penerbit Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'tahun_terbit' => [
                'label' => 'Tahun Terbit Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'isbn' => [
                'label' => 'Penulis Buku',
                'rules' => "required|is_unique[buku.isbn,id,{$id}]",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'is_unique'   => '{field} sudah ada.',
                ]
            ],
            'total_halaman' => [
                'label' => 'Total Halaman Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'stok' => [
                'label' => 'Stok Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'stok_pinjam' => [
                'label' => 'Stok Dipinjam Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'tema_id' => [
                'label' => 'Tema Buku',
                'rules' => 'required',
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                ]
            ],
            'sampul' => [
                'label' => 'Sampul Buku',
                'rules' => 'mime_in[sampul,image/jpg,image/jpeg,image/png]|max_size[sampul,2048]',
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
        $buku = $this->bukuModel;

        $bukuLama = $buku->find($id);

        $bukuUpdate = $buku->update($id, [
            'rak_id' => $this->request->getPost('rak_id'),
            'judul' => $this->request->getPost('judul'),
            'penulis' => $this->request->getPost('penulis'),
            'penerbit' => $this->request->getPost('penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'isbn' => $this->request->getPost('isbn'),
            'total_halaman' => $this->request->getPost('total_halaman'),
            'stok' => $this->request->getPost('stok'),
            'stok_pinjam' => $this->request->getPost('stok_pinjam') ?? 0,
        ]);

        $file = $this->request->getFile('sampul');
        $kodeBuku = $this->request->getPost('kode_buku');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus file lama (jika ada)
            if ($bukuLama->sampul && file_exists(FCPATH . 'images/buku/' . $bukuLama->sampul)) {
                unlink(FCPATH . 'images/buku/' . $bukuLama->sampul);
            }

            // Simpan file baru dengan nama berdasarkan kode_buku
            $ext = $file->getExtension();
            $namaFile = $kodeBuku . '.' . $ext;
            $file->move('images/buku/', $namaFile);
        }

        $tema_ids = $this->request->getPost('tema_id');

        $this->bookTemaModel->where('buku_id', $id)->delete();
        // Insert relasi baru
        if ($tema_ids && is_array($tema_ids)) {
            foreach ($tema_ids as $tema) {
                $this->bookTemaModel->insert([
                    'buku_id' => $id,
                    'tema_id' => $tema
                ]);
            }
        }

        return redirect()->to('buku')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $buku = $this->bukuModel->find($id);
            $this->bukuModel->delete($id);
            if ($buku->sampul && file_exists(FCPATH . 'images/buku/' . $buku->sampul)) {
                unlink(FCPATH . 'images/buku/' . $buku->sampul);
            }
            return redirect()->to('buku')->with('success', 'Data berhasil dihapus.');
        } catch (DatabaseException $e) {
            return redirect()->to('buku')->with('error', 'Data gagal dihapus. Pastikan tidak ada data yang terkait.');
        }
    }
}
