<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\Employee;
use App\Model\LeaveAdjustment;
use App\Model\LeaveAdjustmentApproval;
use App\Model\LeaveType;
use App\Model\LeaveApplication;
use App\Model\EmployeeApproval;
use Cache;
use permission;
use App\Model\UsersPersonModel;
use DB;
use DateTime;
use App\Model\LeaveSetup;
use App\Model\CompanySbu;
class EmployeeTransferController extends Controller
{
    public function index(Request $request){
      $cache=Cache::get('permission');
      $permission=collect($cache)->where('menu_uid','=','AdjustLeaveApplication')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
      foreach($permission as $child) {
          if($child['link_uid']=='add'){
              $data['add']=$child['link_uid'];
          }elseif($child['link_uid']=='edit'){
              $data['edit']=$child['link_uid'];
          }elseif($child['link_uid']=='delete') {
              $data['delete']=$child['link_uid'];
          }elseif($child['link_uid']=='apply') {
              $data['apply']=$child['link_uid'];
          }elseif($child['link_uid']=='view') {
              $data['view']=$child['link_uid'];
          }elseif($child['link_uid']=='approve')  {
              $data['approve']=$child['link_uid'];
          }elseif($child['link_uid']=='cancel')  {
              $data['cancel']=$child['link_uid'];
          }
      }
      $paginate_num = $request->input('paginate_num');
      $search_key = $request->input('search_key');
      $order = $request->input('order');
      $sort = $request->input('sort');
      $project_id=Auth::guard('user')->user()->project_id;
      $branch_id=Auth::guard('user')->user()->branch_id;
      $employee_list = new Employee();
      $employee_ids=$employee_list->Employee_id();
      $employee_id=$employee_ids['employee_id'];

      $approvals_data=DB::table('leave_approval')->where('leave_approve_by',Auth::guard('user')->user()->employee_id)->get();

      $employee_id=array_merge($employee_id, collect(collect($approvals_data)->pluck('leave_approve_by')->unique()->values('leave_approve_by')->all())->toArray());
   
      $paginate_data =LeaveAdjustment::valid()->project()
        ->leftJoin('employees','employees.id','=','leave_adjustments.employee_id')
        // ->leftJoin('leave_types','leave_types.id','=','leave_adjustments.leave_type')
        // ->leftJoin('employees as emp','emp.id','=','leave_adjustments.leave_reliever')
        ->select('leave_adjustments.*','leave_adjustments.id as id', 'employees.id as employee_id', 'employees.employee_id_no','employees.employee_fullname')
        ->when($search_key, function($query, $search_key){
        $query->where(function($query2)use($search_key){
          $query2->where('employees.employee_fullname','LIKE','%'.$search_key.'%')
                  ->orWhere('employees.employee_id_no','LIKE','%'.$search_key.'%');
        });

        return $query;

      })->whereIn('leave_adjustments.employee_id',$employee_id)
        ->orderBy($sort,$order);
       $sortData=$paginate_data;
       $sortGetData=$sortData->get()->toArray();
       $data['requestApplications']=count($sortGetData);
       $data['pendingApplications']=count(collect($sortGetData)->whereIn('leave_apply_status',['1','3'])->toArray());
       $data['acceptedApplications']=count(collect($sortGetData)->where('leave_apply_status',2)->toArray());
       $data['rejectedApplications']=count(collect($sortGetData)->where('leave_apply_status',4)->toArray());
       $data['paginate_data'] =$sortData->paginate($paginate_num);

        
      return response()->json($data);
    }

