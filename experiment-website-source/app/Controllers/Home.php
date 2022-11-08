<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('home', ['controls' => false, 'user' => $this->getParticipant()]);
    }

    // public function dump()
    // {
    //     $id = $this->getParticipantID();

    //     $demoModel = new \App\Models\DemographicModel();
    //     $trainModel = new \App\Models\TrainingModel();
    //     $rTasksModel = new \App\Models\Rego_TasksModel();
    //     $rEvalsModel = new \App\Models\Rego_EvalsModel();
    //     $pTasksModel = new \App\Models\ProProv_TasksModel();
    //     $pEvalsModel = new \App\Models\ProProv_EvalsModel();
    //     $eTextModel = new \App\Models\ExitTextModel();
    //     $eScaleModel = new \App\Models\ExitScaleModel();

    //     $data = [
    //         'controls' => false, 
    //         'user' => $this->getParticipant(),
    //         'demo' => $demoModel->where("Participant", $id)->first(),
    //         'train' => $trainModel->where("Participant", $id)->findAll(),
    //         'regoTasks' => $rTasksModel->where("Participant", $id)->findAll(),
    //         'regoEvals' => $rEvalsModel->where("Participant", $id)->findAll(),
    //         'proprovTasks' => $pTasksModel->where("Participant", $id)->findAll(),
    //         'proprovEvals' => $pEvalsModel->where("Participant", $id)->findAll(),
    //         'eText' => $eTextModel->where("Participant", $id)->findAll(),
    //         'eScale' => $eScaleModel->where("Participant", $id)->findAll(),
    //     ];

    //     return view('dump', $data);
    // }
}
