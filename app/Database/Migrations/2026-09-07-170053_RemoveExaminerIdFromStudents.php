<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveExaminerIdFromStudents extends Migration
{
    public function up()
    {
        /*
        |--------------------------------------------------------------------------
        | Remove old examiner relationship
        |--------------------------------------------------------------------------
        |
        | Students are now global accounts.
        | The relationship between examiner and student is handled by
        | the examiner_students table.
        |
        */

        // Remove foreign key
        $this->forge->dropForeignKey(
            'students',
            'students_examiner_id_foreign'
        );

        // Remove old unique index
        $this->forge->dropKey(
            'students',
            'unique_examiner_student_email'
        );

        // Remove examiner_id column
        $this->forge->dropColumn(
            'students',
            'examiner_id'
        );
    }

    public function down()
    {
        /*
        |--------------------------------------------------------------------------
        | Restore old examiner relationship
        |--------------------------------------------------------------------------
        */

        $this->forge->addColumn('students', [
            'examiner_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => false,
                'after'      => 'id'
            ]
        ]);

        $this->forge->addKey(
            'students',
            ['examiner_id', 'email'],
            false,
            'unique_examiner_student_email'
        );

        $this->forge->addForeignKey(
            'examiner_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE',
            'students_examiner_id_foreign'
        );
    }
}