    public function store(Request $request){
      // return response($request);
      if ($request->employee_id) {
        $user_id = $request->employee_id;
        $user_data=Employee::valid()->project()->where('id',$user_id)->first();    
      }else{
        $user_id = Auth::guard('user')->user()->id;
        $user_data=UsersPersonModel::valid()->project()->join('employees', 'employees.id', '=', 'users_person.employee_id')->select('users_person.*','employees.employee_reporting_to','employees.id as emp_id','employees.employee_id_no as employee_id_no')->where('users_person.id',$user_id)->first();
      }
      if (!empty($user_data->employee_reporting_to)) {
        $employee_reporting_to=Employee::valid()->project()->select('id')->where('employee_id_no', '=', $user_data->employee_reporting_to)->first();
      }else{
        $employee_reporting_to=[];
      }
    
      $validate=[
         'present_date'=>'required',
       ];
      $request->validate($validate);
      $data=$request->only(
          'employee_id',
          'present_date',
          'leave_adjutment_date',
          'leave_adjustment_remarks'
      );
      if (empty($request->employee_id)) {
        $data['employee_id']= Auth::guard('user')->user()->employee_id;
      }else{
        $data['employee_id']= $request->employee_id;
      }
      
       if(!empty($employee_reporting_to)){
           if(!empty($request->id))
           {
             $update_data=LeaveAdjustment::valid()->project()->findOrFail($request->id);
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
             $data['leave_adjustment_status']= 1;
             $data['leave_adj_approve_status']= 2;
             $data['updated_at']= date("Y-m-d H:i:s");
             $data['updated_by']= Auth::guard('user')->user()->id; 

             $save_data=LeaveAdjustment::create($data);
             $save_ids=$save_data->id;
             $Attendancefinds=DB::table('attendance')
             ->where('employee_id',$data['employee_id'])
             ->where('pdate',date('Y-m-d', strtotime($request->leave_adjutment_date)))->first();
             if(!empty($Attendancefinds)){
              $attendances =[
                'pstatus'=>6,
                'remarks'=>'RL',
               ];
              $findesId=DB::table('attendance')->where('id',$Attendancefinds->id)
                    ->update($attendances);
             }else{
                $attendance_data['employee_id']= $data['employee_id'];
                $attendance_data['employee_card_no']= isset($request->user_employee_data['employee_id_no'])?  $request->user_employee_data['employee_id_no']:'';
                $attendance_data['pdate']= $request->leave_adjutment_date;
                $attendance_data['intime']= '00:00:00';
                $attendance_data['outime']= '00:00:00';
                $attendance_data['latetime']= '00:00:00';
                $attendance_data['start_time']= '09:00:00';
                $attendance_data['end_time']= '18:00:00';
                $attendance_data['shift_time']= '09:00:00-18:00:00';
                $attendance_data['pstatus']= 6;
                $attendance_data['status']= 1;
                $attendance_data['remarks']= 'RL';
                $attendance_data['created_at']= date("Y-m-d H:i:s");
                $attendance_data['created_by']= Auth::guard('user')->user()->id;
                $udate_data = DB::table('attendance')->insert($attendance_data);
             }
    
             /* Data sent to approval table */
             $employee_approvals_data=EmployeeApproval::valid()->project()->where('ea_employee_id',$user_data->id)->get();
             
             if (!$employee_approvals_data->isEmpty() && !empty($save_data)) {
               $i=0;
               foreach ($employee_approvals_data as $key => $value) {
                 $i++;
                 $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
                 $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id; 
                 $approve_data['created_by'] = Auth::guard('user')->user()->id; 
                 $approve_data['leave_adjust_id']= $save_ids;
                 $approve_data['leave_adjust_approve_by']= $value['ea_approve_by']; 
                 $approve_data['leave_adj_approve_status']= 2; 
                 $approve_data['updated_at']= date("Y-m-d H:i:s");
                 $approve_data['updated_by']= Auth::guard('user')->user()->id; 
                 $save_data=LeaveAdjustmentApproval::create($approve_data);
                 $message=['status' => 1, 'message' => 'Your data is successfully saved'];
               }
             }else{
                 $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
                 $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id; 
                 $approve_data['created_by'] = Auth::guard('user')->user()->id; 
                 $approve_data['leave_adjust_id']= $save_data->id;
                 $approve_data['leave_adjust_approve_by']= $employee_reporting_to->id;
                 $approve_data['leave_adj_approve_status']= 2;
                 $approve_data['updated_at']= date("Y-m-d H:i:s");
                 $approve_data['updated_by']= Auth::guard('user')->user()->id;
                 $save_data=LeaveAdjustmentApproval::create($approve_data);
                 $message=['status' => 1, 'message' => 'Your data is successfully saved'];
             }
           }
        }else{
         $message=['status' => 0, 'message' => 'Sorry!, Reporting to/Superior Not Set'];
      }
      return response($message);
    }

