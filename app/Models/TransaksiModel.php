<?php

namespace App\Models;



use CodeIgniter\Model;

class TransaksiModel extends Model
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


    public function getTransaksi()
    {
        $this->select("{$this->table}.*, users.nama");
        $this->join("users", "users.id = {$this->table}.id_user");
        $this->orderBy("{$this->table}.id", "ASC");
        $query = $this->findAll();
        return $query;
    }

    public function setorsedekah($data)
    {
        //tambahkan saldo ke akun user
        $user = new AuthModel();
        $user->tambahSaldo($data['id_user'], $data['total_rupiah']);
        //insert ke table transaksi
        $id_transaksi = $this->insert([
            'no_transaksi' => $data['no_transaksi'],
            'id_admin' => $data['id_admin'],
            'id_user' => $data['id_user'],
            'jenis_transaksi' => $data['jenis_transaksi'],
            'status_transaksi' => $data['status_transaksi'],
            'total_rupiah' => $data['total_rupiah']
        ], true);
        
        // lakukan insert ke table detail transaksi
        $detail = new DetailTransaksiModel();
        $detail->tambahDetail([
            'id_transaksi' => $id_transaksi,
            'detail' => $data['detail_transaksi']
        ], false);
        return $id_transaksi;
    }
    
    public function tarikSaldo($data)
    {
        //kurangi saldo ke akun user
        $user = new AuthModel();
        $user->tarikSaldo($data['id_user'], $data['total_rupiah']);
        return $this->insert($data, true);
    }
    
    public function countTransaksiUser($id = false, $id_user = null)
    {
        $this->select("{$this->table}.*");
        $this->where("{$this->table}.id <", $id);
        $this->where("{$this->table}.id_user", $id_user);
        $this->orderBy("{$this->table}.id", "DESC");
        $query = $this->countAllResults();
        return $query;
    }

    public function getTransaksiUser($id = "", $id_user = null, $limit = false)
    {
        $this->select("{$this->table}.*");
        $this->where("{$this->table}.id_user", $id_user);
        if (!empty($id)) {
            $this->where("{$this->table}.id <", $id);
        }
        $this->orderBy("{$this->table}.id", "DESC");
        $query = $this->findAll($limit);
        return $query;
    }

    public function kwitansi($id)
    {
        $this->select("{$this->table}.*, users.nama, users.alamat, users.rt, users.rw, users.saldo");
        $this->join("users", "{$this->table}.id_user=users.id");
        $this->where("{$this->table}.id", $id);
        $query = $this->get()->getRowArray();
        return $query;
    }
    public function rekapTransaksi($dari, $sampai)
    {
        $this->select("{$this->table}.*, users.nama");
        $this->join("users", "{$this->table}.id_user=users.id");
        $this->where("DATE({$this->table}.created_at) >=", $dari);
        $this->where("DATE({$this->table}.created_at) <=", $sampai);
        $query = $this->get()->getResultObject();
        return $query;
    }
    public function search($keyword)
    {
        return $this->table("{$this->table}")->like('users.nama', $keyword);
    }
}
