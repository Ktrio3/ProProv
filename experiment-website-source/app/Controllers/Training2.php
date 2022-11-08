<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Training2 extends BaseController
{
    private function checkTraining2()
    {
        $id = $this->getParticipantID();
        $pModel = new \App\Models\ParticipantModel();

        $result = $pModel->where('id', $id)->first();

        if($result['training_2'] == NULL || $result['training_2'] == 0)
        {
            return false;
        }

        return true;
    }

    private function checkPrevious()
    {
        $pModel = new \App\Models\ParticipantModel();

        $result = $pModel->where('id', $this->getParticipantID())->first();

        if($result["exercise_1"] == NULL || $result["exercise_1"] == 0)
        {
            return false;
        }

        return true;
    }

    public function index()
    {
        if($this->checkTraining2() || !$this->checkPrevious())
        {
            return redirect()->to("");
        }

        $id = $this->getParticipantID();
        $pModel = new \App\Models\ParticipantModel();

        $result = $pModel->where('id', $id)->first();

        $type = "rego";
        if($result['rego_first'] == 1)
        {
            $type = "proprov";
        }

        return view('training-home', ['controls' => false, 'user' => $this->getParticipant(), 'num' => 2, 'type' => $type]);
    }

    public function training($num)
    {
        if($this->checkTraining2() || !$this->checkPrevious())
        {
            return redirect()->to("");
        }

        $id = $this->getParticipantID();
        $pModel = new \App\Models\ParticipantModel();

        $result = $pModel->where('id', $id)->first();

        $type = "rego";
        if($result['rego_first'] == 1)
        {
            $type = "proprov";
        }
        $next = "";

        $tModel = new \App\Models\TrainingModel();

        $result = $tModel->where('Participant', $id)->where('Type', $type)->first();

        if(!$result)
        {
            //Insert
            $data = [
                'Participant' => $id,
                'Type' => $type
            ];
            $tModel->insert($data);
            $result = $tModel->where('Participant', $id)->where('Type', $type)->first();
        }

        $start = $result["session_start"];

        return view('training', ['controls' => true, 'user' => $this->getParticipant(), 'num' => 2, 'type' => $type, 'start'=>$start, 'next'=>$next]);
    }

    public function save()
    {
        if($this->checkTraining2() || !$this->checkPrevious())
        {
            return "fail";
        }

        $id = $this->getParticipantID();

        $type = $this->request->getPost("type");

        $tModel = new \App\Models\TrainingModel();

        $result = $tModel->where('Participant', $id)->where('Type', $type)->first();
        
        if(!$result)
        {
            return "fail";
        }

        $now = new Time('now', 'America/New_York');

        $start = Time::createFromFormat('Y-m-d H:i:s', $result["session_start"], 'America/New_York');

        if($type == "prov"){
            $length = getenv("provLength");  //Wait at least 3 minutes and 45 second
        }
        else if($type == "proprov"){
            $length = getenv("proProvLength");
        }
        else{
            $length = getenv("regoLength");
        }

        $end = $start->addSeconds($length);

        if ($now > $end) {
            //Set this as completed
            $tModel->where('Participant', $this->getParticipantID())
                ->where('Type', $type)
                ->set('session_end', $now->toDateTimeString())
                ->update();
        }
        else{
            //Still need to watch
            return "fail";
        }

        //Check if we are done
        $result = $tModel->where('Participant', $id)->where('session_end is NOT NULL', NULL, FALSE)->findAll();
        //print_r($result);die();
        if(count($result) >= 3)
        {
            //Done with training
            $pModel = new \App\Models\ParticipantModel();

            //Update
            $pModel->where('id', $this->getParticipantID())
            ->set(["training_2" => 1])
            ->update();
        }
        return "success";
    }
}
