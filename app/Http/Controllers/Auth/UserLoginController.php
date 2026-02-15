<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\ValidationException;
use App\Model\UsersPersonModel;
use App\Model\PorjectModel;
// use DateTime;
// use App\Model\UserRoleAccess;
// use App\Model\MenuInternalLink;
use App\Model\Employee;
use App\Model\EmployeePersonalInfo;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
// use Cache;
use DB;
use Hash;
use Session;
// use Symfony\Component\VarDumper\Cloner\Data;

//use App\Model\UserModel;


class UserLoginController extends Controller
{
    public function __construct(){

        $this->middleware('guest:user')->except('logout');

	}

    public function showLoginForm(){

        return view('login');
    }

	public function login(Request $request){
    	$this->validate($request,[
    		'userid' => 'required',
    		'password' => 'required'

        ]);

        $active_status = Employee::where('employee_id_no',$request->userid)->where('employee_status',1)->first();
        if (empty($active_status) || $active_status->employee_status != 1 ){
             $employee_ids = Employee::where('employee_id_no',$request->userid)->first();
             if(!empty($employee_ids)){
                $active_statuss = DB::table('resignations')->where('employee_id',$employee_ids->id)->where('resignation_status',2)->where('effective_date','>',date('Y-m-d'))->pluck('employee_id')->toarray();
                if(!empty($active_statuss)){
                    $active_status = $employee_ids;
                }else{
                    return back()->withInput()->with('error', "Access Denied!");
                }
            }else{
                return back()->withInput()->with('error', "Access Denied!");
            }
        }
        $valid_test = UsersPersonModel::where('employee_card_no',$request->userid)
                                        ->where('user_type','!=','')
                                        ->where('status',1)
                                        ->first();
        // echo "<pre>"; print_r($valid_test); exit();
        if(!empty($valid_test)){
            if($valid_test->role_id ==0 || $valid_test->role_id =='' || $valid_test->user_type =='' || $valid_test->company_sbu =='' || $valid_test->department ==''){
                return back()->withInput()->with('status', "Sorry! Contact your IT Department ....");
            }else{
                if($valid_test){
                    // $sub=['11','12','27','24'];
                    if(Auth::guard('user')->attempt(['employee_card_no'=>$request->userid,'password'=>$request->password])){
                        // $project_id = $valid_test->project_id;
                        // $project_info = PorjectModel::where('id',$project_id)->first();
                        session()->put('password_change', $valid_test['password_change']);

                        $employee_list = new Employee();
                        $employee_ids = $employee_list->Employee_id();
                        Session::put('employee_ids', $employee_ids);
                        Session::put('AllcompanySbuData',$employee_list->report_filter_data()['Allcompany_sbu_data']);
                        Session::put('company_sbu_data',$employee_list->report_filter_data()['company_sbu_data']);
                        Session::put('AllsectionData',$employee_list->report_filter_data()['Allsection_data']);
                        Session::put('section_data',$employee_list->report_filter_data()['section_data']);
                        Session::put('AllsubSectionData',$employee_list->report_filter_data()['Allsub_section_data']);
                        Session::put('sub_section_data',$employee_list->report_filter_data()['sub_section_data']);
                        Session::put('AllsubUnitData',$employee_list->report_filter_data()['Allsub_unit_data']);
                        Session::put('sub_unit_data',$employee_list->report_filter_data()['sub_unit_data']);
                        Session::put('AllunitData',$employee_list->report_filter_data()['Allunit_data']);
                        Session::put('unit_data',$employee_list->report_filter_data()['unit_data']);
                        Session::put('AllworkLocationData',$employee_list->report_filter_data()['Allwork_location_data']);
                        Session::put('work_location_data',$employee_list->report_filter_data()['work_location_data']);
                        Session::put('AlldepartmentData',$employee_list->report_filter_data()['Alldepartment_data']);
                        Session::put('department_data',$employee_list->report_filter_data()['department_data']);
                        
                    // }else if(in_array($valid_test['company_sbu'], $sub)){
                    //     if(Auth::guard('user')->attempt(['employee_card_no'=>$request->userid,'master_password'=>$request->password])){
                    //         $project_id = $valid_test->project_id;
                    //         $project_info = PorjectModel::where('id',$project_id)->first();
                    //         session()->put('password_change', $valid_test['password_change']);
                        }else{
                            return back()->withInput()->with('error', "Password doesn't match");
                        }
                    // }
                    return back()->withInput()->with('error', "Ueser ID doesn't match");
                }
            }
        }else{
            return back()->withInput()->with('error', "Ueser ID doesn't match");
            // return back()->with('error', 'The error message here!');
        }

        return back()->withInput()->with('error', "Invalid Ueser ID and password");
        // return back()->with('error', 'The error message here!');
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        Session::flush();

        return redirect()->route('user.login');
    }

