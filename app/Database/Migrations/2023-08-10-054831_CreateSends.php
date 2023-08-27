<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSends extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        $db->disableForeignKeyChecks();
        //REGISTRO DE ENVIOS DAS CAMPANHAS
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
            'id_campaign' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'id_group' => [
                'type' => 'varchar',
                'constraint' => '80',
                'null' => false
            ],
            'id_user' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'code' => [
                'type' => 'varchar',
                'constraint' => '80',
                'null' => false
            ],
            'message' => [
                'type' => 'text',
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
        $this->forge->createTable('sends', true);

        $db->enableForeignKeyChecks();

    }

    public function down()
    {
        //
        $this->forge->dropTable('sends', true);
    }
}
