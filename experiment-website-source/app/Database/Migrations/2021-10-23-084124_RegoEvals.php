<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RegoEvals extends Migration
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
                        'Task'          => [
                                'type'           => 'INT',
                                'null' => true,
                        ],
                        'Policy'          => [
                                'type'           => 'TEXT',
                        ],
                        'Correct'          => [
                                'type'           => 'INT',
                                'null' => true,
                        ],
                        'Message'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '100',
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
                $this->forge->createTable('Rego_Evals');
    }

    public function down()
    {
        $this->forge->dropTable('Rego_Evals');
    }
}
