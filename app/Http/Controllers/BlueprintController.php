<?php namespace App\Http\Controllers;

use App\Models\Blueprint as Blueprint;

class BlueprintController extends Controller {

	public function createBlueprint() {
		$blueprint = new Blueprint(\Input::all());
		$blueprint->user()->associate(\Auth::user());
		$blueprint->setAttribute('code', str_random(40));
		$blueprint->save();
		return view('blueprint.created');
	}
	
	public function getBlueprintWelcome() {
		return view('blueprint.welcome'); 
	}
	
	public function getBlueprintForm() {
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
