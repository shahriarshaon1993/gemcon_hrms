<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Auth;
class ChangePasswordController extends Controller
{


    public function changePasswordView(Request $request){
        return view('user-change-passwod');
    }


	public function passwordChange(Request $request){

    	try{

    		$request->validate([
    			'oldpassword'=>'required',
    			'newpassword'=>'required',
    		]);
            $userId = Auth::guard('user')->user()->id;
            if(!empty($userId)){
                $user = UserModel::valid()->find($userId);
                if(\Hash::check($request->oldpassword, $user->password)){
                    $input["password"] = bcrypt($request->newpassword);
                    $save = UserModel::valid()->find($userId)->update($input);
                    $output = ['status' => 1, 'message' => 'Password successfully changed.'];
                }else{
                    $output = ['status' => 0, 'message' => 'Old password is wrong.'];   
                }
            }else{
                $output = ['status' => 0, 'message' => 'Invalid userId.'];
            }
    	}catch (Throwable $e) {
            throw $e;
        }
        return response()->json($output);

    }

    public function passwordChangeAction(Request $request){

        try{

            $request->validate([
                'oldpassword'=>'required',
                'newpassword'=>'required',
            ]);
            $userId = Auth::guard('user')->user()->id;
            if(!empty($userId)){
                $user = UserModel::valid()->find($userId);
                if(\Hash::check($request->oldpassword, $user->password)){
                    $input["password"] = bcrypt($request->newpassword);
                    $save = UserModel::valid()->find($userId)->update($input);
                    $output ='true';
                }else{
                    $output ='false'; 
                }
            }else{
                $output = 'Invalid userId.';
            }
        }catch (Throwable $e) {
            throw $e;
        }
        return back()->with('status',$output);

    }
    
}
