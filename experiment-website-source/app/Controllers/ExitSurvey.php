<?php

namespace App\Controllers;

class ExitSurvey extends BaseController
{
    public $questions1 = [
        "If I need to write a provenance policy in the future, I would like to use this tool.",
        "I found the tool unnecessarily complex.",
        "I thought policies were easy to specify using this tool.",
        "I would need the support of an expert to be able to use the tool regularly.",
        "I found the various functions in this tool were well integrated.",
        "I thought there was too much inconsistency in this tool.",
        "Most people would learn to use this tool quickly.",
        "The tool is cumbersome to use.",
        "I felt confident in my ability to specify policies correctly using this tool.",
        "I needed to learn a lot to use this tool.",
        "I took a long time to discover problems in policies using this tool.",
        "I could quickly identify errors in the policies using this tool."
    ];

    public $questions2 = [
        "The provenance training adequately prepared me for the assessment.",
        "The ProProv training adequately prepared me for the assessment.",
        "The Rego training adequately prepared me for the assessment.",
        "After completing the provenance training, I was not prepared to create policies.",
        "After completing the ProProv training, I was not prepared to create policies.",
        "After completing the Rego training, I was not prepared to create policies.",
    ];

    public $questions3 = [
        "Do you have any recommendations for improving the ProProv tool?",
        "Do you have any recommendations for improving Rego?",
        "Do you have any issues, comments, or other remarks on the provenance training?",
        "Do you have any issues, comments, or other remarks on the ProProv training?",
        "Do you have any issues, comments, or other remarks on the Rego training?",
        "Do you have any recommendations for improving the training on provenance?",
        "Do you have any recommendations for improving the ProProv training?",
        "Do you have any recommendations for improving the Rego training?"
    ];

    private function checkBatch1()
    {
        $numQuestions = count($this->questions1) * 2; //One for rego and one for proprov

        $EModel = new \App\Models\ExitScaleModel();

        $results = $EModel->where('Participant', $this->getParticipantID())->findAll();

        if(count($results) < $numQuestions)
        {
            return false;
        }

        return true;
    }

    private function checkBatch2()
    {
        $numQuestions = (count($this->questions1) * 2) + count($this->questions2);

        $EModel = new \App\Models\ExitScaleModel();

        $results = $EModel->where('Participant', $this->getParticipantID())->findAll();

        if(count($results) < $numQuestions)
        {
            return false;
        }

        return true;
    }

    private function checkBatch3()
    {
        $numQuestions = count($this->questions3);

        $EModel = new \App\Models\ExitTextModel();

        $results = $EModel->where('Participant', $this->getParticipantID())->findAll();

        if(count($results) < $numQuestions)
        {
            return false;
        }

        return true;
    }

    private function checkExit()
    {
        $pModel = new \App\Models\ParticipantModel();

        $result = $pModel->where('id', $this->getParticipantID())->first();

        if($result['exit'] == NULL || $result['exit'] == 0)
        {
            return false;
        }

        return true;
    }

    private function checkPrevious()
    {
        $pModel = new \App\Models\ParticipantModel();

        $result = $pModel->where('id', $this->getParticipantID())->first();

        if($result['exercise_2'] == NULL || $result['exercise_2'] == 0)
        {
            return false;
        }

        return true;
    }

    private function checkCompleted($batch)
    {
        if(!$this->checkPrevious())
        {
            //Redirect to step 5
            return redirect()->to("");
        }

        if($this->checkExit())
        {
            return redirect()->to("");
        }

        if($batch < 1 || $batch > 3)
        {
            return redirect()->to('exit');
        }

        if($batch != "1" && !$this->checkBatch1())
        {
            //Have not completed step 1, redirect them there
            return redirect()->to("exit/1");
        }
        else if($batch == "1" && !$this->checkBatch1())
        {
            //Requesting 1, and has not done. Allow.
            return;
        }

        if($batch != "2" && !$this->checkBatch2())
        {
            //Have not completed step 2, redirect them there
            return redirect()->to("exit/2");
        }
        else if($batch == "2" && !$this->checkBatch2())
        {
            //Requesting 2, and has not done. Allow.
            return;
        }

        if($batch != "3" && !$this->checkBatch3())
        {
            //Have not completed step 3, redirect them there
            return redirect()->to("exit/3");
        }
        else if($batch == "3" && !$this->checkBatch3())
        {
            //Requesting 3, and has not done. Allow.
            return;
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

        if($this->checkExit())
        {
            return redirect()->to("");
        }

        return view('exit-home', ['controls' => false, 'user' => $this->getParticipant()]);
    }

    public function questions($batch)
    {
        $check = $this->checkCompleted($batch);

        if($check)
        {
            return $check;
        }

        if($batch == 1)
        {
            $questions = $this->questions1;
            $questionOffset = 1;
            $eachTool = true;
            $view = "exit-questions";
        }
        else if($batch == 2)
        {
            $questions = $this->questions2;
            $questionOffset = 1 + count($this->questions1);
            $eachTool = false;
            $view = "exit-questions";
        }
        else if($batch == 3)
        {
            $questions = $this->questions3;
            $questionOffset = 1 + count($this->questions1) + count($this->questions2);
            $eachTool = false;
            $view = "exit-questions-text";
        }
        else{
            return redirect()->to("exit");
        }

        $data = ['controls' => true, 'user' => $this->getParticipant(), 
                'questions' => $questions, "questionOffset" => $questionOffset,
                'eachTool' => $eachTool, "batch" => $batch
            ];

        return view($view, $data);
    }

    public function submit($batch)
    {
        $check = $this->checkCompleted($batch);

        if($check)
        {
            return "Task already completed";  //Ignore the request
        }

        if($batch == 1)
        {
            $EModel = new \App\Models\ExitScaleModel();
            
            $data = $this->request->getPost();

            foreach($data as $key=>$value)
            {
                $items = explode("_", $key);

                $type = $items[0];
                $number = intval(str_replace("q", "", $items[1]));

                $insert = ["Participant" => $this->getParticipantID(),
                        "Type" => $type, "Question" => $number, 
                        "Score" => $value
                        ];

                $EModel->insert($insert);
            }
        }
        else if($batch == 2)
        {
            $EModel = new \App\Models\ExitScaleModel();
            
            $data = $this->request->getPost();

            foreach($data as $key=>$value)
            {
                $number = intval(str_replace("q", "", $key));

                $insert = ["Participant" => $this->getParticipantID(),
                        "Question" => $number, "Score" => $value
                        ];

                $EModel->insert($insert);
            }
        }
        else if($batch == 3)
        {
            $EModel = new \App\Models\ExitTextModel();
            
            $data = $this->request->getPost();

            foreach($data as $key=>$value)
            {
                $number = intval(str_replace("q", "", $key));

                $insert = ["Participant" => $this->getParticipantID(),
                        "Question" => $number, "Answer" => $value
                        ];

                $EModel->insert($insert);
            }
        }
        else{
            return redirect()->to("exit");
        }

        if($batch < 3)
        {
            return redirect()->to("exit/" . ($batch+1));
        }
        else
        {
            //Mark it as finished
            $pModel = new \App\Models\ParticipantModel();

            //Update
            $pModel->where('id', $this->getParticipantID())
            ->set(["exit" => 1])
            ->update();
            return redirect()->to("");
        }
    }
}
