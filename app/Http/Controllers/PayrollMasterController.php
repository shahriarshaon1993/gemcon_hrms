<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\ValidationException;
use Validator;
// use Illuminate\Validation\ValidationException;
use Auth;
use Session;
use App\Model\UsersPersonModel;
use App\Model\Employee;
use App\Model\CompanySbu;
// use App\Model\Section;
use App\Model\Department;
use App\Model\Designation;
// use App\Model\JobGrade;
// use App\Model\SubUnit;
// use App\Model\WorkLocation;
use App\Model\MenuTable;
// use App\Model\UserRole;
use App\Model\UserRoleAccess;
use App\Model\AttendanceSetup;
use App\Model\EmployeeAdressDetail;
use App\Model\EmployeeFamilyDetail;
use App\Model\EmployeeEducationalQualification;
use App\Model\EmployeeTrainingRecord;
use App\Model\EmployeeOthersContact;
use App\Model\LeaveType;
use App\Model\LeaveApplication;
use App\Model\HolidaySetup;
use App\Model\NoticeModel;
use App\Model\NoticePermission;
use App\Model\ServiceRequest;
use App\Model\LateRequest;
use App\Model\AttendanceIssue;
use App\Model\ManualAttendance;
// use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use App\Model\DocumentFolder;
use App\Model\DocumentFile;
// use App\Http\Controllers\Controller;

use DB;
use Hash;
use Response;
use DateTime;
use DateInterval;
use DatePeriod;
use \Carbon\CarbonPeriod;
// use Carbon;



class PayrollMasterController extends Controller
{

    // public function __construct(){

    //     $this->middleware('guest:user')->except('logout');

    // }
    // public function __construct(){

    //     $this->middleware('guest:user')->except('logout');

    // }
//     public function __construct()
// {
//     $this->middleware('auth')->except('logout');
// }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){

        if(!empty(Auth::guard('user')->user())){
               $id = Auth::guard('user')->user()->id;
           }else{
               return redirect('/');
           }
           // 
           // echo "<pre>";
           // print_r($id);
           // exit();
           $data['employee_data'] = Employee::select(
                                       'employees.*',
                                       'employee_personal_infos.*',
                                       'employee_personal_infos.id as emp_per_id',
                                       'employees.employee_mobile as employee_mobile',
                                       'departments.department_name',
                                       'designations.designation_name',
                                       'designations.designation_name',
                                       'company_sbus.sbu_name',
                                       'sub_units.sub_unit_name',
                                       'sections.section_name',
                                       'work_locations.work_location_name',
                                       'employees2.employee_fullname as reporting_boss'
                                   )
               ->leftJoin('employees as employees2','employees2.id', '=', 'employees.employee_reporting_to')
               ->leftJoin('users_person', 'users_person.employee_id', '=', 'employees.id')
               ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
               ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
               ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
               ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
               ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
               ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
               ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
               ->where('users_person.id', $id)
               ->where('employees.employee_status',1)
               ->first();
           $data['user'] = UsersPersonModel::where('id',$id)->first();
        //    $data['menu_list'] = self::buildMenu($menuList->all());

           $data['url_data'] = 1;

