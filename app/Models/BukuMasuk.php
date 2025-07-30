<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuMasuk extends Model
{
    protected $table            = 'buku_masuk';
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
        return $this->db->table('buku_masuk')
            ->select('buku_masuk.*, buku.sampul, buku.judul, buku.kode_buku')
            ->join('buku', 'buku.id = buku_masuk.buku_id', 'left')
            ->groupBy('buku_masuk.id')
            ->orderBy('buku_masuk.id', 'DESC')
            ->get()
            ->getResult();
    }

    public function getLaporan($start = null, $end = null)
    {
        $builder = $this->db->table('buku_masuk')
            ->select('buku_masuk.*, buku.kode_buku, buku.judul')
            ->join('buku', 'buku.id = buku_masuk.buku_id');

        if ($start && $end) {
            $builder->where('tanggal_masuk >=', $start)
                ->where('tanggal_masuk <=', $end);
        }

        return $builder->orderBy('tanggal_masuk', 'DESC')->get()->getResult();
    }
}
