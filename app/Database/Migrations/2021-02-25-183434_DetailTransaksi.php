<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailTransaksi extends Migration
{
	public function up()
	{
		$this->db->enableForeignKeyChecks();
		$this->forge->addField([
			'id'                => [
				'type'              => 'INT',
				'constraint'        => 11,
				'auto_increment'    => TRUE,
			],
			'id_transaksi'                => [
				'type'              => 'INT',
				'constraint'        => 11,
			],
			'id_realisasi'                => [
				'type'              => 'INT',
				'constraint'        => 11,
			],
			'berat'                => [
				'type'              => 'INT',
				'constraint'        => 11,
			],
			'rupiah'                => [
				'type'              => 'INT',
				'constraint'        => 11,
			],
			'rupiah_total'                => [
				'type'              => 'INT',
				'constraint'        => 11,
			],
			'ket'       => [
				'type'              => 'VARCHAR',
				'constraint'        => '255',
				'null'              => TRUE,
			],
			'created_at'       => [
				'type'              => 'DATETIME',
				'null'              => TRUE,
			],
			'updated_at'       => [
				'type'              => 'DATETIME',
				'null'              => TRUE,
			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addForeignKey('id_transaksi', 'transaksi', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('id_realisasi', 'sedekah', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('detail_transaksi');
	}

	public function down()
	{
		//
	}
}
