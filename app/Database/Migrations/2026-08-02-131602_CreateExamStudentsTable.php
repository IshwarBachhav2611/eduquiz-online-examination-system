<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExamStudentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'exam_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'student_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'assigned_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('exam_id');
        $this->forge->addKey('student_id');
        $this->forge->addUniqueKey(['exam_id', 'student_id']);

        $this->forge->addForeignKey(
            'exam_id',
            'exams',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'student_id',
            'students',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('exam_students');
    }

    public function down()
    {
        $this->forge->dropTable('exam_students');
    }
}