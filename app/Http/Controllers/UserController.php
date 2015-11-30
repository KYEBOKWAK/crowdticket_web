<?php namespace App\Http\Controllers;

use Storage as Storage;
use App\Models\Model as Model;
use App\Models\User as User;
use App\Models\Ticket as Ticket;
use App\Models\Project as Project;
use Illuminate\Http\Request as Request;

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
		return $this->getUpdateView($user);
	}
	
	private function getUpdateView($user, $toast = null) {
		return view('user.modify', [
			'user' => $user,
			'toast' => $toast
		]);
	}
	
	public function updateUser(Request $request, $id) {
		$user = $this->ensureLoginUser($id);
		if ($this->isTryChangePassword()) {
			if ($this->validateUserCredential($user)) {
				$user->password = bcrypt(\Input::get('new_password'));
			} else {
				return $this->getUpdateView($user, $this->messageError('잘못된 비밀번호입니다.'));
			}
		}
		if ($request->file('photo')) {
			$photoUrl = $this->uploadPosterImage($request, $user);
			$user->setAttribute('profile_photo_url', $photoUrl);
		}
		$user->update(\Input::all());
		$user->save();
		
		return $this->getUpdateView($user, $this->messageSuccess('변경되었습니다.'));
	}
	
	private function uploadPosterImage($request, $user) {
		$photoUrlPartial = Model::S3_USER_DIRECTORY . $user->id . '.jpg';
		
		Storage::put(
			$photoUrlPartial,
			file_get_contents($request->file('photo')->getRealPath())
		);
		
		return Model::S3_BASE_URL . $photoUrlPartial;
	}
	
	private function isTryChangePassword() {
		$this->blockDirectChangePassword();
		return \Input::has('new_password');
	}
	
	private function validateUserCredential($user) {
		$credential = [
			'email' => $user->email,
			'password' => \Input::get('old_password')
		];
		return \Auth::validate($credential);
	}
	
	private function blockDirectChangePassword() {
		if (\Input::has('password')) {
			throw new \App\Exceptions\UnapprovedAccessException;
		}
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
