<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Faqs extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id'           => [
				'type'              => 'INT',
				'constraint'        => 11,
				'auto_increment'    => TRUE,
			],
			'pertanyaan'         => [
				'type'              => 'VARCHAR',
				'constraint'        => '255',
			],
			'jawaban'       => [
				'type'              => 'TEXT',
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
		$this->forge->createTable('faqs');
    }

    public function down()
    {
        $this->forge->dropTable('faqs');
    }
}
