<?php

namespace App\Http\Controllers;
use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller {
	public function __construct() {
		// $this->middleware('login', ['except' => ['login', 'showAdmin']]);

		//     $this->middleware('log')->only('index');

		//     $this->middleware('subscribed')->except('store');
	}
	public function showAdmin() {
		$data = Admin::all();
		$this->output($data, 200);
	}

	public function showOneAdmin($id) {
		$data = Admin::find($id);
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
				min:4|max:100|unique:admin',
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

		$admin = Admin::create($data);
		$this->output(['success' => 'thanhcong'], 201);
	}

	public function update(Request $request, $id) {
		$admin = Admin::find($id);
		if (!$admin) {
			$this->output("fail", 404);
		}
		$data = $request->all();
		$check = 'required |min:4|max:100';
		if (isset($data['username']) && $admin->username != $data['username']) {
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
		$admin->update($data);

		$this->output($admin, 200);
	}

	public function delete($id) {
		$data = Admin::find($id);
		if (!$data) {
			$this->output('not exist', 404);
		}
		$data->delete();
		$this->output('Deleted Successfully', 200);
	}

	public function login(Request $request) {
		$data = $request->all();
		// dd(hash::make($request->input('password')));
		$this->validate($request,
			[
				'username' => 'required |
				min:4|max:100',
				'password' => 'required |
				min:4|max:100',
			],
			[
				'username.required' => 'can nhap tai khoan!',

				'password.min' => 'mật khẩu tối thiểu là 4 ký tự',
				'password.max' => 'toi da 100 ky tu',
			]);
		$admin = Admin::where('username', $data['username'])->first();
		if ($admin) {
			if ($admin->status == 1) {
				if (Hash::check($data['password'], $admin->password)) {
					$api_token = base64_encode(str_random(40));
					$admin->update(['api_token' => "$api_token"]);
					$this->output(['status' => 'success', 'api_token' => $api_token], 200);

				} else {
					$this->output(['error' => 'mat khau chua dung'], 401);
				}
			} else {
				$this->output(['error' => 'tai khoan bi khoa'], 401);
			}

		} else {
			$this->output(['error' => 'tai khoan chua dung'], 401);

		}

	}

}
