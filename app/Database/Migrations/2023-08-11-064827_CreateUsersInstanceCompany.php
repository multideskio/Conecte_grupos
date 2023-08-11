<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersInstanceCompany extends Migration
{
    public function up()
    {
        //RELACIONA INSTANCIAS COM USUÁRIOS E EMPRESAS
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
        $this->forge->addForeignKey('id_instance', 'instances', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('instance_user_company', true);
    }

    public function down()
    {
        //
        $this->forge->dropTable('instance_user_company', true);

    }
}
