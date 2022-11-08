<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Participants extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
                        'id'          => [
                                'type'           => 'VARCHAR',
                                'constraint'     => '10',
                        ],
                        'session_start'          => [
                                'type'           => 'DATETIME',
                                'null' => true,
                        ],
                        'session_end'          => [
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
                        'pin'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '4',
                                'null' => true,
                        ],
                        'verification_code'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '45',
                                'null' => true,
                        ],
                        'user_agent'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '105',
                                'null' => true,
                        ],
                        'rego_first'          => [
                                'type'           => 'TINYINT',
                                'constraint' => '1',
                                'default' => 0,
                        ],
                        'demographics'          => [
                                'type'           => 'TINYINT',
                                'constraint' => '1',
                                'default' => 0,
                        ],
                        'training_1'          => [
                                'type'           => 'TINYINT',
                                'constraint' => '1',
                                'default' => 0,
                        ],
                        'exercise_1'          => [
                                'type'           => 'TINYINT',
                                'constraint' => '1',
                                'default' => 0,
                        ],
                        'training_2'          => [
                                'type'           => 'TINYINT',
                                'constraint' => '1',
                                'default' => 0,
                        ],
                        'exercise_2'          => [
                                'type'           => 'TINYINT',
                                'constraint' => '1',
                                'default' => 0,
                        ],
                        'exit'          => [
                                'type'           => 'TINYINT',
                                'constraint' => '1',
                                'default' => 0,
                        ],
                ]);
                $this->forge->addKey('id', true, true);
                $this->forge->createTable('Participants');
    }

    public function down()
    {
        //
        $this->forge->dropTable('Participants');
    }
}