<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInstance extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        $db->disableForeignKeyChecks();
        //TABELA DE INSTANCIAS DO SUPER ADMIN COMPARTILHADA COM OS DEMAIS CLIENTES
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
            'name' => [
                'type' => 'varchar',
                'constraint' => '60',
                'null' => true
            ],
            'phone' => [
                'type' => 'varchar',
                'constraint' => '15',
                'null' => true
            ],
            'owner' => [
                'type' => 'varchar',
                'constraint' => '30',
                'null' => true
            ],
            'profile_name' => [
                'type' => 'varchar',
                'constraint' => '60',
                'null' => true
            ],
            'profile_picture_url' => [
                'type' => 'varchar',
                'constraint' => '255',
                'null' => true
            ],
            'profile_status' => [
                'type' => 'varchar',
                'constraint' => '255',
                'null' => true
            ],
            'status' => [
                'type' => 'varchar',
                'constraint' => '60',
                'null' => true
            ],
            'server_url' => [
                'type' => 'varchar',
                'constraint' => '60'
            ],
            'api_key' => [
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
        $this->forge->addForeignKey('id_company', 'companies', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('instances', true);

        $db->enableForeignKeyChecks();

    }

    public function down()
    {
        //
        $this->forge->dropTable('instances', true);
    }
}