    public function create($id=False){
        $user_id = Auth::guard('user')->user()->id;
        $employee_list = new Employee();
        $employee_ids=$employee_list->Employee_id();
        $employee_id=$employee_ids['employee_id'];

        $user_data=UsersPersonModel::valid()->project()->where('id', $user_id)->first();
        if (!empty($id)) {
          $employee_id = $id;
        }else{
          $employee_id = $user_data->employee_id;
        }
        $user_employee_data=Employee::valid()->project()
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
          ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
          ->select(
            'employees.*',
            'company_sbus.sbu_name',
            'sections.section_name',
            'departments.department_name',
            'designations.designation_name',
            'sub_units.sub_unit_name',
            'work_locations.work_location_name',
            'employee_personal_infos.employee_gender'
          )
         ->where('employee_status',1) ->where('employees.id',$employee_id)->first();

        $user_employee_data_all=Employee::valid()->project()
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
          ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
          ->select(
            'employees.*',
            'company_sbus.sbu_name',
            'sections.section_name',
            'departments.department_name',
            'designations.designation_name',
            'sub_units.sub_unit_name',
            'work_locations.work_location_name',
             'employee_personal_infos.employee_gender'
          )->whereIn('employee_sbu',$employee_ids['sub'])
          ->where('employee_status',1)
            ->whereIn('employee_department',$employee_ids['department'])
          ->get() ->keyBy('id');
        $thisYearsFristday= date('Y-m-d',strtotime(date("Y").'-'.'01'.'-'.'01'));
        // $leaveInfo=LeaveType::valid()->project()->get();

        if($user_employee_data['employee_gender'] == 1){
          $leaveInfo=LeaveType::valid()->project()->get();
        }else{
          $leaveInfo=LeaveType::valid()->project()->where('leave_short_type','!=','ML')->get();
        }

        $authorizedLive=LeaveSetup::valid()->project()->where('leave_status',1)->get(); 

        $availedLive=LeaveAdjustment::valid()->project()->where('employee_id',$user_data->employee_id)->where('leave_apply_status',2)->where('leave_apply_date','>=',$thisYearsFristday)->where('leave_apply_date','<=',date("Y-m-d"))->get();

        foreach ($leaveInfo as $key => $value) {
          $leaave_day_no = isset($aviledLive['leave_day_no'])?$aviledLive['leave_day_no']:0;
            $aviledLive=collect($authorizedLive)->where('leave_type',$value['id'])->first();
           $authorizedLives=collect($availedLive)->where('leave_type',$value['id'])->sum('leave_total_day');
           $prevBalance=0;
           $leaveInfo[$key]['entitlementThisYear']=$leaave_day_no; 
           $leaveInfo[$key]['previousBalance']= $prevBalance;
           $leaveInfo[$key]['totalDay']= $authorizedLives;
           $leaveInfo[$key]['totalEntitlement']=$leaave_day_no+$prevBalance;
           $leaveInfo[$key]['balance']=(($leaave_day_no+$prevBalance)-$authorizedLives);
        }
        // exit();

        $data['leaveInfo']=$leaveInfo;



        $data['user_employee_data'] = $user_employee_data;
        $data['employee_id'] = $user_employee_data->id;
        $data['user_employee_data_all'] = $user_employee_data_all;

        $data['employee_data']=array();
        $employee_data=Employee::valid()->project()->whereIn('employee_sbu',$employee_ids['sub'])->whereIn('employee_department',$employee_ids['department'])->where('employee_status',1)->get();
        foreach ($employee_data as $value) {
          array_push($data['employee_data'],['id'=>$value['id'],'text'=>$value['employee_id_no']." - ". $value['employee_fullname']]);
        }
        $data['leave_type_data']=array();
        $leave_type_data=LeaveType::valid()->project()->get();
        foreach ($leave_type_data as $value) {
          array_push($data['leave_type_data'],['id'=>$value['id'],'text'=>$value['leave_type_name']]);
        }
        $data['approvalfristId']=Employee::valid()->project()
          ->leftJoin('employee_approvals', 'employee_approvals.ea_approve_by', '=', 'employees.id')
          ->where('ea_approval_lavel',1)->where('employee_status',1)->where('ea_employee_id',$employee_id)->first();
        $data['approval2ndId']=Employee::valid()->project()
          ->leftJoin('employee_approvals', 'employee_approvals.ea_approve_by', '=', 'employees.id')
          ->where('ea_approval_lavel',2)->where('employee_status',1)->where('ea_employee_id',$employee_id)->first();
          
          // $data['leave_from_date']=date('Y-m-d');
          // $data['leave_to_date']=date('Y-m-d');

        return response($data);
    }



