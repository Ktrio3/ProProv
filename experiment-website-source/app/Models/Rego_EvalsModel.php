<?php

namespace App\Models;

use CodeIgniter\Model;

class Rego_EvalsModel extends Model
{
    protected $table      = 'Rego_Evals';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['Participant', "Task", "Policy", 'Correct', 'Message'];

    protected $useTimestamps = true;
    protected $createdField  = 'inserted_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getFirstSubmissionTime($id, $task)
    {
        $result = $this->where("Participant", $id)->where("Task", $task)->orderBy("inserted_at", "asc")->first();

        if($result){
            return $result["inserted_at"];
        }else{
            return null;
        }

    }

    public function hasBeenCorrect($id, $task)
    {
        $result = $this->where("Participant", $id)->where("Task", $task)->where("Correct", 1)->first();

        if($result)
        {
            return true;
        }
        return false;
    }
}