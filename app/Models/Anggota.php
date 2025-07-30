<?php

namespace App\Models;

use CodeIgniter\Model;

class Anggota extends Model
{
    protected $table            = 'anggota';
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

    public function generateKodeAnggota(): string
    {
        // Ambil record terakhir berdasarkan ID
        $last = $this->select('kode_anggota')
            ->orderBy('id', 'DESC')
            ->first();

        if ($last && isset($last->kode_anggota)) {
            // Ambil angka dari kode terakhir (misal: AZ-0012 → 12)
            $lastNumber = (int) substr($last->kode_anggota, 3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        // Format final: AZ-0001
        return 'AZ-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
