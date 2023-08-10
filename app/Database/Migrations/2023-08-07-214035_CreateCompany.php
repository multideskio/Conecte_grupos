<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCompany extends Migration
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
            'id_admin' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => '40'
            ],
            'company' => [
                'type' => 'varchar',
                'constraint' => '60'
            ],
            'email' => [
                'type' => 'varchar',
                'constraint' => '40'
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
            'logo' => [
                'type' => 'varchar',
                'constraint' => '80'
            ],
            'ico' => [
                'type' => 'varchar',
                'constraint' => '40'
            ],
            'url_api_wa' => [
                'type' => 'varchar',
                'constraint' => '60'
            ],
            'api_key_wa' => [
                'type' => 'varchar',
                'constraint' => '60'
            ],
            'id_chatwoot' => [
                'type' => 'int',
                'constraint' => 1
            ],
            'url_chatwoot' => [
                'type' => 'varchar',
                'constraint' => '60'
            ],
            'api_key_chatwoot' => [
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
        $this->forge->addForeignKey('id_admin', 'superadmin', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('companies', true);
    }

    public function down()
    {
        //
        $this->forge->dropTable('companies', true);

    }
}
