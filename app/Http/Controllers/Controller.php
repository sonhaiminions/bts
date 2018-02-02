<?php
namespace App\Http\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController {
	public function __construct() {
		header("Access-Control-Allow-Origin: *");
	}
	public function output($data, $statusCode) {
		response()->json($data, $statusCode)->send();die;
	}
}
