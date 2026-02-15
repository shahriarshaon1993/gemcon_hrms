<?php

namespace App\Http\Controllers\hrm;

use App\Model\CandidateInterviewMark;
use App\Model\JobApplyCandidate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\InterveiwBoardCall;
use App\Model\JobCircular;
use App\Model\Employee;
use App\Model\EmployeePersonalInfo;
// use App\Model\Designation;
use App\Mail\ExaminerMail;
use Illuminate\Support\Facades\Mail;
use Cache;
use permission;
use DB;
// use Url;
// use App\Model\UserRoleAccess;

class InterveiwBoardCallController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','InterviewBoardCall')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
  foreach($permission as $child) {
      if($child['link_uid']=='add'){
          $data['add']=$child['link_uid'];
      }elseif($child['link_uid']=='edit'){
          $data['edit']=$child['link_uid'];
      }elseif($child['link_uid']=='delete') {
          $data['delete']=$child['link_uid'];
      }elseif($child['link_uid']=='email_sent') {
          $data['email_sent']=$child['link_uid'];
      }else {
          $data['approve']=$child['link_uid'];
      }
  }
   $paginate_num = $request->input('paginate_num');
   $search_key = $request->input('search_key');
   $order = $request->input('order');
   $sort = $request->input('sort');
   $project_id=Auth::guard('user')->user()->project_id;
   $branch_id=Auth::guard('user')->user()->branch_id;
   $data['paginate_data'] =InterveiwBoardCall::valid()->project()
   ->leftJoin('employees', 'employees.id', '=', 'interview_board_calls.ibc_examiner_name')
   ->leftJoin('job_circulars', 'job_circulars.id', '=', 'interview_board_calls.ibc_circular_id')
   ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
   ->leftJoin('designations', 'designations.id', '=', 'job_circulars.jc_job_position')
   ->select(
      'interview_board_calls.*',
      'job_circulars.jc_circular_id',
      'designations.designation_name',
      'employees.employee_fullname',
      'employees.employee_mobile',
      'employee_personal_infos.employee_email'
   )
   ->when($search_key, function($query, $search_key){
      $query->where(function($query2)use($search_key){
         $query2->where('employee_full_name','LIKE','%'.$search_key.'%');
      });
      return $query;
   })->orderBy($sort,$order)->paginate($paginate_num);

   return response()->json($data);
}

public function create(){
   $data['employee_data']=array();
   $data['job_circular_data']=array();
   $employee_data=Employee::valid()->project()
   ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
   ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
   ->select(
      'employees.*',
      'designations.designation_name',
      'company_sbus.sbu_name'
   )
   ->get();
   $job_circular_data=JobCircular::valid()->project()
   ->leftJoin('designations', 'designations.id', '=', 'job_circulars.jc_job_position')
   ->select(
      'job_circulars.*',
      'designations.designation_name'
   )
   ->get();
   foreach ($employee_data as $value) {
      array_push($data['employee_data'],['id'=>$value['id'],'text'=>$value['employee_fullname'].' - '.$value['designation_name'].' - '.$value['sbu_name'].' - '.$value['sbu_name'].' - '.$value['employee_id_no']]);
   }
   foreach ($job_circular_data as $value) {
      array_push($data['job_circular_data'],['id'=>$value['id'],'text'=>$value['designation_name'].': '.$value['jc_circular_id']]);
   }
// $data->ibc_status = ['id'=>$data->employee_sbu,'text'=>$companysbu_data_list[$data->employee_sbu]->sbu_name];
   $data['ibc_interview_date']=date('Y-m-d');
   return response($data);
}

public function store(Request $request)
{

//   dd($request->ibc_examiner_name);
   $validate=[
      'ibc_circular_id'=>'required',
      // 'ibc_examiner_name'=>'required',
      'ibc_interview_date'=>'required',
      'ibc_interview_time'=>'required'
   ];
   $request->validate($validate);
   $data=$request->only('ibc_circular_id','ibc_examiner_name','ibc_email_status','ibc_interview_date','ibc_interview_time');

   if(!empty($request->id)){
      $update_data=InterveiwBoardCall::valid()->project()->findOrFail($request->id);
      $data['updated_by']=Auth::guard('user')->user()->branch_id;
      $save_data=$update_data->update($data);
      $message=['status' => 1, 'message' => 'Your data is successfully updated'];
   }
   else{
      $data['ibc_interview_time']=$request['ibc_interview_time']['HH'].':'.$request['ibc_interview_time']['mm'].':'.'00';
      $data['project_id']=Auth::guard('user')->user()->project_id;
      $data['branch_id']=Auth::guard('user')->user()->branch_id;
      $data['created_by']=Auth::guard('user')->user()->id;
      $save_data=InterveiwBoardCall::create($data);

      ## Email sending to examinar
      $personal_infos=EmployeePersonalInfo::valid()->project()->where('employee_id',$request->ibc_examiner_name)->first();
      $employee_basic_info=Employee::valid()->project()->where('id',$request->ibc_examiner_name)->first();
      $examiner_email = isset($personal_infos->employee_email)?$personal_infos->employee_email:'';
      $examiner_name = isset($employee_basic_info->employee_fullname)?$employee_basic_info->employee_fullname:'';
      if ($request->ibc_email_status==1 && !empty($examiner_email)) {
         $base_url = url('/');
         $user=[
            'email'=>$personal_infos->employee_email,
            'full_name'=>$employee_basic_info->employee_fullname,'You are shortlisted for interview. Thank you!',
            'email_body'=>'Greetings! You are one of the examiner.',
            'access_link'=>$base_url
         ];
         Mail::to($personal_infos->employee_email)->send(new ExaminerMail($user));
      }
      if (empty($examiner_email)) {
         $message_array[] = $examiner_name. ': Email not found!';
      }
      $message_array[] = 'Data is successfully saved';
      // return response($message_array);
      $message=['status' => 1, 'message' => $message_array];
   }
   if(!$save_data){
      $message=['status' => 0, 'message' => 'Ops! Something went worng.'];
   }
   return response($message);
}

