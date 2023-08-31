<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableFiles extends Migration
{
    public function up()
    {
        //
        $db = \Config\Database::connect();
        $db->disableForeignKeyChecks();

        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'Primary key',
            ],
            'id_company' => [
                'type' => 'int',
                'unsigned' => true,
                'comment' => 'Foreign key to companies table',
            ],
            'title' => [
                'type' => 'varchar',
                'constraint' => 60,
                'comment' => 'Title file',
            ],
            'description' => [
                'type' => 'varchar',
                'constraint' => 60,
                'comment' => 'Description file',
            ],
            'slug' => [
                'type' => 'varchar',
                'constraint' => 120,
                'comment' => 'Slug file',
            ],
            'meta' => [
                'type' => 'text',
                'comment' => 'Meta json file',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Record creation timestamp',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Record update timestamp',
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Record deletion timestamp',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_company', 'companies', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('files', true);
        $db->enableForeignKeyChecks();
    }

    public function down()
    {
        //
        $this->forge->dropTable('files', true);
    }
}
