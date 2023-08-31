<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Plans extends Migration
{
    public function up()
    {

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
            'id_user' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'num_instance' => [
                'type' => 'int',
                'constraint' => 2
            ],
            'valid_days' => [
                'type' => 'int',
                'unsigned' => 3
            ],
            'payday' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2'
            ],
            'status' => [
                'type' => 'bool',
                'DEFAULT' => true
            ],
            'size_files' => [
                'type' => 'int',
                'DEFAULT' => 200
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
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('plans', true);
        $db->enableForeignKeyChecks();

        $seeder = \Config\Database::seeder();
        $seeder->call('SuperAdmin');
    }

    public function down()
    {
        ////
        $this->forge->dropTable('plans', true);
    }
}
