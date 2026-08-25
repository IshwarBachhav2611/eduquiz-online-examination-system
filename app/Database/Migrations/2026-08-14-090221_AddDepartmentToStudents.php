<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDepartmentToStudents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('students', [

            'department' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'email'
            ]

        ]);
    }


    public function down()
    {
        $this->forge->dropColumn(
            'students',
            'department'
        );
    }
}