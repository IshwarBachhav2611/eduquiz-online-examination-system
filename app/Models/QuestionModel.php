<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionModel extends Model
{
    protected $table = 'questions';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $protectFields = true;

    protected $allowedFields = [

        'exam_id',

        'question',

        'option_a',

        'option_b',

        'option_c',

        'option_d',

        'correct_option',

        'marks',

    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';

    protected $validationRules = [];

    protected $validationMessages = [];

    protected $skipValidation = false;
}