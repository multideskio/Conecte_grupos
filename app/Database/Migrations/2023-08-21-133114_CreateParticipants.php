<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateParticipants extends Migration
{
    public function up()
    {
        //
        $db = \Config\Database::connect();
        $db->disableForeignKeyChecks();
        //
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
            'id_group' => [
                'type' => 'varchar',
                'constraint' => 60
            ],
            'participant' => [
                'type' => 'varchar',
                'constraint' => 50
            ],
            'admin' => [
                'type' => 'varchar',
                'constraint' => 30,
                'null' => true
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
        $this->forge->createTable('participants', true);
        $db->enableForeignKeyChecks();

        
    }

    public function down()
    {
        //
        $this->forge->dropTable('participants', true);
    }
}
