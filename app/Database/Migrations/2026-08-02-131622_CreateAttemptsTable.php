<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttemptsTable extends Migration
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
            'started_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'submitted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'score' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 0,
            ],
            'percentage' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0.00,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Started', 'Submitted', 'Auto Submitted'],
                'default'    => 'Started',
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
        $this->forge->addKey('exam_id');
        $this->forge->addKey('student_id');

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

        $this->forge->createTable('attempts');
    }

    public function down()
    {
        $this->forge->dropTable('attempts');
    }
}