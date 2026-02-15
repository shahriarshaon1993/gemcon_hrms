<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
// use Session;
use App\Model\Employee;
use App\Model\AttendanceSetup;
// use App\Model\AttendanceMachine;
use App\Model\OfficeTimeSetup;
use App\Model\AddNote;
use App\Model\EmployeeApproval;
use App\Model\UsersPersonModel;
use Cache;
// use permission;
use DB;
use App\Model\AttendanceLog;
use App\Model\NoteIssue;
use App\Mail\MailSent;
// use App\Model\UserRoleAccess;

class AddNoteController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $cache = Cache::get('permission');
  $permission = collect($cache)->where('menu_uid','=','NotesRequest')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
  foreach($permission as $child) {
      if($child['link_uid']=='add'){
          $data['add']=$child['link_uid'];
      }elseif($child['link_uid']=='edit'){
          $data['edit']=$child['link_uid'];
      }elseif($child['link_uid']=='delete') {
          $data['delete']=$child['link_uid'];
      }elseif($child['link_uid']=='approve') {
          $data['approve']=$child['link_uid'];
      }
  }   

  $paginate_num = $request->input('paginate_num');
  $search_key = $request->input('search_key');
  $search_key_velue =$request->input('search_inpu_all');

  $order = $request->input('order');
  $sort = $request->input('sort');
  // $project_id=Auth::guard('user')->user()->project_id;
  // $branch_id=Auth::guard('user')->user()->branch_id;
  // $employee_list = new Employee();
  // $employee_ids=$employee_list->Employee_id();
  // $employee_id=$employee_ids['employee_id'];


