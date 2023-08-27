<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateScheduledCampaigns extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        $db->disableForeignKeyChecks();
        //RELACIONA CAMPANHA COM AGENDAMENTO
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
            'id_scheduled' => [
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
        $this->forge->addForeignKey('id_campaign', 'campaigns', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_scheduled', 'scheduleds', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('scheduled_campaigns', true);

        $db->enableForeignKeyChecks();

    }

    public function down()
    {
        //
        $this->forge->dropTable('scheduled_campaigns', true);

    }
}
