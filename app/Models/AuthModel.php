<?php

namespace App\Models;



use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
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

    function get_data_login($username, $tbl)
    {
        $builder = $this->db->table($tbl);
        $builder->where('username', $username);
        $log = $builder->get()->getRow();
        return $log;
    }

    public function getakun($username = false)
    {
        if ($username == false) {
            return $this->findAll();
        }
        return $this->where(['username' => $username])->first();
    }

    public function search($keyword)
    {
        return $this->table('users')->like('nama', $keyword);
    }

    public function getById($id)
    {
        // return $this->where(['id' => $id]);
        return $this->find($id);
    }
    public function tambahSaldo($id, $nominal)
    {
        $user = (object)$this->find($id);
        $saldo = $user->saldo;
        //tambahkan saldo
        $tambah = $saldo + $nominal;
        //lakukan update
        $this->update($id, ['saldo' => $tambah]);
        return true;
    }
    public function tarikSaldo($id, $nominal)
    {
        $user = (object)$this->find($id);
        $saldo = $user->saldo;
        //tambahkan saldo
        $penarikan = $saldo - $nominal;
        //lakukan update
        $this->update($id, ['saldo' => $penarikan]);
        return true;
    }
}
