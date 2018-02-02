<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

	public function showUser() {
		$data = User::all();
		$data['url'] = url();
		$this->output($data, 200);

	}

	public function showOneUser($id) {

		$data = User::find($id);
		$data['url'] = url();
		if ($data) {
			$this->output($data, 200);
		} else {
			$this->output("fail", 404);
		}
	}

	public function create(Request $request) {
		$data = $request->all();
		$this->validate($request,
			[
				'username' => 'required |
				min:4|max:100|unique:user',
				'password' => 'required |
				min:4|max:100',
				'avatar' => 'mimes:jpeg,png',

			],
			[
				'username.required' => 'can nhap tai khoan!',
				'username.unique' => 'tai khoan da ton tai',

				'password.min' => 'mật khẩu tối thiểu là 4 ký tự',
				'password.max' => 'toi da 100 ky tu',
			]);
		$destinationPath = 'avatar';
		if ($request->hasFile('avatar')) {
			$avatar = str_random(10) . $request->file('avatar')->getClientOriginalName();
			$request->file('avatar')->move($destinationPath, $avatar);
			$data['avatar'] = $destinationPath . '/' . $avatar;
		} else {
			$data['avatar'] = $destinationPath . '/' . 'icon.png';
		}
		$data['password'] = hash::make($data['password']);
		$user = User::create($data);
		$this->output($user, 201);
	}

	public function update(Request $request, $id) {
		$user = User::find($id);
		if (!$user) {
			$this->output("fail", 404);
		}
		$data = $request->all();
		// dd();if ($admin->username == $data['username']) {
		$check = 'required |min:4|max:100';
		if (isset($data['username']) && $user->username != $data['username']) {
			$check = 'required |min:4|max:100|unique:admin';
		}
		$this->validate($request,
			[
				'username' => $check,
				'password' => 'min:4|max:100',
				'avatar' => 'mimes:jpeg,png',

			],
			[
				'username.required' => 'ban chua nhap ten !',

				'username.min' => 'tên thể loại tối thiểu là 4 ký tự',
				'username.unique' => 'ten da ton tai',
				'username.max' => 'toi da 100 ky tu',

				'avatar.mimes' => 'file chua dung dinh dang!',

				'password.min' => 'mật khẩu tối thiểu là 4 ký tự',
				'password.max' => 'toi da 100 ky tu',
			]);
		$destinationPath = 'avatar';
		if ($request->hasFile('avatar')) {
			$avatar = str_random(10) . $request->file('avatar')->getClientOriginalName();

			$request->file('avatar')->move($destinationPath, $avatar);
			$data['avatar'] = $destinationPath . '/' . $avatar;
		} else {
			$data['avatar'] = $destinationPath . '/' . 'icon.png';
		}

		if (isset($data['password'])) {
			$data['password'] = hash::make($data['password']);
		}
		// dd($user);
		$user->update($data);

		$this->output($user, 200);
	}

	public function delete($id) {
		$data = User::find($id);
		if (!$data) {
			$this->output('not exist user', 404);
		}
		User::find($id)->delete();
		$this->output('Deleted Successfully', 200);
	}
	public function search($key) {

		$data = User::where('username', 'like', '%' . $key . '%')->get();
		if (count($data->toArray()) != 0) {
			$this->output($data, 200);
		} else {
			$this->output(['error' => 'not data return'], 203);
		}
	}
}