     public function emailSendForPassChange(Request $request){
        // return response('$request');
        $this->validate($request,[
            'employee_email' => 'required',
            'employee_userid' => 'required'
        ]);
        $valid_employee_userid = Employee::where('employee_id_no',$request->employee_userid)->where('valid',1)->first();
        if (!empty($valid_employee_userid )) {
           $valid_test = Employee::where('official_email_id',$request->employee_email)->where('valid',1)->first();
           if (empty($valid_test)) {
               $valid_test = EmployeePersonalInfo::where('employee_email',$request->employee_email)->where('valid',1)->first();
           }else{
                $data['email_match'] = 2;
           }
           if (!empty($valid_test)) {
               $otp = rand(1,1000000);
               $otp_email=[
                   'email'=>$request->employee_email,
                   'full_name'=>'',
                   'email_body'=>'',
                   'otp'=>$otp
                ];
                // $email_sent = 1;
                $email_sent = Mail::to($request->employee_email)->send(new OtpMail($otp_email));
                // check for failures
                if (Mail::failures()) {
                    // return response showing failed emails
                     echo "Mail sent Failed!";
                }else{
                    $data['email_match'] = 1;
                    $data['employee_userid'] = $request->employee_userid;
                    DB::table('users_person')->where('employee_card_no', '=', $request->employee_userid)->update(array(
                            'employee_otp' => $otp,
                         ));
                }
           }else{
                   $data['email_match'] = 3;
           }
        }else{
            $data['userid_match'] = 4;
        }

        return response($data);
    }

    public function otpChecking(Request $request){
        $valid_employee_userid = UsersPersonModel::where('employee_card_no',$request->employee_userid)->where('employee_otp',$request->employee_otp)->first();
        if (!empty($valid_employee_userid)) {
            $data['otp_match'] = 1;
            $data['employee_userid'] = $request->employee_userid;
        }else{
            $data['otp_match'] = 0;
        }
        return response($data);
    }

    public function createNewPass(Request $request){
        // $request->password;
        // $request->password_confirmation;
        if ($request->password!=$request->password_confirmation) {
            $data['pass_change_suceessfull'] = 0;
            return response($data);
        }else{
            if (!empty($request)) {
                $password= Hash::make($request->password);
                DB::table('users_person')->where('employee_card_no', '=', $request->employee_userid)->update(array(
                                'password' => $password,
                                'employee_otp' => NULL
                             ));
                $data['pass_change_suceessfull'] = 1;
            }
            return response($data);
        }
    }

    public function find_user_email_id(Request $request){
        $data = Employee::valid()
        ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
        ->select('official_email_id', 'employee_email')
        ->where('employee_id_no', $request->employee_userid)
        ->first();
        if (!empty($data->official_email_id)) {
            $data['employee_email_id'] = $data->official_email_id;
        }elseif (!empty($data->employee_email)){
            $data['employee_email_id'] = $data->employee_email;
        }else{
            $data['employee_email_id'] = '';
        }
        return response($data);
    }



}
