<?php

namespace App\Controllers;

class TrainingMats extends BaseController
{
	public function index(){
		return view('training-mats', ['controls' => false, 'user' => $this->getParticipant()]);
	}

	public function rego(){
		return view('training', ['controls' => false, 'user' => $this->getParticipant(), 'num' => 1, 'type' => "rego", 'next'=>""]);
	}

	public function prov(){
		return view('training', ['controls' => false, 'user' => $this->getParticipant(), 'num' => 1, 'type' => "prov", 'next'=>""]);
	}

	public function proprov(){
		return view('training', ['controls' => false, 'user' => $this->getParticipant(), 'num' => 1, 'type' => "proprov", 'next'=>""]);
	}

}