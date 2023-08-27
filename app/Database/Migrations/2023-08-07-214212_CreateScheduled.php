<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateScheduled extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        $db->disableForeignKeyChecks();
        //AGENDAMENTOS
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_company' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'id_user' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'id_instance' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => 40
            ],
            'message' => [
                'type' => 'text',
                'null' => false
            ],
            'archive' => [
                'type' => 'varchar',
                'constraint' => '140',
                'null' => true
            ],
            'senders' => [
                'type' => 'text',
                'null' => false
            ],
            'everyone' => [
                'type'    => 'BOOLEAN',
                'DEFAULT' => false
            ],
            'start' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'status' => [
                'type'    => 'BOOLEAN',
                'DEFAULT' => false
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_company', 'companies', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('scheduleds', true);
        $db->enableForeignKeyChecks();

    }

    public function down()
    {
        //
        $this->forge->dropTable('scheduleds', true);

    }
}
