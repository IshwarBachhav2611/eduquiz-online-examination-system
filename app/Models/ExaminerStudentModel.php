<?php

namespace App\Models;

use CodeIgniter\Model;

class ExaminerStudentModel extends Model
{
    protected $table = 'examiner_students';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'examiner_id',
        'student_id'
    ];

    protected $useTimestamps = false;

    protected $protectFields = true;

    protected $skipValidation = true;
}