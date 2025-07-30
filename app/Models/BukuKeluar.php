<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuKeluar extends Model
{
    protected $table            = 'buku_keluar';
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

    public function getAllWithBuku()
    {
        return $this->db->table('buku_keluar')
            ->select('buku_keluar.*, buku.sampul, buku.judul, buku.kode_buku')
            ->join('buku', 'buku.id = buku_keluar.buku_id', 'left')
            ->groupBy('buku_keluar.id')
            ->orderBy('buku_keluar.id', 'DESC')
            ->get()
            ->getResult();
    }

    public function getLaporan($start = null, $end = null, $jenis_keluar = null)
    {
        $builder = $this->db->table('buku_keluar')
            ->select('buku_keluar.*, buku.judul, buku.kode_buku')
            ->join('buku', 'buku.id = buku_keluar.buku_id', 'left');

        if (!empty($start)) {
            $builder->where('tanggal_keluar >=', $start);
        }

        if (!empty($end)) {
            $builder->where('tanggal_keluar <=', $end);
        }

        if (!empty($jenis_keluar)) {
            $builder->where('jenis_keluar', $jenis_keluar);
        }

        return $builder->orderBy('tanggal_keluar', 'DESC')->get()->getResult();
    }
}
