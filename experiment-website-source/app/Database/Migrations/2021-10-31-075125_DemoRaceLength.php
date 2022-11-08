<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DemoRaceLength extends Migration
{
    public function up()
    {
        //
        $fields = [
                'Race' => [
                        'type' => 'VARCHAR',
                        'constraint' => '150',
                        'null' => true
                ],
        ];
        $this->forge->modifyColumn('Demographics', $fields);
    }

    public function down()
    {
        //Don't really care about shrinking it down, so don't.
    }
}
