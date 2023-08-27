<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogsGroups extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        $db->disableForeignKeyChecks();

        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'Primary key',
            ],
            'id_campaign' => [
                'type' => 'int',
                'unsigned' => true,
                'comment' => 'Foreign key to campaign table',
            ],
            'id_company' => [
                'type' => 'int',
                'unsigned' => true,
                'comment' => 'Foreign key to companies table',
            ],
            'id_instance' => [
                'type' => 'int',
                'unsigned' => true,
                'comment' => 'Foreign key to instances table',
            ],
            'id_group' => [
                'type' => 'varchar',
                'constraint' => 60,
                'comment' => 'Group identifier',
            ],
            'event' => [
                'type' => 'varchar',
                'constraint' => 60,
                'comment' => 'Event name',
            ],
            'action' => [
                'type' => 'varchar',
                'constraint' => 60,
                'comment' => 'Action name',
            ],
            'participants' => [
                'type' => 'text',
                'comment' => 'List of participants',
            ],
            "payload" => [
                "type" => "text",
                'comment' => 'Payload complet',
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
        $this->forge->createTable('logs_groups', true);

        $this->db->query("ALTER TABLE logs_groups COMMENT = 'Log table for reporting'");
        $db->enableForeignKeyChecks();

    }

    public function down()
    {
        $this->forge->dropTable('logs_groups', true);
    }
}
