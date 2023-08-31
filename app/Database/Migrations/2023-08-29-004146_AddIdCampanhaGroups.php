<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdCampanhaGroups extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('groups', [
            'id_campaigns' => [
                'type' => 'int',
                'unsigned' => true,
                'after' => 'instance',
                'null' => true
            ]
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('groups', 'id_campaigns');
    }
}
