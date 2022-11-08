<?php

namespace App\Models;

use CodeIgniter\Model;

class Rego_TasksModel extends Model
{
    protected $table      = 'Rego_Tasks';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['Participant', "Task1", "Task2", "Task3", "Task4", "Task5", "Task6", "Task7"];

    protected $useTimestamps = true;
    protected $createdField  = 'inserted_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function markComplete($id, $task)
    {
        $result = $this->where("Participant", $id)->first();

        //Check if we should insert first
        if(!$result)
        {
            $this->insert(["Participant" => $id]);
        }

        $column = "Task" . $task;

        $this->where("Participant", $id)->set($column, 1)->update();
    }
}