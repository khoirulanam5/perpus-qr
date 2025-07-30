<?php

namespace App\Models;

use CodeIgniter\Model;

class Peminjaman extends Model
{
    protected $table            = 'peminjaman';
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

    public function getAllPeminjamanWithDetails()
    {
        return $this->db->table('peminjaman')
            ->select('
        peminjaman.*, 
        users.nama AS user_nama, 
        anggota.nama AS anggota_nama, 
        anggota.kode_anggota AS kode_anggota,
        GROUP_CONCAT(CONCAT(buku.judul, " (", peminjaman_detail.jumlah, ")") SEPARATOR ", ") AS buku_dipinjam,
        SUM(peminjaman_detail.jumlah) AS jumlah_buku,
        IFNULL(MAX(denda.total_denda), 0) AS total_denda
    ')
            ->join('users', 'users.id = peminjaman.user_id', 'left')
            ->join('anggota', 'anggota.id = peminjaman.anggota_id', 'left')
            ->join('peminjaman_detail', 'peminjaman_detail.peminjaman_id = peminjaman.id', 'left')
            ->join('buku', 'buku.id = peminjaman_detail.buku_id', 'left')
            ->join('denda', 'denda.peminjaman_id = peminjaman.id', 'left')
            ->groupBy('peminjaman.id')
            ->orderBy('ISNULL(MAX(denda.id))', 'DESC')
            ->orderBy('peminjaman.tanggal_due', 'ASC')
            ->get()
            ->getResult();
    }

    public function getAllPeminjamanWithDetailsByUser()
    {
        return $this->db->table('peminjaman')
            ->select('
        peminjaman.*, 
        users.nama AS user_nama, 
        anggota.nama AS anggota_nama, 
        anggota.kode_anggota AS kode_anggota,
        GROUP_CONCAT(CONCAT(buku.judul, " (", peminjaman_detail.jumlah, ")") SEPARATOR ", ") AS buku_dipinjam,
        SUM(peminjaman_detail.jumlah) AS jumlah_buku,
        IFNULL(MAX(denda.total_denda), 0) AS total_denda
    ')
            ->join('users', 'users.id = peminjaman.user_id', 'left')
            ->join('anggota', 'anggota.id = peminjaman.anggota_id', 'left')
            ->join('peminjaman_detail', 'peminjaman_detail.peminjaman_id = peminjaman.id', 'left')
            ->join('buku', 'buku.id = peminjaman_detail.buku_id', 'left')
            ->join('denda', 'denda.peminjaman_id = peminjaman.id', 'left')
            ->where('anggota.kode_anggota', session()->get('user_username'))
            ->groupBy('peminjaman.id')
            ->orderBy('ISNULL(MAX(denda.id))', 'DESC')
            ->orderBy('peminjaman.tanggal_due', 'ASC')
            ->get()
            ->getResult();
    }
    public function getLaporanPeminjamanWithFilter(array $filters = [])
    {
        $builder = $this->db->table('peminjaman')
            ->select('
            peminjaman.*, 
            users.nama AS user_nama, 
            anggota.nama AS anggota_nama, 
            anggota.kode_anggota AS kode_anggota,
            GROUP_CONCAT(CONCAT(buku.judul, " (", peminjaman_detail.jumlah, ")") SEPARATOR ", ") AS buku_dipinjam,
            SUM(peminjaman_detail.jumlah) AS jumlah_buku,
            IFNULL(MAX(denda.total_denda), 0) AS total_denda
        ')
            ->join('users', 'users.id = peminjaman.user_id', 'left')
            ->join('anggota', 'anggota.id = peminjaman.anggota_id', 'left')
            ->join('peminjaman_detail', 'peminjaman_detail.peminjaman_id = peminjaman.id', 'left')
            ->join('buku', 'buku.id = peminjaman_detail.buku_id', 'left')
            ->join('denda', 'denda.peminjaman_id = peminjaman.id', 'left')
            ->groupBy('peminjaman.id');

        // Filter: Tanggal Awal
        if (!empty($filters['start'])) {
            $builder->where('peminjaman.tanggal_pinjam >=', $filters['start']);
        }

        // Filter: Tanggal Akhir
        if (!empty($filters['end'])) {
            $builder->where('peminjaman.tanggal_pinjam <=', $filters['end']);
        }

        // Filter: Anggota
        if (!empty($filters['anggota_id'])) {
            $builder->where('peminjaman.anggota_id', $filters['anggota_id']);
        }

        // Filter: Status
        if (!empty($filters['status'])) {
            $builder->where('peminjaman.status', $filters['status']);
        }

        // Urutan: yang belum denda di atas
        $builder->orderBy('ISNULL(MAX(denda.id))', 'DESC');
        $builder->orderBy('peminjaman.tanggal_due', 'ASC');

        return $builder->get()->getResult();
    }
    public function getLaporan($start = null, $end = null, $anggota_id = null, $status = null)
    {
        $builder = $this->db->table('peminjaman')
            ->select('
            peminjaman.*, 
            users.nama AS user_nama, 
            anggota.nama AS anggota_nama, 
            anggota.kode_anggota AS kode_anggota,
            GROUP_CONCAT(CONCAT(buku.judul, " (", peminjaman_detail.jumlah, ")") SEPARATOR ", ") AS buku_dipinjam,
            SUM(peminjaman_detail.jumlah) AS jumlah_buku,
            IFNULL(MAX(denda.total_denda), 0) AS total_denda
        ')
            ->join('users', 'users.id = peminjaman.user_id', 'left')
            ->join('anggota', 'anggota.id = peminjaman.anggota_id', 'left')
            ->join('peminjaman_detail', 'peminjaman_detail.peminjaman_id = peminjaman.id', 'left')
            ->join('buku', 'buku.id = peminjaman_detail.buku_id', 'left')
            ->join('denda', 'denda.peminjaman_id = peminjaman.id', 'left')
            ->groupBy('peminjaman.id');

        if ($start) {
            $builder->where('peminjaman.tanggal_pinjam >=', $start);
        }

        if ($end) {
            $builder->where('peminjaman.tanggal_pinjam <=', $end);
        }

        if ($anggota_id) {
            $builder->where('peminjaman.anggota_id', $anggota_id);
        }

        if ($status) {
            $builder->where('peminjaman.status', $status);
        }

        return $builder->get()->getResult();
    }
}
