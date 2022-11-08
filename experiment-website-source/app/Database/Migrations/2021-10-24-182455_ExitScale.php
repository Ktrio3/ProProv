<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ExitScale extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
                        'id'          => [
                                'type'           => 'INT',
                                'auto_increment' => true
                        ],
                        'Participant'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '10',
                        ],
                        'Type'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '10',
                                'null' => true,
                        ],
                        'Question'          => [
                                'type'           => 'INT',
                                'null' => true,
                        ],
                        'Score'          => [
                                'type'           => 'INT',
                                'null' => true,
                        ],
                        'inserted_at'          => [
                                'type'           => 'DATETIME',
                                'null' => true,
                        ],
                        'deleted_at'          => [
                                'type'           => 'DATETIME',
                                'null' => true,
                        ],
                        'updated_at'          => [
                                'type'           => 'DATETIME',
                                'null' => true,
                        ],
                ]);
                $this->forge->addKey('id', true, true);
                $this->forge->addForeignKey('Participant','Participants','id');
                $this->forge->createTable('Exit_Scale');
    }

    public function down()
    {
        //
        $this->forge->dropTable('Exit_Scale');
    }
}
