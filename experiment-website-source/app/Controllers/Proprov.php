<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Proprov extends BaseController
{
    private function checkProProv()
    {
        $pModel = new \App\Models\ParticipantModel();

        $result = $pModel->where('id', $this->getParticipantID())->first();

        $user = $this->getParticipant();

        if($user['rego_first'] == 1)
        {
            $column = "exercise_2";
        }
        else{
            $column = "exercise_1";   
        }

        if($result[$column] == NULL || $result[$column] == 0)
        {
            return false;
        }

        return true;
    }

    private function checkPrevious()
    {
        $pModel = new \App\Models\ParticipantModel();

        $result = $pModel->where('id', $this->getParticipantID())->first();

        $user = $this->getParticipant();

        if($user['rego_first'] == 1)
        {
            $column = "training_2";
        }
        else{
            $column = "training_1";   
        }

        if($result[$column] == NULL || $result[$column] == 0)
        {
            return false;
        }

        return true;
    }

    private function checkCompleted($task)
    {
        if(!$this->checkPrevious())
        {
            //Redirect
            return redirect()->to("");
        }

        if($this->checkProProv())
        {
            return redirect()->to("");
        }

        if($task < 1 || $task > 7)
        {
            return redirect()->to('proprov');
        }

        $tModel = new \App\Models\ProProv_TasksModel();

        $data = $tModel->where("Participant", $this->getParticipantID())->first();

        if(!$data && $task == 1)
        {
            return; //Allow through
        }
        else if(!$data && $task != 1)
        {
            return redirect()->to('proprov/1');
        }

        //Find the first unfinished item
        for($i = 1; $i < 8; $i++)
        {
            if($data["Task" . strval($i)] != 1)
            {
                break;
            }
        }

        if($i == $task)
        {
            //Asking for the right task, allow them to continue
            return;
        }
        else if($i < 8){
            //Send them to the question they should be at
            return redirect()->to('proprov/' . strval($i));
        }

        //Must have requested an invalid batch number, send home
        return redirect()->to("");
    }

    public function index()
    {
        if(!$this->checkPrevious())
        {
            //Redirect to step 5
            return redirect()->to("");
        }

        if($this->checkProProv())
        {
            return redirect()->to("");
        }

        return view('proprov-home', ['controls' => false, 'user' => $this->getParticipant()]);
    }

    public function task($task)
    {
        if($task < 1 || $task > 7)
        {
            return redirect()->to('proprov');
        }

        $check = $this->checkCompleted($task);

        if($check)
        {
            return $check;
        }

        //Add an empty policy to mark beginning (don't want to redesign database) 
        $data = [
            "Participant" => $this->getParticipantID(),
            "Task" => $task,
            "Policy" => "",
            "Correct" => 0,
            "Message" => "Start"
        ];

        //Don't save multiple versions of the same policy
        $PEModel = new \App\Models\ProProv_EvalsModel();
        $previous = $PEModel->where("Participant", $this->getParticipantID())
                ->where("Task", $task)
                ->where("Policy", "")
                ->first();
        if(!$previous)
        {
            $PEModel->insert($data);
        }

        if($task < 7)
        {
            $next = "proprov/" . ($task + 1);
        }
        else
        {
            //Task 7 should be sent to next step
            $next = "";
        }

        return view('proprov', ['controls' => true, 'user' => $this->getParticipant(), 'task' => $task, 'next' => $next]);
    }

    public function check()
    {
        //Check that they've 

        $task = $this->request->getPost('task');

        if($task < 1 || $task > 7)
        {
            return "Invalid task number";
        }

        $check = $this->checkCompleted($task);

        if($check)
        {
            return "Task already completed";  //Ignore the request
        }

        $PEModel = new \App\Models\ProProv_EvalsModel();

        $correct = $PEModel->hasBeenCorrect($this->getParticipantID(), $task);

        if($correct)
        {
            $tModel = new \App\Models\ProProv_TasksModel();
            $tModel->markComplete($this->getParticipantID(), $task);

            if($task == 7)
            {
                //Mark whole section as done
                $user = $this->getParticipant();
                if($user['rego_first'] == 1)
                {
                    $column = "exercise_2";
                }
                else{
                    $column = "exercise_1";   
                }
                $pModel = new \App\Models\ParticipantModel();
                $pModel->where("id", $this->getParticipantID())->set($column, 1)->update();
            }

            return "success";
        }

        $now = new Time('now', 'America/New_York');

        $beginTime = $PEModel->getFirstSubmissionTime($this->getParticipantID(), $task);

        if($beginTime == null)
        {
            return "For now please keep trying to create a correct policy";
        }

        $start = Time::createFromFormat('Y-m-d H:i:s', $beginTime, 'America/New_York');

        $length = getenv("attemptTime");

        $end = $start->addSeconds($length);

        if ($now > $end) {
            $tModel = new \App\Models\ProProv_TasksModel();
            $tModel->markComplete($this->getParticipantID(), $task);

            if($task == 7)
            {
                //Mark whole section as done
                $user = $this->getParticipant();
                if($user['rego_first'] == 1)
                {
                    $column = "exercise_2";
                }
                else{
                    $column = "exercise_1";   
                }
                $pModel = new \App\Models\ParticipantModel();
                $pModel->where("id", $this->getParticipantID())->set($column, 1)->update();
            }

            return "success";
        }

        return "For now please keep trying to create a correct policy";
    }

    public function checkTime()
    {
        $task = $this->request->getPost('task');

        $check = $this->checkCompleted($task);

        if($check)
        {
            return "Task already completed";  //Ignore the request
        }

        $now = new Time('now', 'America/New_York');

        $PEModel = new \App\Models\ProProv_EvalsModel();
        $beginTime = $PEModel->getFirstSubmissionTime($this->getParticipantID(), $task);

        if($beginTime == null)
        {
            return "";
        }

        $start = Time::createFromFormat('Y-m-d H:i:s', $beginTime, 'America/New_York');

        $length = getenv("attemptTime");

        $canStop = $start->addSeconds($length);

        if($task > 4)
        {
            $length = getenv("hardMaxTime");
        }
        else
        {
            $length = getenv("easyMaxTime");
        }


        $mustStop = $start->addSeconds($length);

        if ($now > $mustStop) {
            //Mark them as done

            $tModel = new \App\Models\ProProv_TasksModel();
            $tModel->markComplete($this->getParticipantID(), $task);

            if($task == 7)
            {
                //Mark whole section as done
                $user = $this->getParticipant();
                if($user['rego_first'] == 1)
                {
                    $column = "exercise_2";
                }
                else{
                    $column = "exercise_1";   
                }
                $pModel = new \App\Models\ParticipantModel();
                $pModel->where("id", $this->getParticipantID())->set($column, 1)->update();
            }

            return "max";
        }

        if ($now > $canStop) {
            return "min";
        }

        return "";
    }

    public function run($task)
    {
        if($task < 1 || $task > 7)
        {
            return "";  //Return nothing on error
        }

        $check = $this->checkCompleted($task);

        if($check)
        {
            return "Task already completed";  //Ignore the request
        }

        $policy = $this->request->getPost('policy');

        if($policy === null)
        {
            return "";
        }

        //Write the policy to a temp file
        $tmpfname = tempnam("/tmp", "proprov");

        rename($tmpfname, $tmpfname .= '.json');

        $handle = fopen($tmpfname, "w");
        fwrite($handle, $policy);
        fclose($handle);

        //Run the policy evaluator
        $java = getenv("java"); 
        $result = shell_exec($java . " -jar ../experiments-proprov.jar " . $task . " " . $tmpfname);

        $PEModel = new \App\Models\ProProv_EvalsModel();

        if(substr($result, 0, 7) === "Correct")
        {
            $correct = 1;
        }
        else{
            $correct = 0;
        }

        if($correct == 1){
            $tModel = new \App\Models\ProProv_TasksModel();
            $tModel->markComplete($this->getParticipantID(), $task);

            if($task == 7)
            {
                //Mark whole section as done
                $user = $this->getParticipant();
                if($user['rego_first'] == 1)
                {
                    $column = "exercise_2";
                }
                else{
                    $column = "exercise_1";   
                }
                $pModel = new \App\Models\ParticipantModel();
                $pModel->where("id", $this->getParticipantID())->set($column, 1)->update();
            }
        }

        //Save the policy and result
        $data = [
            "Participant" => $this->getParticipantID(),
            "Task" => $task,
            "Policy" => $policy,
            "Correct" => $correct,
            "Message" => $result
        ];

        //Don't save multiple versions of the same policy
        $previous = $PEModel->where("Participant", $this->getParticipantID())
                ->where("Task", $task)
                ->where("Policy", $policy)
                ->first();
        if(!$previous)
        {
            $PEModel->insert($data);
        }

        return($result);
    }
}