public function edit($id)
{
   $data=InterveiwBoardCall::valid()->project()->findOrFail($id);
   $job_circular_list=JobCircular::valid()->project()
   ->leftJoin('designations', 'designations.id', '=', 'job_circulars.jc_job_position')
   ->select(
      'job_circulars.*',
      'designations.designation_name'
   )
   ->get()->keyBy('id')->all();
   $employee_data_list=Employee::valid()->project()
   ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
   ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
   ->select(
      'employees.*',
      'designations.designation_name',
      'company_sbus.sbu_name'
   )
   ->get()->keyBy('id')->all();

   if(!$data->ibc_examiner_name){
      $data->employee_name_value = ['id'=>'','text'=>''];
   }else{
      $data->employee_name_value = ['id'=>$data->ibc_examiner_name,'text'=>$employee_data_list[$data->ibc_examiner_name]->employee_fullname];
   }

   if(!$data->ibc_circular_id){
      $data->job_circular_value = ['id'=>'','text'=>''];
   }else{
      $data->job_circular_value = ['id'=>$data->ibc_circular_id,'text'=>$job_circular_list[$data->ibc_circular_id]->designation_name];
   }

   $job_circular_data=array();
   $employee_data=array();
   foreach ($job_circular_list as $value) {
      array_push($job_circular_data,['id'=>$value['id'],'text'=>$value['designation_name'].': '.$value['jc_circular_id']]);
   }
   foreach ($employee_data_list as $value) {
      array_push($employee_data,['id'=>$value['id'],'text'=>$value['employee_fullname'].' - '.$value['designation_name'].' - '.$value['sbu_name']]);
   }

   $data->job_circular_data =  $job_circular_data;
   $data->employee_data =  $employee_data;
   return response($data);

}

public function destroy($id)
{

   $delete_data=InterveiwBoardCall::valid()->project()->findOrFail($id);
   if($delete_data->delete())
   {
      $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
   }
   return response($message);

}

// public function findMaxCode(){
//   $last_entry_data=InterveiwBoardCall::latest()->first();
//   $last_code = $last_entry_data['jobgrade_code'];
//   if ($last_code==0) {
//     $last_code = 101;
//   }else{
//     $last_code = $last_code+1;
//   }
//   return $last_code;
// }

   public function emailSendToExaminer($id,$name,$email){
      $data_update= DB::table('interview_board_calls')
      ->where('id', $id)
      ->update([
         'ibc_email_status' => "1"
      ]);
      if ($data_update==1) {
         $base_url = url('/');
         $user=[
            'email'=>$email,
            'full_name'=>$name,'You are a examinar. Thank you!',
            'email_body'=>'Greetings! You are one of the examiner.',
            'access_link'=>$base_url
         ];
         Mail::to($email)->send(new ExaminerMail($user));
      }
      return response(1);
   }

   public function marksEntry(request $request)
   {
      $validate = [
            'cim_candidate_id' => 'required',
            'cim_circular_id' => 'required',
            'cim_experience_mark' => 'required',
            'cim_dressup_mark' => 'required',
            'cim_academic_mark' => 'required',
            'cim_viva_mark' => 'required',
            'cim_written_mark' => 'required',
            'cim_total_mark' => 'required'
        ];

        $data = $request->validate($validate);
        $auth = Auth::guard('user')->user();

        $candidateId = $data['cim_candidate_id'];
        $circularId = $data['cim_circular_id'];

        $data['cim_status'] = 1;
        $data['cim_created'] = now();
        $data['cim_marks_entry_by'] = $auth->id;

        $marks = DB::transaction(function () use ($candidateId, $circularId, $data) {
            $marks = DB::table('candidate_interview_marks')
                ->updateOrInsert(
                [
                    'cim_candidate_id' => $candidateId,
                    'cim_circular_id'  => $circularId
                ],
                $data
            );

            if ($data['cim_total_mark'] >= 40 && $data['cim_total_mark'] <= 50) {
                $candidate = JobApplyCandidate::findOrFail($candidateId);

                if ($candidate) {
                    $candidate->update(['jac_status' => 3]);
                }
            }

            return $marks;
        });

        return response([
            'status' => 1,
            'message' => 'The candidate mark has been saved.'
        ]);
   }
}
