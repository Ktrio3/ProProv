<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class DemoFilter implements FilterInterface
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

        if($result['Gender'] == NULL || $result['Age'] == NULL || $result['Language'] == NULL || $result['Fluency'] == NULL || $result['Education'] == NULL || $result['Major'] == NULL)
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

        if($result['Ethnicity'] == NULL || $result['Race'] == NULL)
        {
            return false;
        }

        return true;
    }

    private function check3()
    {
        $session = session();
        $id = $session->get('id'); 
        $dModel = new \App\Models\DemographicModel();

        $result = $dModel->where('Participant', $id)->first();

        if($result['YearsCyS'] == NULL || $result['YearsCS'] == NULL || $result['YearsCE'] == NULL 
            || $result['YearsIT'] == NULL || $result['YearsProg'] == NULL || $result['SpecifiedPolicy'] == NULL)
        {
            return false;
        }

        return true;
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        //Check if they are done with demographics
        return;
        if($this->checkDemo())
        {
            return redirect()->to("");
        }

        $uri = current_url(true);

        $batch = $uri->getSegment(2);

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
            //Requesting 3, but has not done 2. Redirect them there
            return redirect()->to("demographics/2");
        }
        else if($batch == "2" && !$this->check2())
        {
            //Requesting 1, and has not done. Allow.
            return;
        }

        if($batch == "3" && !$this->check3())
        {
            //Requesting 3, and has not done. Allow.
            return;
        }

        //Must have requested an invalid batch number, send home
        return redirect()->to("");
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}