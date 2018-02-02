<?php

namespace App\Http\Middleware;
use App\Admin;
use Closure;

class LoginMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {

		if ($request->input('api_token')) {
			$a = Admin::where('api_token', $request->input('api_token'))->first();
			if ($a) {
				return $next($request);
			} else {
				return response()->json(["fail" => " dc vao"], 200)->send();
			}

		} else {
			return response()->json(["fail" => " dc vao"], 200)->send();
		}

	}
}
