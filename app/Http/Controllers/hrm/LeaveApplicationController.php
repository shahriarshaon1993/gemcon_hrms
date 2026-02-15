<?php
namespace App\Http\Controllers\hrm;
use Carbon\CarbonPeriod;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\HolidaySetup;
use App\Model\LeaveType;
use App\Model\LeaveApplication;
use App\Model\EmployeeApproval;
use App\Model\UsersPersonModel;
use App\Model\LeaveSetup;
use App\Http\Controllers\hrm\Carbon\Carbon;
use DB;
use Auth;
use Cache;
use Session;
use App\Mail\MailSent;
use App\Http\Controllers\hrm\stdClass;
class LeaveApplicationController extends Controller
{

     // public function __construct()
     //  {
     //      $this->middleware('Auth');
     //  }


    public function index(Request $request){



      // $eanlave = DB::table('excel_earned_leave_up')
      // ->leftJoin('employees', 'employees.id', '=', 'excel_earned_leave_up')
      // ->where('status',1)->get();
      // $empllyeeLis = Employee::valid()->project()->where('employee_status',1)->get();
      // foreach($eanlave as $v) {
      //   $singl=collect($empllyeeLis)->where('employee_id_no',$v->employee_id)->first();
      //   if(!empty($singl)){
      //     $earned_leave=[
      //       'employee_id'=>$singl->id,
      //       'leave_type' =>1,
      //       'date'=>'2021-12-30',
      //       'year'=>2021,
      //       'earned_day'=>$v->earned_day,
      //       'leave_status'=>1,
      //       'project_id'=>Auth::guard('user')->user()->project_id,
      //       'branch_id'=>Auth::guard('user')->user()->branch_id,
      //       'created_by'=>Auth::guard('user')->user()->id,
      //     ];
      //     DB::table('earned_leave')->insert($earned_leave);
      //     DB::table('excel_earned_leave_up')->where('status',1)->where('id',$v->id)->update([
      //       'status'=>0,
      //     ]);
      //   }
      // }
      // return response()->json($request);



      //   $leaveInfo = LeaveType::valid()->project()->where('leave_short_type','AL')->first();


      // $authorizedLive = LeaveSetup::valid()->project()->where('leave_status',1)->get();

      // $availedLive = LeaveApplication::valid()->project()->where('employee_id',$user_data->employee_id)
      // ->where('leave_apply_status',2)->where('leave_from_date','>=',$thisYearsFristday)
      // ->where('leave_to_date','<=',date("Y-m-d"))
      // ->get();
      // $earnedLeave = DB::table('earned_leave')->where('employee_id',$user_data->employee_id)
      // ->where('leave_status',1)->where('date','<',$thisYearsFristday)->get();

      // foreach ($leaveInfo as $key => $value) {
      //     // $aviledLive=collect($authorizedLive)->where('leave_type',$value['id'])->first();
      //     $authorizedLives=collect($availedLive)->where('leave_type',$value['id'])->sum('leave_total_day');
      //     // $previousBalance=collect($earnedLeave)->where('leave_type',$value['id'])->sum('earned_day');
      //     // $leaveInfo[$key]['entitlementThisYear'] = $aviledLive['leave_day_no'];
      //     // $leaveInfo[$key]['previousBalance']= $previousBalance;
      //     // $leaveInfo[$key]['totalDay']= $authorizedLives;
      //     // $leaveInfo[$key]['totalEntitlement']=$aviledLive['leave_day_no']+$previousBalance;
      //     $balance = (($aviledLive['leave_day_no'])-$authorizedLives);
      // }


      ini_set('memory_limit', '-1');
      $cache=Cache::get('permission');
      $permission=collect($cache)->where('menu_uid','=','LeaveApplication')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
      foreach ($permission as $child) {
          if ($child['link_uid']=='add') {
              $data['add']=$child['link_uid'];
          } elseif ($child['link_uid']=='edit') {
              $data['edit']=$child['link_uid'];
          } elseif ($child['link_uid']=='delete') {
              $data['delete']=$child['link_uid'];
          } elseif ($child['link_uid']=='apply') {
              $data['apply']=$child['link_uid'];
          } elseif ($child['link_uid']=='view') {
              $data['view']=$child['link_uid'];
          } elseif ($child['link_uid']=='approve') {
              $data['approve']=$child['link_uid'];
          } elseif ($child['link_uid']=='cancel') {
              $data['cancel']=$child['link_uid'];
          }
      }
      $paginate_num = $request->input('paginate_num');
      $search_key = $request->input('search_key');
      // $search_key_all=$request->input('search_inpu_all');

      // if(($search_key_all =='Requested') || ($search_key_all=='Pending') || ($search_key_all=='Accepted') || ($search_key_all=='Rejected') || ($search_key_all=='team') || ($search_key_all=='AllRequested')){
      //   $search_key_all = '';
        $search_key_velue =$request->input('search_inpu_all');
      // }else{
      //   $search_key_all = $request->input('search_inpu_all');
      //   $search_key_velue ='';
      // }

      $order = $request->input('order');
      $sort = $request->input('sort');
      $project_id=Auth::guard('user')->user()->project_id;
      // $branch_id=Auth::guard('user')->user()->branch_id;
      $employee_list = new Employee();
      $employee_ids=$employee_list->Employee_id();
      $employee_id=$employee_ids['employee_id'];

      $approvals_data=DB::table('leave_approval')->where('leave_approve_by',Auth::guard('user')->user()->employee_id)->get();

      $employee_id=array_merge($employee_id, collect(collect($approvals_data)->pluck('leave_approve_by')->unique()->values('leave_approve_by')->all())->toArray());

      $paginate_data =LeaveApplication::valid()->project()
        ->leftJoin('employees','employees.id','=','leave_applications.employee_id')
        ->leftJoin('leave_types','leave_types.id','=','leave_applications.leave_type')
        ->leftJoin('employees as emp','emp.id','=','leave_applications.leave_reliever')
        ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
        ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
        ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
        ->select('leave_applications.*','leave_applications.id as id', 'employees.id as employee_id', 'employees.employee_id_no','employees.employee_fullname','employees.employee_reporting_to','leave_types.leave_type_name','emp.employee_fullname as reliever_name','company_sbus.sbu_name','departments.department_name','designations.designation_name','work_locations.work_location_name')
        ->when($search_key, function($query, $search_key){
        $query->where(function($query2)use($search_key){
          $query2->where('employees.employee_fullname','LIKE','%'.$search_key.'%')
                  ->orWhere('employees.employee_id_no','LIKE','%'.$search_key.'%')
                  ->orWhere('company_sbus.sbu_name','LIKE','%'.$search_key.'%')
                  ->orWhere('departments.department_name','LIKE','%'.$search_key.'%')
                  ->orWhere('designations.designation_name','LIKE','%'.$search_key.'%')
                  ->orWhere('work_locations.work_location_name','LIKE','%'.$search_key.'%');
                  // ->orWhere('employees.employee_id_no','LIKE','%'.$search_key.'%');  1```
        });
        return $query;
      })->whereIn('leave_applications.employee_id',$employee_id)
        ->where('leave_applications.project_id',$project_id)
        ->orderBy($sort,$order);

        if($search_key_velue=='Requested'){
          $paginate_data=$paginate_data->where('leave_applications.leave_apply_status', 1);
        }else if($search_key_velue=='Pending'){
          $paginate_data=$paginate_data->whereIn('leave_applications.leave_apply_status', ['1','3']);
        }else if($search_key_velue=='Accepted'){
          $paginate_data=$paginate_data->where('leave_applications.leave_apply_status', 2);
        }else if($search_key_velue=='Rejected'){
          $paginate_data=$paginate_data->where('leave_applications.leave_apply_status', 4);
        }else if($search_key_velue=='AllRequested'){
          $paginate_data=$paginate_data->whereIn('leave_applications.leave_apply_status', [1,2,3,4]);
        }else if($search_key_velue=='team'){
          $paginate_data=$paginate_data->whereIn('leave_apply_status',[1,3])->where('employees.employee_reporting_to', Auth::guard('user')->user()->employee_card_no);
        }


       $sortData=$paginate_data;
       $data['paginate_data'] =$sortData->paginate($paginate_num);
       $sortGetData=LeaveApplication::leftJoin('employees','employees.id','=','leave_applications.employee_id')
       ->valid()->project()->whereIn('leave_applications.employee_id',$employee_id)->get()->toArray();
       $data['requestApplications']=count($sortGetData);
       $data['onlyRequested']=count(collect($sortGetData)->where('leave_apply_status',1)->toArray());
       $data['pendingApplications']=count(collect($sortGetData)->whereIn('leave_apply_status',['1','3'])->toArray());
       $data['acceptedApplications']=count(collect($sortGetData)->where('leave_apply_status',2)->toArray());
       $data['rejectedApplications']=count(collect($sortGetData)->where('leave_apply_status',4)->toArray());
       $data['my_team_employees']=count(collect($sortGetData)->whereIn('leave_apply_status',[1,3])->where('employee_reporting_to', Auth::guard('user')->user()->employee_card_no)->toArray());
      //  $data['my_team_employees'] = count(collect(collect($sortGetData)->where('employee_reporting_to', Auth::guard('user')->user()->employee_card_no))->toArray());
      return response()->json($data);
    }
    public function create($id=False){
        $user_id = Auth::guard('user')->user()->id;
        // $employee_list = new Employee();
        // $employee_ids = $employee_list->Employee_id();
        $employee_ids = Session::get('employee_ids');
        // $employee_id = $employee_ids['employee_id'];
        $find_today = date('Y-m-d');
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
            'employee_personal_infos.employee_gender',
            DB::raw('(DATEDIFF(NOW(), employee_joining_date))/365 as service_length'),
          )
         ->where('employee_status',1)
        //  ->where('employee_joining_date', '<=', $find_today)
         ->where('employees.id',$employee_id)->first();