    public function edit($id)
    {
      $employee_list = new Employee();
      $employee_ids=$employee_list->Employee_id();
      $employee_id=$employee_ids['employee_id'];
      
      $data=LeaveAdjustment::valid()->project()->findOrFail($id);
      $data['leave_apply_date_custom'] = date('j M Y', strtotime($data->leave_apply_date));
      $data['leave_from_date_custom'] = date('l, j M Y', strtotime($data->leave_from_date));
      $data['leave_to_date_custom'] = date('l, j M Y', strtotime($data->leave_to_date));
      $data['created_at_custom'] = date('D, j M Y, h:i A', strtotime($data->created_at));
      // return response($data);
      $user_employee_data=Employee::valid()->project()
        ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
        ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
        ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
        ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
        ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
        ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
        ->select(
          'employees.*',
          'company_sbus.sbu_name',
          'sections.section_name',
          'departments.department_name',
          'designations.designation_name',
          'sub_units.sub_unit_name',
          'work_locations.work_location_name',
          'company_sbus.sbu_logo',
          'employee_personal_infos.employee_gender'
        )->whereIn('employee_sbu',$employee_ids['sub'])
        ->whereIn('employee_department',$employee_ids['department'])
        ->where('employees.id',$data->employee_id)->first(); 
      $data['employee_joining_date_custom'] = date('j M Y', strtotime($user_employee_data->employee_joining_date));
      $data['user_employee_data'] = $user_employee_data;
      $employee_data=array();
      $approvalId=DB::table('leave_adjustments_approval')->where('leave_adjust_id',$id)->get();
      $empllyIdfinds=collect($approvalId)->pluck('leave_adjust_approve_by');
      $user_employee_data=Employee::valid()->project()
        ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
        ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
        ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
        ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
        ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
        ->leftJoin('leave_adjustments_approval', 'leave_adjustments_approval.leave_adjust_approve_by', '=', 'employees.id')
        ->select(
          'employees.*',
          'company_sbus.sbu_name',
          'sections.section_name',
          'departments.department_name',
          'designations.designation_name',
          'sub_units.sub_unit_name',
          'work_locations.work_location_name',
          'leave_adjustments_approval.leave_adjust_comments',
          'leave_adjustments_approval.leave_adj_approve_status'
        )->where('employee_status',1)->whereIn('employee_sbu',$employee_ids['sub'])
        ->whereIn('employee_department',$employee_ids['department'])
        ->where('leave_adjustments_approval.leave_adjust_id',$id)
        ->whereIn('employees.id',$empllyIdfinds)->get();
      $findsId=collect($approvalId)->where('leave_adjust_approve_by',Auth::guard('user')->user()->employee_id)->whereNotIn('leave_adj_approve_status',['3','2','4'])->first();
      $data->approveData=$user_employee_data;
      if(!empty($findsId)){
        $data->approveParmition=1;
      }else{
          $data->approveParmition=0;
      }
      $employeesId=Employee::valid()->project()->where('employee_status',1)->where('employee_sbu',Auth::guard('user')->user()->company_sbu)->where('employee_department',Auth::guard('user')->user()->department)->get(); 
      $employee_ids=collect(collect($employeesId)->pluck('id')->unique()->values('id')->all())->toArray();
      // $conflictsNo=LeaveAdjustment::valid()->project()->where('leave_adjutment_date',$data['leave_adjutment_date'])->where('leave_adjutment_date',$data['leave_adjutment_date'])->whereIn('employee_id',$employee_ids)->where('leave_adj_approve_status',2)->where('employee_id','!=',Auth::guard('user')->user()->employee_id)->get();
      // $data['conflictsNo']=count($conflictsNo);
      $data->employee_data =  $employee_data;
      // $data->leave_type_data =  $leave_type_data;
      $data->user_ids=Auth::guard('user')->user()->id;
      return response($data);
    }
    public function destroy($id){
      $delete_data=LeaveAdjustment::valid()->project()->findOrFail($id);
      if($delete_data->delete())
      {
        DB::table('leave_adjustments_approval')->where('leave_adjust_id',$id)->delete();
        $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
      }
      return response($message);
    }
    

