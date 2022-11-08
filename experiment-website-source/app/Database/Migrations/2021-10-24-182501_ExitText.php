<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ExitText extends Migration
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
                'Question'          => [
                        'type'           => 'INT',
                        'null' => true,
                ],
                'Answer'          => [
                        'type'           => 'TEXT',
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
        $this->forge->createTable('Exit_Text');
    }

    public function down()
    {
        //
        $this->forge->dropTable('Exit_Text');
    }
}
