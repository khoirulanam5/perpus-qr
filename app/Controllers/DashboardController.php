<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    protected $userModel;
    protected $bukuModel;
    protected  $anggotaModel;
    protected $peminjamanModel;

    public function __construct()
    {
        $this->bukuModel = new Buku();
        $this->anggotaModel = new Anggota();
        $this->peminjamanModel = new Peminjaman();
        $this->userModel = new User();
    }

    public function index()
    {
        $buku = $this->bukuModel->countAll();
        $anggota = $this->anggotaModel->countAll();
        $peminjaman = $this->peminjamanModel->countAll();
        $user = $this->userModel->countAll();
        return view('admin\dashboard\index', [
            'title' => 'Dashboard',
            'buku' => $buku,
            'anggota' => $anggota,
            'peminjaman' => $peminjaman,
            'user' => $user
        ]);
    }
}
