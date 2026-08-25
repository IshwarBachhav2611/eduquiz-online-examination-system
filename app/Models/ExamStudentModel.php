<?php

namespace App\Models;

use CodeIgniter\Model;

class ExamStudentModel extends Model
{
    protected $table = 'exam_students';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $protectFields = true;

    protected $allowedFields = [
        'exam_id',
        'student_id',
        'assigned_at'
    ];

    protected $useTimestamps = false;

    protected $validationRules = [];

    protected $validationMessages = [];

    protected $skipValidation = false;
}