    public function leaveAdjustmentSend(Request $request){
      // return response($request);
      if ($request->employee_id) {
        $user_id = $request->employee_id;
        $user_data=Employee::valid()->project()->where('id',$user_id)->first();    
      }else{
        $user_id = Auth::guard('user')->user()->id;
        $user_data=UsersPersonModel::valid()->project()->join('employees', 'employees.id', '=', 'users_person.employee_id')->select('users_person.*','employees.employee_reporting_to','employees.id as emp_id','employees.employee_id_no as employee_id_no')->where('users_person.id',$user_id)->first();
      }
      if (!empty($user_data->employee_reporting_to)) {
        $employee_reporting_to=Employee::valid()->project()->select('id')->where('employee_id_no', '=', $user_data->employee_reporting_to)->first();
      }else{
        $employee_reporting_to=[];
      }
    
      $validate=[
         'present_date'=>'required',
       ];
      $request->validate($validate);
      $data=$request->only(
          'employee_id',
          'present_date',
          'leave_adjutment_date',
          'leave_adjustment_remarks'
      );
      if (empty($request->employee_id)) {
        $data['employee_id']= Auth::guard('user')->user()->employee_id;
      }else{
        $data['employee_id']= $request->employee_id;
      }
      
       if(!empty($employee_reporting_to)){
           if(!empty($request->id))
           {
             $update_data=LeaveAdjustment::valid()->project()->findOrFail($request->id);
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
             $data['leave_adjustment_status']= 1;
             $data['leave_adj_approve_status']= 1;
             $save_data=LeaveAdjustment::create($data);
             $save_ids=$save_data->id;
    
             /* Data sent to approval table */
             $employee_approvals_data=EmployeeApproval::valid()->project()->where('ea_employee_id',$user_data->id)->get();
             
             if (!$employee_approvals_data->isEmpty() && !empty($save_data)) {
               $i=0;
               foreach ($employee_approvals_data as $key => $value) {
                 $i++;
                 $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
                 $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id; 
                 $approve_data['created_by'] = Auth::guard('user')->user()->id; 
                 $approve_data['leave_adjust_id']= $save_ids;
                 $approve_data['leave_adjust_approve_by']= $value['ea_approve_by']; 
                 $approve_data['leave_adj_approve_status']= 1; 
                 $save_data=LeaveAdjustmentApproval::create($approve_data);
                //  $save_data=DB::table('leave_adjustments_approval')->insert($approve_data);
                //  return response($save_data);
                 $message=['status' => 1, 'message' => 'Your data is successfully saved'];
               }
             }else{
                 $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
                 $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id; 
                 $approve_data['created_by'] = Auth::guard('user')->user()->id; 
                 $approve_data['leave_adjust_id']= $save_data->id;
                 $approve_data['leave_adjust_approve_by']= $employee_reporting_to->id;
                 $approve_data['leave_adj_approve_status']= 1;
                //  $save_data = DB::table('leave_adjustments_approval')->insert($approve_data);
                 $save_data=LeaveAdjustmentApproval::create($approve_data);
                 $message=['status' => 1, 'message' => 'Your data is successfully saved'];
             }
           }
        }else{
         $message=['status' => 0, 'message' => 'Sorry!, Reporting to/Superior Not Set'];
      }
      return response($message);
    }

