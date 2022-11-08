<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProProvTasks extends Migration
{
    public function up()
    {
        $this->forge->addField([
                        'id'          => [
                                'type'           => 'INT',
                                'auto_increment' => true
                        ],
                        'Participant'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '10',
                        ],
                        'Task1'          => [
                                'type'           => 'INT',
                                'null' => true,
                        ],
                        'Task2'          => [
                                'type'           => 'INT',
                                'null' => true,
                        ],
                        'Task3'          => [
                                'type'           => 'INT',
                                'null' => true,
                        ],
                        'Task4'          => [
                                'type'           => 'INT',
                                'null' => true,
                        ],
                        'Task5'          => [
                                'type'           => 'INT',
                                'null' => true,
                        ],
                        'Task6'          => [
                                'type'           => 'INT',
                                'null' => true,
                        ],
                        'Task7'          => [
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
                $this->forge->createTable('ProProv_Tasks');
    }

    public function down()
    {
        $this->forge->dropTable('ProProv_Tasks');
    }
}
