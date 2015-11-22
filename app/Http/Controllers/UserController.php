<?php namespace App\Http\Controllers;

use App\Models\User as User;
use App\Models\Ticket as Ticket;
use App\Models\Project as Project;

class UserController extends Controller {
	
	public function getUser($id) {
		$user = User::findOrFail($id);
        return view('user.detail', [
        	'user' => $user,
            'orders' => Project::take(3)->get(),
            'created' => Project::skip(3)->take(3)->get()
        ]);
	}
	
	public function getUpdateForm($id) {
		$user = $this->ensureLoginUser($id);
		return view('user.modify', [
			'user' => $user
		]);
	}
	
	public function updateUser($id) {
		$user = $this->ensureLoginUser($id);
		// update
	}
	
	private function ensureLoginUser($id) {
		$user = User::findOrFail($id);
		$loginUser = \Auth::user();
		if ($user->id === $loginUser->id) {
			return $user;
		}
		throw new \App\Exceptions\OwnershipException;
	}

}
