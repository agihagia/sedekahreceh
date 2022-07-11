<?php

namespace App\Models;



use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = '';

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

    // hitung total data pada transaction
    public function getCountTrx()
    {
        return $this->db->table("transaksi")->countAll();
    }

    // hitung total data pada category
    public function getCountCategory()
    {
        return $this->db->table("detail_transaksi")->countAll();
    }

    // hitung total data pada product
    public function getCountProduct()
    {
        return $this->db->table("realisasi")->countAll();
    }

    // hitung total data pada user
    public function getCountUser()
    {
        return $this->db->table("users")->countAll();
    }

    public function chartTransaksi($date)
    {
        $this->like('created_at', $date, 'after');
        return count($this->get()->getResultArray());
    }

    public function chartHarian($date)
    {
        $this->like('created_at', $date, 'after');
        return count($this->get()->getResultArray());
    }

    public function chartPemasukan($date)
    {
        $this->select('sum(total_rupiah) as total');
        $this->where('jenis_transaksi','masuk');
        $this->like('created_at', $date, 'after');
        return $this->get()->getRow()->total;
    }
}
