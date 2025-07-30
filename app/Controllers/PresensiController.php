<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Anggota;
use App\Models\Presensi;
use CodeIgniter\HTTP\ResponseInterface;

class PresensiController extends BaseController
{

    protected $presensiModel;
    protected $anggotaModel;
    public function __construct()
    {
        $this->presensiModel = new Presensi();
        $this->anggotaModel = new Anggota();
    }

    public function index()
    {
        $presensis = $this->presensiModel->presesiWithAnggota()->findAll();

        if (session()->get('user_role') == 'anggota') {
            $presensis = $this->presensiModel->presesiWithAnggotaByUser()->findAll();
        }
        return view('admin/presensi/index', [
            'title' => 'Data Presensi',
            'presensis' => $presensis,
        ]);
    }

    public function store()
    {
        if (!$this->validate([
            'kode_anggota' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Cek apakah anggota dengan kode tersebut ada
        $anggota = $this->anggotaModel->where('kode_anggota', $this->request->getPost('kode_anggota'))->first();
        if (!$anggota) {
            return redirect()->back()->withInput()->with('error', 'Anggota dengan kode tersebut tidak ditemukan.');
        }
        // Cek apakah anggota sudah presensi hari ini
        $today = date('Y-m-d');
        $existingPresensi = $this->presensiModel->where('anggota_id', $anggota->id)
            ->where('tanggal', $today)
            ->first();
        if ($existingPresensi) {
            return redirect()->back()->withInput()->with('error', 'Anggota sudah melakukan presensi hari ini.');
        }


        $data = [
            'anggota_id' => $anggota->id,
            'tanggal' => date('Y-m-d'),
            'waktu' => date('H:i:s'),
        ];

        $this->presensiModel->insert($data);

        return redirect()->to(base_url('/presensi'))->with('success', 'Anggota berhasil presensi.');
    }
}
