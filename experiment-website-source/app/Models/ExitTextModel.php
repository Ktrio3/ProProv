<?php

namespace App\Models;

use CodeIgniter\Model;

class ExitTextModel extends Model
{
    protected $table      = 'Exit_Text';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['Participant', 'Question', 'Answer'];

    protected $useTimestamps = true;
    protected $createdField  = 'inserted_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}