           return view('layouts.dashboard_payroll', $data);
    }


    public function paginate($items, $perPage = 2, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function profileIndex(Request $request) {

//       $date=['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];

// foreach ($date as $key => $value) {

//       $from_date_formated ='2020-08-'.$key;
//         // date('Y-m-d');
//         // date('Y-m-d') ;
//         // date('Y-m-d')
//        $employee_info=DB::table('employees')
//                      ->select('employees.id','employees.employee_id_no','employees.employee_fullname as employee_full_name','employees.employee_sbu','employees.employee_section','employees.employee_department','employees.employee_designation','employees.employee_sub_unit','employees.employee_sub_unit')
//                      // ->valid()
//                      ->where('valid',1)
//                      ->where('employee_status',1)
//                      ->get()->toArray();
//        $employee_ids=collect($employee_info)->pluck('employee_id_no')->toArray();  
//        $employee_primary_ids=collect($employee_info)->pluck('id')->toArray();


//         $attendance_data= DB::table('attendance_log')
//                          ->whereIn('employee_id', $employee_ids)
//                          ->where('TransactionDate', $from_date_formated)
//                          ->where('valid', '=', 1)
//                          ->get()->toArray();
//          $manulAttendance=DB::table('manual_attendances')
//                          ->whereIn('employee_id_no', $employee_ids)
//                          ->where('manual_attendance_date', $from_date_formated)
//                          ->where('manual_attendance_status',1)
//                          ->where('valid', '=', 1)
//                          ->get()->toArray();

//          $attendanceTime = DB::table('attendance_setups')
//                             ->select('attendance_setups.*','office_time_setups.office_start_time as office_start_time','office_time_setups.office_end_time as office_end_time','office_time_setups.lateConsiderTime as lateConsiderTime','office_time_setups.office_type as office_type','office_time_setups.type as type')
//                             ->leftJoin('office_time_setups','office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
//                               ->whereIn('attendance_setups.employee_id', $employee_primary_ids)
//                              ->where('office_time_end_date','>=',$from_date_formated)
//                              ->where('office_time_start_date','<=',$from_date_formated)
//                              ->get(); 
//          $approve_late_request =DB::table('late_approve_requests')
//                              ->whereIn('employee_id', $employee_primary_ids)
//                              ->where('late_date', $from_date_formated)
//                              ->where('late_approve_status', '=', 2)
//                              ->get();

//          $company_sbu_data=DB::table('company_sbus')->get(); 


//          $approve_late_find = array();
//          if ($approve_late_request) {
//              foreach ($approve_late_request as $date) {
//                  array_push($approve_late_find, $date->late_date); 
//              }
//          }

//          $holidayFind = DB::table('holiday_setups')
//                             ->select('holiday_setups.*')
//                             ->where('holiday_start_date', $from_date_formated)
//                             ->get();
//          $holiday_find = array();

//          if ($holidayFind) {

//              foreach ($holidayFind as $key => $value) {
//                  $period_holiday = CarbonPeriod::create($value['holiday_start_date'], $value['holiday_end_date']);
//                  foreach ($period_holiday as $date) {
//                       array_push($holiday_find, $date->format('Y-m-d'));
//                  }
//              }
//          }
//          $indLeaveInfo =DB::table('leave_applications')
//                      ->leftJoin('leave_types','leave_types.id','=','leave_applications.leave_type')
//                      ->where('leave_from_date', $from_date_formated)
//                      ->whereIn('employee_id', $employee_primary_ids)
//                      ->where('leave_applications.leave_apply_status', '=', 2)
//                      ->get();          
//          $ind_leave_info = array(); 
//          if ($indLeaveInfo) {
//              foreach ($indLeaveInfo as $key => $value) {
//                  $period_live = CarbonPeriod::create($value->leave_from_date, $value->leave_to_date);
//                  foreach ($period_live as $date) {
//                      array_push($ind_leave_info, $date->format('Y-m-d')); 
//                  }
//              }
             
//          }

//        $pay_days_count = 0;
//          $holiday_count = 0;
//          $leave_count = 0;
//          $present_day_count = 0;
//          $late_day_count = 0;
//          $absent_day_count = 0;
//          $total_late_time = 0;
//          $total_work_time = 0;

//          $late_times = array();
//          $work_times = array();
//          $dataLength = 0; 
//          $attendance_dataNew=[];
//          $attendances=[];

//          $emaploeeAttendall=DB::table('attendance')->where('pdate',$from_date_formated)->get()->toArray();  

//          foreach($employee_info as $key => $value){
//              $attendance_time=collect($attendanceTime)->where('employee_id',$value->id)->first();
//               $companySbu_data=collect($company_sbu_data)->where('id',$value->employee_sbu)->first();
//               $weekend= explode(",",$companySbu_data->weekend);

//             $attendance_time=collect($attendanceTime)->where('employee_id',$value->id)
//                                ->where('start_date','<=',$from_date_formated)
//                                ->where('end_date','>=',$from_date_formated)
//                                 ->first();

//             if(empty($attendance_time)){
//              $attendance_time=$companySbu_data;
//              $attendance_time->office_type=1;
//              $attendance_time->type=1;
             
//             }

         
//          // exit();
//              $intime=collect(collect($attendance_data)->where('TransactionDate',$from_date_formated)->where('employee_id',$value->employee_id_no)->sortBy('id')->values()->all())->first();
//              $outtime=collect(collect($attendance_data)->where('TransactionDate',$from_date_formated)->where('employee_id',$value->employee_id_no)->sortByDesc('id')->values()->all())->first();
//              $manulAttendances=collect($manulAttendance)->where('manual_attendance_date',$from_date_formated)->where('employee_id_no',$value->employee_id_no)->first();
//              $office_start_time = isset($attendance_time->office_start_time)?$attendance_time->office_start_time:'00:00:00';
//              $office_end_time = isset($attendance_time->office_end_time)?$attendance_time->office_end_time:'00:00:00';
        
//            if(!empty($attendance_time)){


//              if(!empty($manulAttendances)){
//                   $intimes =date('H:i', strtotime($manulAttendances->manual_start_time));
//                   $outtimes =date('H:i', strtotime($manulAttendances->manual_end_time));

//                    // if(!empty($attendance_time->lateConsiderTime)){
//                    //      $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
//                    //  }else{
//                    //      $lateConsiderTime=strtotime($office_start_time);
//                    //  }
//                     if(!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) !=  date('H:i', strtotime('00:00:00'))){
//                         $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
//                     }else{
//                         $lateConsiderTime=date('H:i', strtotime($office_start_time));
//                     }

//                    if ($intimes <= $lateConsiderTime) {
//                          $late_time = '00:00';
//                          $status="Present";
//                          $statusId=1;
//                    }else{
//                        if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
//                          $late_time = strtotime($intimes) - strtotime($office_start_time);
//                          $late_time = date('H:i',$late_time);
//                          $status="Late(Approved)";
//                          $statusId=1;
//                        }else{
//                           $late_time = strtotime($intimes) - strtotime($office_start_time);
//                           $late_time = date('H:i',$late_time);
//                           $status="Late";
//                           $statusId=2;
//                        }
//                    }

//                   $work_time = strtotime($outtimes) - strtotime($intimes);
//                   $attendances=[
//                         "machineno"=>0,
//                         "uploadid"=>0,
//                         "employee_id"=>$value->id,
//                         "employee_card_no"=>$value->employee_id_no,
//                          "pdate"=>$from_date_formated,
//                          "intime" => $intimes,
//                          "outime" => $outtimes,
//                          "latetime"=>$late_time,
//                          "start_time" => date('H:i', strtotime($office_start_time)),
//                          "end_time" => date('H:i', strtotime($office_end_time)),
//                          "pstatus"=>$statusId,
//                          "status"=>1,
//                          "remarks"=>$status,
//                          "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
//                       ];  


//              }else if($attendance_time->type==2){

//                  if(!empty($intime) && !empty($outtime)){
//                      $intimes =date('H:i', strtotime($intime->TransactionTime));
//                      $outtimes =date('H:i', strtotime($outtime->TransactionTime));
                     
//                      if($attendance_time->office_type ==2){
//                           $status="Weekend";
//                           $statusId=1;
//                           $late_time = '00:00';
//                      }else{
//                         // if(!empty($attendance_time->lateConsiderTime)){
//                         //     $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
//                         // }else{
//                         //     $lateConsiderTime=strtotime($office_start_time);
//                         // }
//                         if(!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) !=  date('H:i', strtotime('00:00:00'))){
//                             $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
//                         }else{
//                             $lateConsiderTime=date('H:i', strtotime($office_start_time));
//                         }
//                          if ($intimes <= $lateConsiderTime) {
//                              $late_time = '00:00';
//                              $status="Present";
//                              $statusId=1;
//                          }else{
//                              if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
//                                  $late_time = strtotime($intimes) - strtotime($office_start_time);
//                                  $late_time = date('H:i',$late_time);
//                                  $status="Late(Approved)";
//                                  $statusId=1;
//                                }else{
//                                   $late_time = strtotime($intimes) - strtotime($office_start_time);
//                                   $late_time = date('H:i',$late_time);
//                                   $status="Late";
//                                   $statusId=2;
//                                }
//                          }

//                      }
//                      $work_time = strtotime($outtimes) - strtotime($intimes);

//                       $attendances=[
//                         "machineno"=>0,
//                         "uploadid"=>0,
//                         "employee_id"=>$value->id,
//                         "employee_card_no"=>$value->employee_id_no,
//                          "pdate"=>$from_date_formated,
//                          "intime" => $intimes,
//                          "outime" => $outtimes,
//                          "latetime"=>$late_time,
//                          "start_time" => date('H:i', strtotime($office_start_time)),
//                          "end_time" => date('H:i', strtotime($office_end_time)),
//                          "pstatus"=>$statusId,
//                          "status"=>1,
//                          "remarks"=>$status,
//                          "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
//                       ];  



//                  }else{
//                      if ($attendance_time['office_type']==2) {
//                           $status="Weekend";
//                           $statusId=4;

//                      }elseif (!empty($holiday_find) && in_array($from_date_formated, $holiday_find)) {
//                          $status="Holiday";
//                          $statusId=5;
//                      }elseif (!empty($ind_leave_info) && in_array($from_date_formated, $ind_leave_info)) {
//                          $laveType=collect($indLeaveInfo)->where('leave_from_date','<=',$from_date_formated)->where('leave_to_date','>=',$from_date_formated)->first();
//                          $status=$laveType['leave_short_type'];
//                          $statusId=6;
//                      }else{
//                          $status="Absent";
//                          $statusId=3;
//                      }

//                      $attendances=[
//                         "machineno"=>0,
//                         "uploadid"=>0,
//                         "employee_id"=>$value->id,
//                         "employee_card_no"=>$value->employee_id_no,
//                          "pdate"=>$from_date_formated,
//                          "intime" => '00:00:00',
//                          "outime" => '00:00:00',
//                          "latetime"=>'00:00:00',
//                          "start_time" => date('H:i', strtotime($office_start_time)),
//                          "end_time" => date('H:i', strtotime($office_end_time)),
//                          "pstatus"=>$statusId,
//                          "status"=>1,
//                          "remarks"=>$status,
//                          "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
//                       ];  

//                  }


//              }else{

//                  if(!empty($intime) && !empty($outtime)){
//                      $intimes =date('H:i', strtotime($intime->TransactionTime));
//                      $outtimes =date('H:i', strtotime($outtime->TransactionTime));
                     
//                      if(in_array(date('D',strtotime($from_date_formated)), $weekend)){
//                           $status="Weekend";
//                           $statusId=1;
//                           $late_time = '00:00';
//                      }else{
//                         //  if(!empty($attendance_time->lateConsiderTime)){
//                         //     $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
//                         // }else{
//                         //     $lateConsiderTime=strtotime($office_start_time);
//                         // }
//                         if(!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) !=  date('H:i', strtotime('00:00:00'))){
//                             $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
//                         }else{
//                             $lateConsiderTime=date('H:i', strtotime($office_start_time));
//                         }

//                          if ($intimes <= $lateConsiderTime) {
//                              $late_time = '00:00';
//                              $status="Present";
//                              $statusId=1;
//                          }else{

//                              if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
//                                  $late_time = strtotime($intimes) - strtotime($office_start_time);
//                                  $late_time = date('H:i',$late_time);
//                                  $status="Late(Approved)";
//                                  $statusId=1;
//                                }else{
//                                   $late_time = strtotime($intimes) - strtotime($office_start_time);
//                                   $late_time = date('H:i',$late_time);
//                                   $status="Late";
//                                   $statusId=2;
//                                }
//                          }

//                      }
//                      $work_time = strtotime($outtimes) - strtotime($intimes);

//                       $attendances=[
//                         "machineno"=>0,
//                         "uploadid"=>0,
//                         "employee_id"=>$value->id,
//                         "employee_card_no"=>$value->employee_id_no,
//                          "pdate"=>$from_date_formated,
//                          "intime" => $intimes,
//                          "outime" => $outtimes,
//                          "latetime"=>$late_time,
//                          "start_time" => date('H:i', strtotime($office_start_time)),
//                          "end_time" => date('H:i', strtotime($office_end_time)),
//                          "pstatus"=>$statusId,
//                          "status"=>1,
//                          "remarks"=>$status,
//                          "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
//                       ];  



//                  }else{
//                      if ((in_array(date('D',strtotime($from_date_formated)), $weekend))) {
//                           $status="Weekend";
//                           $statusId=4;
//                           $late_time = '00:00';

//                      }elseif (!empty($holiday_find) && in_array($from_date_formated, $holiday_find)) {
//                          $status="Holiday";
//                          $statusId=5;
//                          $late_time = '00:00';
//                      }elseif (!empty($ind_leave_info) && in_array($from_date_formated, $ind_leave_info)) {
//                          $laveType=collect($indLeaveInfo)->where('leave_from_date','<=',$from_date_formated)->where('leave_to_date','>=',$from_date_formated)->first();
//                          $status=$laveType->leave_short_type;
//                          $statusId=6;
//                      }else{
//                          $status="Absent";
//                          $statusId=3;
//                          $late_time = '00:00';
//                      }

//                      $attendances=[
//                         "machineno"=>0,
//                         "uploadid"=>0,
//                         "employee_id"=>$value->id,
//                         "employee_card_no"=>$value->employee_id_no,
//                          "pdate"=>$from_date_formated,
//                          "intime" => '00:00:00',
//                          "outime" => '00:00:00',
//                          "latetime"=>'00:00:00',
//                          "start_time" => date('H:i', strtotime($office_start_time)),
//                          "end_time" => date('H:i', strtotime($office_end_time)),
//                          "pstatus"=>$statusId,
//                          "status"=>1,
//                          "remarks"=>$status,
//                          "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
//                       ];  

//                  }


//              }
//            }


//              $emaploeeAttends=collect($emaploeeAttendall)
//                              ->where('employee_card_no',$value->employee_id_no)
//                              ->where('employee_id',$value->id)
//                              ->first();

//              if(!empty($emaploeeAttends)){
//                    $aaa=DB::table('attendance')
//                              ->where('employee_card_no',$value->employee_id_no)
//                              ->where('employee_id',$value->id)
//                              ->where('pdate',$from_date_formated)
//                              ->update($attendances);
  
//              }else{


//                  $attendance_dataNew[]=$attendances;
//              }



//          }

//        $dd=DB::table('attendance')->insert($attendance_dataNew);



//         echo "<pre>";
//         print_r($dd);
//   }
//       exit();


















  
        
       if(!empty(Auth::guard('user')->user()->id)){
            $id = Auth::guard('user')->user()->id;
        }else{
            return redirect('/');
        }
         // return response($from_date);
        // $id = Auth::guard('user')->user()->id;
        $employee_list = new Employee();
        $employee_ids=$employee_list->Employee_id();
        // echo "<pre>";
        // print_r($employee_ids['employee_id']);
        // exit();
        // $employee_id=$employee_ids[0];

        $data['employee_data'] = Employee::valid()->project()
            ->select(
                'employees.*',
                'employee_personal_infos.*',
                'employee_personal_infos.id as emp_per_id',
                'employees.employee_mobile as employee_mobile',
                'departments.department_name',
                'designations.designation_name',
                'designations.designation_name',
                'company_sbus.sbu_name',
                'sub_units.sub_unit_name',
                'sections.section_name',
                'work_locations.work_location_name',
                'employees2.employee_fullname as reporting_boss',
                'employee_personal_infos.employee_gender'
            )
            ->leftJoin('employees as employees2','employees2.employee_id_no', '=', 'employees.employee_reporting_to')
            ->leftJoin('users_person', 'users_person.employee_id', '=', 'employees.id')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->where('users_person.id', $id)
            ->first();



        $d = new DateTime(date("Y-m-d"));
        $d->modify('first day of this month');
        $month_first_date=$d->format('Y-m-d');

        $date = new DateTime(date("Y-m-d"));
        $date->modify('+1 day');
        $tomorrow =$date->format('Y-m-d');

        $start = $tomorrow;
        $end = $month_first_date; 

        if ($request['from_date'] && $request['to_date']) {
            $data['ajax_from_date'] = $request['from_date'];
            $data['ajax_to_date'] = $request['to_date'];
            $datef = str_replace('/', '-', $request->from_date);
            $from_date =  date('Y-m-d', strtotime($datef));
            $datet = str_replace('/', '-', $request['to_date']);
            $to_date =  date('Y-m-d', strtotime($datet));
            $end = $month_first_date = $ajax_from = date('Y-m-d', strtotime($from_date)); 
            $start = $month_last_date = $ajax_to = date('Y-m-d', strtotime($to_date));
        }

        $attendances = $this->attendances_finds($start,$end,$data['employee_data']['employee_joining_date']);
        $data['attendances'] =$attendances;

        $data['present_day_count'] = collect($attendances)->where('statusId',1)->count();
        $data['late_day_count'] = collect($attendances)->where('statusId',2)->count();
        $data['leave_count']=collect($attendances)->where('statusId',3)->count();
        $data['holiday_count'] = collect($attendances)->where('statusId',4)->count(); 
        $data['absent_day_count'] = collect($attendances)->where('statusId',5)->count();
        $data['pay_days'] = $data['present_day_count']+$data['late_day_count']+$data['leave_count']+$data['holiday_count']; 
        // echo "<pre>";
        // print_r($data['leave_count']);
        // exit();
         // echo "<pre>";
         //            print_r($attendances);

              /* Find present days */
        $data['months'] = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        // $data['months'] = array_reverse( $data['months'] );
         $data['months_array'] = array('01' => 'Jan','02' => 'Feb','03' => 'Mar','04' => 'Apr','05' => 'May','06' => 'Jun','07' => 'Jul','08' => 'Aug','09' => 'Sep','10' => 'Oct','11' => 'Nov','12' => 'Dec'
        );


        // $data['months_array']= array_reverse( $data['months_array']);
        $present_count = 0; 
        $late_count = 0; 
        $holiday_count = 0;
        $month_wise_present = array();
        $month_wise_late = array();
        $month_day_count = array();



        foreach ($data['months_array'] as $month_key => $value) {
            if ($request['from_date'] && $request['to_date']) {
                  $data['ajax_from_date'] = $request['from_date'];
                  $data['ajax_to_date'] = $request['to_date'];
                  $datef = str_replace('/', '-', $request->from_date);
                  $from_date =  date('Y-m-d', strtotime($datef));
                  $datet = str_replace('/', '-', $request['to_date']);
                  $to_date =  date('Y-m-d', strtotime($datet));
                  $startMonts= date('m', strtotime($from_date));
                  $endMonths=date('m', strtotime($to_date));

                  $startYers= date('Y', strtotime($from_date));
                  $endYers=date('Y', strtotime($to_date));

                  $requestMonths=array();
                  for ($x = $startMonts; $x <= $endMonths; $x++) {
                        array_push($requestMonths, $x);
                   } 
                   $requestYers=array();
                   for ($x = $startYers; $x <= $endYers; $x++) {
                        array_push($requestYers, $x);
                   }  
                   
                        $year=$startYers;
                        if(in_array($month_key, $requestMonths)){
                              $year= $year;
                              $first_date_of_month=date("Y-m-d", strtotime($year.'-'.$month_key.'-'.'01'));
                              $d = new DateTime($first_date_of_month);
                              $d->modify( 'last day of this month' );
                              $last_day_of_month=$d->format('Y-m-d');
                  
                              $attendances = $this->attendances_finds($last_day_of_month,$first_date_of_month,$data['employee_data']['employee_joining_date']);
                              $present_count  = collect($attendances)->where('statusId',1)->count();
                              $late_count  = collect($attendances)->where('statusId',2)->count();
                              $absent_data  = collect($attendances)->where('dates','>=',$data['employee_data']['employee_joining_date'])->where('dates','<=',date('Y-m-d'))->where('statusId',5)->count();
                        }else{
                              $present_count=0;
                              $late_count =0;
                              $absent_data=0;
                              $last_day_of_month="0000-00-00";
                              $first_date_of_month="0000-00-00";
                        }      

                         array_push($month_wise_present, $present_count);
                        array_push($month_wise_late, $late_count);
                        array_push($month_day_count, $absent_data);
                       
                 
              }else{
                  $year=date('Y');
                  $first_date_of_month=date("Y-m-d", strtotime($year.'-'.$month_key.'-'.'01'));
                  $d = new DateTime($first_date_of_month);
                  $d->modify( 'last day of this month' );
                  $last_day_of_month=$d->format('Y-m-d');

                  $attendances = $this->attendances_finds($last_day_of_month,$first_date_of_month,$data['employee_data']['employee_joining_date']);
                  $present_count  = collect($attendances)->where('statusId',1)->count();
                  $late_count  = collect($attendances)->where('statusId',2)->count();
                  $absent_data  = collect($attendances)->where('dates','>=',$data['employee_data']['employee_joining_date'])->where('dates','<=',date('Y-m-d'))->where('statusId',5)->count();
                  array_push($month_wise_present, $present_count);
                  array_push($month_wise_late, $late_count);
                  array_push($month_day_count, $absent_data);

              }

          
            

        }
        // echo "<pre>";
        //            print_r($month_day_count);
        //            exit();

        $data['data'] = $month_wise_present;
        $data['late_data'] = $month_wise_late;
        $data['absent_data'] = $month_day_count;

        // $data['data'] = collect($attendances)->where('statusId',1)->count('');
        // $data['late_data'] = $month_wise_late;
        // $data['absent_data'] = $month_day_count;

        // echo "<pre>";
        // print_r($attendances);
        // exit();


        // echo "<pre>";
        // print_r($attendances);
        // exit();

























      
        $data['address_details'] =EmployeeAdressDetail::valid()->project()
            // ->leftJoin('users_person', 'users_person.employee_id', '=', 'employee_adress_details.ead_employee_id')
            ->where('ead_employee_id', '=', Auth::guard('user')->user()->employee_id)->first();
        $data['family_details'] =EmployeeFamilyDetail::valid()->project()
            // ->leftJoin('users_person', 'users_person.employee_id', '=', 'employee_family_details.efd_employee_id')
            ->where('efd_employee_id', '=', Auth::guard('user')->user()->employee_id)->get();
        $data['educational_details'] =EmployeeEducationalQualification::valid()->project()
            // ->leftJoin('users_person', 'users_person.employee_id', '=', 'employee_educational_qualifications.eeq_employee_id')
            ->where('eeq_employee_id', '=', Auth::guard('user')->user()->employee_id)->get();
        // echo "<pre>";
        // print_r($data['educational_details']);
        // exit();
        $data['training_details'] =EmployeeTrainingRecord::valid()->project()
            // ->leftJoin('users_person', 'users_person.employee_id', '=', 'employee_training_records.etr_employee_id')
            ->where('etr_employee_id', '=', Auth::guard('user')->user()->employee_id)->get();
        $data['others_contact_details'] =EmployeeOthersContact::valid()->project()
            // ->leftJoin('users_person', 'users_person.employee_id', '=', 'employee_others_contacts.eoc_employee_id')
            ->where('eoc_employee_id', '=', Auth::guard('user')->user()->employee_id)->get();
        /* Below code for attendance data */
        $data['user'] = UsersPersonModel::where('id',$id)->first();
        $employee=Employee::valid()->project()->where('id',Auth::guard('user')->user()->employee_id)->first();
       $today = date('Y-m-d');              
       

       if($data['employee_data']['employee_gender'] == 1){
          $data['leave_type_info'] =LeaveType::valid()->project()
            ->leftJoin('leave_setups', 'leave_setups.leave_type', '=', 'leave_types.id')
            ->get(); 
        }else{
           $data['leave_type_info'] =LeaveType::valid()->project()
            ->leftJoin('leave_setups', 'leave_setups.leave_type', '=', 'leave_types.id')
            ->where('leave_short_type','!=','ML')
            ->get(); 
        }

        /* Leave info for leave table*/
       
        $leaveNo =LeaveApplication::valid()->project()
                       ->select(DB::raw("SUM(leave_total_day) as leave_total_day,leave_applications.leave_type"))
                       // ->where('leave_applications.leave_type', '=', $value['leave_type'])
                       ->where('leave_applications.leave_apply_status', '=', 2)
                       ->where('leave_applications.employee_id', '=', $employee['id'])
                       ->groupBy('leave_applications.leave_type')
                       ->get()->toArray();
       // echo "<pre>";
       // print_r( $leave_no);
       // exit();

        $leave_consumed= array();
        $leave_available = array();
        foreach ($data['leave_type_info'] as $key => $value) {
           $leave_no=collect($leaveNo)->where('leave_type',$value['leave_type'])->first();
            if ($leave_no) {
                $leave_c_no = $leave_no['leave_total_day'];
                $leave_remaining = $value['leave_day_no']-$leave_c_no;
            }else{
                $leave_c_no = 0;
                $leave_remaining = $value['leave_day_no']-$leave_c_no;
            }
            array_push($leave_consumed, $leave_c_no);
            array_push($leave_available,
                [
                'leave_remaining'=>$leave_remaining,
                'leave_type'=>$value['leave_type']
                ]);
        }   

        // echo "<pre>"; print_r($leave_consumed); echo "<pre>";
        $data['leave_consumed']=$leave_consumed; 
        $data['leave_available']=$leave_available;
        /* Leave info for leave table*/

        $today_month = date('m');
        $today_day = date('d');
        $data['today_birthday_info'] =Employee::valid()->project()
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->select(
                'employees.*',
                'employee_personal_infos.employee_dob_actual',
                'departments.department_name',
                'designations.designation_name'
            )
            ->whereMonth('employee_personal_infos.employee_dob_actual', '=', $today_month)
            ->whereDay('employee_personal_infos.employee_dob_actual', '=', $today_day)
            ->get();
            // $date=data('Y-m-d');
// ->where('notice_sdate','>=',date('Y-m-d'))
        $notices=NoticeModel::valid()->project()->where('notice_status',1)->where('notice_edate','>=',date('Y-m-d'))->get()->toArray();
        $noticesPasmition=NoticePermission::valid()->project()->where('notice_edate','<=',date('Y-m-d'))->get();
        // ->where('notice_sdate','>=',date('Y-m-d'))
        // echo "<pre>";
            // print_r($noticesid['permission_type']);
            // exit();


        foreach ($notices as $key => $value) {
            $noticesid=collect($noticesPasmition)->where('notice_id',$value['id'])->toArray();
            // echo "<pre>";
            // print_r($noticesid['permission_type']);
            // exit();
            if(!empty($noticesid)){
                foreach ($noticesid as $key => $value){
                    if($value['permission_type']==1 && $value['permission_id']==Auth::guard('user')->user()->company_sbu){
                        $notices[$key]['access']=1;

                    }elseif ($value['permission_type']==2 && $value['permission_id']==Auth::guard('user')->user()->department) {
                       $notices[$key]['access']=1;
                    }elseif ($value['permission_type']==3 && $value['permission_id']==Auth::guard('user')->user()->unit) {
                        $notices[$key]['access']=1;
                    }elseif ($value['permission_type']==4 && $value['permission_id']==Auth::guard('user')->user()->sub_unit) {
                        $notices[$key]['access']=1;
                    }elseif ($value['permission_type']==5 && $value['permission_id']==Auth::guard('user')->user()->section) {
                        $notices[$key]['access']=1;
                    }elseif ($value['permission_type']==6 && $value['permission_id']==Auth::guard('user')->user()->sub_section) {
                        $notices[$key]['access']=1;
                    }elseif ($value['permission_type']==7 && $value['permission_id']==Auth::guard('user')->user()->employee_card_no) {
                        $notices[$key]['access']=1;
                    }else{
                        $notices[$key]['access']=0;
                    }
                }
            }else{
                $notices[$key]['access']=1;
            }
        }


        // echo "<pre>";
        // print_r($notices);
        // exit();
        $data['notices']=collect($notices)->where('access',1)->toArray();
        /* Leave info */
        $data['all_employee_data']=array();
        $all_employee_data=Employee::valid()->project()->whereIn('employee_sbu',$employee_ids['sub'])->whereIn('employee_department',$employee_ids['department'])->get();

        foreach ($all_employee_data as $value) {
          array_push($data['all_employee_data'],['id'=>$value['id'],'text'=>$value['employee_id_no']." - ". $value['employee_fullname']]);
        }

        $data['leave_type_data']=array();
        $leave_type_data=LeaveType::valid()->project()->get();
        foreach ($leave_type_data as $value) {
          array_push($data['leave_type_data'],['id'=>$value['id'],'text'=>$value['leave_type_name'],'short_text'=>$value['leave_short_type']]);
        }

        $employee_data_directory = Employee::valid()->project()
            ->select(
                'employees.*',
                'employee_personal_infos.*',
                'employee_personal_infos.id as emp_per_id',
                'employees.employee_mobile as employee_mobile',
                'departments.department_name',
                'designations.designation_name',
                'employees.id as employee_id_pri',
                'sections.section_name as section_name',
                'company_sbus.sbu_name'
            )
            ->leftJoin('employees as employees2','employees2.employee_id_no', '=', 'employees.employee_reporting_to')
            ->leftJoin('users_person', 'users_person.employee_id', '=', 'employees.id')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->where('employees.employee_status', 1)
             ->where('employees.employee_sbu', Auth::guard('user')->user()->company_sbu)
            ->where('employees.employee_department', Auth::guard('user')->user()->department)

            // $employee_ids['department']
            ->orderBy('employees.id', 'desc');
        $all_employee_data=$employee_data_directory;
            // ->take(20)
            // ->get()
            
        $data['employee_data_directory'] =$all_employee_data->paginate(7);
         $data['allEmployeeData']=$all_employee_data->get();    
         // print_r($data['allEmployeeData']);


         $approve_late_request =LateRequest::valid()->project()
                ->where('employee_id', '=', $employee['id'])
                ->where('late_approve_status', '=', 2)
                ->get();
        $data['approve_late_request'] = $approve_late_request;

         $attendance_issues =AttendanceIssue::valid()->project()
                ->where('attendance_issue_status', '=', 1)
                ->get();
        $data['attendance_issues'] = $attendance_issues;



        /* Worked on 20/1/2021 Start */
        $all_folder_info = DocumentFolder::valid()->project()
            ->leftJoin('employees', 'employees.id', '=', 'document_folders.created_by')
            ->select(
                'document_folders.*',
                'employees.employee_fullname'
            )
            ->where('document_folders.folder_status', 1)
            // ->where('document_folders.sbu_id', Auth::guard('user')->user()->company_sbu)
            // ->where('document_folders.department_id', Auth::guard('user')->user()->department)
            ->orderBy('document_folders.id', 'desc');
        $all_folder_info_data=$all_folder_info;
        $data['all_folder_info'] =$all_folder_info_data->paginate();
        /* Worked on 20/1/2021 End */


        return view('layouts.app', $data);
    }

    function attendances_finds ($start,$end,$joining_date){
        $start_date=$end;
        $end_date=$start;
        $start= new DateTime($start);
        $end = new DateTime($end);
        $diff = $end->diff($start);
  
        $interval = DateInterval::createFromDateString('-1 day');
      
        $period_main = new DatePeriod($start, $interval, $diff->days);


        $attendance_data= DB::table('attendance_log')
                        ->where('attendance_log.employee_id',Auth::guard('user')->user()->employee_card_no)
                        ->whereBetween('TransactionDate', [$start_date, $end_date])
                        ->where('valid', '=', 1)
                        ->get()->toArray();
        $manulAttendance=DB::table('manual_attendances')
                        ->where('employee_id_no',Auth::guard('user')->user()->employee_card_no)
                        ->whereBetween('manual_attendance_date', [$start_date, $end_date])
                        ->where('manual_atten_approve_status',2)
                        ->where('manual_attendance_status',1)
                        ->where('valid', '=', 1)
                        ->get()->toArray();

        $attendanceTime = AttendanceSetup::valid()->project()
                            ->select('attendance_setups.*','office_time_setups.office_start_time as office_start_time','office_time_setups.office_end_time as office_end_time','office_time_setups.lateConsiderTime as lateConsiderTime','office_time_setups.office_type as office_type','office_time_setups.type as type')
                            ->leftJoin('office_time_setups','office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
                            ->where('employee_id', Auth::guard('user')->user()->employee_id) 
                            // ->where('office_time_end_date','>=',$start_date)
                            // ->where('office_time_start_date','<=',$end_date)
                             ->where('end_date','>=',$start_date)
                            ->where('start_date','<=',$end_date)
                            ->get(); 
        $approve_late_request =LateRequest::valid()->project()
                            ->where('employee_id', '=',Auth::guard('user')->user()->employee_id)
                            ->whereBetween('late_date', [$start_date, $end_date])
                            ->where('late_approve_status', '=', 2)
                            ->get();
        $company_sbu_data=CompanySbu::valid()->project()->where('id',Auth::guard('user')->user()->company_sbu)->first(); 

        $weekend= explode(",",$company_sbu_data['weekend']);

   
                  
        $approve_late_find = array();
        if ($approve_late_request) {
            foreach ($approve_late_request as $date) {
                array_push($approve_late_find, $date['late_date']); 
            }
        }

        $holidayFind = HolidaySetup::valid()->project()
                           ->select('holiday_setups.*')
                           ->whereBetween('holiday_start_date', [$start_date, $end_date])
                           ->get();
        $holiday_find = array();

        if ($holidayFind) {
            // $period_holiday = CarbonPeriod::create($holidayFind['holiday_start_date'], $holidayFind['holiday_end_date']);
            // foreach ($period_holiday as $date) {
            //     array_push($holiday_find, $date->format('Y-m-d')); 
            // }
            foreach ($holidayFind as $key => $value) {
                $period_holiday = CarbonPeriod::create($value['holiday_start_date'], $value['holiday_end_date']);
                foreach ($period_holiday as $date) {
                     array_push($holiday_find, $date->format('Y-m-d'));
                }
            }
        }
        $indLeaveInfo =LeaveApplication::valid()->project()
                    ->leftJoin('leave_types','leave_types.id','=','leave_applications.leave_type')
                    ->whereBetween('leave_from_date', [$start_date, $end_date])
                    ->where('leave_applications.leave_apply_status', '=', 2)
                    ->where('leave_applications.employee_id', '=', Auth::guard('user')->user()->employee_id)
                    ->get();          
        $ind_leave_info = array(); 
        if ($indLeaveInfo) {
            foreach ($indLeaveInfo as $key => $value) {
                $period_live = CarbonPeriod::create($value['leave_from_date'], $value['leave_to_date']);
                foreach ($period_live as $date) {
                    array_push($ind_leave_info, $date->format('Y-m-d')); 
                }
            }
            
        }

        $pay_days_count = 0;
        $holiday_count = 0;
        $leave_count = 0;
        $present_day_count = 0;
        $late_day_count = 0;
        $absent_day_count = 0;
        $total_late_time = 0;
        $total_work_time = 0;
        // $late_time = '';
        $late_times = array();
        $work_times = array();
        $dataLength = 0; 
        $late_time="";
        $attendances=[];

        foreach($period_main as $date){
            if ($date->format("Y-m-d")==date('Y-m-d', strtotime(' +1 day'))) {
                 continue; 
            }
            $dataLength++;
            $pay_days_count++;

            $attendance_time=collect($attendanceTime)
           ->where('start_date','<=',$date->format("Y-m-d"))
           ->where('end_date','>=',$date->format("Y-m-d"))
            ->first();


            if(empty($attendance_time)){
             $attendance_time=$company_sbu_data;
             $attendance_time['office_type']=1;
             $attendance_time['type']=1;
             
            }
// echo "<pre>";
//         print_r($attendance_time);
        // exit();
   

            $intime=collect(collect($attendance_data)->where('TransactionDate',$date->format("Y-m-d"))->sortBy('id')->values()->all())->first();
            $outtime=collect(collect($attendance_data)->where('TransactionDate',$date->format("Y-m-d"))->sortByDesc('id')->values()->all())->first();
            $manulAttendances=collect($manulAttendance)->where('manual_attendance_date',$date->format("Y-m-d"))->first();

            $office_start_time = isset($attendance_time->office_start_time)?$attendance_time->office_start_time:'00:00:00';
            $office_end_time = isset($attendance_time->office_end_time)?$attendance_time->office_end_time:'00:00:00';
        if($joining_date <= $date->format("Y-m-d")){
            if(!empty($attendance_time)){
                if(!empty($manulAttendances)){
                     $intimes =date('H:i', strtotime($manulAttendances->manual_start_time));
                     $outtimes =date('H:i', strtotime($manulAttendances->manual_end_time));

                        if(!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) !=  date('H:i', strtotime('00:00:00'))){
                            $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                        }else{
                            $lateConsiderTime=date('H:i', strtotime($office_start_time));
                        }

                      if ($intimes <= $lateConsiderTime) {
                            $late_time = '00:00';
                            $status="P";
                            $statusId=1;
                      }else{
                          if (!empty($approve_late_find) && in_array($date->format("Y-m-d"), $approve_late_find)) {
                            $late_time = strtotime($intimes) - strtotime($office_start_time);
                            $late_time = date('H:i',$late_time);
                            $status="L";
                            $statusId=1;
                          }else{
                             $late_time = strtotime($intimes) - strtotime($office_start_time);
                             $late_time = date('H:i',$late_time);
                             $status="L";
                             $statusId=2;
                          }
                      }

                     $work_time = strtotime($outtimes) - strtotime($intimes);
                     $attendances[]=[
                            "date"=>$date->format("j M, Y"),
                            "dates"=>$date->format("Y-m-d"),
                            "office_start_time" => date('H:i', strtotime($office_start_time)),
                            "office_end_time" => date('H:i', strtotime($office_end_time)),
                            "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
                            "intime" => $intimes,
                            "outtime" => $outtimes,
                            "late_time"=>$late_time,
                            "work_time"=>date('H:i',$work_time),
                            "Status"=>$status,
                            "statusId"=>$statusId,
                         ];  



                }else if($attendance_time['type']==2){
                    if(!empty($intime) && !empty($outtime)){
                        $intimes =date('H:i', strtotime($intime->TransactionTime));
                        $outtimes =date('H:i', strtotime($outtime->TransactionTime));

                        if($attendance_time['office_type']==2 ){
                             $status="W";
                             $statusId=1;
                        }else{
                            // if(!empty($attendance_time->lateConsiderTime)){
                            //     $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                            // }else{
                            //     $lateConsiderTime=strtotime($office_start_time);
                            // }
                            if(!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) !=  date('H:i', strtotime('00:00:00'))){
                                $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                            }else{
                                $lateConsiderTime=date('H:i', strtotime($office_start_time));
                            }


                            if ($intimes <= $lateConsiderTime) {
                                $late_time = '00:00';
                                $status="P";
                                $statusId=1;
                            }else{
                                if (!empty($approve_late_find) && in_array($date->format("Y-m-d"), $approve_late_find)) {
                                    $late_time = strtotime($intimes) - strtotime($office_start_time);
                                    $late_time = date('H:i',$late_time);
                                    $status="L";
                                    $statusId=1;
                                  }else{
                                     $late_time = strtotime($intimes) - strtotime($office_start_time);
                                     $late_time = date('H:i',$late_time);
                                     $status="L";
                                     $statusId=2;
                                  }
                            }

                        }
                        
                       
                        $work_time = strtotime($outtimes) - strtotime($intimes);

                        
                        // if($intime >= date('H:i', strtotime($attendance_time->lateConsiderTime)) && (date('D',strtotime($date->format("Y-m-d"))) == 'Sat' || date('D',strtotime($date->format("Y-m-d"))) == 'Fri')){
                        // }

                        $attendances[]=[
                            "date"=>$date->format("j M, Y"),
                            "dates"=>$date->format("Y-m-d"),
                            "office_start_time" => date('H:i', strtotime($office_start_time)),
                            "office_end_time" => date('H:i', strtotime($office_end_time)),
                            "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
                            "intime" => $intimes,
                            "outtime" => $outtimes,
                            "late_time"=>$late_time,
                            "work_time"=>date('H:i',$work_time),
                            "Status"=>$status,
                            "statusId"=>$statusId,
                         ];  

                        // exit();
                    }else{
                        if($attendance_time['office_type']==2) {
                             $status="W";
                             $statusId=4;

                        }elseif (!empty($holiday_find) && in_array($date->format("Y-m-d"), $holiday_find)) {
                            $status="H";
                            $statusId=4;
                        }elseif (!empty($ind_leave_info) && in_array($date->format("Y-m-d"), $ind_leave_info)) {
                            $laveType=collect($indLeaveInfo)->where('leave_from_date','<=',$date->format("Y-m-d"))->where('leave_to_date','>=',$date->format("Y-m-d"))->first();
                            $status=$laveType['leave_short_type'];
                            $statusId=3;
                        }else{
                            $status="A";
                            $statusId=5;
                        }

                        $attendances[]=[
                            "date"=>$date->format("j M, Y"),
                            "dates"=>$date->format("Y-m-d"),
                            "office_start_time" => date('H:i', strtotime($office_start_time)),
                            "office_end_time" => date('H:i', strtotime($office_end_time)),
                            "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
                            "intime" => '00:00',
                            "outtime" => '00:00',
                            "late_time" => '00:00',
                            "work_time" => '00:00',
                            "Status"=>$status,
                            "statusId"=>$statusId,
                        ];


                    }

                }else{
                    if(!empty($intime) && !empty($outtime)){
                        $intimes =date('H:i', strtotime($intime->TransactionTime));
                        $outtimes =date('H:i', strtotime($outtime->TransactionTime));

                        if(in_array(date('D',strtotime($date->format("Y-m-d"))), $weekend) ){
                             $status="W";
                             $statusId=1;
                        }else{
                            // if(!empty($attendance_time->lateConsiderTime)){
                            //     $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                            // }else{
                            //     $lateConsiderTime=strtotime($office_start_time);
                            // }
                            if(!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) !=  date('H:i', strtotime('00:00:00'))){
                                $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                            }else{
                                $lateConsiderTime=date('H:i', strtotime($office_start_time));
                            }

                            if ($intimes <= $lateConsiderTime) {
                                $late_time = '00:00';
                                $status="P";
                                $statusId=1;
                            }else{
                                if (!empty($approve_late_find) && in_array($date->format("Y-m-d"), $approve_late_find)) {
                                    $late_time = strtotime($intimes) - strtotime($office_start_time);
                                    $late_time = date('H:i',$late_time);
                                    $status="L";
                                    $statusId=1;
                                  }else{
                                     $late_time = strtotime($intimes) - strtotime($office_start_time);
                                     $late_time = date('H:i',$late_time);
                                     $status="L";
                                     $statusId=2;
                                  }
                            }

                        }
                        
                       
                        $work_time = strtotime($outtimes) - strtotime($intimes);

                        
                        // if($intime >= date('H:i', strtotime($attendance_time->lateConsiderTime)) && (date('D',strtotime($date->format("Y-m-d"))) == 'Sat' || date('D',strtotime($date->format("Y-m-d"))) == 'Fri')){
                        // }

                        $attendances[]=[
                            "date"=>$date->format("j M, Y"),
                            "dates"=>$date->format("Y-m-d"),
                            "office_start_time" => date('H:i', strtotime($office_start_time)),
                            "office_end_time" => date('H:i', strtotime($office_end_time)),
                            "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
                            "intime" => $intimes,
                            "outtime" => $outtimes,
                            "late_time"=>$late_time,
                            "work_time"=>date('H:i',$work_time),
                            "Status"=>$status,
                            "statusId"=>$statusId,
                         ];  

                        // exit();
                    }else{
                        if((in_array(date('D',strtotime($date->format("Y-m-d"))), $weekend))) {
                             $status="W";
                             $statusId=4;

                        }elseif (!empty($holiday_find) && in_array($date->format("Y-m-d"), $holiday_find)) {
                            $status="H";
                            $statusId=4;
                        }elseif (!empty($ind_leave_info) && in_array($date->format("Y-m-d"), $ind_leave_info)) {
                            $laveType=collect($indLeaveInfo)->where('leave_from_date','<=',$date->format("Y-m-d"))->where('leave_to_date','>=',$date->format("Y-m-d"))->first();
                            $status=$laveType['leave_short_type'];
                            $statusId=3;
                        }else{
                            $status="A";
                            $statusId=5;
                        }

                        $attendances[]=[
                            "date"=>$date->format("j M, Y"),
                            "dates"=>$date->format("Y-m-d"),
                            "office_start_time" => date('H:i', strtotime($office_start_time)),
                            "office_end_time" => date('H:i', strtotime($office_end_time)),
                            "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
                            "intime" => '00:00',
                            "outtime" => '00:00',
                            "late_time" => '00:00',
                            "work_time" => '00:00',
                            "Status"=>$status,
                            "statusId"=>$statusId,
                        ];


                    }

                }
            }
        }
        
        }
      
             // exit();
        return $attendances;  

    }

    function fetch_data(Request $request)
    {
        // echo"<pre>";
        // print_r($request->get('viewType'));

        // dd($srequest);
        // exit();
     if($request->ajax())
     {

      $sort_by = 'employees.'.$request->get('sortby');
      $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
     if(!empty($request->get('query'))){

        $employee_data_directory = Employee::valid()->project()
            ->select(
                'employees.*',
                'employee_personal_infos.*',
                'employee_personal_infos.id as emp_per_id',
                'employees.employee_mobile as employee_mobile',
                'departments.department_name',
                'designations.designation_name',
                'sections.section_name',
                'company_sbus.sbu_name'
            )
            ->leftJoin('employees as employees2','employees2.employee_id_no', '=', 'employees.employee_reporting_to')
            ->leftJoin('users_person', 'users_person.employee_id', '=', 'employees.id')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->where('employees.employee_status', 1)
            ->where('employees.employee_id_no', 'like', '%'.$query.'%')
            ->orWhere('employees.employee_fullname', 'like', '%'.$query.'%')
            // ->orWhere('post_description', 'like', '%'.$query.'%')
            ->orderBy($sort_by, $sort_type)
            ->paginate(7);

     }else{

        $employee_data_directory = Employee::valid()->project()
            ->select(
                'employees.*',
                'employee_personal_infos.*',
                'employee_personal_infos.id as emp_per_id',
                'employees.employee_mobile as employee_mobile',
                'departments.department_name',
                'designations.designation_name',
                 'sections.section_name',
                'company_sbus.sbu_name'
            )
            ->leftJoin('employees as employees2','employees2.employee_id_no', '=', 'employees.employee_reporting_to')
            ->leftJoin('users_person', 'users_person.employee_id', '=', 'employees.id')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->where('employees.employee_status', 1)
             ->where('employees.employee_sbu', Auth::guard('user')->user()->company_sbu)
            ->where('employees.employee_department', Auth::guard('user')->user()->department)
            // ->orWhere('post_description', 'like', '%'.$query.'%')
            ->orderBy($sort_by, $sort_type)
            ->paginate(7);

     }      

     // echo "<pre>";
     // print_r($request->get('view_type'));
     // exit();

      // self::pagination_data_grid($employee_data_directory);

        if($request->get('viewType')==1){
            return view('layouts.pagination_data', compact('employee_data_directory'))->render();
        }elseif ($request->get('viewType')==2) {
            // echo "<pre>";
            // print_r($employee_data_directory);
            // exit();
            return view('layouts.pagination_data_grid', compact('employee_data_directory'))->render();
        }
      
     }
    }
    // pagination_data_grid

    function pagination_data_grid ($employee_data_directory){

        // echo "<pre>";
        // print_r('sss');
        // exit();
        return view('layouts.pagination_data_grid', compact('employee_data_directory'))->render();
    }

    function countDays($year, $month, $ignore) {
        $count = 0;
        $counter = mktime(0, 0, 0, $month, 1, $year);
        while (date("n", $counter) == $month) {
            if (in_array(date("w", $counter), $ignore) == false) {
                $count++;
            }
            $counter = strtotime("+1 day", $counter);
        }
        return $count;  
    }

    public function get_last_service_info($id){
        $service_data = ServiceRequest::valid()->project()
            ->where('service_requests.service_type', $id)->where('employee_id',Auth::guard('user')->user()->employee_id)
            // ->where('service_requests.approve_status', 2)
            ->first();
        return response($service_data);
    }


    public function dashboard(Request $request) {
        //  echo "<pre>";
        // print_r();
        // exit();
        //   echo "<pre>";
        // print_r("sss");
        // exit();
        if(!empty(Auth::guard('user')->user())){
            $id = Auth::guard('user')->user()->id;
        }else{
            return redirect('/');
        }
        // 
        // echo "<pre>";
        // print_r($id);
        // exit();
        $data['employee_data'] = Employee::select(
                                    'employees.*',
                                    'employee_personal_infos.*',
                                    'employee_personal_infos.id as emp_per_id',
                                    'employees.employee_mobile as employee_mobile',
                                    'departments.department_name',
                                    'designations.designation_name',
                                    'designations.designation_name',
                                    'company_sbus.sbu_name',
                                    'sub_units.sub_unit_name',
                                    'sections.section_name',
                                    'work_locations.work_location_name',
                                    'employees2.employee_fullname as reporting_boss'
                                )
            ->leftJoin('employees as employees2','employees2.id', '=', 'employees.employee_reporting_to')
            ->leftJoin('users_person', 'users_person.employee_id', '=', 'employees.id')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->where('users_person.id', $id)
            ->where('employees.employee_status',1)
            ->first();
        $data['user'] = UsersPersonModel::where('id',$id)->first();

        return view('layouts.dashboard', $data);
    }
    public function getUserMenuList(){
        $id = Auth::guard('user')->user()->role_id;
        $employeesInfo=DB::table('employees')->where('id',Auth::guard('user')->user()->employee_id)->first();
        $sbuThemesInfo=DB::table('company_sbus')->where('id',$employeesInfo->employee_sbu)->first();
        $data['logos']=$sbuThemesInfo->sbu_logo;
        $data['Sbu_name']=$sbuThemesInfo->sbu_name;
        
        $menu_ids = UserRoleAccess::where('role_id',$id)->pluck('menu_id')->all();
        $menuList = MenuTable::whereIn('id',$menu_ids)->where('status',1)->where('panel_type',3)->get();
        $data['menuTopbar'] = MenuTable::whereIn('id',$menu_ids)->where('status',1)->where('panel_type',3)->where('is_top_bar','=','1')->get();
        $data['menu_list'] = self::buildMenu($menuList->all());
        return response()->json($data);

    }

   
    public static function buildMenu(array $elements, $parentId = 0) {
        $menuGrid = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = self::buildMenu($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $menuGrid[] = $element;
            }
        }
        return $menuGrid;
    }

    public function autoLogOutAction(Request $request) {
        $data['status'] = 'logout';
        $from  = Session::get('from');
        if($from == 'admin'){
            $data['url'] = url('admin/login');       
        }else{
            $data['url'] = url('/');          
        }
       
        return response($data);
    }

    public function dashboardSummary(){
        $company_sbu_data=CompanySbu::valid()->project()->where('sbu_status', '=', 1)->get();
        $data['company_count'] = $company_sbu_data->count();
        $department_data=Department::valid()->project()->where('department_status', '=', 1)->get();
        $data['department_count'] = $department_data->count();
        $designation_data=Designation::valid()->project()->where('designation_status', '=', 1)->get();
        $data['designation_count'] = $designation_data->count();
        $employee_data=Employee::valid()->project()->where('employee_status', '=', 1)->get();
        $data['employee_count'] = $employee_data->count();
        return response($data);
    }


    
    public function changePassword(Request $request)
    {

        // echo "<pre>"; print_r($request); die();

      if(!empty($request))
      {
        $request_data = $request->All();
        $validator = $this->admin_credential_rules($request_data);
        // dd($validator);
        if($validator->fails())
        {
          // return response()->json(array('error' => $validator->getMessageBag()->toArray()), 400);
          return redirect()->back()->with("error",'The new password and confirmation password not match.');
        }
        else
        {  
          $current_password = Auth::guard('user')->user()->password;           
          if(Hash::check($request_data['current-password'], $current_password))
          {           
            $user_id = Auth::guard('user')->user()->id;                       
            $obj_user = UsersPersonModel::find($user_id);
            $obj_user->password = Hash::make($request_data['password']);
            $obj_user->password_change = 1;
            $obj_user->save(); 
            session()->put('password_change', 1);
            // return "ok";
            return redirect()->back()->with("success","Password changed successfully !");

          }
          else
          {           
            $error = array('current-password' => 'Please enter correct current password');
            // return response()->json(array('error' => $error), 400);   
            return redirect()->back()->with("error","Please enter correct current password.");
          }
        }        
      }
      else
      {
        return redirect()->to('/');
      }    
    }

    public function admin_credential_rules(array $data)
    {
      $messages = [
        'current-password.required' => 'Please enter current password',
        'password.required' => 'Please enter password',
      ];

      $validator = Validator::make($data, [
        'current-password' => 'required',
        'password' => 'required|same:password',
        'password_confirmation' => 'required|same:password',     
      ], $messages);
        // dd($validator);

      return $validator;
    }

    public function get_responsible_info($id){
        $response_person_info = Employee::valid()->project()
            ->select(
                'employees.*',
                'departments.department_name',
                'designations.designation_name',
                'company_sbus.sbu_name'
            )
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->where('employees.employee_status', 1)
            ->where('employees.id', $id)
            ->first();
        return response($response_person_info);
    }













    public function generalInfoSubmit(Request $request){
         // echo "<pre>"; print_r($request); die();
        $user_id =Auth::guard('user')->user()->id;
        $employee_id =Auth::guard('user')->user()->employee_id;
        $user_data = DB::table('general_info_temp')->where('created_by', '=', $user_id)->first();

        $data['personal_email_id']=$request->personal_email_id;
        $data['personal_mobile_no']=$request->personal_mobile_no;
        $data['desk_phone']=$request->desk_phone;
        $data['whatsapp']=$request->whatsapp;
        $data['skype_no']=$request->skype_no;
        $data['created_by']=Auth::guard('user')->user()->id; 
        if (empty($user_data)) {
        // return response($user_data);
            DB::table('general_info_temp')->insert($data);
            DB::table('employees')->where('id', '=', $employee_id)->update(array(
                 'update_request' => 1,
              ));
        }else{
            DB::table('general_info_temp')->where('created_by', '=', $user_id)->update($data);
            DB::table('employees')->where('id', '=', $employee_id)->update(array(
                 'update_request' => 1,
              ));
        }

    }

    public function get_service_list_info($id){
        $employee_data = Employee::valid()->project()->where('employee_status', 1)->where('id',$id)
           ->get();
        $data['employee_data'] =$employee_data;

        $service_list_data = ServiceRequest::valid()->project()
            ->where('service_requests.employee_id',$id)
           ->get();
        $data['service_list_data'] =$service_list_data;

        $late_approve_data = LateRequest::valid()->project()
            ->where('late_approve_requests.employee_id',$id)
           ->get();
        $data['late_approve_data'] =$late_approve_data;

        $leave_list_data = LeaveApplication::valid()->project()
            ->leftJoin('leave_types','leave_types.id','=','leave_applications.leave_type')
            ->leftJoin('employees as emp','emp.id','=','leave_applications.leave_reliever')
            ->select('leave_applications.*','leave_applications.id as id','leave_types.leave_type_name','emp.employee_fullname as reliever_name')
            ->where('leave_applications.employee_id',$id)
           ->get();

        $data['leave_list_data'] =$leave_list_data;

        $manulAttendance_list_data=DB::table('manual_attendances')
                        ->where('employee_id',$id)
                        ->where('manual_attendance_status',1)
                         ->get(); 
        $data['manulAttendance_list_data'] =$manulAttendance_list_data;


        $serviceList=[];
        foreach ($service_list_data as $key => $value) {
            if($value['service_type']==1){
                $serves_type= 'NOC (No Objection Certificate)';
            }elseif ($value['service_type']==2) {
               $serves_type='Salary Certificate';
            }elseif ($value['service_type']==3) {
                $serves_type='Pay Slip';
            }
         $serviceList[]=[
            'Type'=>$serves_type,
            'date'=>$value['service_date'],
            'type_id'=>1,
            'status'=>$value['approve_status'],
            'purpose'=>$value['service_purpose'],
            'id'=>$value['id'],
         ];
        }
        foreach ($late_approve_data as $key => $value) {
            $serviceList[]=[
                'Type'=>'Late Approve Request',
                'type_id'=>2,
                'date'=>$value['late_request_date'],
                'status'=>$value['late_approve_status'],
                'purpose'=>$value['late_reason'],
                'id'=>$value['id'],
            ];
        }
        foreach ($leave_list_data as $key => $value) {
            $serviceList[]=[
                'Type'=>'Leave Request',
                'type_id'=>3,
                'date'=>$value['leave_apply_date'],
                'status'=>$value['leave_apply_status'],
                'purpose'=>$value['leave_reason'],
                'id'=>$value['id'],
            ];
        }

        foreach ($manulAttendance_list_data as $key => $value) {
            $serviceList[]=[
                'Type'=>'Manual Attendance',
                'type_id'=>4,
                'date'=>$value->manual_attendance_date,
                'status'=>$value->manual_atten_approve_status,
                'purpose'=>$value->manual_remarks,
                'id'=>$value->id,
            ];
        }

        $data['serviceList']=collect($serviceList)->sortByDesc('date')->values()->all();
        return response($data);
    }

    public function findServiceRequestData($id){
        $employee_id = Auth::guard('user')->user()->employee_id;
        $service_list_data = ServiceRequest::valid()->project()
            ->where('service_requests.id',$id)
            ->where('service_requests.employee_id',$employee_id)
           ->first();
        $data['service_list_data'] =$service_list_data;
        return response($service_list_data);
    }
    public function findLateRequestData($id){
        $employee_id = Auth::guard('user')->user()->employee_id;
        $late_list_data = LateRequest::valid()->project()
            ->where('late_approve_requests.id',$id)
            ->where('late_approve_requests.employee_id',$employee_id)
           ->first();
        $data['late_list_data'] =$late_list_data;
        return response($late_list_data);
    }

    public function findLeaveRequestData($id){
        $employee_id = Auth::guard('user')->user()->employee_id;
        $leave_list_data = LeaveApplication::valid()->project()
            ->leftJoin('leave_types','leave_types.id','=','leave_applications.leave_type')
            ->leftJoin('employees as emp','emp.id','=','leave_applications.leave_reliever')
            ->select('leave_applications.*','leave_applications.id as id','leave_types.leave_type_name','emp.employee_fullname as reliever_name','emp.id as reliever_id')
            ->where('leave_applications.id',$id)
            ->where('leave_applications.employee_id',$employee_id)
           ->first(); 
        $data['leave_list_data'] =$leave_list_data;
        return response($leave_list_data);
    }

    public function findManualAttendanceData($id){
        $employee_id = Auth::guard('user')->user()->employee_id;
        $manual_attendance_data = ManualAttendance::valid()->project()
            ->where('id',$id)
            ->where('employee_id',$employee_id)
           ->first();
        $data['manual_attendance_data'] =$manual_attendance_data;
        return response($manual_attendance_data);
    }

    public function findFileList($id){
         // return response($id);
        $employee_id = Auth::guard('user')->user()->employee_id;
        $file_list_data = DocumentFile::valid()->project()
            ->leftJoin('document_folders','document_folders.id','=','document_files.folder_id')
            ->leftJoin('file_types','file_types.id','=','document_files.file_type')
            ->select('document_files.*','document_folders.folder_name','file_types.type_name')
            ->where('document_files.folder_id',$id)
           ->get();
        $data['file_list_data'] =$file_list_data;
        return response($data);
    }


    public function zoom_meeting(Request $request){
        $data['id']=0;
        return view('zoom.zoom_index', $data);
    }

     public function zoom_meeting_connect($id){
        $data['id']=0;
        return view('zoom.meeting', $data);
    }





}