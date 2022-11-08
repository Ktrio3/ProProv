<?php

namespace App\Models;

use CodeIgniter\Model;

class ParticipantModel extends Model
{
    protected $table      = 'Participants';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id', 'pin', 'verification_code', 
                                'session_end', 'user_agent', 'rego_first',
                                'demographics', 'training_1', 'exercise_1',
                                'training_2', 'exercise_2', 'exit'];

    protected $useTimestamps = true;
    protected $createdField  = 'session_start';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}