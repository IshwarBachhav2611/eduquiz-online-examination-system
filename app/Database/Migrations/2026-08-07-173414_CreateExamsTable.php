<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExamsTable extends Migration
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

            'examiner_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'subject' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'instructions' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'duration' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],

            'total_marks' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],

            'passing_marks' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],

            'max_attempts' => [
                'type'       => 'INT',
                'constraint' => 2,
                'default'    => 1,
            ],

            'negative_marking' => [
                'type'       => 'ENUM',
                'constraint' => ['Yes', 'No'],
                'default'    => 'No',
            ],

            'exam_date' => [
                'type' => 'DATE',
            ],

            'start_time' => [
                'type' => 'TIME',
            ],

            'end_time' => [
                'type' => 'TIME',
            ],

            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Draft', 'Published'],
                'default'    => 'Draft',
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
        $this->forge->addKey('examiner_id');

        // Uncomment this if you have a users table and examiner_id
        // should reference users.id
        /*
        $this->forge->addForeignKey(
            'examiner_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );
        */

        $this->forge->createTable('exams');
    }

    public function down()
    {
        $this->forge->dropTable('exams');
    }
}