// return response()->json($search_key);
  $paginate_data = AddNote::valid()
    ->leftJoin('add_notes_approval', 'add_notes_approval.add_note_id', '=', 'add_notes.id')
    ->leftJoin('employees', 'employees.id', '=', 'add_notes.employee_id')
    ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
    ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
    ->leftJoin('note_issues', 'note_issues.id', '=', 'add_notes.add_note_issues')
    ->select('add_notes.*','employees.employee_fullname','employees.employee_reporting_to','employees.employee_id_no','company_sbus.sbu_name','designations.designation_name','note_issues.note_issue')
    ->when($search_key, function($query, $search_key){
      $query->where(function($query2)use($search_key){
        $query2->where('employees.employee_fullname','LIKE','%'.$search_key.'%');
        $query2->orWhere('employees.employee_id_no','LIKE','%'.$search_key.'%');
        $query2->orWhere('company_sbus.sbu_name','LIKE','%'.$search_key.'%');
        $query2->orWhere('designations.designation_name','LIKE','%'.$search_key.'%');
        $query2->orWhere('note_issues.note_issue','LIKE','%'.$search_key.'%');
      });
      return $query;

    })
    // ->where('add_notes.project_id',$project_id)
    // ->wherein('add_notes.employee_id',$employee_id)
    // ->where('note_approve_by', 2025)
    ->orderBy($sort,$order);

    if($search_key_velue=='Requested'){
      $paginate_data=$paginate_data->where('note_approve_status', 1);
    }else if($search_key_velue=='Pending'){
      $paginate_data=$paginate_data->whereIn('note_approve_status', [1,3]);
    }else if($search_key_velue=='Accepted'){
      $paginate_data=$paginate_data->where('note_approve_status', 2);
    }else if($search_key_velue=='Rejected'){
      $paginate_data=$paginate_data->where('note_approve_status', 4);
    }else if($search_key_velue=='AllRequested'){
      $paginate_data=$paginate_data->whereIn('note_approve_status', [1,2,3,4]);
    }else if($search_key_velue=='team'){
      $paginate_data=$paginate_data->whereIn('note_approve_status', [1,3])->where('employees.employee_reporting_to', Auth::guard('user')->user()->employee_card_no);
    }
    // ->paginate($paginate_num);

   $sortData=$paginate_data;
   $sortGetData=$sortData->get();
   $data['requestApplications']=count($sortGetData);
   $data['pendingApplications']=count(collect($sortGetData)->whereIn('note_approve_status',['1','3'])->toArray());
   $data['acceptedApplications']=count(collect($sortGetData)->where('note_approve_status',2)->toArray());
   $data['rejectedApplications']=count(collect($sortGetData)->where('note_approve_status',4)->toArray());
   $data['my_team_employees']=count(collect($sortGetData)->whereIn('note_approve_status', [1,3])->where('employee_reporting_to', Auth::guard('user')->user()->employee_card_no)->toArray());
   $data['paginate_data'] =$sortData->paginate($paginate_num);

   return response()->json($data);
}
public function store(Request $request)
{

  // if (date('Y-m-d') < date('Y-m-d', strtotime($request['add_note_date']))) {
  //   $message=['status' => 0, 'message' => 'Add Note should not exceed today date!']; return($message);
  // }
  if($request['note_type']==2){
    $validate=[
      'employee_id'=>'required',
      'add_note_issues'=>'required',
      'add_note_date'=>'required',
    ];
    $request->validate($validate);
  }else{
    if (!empty($request['out_time']) && $request['out_time'] == '00:00'){
        $message=['status' => 0, 'message' => 'Out Time not correct!']; return($message);
    }elseif(!empty($request['out_time']) && $request->id){
      $out_time = explode(":", $request['out_time']);
      if ($out_time['0'] == '00') {
        $message=['status' => 0, 'message' => 'Out Time not correct!']; return($message);    
      }
    }
    $validate=[
      'employee_id'=>'required',
      'add_note_issues'=>'required',
      'add_note_date'=>'required',
      'out_time'=>'required'
    ];
    $request->validate($validate);
  }
  $data=$request->only('employee_id','add_note_issues','add_note_date','out_time','return_time','employee_id_no','add_note_remarks');

  if(!empty($request->id))
  {   
    if (!empty($request['out_time']['HH'])) {
      $data['out_time']=$request['out_time'].':'.'00';
    }
    if (!empty($request['return_time']['HH'])) {
      $data['return_time']=$request['return_time'].':'.'00';
    }
    $update_data=AddNote::valid()->project()->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->branch_id; 
    $save_data=$update_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    
    if (!empty($request['out_time'])) {
      $data['out_time']=$request['out_time'].':'.'00';
      // $TransactionTime=$request['out_time'].':'.'00';
    }else{
      $data['out_time']='00:00:00';
      // $TransactionTime=$data['out_time'];
    }
    
    if (!empty($request['return_time'])) {
      $data['return_time']=$request['return_time'].':'.'00';
    }else{
      $data['return_time']='00:00:00';
    }
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
    $data['note_approve_status']= 2;
    $data['add_note_status']= 1;

    // $attendanceLog=[
    //             'employee_id'=>$request['employee_id_no'],
    //             'TransactionDate'=>date("Y-m-d", strtotime($request['add_note_date'])),
    //             'TransactionTime'=>$TransactionTime,
    //             'ServerRecordDate'=>date("Y-m-d"),
    //             'branch_id'=>Auth::guard('user')->user()->branch_id,
    //             'created_by'=>Auth::guard('user')->user()->id,
    //             'project_id'=>Auth::guard('user')->user()->project_id,
    //           ];
    // $attendance_log=AttendanceLog::create($attendanceLog);
    // $Attendancefinds=DB::table('attendance')
    //          ->where('employee_id',$request['employee_id'])
    //          ->where('pdate',date("Y-m-d", strtotime($request['add_note_date'])))->first();
    // if($request['note_type'] == 1){
    //   $remarks = 'Present';
    //   $pstatus = 1;
    // }else{
    //   $remarks = 'Absent';
    //   $pstatus = 3;
    // }
    // if(!empty($Attendancefinds)){
    //   $attendances =[
    //     'pstatus'=>$pstatus,
    //     'remarks'=>$remarks,
    //     'manual_id' => 2,
    //     ];
    //   $findesId=DB::table('attendance')->where('id',$Attendancefinds->id)
    //         ->update($attendances);
    // }else{
    //   $attendance_data['employee_id']= $request['employee_id'];
    //   $attendance_data['employee_card_no']=$request['employee_id_no'];
    //   $attendance_data['pdate']= date("Y-m-d", strtotime($request['add_note_date']));
    //   $attendance_data['intime']= $request['out_time'];
    //   $attendance_data['outime']= $request['return_time'];
    //   $attendance_data['latetime']= '00:00:00';
    //   $attendance_data['start_time']= $request['out_time'];
    //   $attendance_data['end_time']=  $request['return_time'];
    //   $attendance_data['shift_time']= $request['out_time'].'-'.$request['return_time'];
    //   $attendance_data['pstatus']= $pstatus;
    //   $attendance_data['status']= 1;
    //   $attendance_data['manual_id']= 2;
    //   $attendance_data['remarks']= $remarks;
    //   $attendance_data['created_at']= date("Y-m-d H:i:s");
    //   $attendance_data['created_by']= Auth::guard('user')->user()->id;
    //   $udate_data = DB::table('attendance')->insert($attendance_data);
    // }
     // return response($attendance_log);
    $save_data=AddNote::create($data);
    $message=['status' => 1, 'message' => 'Your data is successfully saved'];
  }

  if(!$save_data)

  {
    $message=['status' => 0, 'message' => 'Ops! Something went worng.'];

  }
  return response($message);
}

