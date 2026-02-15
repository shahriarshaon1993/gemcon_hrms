<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\Employee;
// use App\Model\CompanySbu;
// use App\Model\Department;
// use App\Model\Designation;
// use App\Model\JobGrade;
use App\Model\LeaveType;
use App\Model\LateRequest;
// use App\Model\LateRequestApproval;
use App\Model\EmployeeApproval;
use Cache;
// use permission;
use App\Model\UsersPersonModel;
use DB;
use App\Model\LeaveSetup;
use App\Mail\MailSent;
class LateRequestController extends Controller
{

     // public function __construct()
     //  {
     //      $this->middleware('Auth');
     //  }


    public function index(Request $request){
      $cache=Cache::get('permission');
      $permission=collect($cache)->where('menu_uid','=','LateApproval')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
          }
      } 
      
      $paginate_num = $request->input('paginate_num');
      $search_key = $request->input('search_key');

      // if(($search_key =='Requested') || ($search_key=='Pending') || ($search_key=='Accepted') || ($search_key=='Rejected') || ($search_key=='team')  || ($search_key=='team') || ($search_key=='AllRequested')){
      //   $search_key = '';
        $search_key_velue =$request->input('search_inpu_all');
      // }else{
      //   $search_key = $request->input('search_key');
      //   $search_key_velue ='';
      // }

      $order = $request->input('order');
      $sort = $request->input('sort');
      $project_id=Auth::guard('user')->user()->project_id;
      $branch_id=Auth::guard('user')->user()->branch_id;
      $employee_list = new Employee();
      $employee_id=$employee_list->Employee_id();

      // $approvals_data=DB::table('late_request_approvals')->where('late_approve_by',Auth::guard('user')->user()->employee_id)->get();
      // $employee_ids=array_merge($employee_id, collect(collect($approvals_data)->pluck('late_approve_by')->unique()->values('late_approve_by')->all())->toArray());
      // return response($employee_ids);

      $paginate_data =LateRequest::valid()->project()
        ->leftJoin('employees','employees.id','=','late_approve_requests.employee_id')
        ->leftJoin('late_request_approvals','late_request_approvals.late_request_id','=','late_approve_requests.id')
        // ->leftJoin('leave_types','leave_types.id','=','late_approve_requests.leave_type')
        // ->leftJoin('employees as emp','emp.id','=','late_approve_requests.leave_reliever')
        ->select('late_approve_requests.*','late_approve_requests.id as id', 'employees.id as employee_id','employees.employee_id_no', 'employees.employee_reporting_to', 'employees.employee_fullname','employees.employee_reporting_to')
        ->when($search_key, function($query, $search_key){
        $query->where(function($query2)use($search_key){
          $query2->where('employees.employee_fullname','LIKE','%'.$search_key.'%');
          $query2->orWhere('employees.employee_id_no','LIKE','%'.$search_key.'%');
        });
        return $query;

      })
        ->where('late_request_approvals.late_approve_by', Auth::guard('user')->user()->employee_id)
        ->where('late_approve_requests.project_id',$project_id)
        ->orderBy($sort,$order);

        if($search_key_velue=='Requested'){
          $paginate_data=$paginate_data->where('late_approve_requests.late_approve_status', 1);
        }else if($search_key_velue=='Pending'){
          $paginate_data=$paginate_data->whereIn('late_approve_requests.late_approve_status', [1,3]);
        }else if($search_key_velue=='Accepted'){
          $paginate_data=$paginate_data->where('late_approve_requests.late_approve_status', 2);
        }else if($search_key_velue=='Rejected'){
          $paginate_data=$paginate_data->where('late_approve_requests.late_approve_status', 4);
        }else if($search_key_velue=='AllRequested'){
          $paginate_data=$paginate_data->whereIn('late_approve_requests.late_approve_status', [1,2,3,4]);
        }else if($search_key_velue=='team'){
          $paginate_data=$paginate_data->whereIn('late_approve_requests.late_approve_status', [1,3])->where('employees.employee_reporting_to', Auth::guard('user')->user()->employee_card_no);
        }
  
       $sortData=$paginate_data;
       $sortGetData=$sortData->get();
       $data['requestApplications']=count($sortGetData);
       $data['pendingApplications']=count(collect($sortGetData)->whereIn('late_approve_status',[1,3])->toArray());
       $data['acceptedApplications']=count(collect($sortGetData)->where('late_approve_status',2)->toArray());
       $data['rejectedApplications']=count(collect($sortGetData)->where('late_approve_status',4)->toArray());
       $data['my_team_employees']=count(collect($sortGetData)->whereIn('late_approve_status', [1,3])->where('employee_reporting_to', Auth::guard('user')->user()->employee_card_no)->toArray());
       $data['paginate_data'] =$sortData->paginate($paginate_num);
      return response()->json($data);
    }

    public function create(){
      
        $user_id = Auth::guard('user')->user()->id;
        $user_data=UsersPersonModel::valid()->project()->where('id', $user_id)->first();
        $user_employee_data=Employee::valid()->project()
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
          ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->select(
            'employees.*',
            'company_sbus.sbu_name',
            'sections.section_name',
            'departments.department_name',
            'designations.designation_name',
            'sub_units.sub_unit_name',
            'work_locations.work_location_name'
          )
          ->where('employees.id',$user_data->employee_id)->first();

        $user_employee_data_all=Employee::valid()->project()
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
          ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->select(
            'employees.*',
            'company_sbus.sbu_name',
            'sections.section_name',
            'departments.department_name',
            'designations.designation_name',
            'sub_units.sub_unit_name',
            'work_locations.work_location_name'
          )
          ->get()->keyBy('id');
        $thisYearsFristday= date('Y-m-d',strtotime(date("Y").'-'.'01'.'-'.'01'));
        $leaveInfo=LeaveType::valid()->project()->get();
        $authorizedLive=LeaveSetup::valid()->project()->where('leave_status',1)->get(); 

        $availedLive=LateRequest::valid()->project()->where('employee_id',$user_data->employee_id)->where('leave_apply_status',2)->where('leave_apply_date','>=',$thisYearsFristday)->where('leave_apply_date','<=',date("Y-m-d"))->get();

        foreach ($leaveInfo as $key => $value) {
         $aviledLive=collect($authorizedLive)->where('leave_type',$value['id'])->first();
         $authorizedLives=collect($availedLive)->where('leave_type',$value['id'])->sum('leave_total_day');
         $leaveInfo[$key]['entitlementThisYear']= $aviledLive['leave_day_no'];
         $leaveInfo[$key]['previousBalance']= 0;
         $leaveInfo[$key]['totalDay']= $authorizedLives;
         $leaveInfo[$key]['totalEntitlement']=$aviledLive['leave_day_no']+0;
         $leaveInfo[$key]['balance']=(($aviledLive['leave_day_no']+0)-$authorizedLives);
        }
        $data['leaveInfo']=$leaveInfo;
        $data['user_employee_data'] = $user_employee_data;
        $data['user_employee_data_all'] = $user_employee_data_all;

        $data['employee_data']=array();
        $employee_data=Employee::valid()->project()->get();
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
          ->where('ea_approval_lavel',1)->where('ea_employee_id',$user_data->employee_id)->first();
        $data['approval2ndId']=Employee::valid()->project()
          ->leftJoin('employee_approvals', 'employee_approvals.ea_approve_by', '=', 'employees.id')
          ->where('ea_approval_lavel',2)->where('ea_employee_id',$user_data->employee_id)->first();
        return response($data);
    }
    public function other_create($id){
        $user_id = $id;
        // $user_data=UsersPersonModel::valid()->project()->where('id', $user_id)->first();
        $user_employee_data=Employee::valid()->project()
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
          ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->select(
            'employees.*','employees.id as employee_id',
            'company_sbus.sbu_name',
            'sections.section_name',
            'departments.department_name',
            'designations.designation_name',
            'sub_units.sub_unit_name',
            'work_locations.work_location_name',
            'company_sbus.sbu_logo'
          )
          ->where('employees.id',$user_id)->first();

        $user_employee_data_all=Employee::valid()->project()
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
          ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->select(
            'employees.*',
            'company_sbus.sbu_name',
            'sections.section_name',
            'departments.department_name',
            'designations.designation_name',
            'sub_units.sub_unit_name',
            'work_locations.work_location_name'
          )
          ->get()->keyBy('id');
        $thisYearsFristday= date('Y-m-d',strtotime(date("Y").'-'.'01'.'-'.'01'));
        $leaveInfo=LeaveType::valid()->project()->get();
        $authorizedLive=LeaveSetup::valid()->project()->where('leave_status',1)->get(); 

        $availedLive=LateRequest::valid()->project()->where('employee_id',$user_id)->where('leave_apply_status',2)->where('leave_apply_date','>=',$thisYearsFristday)->where('leave_apply_date','<=',date("Y-m-d"))->get();

        foreach ($leaveInfo as $key => $value) {
         $aviledLive=collect($authorizedLive)->where('leave_type',$value['id'])->first();
         $authorizedLives=collect($availedLive)->where('leave_type',$value['id'])->sum('leave_total_day');
         $leaveInfo[$key]['entitlementThisYear']= $aviledLive['leave_day_no'];
         $leaveInfo[$key]['previousBalance']= 0;
         $leaveInfo[$key]['totalDay']= $authorizedLives;
         $leaveInfo[$key]['totalEntitlement']=$aviledLive['leave_day_no']+0;
         $leaveInfo[$key]['balance']=(($aviledLive['leave_day_no']+0)-$authorizedLives);
        }

        $data['leaveInfo']=$leaveInfo;



        $data['user_employee_data'] = $user_employee_data;
        $data['user_employee_data_all'] = $user_employee_data_all;

        // $employee_data_list=Employee::valid()->project()->get()->keyBy('id')->all();
        // if(!$data->leave_reliever){
        //  $data->employee_name_search = ['id'=>'','text'=>'']; 
        // }else{
        //  $data->employee_name_search = ['id'=>$data->leave_reliever,'text'=>$user_employee_data_all[$data->leave_reliever]->employee_fullname];
        // }

        $data['employee_data']=array();
        $employee_data=Employee::valid()->project()->get();
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
          ->where('ea_approval_lavel',1)->where('ea_employee_id',$user_id)->first();
        $data['approval2ndId']=Employee::valid()->project()
          ->leftJoin('employee_approvals', 'employee_approvals.ea_approve_by', '=', 'employees.id')
          ->where('ea_approval_lavel',2)->where('ea_employee_id',$user_id)->first();
        return response($data);
    }


    public function store(Request $request)
    {     
        if ($request->employee_id) {
          $user_id = $request->employee_id;
          $user_data=Employee::valid()->project()->where('id',$user_id)->first();    
        }else{
          $user_id = Auth::guard('user')->user()->id;
          $user_data=UsersPersonModel::valid()->project()->join('employees', 'employees.id', '=', 'users_person.employee_id')->select('users_person.*','employees.employee_reporting_to','employees.id as emp_id')->where('users_person.id',$user_id)->first();
        }
        if (!empty($user_data->employee_reporting_to)) {
          $employee_reporting_to=Employee::valid()->project()->select('id')->where('employee_id_no', '=', $user_data->employee_reporting_to)->first();
        }else{
          $employee_reporting_to=[];
        }
        //     $leave_from_date = strtotime($request->leave_from_date); 
        //     $leave_to_date = strtotime($request->leave_to_date); 
        //     $leave_from_date_check = date('Y-m-d',$leave_from_date); 
        //     $leave_to_date_check = date('Y-m-d',$leave_to_date); 
        //     $date_checking_data=LateRequest::valid()->project()
        //                         ->where('employee_id', $user_data->id)
        //                         ->whereBetween('leave_from_date', [$leave_from_date_check, $leave_to_date_check])
        //                         ->orWhereBetween('leave_to_date', [$leave_from_date_check, $leave_to_date_check])
        //                         ->first();
        //     if(empty($request->id) && $leave_from_date>$leave_to_date){
        //       $message=['status' => 0, 'message' => 'Wrong Date Range!'];
        //       return response($message);
        //     }
        //     $datediff = $leave_to_date - $leave_from_date;
        //     $leave_total_day = round($datediff / (60 * 60 * 24)) + 1;

            $validate=[
               'actual_in_time'=>'required',
             ];
            $request->validate($validate);
            $data=$request->only(
                'in_time',
                'actual_in_time',
                'late_date',
                'late_reason'
            );
            if (empty($request->employee_id)) {
              $data['employee_id']= Auth::guard('user')->user()->employee_id;
            }else{
              $data['employee_id']= $request->employee_id;
            }


         if(!empty($employee_reporting_to)){

             if(!empty($request->id))
             {
               $update_data=LateRequest::valid()->project()->findOrFail($request->id);
               $data['updated_by']=Auth::guard('user')->user()->branch_id; 
               $save_data=$update_data->update($data);
               $message=['status' => 1, 'message' => 'Your data is successfully updated'];
               return response($message);
             }
             else {
               $data['project_id']=Auth::guard('user')->user()->project_id;
               $data['branch_id']=Auth::guard('user')->user()->branch_id; 
               $data['created_by']=Auth::guard('user')->user()->id; 
               $data['late_request_date']= date('Y-m-d');
               $data['late_approve_status']= 1;
              //  $save_data = 1;
               $save_data=LateRequest::create($data);

               /* Data sent to approval table */
               $employee_approvals_data=EmployeeApproval::valid()->project()->where('ea_employee_id',$user_data->id)->get();
               $save_ids= $save_data->id;
              //  $save_ids = 1;
               if (!$employee_approvals_data->isEmpty() && !empty($save_data)) {
                 $i=0;
                 $eaApprove_by=[];
                 foreach ($employee_approvals_data as $key => $value) {
                   $i++;
                   $eaApprove_by[] = $value['ea_approve_by'];
                   $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
                   $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id; 
                   $approve_data['created_by'] = Auth::guard('user')->user()->id; 
                   $approve_data['late_request_id']= $save_ids;
                   $approve_data['late_approve_by']= $value['ea_approve_by']; 
                   $approve_data['late_approve_status']= 1; 
                   $save_data=DB::table('late_request_approvals')->insert($approve_data);
                   $message=['status' => 1, 'message' => 'Your data is successfully saved'];
                 }
               }else{
                   $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
                   $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id; 
                   $approve_data['created_by'] = Auth::guard('user')->user()->id; 
                   $approve_data['late_request_id']= $save_data->id;
                   $approve_data['late_approve_by']= $employee_reporting_to->id;
                   $approve_data['late_approve_status']= 1;
                   $save_data = DB::table('late_request_approvals')->insert($approve_data);
                   $message=['status' => 1, 'message' => 'Your data is successfully saved'];
               }

               if(!empty($eaApprove_by)){
                $emplyInfo = DB::table('employees')->where('id', $request->employee_id)->first();
                $templates = DB::table('email_templates')->where('template_name','leave')
                ->whereRaw('FIND_IN_SET(?, company_id)', [$emplyInfo->employee_sbu])
                ->first();
                
                // dd($leave_type->leave_type_name);
                if(!empty($templates)){
                  $sents = new MailSent();
                  $sents->lateMail(
                    $in_time = $request->in_time, 
                    $actual_in_time = $request->actual_in_time, 
                    $late_date = $request->late_date, 
                    $leaveReason = $request->late_reason ?? '', 
                    $eaApprove_by, 
                    $employeeId = $user_data->id,
                  );
                }
               }
             }
          }else{
           $message=['status' => 0, 'message' => 'Sorry !, Reporting to/Superior Not Set'];
           return response($message);

        }

         return response($message);
    
    }

    public function edit($id)
    {
      $data=LateRequest::valid()->project()->findOrFail($id);
      // $data['leave_apply_date_custom'] = date('j M Y', strtotime($data->leave_apply_date));
      // $data['leave_from_date_custom'] = date('l, j M Y', strtotime($data->leave_from_date));
      // $data['leave_to_date_custom'] = date('l, j M Y', strtotime($data->leave_to_date));
      // $data['created_at_custom'] = date('D, j M Y, h:i A', strtotime($data->created_at));
      // return response($data);
      $user_employee_data=Employee::valid()->project()
        ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
        ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
        ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
        ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
        ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
        ->select(
          'employees.*',
          'company_sbus.sbu_name',
          'sections.section_name',
          'departments.department_name',
          'designations.designation_name',
          'sub_units.sub_unit_name',
          'work_locations.work_location_name'
        )
        ->where('employees.id',$data->employee_id)->first(); 
      // $data['employee_joining_date_custom'] = date('j M Y', strtotime($user_employee_data->employee_joining_date));
      $data['user_employee_data'] = $user_employee_data;
      // $employee_data_list=Employee::valid()->project()->get()->keyBy('id')->all();
      // $leave_type_data_list=LeaveType::valid()->project()->get()->keyBy('id')->all();
      // if(!$data->leave_reliever){
      //  $data->employee_name_value = ['id'=>'','text'=>'']; 
      // }else{
      //  $data->employee_name_value = ['id'=>$data->leave_reliever,'text'=>$employee_data_list[$data->leave_reliever]->employee_fullname];
      // }
      // if(!$data->leave_type){
      //  $data->leave_type_value = ['id'=>'','text'=>'']; 
      // }else{
      //  $data->leave_type_value = ['id'=>$data->leave_type,'text'=>$leave_type_data_list[$data->leave_type]->leave_type_name];
      // }
      // $employee_data=array();
      // $leave_type_data=array();
      // foreach ($employee_data_list as $value) {
      //   array_push($employee_data,['id'=>$value['id'],'text'=>$value['employee_id_no']." - ". $value['employee_fullname']]);
      // }
      // foreach ($leave_type_data_list as $value) {
      //   array_push($leave_type_data,['id'=>$value['id'],'text'=>$value['leave_type_name']]);
      // }
      // $thisYearsFristday= date('Y-m-d',strtotime(date("Y").'-'.'01'.'-'.'01'));
      // $leaveInfo=LeaveType::valid()->project()->get();
      // $authorizedLive=LeaveSetup::valid()->project()->where('leave_status',1)->get(); 

      // $availedLive=LateRequest::valid()->project()->where('employee_id',$data->employee_id)->where('late_approve_status',2)->where('late_request_date','>=',$thisYearsFristday)->where('late_request_date','<=',date("Y-m-d"))->get();

      // foreach ($leaveInfo as $key => $value) {
      //  $aviledLive=collect($authorizedLive)->where('leave_type',$value['id'])->first();
      //  $authorizedLives=collect($availedLive)->where('leave_type',$value['id'])->sum('leave_total_day');
      //  $leaveInfo[$key]['entitlementThisYear']= $aviledLive['leave_day_no'];
      //  $leaveInfo[$key]['previousBalance']= 0;
      //  $leaveInfo[$key]['totalDay']= $authorizedLives;
      //  $leaveInfo[$key]['totalEntitlement']=$aviledLive['leave_day_no']+0;
      //  $leaveInfo[$key]['balance']=(($aviledLive['leave_day_no']+0)-$authorizedLives);
      // }

      // $data['leaveInfo']=$leaveInfo;
      // $data['cl']=0; $data['al']=0; $data['sl']=0;$data['el']=0;
      // foreach ($authorizedLive as $key => $value) {
      //   if($value['leave_type']==1){
      //     $data['cl']=$value['leave_day_no'];
      //   }elseif ($value['leave_type']==2) {
      //     $data['al']=$value['leave_day_no'];
      //   }elseif ($value['leave_type']==3) {
      //     $data['sl']=$value['leave_day_no'];
      //   }elseif ($value['leave_type']==4) {
      //     $data['el']=$value['leave_day_no'];
      //   }
       
      // }
      //  $data['avcl']=0; $data['aval']=0; $data['avsl']=0;$data['avel']=0;
      // foreach ($availedLive as $key => $value) {
      //   if($value['leave_type']==1){
      //     $data['avcl'] +=$value['leave_total_day'];
      //   }elseif ($value['leave_type']==2) {
      //     $data['aval'] +=$value['leave_total_day'];
      //   }elseif ($value['leave_type']==3) {
      //     $data['avsl'] +=$value['leave_total_day'];
      //   }elseif ($value['leave_type']==4) {
      //     $data['avel'] +=$value['leave_total_day'];
      //   }
      // }

      //   if(($data['cl']-$data['avcl']) > 0){
      //     $data['tcl'] =($data['cl']-$data['avcl']);
      //   }else{
      //     $data['tcl'] =0;
      //   }

      //   if(($data['al']-$data['aval']) > 0) {
      //     $data['tal'] =($data['al']-$data['aval']);
      //   }else{
      //     $data['tal'] =0;
      //   }

      //   if(($data['sl']-$data['avsl']) > 0) {
      //     $data['tsl'] =($data['sl']-$data['avsl']);
      //   }else{
      //     $data['tsl'] =0;
      //   }

      //   if (($data['el']-$data['avel']) >0) {
      //     $data['tel'] =($data['el']-$data['avel']);
      //   }else{
      //     $data['tel'] =0;
      //   }

      $approvalId=DB::table('late_request_approvals')->where('late_request_id',$id)->get();
      $empllyIdfinds=collect($approvalId)->pluck('late_approve_by');
// return response($approvalId);

      $user_employee_data=Employee::valid()->project()
        ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
        ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
        ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
        ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
        ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
        ->leftJoin('late_request_approvals', 'late_request_approvals.late_approve_by', '=', 'employees.id')
        ->select(
          'employees.*',
          'company_sbus.sbu_name',
          'sections.section_name',
          'departments.department_name',
          'designations.designation_name',
          'sub_units.sub_unit_name',
          'work_locations.work_location_name',
          'late_request_approvals.comments',
          'late_request_approvals.late_approve_status'
        )
        ->where('late_request_approvals.late_request_id',$id)
        ->whereIn('employees.id',$empllyIdfinds)->get();


      $findsId=collect($approvalId)->where('late_approve_by',Auth::guard('user')->user()->id)->whereNotIn('late_approve_status',['3','2','4'])->first();
      $data->approveData=$user_employee_data;
        if(!empty($findsId) ){
          $data->approveParmition=1;
        }else{
           $data->approveParmition=0;
        }
        
      // }

      // $data->employee_data =  $employee_data;
      // $data->leave_type_data =  $leave_type_data;
      $data->user_ids=Auth::guard('user')->user()->id;
      // $data['leave_type_data']=array();
      
      // foreach ($leave_type_data as $value) {
      //   array_push($data['leave_type_data'],['id'=>$value['id'],'text'=>$value['leave_type_name']]);
      // }

      // $edit_data=LateRequest::valid()->project()->findOrFail($id);
      return response($data);

    }
    public function destroy($id){
      $delete_data=LateRequest::valid()->project()->findOrFail($id);
      if($delete_data->delete())
      {
        DB::table('late_request_approvals')->where('late_request_id',$id)->delete();
        $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
      }
      return response($message);
    }

    public function approveOrReject(Request $request){
      // return response($request);
      $id = $request->id;
      $late_date = $request->late_date;
      $employee_id = $request->employee_id;
      $user_id = Auth::guard('user')->user()->id;
      // $employee_id = Auth::guard('user')->user()->employee_id;
      $user_data=UsersPersonModel::valid()->project()->where('id', $user_id)->first();
      $approval_info=EmployeeApproval::valid()->project()->where('ea_approve_by', $user_data->employee_id)->where('ea_employee_id', $request->employee_id)->first();
      if (!empty($approval_info)) {
        $ea_approval_lavel = $approval_info->ea_approval_lavel;
        $ea_employee_id = $approval_info->ea_employee_id;
        $ea_approve_by = $approval_info->ea_approve_by;
        if ($ea_approval_lavel==1) {
          if($request->approve_reject_status==1) {
            $data['late_approve_status']= 2;
            // $attendance_approve =  DB::table('attendance')->where('employee_id',$employee_id)->where('pdate',$late_date)->get();
            $attendance_data['pstatus']= 1;
            $attendance_data['remarks']= '(L) Late Approved';
            // return response($late_date);
            $udate_data = DB::table('attendance')->where('employee_id',$employee_id)->where('pdate',$late_date)->update($attendance_data);
          }elseif ($request->approve_reject_status==3) {
            $data['late_approve_status']= 2;
            $attendance_data['pstatus']= 1;
            $attendance_data['remarks']= '(L) Late Approved';
            $udate_data = DB::table('attendance')->where('employee_id',$employee_id)->where('pdate',$late_date)->update($attendance_data);
          }else{
            $data['late_approve_status']= 4;
          }
        }else{
          if ($request->approve_reject_status==1) {
            $data['late_approve_status']= 3;
          }else{
            $data['late_approve_status']= 4;
          }
        }
        $data['late_approve_date']= date("Y-m-d");
        $data['comments']= $request->comments;
        // $data['leave_view_date']= date("Y-m-d");
        $data['updated_at']= date("Y-m-d H:i:s");
      // return response($id);
        $udate_data = DB::table('late_request_approvals')->where('late_request_id',$id)->where('late_approve_by',$ea_approve_by)->update($data);
        // $leave_data['leave_apply_status'] = $data['late_approve_status'];
        $udate_data = LateRequest::valid()->project()->where('id',$id)->update(array('late_approve_status'=>$data['late_approve_status']));
        // ->update('leave_apply_status',$data['late_approve_status']);
        if ($udate_data && $request->approve_reject_status==1) {
          $message=['status' => 1, 'message' => 'Application status updated!'];
        }else{
          $message=['status' => 1, 'message' => 'Application rejected!'];
        }
        return response($message);
      }
    }

    
}