    public function approveOrReject(Request $request){
      // return response($request->user_employee_data['employee_id_no']);
      $adjustment_leave_id = $request->id;
      $user_id = Auth::guard('user')->user()->id;
      $user_data=UsersPersonModel::valid()->project()->where('id', $user_id)->first();
      $approval_info=EmployeeApproval::valid()->project()->where('ea_approve_by', $user_data->employee_id)->where('ea_employee_id', $request->employee_id)->first();
      if (!empty($approval_info)) {
        $ea_approval_lavel = $approval_info->ea_approval_lavel;
        $ea_employee_id = $approval_info->ea_employee_id;
        $ea_approve_by = $approval_info->ea_approve_by;
        if ($ea_approval_lavel==1) {
          if($request->approve_reject_status==1) {
            $data['leave_adj_approve_status']= 2;
          }elseif ($request->approve_reject_status==3) {
            $data['leave_adj_approve_status']= 2;
          }else{
            $data['leave_adj_approve_status']= 4;
          }
        }else{
          if ($request->approve_reject_status==1) {
            $data['leave_adj_approve_status']= 3;
          }else{
            $data['leave_adj_approve_status']= 4;
          }
        }
        $data['leave_adjust_approve_date']= date("Y-m-d");
        $data['leave_adjust_comments']= $request->leave_comments;
        $data['updated_at']= date("Y-m-d H:i:s");
        $data['updated_by']= $ea_approve_by;
        $udate_data = DB::table('leave_adjustments_approval')->where('leave_adjust_id',$adjustment_leave_id)->where('leave_adjust_approve_by',$ea_approve_by)->update($data);
        $udate_data = LeaveAdjustment::valid()->project()->where('id',$adjustment_leave_id)->update(array('leave_adj_approve_status'=>$data['leave_adj_approve_status']));
        $udate_data = 1;
        if ($udate_data && $request->approve_reject_status==1) {

          $attendance_data['employee_id']= $approval_info->ea_employee_id;
          $attendance_data['employee_card_no']= isset($request->user_employee_data['employee_id_no'])?$request->user_employee_data['employee_id_no']:'';
          $attendance_data['pdate']= $request->leave_adjutment_date;
          $attendance_data['intime']= '00:00:00';
          $attendance_data['outime']= '00:00:00';
          $attendance_data['latetime']= '00:00:00';
          $attendance_data['start_time']= '09:00:00';
          $attendance_data['end_time']= '18:00:00';
          $attendance_data['shift_time']= '09:00:00-18:00:00';
          $attendance_data['pstatus']= 6;
          $attendance_data['status']= 1;
          $attendance_data['remarks']= 'RL';
          $attendance_data['created_at']= date("Y-m-d H:i:s");
          $attendance_data['created_by']= $ea_approve_by;

          $udate_data = DB::table('attendance')->insert($attendance_data);
          $message=['status' => 1, 'message' => 'Application status updated!'];
        }else{
          $message=['status' => 1, 'message' => 'Application rejected!'];
        }
        return response($message);
      }
    }


    public function adjustment_list(Request $request){
      $employee_list = new Employee();
      $employee_ids = $employee_list->Employee_id();
      $employee_id = $employee_ids['employee_id'];
      $data['AllcompanySbuData']=$employee_list->report_filter_data()['Allcompany_sbu_data'];
      $data['company_sbu_data']=$employee_list->report_filter_data()['company_sbu_data'];
      $data['AllsectionData']=$employee_list->report_filter_data()['Allsection_data'];
      $data['section_data'] = $employee_list->report_filter_data()['section_data'];
      $data['AllsubSectionData']=$employee_list->report_filter_data()['Allsub_section_data'];
      $data['sub_section_data'] = $employee_list->report_filter_data()['sub_section_data'];
      $data['AllsubUnitData']= $employee_list->report_filter_data()['Allsub_unit_data'];
      $data['sub_unit_data'] = $employee_list->report_filter_data()['sub_unit_data'];
      $data['AllunitData']= $employee_list->report_filter_data()['Allunit_data'];
      $data['unit_data'] = $employee_list->report_filter_data()['unit_data'];
      $data['AllworkLocationData']= $employee_list->report_filter_data()['Allwork_location_data'];
      $data['work_location_data'] = $employee_list->report_filter_data()['work_location_data'];
      $data['AlldepartmentData']=$employee_list->report_filter_data()['Alldepartment_data'];
      $data['department_data'] =$employee_list->report_filter_data()['department_data'];
      $data['AllemployeeData']=$data['employee_data'] = $employee_list->report_filter_data()['employee_data'];
      $data['months_array'] = [];
      $data['today_date'] = date('Y-m-d');
      $data['report_print_date'] = date('d F Y');
      return response()->json($data);
    }

