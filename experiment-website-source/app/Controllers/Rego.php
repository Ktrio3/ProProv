<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;

class Rego extends BaseController
{

    private function checkRego()
    {
        $pModel = new \App\Models\ParticipantModel();

        $result = $pModel->where('id', $this->getParticipantID())->first();

        $user = $this->getParticipant();

        if($user['rego_first'] == 1)
        {
            $column = "exercise_1";
        }
        else{
            $column = "exercise_2";   
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
            $column = "training_1";
        }
        else{
            $column = "training_2";   
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
            //Redirect to step 5
            return redirect()->to("");
        }

        if($this->checkRego())
        {
            return redirect()->to("");
        }

        if($task < 1 || $task > 7)
        {
            return redirect()->to('rego');
        }

        $tModel = new \App\Models\Rego_TasksModel();

        $data = $tModel->where("Participant", $this->getParticipantID())->first();

        if(!$data && $task == 1)
        {
            return; //Allow through
        }
        else if(!$data && $task != 1)
        {
            return redirect()->to('rego/1');
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
            return redirect()->to('rego/' . strval($i));
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

        if($this->checkRego())
        {
            return redirect()->to("");
        }

        return view('rego-home', ['controls' => false, 'user' => $this->getParticipant()]);
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
        $REModel = new \App\Models\Rego_EvalsModel();
        $previous = $REModel->where("Participant", $this->getParticipantID())
                ->where("Task", $task)
                ->where("Policy", "")
                ->first();
        if(!$previous)
        {
            $REModel->insert($data);
        }

        if($task < 7)
        {
            $next = "rego/" . ($task + 1);
        }
        else
        {
            //Task 7 should be sent to next step
            $next = "";
        }

        return view('rego', ['controls' => true, 'user' => $this->getParticipant(), 'task' => $task, 'next' => $next]);
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

        $REModel = new \App\Models\Rego_EvalsModel();

        $correct = $REModel->hasBeenCorrect($this->getParticipantID(), $task);

        if($correct)
        {
            $tModel = new \App\Models\Rego_TasksModel();
            $tModel->markComplete($this->getParticipantID(), $task);

            if($task == 7)
            {
                //Mark whole section as done
                $user = $this->getParticipant();
                if($user['rego_first'] == 1)
                {
                    $column = "exercise_1";
                }
                else{
                    $column = "exercise_2";   
                }
                $pModel = new \App\Models\ParticipantModel();
                $pModel->where("id", $this->getParticipantID())->set($column, 1)->update();
            }

            return "success";
        }

        $now = new Time('now', 'America/New_York');

        $beginTime = $REModel->getFirstSubmissionTime($this->getParticipantID(), $task);

        if($beginTime == null)
        {
            return "For now please keep trying to create a correct policy";
        }

        $start = Time::createFromFormat('Y-m-d H:i:s', $beginTime, 'America/New_York');

        $length = getenv("attemptTime");

        $end = $start->addSeconds($length);

        if ($now > $end) {
            $tModel = new \App\Models\Rego_TasksModel();
            $tModel->markComplete($this->getParticipantID(), $task);

            if($task == 7)
            {
                //Mark whole section as done
                $user = $this->getParticipant();
                if($user['rego_first'] == 1)
                {
                    $column = "exercise_1";
                }
                else{
                    $column = "exercise_2";   
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

        if($task < 1 || $task > 7)
        {
            return "Invalid task number";
        }

        $check = $this->checkCompleted($task);

        if($check)
        {
            return "Task already completed";  //Ignore the request
        }

        $now = new Time('now', 'America/New_York');

        $REModel = new \App\Models\Rego_EvalsModel();
        $beginTime = $REModel->getFirstSubmissionTime($this->getParticipantID(), $task);

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

            $tModel = new \App\Models\Rego_TasksModel();
            $tModel->markComplete($this->getParticipantID(), $task);

            if($task == 7)
            {
                //Mark whole section as done
                $user = $this->getParticipant();
                if($user['rego_first'] == 1)
                {
                    $column = "exercise_1";
                }
                else{
                    $column = "exercise_2";   
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
        $rules = $this->request->getPost("rules");

        if($task < 1 || $task > 7)
        {
            die("ERROR: Invalid task number");
        }

        $check = $this->checkCompleted($task);

        if($check)
        {
            return "Task already completed";  //Ignore the request
        }

        $tmpfname = tempnam("/tmp", "rules");
        rename($tmpfname, $tmpfname .= '.rego');

        $handle = fopen($tmpfname, "w");
        fwrite($handle, $rules);
        fclose($handle);

        $short_output = "";
        $output = "";
        $success = true;
        for($i = 1; $i < 6; $i++)
        {
            $input = "../graphs/policy-" . strval($task) . "/input" . strval($i) . ".json";
            $eval = shell_exec('../opa eval -d ' . $tmpfname . ' -i ' . $input . ' "data.study.final_policy"');
            $correct = shell_exec('../opa eval -d ../graphs/policy-' . strval($task) . '/correct.rego -i ' . $input . ' "data.study.final_policy"');
            $result = json_decode($eval);
            $correct_result = json_decode($correct);

            if(isset($result->result))
            {
                if(!isset($correct_result->result))
                {
                    $short_output .= strval($i) . "v, ";
                    $output .= "Unexpected result: Input " . strval($i) . " should violate your policy.\n";
                    $success = false;
                }
            }
            else if(isset($result->errors))
            {
                $output = "Error on line ". $result->errors[0]->location->row . " col " . $result->errors[0]->location->col . ": " . $result->errors[0]->message;
                $short_output = "L" . $result->errors[0]->location->row . "C" . $result->errors[0]->location->col . ":" . $result->errors[0]->message;
                $success = false;
                break;
            }
            else
            {
                if(isset($correct_result->result))
                {
                    $short_output .= strval($i) . "s, ";
                    $output .= "Unexpected result: Input " . strval($i) . " should satisfy your policy.\n";
                    $success = false;
                }
            }
        }

        //Strip out the default comments

$comments = '# Please implement the requested policy using Rego
# The policy and example graphs/inputs can be 
# found in the panel to the right
#
# Click the green "Run" button to evaluate your 
# policy on each of the inputs
#
# Your policy should be named final_policy, but you may 
# define additional policies to use in final_policy';

        $cleanRules = str_replace($comments, "", $rules);

        //Save the policy and result
        $data = [
            "Participant" => $this->getParticipantID(),
            "Task" => $task,
            "Policy" => $cleanRules,
            "Correct" => $success ? 1 : 0 ,
            "Message" => $short_output 
        ];

        if($success)
        {
            $tModel = new \App\Models\Rego_TasksModel();
            $tModel->markComplete($this->getParticipantID(), $task);

            if($task == 7)
            {
                //Mark whole section as done
                $user = $this->getParticipant();
                if($user['rego_first'] == 1)
                {
                    $column = "exercise_1";
                }
                else{
                    $column = "exercise_2";   
                }
                $pModel = new \App\Models\ParticipantModel();
                $pModel->where("id", $this->getParticipantID())->set($column, 1)->update();
            }
        }

        $REModel = new \App\Models\Rego_EvalsModel();
        //Don't save multiple versions of the same policy
        $previous = $REModel->where("Participant", $this->getParticipantID())
                ->where("Task", $task)
                ->where("Policy", $cleanRules)
                ->first();
        if(!$previous)
        {
            $REModel->insert($data);
        }

        $arr = array('success' => $success, 'text' => $output);

        unlink($tmpfname);
        return(json_encode($arr));
    }
}
