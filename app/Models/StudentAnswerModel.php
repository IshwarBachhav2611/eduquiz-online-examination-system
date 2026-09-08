<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentAnswerModel extends Model
{
    protected $table            = 'student_answers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'attempt_id',
        'question_id',
        'selected_option',
        'is_correct',
        'marks_obtained',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}