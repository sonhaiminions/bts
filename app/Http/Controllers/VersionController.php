<?php

namespace App\Http\Controllers;
use App\Version;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VersionController extends Controller {

	public function OneVersion($id) {
		$data = Version::find($id);
		if ($data) {
			// response()->json($data);
			$this->output($data, 200);
		} else {
			$this->output(['fail' => 'not exist version'], 404);
		}
	}
	public function create(Request $request) {
		$data = $request->all();
		$this->validate($request,
			[
				'version' => 'required',
				'newfeature' => 'required',

				// 'link' => 'required',
				// 'permission'=>'required',
				// 'admin_id'=> 'required',
				// 'status'=>'required'
			],
			[
				'version.required' => 'can  nhap version',
				'newfeature.required' => 'can nhap tinh nang',
			]
		);

		$version = Version::create($data);
		$this->output(['success' => 'add Successful'], 201);
	}

	public function update(Request $request, $id) {
		$version = Version::find($id);
		if (!$version) {
			$this->output(['fail' => 'not exist'], 404);
		}
		$data = $request->all();
		$check = 'required';
		if (isset($data['version']) && $data['version'] != $version->version) {
			$check = 'required|unique:version';
		}
		$this->validate($request,
			[

				'version' => $check,
				'newfeature' => 'required',
			],
			[
				'version.required' => 'can  nhap version',
				'newfeature.required' => 'can nhap tinh nang',
			]);
		$version->update($data);
		$this->output(['success' => 'update Successfully'], 200);
	}

	public function delete($id) {
		$data = Version::find($id);
		if ($data) {
			$this->output(['fail' => 'not exist'], 404);
		}
		$data->delete();
		$this->output(['success' => 'Deleted Successfully'], 200);
	}
	public function download($id) {
		$data = Version::find($id);
		$file = $data->link;
		return response()->download($file);
	}
}
//