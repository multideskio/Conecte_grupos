<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCompanyGroup extends Migration
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
            'id_group' => [
                'type' => 'varchar',
                'constraint' => 60
            ],
            'id_company' => [
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
        $this->forge->createTable('company_groups', true);
    }

    public function down()
    {
        //
        $this->forge->dropTable('company_groups', true);

    }
}
