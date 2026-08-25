<?php

namespace App\Models;

use CodeIgniter\Model;

class ExamModel extends Model
{
    protected $table            = 'exams';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'examiner_id',
        'title',
        'subject',
        'description',
        'instructions',
        'duration',
        'total_marks',
        'passing_marks',
        'max_attempts',
        'negative_marking',
        'exam_date',
        'start_time',
        'end_time',
        'status'
    ];

    /*
    |--------------------------------------------------------------------------
    | Timestamps
    |--------------------------------------------------------------------------
    */

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /*
    |--------------------------------------------------------------------------
    | Validation Rules
    |--------------------------------------------------------------------------
    */

    protected $validationRules = [

        'title' => 'required|min_length[3]|max_length[255]',

        'subject' => 'required|max_length[150]',

        'duration' => 'required|integer|greater_than[0]',

        'total_marks' => 'required|integer|greater_than[0]',

        'passing_marks' => 'required|integer|greater_than_equal_to[0]',

        'exam_date' => 'required',

        'start_time' => 'required',

        'end_time' => 'required'
    ];

    protected $validationMessages = [

        'title' => [
            'required' => 'Exam title is required.',
            'min_length' => 'Exam title must contain at least 3 characters.'
        ],

        'subject' => [
            'required' => 'Subject is required.'
        ],

        'duration' => [
            'required' => 'Duration is required.',
            'greater_than' => 'Duration must be greater than 0.'
        ],

        'total_marks' => [
            'required' => 'Total marks is required.',
            'greater_than' => 'Total marks must be greater than 0.'
        ],

        'passing_marks' => [
            'required' => 'Passing marks is required.'
        ],

        'exam_date' => [
            'required' => 'Exam date is required.'
        ],

        'start_time' => [
            'required' => 'Start time is required.'
        ],

        'end_time' => [
            'required' => 'End time is required.'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /*
    |--------------------------------------------------------------------------
    | Other Settings
    |--------------------------------------------------------------------------
    */

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    /*
    |--------------------------------------------------------------------------
    | Callbacks
    |--------------------------------------------------------------------------
    */

    protected $allowCallbacks = true;

    protected $beforeInsert = [];
    protected $afterInsert  = [];

    protected $beforeUpdate = [];
    protected $afterUpdate  = [];

    protected $beforeFind = [];
    protected $afterFind  = [];

    protected $beforeDelete = [];
    protected $afterDelete  = [];
}