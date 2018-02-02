<?php

namespace App\Http\Controllers;
use App\App;
use App\Version;
use Illuminate\Http\Request;

class AppController extends Controller {

	public function showApp() {
		$data['data'] = App::all();
		$data['url'] = url();
		// $this->output($data, 200);
		return response()->json($data, 200);
	}
	public function ListApp() {
		$data = App::where('status', 1)->get();
		// $data['url'] = url();
		$this->output($data, 200);
	}
	public function ShowOneApp($id) {
		$data['app'] = App::find($id);
		$data['version'] = Version::where('app_id', $id)->get();
		if ($data['app']) {
			$this->output($data, 200);
		} else {
			$this->output(["fail" => "k ton tai"], 404);
		}
	}
	public function OneApp($id) {
		$data['app'] = App::where('status', 1)->find($id);
		$data['version'] = Version::where('app_id', $id)->get();
		if ($data['app']) {
			$this->output($data, 200);
		} else {
			$this->output(["fail" => "k ton tai"], 404);
		}

	}

	public function create(Request $request) {
		// dd(url());
		$data = $request->all();
		$this->validate($request,
			[
				'name' => 'required |
				min:4|max:100|unique:app',
				'icon' => 'mimes:jpeg,png',
				// 'describ' => 'required '
				// 'hdh' => 'required ',
				// 'publisher' => 'required',
				// 'admin_id' => 'required',
				// 'status' => 'required '
			],
			[
				'name.required' => 'can nhap ten app!',
				'name.unique' => 'ten app da ton tai',
				'name.min' => 'ten app qua ngan ',
				'name.max' => 'ten app qua dai',
				'icon.mimes' => 'file nhap k hop le',
			]);

		// if (isset($data['icon'])) {
		// 	$file = $data['icon'];
		// 	$a = str_random(10) . '.' . $file->getClientOriginalExtension();
		// 	$request->file('icon')->move('resources/', $a);
		// 	$data['icon'] = $a;

		// } else {
		// 	$data['icon'] = 'icon.png';
		// }
		$destinationPath = 'icon_app';
		if ($request->hasFile('icon')) {
			$icon = str_random(10) . $request->file('icon')->getClientOriginalName();

			$request->file('icon')->move($destinationPath, $icon);
			$data['icon'] = $destinationPath . "/" . $icon;
		} else {
			$data['icon'] = $destinationPath . '/' . 'icon.png';
		}

		$app = App::create($data);

		$this->output(['success' => 'Successfully'], 201);
	}

	public function update(Request $request, $id) {
		$app = App::find($id);
		if (!$app) {
			$this->output(['fail' => 'not exists'], 404);
		}
		$data = $request->all();
		$check = 'required |min:4|max:100';
		if (isset($data['name']) && $app->name != $data['name']) {
			$check = 'required |min:4|max:100|unique:app';
		}
		$this->validate($request,
			[
				'name' => $check,
				'icon' => 'mimes:jpeg,png',
			],
			[
				'name.required' => 'ban chua nhap ten !',

				'name.min' => 'tên app tối thiểu là 4 ký tự',
				'name.unique' => 'ten da ton tai',
				'name.max' => 'toi da 100 ky tu',

				'icon.mimes' => 'file chua dung dinh dang!',
			]);

		if ($request->hasFile('icon')) {
			$icon = str_random(10) . $request->file('icon')->getClientOriginalName();
			$destinationPath = 'icon_app';
			$request->file('icon')->move($destinationPath, $icon);
			$data['icon'] = $destinationPath . '/' . $icon;
		} else {
			$data['icon'] = $app->icon;
		}

		$app->update($data);

		$this->output($app, 200);
	}

	public function delete($id) {
		$data = App::find($id);
		if (!$data) {
			$this->output(['fail' => 'not exist'], 404);
		}
		$data->delete();
		$this->output(['success' => 'Deleted Successfully'], 200);
	}

}