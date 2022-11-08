<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Training1 extends BaseController
{
    private function checkTraining1()
    {
        $id = $this->getParticipantID();
        $pModel = new \App\Models\ParticipantModel();

        $result = $pModel->where('id', $id)->first();

        if($result['training_1'] == NULL || $result['training_1'] == 0)
        {
            return false;
        }

        return true;
    }

    private function checkVideo($type)
    {
        $tModel = new \App\Models\TrainingModel();
        $result = $tModel->where('Participant', $this->getParticipantID())
                ->where('session_end is NOT NULL', NULL, FALSE)->findAll();

        if(!$result && $type != "prov")
        {
            //None done, go to video 1
            return redirect()->to("training-1/1");
        }

        if(count($result) == 1 && $type == "prov")
        {
            //Did prov already, go to part 2
            return redirect()->to("training-1/2");
        }

        if(count($result) > 1)
        {
            //Done
            return redirect()->to("");
        }

        return;
    }

    private function checkPrevious()
    {
        $pModel = new \App\Models\ParticipantModel();

        $result = $pModel->where('id', $this->getParticipantID())->first();

        if($result["demographics"] == NULL || $result["demographics"] == 0)
        {
            return false;
        }

        return true;
    }

    public function index()
    {
        if($this->checkTraining1() || !$this->checkPrevious())
        {
            return redirect()->to("");
        }

        $id = $this->getParticipantID();
        $pModel = new \App\Models\ParticipantModel();

        $result = $pModel->where('id', $id)->first();

        $type = "proprov";
        if($result['rego_first'] == 1)
        {
            $type = "rego";
        }

        return view('training-home', ['controls' => false, 'user' => $this->getParticipant(), 'num' => 1, 'type' => $type]);
    }

    //Uncomment to allow testing videos by bypassing login requirement
    // public function bypass()
    // {
    //     $type = $this->request->getGet("type");

    //     $start = "2021-11-01 11:19:46";

    //     $pModel = new \App\Models\ParticipantModel();
    //     $user = $pModel->find("S74376");

    //     return view('training', ['controls' => false, 'user' => $this->getParticipant(), 'num' => 1, 'type' => $type, 'start'=>$start, 'next'=>""]);
    // }

    public function training($num)
    {
        if($this->checkTraining1() || !$this->checkPrevious())
        {
            return redirect()->to("");
        }

        $id = $this->getParticipantID();
        $pModel = new \App\Models\ParticipantModel();

        $result = $pModel->where('id', $id)->first();

        if($num == "1"){
            $type = "prov";
            $next = "training-1/2";
        }
        else if($num == "2"){
            $type = "proprov";
            if($result['rego_first'] == 1)
            {
                $type = "rego";
            }
            $next = "";
        }else{
            return redirect()->to("training-1");
        }

        $check = $this->checkVideo($type);

        if($check)
        {
            return $check;
        }

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

        return view('training', ['controls' => true, 'user' => $this->getParticipant(), 'num' => 1, 'type' => $type, 'start'=>$start, 'next'=>$next]);
    }

    public function save()
    {
        if($this->checkTraining1() || !$this->checkPrevious())
        {
            return redirect()->to("");
        }

        $id = $this->getParticipantID();

        $type = $this->request->getPost("type");

        $check = $this->checkVideo($type);

        if($check)
        {
            return "fail";
        }

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
        if(count($result) >= 2)
        {
            //Done with training
            $pModel = new \App\Models\ParticipantModel();

            //Update
            $pModel->where('id', $this->getParticipantID())
            ->set(["training_1" => 1])
            ->update();
        }
        return "success";
    }
}