        // $user_employee_data_all=Employee::valid()->project()
        //   ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        //   ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
        //   ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
        //   ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          // ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
          // ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          // ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
        //   ->select(
        //     'employees.*',
            // 'company_sbus.sbu_name',
            // 'sections.section_name',
            // 'departments.department_name',
            // 'designations.designation_name',
            // 'sub_units.sub_unit_name',
            // 'work_locations.work_location_name',
            //  'employee_personal_infos.employee_gender',
            //  DB::raw('(DATEDIFF(NOW(), employee_joining_date))/365 as service_length'
      // ),
        //   )->whereIn('employee_sbu', $employee_ids['sub'])
        //   ->where('employee_status',1)
        //   // ->whereIn('employee_department',$employee_ids['department'])
        //   ->where('employee_joining_date', '<=', $find_today)
        //   ->get()->keyBy('id');
        $thisYearsFristday= date('Y-m-d',strtotime(date("Y").'-'.'01'.'-'.'01'));
        // $leaveInfo=LeaveType::valid()->project()->get();
        // return response('dddd');
        if(!empty($user_employee_data)){
            if($user_employee_data['employee_gender'] == 1){
              $leaveInfo=LeaveType::valid()->project()->get();
              $data['leave_status_rowspan'] = 6;
            }else{
              $leaveInfo=LeaveType::valid()->project()->where('leave_short_type','!=','ML')->get();
              $data['leave_status_rowspan'] = 5;
            }

            $authorizedLive = LeaveSetup::valid()->project()->where('leave_status',1)->get();

            $availedLive=LeaveApplication::valid()->project()->where('employee_id', $employee_id)->where('leave_apply_status',2)
            ->where('leave_from_date','>=',$thisYearsFristday)->where('leave_from_date','<=',date("Y-m-d"))
            ->get();

            $availedLiveML=LeaveApplication::valid()->project()
            ->leftJoin('leave_types', 'leave_types.id', '=', 'leave_applications.leave_type')
            ->where('leave_short_type', 'ML')
            ->where('employee_id',$user_id)
            ->where('leave_apply_status', 2)
            ->get();

            // return response($availedLive);

            $earnedLeave=DB::table('earned_leave')->where('employee_id',$employee_id)->where('leave_status',1)->where('date','<',$thisYearsFristday)->get();

            $data['find_confirmation_date'] = $find_confirmation_date = $user_employee_data->employee_confirmation_due_date;
            $data['find_today'] = $find_today = date('Y-m-d');
            // echo"<pre>";
            // print_r($user_employee_data->employee_type);
            // exit();
            foreach ($leaveInfo as $key => $value) {
              //  code for meena bazar start
              if($user_employee_data->employee_sbu == 2 || $user_employee_data->employee_sbu == 11 || $user_employee_data->employee_sbu == 27){
                $running_year = date('Y');
                $joining_year = date ('Y', strtotime($user_employee_data->employee_joining_date));
                $year_end = new DateTime(date('Y-m-d', strtotime('12/31')));
                $today_date = new DateTime(date('Y-m-d'));
                if($joining_year == $running_year){
                  $joining_date = new DateTime($user_employee_data->employee_joining_date);
                  $interval = $joining_date->diff($today_date);
                  $working_days = $interval->format('%a') + 1;
                }else{
                  $year_start = new DateTime(date('Y-m-d', strtotime('01/01')));
                  $interval = $year_start->diff($year_end);
                  $working_days = $interval->format('%a') + 1;
                }
                $aviledLive=collect($authorizedLive)->where('leave_type', $value['id'])->first();
                if(!empty($aviledLive['leave_day_no'])){
                  $aviledLive_leave_day_no = $aviledLive['leave_day_no'];
                }else{
                  $aviledLive_leave_day_no = 0;
                }
                $aviledLive_leave_day_no = round(($aviledLive_leave_day_no * $working_days) / 365);
                if($value['leave_short_type'] == 'ML'){
                  $authorizedLives=collect($availedLiveML)->where('leave_type',$value['id'])->sum('leave_total_day');
                }else{
                  $authorizedLives=collect($availedLive)->where('leave_from_date','>=',$thisYearsFristday)->where('leave_from_date','<=',date("Y-m-d"))->where('leave_type',$value['id'])->sum('leave_total_day');
                } 
                $previousBalance=collect($earnedLeave)->where('leave_type',$value['id'])->sum('earned_day');
                $leaveInfo[$key]['entitlementThisYear']= $aviledLive_leave_day_no;
                $leaveInfo[$key]['previousBalance']= $previousBalance ?? 0;
                $leaveInfo[$key]['totalDay']= $authorizedLives; // availed
                $leaveInfo[$key]['totalEntitlement'] = $aviledLive_leave_day_no+$previousBalance;
                $leaveInfo[$key]['balance'] = (($aviledLive_leave_day_no+$previousBalance)-$authorizedLives);
              }else{
              //  code for meena bazar end
                if(($find_confirmation_date > $find_today) || ($user_employee_data->employee_type != 1)){
                    if($value['leave_short_type'] == 'CL'){
                        $aviledLive_leave_day_no = 3;
                        $authorizedLives=collect($availedLive)->where('leave_type',$value['id'])->sum('leave_total_day');
                        $previousBalance=collect($earnedLeave)->where('leave_type',$value['id'])->sum('earned_day');
                        $leaveInfo[$key]['entitlementThisYear']= $aviledLive_leave_day_no;
                        $leaveInfo[$key]['previousBalance']= $previousBalance ?? 0;
                        $leaveInfo[$key]['totalDay']= $authorizedLives;
                        $leaveInfo[$key]['totalEntitlement'] = $aviledLive_leave_day_no+$previousBalance;
                        $leaveInfo[$key]['balance'] = (($aviledLive_leave_day_no+$previousBalance)-$authorizedLives);
                    }
                }else{
                    $running_year = date('Y');
                    $joining_year = date ('Y', strtotime($user_employee_data->employee_joining_date));
                    $year_end = new DateTime(date('Y-m-d', strtotime('12/31')));
                    $today_date = new DateTime(date('Y-m-d'));
                    if($joining_year == $running_year){
                    $joining_date = new DateTime($user_employee_data->employee_joining_date);
                    $interval = $joining_date->diff($today_date);
                    $working_days = $interval->format('%a') + 1;
                    }else{
                    $year_start = new DateTime(date('Y-m-d', strtotime('01/01')));
                    $interval = $year_start->diff($year_end);
                    $working_days = $interval->format('%a') + 1;
                    }
                    $aviledLive=collect($authorizedLive)->where('leave_type', $value['id'])->first();
                    if(!empty($aviledLive['leave_day_no'])){
                    $aviledLive_leave_day_no = $aviledLive['leave_day_no'];
                    }else{
                    $aviledLive_leave_day_no = 0;
                    }
                    $aviledLive_leave_day_no = round(($aviledLive_leave_day_no * $working_days) / 365);
                    if($value['leave_short_type'] == 'ML'){
                      $authorizedLives=collect($availedLiveML)->where('leave_type',$value['id'])->sum('leave_total_day');
                    }else{
                      $authorizedLives=collect($availedLive)->where('leave_from_date','>=',$thisYearsFristday)->where('leave_from_date','<=',date("Y-m-d"))->where('leave_type',$value['id'])->sum('leave_total_day');
                    }
                    $previousBalance=collect($earnedLeave)->where('leave_type',$value['id'])->sum('earned_day');
                    $leaveInfo[$key]['entitlementThisYear']= $aviledLive_leave_day_no;
                    $leaveInfo[$key]['previousBalance']= $previousBalance ?? 0;
                    $leaveInfo[$key]['totalDay']= $authorizedLives; // availed
                    $leaveInfo[$key]['totalEntitlement'] = $aviledLive_leave_day_no+$previousBalance;
                    $leaveInfo[$key]['balance'] = (($aviledLive_leave_day_no+$previousBalance)-$authorizedLives);
                }
              }
            }

            $data['leaveInfo']=$leaveInfo;
            $data['user_employee_data'] = $user_employee_data;
            $data['employee_id'] = $user_employee_data->id;
            $data['employee_sbu'] = $user_employee_data->employee_sbu;
            // $data['user_employee_data_all'] = $user_employee_data_all;

            $data['employee_data'] = array();
            $employee_data = Employee::valid()->project()
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->select(
              'employees.*',
              'designations.designation_name', 
              'company_sbus.sbu_name',
              'sections.section_name',
              'departments.department_name',
              'designations.designation_name',
              'sub_units.sub_unit_name',
              'work_locations.work_location_name',
              'employee_personal_infos.employee_gender',
               DB::raw('(DATEDIFF(NOW(), employee_joining_date))/365 as service_length')
            )
            ->whereIn('employee_sbu',$employee_ids['sub'])
            // ->whereIn('employees.id',$employee_ids['employee_id'])
            ->where('employee_status',1)
            ->where('employee_joining_date', '<=', $find_today)
            ->get()->keyBy('id');
            foreach ($employee_data as $value) {
              array_push($data['employee_data'],
              [
                'id'=>$value['id'],
                'text'=>$value['employee_id_no']." - ". $value['employee_fullname']." - ". $value['designation_name']." - ". $value['sbu_name'],
                'designation_name' => $value['designation_name'],
                'sbu_name' => $value['sbu_name'],
                'employee_sbu' => $value['employee_sbu'],
                'employee_mobile'=> $value['official_mobile_no'] ?? $value['employee_mobile'] ?? ''
              ]);
            }
            $data['leave_type_data']=array();
            // $leave_type_data=LeaveType::valid()->project()->get();
            foreach ($leaveInfo as $value) {
              if($user_employee_data->employee_sbu == 2 || $user_employee_data->employee_sbu == 11 || $user_employee_data->employee_sbu == 27){
                array_push($data['leave_type_data'],['id'=>$value['id'],'text'=>$value['leave_type_name']]);
              }else{
                if($user_employee_data->employee_type == 2){
                  if($value['leave_short_type'] == 'CL'){
                    array_push($data['leave_type_data'],['id'=>$value['id'],'text'=>$value['leave_type_name']]);
                  }
                }else{
                  array_push($data['leave_type_data'],['id'=>$value['id'],'text'=>$value['leave_type_name']]);
                }
  
              }
            }
            $data['approvalfristId']=Employee::valid()->project()
            ->leftJoin('employee_approvals', 'employee_approvals.ea_approve_by', '=', 'employees.id')
            ->where('ea_approval_lavel',1)->where('employee_status',1)->where('ea_employee_id',$employee_id)->first();
            $data['approval2ndId']=Employee::valid()->project()
            ->leftJoin('employee_approvals', 'employee_approvals.ea_approve_by', '=', 'employees.id')
            ->where('ea_approval_lavel',2)->where('employee_status',1)->where('ea_employee_id',$employee_id)->first();
            return response($data);
    }else{
        return response(['status'=>0,'message'=>'Employee basic data not available!']);
    }



    }
    public function other_create($id){
        // $employee_list = new Employee();
        // $employee_ids=$employee_list->Employee_id();
        $employee_ids = Session::get('employee_ids');
        // $employee_id = $employee_ids['employee_id'];
        $user_id = $id;
        $find_today = date('Y-m-d');
        // $user_data=UsersPersonModel::valid()->project()->where('id', $user_id)->first();
        $user_employee_data=Employee::valid()->project()
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
          ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
          ->select(
            'employees.*','employees.id as employee_id',
            'company_sbus.sbu_name',
            'sections.section_name',
            'departments.department_name',
            'designations.designation_name',
            'sub_units.sub_unit_name',
            'work_locations.work_location_name',
            'company_sbus.sbu_logo',
            'employee_personal_infos.employee_gender',
            DB::raw('(DATEDIFF(NOW(), employee_joining_date))/365 as service_length'),
          )->where('employee_status',1)->where('employee_status',1)
          // ->where('employee_joining_date', '<=', $find_today)
          ->where('employees.id',$user_id)->first();

        // $user_employee_data_all=Employee::valid()->project()
        //   ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        //   ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
        //   ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
        //   ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
        //   ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
        //   ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
        //   ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
        //   ->select(
        //     'employees.*',
        //     'company_sbus.sbu_name',
        //     'sections.section_name',
        //     'departments.department_name',
        //     'designations.designation_name',
        //     'sub_units.sub_unit_name',
        //     'work_locations.work_location_name',
        //     'employee_personal_infos.employee_gender',
        //     DB::raw('(DATEDIFF(NOW(), employee_joining_date))/365 as service_length'),
        //   )->where('employee_status',1)->where('employee_status',1)->whereIn('employee_sbu',$employee_ids['sub'])
        //   // ->whereIn('employee_department',$employee_ids['department'])
        //   ->where('employee_joining_date', '<=', $find_today)
        //   ->get()->keyBy('id');

        $thisYearsFristday= date('Y-m-d',strtotime(date("Y").'-'.'01'.'-'.'01'));


        if($user_employee_data['employee_gender'] == 1){
          $leaveInfo=LeaveType::valid()->project()->get();
          $data['leave_status_rowspan'] = 6;
        }else{
          $leaveInfo=LeaveType::valid()->project()->where('leave_short_type','!=','ML')->get();
          $data['leave_status_rowspan'] = 5;
        }

        $authorizedLive=LeaveSetup::valid()->project()->where('leave_status',1)->get();

        $availedLive=LeaveApplication::valid()->project()->where('employee_id',$user_id)
        ->where('leave_apply_status', 2)
        ->where('leave_from_date','>=',$thisYearsFristday)
        ->where('leave_from_date','<=',date("Y-m-d"))
        ->get();

        $availedLiveML=LeaveApplication::valid()->project()
        ->leftJoin('leave_types', 'leave_types.id', '=', 'leave_applications.leave_type')
        ->where('leave_short_type', 'ML')
        ->where('employee_id',$user_id)
        ->where('leave_apply_status', 2)
        ->get();

        //  return response($availedLive);

        $earnedLeave=DB::table('earned_leave')->where('employee_id',$user_id)->where('leave_status',1)->where('date','<',$thisYearsFristday)->get();
        $data['find_confirmation_date'] = $find_confirmation_date = $user_employee_data->employee_confirmation_due_date;
        $data['find_today'] = $find_today = date('Y-m-d');
        foreach ($leaveInfo as $key => $value) {
          //  code for meena bazar start
          if($user_employee_data->employee_sbu == 2 || $user_employee_data->employee_sbu == 11 || $user_employee_data->employee_sbu == 27){
            $running_year = date('Y');
              $joining_year = date ('Y', strtotime($user_employee_data->employee_joining_date));
              $year_end = new DateTime(date('Y-m-d', strtotime('12/31')));
              $today_date = new DateTime(date('Y-m-d'));
              if($joining_year == $running_year){
                $joining_date = new DateTime($user_employee_data->employee_joining_date);
                $interval = $joining_date->diff($today_date);
                $working_days = $interval->format('%a') + 1;
              }else{
                $year_start = new DateTime(date('Y-m-d', strtotime('01/01')));
                $interval = $year_start->diff($year_end);
                $working_days = $interval->format('%a') + 1;
              }
              $aviledLive=collect($authorizedLive)->where('leave_type', $value['id'])->first();
              if(!empty($aviledLive['leave_day_no'])){
                $aviledLive_leave_day_no = $aviledLive['leave_day_no'];
              }else{
                $aviledLive_leave_day_no = 0;
              }
              $aviledLive_leave_day_no = round(($aviledLive_leave_day_no * $working_days) / 365);
              if($value['leave_short_type'] == 'ML'){
                $authorizedLives=collect($availedLiveML)->where('leave_type',$value['id'])->sum('leave_total_day');
              }else{
                $authorizedLives=collect($availedLive)->where('leave_from_date','>=',$thisYearsFristday)->where('leave_from_date','<=',date("Y-m-d"))->where('leave_type',$value['id'])->sum('leave_total_day');
              } 
              $previousBalance=collect($earnedLeave)->where('leave_type',$value['id'])->sum('earned_day');
              $leaveInfo[$key]['entitlementThisYear']= $aviledLive_leave_day_no;
              $leaveInfo[$key]['previousBalance']= $previousBalance ?? 0;
              $leaveInfo[$key]['totalDay']= $authorizedLives; // availed
              $leaveInfo[$key]['totalEntitlement'] = $aviledLive_leave_day_no+$previousBalance;
              $leaveInfo[$key]['balance'] = (($aviledLive_leave_day_no+$previousBalance)-$authorizedLives);
          }else{
        //  code for meena bazar end

        //   if($find_confirmation_date > $find_today){
          if(($find_confirmation_date > $find_today) || ($user_employee_data->employee_type != 1)){
              if($value['leave_short_type'] == 'CL'){
                $aviledLive_leave_day_no = 3;
                $authorizedLives=collect($availedLive)->where('leave_type',$value['id'])->sum('leave_total_day');
                $previousBalance=collect($earnedLeave)->where('leave_type',$value['id'])->sum('earned_day');
                $leaveInfo[$key]['entitlementThisYear']= $aviledLive_leave_day_no;
                $leaveInfo[$key]['previousBalance']= $previousBalance ?? 0;
                $leaveInfo[$key]['totalDay']= $authorizedLives;
                $leaveInfo[$key]['totalEntitlement'] = $aviledLive_leave_day_no+$previousBalance;
                $leaveInfo[$key]['balance'] = (($aviledLive_leave_day_no+$previousBalance)-$authorizedLives);
              }
            }else{
              $running_year = date('Y');
              $joining_year = date ('Y', strtotime($user_employee_data->employee_joining_date));
              $year_end = new DateTime(date('Y-m-d', strtotime('12/31')));
              $today_date = new DateTime(date('Y-m-d'));
              if($joining_year == $running_year){
                $joining_date = new DateTime($user_employee_data->employee_joining_date);
                $interval = $joining_date->diff($today_date);
                $working_days = $interval->format('%a') + 1;
              }else{
                $year_start = new DateTime(date('Y-m-d', strtotime('01/01')));
                $interval = $year_start->diff($year_end);
                $working_days = $interval->format('%a') + 1;
              }
              $aviledLive=collect($authorizedLive)->where('leave_type', $value['id'])->first();
              if(!empty($aviledLive['leave_day_no'])){
                $aviledLive_leave_day_no = $aviledLive['leave_day_no'];
              }else{
                $aviledLive_leave_day_no = 0;
              }
              $aviledLive_leave_day_no = round(($aviledLive_leave_day_no * $working_days) / 365);
              if($value['leave_short_type'] == 'ML'){
                $authorizedLives=collect($availedLiveML)->where('leave_type',$value['id'])->sum('leave_total_day');
              }else{
                $authorizedLives=collect($availedLive)->where('leave_from_date','>=',$thisYearsFristday)->where('leave_from_date','<=',date("Y-m-d"))->where('leave_type',$value['id'])->sum('leave_total_day');
              } 
              $previousBalance=collect($earnedLeave)->where('leave_type',$value['id'])->sum('earned_day');
              $leaveInfo[$key]['entitlementThisYear']= $aviledLive_leave_day_no;
              $leaveInfo[$key]['previousBalance']= $previousBalance ?? 0;
              $leaveInfo[$key]['totalDay']= $authorizedLives; // availed
              $leaveInfo[$key]['totalEntitlement'] = $aviledLive_leave_day_no+$previousBalance;
              $leaveInfo[$key]['balance'] = (($aviledLive_leave_day_no+$previousBalance)-$authorizedLives);
            }
          }
        }

        $data['leaveInfo']=$leaveInfo;



        $data['user_employee_data'] = $user_employee_data;
        // $data['user_employee_data_all'] = $user_employee_data_all;

        $data['employee_id'] = $user_employee_data->id;
        $data['employee_sbu'] = $user_employee_data->employee_sbu;

        $data['employee_data']=array();
        $employee_data = Employee::valid()->project()
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->select(
              'employees.*',
              'designations.designation_name', 
              'company_sbus.sbu_name',
              'sections.section_name',
              'departments.department_name',
              'designations.designation_name',
              'sub_units.sub_unit_name',
              'work_locations.work_location_name',
              'employee_personal_infos.employee_gender',
               DB::raw('(DATEDIFF(NOW(), employee_joining_date))/365 as service_length')
            )
            ->whereIn('employee_sbu',$employee_ids['sub'])
            // ->whereIn('employees.id',$employee_ids['employee_id'])
            ->where('employee_status',1)
            ->where('employee_joining_date', '<=', $find_today)
            ->get()->keyBy('id');
          foreach ($employee_data as $value) {
          array_push($data['employee_data'],
          [
            'id'=>$value['id'],
            'text'=>$value['employee_id_no']." - ". $value['employee_fullname']." - ". $value['designation_name']." - ". $value['department_name'],
            'designation_name' => $value['designation_name'],
            'sbu_name' => $value['sbu_name'],
            'employee_sbu' => $value['employee_sbu'],
            'employee_mobile'=> $value['official_mobile_no'] ?? $value['employee_mobile'] ?? ''
          ]);
        }
        $data['leave_type_data']=array();
        // $leave_type_data=LeaveType::valid()->project()->get();
        foreach ($leaveInfo as $value) {
          if($user_employee_data->employee_sbu == 2 || $user_employee_data->employee_sbu == 11 || $user_employee_data->employee_sbu == 27){
            array_push($data['leave_type_data'],['id'=>$value['id'],'text'=>$value['leave_type_name']]);
          }else{
            if($user_employee_data->employee_type == 2){
              if($value['leave_short_type'] == 'CL'){
                array_push($data['leave_type_data'],['id'=>$value['id'],'text'=>$value['leave_type_name']]);
              }
            }else{
              array_push($data['leave_type_data'],['id'=>$value['id'],'text'=>$value['leave_type_name']]);
            }
          }
        }
        $data['approvalfristId']=Employee::valid()->project()
          ->leftJoin('employee_approvals', 'employee_approvals.ea_approve_by', '=', 'employees.id')
          ->where('ea_approval_lavel',1)->where('employee_status',1)->where('ea_employee_id',$user_id)->first();
        $data['approval2ndId']=Employee::valid()->project()
          ->leftJoin('employee_approvals', 'employee_approvals.ea_approve_by', '=', 'employees.id')
          ->where('ea_approval_lavel',2)->where('employee_status',1)->where('ea_employee_id',$user_id)->first();
        return response($data);
    }

    public function leave_application_cancel($request){
      // return response($request);
      if($request->cancel_application == 2){
        $data=$request->only(
            'leave_from_date',
            'leave_to_date',
            'leave_reason',
            'leave_reliever',
            'leave_reliever_contact',
            'address_leave',
            'leave_total_day'
        );
        // $leave_total_day = $request->leave_total_day ?? 0;
        $update_data=LeaveApplication::valid()->project()->findOrFail($request->id);
        $data['updated_by'] = Auth::guard('user')->user()->id;
        $save_data = $update_data->update($data);
        if($save_data){
          return 2;
        }else{
          return 3;
        }
      }else{
        $leave_application['leave_apply_status']=5;
        $leave_application['updated_at']= date('Y-m-d H:i:s');
        $leave_application['updated_by']= Auth::guard('user')->user()->id;
        $udate_data1 = DB::table('leave_applications')->where('id',$request->id)->update($leave_application);

        $leave_approval['leave_approve_status']=5;
        $leave_approval['updated_at']= date('Y-m-d H:i:s');
        $leave_approval['updated_by']= Auth::guard('user')->user()->id;
        $udate_data2 = DB::table('leave_approval')->where('leave_apply_id',$request->id)->update($leave_approval);

        $attendance['remarks'] = 'Absent';
        $attendance['pstatus'] = 3;
        $attendance['updated_at'] = date('Y-m-d H:i:s');
        $attendance['updated_by'] = Auth::guard('user')->user()->id;
        $udate_data = DB::table('attendance')->where('employee_id', $request->employee_id)->whereBetween('pdate', [$request->leave_from_date, $request->leave_to_date])->update($attendance);
        // return [$udate_data, $udate_data1, $udate_data2];
        if($udate_data || $udate_data1 || $udate_data2){
          return 1;
        }else{
          return 0;
        }
      }
    }

    public function store(Request $request)
    {
        // return response($request);

        if($request->cancel_application == 1 || $request->cancel_application == 2) {
          $requested_data['requested_data'] = $request;
          $return_value  = $this->leave_application_cancel($requested_data['requested_data']);
          // return response($return_value);
          if($return_value==1){
            return response(['status'=>1,'message'=>'Leave Application Cancelled Successfully']);
          }elseif($return_value==2){
            return response(['status'=>1,'message'=>'Your data successfully updated']);
          }elseif($return_value==3){
            return response(['status'=>1,'message'=>'Your data not updated']);
          }else{
            return response(['status'=>0,'message'=>'Leave Application Cancelled Failed']);
          }
        }

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

        $leave_from_date = strtotime($request->leave_from_date);
        $leave_to_date = strtotime($request->leave_to_date);
        $start = date('Y-m-d',$leave_from_date);
        $end = date('Y-m-d',$leave_to_date);
        $leave_type = $request['leave_type'];
        $date_checking_data = [];
        if(empty($request->id)){
          $date_checking_data=LeaveApplication::valid()->project()
              ->whereIn('leave_apply_status', [1,2,3])
              ->where(function ($query) use ($start,$end) {
                $query->whereBetween('leave_from_date', [$start, $end])
                ->orWhereBetween('leave_to_date', [$start, $end]);
              })->where(function ($query) use ($user_id) {
                  $query->where('employee_id', $user_id);
              })
          ->get();
        }
        if(count($date_checking_data) > 0){
          $message=['status' => 0, 'message' => 'Already leave applied between this date range!'];
          return response($message);
        }
        if(empty($request->id) && $leave_from_date>$leave_to_date){
          $message=['status' => 0, 'message' => 'Wrong Date Range!'];
          return response($message);
        }
        // Date range validation checking
        // $datediff = $leave_to_date - $leave_from_date;
        // $leave_total_day = round($datediff / (60 * 60 * 24)) + 1;
        $leave_total_day = $request->leave_total_day ?? 0;
        $validate=[
            'leave_from_date'=>'required',
          ];
        $request->validate($validate);
        $data=$request->only(
          'leave_from_date',
          'leave_to_date',
          'leave_type',
          'leave_reason',
          'leave_apply_type',
          'leave_with_holiday',
          'leave_paystatus',
          'leave_reliever',
          'leave_reliever_contact',
          'address_leave'
        );
        $data['leave_total_day'] = $leave_total_day;
        $data['leave_apply_date']= date('Y-m-d');
        $data['leave_apply_status']= 1;
        $data['leave_app_status']= 1;
        $data['employee_id']= $user_data->id;
        // leave condition
        // return response($leave_total_day);
        $leave_type = LeaveType::valid()->project()->where('id',$request['leave_type'])->first();
        $checkis=0;
        if($leave_type['leave_short_type']=='CL' && $leave_total_day >= 4){
          $checkis=0;
        }else{
            $checkis=1;
        }

        if(!empty($employee_reporting_to)){
          if($checkis){
            // return response($image);
             if(!empty($request->leave_attachment)){
               $exploded=explode(',',$request->leave_attachment);
               if(strlen($request->leave_attachment) >=800){
               $decoded = base64_decode($exploded[1]);
               $exploded1=explode(';',$exploded[0]);
               $exploded2=explode('/',$exploded1[0]);
                 if(str_contains($exploded2[1],'jpeg')){
                     $str_contains='jpeg';
                 }
                 elseif(str_contains($exploded2[1],'pdf')){
                      $str_contains='pdf';
                 }
                 elseif(str_contains($exploded2[1],'doc')){
                      $str_contains='doc';
                 }
                 elseif(str_contains($exploded2[1],'docx')){
                      $str_contains='docx';
                 }
                 else{
                     $str_contains='png';
                 }

               $fileName=str_random().'.'.$str_contains;
               $path=public_path().'/attachments/'.$fileName;
               file_put_contents( $path,$decoded);
               $data['leave_attachment']=$fileName;
              }
             }



             if(!empty($request->id))
             {
               $update_data=LeaveApplication::valid()->project()->findOrFail($request->id);
               $data['updated_by']=Auth::guard('user')->user()->branch_id;
               $save_data=$update_data->update($data);
               $message=['status' => 1, 'message' => 'Your data successfully updated'];
               return response($message);
             } else {
              if($request->add_new_type == 1){
                 $data['project_id']=Auth::guard('user')->user()->project_id;
                 $data['branch_id']=Auth::guard('user')->user()->branch_id;
                 $data['created_by']=Auth::guard('user')->user()->id;
                 $save_ids = 1;
                 $save_data=LeaveApplication::create($data); $save_ids=$save_data->id; // testing

                 /* Data sent to approval table */
                 $employee_approvals_data=EmployeeApproval::valid()->project()->where('ea_employee_id',$user_data->id)->get();

                 
                 if (!$employee_approvals_data->isEmpty() && !empty($save_ids)) {
                   $i=0;
                   $eaApprove_by=[];
                   foreach ($employee_approvals_data as $key => $value) {
                     $i++;
                     // return response($save_data->id);
                     $eaApprove_by[] = $value['ea_approve_by'];
                     $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
                     $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                     $approve_data['created_by'] = Auth::guard('user')->user()->id;
                     $approve_data['created_at'] = date('Y-m-d H:i:s');
                     $approve_data['leave_apply_id']= $save_ids;
                     $approve_data['leave_approve_by']= $value['ea_approve_by'];
                     $approve_data['leave_approve_status']= 1;
                     $save_data=DB::table('leave_approval')->insert($approve_data); // testing
                     $message=['status' => 1, 'message' => 'Your data successfully saved'];
                   }
                 }else{
                     // return response($employee_reporting_to);

                     $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
                     $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                     $approve_data['created_by'] = Auth::guard('user')->user()->id;
                     $approve_data['created_at'] = date('Y-m-d H:i:s');
                     $approve_data['leave_apply_id']= $save_ids;
                     $approve_data['leave_approve_by']= $employee_reporting_to->id;
                     $approve_data['leave_approve_status']= 1;

                     $save_data = DB::table('leave_approval')->insert($approve_data); // testing
                     $message=['status' => 1, 'message' => 'Your data successfully saved'];
                 }
              }else{
                $save_data = array();
                $data['project_id']=Auth::guard('user')->user()->project_id;
                 $data['branch_id']=Auth::guard('user')->user()->branch_id;
                 $data['created_by']=Auth::guard('user')->user()->id;
                 $data['leave_apply_status']=2;
                 $save_ids = 1;
                 $save_data=LeaveApplication::create($data); $save_ids= $save_data->id; //testing

                 /* Data sent to approval table */
                 $employee_approvals_data=EmployeeApproval::valid()->project()->where('ea_employee_id',$user_data->id)->get();

                $Attendancefinds = DB::table('attendance')
                                ->where('employee_id', $request->employee_id)
                                ->whereBetween('pdate',[date('Y-m-d', strtotime($request['leave_from_date'])),date('Y-m-d', strtotime($request['leave_to_date']))])->get();
                                // ->where('pdate','<=',$request['leave_from_date'])
                                // ->toSql();
                // return response($Attendancefinds);

                if(!empty($Attendancefinds)){
                  $leave_type=LeaveType::valid()->project()->where('id',$request['leave_type'])->first();
                  foreach ($Attendancefinds as $key => $value) {
                    $attendances =[
                      'pstatus'=>6,
                      'remarks'=>$leave_type['leave_short_type'],
                     ];
                    $findesId=DB::table('attendance')->where('id',$value->id)->update($attendances); // testing
                  }
                }
                 if (!$employee_approvals_data->isEmpty() && !empty($save_data)) {
                   $i=0;
                   foreach ($employee_approvals_data as $key => $value) {
                     $i++;
                     // return response($save_data->id);
                     $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
                     $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                     $approve_data['created_by'] = Auth::guard('user')->user()->id;
                     $approve_data['created_at'] = date('Y-m-d H:i:s');
                     $approve_data['leave_apply_id']= $save_ids;
                     $approve_data['leave_approve_by']= $value['ea_approve_by'];
                     $approve_data['leave_approve_status']= 2;
                     $save_data=DB::table('leave_approval')->insert($approve_data); // testing
                     $message=['status' => 1, 'message' => 'Your data successfully saved'];
                   }
                 }else{
                     // return response($employee_reporting_to);
                     $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
                     $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                     $approve_data['created_by'] = Auth::guard('user')->user()->id;
                     $approve_data['created_at'] = date('Y-m-d H:i:s');
                     $approve_data['leave_apply_id']= $save_data->id;
                     $approve_data['leave_approve_by']= $employee_reporting_to->id;
                     $approve_data['leave_approve_status']= 2;


                     $save_data = DB::table('leave_approval')->insert($approve_data); // testing
                     $message=['status' => 1, 'message' => 'Your data successfully saved'];
                 }


              }

              if(!empty($eaApprove_by)){
                $emplyInfo = DB::table('employees')->where('id', $request->employee_id)->first();
                $templates = DB::table('email_templates')->where('template_name','leave')
                ->whereRaw('FIND_IN_SET(?, company_id)', [$emplyInfo->employee_sbu])
                ->first();
                
                // dd($leave_type->leave_type_name);
                if(!empty($templates)){
                  $sents = new MailSent();
                  $sents->leaveMail($leaveType = $leave_type->leave_type_name ?? '', $leaveReason=$request->leave_reason ?? '', $totalDays=$request->leave_total_day, $startDate=$request->leave_from_date, $endDate=$request->leave_to_date, $eaApprove_by, $employeeId=$user_data->id, $data1=null);
                }
               }

             }
           }else{
            $message=['status' => 0, 'message' => 'Casual Leave is not more then 3 days !'];
            // return response($message);
           }

          }else{
           $message=['status' => 0, 'message' => 'Sorry !, Reporting to/Superior Not Set'];
           return response($message);

        }

       // if(!empty($save_data)){
       //   $message=['status' => 0, 'message' => 'Ops! Something went worng23123.'];
       // }

         return response($message);

    }

    public function edit($id)
    {
      $employee_list = new Employee();
      $employee_ids=$employee_list->Employee_id();
      // $employee_id=$employee_ids['employee_id'];

      $data=LeaveApplication::valid()->project()->findOrFail($id);
      $data['leave_apply_date_custom'] = date('j M Y', strtotime($data->leave_apply_date));
      $data['leave_from_date_custom'] = date('l, j M Y', strtotime($data->leave_from_date));
      $data['leave_to_date_custom'] = date('l, j M Y', strtotime($data->leave_to_date));
      $data['created_at_custom'] = date('D, j M Y', strtotime($data->leave_apply_date));

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
        )
        // ->whereIn('employee_sbu',$employee_ids['sub'])
        // ->whereIn('employee_department',$employee_ids['department'])
        ->where('employees.id',$data->employee_id)
        ->first();


      // return response([$user_employee_data]);
      $data['employee_joining_date_custom'] = date('j M Y', strtotime($user_employee_data->employee_joining_date));
      $data['employee_sbu'] = $user_employee_data->employee_sbu;
      $data['user_employee_data'] = $user_employee_data;
      $employee_data_list=Employee::valid()->project()->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')->where('employee_status',1)->select('employees.*', 'designations.designation_name','company_sbus.sbu_name')
      ->whereIn('employee_sbu',$employee_ids['sub'])
      // ->whereIn('employee_department',$employee_ids['department'])
      ->get()->keyBy('id')->all();

      // return response([$employee_data_list]);
      if($user_employee_data['employee_gender'] == 1){
          $leave_type_data_list=LeaveType::valid()->project()->get()->keyBy('id')->all();
        }else{
          $leave_type_data_list=LeaveType::valid()->project()->where('leave_short_type','!=','ML')->get()->keyBy('id')->all();
        }

      // $leave_type_data_list=LeaveType::valid()->project()->get()->keyBy('id')->all();
      if(!$data->leave_reliever){
       $data->employee_name_value = ['id'=>'','text'=>''];
      }else{
         $data->employee_name_value = [
          'id'=>$data->leave_reliever,
          'text'=>$employee_data_list[$data->leave_reliever]->employee_fullname,
          'designation_name'=>$employee_data_list[$data->leave_reliever]->designation_name,
          'reliever_image'=>$employee_data_list[$data->leave_reliever]->employee_image,
        ];
      }
      if(!$data->leave_type){
       $data->leave_type_value = ['id'=>'','text'=>''];
      }else{
       $data->leave_type_value = ['id'=>$data->leave_type,'text'=>$leave_type_data_list[$data->leave_type]->leave_type_name];
      }
      $employee_data=array();
      $leave_type_data=array();
      foreach ($employee_data_list as $value) {
        array_push($employee_data,[
          'id'=>$value['id'],
          'text'=>$value['employee_id_no']." - ". $value['employee_fullname'],
          'designation_name' => $value['designation_name'],
          'sbu_name' => $value['sbu_name'],
          'employee_mobile' => $value['employee_mobile'],
          'official_mobile_no' => $value['official_mobile_no'],
        ]);
      }
      foreach ($leave_type_data_list as $value) {
        array_push($leave_type_data,['id'=>$value['id'],'text'=>$value['leave_type_name']]);
      }
      $thisYearsFristday= date('Y-m-d',strtotime(date("Y").'-'.'01'.'-'.'01'));
      if($user_employee_data['employee_gender'] == 1){
        $leaveInfo=LeaveType::valid()->project()->get();
      }else{
        $leaveInfo=LeaveType::valid()->project()->where('leave_short_type','!=','ML')->get();
      }

      // $leaveInfo=LeaveType::valid()->project()->get();
      $authorizedLive=LeaveSetup::valid()->project()->where('leave_status',1)->get();

      $availedLive = LeaveApplication::valid()->project()->where('employee_id',$data->employee_id)->where('leave_apply_status',2)->where('leave_from_date','>=',$thisYearsFristday)->where('leave_from_date','<=',date("Y-m-d"))->get();

  

      $availedLiveML=LeaveApplication::valid()->project()
      ->leftJoin('leave_types', 'leave_types.id', '=', 'leave_applications.leave_type')
      ->where('leave_short_type', 'ML')
      ->where('employee_id', $data->employee_id)
      ->where('leave_apply_status', 2)
      ->get();

      

      $earnedLeave=DB::table('earned_leave')->where('employee_id',$data->employee_id)->where('leave_status',1)->where('date','<',$thisYearsFristday)->get();
      // return response($leaveInfo);
      foreach ($leaveInfo as $key => $value) {
        $aviledLive=collect($authorizedLive)->where('leave_type',$value['id'])->first();
        if($value['leave_short_type'] == 'ML'){
          $authorizedLives=collect($availedLiveML)->where('leave_type',$value['id'])->sum('leave_total_day');
        }else{
          $authorizedLives=collect($availedLive)->where('leave_type',$value['id'])->sum('leave_total_day');
        }
        $previousBalance=collect($earnedLeave)->where('leave_type',$value['id'])->sum('earned_day');
        $leaveInfo[$key]['entitlementThisYear']= $aviledLive['leave_day_no'] ?? 0;
        $leaveInfo[$key]['previousBalance']= $previousBalance ?? 0;
        $leaveInfo[$key]['totalDay']= $authorizedLives ?? 0;
        $leaveInfo[$key]['totalEntitlement'] = (($aviledLive['leave_day_no'] ?? 0) + $previousBalance) ?? 0;
        $leaveInfo[$key]['balance'] = ((($aviledLive['leave_day_no'] ?? 0) + $previousBalance)-$authorizedLives) ?? 0;
      }

      $data['leaveInfo']=$leaveInfo;

      $approvalId=DB::table('leave_approval')->where('leave_apply_id',$id)->get();
      $empllyIdfinds=collect($approvalId)->pluck('leave_approve_by');
     // return response($approvalId);

      $user_employee_data=Employee::valid()->project()
        ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
        ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
        ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
        ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
        ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
        ->leftJoin('leave_approval', 'leave_approval.leave_approve_by', '=', 'employees.id')
        // ->leftJoin('leave_applications', 'leave_applications.id', '=', 'leave_approval.leave_apply_id')
        ->select(
          'employees.*',
          'company_sbus.sbu_name',
          'sections.section_name',
          'departments.department_name',
          'designations.designation_name',
          'sub_units.sub_unit_name',
          'work_locations.work_location_name',
          'leave_approval.leave_comments',
          'leave_approval.leave_approve_status',
          DB::raw("DATE_FORMAT(leave_approval.created_at, '%a, %D %b %Y, %r') as created_at_approval"),
          DB::raw("DATE_FORMAT(leave_approval.updated_at, '%a, %D %b %Y, %r') as updated_at_approval")
        )->where('employee_status',1)
        ->whereIn('employee_sbu',$employee_ids['sub'])
        // ->whereIn('employee_department',$employee_ids['department'])
        ->where('leave_approval.leave_apply_id', $id)
        ->whereIn('employees.id', $empllyIdfinds)
        ->get();

      $findsId=collect($approvalId)->where('leave_approve_by',Auth::guard('user')->user()->employee_id)->whereNotIn('leave_approve_status',['3','2','4'])->first();

      $data->approveData=$user_employee_data;

        if(!empty($findsId)){
          $data->approveParmition=1;
        }else{
           $data->approveParmition=0;
        }

      $employeesId=Employee::valid()->project()->where('employee_status',1)->where('employee_sbu',Auth::guard('user')->user()->company_sbu)->where('employee_department',Auth::guard('user')->user()->department)->get();
      $employee_ids=collect(collect($employeesId)->pluck('id')->unique()->values('id')->all())->toArray();
      $conflictsNo=LeaveApplication::valid()->project()->where('leave_to_date',$data['leave_to_date'])->where('leave_from_date',$data['leave_from_date'])->whereIn('employee_id',$employee_ids)->where('leave_apply_status',2)->where('employee_id','!=',Auth::guard('user')->user()->employee_id)->get();
      $data['conflictsNo']=count($conflictsNo);
        // return response($conflictsNo);
      // }

      $data->employee_data =  $employee_data;
      $data->user_employee_data_all = $employee_data_list;
      $data->leave_type_data =  $leave_type_data;
      $data->user_ids = Auth::guard('user')->user()->id;

      // $data['leave_type_data']=array();

      // foreach ($leave_type_data as $value) {
      //   array_push($data['leave_type_data'],['id'=>$value['id'],'text'=>$value['leave_type_name']]);
      // }

      // $edit_data=LeaveApplication::valid()->project()->findOrFail($id);
      return response($data);

    }
    public function destroy($id){
      $delete_data=LeaveApplication::valid()->project()->findOrFail($id);
      if($delete_data->delete())
      {
        DB::table('leave_approval')->where('leave_apply_id',$id)->delete();
        $message=['status' => 1, 'message' => 'Your data successfully deleted'];
      }
      return response($message);
    }

    public function approveOrReject(Request $request){
      $leave_app_id = $request->id;
      $user_id = Auth::guard('user')->user()->id;
      $user_data=UsersPersonModel::valid()->project()->where('id', $user_id)->first();
      $approval_info=EmployeeApproval::valid()->project()->where('ea_approve_by', $user_data->employee_id)->where('ea_employee_id', $request->employee_id)->first();
      // return response($request);
      if (!empty($approval_info)) {
        $ea_approval_lavel = $approval_info->ea_approval_lavel;
        $ea_employee_id = $approval_info->ea_employee_id;
        $ea_approve_by = $approval_info->ea_approve_by;
        if ($ea_approval_lavel==1) {
          if($request->approve_reject_status==1) {
            $data['leave_approve_status']= 2;
          }elseif ($request->approve_reject_status==3) {
            $data['leave_approve_status']= 2;
          }else{
            $data['leave_approve_status']= 4;
          }
        }else{
          if ($request->approve_reject_status==1) {
            $data['leave_approve_status']= 3;
          }else{
            $data['leave_approve_status']= 4;
          }
        }
        $data['leave_approve_date']= date("Y-m-d");
        $data['leave_comments']= $request->leave_comments;
        $data['leave_view_date']= date("Y-m-d");
        $data['updated_at']= date("Y-m-d H:i:s");
      // return response($leave_app_id);
        $udate_data = DB::table('leave_approval')->where('leave_apply_id',$leave_app_id)->where('leave_approve_by',$ea_approve_by)->update($data);
        // $leave_data['leave_apply_status'] = $data['leave_approve_status'];
        $udate_data = LeaveApplication::valid()->project()->where('id',$leave_app_id)->update(array('leave_apply_status'=>$data['leave_approve_status']));

        $employee_id=LeaveApplication::valid()->project()->where('id',$leave_app_id)->first()->employee_id;
        $Attendancefinds=DB::table('attendance')
        ->where('employee_id',$employee_id)
        ->whereBetween('pdate',[date('Y-m-d', strtotime($request['leave_from_date'])),date('Y-m-d', strtotime($request['leave_to_date']))])->get();
        // ->where('pdate','<=',$request['leave_from_date'])
        // ->toSql();
        // return response($Attendancefinds);

        if(!empty($Attendancefinds)){
          $leave_type=LeaveType::valid()->project()->where('id',$request['leave_type'])->first();
          foreach ($Attendancefinds as $key => $value) {
            $attendances =[
            'pstatus'=>6,
            'remarks'=>$leave_type['leave_short_type'],
            ];
            $findesId=DB::table('attendance')->where('id',$value->id)
              ->update($attendances);
          }
        }
        // ->update('leave_apply_status',$data['leave_approve_status']);
        if ($udate_data && $request->approve_reject_status==1) {
          $message=['status' => 1, 'message' => 'Application status updated!'];
        }else{
          $message=['status' => 1, 'message' => 'Application rejected!'];
        }
        return response($message);
      }
    }

    public function findActualAnnualLeaveDays(Request $request){
      $start = $from_date = date('Y-m-d', strtotime($request->leave_form_date));
      $end = $to_date = date('Y-m-d', strtotime($request->leave_to_date));
      $employee_sbu = $request->employee_sbu;
      $total_day = $request->totalDayss;
      $search_period = CarbonPeriod::create($from_date, $to_date);
      $employee_info = Employee::where('id', $request->employee_id)->first();

     
      $holidays_date = HolidaySetup::valid()->project()
      ->leftJoin('holiday_permissions', 'holiday_permissions.holiday_id', '=', 'holiday_setups.id')
      ->select('holiday_permissions.*','holiday_setups.id', 'holiday_event','holiday_start_date', 'holiday_end_date')
      ->where(function($query) use ($start, $end) {
        $query->whereBetween('holiday_start_date', [$start, $end])
        ->orWhereBetween('holiday_end_date', [$start, $end]);
      })
      ->where('sbu_permission', $employee_sbu)
      ->get()
      // ->toArray()
      ;
      $holiday_permission = [];
      $holiday_permission = collect($holidays_date);

      foreach ($holiday_permission as $key => $permission) {

        if(!empty($permission->sbu_permission) && $permission->sbu_permission == $employee_info['employee_sbu']){
          // return response([$permission->sbu_permission, $employee_info['employee_sbu']]);
          $holiday_permission = [1];
        }
        if(!empty($permission->unit_permission)){
            $holiday_permission = [];
            if($permission->unit_permission == $employee_info['employee_unit']){
                // $holiday_permission = [1];
                array_push($holiday_permission, 1);
            }
        }

        if(!empty($permission->sub_unit_permission)){
            $holiday_permission = [];
            if($permission->sub_unit_permission == $employee_info['employee_sub_unit']){
                // $holiday_permission = [1];
                array_push($holiday_permission, 1);
            }
        }

        if(!empty($permission->department_permission)){
            $holiday_permission = [];
            if($permission->department_permission == $employee_info['employee_department']){
                // $holiday_permission = [1];
                array_push($holiday_permission, 1);
            }
        }

        if(!empty($permission->section_permission)){
            $holiday_permission = [];
            if($permission->section_permission == $employee_info['employee_section']){
                // $holiday_permission = [1];
                array_push($holiday_permission, 1);
            }
        }

        if(!empty($permission->sub_section_permission)){
            $holiday_permission = [];
            if($permission->sub_section_permission == $employee_info['employee_sub_section']){
                // $holiday_permission = [1];
                array_push($holiday_permission, 1);
            }
        }

        if(!empty($permission->work_location_permission)){
            $holiday_permission = [];
            if($permission->work_location_permission == $employee_info['employee_work_location']){
                // $holiday_permission = [1];
                array_push($holiday_permission, 1);
            }
        }

        if(!empty($permission->employee_id)){
            $holiday_permission = [];
            if($permission->employee_id == $employee_info['id']){
                // $holiday_permission = [1];
                array_push($holiday_permission, 1);
            }
        }

        if(!empty($holiday_permission)){
            break;
        }
        
    }

    // dd($holiday_permission);
     
      // $collect_unit_permission = [];
      // if(!empty($employee_info->employee_unit)){
      //     $collect_unit_permission = collect($holidays_date)->where('unit_permission', '!=', 0)->pluck('unit_permission')->toArray();
      // }
      // $collect_sub_unit_permission = [];
      // if(!empty($employee_info->employee_sub_unit)){
      //     $collect_sub_unit_permission = collect($holidays_date)->where('sub_unit_permission', '!=', 0)->pluck('sub_unit_permission')->toArray();
      // }
      // $collect_department_permission = [];
      // if(!empty($employee_info->employee_department)){
      //     $collect_department_permission = collect($holidays_date)->where('department_permission', '!=', 0)->pluck('department_permission')->toArray();
      // }
      // $collect_section_permission = [];
      // if(!empty($employee_info->employee_section)){
      //     $collect_section_permission = collect($holidays_date)->where('section_permission', '!=', 0)->pluck('section_permission')->toArray();
      // }
      // $collect_sub_section_permission = [];
      // if(!empty($employee_info->employee_sub_section)){
      //     $collect_sub_section_permission = collect($holidays_date)->where('sub_section_permission', '!=', 0)->pluck('sub_section_permission')->toArray();
      // }
      // $collect_work_location_permission = [];
      // if(!empty($employee_info->employee_work_location)){
      //     $collect_work_location_permission = collect($holidays_date)->where('work_location_permission', '!=', 0)->pluck('work_location_permission')->toArray();
      // }
      // $collect_employee_id_permission = [];
      // if(!empty($employee_info->id)){
      //     $collect_employee_id_permission = collect($holidays_date)->where('employee_id', '!=', 0)->pluck('employee_id')->toArray();
      // }

      // $holidays_date = collect($holidays_date);
      
      // if (!empty($employee_info->unit)) {
      //   if(in_array($employee_info->unit, $collect_unit_permission)){
      //     $holidays_date->where('unit_permission', $employee_info->unit);
      //   }
      // }
      // if (!empty($employee_info->sub_unit)) {
      //   if(in_array($employee_info->sub_unit, $collect_sub_unit_permission)){
      //     $holidays_date->where('sub_unit_permission', $employee_info->sub_unit);
      //   }
      // }
      // if (!empty($employee_info->employee_department)) {
      //   if(in_array($employee_info->employee_department, $collect_department_permission)){
      //     $holidays_date->where('department_permission', $employee_info->employee_department);
      //   }
      // }
      // if (!empty($employee_info->employee_section)) {
      //   if(in_array($employee_info->employee_section, $collect_section_permission)){
      //     $holidays_date->where('section_permission', $employee_info->employee_section);
      //   }
      // }
      // if (!empty($employee_info->employee_sub_section)) {
      //   if(in_array($employee_info->employee_sub_section, $collect_sub_section_permission)){
      //     $holidays_date->where('sub_section_permission', $employee_info->employee_sub_section);
      //   }
      // }
      // if (!empty($employee_info->employee_work_location)) {
      //   if(in_array($employee_info->employee_work_location, $collect_work_location_permission)){
      //     $holidays_date->where('work_location_permission', $employee_info->employee_work_location);
      //   }
      // }
      // if (!empty($request->employee_id)) {
      //   if(in_array($request->employee_id,$collect_employee_id_permission)){
      //     $holidays_date->where('holiday_permissions.employee_id', $employee_info->id);
      //   }
      // }

     
      // $holidays_date =  $holidays_date->toArray();
     
      
      $count_date_array = count($holiday_permission);

      // dd($count_date_array);

      $roaster_day_off = DB::table('attendance_setups')
      ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
      ->leftJoin('employees', 'employees.id', '=', 'attendance_setups.employee_id')
        ->select('employee_fullname','employee_id','start_date','end_date')
      ->where('office_type', 2)
      ->where('employee_id', $request->employee_id)
      ->where(function($query) use ($start, $end) {
        $query->whereBetween('start_date', [$start, $end])
        ->orWhereBetween('end_date', [$start, $end]);
      })
      ->get()->toArray();
      // $roaster_day_off = collect($roaster_day_off)->toArray();

      
      
      $roaster_day_off1 = array();
      $others_roaster = array();
      if(count($roaster_day_off) == 0){
       $others_roaster =  $roaster_day_off1 = $roaster_day_off = DB::table('attendance_setups')
        ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
        ->leftJoin('employees', 'employees.id', '=', 'attendance_setups.employee_id')
        ->select('employee_fullname','employee_id','start_date','end_date')
        // ->where('office_type', 2)
        ->where('employee_id', $request->employee_id)
        ->where(function($query) use ($start, $end) {
          $query->whereBetween('start_date', [$start, $end])
          ->orWhereBetween('end_date', [$start, $end]);
        })
        ->where('attendance_setups.valid', 1)
        ->get()->toArray();
       
        
        $collect_roaster_holday_date = collect($roaster_day_off)->pluck('start_date')->toArray();
        $collect_roaster_holday_date = array_unique($collect_roaster_holday_date);
        // $collect_roaster_holday_date = sort($collect_roaster_holday_date);
        // $arr = ['11/01/2012', '03/16/2022', '12/26/2021', '01/01/2014', '09/02/2013'];
          usort($collect_roaster_holday_date, function ($a, $b) {
              return strtotime($a) - strtotime($b);
          });
          // print_r($collect_roaster_holday_date);
      
        
        $match_h_w_date = [];
        foreach ($search_period as  $key=>$s_date) {
            if (!empty($collect_roaster_holday_date) && !in_array($s_date->format('Y-m-d'), $collect_roaster_holday_date)){
              // $match_h_w_date[] = $s_date->format('Y-m-d');
              $roaster_day_off1[] = $roaster_day_off[] = [
                'employee_id' => $request->employee_id,
                'employee_fullname' => $employee_info->employee_fullname,
                'start_date' => $s_date->format('Y-m-d'),
                'end_date' => $s_date->format('Y-m-d'),
              ];
            }else{
              $roaster_day_off1 = $roaster_day_off = [];
            }
          }

          // return response($roaster_day_off1);
          
          // return response([$roaster_day_off, $roaster_day_off, $match_h_w_date]);

          // return response($roaster_day_off1);
      }

      $weekend_separation = [];
      if(count($roaster_day_off) == 0 && count($others_roaster) == 0){
        // return response([$roaster_day_off]);
        $company_weekend =  CompanySbu::valid()->project()->select('id', 'weekend')->where('id', $employee_sbu)->first();
        if(!empty($employee_sbu)){
          $weekend_separation = explode(',', $company_weekend->weekend);
        }else{
          $weekend_separation = [];
        }
      }

    
      
      // return response([$search_period,$weekend_separation,$roaster_day_off1]);
      $find_h_dates = array();
      $match_h_w_date = array();
      foreach ($search_period as  $key=>$s_date) {
        if($key < $count_date_array ){
          $leave_period = CarbonPeriod::create($holidays_date[$key]['holiday_start_date'], $holidays_date[$key]['holiday_end_date']);
          foreach ($leave_period as $key2=>$date1) {
            
            $find_h_dates[] =  $date1->format('Y-m-d');

            if($key2 == $count_date_array){
              break;
            }
          }
        }
        // dd($leave_period,$find_h_dates); 
        if (!empty($find_h_dates) && in_array($s_date->format('Y-m-d'), $find_h_dates)){
          $match_h_w_date[] = $s_date->format('Y-m-d');
        }
        
        if (!empty($weekend_separation) && in_array(date('D', strtotime($s_date->format("Y-m-d"))), $weekend_separation)){
          $match_h_w_date[] = $s_date->format('Y-m-d');
        }
      }

    

      // $roaster_day_off = collect($roaster_day_off)->toArray();
      if(count($roaster_day_off) > 0){
      $find_h_dates = array();
      $match_h_w_date = array();
        $count_roaster_day_off = count($roaster_day_off);
      
        foreach ($search_period as  $key=>$s_date) {
         
          if($key < $count_roaster_day_off ){
            if(count($roaster_day_off1) > 0){
              $roaster_period = CarbonPeriod::create($roaster_day_off[$key]->start_date, $roaster_day_off[$key]->end_date);
            }else{
              $roaster_period = CarbonPeriod::create($roaster_day_off[$key]->start_date, $roaster_day_off[$key]->end_date);
            }
            // return response([$roaster_day_off, $find_h_dates, $match_h_w_date]);
            foreach ($roaster_period as $key2=>$date1) {
              $find_h_dates[] =  $date1->format('Y-m-d');
            }
            if (!empty($find_h_dates) && in_array($s_date->format('Y-m-d'), $find_h_dates)){
              $match_h_w_date[] = $s_date->format('Y-m-d');
            }
          }
          
        }
      }

      // return response($match_h_w_date);

      // return response([$match_h_w_date, $roaster_day_off, $weekend_separation]);

      // return response([$roaster_period, $search_period]);

      $data['cross_match_h_w'] = $match_h_w_date;
      // $data['from_date'] = $from_date;
      // $data['cross_match_h_w'] = $match_h_w_date;
      $data['count_holiday_weekend'] = count(array_unique($match_h_w_date));
      $data['rest_day_except_hw'] = $total_day - $data['count_holiday_weekend'];
      // date('D',strtotime($date->format("Y-m-d"))) == 'Fri')
      return response($data);
    }



}
