<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInstance extends Migration
{
    public function up()
    {
        //TABELA DE INSTANCIAS DO SUPER ADMIN COMPARTILHADA COM OS DEMAIS CLIENTES
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_superadmin' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => '60'
            ],
            'url_api_wa' => [
                'type' => 'varchar',
                'constraint' => '60'
            ],
            'wa_number' => [
                'type' => 'varchar',
                'constraint' => '15'
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
        $this->forge->addForeignKey('id_superadmin', 'superadmin', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('instances', true);
    }

    public function down()
    {
        //
        $this->forge->dropTable('instances', true);
    }
}
