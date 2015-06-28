<?php namespace App\Http\Controllers;

use App\Models\Blueprint as Blueprint;

class BlueprintController extends Controller {

	public function createBlueprint() {
		$blueprint = new Blueprint(\Input::all());
		$blueprint->user()->associate(\Auth::user());
		$blueprint->setAttribute('code', $this->generateUniqueCode());
		$blueprint->save();
		return view('blueprint.created');
	}
	
	private function generateUniqueCode() {
		$code = str_random(40);
		$blueprint = Blueprint::findByCode($code);
		if ($blueprint) {
			return $this->generateUniqueCode();
		} else {
			return $code;
		}
	}
	
	public function getBlueprintWelcome() {
		return view('blueprint.welcome'); 
	}
	
	public function getCreateForm() {
		return view('blueprint.form');
	}
	
	public function getBlueprints() {
		return Blueprint::all();
	}
	
	public function getBlueprint($id) {
		return Blueprint::findOrFail($id);
	}
	
	public function approveBlueprint($id) {
		$bluePrint = $this->getBlueprint($id);
		$bluePrint->approve();
		$code = $bluePrint->code;
		// send email
	}

}
