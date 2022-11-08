<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        $session = session();

        if($session->has('id'))
        {
            return redirect()->to('');
        }

        return view('login');
    }

    private function randomID()
    {
        $prefix = getenv("participantPrefix"); //Get the current prefix for new IDs

        //Generate a random number
        $digits = 5;
        $id = $prefix . str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        return $id;
    }

    private function randomCode()
    {
        $prefix = getenv("amazonPrefix"); //Get the current prefix for new IDs
        $suffix = getenv("amazonSuffix");

        //Generate a random number
        $digits = 5;
        $id = $prefix . "-" . str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        $id .= str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT) . "-" . $suffix ;
        return $id;
    }

    public function logout()
    {
        $session = session();
        $session->destroy();

        return redirect()->to("login");
    }

    public function login()
    {
        //Ensure they aren't already logged in
        $session = session();

        if($session->has('id'))
        {
            return redirect()->to('');
        }


        if($this->request->getPost("accessCode") != getenv("accessCode"))
        {
            return view('login', ['errors' => "The access code provided is incorrect."]);
        }

        $pModel = new \App\Models\ParticipantModel();
    
        //Handle login and redirect to pincode
        $id = $this->randomID();
        
        //Make sure this was not already generated
        while($pModel->find($id))
        {
            $id = $this->randomID();
        }

        //Handle login and redirect to pincode
        $amazonCode = $this->randomCode();
        
        //Make sure this was not already generated
        while($pModel->where('verification_code', $amazonCode)->first())
        {
            $amazonCode = $this->randomCode();
        }

        $userAgent = $this->request->getUserAgent()->getAgentString();

        //Determine if this should be a rego first or proprov first
        //If even or 0, then proprov first. Odd is rego first
        $regoFirst = $pModel->countAllResults() % 2;
        // echo $regoFirst;
        // die();

        $data = [
            'id'       => $id,
            'verification_code' => $amazonCode,
            'user_agent' => substr($userAgent, 0, 100),
            'rego_first' => $regoFirst
        ];
        $pModel->save($data);

        //Create the session
        $session->set(['id' => $id]);

        return redirect()->to('');
    }
}
