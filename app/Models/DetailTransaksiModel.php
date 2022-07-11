<?php

namespace App\Models;



use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table      = 'detail_transaksi';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['id_transaksi', 'id_realisasi', 'berat', 'rupiah', 'rupiah_total', 'ket'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function __construct()
    {
        $this->builder($this->table);
    }

    public function tambahDetail($data)
    {
        foreach ($data['detail'] as $d) {
            $this->insert([
                'id_transaksi' => $data['id_transaksi'],
                'id_realisasi' => $d['id_realisasi'],
                'berat' => $d['qty'],
                'rupiah' => $d['rupiah'],
                'rupiah_total' => $d['rupiah_total']
            ]);
        }
    }
    
    public function getDetail($id_tr)
    {
        return $this->db->table($this->table)
            ->select(['detail_transaksi.*', 'realisasi.jenis'])
            ->join('realisasi', 'realisasi.id=detail_transaksi.id_realisasi')
            ->where('detail_transaksi.id_transaksi', $id_tr)
            ->get()->getResultObject();
    }
}
