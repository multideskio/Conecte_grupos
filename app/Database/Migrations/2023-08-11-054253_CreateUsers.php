<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        $db->disableForeignKeyChecks();
        //Tabel para todos os usuários relacionando e definindo a uma empresa
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
                'constraint' => 60,
                'null' => false
            ],
            'wa_number' => [
                'type' => 'varchar',
                'constraint' => '15'
            ],
            'email' => [
                'type' => 'varchar',
                'constraint' => '60'
            ],
            'level' => [
                'type' => 'varchar',
                'constraint' => 10,
                'null' => false
            ],
            'permission' => [
                'type' => 'int',
                'constraint' => 1,
                'null' => false
            ],
            'status' => [
                'type' => 'bool',
                'DEFAULT' => true
            ],
            'password' => [
                'type' => 'varchar',
                'constraint' => '100'
            ],
            'token' => [
                'type' => 'varchar',
                'constraint' => '100'
            ],
            'image' => [
                'type' => 'varchar',
                'constraint' => '100'
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
        $this->forge->createTable('users', true);

        $db->enableForeignKeyChecks();

    }

    public function down()
    {
        //
        $this->forge->dropTable('users', true);
    }
}
