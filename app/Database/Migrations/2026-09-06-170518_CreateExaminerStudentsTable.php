<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExaminerStudentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'examiner_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'student_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['examiner_id', 'student_id'], false, true);

        $this->forge->createTable('examiner_students');
    }

    public function down()
    {
        $this->forge->dropTable('examiner_students');
    }
}