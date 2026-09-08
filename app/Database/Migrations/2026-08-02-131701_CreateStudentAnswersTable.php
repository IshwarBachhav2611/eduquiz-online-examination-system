<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentAnswersTable extends Migration
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
            'attempt_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'question_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'selected_option' => [
                'type'       => 'ENUM',
                'constraint' => ['A', 'B', 'C', 'D'],
                'null'       => true,
            ],
            'is_correct' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'marks_obtained' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('attempt_id');
        $this->forge->addKey('question_id');

        $this->forge->addForeignKey(
            'attempt_id',
            'attempts',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'question_id',
            'questions',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('student_answers');
    }

    public function down()
    {
        $this->forge->dropTable('student_answers');
    }
}