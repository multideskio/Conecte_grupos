<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroups extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        $db->disableForeignKeyChecks();
        //CRIAÇÃO DE GRUPOS
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_group' => [
                'type' => 'varchar',
                'constraint' => 60,
                'null' => false
            ],
            'instance' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'subject' => [
                'type' => 'varchar',
                'constraint' => 60,
                'null' => true
            ],
            'subject_owner' => [
                'type' => 'varchar',
                'constraint' => 30,
                'null' => true
            ],
            'subject_time' => [
                'type' => 'varchar',
                'constraint' => 20,
                'null' => true
            ],
            'size' => [
                'type' => 'varchar',
                'constraint' => 20,
                'null' => true
            ],
            'creation' => [
                'type' => 'varchar',
                'constraint' => 20,
                'null' => true
            ],
            'owner' => [
                'type' => 'varchar',
                'constraint' => 30,
                'null' => true
            ],
            'desc' => [
                'type' => 'varchar',
                'constraint' => '255',
                'null' => true
            ],
            'desc_id' => [
                'type' => 'varchar',
                'constraint' => '255',
                'null' => true
            ],
            'restrict' => [
                'type' => 'bool',
                'DEFAULT' => true
            ],
            'announce' => [
                'type' => 'bool',
                'DEFAULT' => true
            ],
            'image' => [
                'type' => 'varchar',
                'constraint' => '255',
                'null' => true
            ],
            'system_create' => [
                'type' => 'bool',
                'DEFAULT' => false
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
        $this->forge->addForeignKey('instance', 'instances', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('groups', true);

        $db->enableForeignKeyChecks();

    }

    public function down()
    {
        //
        $this->forge->dropTable('groups', true);

    }
}