    public function adjustment_report_finding(Request $request){
      $from_date =  date("Y-m-d", strtotime($request['from_date']));
      $to_date =  date("Y-m-d", strtotime($request['to_date']));
      $employee_data_info=Employee::valid()
        ->leftJoin('attendance', 'attendance.employee_id', '=', 'employees.id')
        ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
        ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
        ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
        ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
        ->leftjoin('employee_personal_infos','employees.id','=','employee_personal_infos.employee_id')
        ->select(
            'employees.*',
            'attendance.pdate',
            'company_sbus.sbu_name',
            'departments.department_name',
            'designations.designation_name',
            'work_locations.work_location_name',
            'job_grades.jobgrade_name',
            'job_grades.insurance_amount',
            'job_grades.yearly_premium_cost',
            'employee_personal_infos.employee_dob_actual',
            'employee_personal_infos.employee_dob_certificate'
        )
        ->whereDate('attendance.pdate', '>=', $from_date)
        ->whereDate('attendance.pdate', '<=', $to_date)
        ->whereIn('attendance.pstatus', [4,5])
        ->where('attendance.intime', '!=', '00:00:00')
        ;
        if (!empty($request['id'])) {
          $employee_data_info->where('employees.employee_sbu',$request['id']);
        }
        if (!empty($request['unit_id'])) {
          $employee_data_info->where('employees.employee_unit',$request['unit_id']);
        }
        if (!empty($request['subunit_id'])) {
          $employee_data_info->where('employees.employee_sub_unit',$request['subunit_id']);
        }
        if (!empty($request['department_id'])) {
          $employee_data_info->where('employees.employee_department',$request['department_id']);
        }
        if (!empty($request['section_id'])) {
          $employee_data_info->where('employees.employee_sub_section',$request['section_id']);
        }
        if (!empty($request['department_id'])) {
          $employee_data_info->where('employees.employee_department',$request['department_id']);
        }
        if (!empty($request['section_id'])) {
          $employee_data_info->where('employees.employee_section',$request['section_id']);
        }
        if (!empty($request['subsection_id'])) {
          $employee_data_info->where('employees.employee_sub_section',$request['subsection_id']);
        }
        if (!empty($request['employee_work_location'])) {
          $employee_data_info->where('employees.employee_work_location',$request['employee_work_location']);
        }
        if (!empty($request['employeeId'])) {
          $employee_data_info->where('employees.id',$request['employeeId']);
        }
        if ($request['employee_status']==1 || $request['employee_status']==2) {
          $employee_data_info->where('employees.employee_status',$request['employee_status']);
        }
        if ($request['employee_status']==0) {
          $employee_data_info->where('employees.employee_status',$request['employee_status']);
        }
        $data['employee_adjustment_info'] = $employee_data_info->groupBy('employees.id')->orderBy('employees.id')->get();


        // return response($data['employee_adjustment_info']);
        
        $employee_all_id=collect($data['employee_adjustment_info'])->pluck('id')->toArray();
        $holiday_present_data=DB::table('attendance')
        ->whereDate('pdate', '>=', $request['from_date'])
        ->whereDate('pdate', '<=', $request['to_date'])
        ->whereIn('employee_id',$employee_all_id)
        ->whereIn('attendance.pstatus', [4,5])
        ->where('attendance.intime', '!=', '00:00:00')
        ->get();
        $data['unique_date_find'] = collect($holiday_present_data)->sortBy('pdate')->unique('pdate');
        // return response($data['unique_date_find']);
        $adjustment_leave_data=DB::table('attendance')
        ->leftJoin('leave_adjustments', 'attendance.employee_id', '=', 'leave_adjustments.employee_id')
        ->select(
            'attendance.*',
            'leave_adjustments.employee_id as la_employee_id',
            'leave_adjustments.present_date',
            'leave_adjustments.leave_adjutment_date',
        )
        ->whereIn('attendance.employee_id',$employee_all_id)
        ->whereIn('attendance.pstatus', [6])
        ->where('attendance.remarks', 'RL')
        ->get();
        // $data['holiday_present_data'] =  $holiday_present_data;
        // $data['holiday_present_data_count'] =  count($holiday_present_data);
        // $data['adjustment_leave_data'] =  $adjustment_leave_data;
        $find_comapny_info = CompanySbu::valid()->where('id', $request->id)->first();
        $data['company_name'] = isset($find_comapny_info->sbu_name)?$find_comapny_info->sbu_name: 'Gemcon Group';
        $holiday_persent_data_count_basket[] = 0;
        foreach ($data['employee_adjustment_info'] as $key => $value) {
          $data['adjustment_info'][$key]['holiday_present_data'] =collect($holiday_present_data)->where('employee_id',$value->id)->toArray();
          $data['adjustment_info'][$key]['adjustment_leave_data'] =collect($adjustment_leave_data)->where('employee_id',$value->id)->toArray();
          $data['adjustment_info'][$key]['row_count'] = count($data['adjustment_info'][$key]['holiday_present_data']);
          $employee_joining_date = isset($value['employee_joining_date'])?$value['employee_joining_date']:'';
          if (empty($employee_joining_date) || $employee_joining_date=='0000-00-00') {
            $employeoJoining = isset($value['employee_joining_date'])?$value['employee_joining_date']:'';
            if ($employeoJoining==0 || $employeoJoining=='0000-00-00') {
              $employeoJoining = '';
            }
          }
          $employeoJoining=$employee_joining_date;
          $employeoJoining1 = strtotime($employee_joining_date);
          $date2 = date('Y-m-d');
          if ($employeoJoining1) {
            $Joining = new DateTime($employeoJoining);
            $today = new Datetime(date('Y-m-d'));
            $diff = $today->diff($Joining);
            $JoiningDates=$diff->y.'.'. $diff->m;
            $JoiningDates1=$diff->y;
          }else{
            $JoiningDates='No Data!';
            $JoiningDates1=0;
          }
          $service_length=$JoiningDates;
          $service_length1=$JoiningDates1;
    
          $joining_date = isset($value['employee_joining_date']) ? $value['employee_joining_date'] : '';
          if (empty($joining_date) || $joining_date=='0000-00-00') {
            $Joining = 'Not Available';
          }else{
            // $date = date_create($joining_date);
            // $Joining =  date_format($date, 'd-M-Y');
            $Joining =  date('d-M-Y', strtotime($joining_date));
          }
          $data['adjustment_info'][$key]['employee_id'] = isset($value['id'])?$value['id']:'';
          $data['adjustment_info'][$key]['present_date'] = isset($value['pdate'])?$value['pdate']:'';
          $data['adjustment_info'][$key]['employee_id_no'] = isset($value['employee_id_no'])?$value['employee_id_no']:'';
          $data['adjustment_info'][$key]['employee_fullname'] = isset($value['employee_fullname'])?$value['employee_fullname']:'';
          $data['adjustment_info'][$key]['designation_name'] = isset($value['designation_name'])?$value['designation_name']:'';
          $data['adjustment_info'][$key]['department_name'] = isset($value['department_name'])?$value['department_name']:'';
          $data['adjustment_info'][$key]['work_location_name'] = isset($value['work_location_name'])?$value['work_location_name']:'';
          $data['adjustment_info'][$key]['employee_joining_date'] = isset($Joining)?$Joining:'';
          $data['adjustment_info'][$key]['service_length'] = isset($service_length)?$service_length:'';
          $data['adjustment_info'][$key]['employee_dob'] = isset($employee_dobs)?$employee_dobs:'';
          $data['adjustment_info'][$key]['employee_age'] = isset($employee_age)?$employee_age:'';
          $data['adjustment_info'][$key]['jobgrade_name'] = isset($value['jobgrade_name'])?$value['jobgrade_name']:'';
          $data['adjustment_info'][$key]['insurance_amount'] = isset( $value['insurance_amount'])?$value['insurance_amount']:0;
          $data['adjustment_info'][$key]['yearly_premium_cost'] = isset($value['yearly_premium_cost'])?$value['yearly_premium_cost']:0;
          $data['adjustment_info'][$key]['employee_sbu'] = isset($value['sbu_name'])?$value['sbu_name']:'';
        }
        // return response($data['adjustment_info']);
        if(!empty($data['adjustment_info'])){
          $data['row_no_collect'] = collect($data['adjustment_info'])->sortByDesc('row_count')->first()['row_count'];
        }
        $data['employee_status'] = $request['employee_status'];
        $data['report_print_date'] = date('d F Y');
        return response($data);
    }

    public function adjust_create($id=False){
      $data['adjustment_data'] =1;
      return response($data);
  }

    
}
