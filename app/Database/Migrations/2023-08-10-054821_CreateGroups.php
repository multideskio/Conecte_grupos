<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroups extends Migration
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
            'name' => [
                'type' => 'varchar',
                'constraint' => '80',
                'null' => true
            ],
            'description' => [
                'type' => 'varchar',
                'constraint' => '160',
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
        $this->forge->addForeignKey('id_campaign', 'campaigns', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('groups', true);
    }

    public function down()
    {
        //
        $this->forge->dropTable('groups', true);

    }
}