public function sendAddNoteRequest(Request $request){
  // return response($request);
  
  if ($request->employee_id) {
    $user_id = $request->employee_id;
    $user_data = Employee::valid()->project()->where('id',$user_id)->first();    
  }else{
    $user_id = Auth::guard('user')->user()->id;
    $user_data = UsersPersonModel::valid()->project()->join('employees', 'employees.id', '=', 'users_person.employee_id')->select('users_person.*','employees.employee_reporting_to','employees.id as emp_id','employees.employee_id_no as employee_id_no')->where('users_person.id',$user_id)->first();
  }
  if (!empty($user_data->employee_reporting_to)) {
    $employee_reporting_to = Employee::valid()->project()->select('id')->where('employee_id_no', '=', $user_data->employee_reporting_to)->first();
  }else{
    $employee_reporting_to=[];
  }

  $validate=[
     'add_note_issues'=>'required',
   ];
  $request->validate($validate);
  $data=$request->only(
      'add_note_issues',
      'add_note_date',
      'out_time',
      'return_time',
      'add_note_remarks'
  );
  if (empty($request->employee_id)) {
    $data['employee_id']= Auth::guard('user')->user()->employee_id;
  }else{
    $data['employee_id']= $request->employee_id;
  }

   if(!empty($employee_reporting_to)){
       if(!empty($request->id))
       {
         $update_data=AddNote::valid()->project()->findOrFail($request->id);
         $data['updated_by']=Auth::guard('user')->user()->branch_id; 
         $save_data=$update_data->update($data);
         $message=['status' => 1, 'message' => 'Your data is successfully updated'];
         return response($message);
       }
       else {
         $data['project_id']=Auth::guard('user')->user()->project_id;
         $data['branch_id']=Auth::guard('user')->user()->branch_id; 
         $data['created_by']=Auth::guard('user')->user()->id; 
         $data['requseted_date']= date('Y-m-d');
         $data['add_note_status']= 1;
         $data['note_approve_status']= 1;
         $data['employee_id_no']= $user_data->employee_id_no;
         // $data['note_approve_date']= 1;
         $save_data = AddNote::create($data);
         $save_ids=$save_data->id;

         /* Data sent to approval table */
         $employee_approvals_data=EmployeeApproval::valid()->project()->where('ea_employee_id',$user_data->id)->get();
         if (!$employee_approvals_data->isEmpty() && !empty($save_data)) {
           $i=0;
           $eaApprove_by=[];
           foreach ($employee_approvals_data as $key => $value) {
             $i++;
             $eaApprove_by[] = $value['ea_approve_by'];
             $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
             $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id; 
             $approve_data['created_by'] = Auth::guard('user')->user()->id; 
             $approve_data['add_note_id']= $save_ids;
             $approve_data['note_approve_by']= $value['ea_approve_by']; 
             $approve_data['note_approve_status']= 1; 
             // $approve_data['note_approve_date']= date('Y-m-d');
             $save_data=DB::table('add_notes_approval')->insert($approve_data);
             $message=['status' => 1, 'message' => 'Your data is successfully saved'];
           }
         }else{
             $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
             $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id; 
             $approve_data['created_by'] = Auth::guard('user')->user()->id; 
             $approve_data['add_note_id']= $save_data->id;
             $approve_data['note_approve_by']= $employee_reporting_to->id;
             $approve_data['note_approve_status']= 1;
             // $approve_data['note_approve_date']=date('Y-m-d');
             $save_data = DB::table('add_notes_approval')->insert($approve_data);
             $message=['status' => 1, 'message' => 'Your data is successfully saved'];
         }
       }

       if(!empty($eaApprove_by)){
        $emplyInfo = DB::table('employees')->where('id', $request->employee_id)->first();
        $templates = DB::table('email_templates')->where('template_name','note')
        ->whereRaw('FIND_IN_SET(?, company_id)', [$emplyInfo->employee_sbu])
        ->where('status', 1)
        ->first();
        if(!empty($templates)){
          $get_note_issues = NoteIssue::valid()->select('note_issue')->where('id', $request->add_note_issues)->first();
          $sents = new MailSent();
          $sents->NoteMail($add_note_issues = $get_note_issues->note_issue ?? '', $add_note_date=$request->add_note_date ?? '', $out_time=$request->out_time, $return_time=$request->return_time, $add_note_remarks=$request->add_note_remarks, $eaApprove_by, $employeeId=$user_data->id, $data1=null);
        }  
       }
    }else{
     $message=['status' => 0, 'message' => 'Sorry !, Reporting to/Superior Not Set'];
  }
  return response($message);
}

