<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Model\AdminModel;
class AdminLoginController extends Controller
{
    public function __construct(){

        $this->middleware('guest:admin')->except('logout');

	}

    public function showLoginForm(){

        return view('auth.admin-login');
    }

	public function login(Request $request){

    	//Validate the form data

    	$this->validate($request,[

    		'username' => 'required',
    		'password' => 'required'

    	]);

        $valid_test = AdminModel::valid()->where('username',$request->username)->first();

        if($valid_test){

        	//Attempt to log the user

        	if(Auth::guard('admin')->attempt(['username'=>$request->username,'password'=>$request->password])){
               
               //if successful, then redirect to their intended loaction

        		return redirect(route('admin.home'));

        	}

        	//if unsuccessful, then redirect to the login with form data
            
            return back()->withInput()->with('status', "Username and password doesn't match");

        }
        
        return back()->withInput()->with('status', "Invalid username and password");
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }
}
