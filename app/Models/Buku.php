<?php

namespace App\Models;

use CodeIgniter\Model;

class Buku extends Model
{
    protected $table            = 'buku';
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

    public function getAllWithRakAndTema()
    {
        return $this->db->table('buku')
            ->select('buku.*, rak.nama_rak, GROUP_CONCAT(tema.nama SEPARATOR ", ") AS tema_nama')
            ->join('rak', 'rak.id = buku.rak_id', 'left')
            ->join('book_tema', 'book_tema.buku_id = buku.id', 'left')
            ->join('tema', 'tema.id = book_tema.tema_id', 'left')
            ->groupBy('buku.id')
            ->orderBy('buku.id', 'DESC')
            ->get()
            ->getResult();
    }

    public function generateKodeBuku(): string
    {
        // Ambil kode terakhir dari tabel buku
        $last = $this->orderBy('id', 'DESC')->first();

        if ($last && isset($last->kode_buku)) {
            // Ambil angka dari kode terakhir
            $lastNumber = (int) substr($last->kode_buku, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        // Format: PAZDN-0001
        return 'PAZDN-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
