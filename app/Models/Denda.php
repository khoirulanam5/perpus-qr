<?php

namespace App\Models;

use CodeIgniter\Model;

class Denda extends Model
{
    protected $table            = 'denda';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAllWithPeminjaman()
    {
        return $this->select('
            denda.*,
            users.nama AS user_nama,
            peminjaman.tanggal_pinjam,
            peminjaman.tanggal_due,
            peminjaman.tanggal_kembali,
            anggota.nama AS anggota_nama,
            GROUP_CONCAT(CONCAT(buku.judul, " (", 1, ")") SEPARATOR ", ") AS buku_dipinjam,
            anggota.kode_anggota,
        ')
            ->join('peminjaman', 'peminjaman.id = denda.peminjaman_id', 'left')
            ->join('users', 'users.id = peminjaman.user_id', 'left')
            ->join('anggota', 'anggota.id = peminjaman.anggota_id', 'left')
            ->join('denda_detail', 'denda_detail.denda_id = denda.id', 'left')
            ->join('buku', 'buku.id = denda_detail.buku_id', 'left')
            ->groupBy('denda.id')
            ->orderBy('denda.created_at', 'DESC')
            ->findAll();
    }

    public function getAllWithPeminjamanByUser()
    {
        return $this->select('
            denda.*,
            users.nama AS user_nama,
            peminjaman.tanggal_pinjam,
            peminjaman.tanggal_due,
            peminjaman.tanggal_kembali,
            anggota.nama AS anggota_nama,
            GROUP_CONCAT(CONCAT(buku.judul, " (", 1, ")") SEPARATOR ", ") AS buku_dipinjam,
            anggota.kode_anggota,
        ')
            ->join('peminjaman', 'peminjaman.id = denda.peminjaman_id', 'left')
            ->join('users', 'users.id = peminjaman.user_id', 'left')
            ->join('anggota', 'anggota.id = peminjaman.anggota_id', 'left')
            ->join('denda_detail', 'denda_detail.denda_id = denda.id', 'left')
            ->join('buku', 'buku.id = denda_detail.buku_id', 'left')
            ->where('anggota.kode_anggota', session()->get('user_username'))
            ->groupBy('denda.id')
            ->orderBy('denda.created_at', 'DESC')
            ->findAll();
    }

    public function getFilteredDenda($anggota_id = null, $status = null, $start = null, $end = null)
    {
        $builder = $this->select('
            denda.*,
            users.nama AS user_nama,
            peminjaman.tanggal_pinjam,
            peminjaman.tanggal_due,
            peminjaman.tanggal_kembali,
            anggota.nama AS anggota_nama,
            anggota.kode_anggota,
            GROUP_CONCAT(CONCAT(buku.judul, " (", 1, ")") SEPARATOR ", ") AS buku_dipinjam
        ')
            ->join('peminjaman', 'peminjaman.id = denda.peminjaman_id', 'left')
            ->join('users', 'users.id = peminjaman.user_id', 'left')
            ->join('anggota', 'anggota.id = peminjaman.anggota_id', 'left')
            ->join('denda_detail', 'denda_detail.denda_id = denda.id', 'left')
            ->join('buku', 'buku.id = denda_detail.buku_id', 'left');

        if ($anggota_id) {
            $builder->where('anggota.id', $anggota_id);
        }

        if ($status) {
            $builder->where('denda.status', $status);
        }

        if ($start && $end) {
            $builder->where("DATE(denda.tanggal_denda) BETWEEN", [$start, $end]);
        }

        return $builder->groupBy('denda.id')
            ->orderBy('denda.created_at', 'DESC')
            ->findAll();
    }
}
