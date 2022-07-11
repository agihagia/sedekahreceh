<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Backup extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id'           => [
				'type'              => 'INT',
				'constraint'        => 11,
				'auto_increment'    => TRUE,
			],
			'file_name'         => [
				'type'              => 'VARCHAR',
				'constraint'        => '255',
                'null'              => TRUE,
			],
			'file_path'       => [
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
		$this->forge->createTable('backups');
    }

    public function down()
    {
        $this->forge->dropTable('backups');
    }
}
