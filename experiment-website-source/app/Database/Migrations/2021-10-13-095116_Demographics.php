<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Demographics extends Migration
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
                        'Gender'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '20',
                                'null' => true,
                        ],
                        'Age'          => [
                                'type'           => 'INT',
                                'null' => true,
                        ],
                        'Language'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '10',
                                'null' => true,
                        ],
                        'Fluency'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '20',
                                'null' => true,
                        ],
                        'Education'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '20',
                                'null' => true,
                        ],
                        'Major'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '20',
                                'null' => true,
                        ],
                        'Ethnicity'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '30',
                                'null' => true,
                        ],
                        'Race'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '50',
                                'null' => true,
                        ],
                        'YearsCyS'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '30',
                                'null' => true,
                        ],
                        'YearsCS'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '30',
                                'null' => true,
                        ],
                        'YearsCE'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '30',
                                'null' => true,
                        ],
                        'YearsIT'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '30',
                                'null' => true,
                        ],
                        'YearsProg'          => [
                                'type'           => 'VARCHAR',
                                'constraint' => '30',
                                'null' => true,
                        ],
                        'SpecifiedPolicy'           => [
                                'type'           => 'INT',
                                'null' => true,
                        ],
                        'PoliciesWorkedWith'          => [
                                'type'           => 'TEXT',
                                'null' => true,
                        ],
                        'SpecifiedPolicyRego'          => [
                                'type'           => 'INT',
                                'null' => true,
                        ],
                        'session_start'          => [
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
                $this->forge->createTable('Demographics');
    }

    public function down()
    {
        //
        $this->forge->dropTable('Demographics');
    }
}
