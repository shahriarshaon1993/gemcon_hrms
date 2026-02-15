<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdapterController extends Controller {

	public function jsBaseURLs() {
		$data['baseURL'] = url("/");
		return view('jsBaseURLs', $data);
	}

	public function hrmJsBaseURLs() {
		$data['baseURL'] = url("hrm");
		return view('jsBaseURLs', $data);
	}
	public function payrollJsBaseURLs() {
		$data['baseURL'] = url("payroll");
		return view('jsBaseURLs', $data);
	}


	public function adminJsBaseURLs() {
		$data['baseURL'] = url("admin");
		return view('jsBaseURLs', $data);
	}

}
