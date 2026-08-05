<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $allowedFields = [

        'name',
        'organization',
        'designation',
        'email',
        'mobile',
        'password'

    ];

    protected $useTimestamps = true;

    protected $returnType = 'array';
}