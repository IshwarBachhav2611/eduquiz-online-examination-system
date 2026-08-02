<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuestionsTable extends Migration
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
            'question' => [
                'type' => 'TEXT',
            ],
            'option_a' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'option_b' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'option_c' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'option_d' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'correct_option' => [
                'type'       => 'ENUM',
                'constraint' => ['A', 'B', 'C', 'D'],
            ],
            'marks' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 1,
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

        $this->forge->addForeignKey(
            'exam_id',
            'exams',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('questions');
    }

    public function down()
    {
        $this->forge->dropTable('questions');
    }
}