public function edit($id)
{
  //  $employee_list = new Employee();
  //  $employee_ids=$employee_list->Employee_id();
  //  $employee_id=$employee_ids['employee_id'];

  $data = AddNote::valid()
  ->leftJoin('note_issues', 'note_issues.id', '=', 'add_notes.add_note_issues')
  ->select('add_notes.*', 'note_issues.id as issue_id', 'note_issues.note_issue')
  ->project()->findOrFail($id);


  // $employee_data_list=Employee::valid()->project()
  // ->whereIn('employee_sbu',$employee_ids['sub'])
  // ->whereIn('employee_department',$employee_ids['department'])
  // ->get()->keyBy('id')->all();
  // $attendance_machine_list=AttendanceMachine::valid()->project()->get()->keyBy('id')->all();
  // $office_time_list=OfficeTimeSetup::valid()->project()->get()->keyBy('id')->all();
  $add_notes_list = NoteIssue::valid()->get()->keyBy('id')->all();
  // if(!$data->employee_id){
  //   $data->employee_name_value = ['id'=>'','text'=>'']; 
  // }else{
  //   $data->employee_name_value = ['id'=>$data->employee_id,'text'=>$employee_data_list[$data->employee_id]->employee_fullname];
  // }
  // if(!$data->attendance_machine_no){
  //   $data->attendance_machine_value = ['id'=>'','text'=>'']; 
  // }else{
  //   $data->attendance_machine_value = ['id'=>$data->attendance_machine_no,'text'=>$attendance_machine_list[$data->attendance_machine_no]->attendance_machine_name];
  // }
  // if(!$data->attendance_office_time){
  //   $data->office_time_value = ['id'=>'','text'=>'']; 
  // }else{
  //   $data->office_time_value = [
  //     'id'=>$data->attendance_office_time,
  //     'text'=>$office_time_list[$data->attendance_office_time]->office_start_time.'-'.$office_time_list[$data->attendance_office_time]->office_end_time
  //   ];
  // }
  if(!$data->add_note_issues){
    $data->note_issues_name_value = ['id'=>'','text'=>'']; 
  }else{
    $data->note_issues_name_value = ['id'=>$data->add_note_issues,'text'=>$add_notes_list[$data->add_note_issues]->note_issue];
  }
  
// return response($data);
  // $employee_data=array();
  // $attendance_machine_data=array();
  // $office_time_data=array();
  $note_issues_data=array();
  // foreach ($employee_data_list as $value) {
  //   array_push($employee_data,['id'=>$value['id'],'text'=>$value['employee_id_no']. " - " .$value['employee_fullname']]);
  // }

  // foreach ($attendance_machine_list as $value) {
  //   array_push($attendance_machine_data,['id'=>$value['id'],'text'=>$value['attendance_machine_name']]);
  // }
  // foreach ($office_time_list as $value) {
  //   array_push($office_time_data,['id'=>$value['id'],'text'=>$value['office_start_time'].'-'.$value['office_end_time']]);
  // }
  // foreach ($add_notes_list as $value) {
  //   array_push($note_issues_data,['id'=>$value['id'],'text'=>$value['note_issue']]);
  // }
  // $data->employee_data =  $employee_data;
  // $data->attendance_machine_data =  $attendance_machine_data;
  // $data->office_time_data =  $office_time_data;
  $data->note_issues_data =  $note_issues_data;
  return response($data);

}

  public function create($id=False){
      ini_set('memory_limit', '-1'); 
      $employee_list = new Employee();
      $employee_ids=$employee_list->Employee_id();
      // $employee_id=$employee_ids['employee_id'];
      $data['employee_data']=array();
      $data['attendance_machine_data']=array();
      $data['office_time_data']=array();
      $data['note_issues_data']=array();
      // ->whereIn('employee_department',$employee_ids['department'])
      $employee_data=Employee::valid()->project()->whereIn('employee_sbu',$employee_ids['sub'])->get();
      //$attendance_machine_data=AttendanceMachine::valid()->project()->get();
      $office_time_data=OfficeTimeSetup::valid()->project()->get();
      $add_notes_data = NoteIssue::valid()->project()->get();
      foreach ($employee_data as $value) {
        array_push($data['employee_data'],['id'=>$value['id'],'employee_id_no'=>$value['employee_id_no'],'text'=>$value['employee_id_no']. " - " .$value['employee_fullname']]);
      }
      // foreach ($attendance_machine_data as $value) {
      //   array_push($data['attendance_machine_data'],['id'=>$value['id'],'text'=>$value['attendance_machine_name']]);
      // }
      foreach ($office_time_data as $value) {
        array_push($data['office_time_data'],['id'=>$value['id'],'text'=>$value['office_start_time'].' - '.$value['office_end_time']]);
      }
      foreach ($add_notes_data as $value) {
        array_push($data['note_issues_data'],['id'=>$value['id'],'text'=>$value['note_issue']]);
      }
      if (!empty($id)) {
        $employee_data_list=Employee::valid()->project()->where('id',$id)->first();
        if(!$id){
          $data['employee_name_value'] = ['id'=>'','text'=>'']; 
        }else{
          $data['employee_name_value'] = ['id'=>$id,'text'=>$employee_data_list->employee_fullname];
        }
      }
      
      $data['add_note_date']=date('Y-m-d');
      $data['note_type'] = 1;

      // $auth_sbu_id = Auth::guard('user')->user()->company_sbu;
      // $office_time_data=AttendanceSetup::valid()->project()
      //                   ->leftJoin('office_time_setups','office_time_setups.id','=','attendance_setups.attendance_office_time')
      //                   ->leftJoin('employees','employees.id','=','attendance_setups.employee_id')
      //                   ->select('attendance_setups.id','attendance_setups.employee_id','attendance_setups.start_date','attendance_setups.end_date','office_time_setups.id as office_time_id','office_time_setups.office_start_time','office_time_setups.office_end_time', 'employees.employee_sbu')
      //                   ->where('employee_sbu', $auth_sbu_id)
      //                   ->get();
      // $data['shift_time_datas']=$office_time_data;    

      return response($data);
  }


  public function destroy($id)
  {
    $delete_data=AddNote::valid()->project()->findOrFail($id);
    if($delete_data->delete())
    {
      DB::table('add_notes_approval')->where('add_note_id',$id)->delete();
      $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
    }
    return response($message);
  }

  public function approveOrReject(Request $request){
    $request_id = $request->id;
    $user_id = Auth::guard('user')->user()->id;
    $user_data=UsersPersonModel::valid()->project()->where('id', $user_id)->first();
    $approval_info=EmployeeApproval::valid()->project()->where('ea_approve_by', $user_data->employee_id)->where('ea_employee_id', $request->employee_id)->first();
   $udate_data = AddNote::valid()->project()->where('id',$request_id)->first();
    if (!empty($approval_info)) {
      $ea_approval_lavel = $approval_info->ea_approval_lavel;
      $ea_employee_id = $approval_info->ea_employee_id;
      $ea_approve_by = $approval_info->ea_approve_by;
      if ($ea_approval_lavel==1) {
        if($request->approve_reject_status==1) {
          $data['note_approve_status']= 2;
          $attendanceLog=[
                'employee_id'=>$udate_data['employee_id_no'],
                'TransactionDate'=>date("Y-m-d", strtotime($udate_data['add_note_date'])),
                'TransactionTime'=>$udate_data['out_time'],
                'ServerRecordDate'=>date("Y-m-d"),
                'branch_id'=>Auth::guard('user')->user()->branch_id,
                'created_by'=>Auth::guard('user')->user()->branch_id,
                'project_id'=>Auth::guard('user')->user()->project_id,
              ];
          $attendance_log=AttendanceLog::create($attendanceLog);
        }elseif ($request->approve_reject_status==3) {
          $data['note_approve_status']= 2;
          $attendanceLog=[
                'employee_id'=>$udate_data['employee_id_no'],
                'TransactionDate'=>date("Y-m-d", strtotime($udate_data['add_note_date'])),
                'TransactionTime'=>$udate_data['out_time'],
                'ServerRecordDate'=>date("Y-m-d"),
                'branch_id'=>Auth::guard('user')->user()->branch_id,
                'created_by'=>Auth::guard('user')->user()->branch_id,
                'project_id'=>Auth::guard('user')->user()->project_id,
              ];
          $attendance_log=AttendanceLog::create($attendanceLog);
        }else{
          $data['note_approve_status']= 4;
        }
      }else{
        if ($request->approve_reject_status==1) {
          $data['note_approve_status']= 3;
        }else{
          $data['note_approve_status']= 4;
        }
      }
      $data['note_approve_date']= date("Y-m-d");
      $data['add_note_remarks']= $request->add_note_remarks;
      $data['updated_at']= date("Y-m-d H:i:s");
      $udate_data = DB::table('add_notes_approval')->where('add_note_id',$request_id)->where('note_approve_by',$ea_approve_by)->update($data);
      $udate_data = AddNote::valid()->project()->where('id',$request_id)->update(array('note_approve_status'=>$data['note_approve_status']));

      $Attendancefinds=DB::table('attendance')
      ->where('employee_id',$request['employee_id'])
      ->where('pdate',date("Y-m-d", strtotime($request['add_note_date'])))->first();
      $attends=AddNote::valid()->project()->where('id',$request_id)->first();
      if(!empty($Attendancefinds)){
          $attendances =[
          'pstatus'=>1,
          'remarks'=>'Present',
          ];
          $findesId=DB::table('attendance')->where('id',$Attendancefinds->id)
            ->update($attendances);
      }else{
          $attendance_data['employee_id']= $attends['employee_id'];
          $attendance_data['employee_card_no']=$attends['employee_id_no'];
          $attendance_data['pdate']= $attends['add_note_date'];
          $attendance_data['intime']= $attends['out_time'];
          $attendance_data['outime']= $attends['return_time'];
          $attendance_data['latetime']= '00:00:00';
          $attendance_data['start_time']= $attends['out_time'];
          $attendance_data['end_time']=  $attends['return_time'];
          $attendance_data['shift_time']= $attends['out_time'].'-'.$attends['return_time'];
          $attendance_data['pstatus']= 1;
          $attendance_data['status']= 1;
          $attendance_data['remarks']= 'Present';
          $attendance_data['created_at']= date("Y-m-d H:i:s");
          $attendance_data['created_by']= Auth::guard('user')->user()->id;
          $udate_data = DB::table('attendance')->insert($attendance_data);
      }

      if ($udate_data && $request->approve_reject_status==1) {
        $message=['status' => 1, 'message' => 'Application status updated!'];
      }else{
        $message=['status' => 1, 'message' => 'Application rejected!'];
      }
    }else{
      $message=['status' => 0, 'message' => 'You have no authorization for approval!'];
    }
    return response($message);
  }
  public function find_shift_time($employee_id=NULL){
    $employee_data=Employee::valid()->project()->where('id',$employee_id)->first();
    $shift_data=Shift::valid()->project()->where('id',$employee_data->shift_id)->first();
    $shift_start_time=date("H:i:s", strtotime($shift_data['shift_start_time']));
    $shift_end_time=date("H:i:s", strtotime($shift_data['shift_end_time']));
    $shift_data=['shift_start_time'=>$shift_start_time,'shift_end_time'=>$shift_end_time];
    return response($shift_data);
  }
  public function find_shift_time_get(Request $request){
    // return response($request);
    $employee_data=AttendanceSetup::valid()->project()->where('employee_id',$request->employee_id)
    ->where('start_date',$request->today_date)->first();
    $shift_data=OfficeTimeSetup::valid()->project()->where('id',$employee_data->attendance_office_time)->first();
    $data['out_time'] = $shift_data['office_start_time'];
    $data['return_time'] = $shift_data['office_end_time'];
    return response($data);
  }


}
