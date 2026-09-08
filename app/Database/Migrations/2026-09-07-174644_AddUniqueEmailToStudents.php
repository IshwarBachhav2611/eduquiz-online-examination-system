<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUniqueEmailToStudents extends Migration
{
    public function up()
    {
        // Add UNIQUE constraint to students.email
        $this->db->query(
            "ALTER TABLE students
             ADD UNIQUE KEY unique_student_email (email)"
        );
    }

    public function down()
    {
        // Remove UNIQUE constraint
        $this->db->query(
            "ALTER TABLE students
             DROP INDEX unique_student_email"
        );
    }
}