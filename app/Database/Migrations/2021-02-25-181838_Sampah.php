<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class sedekah extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'           => [
				'type'              => 'INT',
				'constraint'        => 11,
				'auto_increment'    => TRUE,
			],
			'jenis'         => [
				'type'              => 'VARCHAR',
				'constraint'        => '255',
			],
			'slug'       => [
				'type'              => 'VARCHAR',
				'constraint'        => '255',
			],
			'rupiah'       => [
				'type'              => 'INT',
				'constraint'        => 11,
			],
			'des'       => [
				'type'              => 'VARCHAR',
				'constraint'        => '255',
				'null'              => TRUE,
			],
			'sampul'       => [
				'type'              => 'VARCHAR',
				'constraint'        => '255',
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
		$this->forge->createTable('sedekah');
	}

	public function down()
	{
		//
	}
}
