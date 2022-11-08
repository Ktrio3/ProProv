<?php

namespace App\Controllers;

class Demographics extends BaseController
{
    private function checkDemo()
    {
        $session = session();
        $id = $session->get('id'); 
        $pModel = new \App\Models\ParticipantModel();

        $result = $pModel->where('id', $id)->first();

        if($result['demographics'] == NULL || $result['demographics'] == 0)
        {
            return false;
        }

        return true;
    }

    private function check1()
    {
        $session = session();
        $id = $session->get('id'); 
        $dModel = new \App\Models\DemographicModel();

        $result = $dModel->where('Participant', $id)->first();

        if($result == NULL || $result['Gender'] == NULL || $result['Age'] == NULL || $result['Language'] == NULL || $result['Fluency'] == NULL || $result['Education'] == NULL || $result['Ethnicity'] == NULL || $result['Race'] == NULL)
        {
            return false;
        }

        return true;
    }

    private function check2()
    {
        $session = session();
        $id = $session->get('id'); 
        $dModel = new \App\Models\DemographicModel();

        $result = $dModel->where('Participant', $id)->first();

        if($result == NULL || $result['YearsCyS'] == NULL || $result['YearsCS'] == NULL || $result['YearsCE'] == NULL 
            || $result['YearsIT'] == NULL || $result['YearsProg'] == NULL || $result['SpecifiedPolicy'] == NULL)
        {
            return false;
        }

        return true;
    }

    private function checkCompleted($batch)
    {
        //Check if they are done with demographics
        if($this->checkDemo())
        {
            return redirect()->to("");
        }

        if($batch < 1 || $batch > 2)
        {
            return redirect()->to('demographics');
        }

        if($batch != "1" && !$this->check1())
        {
            //Have not completed step 1, redirect them there
            return redirect()->to("demographics/1");
        }
        else if($batch == "1" && !$this->check1())
        {
            //Requesting 1, and has not done. Allow.
            return;
        }

        if($batch != "2" && !$this->check2())
        {
            //Have not completed step 2, redirect them there
            return redirect()->to("demographics/2");
        }
        else if($batch == "2" && !$this->check2())
        {
            //Requesting 2, and has not done. Allow.
            return;
        }

        //Must have requested an invalid batch number, send home
        return redirect()->to("");
    }

    public function index()
    {
        //Note: Checks for having completed the different batches are contained in the filter
        if($this->checkDemo())
        {
            return redirect()->to("");
        }
        return view('demographics-home', ['controls' => false, 'user' => $this->getParticipant()]);
    }

    public function questions($batch)
    {

        $check = $this->checkCompleted($batch);

        if($check != NULL)
        {
            return $check;
        }

        if($batch == 1)
        {
            return view('demographics-questions1', ['controls' => true, 'user' => $this->getParticipant()]);
        }

        return view('demographics-questions2', ['controls' => true, 'user' => $this->getParticipant()]);
    }

    public function submit($batch)
    {
        if($batch < 1 || $batch > 2)
        {
            return redirect()->to('demographics');
        }

        $check = $this->checkCompleted($batch);
        if($check != NULL)
        {
            return $check;
        }

        $validation = \Config\Services::validation();

        if($batch == 1)
        {
            //Get the validation rules so we can dynamically modify them
            $rules = $validation->getRuleGroup('demo1');
            $data = $this->request->getPost();

            //Manually check if Gender_other and Major were set
            if($this->request->getPost('Gender') == "other")
            {
                //Make Gender_other required
                $rules['Gender_other']['rules'] = 'required|max_length[20]';
                $data['Gender'] = $data['Gender_other'];  //Overwrite gender with custom one   
            }

            $edu = $this->request->getPost('Education');
            if($edu != 'none' && $edu != 'some_high' && $edu != 'high')
            {
                //Make Major required
                $rules['Major']['rules'] = 'required|max_length[20]';
            }

            if(!$validation->setRules($rules)->run($this->request->getPost()))
            {
                return view('demographics-questions1', ['controls' => true, 'user' => $this->getParticipant(), 
                                                        'validation' => $validation, 'vals' => $this->request->getPost()]);
            }

            $data['Race'] = implode(",", $this->request->getPost('Race'));

            //Save

            $dModel = new \App\Models\DemographicModel();

            //Check if the user already has an entry
            $result = $dModel->where('Participant', $this->getParticipantID())->first();

            if(!$result)
            {
                //Insert
                $data['Participant'] = $this->getParticipantID();
                $dModel->insert($data);
            }
            else
            {
                //Update
                $dModel->where('Participant', $this->getParticipantID())
                ->set($data)
                ->update();
            }

            return redirect()->to('demographics/2');
        }

        //Get the validation rules so we can dynamically modify them
        $rules = $validation->getRuleGroup('demo2');

        //Manually check if SpecifiedPolicy was set
        if($this->request->getPost('SpecifiedPolicy') == "1")
        {
            //Make PoliciesWorkedWith and SpecifiedPolicyRego required
            $rules['PoliciesWorkedWith']['rules'] = 'required|max_length[200]';
            $rules['SpecifiedPolicyRego']['rules'] = 'required|in_list[0,1]';   
        }

        if(!$validation->setRules($rules)->run($this->request->getPost()))
        {
            return view('demographics-questions2', ['controls' => true, 'user' => $this->getParticipant(), 
                                                    'validation' => $validation, 'vals' => $this->request->getPost()]);
        }

        //Save
        $dModel = new \App\Models\DemographicModel();

        //Update
        $dModel->where('Participant', $this->getParticipantID())
        ->set($this->request->getPost())
        ->update();

        //User has completed demographics!
        $pModel = new \App\Models\ParticipantModel();

        //Update
        $pModel->where('id', $this->getParticipantID())
        ->set(["demographics" => 1])
        ->update();

        return redirect()->to('');
    }
}
