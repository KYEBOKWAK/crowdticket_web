<?php namespace App\Http\Controllers;

class BlueprintController extends Controller {

	public function createBlueprint() {
		return 5;
	}
	
	public function getBlueprintWelcome() {
		return view('blueprint.welcome'); 
	}
	
	public function getBlueprintForm() {
		return view('blueprint.form');
	}
	
	public function getBlueprints() {
		
	}
	
	public function getBlueprint($id) {
		
	}
	
	public function approveBlueprint($id) {
		
	}

}
