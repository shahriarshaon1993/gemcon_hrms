<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\Department;
use App\Model\Designation;
use App\Model\JobGrade;
use App\Model\LeaveType;
use App\Model\ServiceRequest;
use App\Model\ServiceRequestApproval;
use App\Model\EmployeeApproval;
use Cache;
use permission;
use App\Model\UsersPersonModel;
use DB;
use App\Model\LeaveSetup;
use App\Model\LateRequest;
use App\Model\LeaveApplication;
// use App\Notifications\ServiceRequestNotifi;
use App\Notifications\RealTimeNotification;
use App\Notifications\ServiceRequestNotifi;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Model\payroll\SalarySetting;
use App\Model\payroll\Salary;
class ServiceRequestController extends Controller
{

     // public function __construct()
     //  {
     //      $this->middleware('Auth');
     //  }


    public function index(Request $request){
      $cache=Cache::get('permission');
      $permission=collect($cache)->where('menu_uid','=','ServiceRequest')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
          }elseif($child['link_uid']=='print')  {
              $data['print']=$child['link_uid'];
          }elseif($child['link_uid']=='employment_certificate')  {
              $data['employment_certificate']=$child['link_uid'];
          }elseif($child['link_uid']=='emp_experience_print')  {
              $data['emp_experience_print']=$child['link_uid'];
          }elseif($child['link_uid']=='employee_noc')  {
              $data['employee_noc']=$child['link_uid'];
          }
      } 
      // return response($permission);
      $paginate_num = $request->input('paginate_num');
      $search_key = $request->input('search_key');
      $search_key_velue =$request->input('search_inpu_all');
      // if(($search_key =='Requested') || ($search_key=='Pending') || ($search_key=='Accepted') || ($search_key=='Rejected') || ($search_key=='team')  || ($search_key=='team') || ($search_key=='AllRequested')){
      //   $search_key = '';
      //   $search_key_velue =$request->input('search_key');
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

      $paginate_data =ServiceRequest::valid()->project()
        ->leftJoin('employees','employees.id','=','service_requests.employee_id')
        ->leftJoin('service_request_approvals','service_request_approvals.service_request_id','=','service_requests.id')
        // ->leftJoin('employees as emp','emp.id','=','service_requests.leave_reliever')
        ->select('service_requests.*','service_requests.id as id', 'employees.id as employee_id','employees.employee_id_no', 'employees.employee_reporting_to', 'employees.employee_fullname','employees.employee_reporting_to')
        ->when($search_key, function($query, $search_key){
        $query->where(function($query2)use($search_key){
          $query2->where('employees.employee_fullname','LIKE','%'.$search_key.'%');
          $query2->orWhere('employees.employee_id_no','LIKE','%'.$search_key.'%');
        });
        return $query;

      })
        // ->where('service_request_approvals.service_approve_by',Auth::guard('user')->user()->employee_id)
        // ->wherein('service_requests.employee_id',$employee_id)
        ->where('service_requests.project_id',$project_id)
        ->orderBy($sort,$order);

        if($search_key_velue=='Requested'){
          $paginate_data=$paginate_data->where('service_requests.approve_status', 1);
        }else if($search_key_velue=='Pending'){
          $paginate_data=$paginate_data->whereIn('service_requests.approve_status', [1,3]);
        }else if($search_key_velue=='Accepted'){
          $paginate_data=$paginate_data->where('service_requests.approve_status', 2);
        }else if($search_key_velue=='Rejected'){
          $paginate_data=$paginate_data->where('service_requests.approve_status', 4);
        }else if($search_key_velue=='AllRequested'){
          $paginate_data=$paginate_data->whereIn('service_requests.approve_status', [1,2,3,4]);
        }else if($search_key_velue=='team'){
          $paginate_data=$paginate_data->whereIn('service_requests.approve_status',[1,3])->where('employees.employee_reporting_to', Auth::guard('user')->user()->employee_card_no);
        }

       $sortData=$paginate_data;
       $data['paginate_data'] =$sortData->paginate($paginate_num);


       $sortGetData=$sortData->get();
       $data['requestApplications']=count($sortGetData);
       $data['pendingApplications']=count(collect($sortGetData)->whereIn('service_requests.approve_status',[1,3])->toArray());
       $data['acceptedApplications']=count(collect($sortGetData)->where('service_requests.approve_status',2)->toArray());
       $data['rejectedApplications']=count(collect($sortGetData)->where('service_requests.approve_status',4)->toArray());
       $data['my_team_employees']=count(collect($sortGetData)->whereIn('service_requests.approve_status',[1,3])->where('employee_reporting_to', Auth::guard('user')->user()->employee_card_no)->toArray());
      return response()->json($data);
    }

    public function create(){
      
        $user_id = Auth::guard('user')->user()->id;
        $user_data=UsersPersonModel::valid()->project()->where('id', $user_id)->first();
        $user_employee_data=Employee::valid()->project()
          ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
          ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->select(
            'employees.*',
            'employee_personal_infos.employee_father_name',
            'employee_personal_infos.employee_mother_name',
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

        $availedLive=ServiceRequest::valid()->project()->where('employee_id',$user_data->employee_id)->where('approve_status',2)->where('leave_apply_date','>=',$thisYearsFristday)->where('leave_apply_date','<=',date("Y-m-d"))->get();

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

        $availedLive=ServiceRequest::valid()->project()->where('employee_id',$user_id)->where('approve_status',2)->where('leave_apply_date','>=',$thisYearsFristday)->where('leave_apply_date','<=',date("Y-m-d"))->get();

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
      // $user = Employee::first();
      // $user->notify(new NotificationsServiceRequest ('Hello World'));

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
            $validate=[
               'service_type'=>'required',
             ];
            $request->validate($validate);
            $data=$request->only(
                'service_type',
                'service_date_from',
                'service_date_to',
                'service_purpose'
            );
            if (empty($request->employee_id)) {
              $data['employee_id']= Auth::guard('user')->user()->employee_id;
            }else{
              $data['employee_id']= $request->employee_id;
            }
         if(!empty($employee_reporting_to)){
             if(!empty($request->id))
             {
               $update_data=ServiceRequest::valid()->project()->findOrFail($request->id);
               $data['updated_by']=Auth::guard('user')->user()->branch_id; 
               $save_data=$update_data->update($data);
               $message=[
                 'status' => 1, 
                 'message' => 'Your data is successfully updated'
                ];
               return response($message);
             }
             else {
               $data['project_id']=Auth::guard('user')->user()->project_id;
               $data['branch_id']=Auth::guard('user')->user()->branch_id; 
               $data['created_by']=Auth::guard('user')->user()->id; 
               $data['service_date']= date('Y-m-d');
               $save_data=ServiceRequest::create($data);
               /* Data sent to approval table */
               $employee_approvals_data=EmployeeApproval::valid()->project()->where('ea_employee_id',$user_data->id)->get();
               $save_ids=$save_data->id;
               // return response($employee_approvals_data);
               if (!$employee_approvals_data->isEmpty() && !empty($save_data)) {
                 $i=0;
                 foreach ($employee_approvals_data as $key => $value) {
                   $i++;
                   $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
                   $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id; 
                   $approve_data['created_by'] = Auth::guard('user')->user()->id; 
                   $approve_data['service_request_id']= $save_ids;
                   $approve_data['service_approve_by']= $value['ea_approve_by']; 
                   $approve_data['approve_status']= 1; 
                   $save_data=DB::table('service_request_approvals')->insert($approve_data);
                  $send_to=Auth::guard('user')->user()->id;
                  $send_from=$value['ea_approve_by'];
                  $n_type=1;
                //   $admins = User::all()->filter(function($user) {
                //     return $user->hasRole('Admin');
                // });
        
                // try {
                  // ServiceRequestNotifi::send($value, new BroadcastMessage($data));
                // } catch(\Exception $e){
        
                // }

                  //  return $value->notify(new NotificationsServiceRequest(Auth::guard('user')->user(), $approve_data,$send_to,$send_from, $n_type));

                   $message=['status' => 1, 'message' => 'Your data is successfully saved'];

                 }
                 
               }else{

                   $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
                   $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id; 
                   $approve_data['created_by'] = Auth::guard('user')->user()->id; 
                   $approve_data['service_request_id']= $save_data->id;
                   $approve_data['service_approve_by']= $employee_reporting_to->id;
                   $approve_data['approve_status']= 1;
                   $send_to=Auth::guard('user')->user()->id;
                   $send_from=$employee_reporting_to->id;
                   $n_type=1;
                  //  try {
                    // $user = User::first();
                    // $employee_reporting_to->notify(new RealTimeNotification('Hello World'));
                    // $employee_reporting_to->notify(new ServiceRequestNotifi('Hello World'));
                    // ServiceRequestNotifi::send($employee_reporting_to, new BroadcastMessage($data));
                  //  } catch(\Exception $e){
          
                  //  }
                  //  return $employee_reporting_to->notify(new NotificationsServiceRequest(Auth::guard('user')->user(), $approve_data,$send_to,$send_from, $n_type));

                   $save_data = DB::table('service_request_approvals')->insert($approve_data);
                   $message=['status' => 1, 'message' => 'Your data is successfully saved'];
               }
             }
          }else{
           $message=['status' => 0, 'message' => 'Sorry !, Reporting to/Superior Not Set'];
           return response($message);

        }
         return response($message);
    }

    static function get_service_list_info($id)
    {
        $employee_data = Employee::valid()->project()->where('employee_status', 1)->where('id', $id)
            ->get();
        $data['employee_data'] = $employee_data;

        $service_list_data = ServiceRequest::valid()->project()
            ->where('service_requests.employee_id', $id)
            ->get();
        $data['service_list_data'] = $service_list_data;

        $late_approve_data = LateRequest::valid()->project()
            ->where('late_approve_requests.employee_id', $id)
            ->get();
        $data['late_approve_data'] = $late_approve_data;

        $leave_list_data = LeaveApplication::valid()->project()
            ->leftJoin('leave_types', 'leave_types.id', '=', 'leave_applications.leave_type')
            ->leftJoin('employees as emp', 'emp.id', '=', 'leave_applications.leave_reliever')
            ->select('leave_applications.*', 'leave_applications.id as id', 'leave_types.leave_type_name', 'emp.employee_fullname as reliever_name')
            ->where('leave_applications.employee_id', $id)
            ->get();

        $data['leave_list_data'] = $leave_list_data;

        $manulAttendance_list_data = DB::table('manual_attendances')
            ->where('employee_id', $id)
            ->where('manual_attendance_status', 1)
            ->get();
        $data['manulAttendance_list_data'] = $manulAttendance_list_data;


        $serviceList = [];
        foreach ($service_list_data as $key => $value) {
            if ($value['service_type'] == 1) {
                $serves_type = 'NOC (No Objection Certificate)';
            } elseif ($value['service_type'] == 2) {
                $serves_type = 'Salary Certificate';
            } elseif ($value['service_type'] == 3) {
                $serves_type = 'Pay Slip';
            }else{
                $serves_type = 'Manual Attendance';
            }
            $serviceList[] = [
                'Type' => $serves_type,
                'date' => $value['service_date'],
                'type_id' => 1,
                'status' => $value['approve_status'],
                'purpose' => $value['service_purpose'],
                'id' => $value['id'],
            ];
        }
        foreach ($late_approve_data as $key => $value) {
            $serviceList[] = [
                'Type' => 'Late Approve Request',
                'type_id' => 2,
                'date' => $value['late_request_date'],
                'status' => $value['late_approve_status'],
                'purpose' => $value['late_reason'],
                'id' => $value['id'],
            ];
        }
        foreach ($leave_list_data as $key => $value) {
            $serviceList[] = [
                'Type' => 'Leave Request',
                'type_id' => 3,
                'date' => $value['leave_apply_date'],
                'status' => $value['leave_apply_status'],
                'purpose' => $value['leave_reason'],
                'id' => $value['id'],
            ];
        }

        foreach ($manulAttendance_list_data as $key => $value) {
            $serviceList[] = [
                'Type' => 'Manual Attendance',
                'type_id' => 4,
                'date' => $value->manual_attendance_date,
                'status' => $value->manual_atten_approve_status,
                'purpose' => $value->manual_remarks,
                'id' => $value->id,
            ];
        }

        $data['serviceList'] = collect($serviceList)->sortByDesc('date')->values()->all();
        return response($data);
    }

    public function edit($id)
    {
      $data=ServiceRequest::valid()->project()->findOrFail($id);
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
      // return response($data);  

      
      $data['user_employee_data'] = $user_employee_data;
      $employee_data_list=Employee::valid()->project()->get()->keyBy('id')->all();

      $data->user_ids=Auth::guard('user')->user()->id;

      return response($data);

    }

    public function salary_certificate($id){
      $user_id = Auth::guard('user')->user()->id;
      $user_sbu_id = Auth::guard('user')->user()->company_sbu;
      $data=ServiceRequest::valid()->project()->findOrFail($id);
      $data['service_date_from'] = date("jS \of F, Y", strtotime($data->service_date_from));
      $data['service_date_to'] = date("jS \of F, Y", strtotime($data->service_date_to));
      $data['service_type'] = $data->service_type;
      $data['service_purpose'] = $data->service_purpose;
      $data['approve_status '] = $data->approve_status;
      $user_employee_data=Employee::valid()->project()
        ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
        ->leftJoin('employee_adress_details', 'employee_adress_details.ead_employee_id', '=', 'employees.id')
        ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
        ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
        ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
        ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
        ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
        ->leftJoin('districts', 'districts.id', '=', 'employee_adress_details.present_district')
        ->select(
          'employees.*',
          'employee_personal_infos.employee_father_name',
          'employee_personal_infos.employee_gender',
          'employee_personal_infos.employee_mother_name',
          'employee_adress_details.present_holding_no',
          'employee_adress_details.present_house_name',
          'employee_adress_details.present_road_no',
          'employee_adress_details.present_road_name',
          'employee_adress_details.present_vill_area',
          'employee_adress_details.present_ward_no',
          'company_sbus.sbu_name',
          'sections.section_name',
          'departments.department_name',
          'designations.designation_name',
          'sub_units.sub_unit_name',
          'work_locations.work_location_name',
          'districts.name as district_name'
        )
        ->where('employees.id',$data->employee_id)->first();
        // return response($user_employee_data);
      $data['user_employee_data'] = $user_employee_data;
      $employee_data_list=Employee::valid()->project()->get()->keyBy('id')->all();
      $data->user_ids=Auth::guard('user')->user()->id;
      $data->current_year = date('Y');
      $data->current_month = date('F');
      $data->current_day = date('d');
      if($data->current_day==11 || $data->current_day==12 || $data->current_day==13){
        $data['sup_format'] = 'th';
      }else{
        $last_date_no = substr($data->current_day, -1);
        if ($last_date_no == '1') {
          $data['sup_format'] = 'st';
        } elseif ($last_date_no == '2') {
          $data['sup_format'] = 'nd';
        } elseif ($last_date_no == '3') {
          $data['sup_format'] = 'rd';
        } else {
          $data['sup_format'] = 'th';
        }
      }
      // $data->current_date = date("jS \of F, Y");
      $data->employee_joining_date = date("jS \of F, Y", strtotime($user_employee_data->employee_joining_date));
      $data->employee_joining_day = date("d", strtotime($user_employee_data->employee_joining_date));
      if($data->employee_joining_day==11 || $data->employee_joining_day==12 || $data->employee_joining_day==13){
        $data['joining_sup_format'] = 'th';
      }else{
        $last_date_no = substr($data->employee_joining_day, -1);
        if ($last_date_no == '1') {
          $data['joining_sup_format'] = 'st';
        } elseif ($last_date_no == '2') {
          $data['joining_sup_format'] = 'nd';
        } elseif ($last_date_no == '3') {
          $data['joining_sup_format'] = 'rd';
        } else {
          $data['joining_sup_format'] = 'th';
        }
      }
      $data->employee_joining_month_year = date(" \of F, Y", strtotime($user_employee_data->employee_joining_date));
      if($user_employee_data->employee_type==1){
        $data->employee_type_value = 'permanent';
      }elseif ($user_employee_data->employee_type==2) {
        $data->employee_type_value = 'probationary';
      }elseif ($user_employee_data->employee_type==3) {
        $data->employee_type_value = 'cotractual';
      }elseif ($user_employee_data->employee_type==4) {
        $data->employee_type_value = 'temporary';
      }elseif ($user_employee_data->employee_type==5) {
        $data->employee_type_value = 'intern';
      }elseif ($user_employee_data->employee_type==6) {
        $data->employee_type_value = 'casual';
      }else{
        $data->employee_type_value = 'other';
      }
      $data->designation_name = isset($user_employee_data->designation_name)?$user_employee_data->designation_name:'';
      $data->sbu_name = isset($user_employee_data->sbu_name)?$user_employee_data->sbu_name:'';
      if($user_employee_data->employee_gender==1){
        $data['mr_ms'] = 'Ms.';
        $data['he_or_she'] = 'She';
      }elseif($user_employee_data->employee_gender==2){
        $data['mr_ms'] = 'Mr.';
        $data['he_or_she'] = 'He';
      }else{
        $data['mr_ms'] = '';
        $data['he_or_she'] = '';
      }

      $payroll_setting = SalarySetting::where('company_sbu_id',$user_employee_data->employee_sbu)->first();
      $data->basic_salary_percentage = isset($payroll_setting->basic_salary)?$payroll_setting->basic_salary:'60';
      $data->housing_allowance_percentage = isset($payroll_setting->housing_allowance)?$payroll_setting->housing_allowance:'30';
      $data->medical_allowance_percentage = isset($payroll_setting->medical_allowance)?$payroll_setting->medical_allowance:'5';
      $data->conveyance_allowance_percentage = isset($payroll_setting->conveyance_allowance)?$payroll_setting->conveyance_allowance:'10';
      $data->provident_fund_percentage = isset($payroll_setting->provident_fund)?$payroll_setting->provident_fund:'10';
      // $data->tax_deduction_percentage = isset($payroll_setting->tax_deduction)?$payroll_setting->tax_deduction:'10';
      $emp_salary = Salary::valid()->project()
            ->selectRaw(
                'salaries.*,
                sum(gross_salary) as gross_salary,
                sum(basic_salary) as basic_salary,
                sum(housing_allowance) as housing_allowance,
                sum(medical_allowance) as medical_allowance,
                sum(provident_fund_amount) as pf,
                sum(car_allowance_amount) as car_allowance_amount,
                sum(others_allowance) as others_allowance,
                sum(conveyance_allowance) as conveyance_allowance
                '
              )
            ->where('confirmation_date', '<=', date('Y-m-d'))
            ->where('employee_id', $data->employee_id)
            // ->where('salary_goes_to', 2)
            ->groupBy('entry_date')
            ->groupBy('salary_goes_to')
            ->orderBy('salary_goes_to', 'asc')
            ->get();
            $data['cash_salary'] = collect($emp_salary)->where('salary_goes_to', 1)->first();
            $cash_gross_salary = isset($data['cash_salary']['gross_salary'])?$data['cash_salary']['gross_salary']:0;
            $data['bank_salary'] = collect($emp_salary)->where('salary_goes_to', 2)->first();
            $basic_salary = collect($emp_salary)->sum('basic_salary');
            
        $data['cash_salary'] = number_format($cash_gross_salary, 2, '.', ',');
        $data['gross_salary'] = number_format(collect($emp_salary)->sum('gross_salary'), 2, '.', ',');
        $data['basic_salary'] = number_format(collect($emp_salary)->sum('basic_salary'), 2, '.', ',');
        $data['housing_allowance'] = number_format(collect($emp_salary)->sum('housing_allowance'), 2, '.', ',');
        $data['medical_allowance'] = number_format(collect($emp_salary)->sum('medical_allowance'), 2, '.', ',');
        $data['conveyance_allowance'] = number_format(collect($emp_salary)->sum('conveyance_allowance'), 2, '.', ',');
        $provident_fund_amount = ($basic_salary*$data->provident_fund_percentage)/100;
        $data['provident_fund'] = number_format(($provident_fund_amount), 2, '.', ',');
        $data['tax_deduction'] = 0; //number_format(($data['basic_salary']*0.10), 2, '.', ','); // dummay calculation need real calculation
        $salary_goes_bank = collect($emp_salary)->sum('gross_salary')-$provident_fund_amount-$data['tax_deduction'];
        // return response($salary_goes_bank);
        $data['salary_goes_bank'] = number_format($salary_goes_bank, 2, '.', ',');
        $data['total_amount_inwords'] = self::inword($salary_goes_bank);     
        $data['user_sbu_data_info'] = DB::table('company_sbus')->where('id',$user_sbu_id)->first();
        $data['employee_sbu_data_info'] = DB::table('company_sbus')->where('id',$user_employee_data->employee_sbu)->first();
        if(!empty($data['user_sbu_data_info'])){
          $data['sbu_short_name'] = $data['user_sbu_data_info']->sbu_short_name;
        }elseif(!empty($data['employee_sbu_data_info'])){
          $data['sbu_short_name'] = $data['employee_sbu_data_info']->sbu_short_name;
        }else{
          $data['sbu_short_name'] = 'GG';
        }
        $total_salary_certificate = ServiceRequest::where('service_type', 2)->where('approve_status', 2)->count();
        $data['no_of_salary_certificate'] = $total_salary_certificate+1;
        return response($data);
    }

    public static function inword ($Total_Credit_Amount){
      $number = $Total_Credit_Amount;
      $no = round($number);
      $hundred = null;
      $digits_1 = strlen($no);
      $i = 0;
      $str = array();
      $words = array('0' => '', '1' => 'One', '2' => 'Two',
      '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
      '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
      '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
      '13' => 'Thirteen', '14' => 'Fourteen',
      '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
      '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
      '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
      '60' => 'Sixty', '70' => 'Seventy',
      '80' => 'Eighty', '90' => 'Ninety');
      $digits = array('', 'Hundred', 'Thousand', 'Lac', 'Crore');
      while ($i < $digits_1) { $divider=($i==2) ? 10 : 100; $number=floor($no % $divider); $no=floor($no / $divider); $i +=($divider==10) ? 1 : 2; if ($number) { $plural=(($counter=count($str)) && $number> 9) ? '' : null;
          $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
          $str [] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred; } else $str[]=null; } $str=array_reverse($str); $result=implode('', $str); $p=$result . "Taka Only." ;
          return $p;
   }

    public function destroy($id){
      // return response($id);
      $delete_data=ServiceRequest::valid()->project()->findOrFail($id);
      if($delete_data->delete())
      {
        DB::table('service_request_approvals')->where('service_request_id',$id)->delete();
        $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
      }
      return response($message);
    }

    public function serviceCancel($id){
      // return response($id);
      $delete_data=LeaveApplication::valid()->project()->findOrFail($id);
      if($delete_data->update())
      {
        $data['leave_apply_status'] = 6;
        DB::table('leave_applications')->where('id',$id)->update($data);
        $approve['leave_approve_status'] = 6;
        DB::table('leave_approval')->where('leave_apply_id',$id)->update($approve);
        $message=['status' => 1, 'message' => 'Your request successfully sent!'];
      }
      return response($message);
    }

    public function approveOrReject(Request $request){
      $service_id = $request->id;
      $user_id = Auth::guard('user')->user()->id;
      $user_data=UsersPersonModel::valid()->project()->where('id', $user_id)->first();
      // $approval_info=EmployeeApproval::valid()->project()->where('ea_approve_by', $user_data->employee_id)->where('ea_employee_id', $request->employee_id)->first();
      // return response($approval_info);
      // if (!empty($approval_info)) {
        // $ea_approval_lavel = $approval_info->ea_approval_lavel;
        // $ea_employee_id = $approval_info->ea_employee_id;
        // $ea_approve_by = $approval_info->ea_approve_by;
        // if ($ea_approval_lavel==1) {
          if($request->approve_reject_status==1) {
            $data['approve_status']= 2;
          }elseif ($request->approve_reject_status==3) {
            $data['approve_status']= 2;
          }else{
            $data['approve_status']= 4;
          }
        // }else{
        //   if ($request->approve_reject_status==1) {
        //     $data['approve_status']= 3;
        //   }else{
        //     $data['approve_status']= 4;
        //   }
        // }
        $data['approve_date']= date("Y-m-d");
        $data['comments']= $request->leave_comments;
        // $data['leave_view_date']= date("Y-m-d");
        $data['updated_at']= date("Y-m-d H:i:s");
        $data['updated_by']= $user_id;
        $dataa['approve_status']=  $data['approve_status'];
        $dataa['comments']=  $request->comments;
      // return response($service_id);
        $udate_data = DB::table('service_request_approvals')->where('service_request_id',$service_id)->update($data);
        // $leave_data['approve_status'] = $data['approve_status'];
        $udate_data = ServiceRequest::valid()->project()->where('id',$service_id)->update($dataa);
        // ->update('approve_status',$data['approve_status']);
        if ($udate_data && $request->approve_reject_status==1) {
          $message=['status' => 1, 'message' => 'Request status updated!'];
        }else{
          $message=['status' => 1, 'message' => 'Request rejected!'];
        }
        return response($message);
      // }else{
      //   $message=['status' => 1, 'message' => 'Reporting To not set!'];
      //   return response($message);
      // }
    }

    
}
