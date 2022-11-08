<?php

namespace App\Models;

use CodeIgniter\Model;

class DemographicModel extends Model
{
    protected $table      = 'Demographics';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['Participant', 'Gender', 'Age', 'Language', 
                                'Fluency', 'Education', 'Major', 'Ethnicity', 
                                'Race', 'YearsCyS', 'YearsCS', 'YearsCE', 'YearsIT', 
                                'YearsProg', 'SpecifiedPolicy', 'PoliciesWorkedWith', 'SpecifiedPolicyRego'];

    protected $useTimestamps = true;
    protected $createdField  = 'session_start';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}