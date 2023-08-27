<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdmin extends Migration
{
    public function up()
    {

        $db = \Config\Database::connect();
        $db->disableForeignKeyChecks();

        //ADMINISTRADO DO SISTEMA
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => 60,
                'null' => false
            ],
            'url_api_wa' => [
                'type' => 'varchar',
                'constraint' => '60'
            ],
            'api_key_wa' => [
                'type' => 'varchar',
                'constraint' => '60'
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
        $this->forge->createTable('superadmin', true);
        $db->enableForeignKeyChecks();

    }

    public function down()
    {
        //
        $this->forge->dropTable('superadmin', true);
    }
}
