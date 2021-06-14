<?php namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Validator;

class Registrar implements RegistrarContract
{

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'nick_name' => 'max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ], $this->messages());
    }

    public function messages()
    {
        return [
            'email.unique' => '이미 사용중인 이메일입니다.',
            'password.confirmed' => '비밀번호를 다시 한번 확인해주세요',
            'password.min' => '비밀번호는 6자리 이상으로 입력해주세요'
        ];
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    public function create(array $data)
    {
      $nickName = $data['nick_name'];
      if(!$nickName)
      {
        $nickName = $data['name'];
      }

      $advertising_at = date('Y-m-d H:i:s', time());

        return User::create([
            'name' => $data['name'],
            'nick_name' => $nickName,
            'age' => $data['age'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'contact' => $data['contact'],
            'country_code' => $data['country_code'],
            'is_certification' => $data['is_certification'],
            'advertising' => $data['advertising'],
            'advertising_at' => $advertising_at
        ]);
    }

}
