<?php

namespace App\Models;

use CodeIgniter\Model;

class SedekahModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'realisasi';
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

    public function getsedekah($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }
        return $this->where(['slug' => $slug])->first();
    }

    public function get_data_sedekah()
    {
        return $this->findAll();
    }

    public function search($keyword)
    {
        return $this->table('realisasi')->like('jenis', $keyword);
    }

    public function loadmoresedekah($id = "", $limit = false)
    {
        $this->select("{$this->table}.*");
        if (!empty($id)) {
            $this->where("{$this->table}.id >", $id);
        }
        $this->orderBy("{$this->table}.id", "ASC");
        $query = $this->asObject()->findAll($limit);
        return $query;
    }

    public function countLoadmoresedekah($id = false)
    {
        $this->select("{$this->table}.*");
        $this->where("{$this->table}.id >", $id);
        $this->orderBy("{$this->table}.id", "ASC");
        $query = $this->countAllResults();
        return $query;
    }
}
