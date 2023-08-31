<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCampaigns extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        $db->disableForeignKeyChecks();
        //CRIAÇÃO DE CAMPANHA
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '80'
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '80'
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 60
            ],
            'time_start' => [
                'type' => 'DATETIME'
            ],
            'time_end' => [
                'type' => 'DATETIME'
            ],
            'automate_creation' => [
                'type' => 'bool',
                'DEFAULT' => false
            ],
            //Config Page Redirect
            'title_page' => [
                'type' => 'VARCHAR',
                'constraint' => 30
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 120
            ],
            'video' => [
                'type' => 'VARCHAR',
                'constraint' => 60
            ],
            'button' => [
                'type' => 'VARCHAR',
                'constraint' => 30
            ],
            'title_redirect' => [
                'type' => 'VARCHAR',
                'constraint' => 30
            ],
            'desc_search' => [
                'type' => 'VARCHAR',
                'constraint' => 60
            ],
            'title_search' => [
                'type' => 'VARCHAR',
                'constraint' => 60
            ],
            'force_app' => [
                'type' => 'bool',
                'DEFAULT' => false
            ],
            'active' => [
                'type' => 'bool',
                'DEFAULT' => false
            ],
            'protected_group' => [
                'type' => 'bool',
                'DEFAULT' => false
            ],
            //Page waiting
            'external_url' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
                'null' => true
            ],
            'video' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
                'null' => true
            ],
            //Tracking
            'type_tracking' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
                'null' => true
            ],
            'pixel_facebook' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
                'null' => true
            ],
            'event_facebook' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
                'null' => true
            ],
            'google_analytics' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
                'null' => true
            ],
            'tag_manager' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
                'null' => true
            ],
            'ads_google' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
                'null' => true
            ],
            //
            'custom_script' => [
                'type' => 'text',
                'null' => true,
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_company', 'companies', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('campaigns', true);

        $db->enableForeignKeyChecks();

    }

    public function down()
    {
        //
        $this->forge->dropTable('campaigns', true);

    }
}
