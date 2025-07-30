<?php

namespace App\Models;

use CodeIgniter\Model;

class Presensi extends Model
{
    protected $table            = 'presensi';
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

    public function presesiWithAnggota()
    {
        return $this->select('presensi.*, anggota.nama, anggota.kode_anggota')
            ->join('anggota', 'anggota.id = presensi.anggota_id', 'left')
            ->orderBy('presensi.created_at', 'DESC');
    }

    public function presesiWithAnggotaByUser()
    {
        return $this->select('presensi.*, anggota.nama, anggota.kode_anggota')
            ->join('anggota', 'anggota.id = presensi.anggota_id', 'left')
            ->where('anggota.kode_anggota', session()->get('user_username'))
            ->orderBy('presensi.created_at', 'DESC');
    }
}
