<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdmin extends Migration
{
    public function up()
    {
        //
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
            'apikey' => [
                'type' => 'varchar',
                'constraint' => 60,
                'null' => false
            ],
            'email' => [
                'type' => 'varchar',
                'constraint' => '60'
            ],
            'wa' => [
                'type' => 'varchar',
                'constraint' => '15'
            ],
            'password' => [
                'type' => 'varchar',
                'constraint' => '120'
            ],
            'token' => [
                'type' => 'varchar',
                'constraint' => '120'
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
    }

    public function down()
    {
        //
        $this->forge->dropTable('superadmin', true);
    }
}
