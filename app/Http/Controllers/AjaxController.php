<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


class AjaxController extends Controller {

	public function post(Request $request){

		$response = array(
			'status' => 'success',

			'idArea' => request('idstored'),

		);

		return response()->json($response); 
	}
}