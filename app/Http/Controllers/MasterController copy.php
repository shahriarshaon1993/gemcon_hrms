<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
// use App\Http\Controllers\Controller;
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
use App\Model\LeaveSetup;
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
use App\Model\LeaveAdjustment;
// use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use App\Model\DocumentFolder;
use App\Model\DocumentFile;
use App\Model\OfficeTimeSetup;
use App\Model\payroll\PayrollList;
use App\Model\payroll\ProvidentFund;
// use App\Model\payroll\EmployeeLoan;
use App\Model\payroll\LoanTransaction;
use App\Model\payroll\LoanAdvance;
use App\Model\payroll\Salary;
// use App\Http\Controllers\Controller;

use DB;
use Hash;
use Response;
use DateTime;
use DateInterval;
use DatePeriod;
use \Carbon\CarbonPeriod;
use Artisan;
use Cache;
// use Carbon;



class MasterController extends Controller
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

    public function getUserInfo()
    {
        $user_id = Auth::guard('user')->user()->id;
        $user_info = UsersPersonModel::where('id', $user_id)->first();
        if (!empty($user_info)) {
            return response()->json($user_info);;
        } else {
            return response()->json(['error' => 'User not found']);
        }
    }
    public function index()
    {
        $id = Auth::guard('user')->user()->id;
        $data['user'] = UsersPersonModel::valid()->project()->findOrFail($id);
        return view('app', $data);
    }


    public function paginate($items, $perPage = 2, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function profileIndex(Request $request)
    {
        // $first_date_of_year = '2023-01-01';
        // $leaveInfo = LeaveType::valid()->project()->where('leave_short_type','AL')->get()->toArray();
        // $authorizedLive = LeaveSetup::valid()->project()->where('leave_type', 1)->where('leave_status', 1)->get();
        // // 200645
        // // 209927
        // $emplyees = Employee::valid()->project()
        // ->whereIn('employee_sbu', [3])
        // // ->whereNotIn('employee_department', [42])
        // ->where('employee_type', 1)
        // ->where('employee_status', 1)
        // // ->whereIn('employee_id_no', [209315])
        // ->get();
        // $annualLive = [];
        // foreach ($emplyees as $key => $employee){
        //     $availedLive = LeaveApplication::valid()->project()
        //     ->where('employee_id', $employee['id'])
        //     // ->where('leave_type', 1)
        //     ->where('leave_apply_status', 2)
        //     ->where('leave_from_date','>=', $first_date_of_year)
        //     // ->where('leave_to_date','<=', date("Y-m-d"))
        //     ->where('leave_to_date','<=', '2023-12-31')
        //     ->get();
        //     // dd($availedLive);
        //     $earnedLeave = DB::table('earned_leave')->where('employee_id', $employee['id'])->where('leave_status', 1)->where('date', '<', $first_date_of_year)->get();
        //     foreach ($leaveInfo as $key => $value) {
        //         $aviledLive = collect($authorizedLive)->where('leave_type', $value['id'])->first();
        //         $authorizedLives = collect($availedLive)->where('leave_type', $value['id'])->sum('leave_total_day');
        //         $previousBalance = collect($earnedLeave)->where('leave_type',$value['id'])->sum('earned_day');

        //         // echo "<pre>";
        //         // print_r([$aviledLive['leave_day_no'],$authorizedLives, $previousBalance]);
        //         // exit();
        //         // $leaveInfo[$key]['entitlementThisYear'] =  $aviledLive['leave_day_no'];
        //         // $leaveInfo[$key]['previousBalance'] =  $previousBalance;
        //         // $leaveInfo[$key]['totalDay'] =  $authorizedLives;
        //         // $leaveInfo[$key]['totalEntitlement'] = $aviledLive['leave_day_no']+$previousBalance;
        //         // $leaveInfo[$key]['balance'] = (($aviledLive['leave_day_no']+$previousBalance)-$authorizedLives);
        //         $aviledLives = 0;
        //         if($employee['employee_joining_date'] <= $first_date_of_year){
        //             $aviledLives = $aviledLive['leave_day_no'];
        //         }else{
                    
        //             $from_date = strtotime($employee['employee_joining_date']);
        //             $to_date = strtotime('2023-12-31');
        //             $day_diff = $to_date - $from_date;
        //             $totalDays =  floor($day_diff/(60*60*24));
        //             $totalAl = number_format(($aviledLive['leave_day_no']/365),5);
        //             $aviledLives = round(($totalDays * $totalAl));

        //         }
        //         // echo "<pre>";
        //         // print_r([$aviledLives,$authorizedLives]);
        //         // exit();
        //         $thisYersBalance = ($aviledLives - $authorizedLives);
        //          $thisYesrsearned_day = 0;
        //          //$thisYesrsAvailed_day = 0;
        //         if($thisYersBalance >= 7){
        //             $thisYesrsearned_day = 7;
        //         }else{
        //             $thisYesrsearned_day = $thisYersBalance;
        //         }

        //         // echo "<pre>";
        //         // print_r([$aviledLives,$authorizedLives,$thisYersBalance,$thisYesrsearned_day]);
        //         // exit();

        //         $earned_day = 0;
        //         if($previousBalance < 35){
        //             $earned_day = $thisYesrsearned_day;
        //         }else{
        //             $earned_day = 0;
        //         }

        //             $annualLive []= [
        //                 'employee_id' => $employee['id'],
        //                 'leave_type' => 1,
        //                 'date' => '2023-12-31',
        //                 'year' => '2023',
        //                 'earned_day' => $earned_day,
        //                 'leave_status' =>1, 
        //                 'project_id' => 8,
        //                 'branch_id' => 8,
        //                 'created_by' => Auth::guard('user')->user()->id,

        //             ];
        //     }
            
        // }

        // DB::table('earned_leave')->insert($annualLive);
        // exit();

        
        // $exitCode = Artisan::call('cache:clear');
        // $exitCode1 = Artisan::call('route:clear');
        // $exitCode2 = Artisan::call('config:clear');
        // $exitCode3 = Artisan::call('view:clear');

        // echo "<pre>";
        // print_r($exitCode3);
        // exit();


        // $date=['01','02','03','04','05','06','07','08','09'];
        // $date=['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];

        // foreach ($date as $key => $value) {
        //     // echo "<pre>";
        //     // print_r($value);
        //     // exit();

        //       $from_date_formated ='2021-11-'.$value;
        //         // date('Y-m-d');
        //         // date('Y-m-d') ;
        //         // date('Y-m-d')
        //        $employee_info=DB::table('employees')
        //                      ->select('employees.id','employees.employee_id_no','employees.employee_fullname as employee_full_name','employees.employee_sbu','employees.employee_section','employees.employee_department','employees.employee_designation','employees.employee_sub_unit','employees.employee_sub_unit')
        //                      // ->valid()
        //                      ->where('valid',1)
        //                      ->where('employee_status',1)
        //                      ->where('employee_sbu',7)
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
        //                  $period_holiday = CarbonPeriod::create($value->holiday_start_date, $value->holiday_end_date);
        //                  foreach ($period_holiday as $date) {
        //                       array_push($holiday_find, $date->format('Y-m-d'));
        //                  }
        //              }
        //          }
        //          $indLeaveInfo1 =DB::table('leave_applications')
        //                      ->leftJoin('leave_types','leave_types.id','=','leave_applications.leave_type')
        //                      ->where('leave_from_date', $from_date_formated)
        //                      ->whereIn('employee_id', $employee_primary_ids)
        //                      ->where('leave_applications.leave_apply_status', '=', 2)
        //                      ->get();          
        //          // $ind_leave_info = array(); 
        //          // if ($indLeaveInfo) {
        //          //     foreach ($indLeaveInfo as $key => $value) {
        //          //         $period_live = CarbonPeriod::create($value->leave_from_date, $value->leave_to_date);
        //          //         foreach ($period_live as $date) {
        //          //             array_push($ind_leave_info, $date->format('Y-m-d')); 
        //          //         }
        //          //     }

        //          // }

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
        //               $indLeaveInfo=collect($indLeaveInfo1)->where('employee_id',$value->id)->toArray();
        //               $ind_leave_info = array(); 
        //               if ($indLeaveInfo) {
        //                  foreach ($indLeaveInfo as $key => $value_a) {
        //                      $period_live = CarbonPeriod::create($value_a->leave_from_date, $value_a->leave_to_date);
        //                      foreach ($period_live as $date) {
        //                          array_push($ind_leave_info, $date->format('Y-m-d')); 
        //                      }

        //                  }

        //                }

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
        //                          $laveType=collect($indLeaveInfo)->where(''leave_from_date,'<=',$from_date_formated)->where('leave_to_date','>=',$from_date_formated)->first();
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


        //              echo $from_date_formated;
        //              echo "<br>";
        //          }

        //        $dd=DB::table('attendance')->insert($attendance_dataNew);



        //         echo "<pre>";
        //         print_r($dd);
        //   }
              // exit();




















        if (!empty(Auth::guard('user')->user()->id)) {
            $id = Auth::guard('user')->user()->id;
        } else {
            return redirect('/');
        }


        $cache = Cache::get('permission');
        $permission = collect($cache)->where('menu_uid', '=', 'ImageDownload')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
        foreach ($permission as $child) {
            if ($child['link_uid'] == 'download') {
                $data['download'] = $child['link_uid'];
            }
        }
        // return response(Auth::guard('user')->user()->role_id);
        // $id = Auth::guard('user')->user()->id;
        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
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
                'company_sbus.sbu_logo',
                'company_sbus.modal_header_color',
                'sub_units.sub_unit_name',
                'sections.section_name',
                'work_locations.work_location_name',
                'employees2.employee_fullname as reporting_boss',
                'employee_personal_infos.employee_gender',
                DB::raw('(DATEDIFF(NOW(), employees.employee_joining_date))/365 as service_length')
            )
            ->leftJoin('employees as employees2', 'employees2.employee_id_no', '=', 'employees.employee_reporting_to')
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


        $pabxAndEmailData = Employee::valid()->project()
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
             ->where('employee_status','!=', 2)
            // ->where('desk_phone_no', '!=', '')
            // ->orderBy('desk_phone_no', 'ASC')
            ->get();
        $data['emailListData'] = collect($pabxAndEmailData)->where('official_email_id', '!=', '')->where('official_email_id', '!=', 'n/a');
        $sbusIdEmail = collect($data['emailListData'])->pluck('employee_sbu')->toArray();
        $depertIdEmail = collect($data['emailListData'])->pluck('employee_department')->toArray();
        $data['sbueNameEmail'] = CompanySbu::whereIn('id', $sbusIdEmail)->orderBy('priority', 'ASC')->get()->toArray();
        $data['depertmentEmail'] = Department::whereIn('id', $depertIdEmail)->orderBy('priority', 'ASC')->get()->toArray(); 
        
        $data['pabxnumber'] = collect($pabxAndEmailData)->where('desk_phone_no', '!=', '');    
        $sbusId = collect($data['pabxnumber'])->pluck('employee_sbu')->toArray();
        $depertId = collect($data['pabxnumber'])->pluck('employee_department')->toArray();
        $data['sbueName'] = CompanySbu::whereIn('id', $sbusId)->orderBy('priority', 'ASC')->get()->toArray();
        $data['depertment'] = Department::whereIn('id', $depertId)->orderBy('priority', 'ASC')->get()->toArray();


        // $arry=[];
        //             foreach ($data['pabxnumber'] as $key => $value) {
        //                // $sbuname=collect($value)->where('employee_sbu',$key)->first();
        //                $depname=collect($value)->keyBy('department_name');
        //                echo "<pre>";
        // print_r($value['department_name']);
        //                $arry[$key]['sbu_name']=$key;
        //                 foreach ($depname as $key1 => $value1) {
        //             //         $depname=collect($value1)->where('employee_department',$key1)->first();
        //                     $arry[$key1]['dcode']=$key1;
        //             //         $arry[$key1]['dname']=$depname['department_name'];
        //             //         foreach ($value1 as $key2 => $value2) {
        //             //             $arry[$key2]['name']=$value2['employee_fullname'];
        //             //             $arry[$key2]['id']=$value2['employee_id_no'];
        //             //             $arry[$key2]['phone']=$value2['desk_phone_no'];
        //             //         }
        //                 }
        //             }
        //              echo "<pre>";
        // print_r($data['depertment']);
        // exit();

        $d = new DateTime(date("Y-m-d"));
        $d->modify('first day of this month');
        $month_first_date = $d->format('Y-m-d');

        $date = new DateTime(date("Y-m-d"));
        $date->modify('+1 day');
        $tomorrow = $date->format('Y-m-d');

        $firstDayOfYears = date('Y', strtotime($month_first_date)) . '-' . '01' . '-' . '01';

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
            $firstDayOfYears = date('Y', strtotime($request['from_date'])) . '-' . '01' . '-' . '01';
        }
        $attendance_data = DB::table('attendance_log')
            ->where('attendance_log.employee_id', Auth::guard('user')->user()->employee_card_no)
            ->whereBetween('TransactionDate', [$firstDayOfYears, $tomorrow])
            ->where('valid', '=', 1)
            ->get()->toArray();
        $attendanceTime = AttendanceSetup::valid()->project()
            ->select('attendance_setups.*', 'office_time_setups.office_start_time as office_start_time', 'office_time_setups.office_end_time as office_end_time', 'office_time_setups.lateConsiderTime as lateConsiderTime', 'office_time_setups.office_type as office_type', 'office_time_setups.type as type')
            ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
            ->where('employee_id', Auth::guard('user')->user()->employee_id)
            ->where('end_date', '>=', $firstDayOfYears)
            ->where('start_date', '<=', $tomorrow)
            ->get();
        $attendances =  $this->attendances_finds($start, $end, $data['employee_data'], $data['employee_data']['employee_joining_date'], $attendance_data, $attendanceTime);
        $data['attendances'] = $attendances;

        $data['present_day_count'] = collect($attendances)->where('statusId', 1)->count();
        $data['late_day_count'] = collect($attendances)->where('statusId', 2)->count();
        $data['leave_count'] = collect($attendances)->where('statusId', 3)->count();
        $data['holiday_count'] = collect($attendances)->where('statusId', 4)->count();
        $data['absent_day_count'] = collect($attendances)->where('statusId', 5)->count();
        $data['pay_days'] = $data['present_day_count'] + $data['late_day_count'] + $data['leave_count'] + $data['holiday_count'];
        // echo "<pre>";
        // print_r($attendances);
        // exit();
        // echo "<pre>";
        //            print_r($attendances);

        /* Find present days */
        $data['months'] = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        // $data['months'] = array_reverse( $data['months'] );
        $data['months_array'] = array(
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'
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
                $startMonts = date('m', strtotime($from_date));
                $endMonths = date('m', strtotime($to_date));

                $startYers = date('Y', strtotime($from_date));
                $endYers = date('Y', strtotime($to_date));

                $requestMonths = array();
                for ($x = $startMonts; $x <= $endMonths; $x++) {
                    array_push($requestMonths, $x);
                }
                $requestYers = array();
                for ($x = $startYers; $x <= $endYers; $x++) {
                    array_push($requestYers, $x);
                }

                $year = $startYers;
                if (in_array($month_key, $requestMonths)) {
                    $year = $year;
                    $first_date_of_month = date("Y-m-d", strtotime($year . '-' . $month_key . '-' . '01'));
                    $d = new DateTime($first_date_of_month);
                    $d->modify('last day of this month');
                    $last_day_of_month = $d->format('Y-m-d');
                    // $attendances =[];
                    $attendances = $this->attendances_finds($last_day_of_month, $first_date_of_month, $data['employee_data'], $data['employee_data']['employee_joining_date'], $attendance_data, $attendanceTime);
                    $present_count  = collect($attendances)->where('statusId', 1)->count();
                    $late_count  = collect($attendances)->where('statusId', 2)->count();
                    $absent_data  = collect($attendances)->where('dates', '>=', $data['employee_data']['employee_joining_date'])->where('dates', '<=', date('Y-m-d'))->where('statusId', 5)->count();
                } else {
                    $present_count = 0;
                    $late_count = 0;
                    $absent_data = 0;
                    $last_day_of_month = "0000-00-00";
                    $first_date_of_month = "0000-00-00";
                }

                array_push($month_wise_present, $present_count);
                array_push($month_wise_late, $late_count);
                array_push($month_day_count, $absent_data);
            } else {
                $year = date('Y');
                $first_date_of_month = date("Y-m-d", strtotime($year . '-' . $month_key . '-' . '01'));
                $d = new DateTime($first_date_of_month);
                $d->modify('last day of this month');
                $last_day_of_month = $d->format('Y-m-d');

                // $attendances = [];
                $attendances = $this->attendances_finds($last_day_of_month, $first_date_of_month, $data['employee_data'], $data['employee_data']['employee_joining_date'], $attendance_data, $attendanceTime);
                $present_count  = collect($attendances)->where('statusId', 1)->count();
                $late_count  = collect($attendances)->where('statusId', 2)->count();
                $absent_data  = collect($attendances)->where('dates', '>=', $data['employee_data']['employee_joining_date'])->where('dates', '<=', date('Y-m-d'))->where('statusId', 5)->count();
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







        $data['address_details'] = EmployeeAdressDetail::valid()->project()
            // ->leftJoin('users_person', 'users_person.employee_id', '=', 'employee_adress_details.ead_employee_id')
            ->where('ead_employee_id', '=', Auth::guard('user')->user()->employee_id)->first();
        $data['family_details'] = EmployeeFamilyDetail::valid()->project()
            // ->leftJoin('users_person', 'users_person.employee_id', '=', 'employee_family_details.efd_employee_id')
            ->where('efd_employee_id', '=', Auth::guard('user')->user()->employee_id)->get();
        $data['educational_details'] = EmployeeEducationalQualification::valid()->project()
            // ->leftJoin('users_person', 'users_person.employee_id', '=', 'employee_educational_qualifications.eeq_employee_id')
            ->where('eeq_employee_id', '=', Auth::guard('user')->user()->employee_id)->get();
        // echo "<pre>";
        // print_r($data['educational_details']);
        // exit();
        $data['training_details'] = EmployeeTrainingRecord::valid()->project()
            // ->leftJoin('users_person', 'users_person.employee_id', '=', 'employee_training_records.etr_employee_id')
            ->where('etr_employee_id', '=', Auth::guard('user')->user()->employee_id)->get();
        $data['others_contact_details'] = EmployeeOthersContact::valid()->project()
            // ->leftJoin('users_person', 'users_person.employee_id', '=', 'employee_others_contacts.eoc_employee_id')
            ->where('eoc_employee_id', '=', Auth::guard('user')->user()->employee_id)->get();
        /* Below code for attendance data */
        $data['user'] = UsersPersonModel::where('id', $id)->first();
        $employee = Employee::valid()->project()->where('id', Auth::guard('user')->user()->employee_id)->first();
        $today = date('Y-m-d');


        if ($data['employee_data']['employee_gender'] == 1) {
            if($data['employee_data']['employee_type'] == 2){
                $data['leave_type_info'] = LeaveType::valid()->project()
                ->leftJoin('leave_setups', 'leave_setups.leave_type', '=', 'leave_types.id')
                ->select('leave_types.*', 'leave_setups.*', 'leave_setups.id as leave_setup_id')
                ->where('leave_short_type', 'CL')
                ->get();
            }else{
                $data['leave_type_info'] = LeaveType::valid()->project()
                ->leftJoin('leave_setups', 'leave_setups.leave_type', '=', 'leave_types.id')
                ->select('leave_types.*', 'leave_setups.*', 'leave_setups.id as leave_setup_id')
                ->get();
            }
        } else {
            if($data['employee_data']['employee_type'] == 2){
                $data['leave_type_info'] = LeaveType::valid()->project()
                ->leftJoin('leave_setups', 'leave_setups.leave_type', '=', 'leave_types.id')
                ->select('leave_types.*', 'leave_setups.*', 'leave_setups.id as leave_setup_id')
                ->where('leave_short_type', 'CL')
                ->get();
            }else{
                $data['leave_type_info'] = LeaveType::valid()->project()
                ->leftJoin('leave_setups', 'leave_setups.leave_type', '=', 'leave_types.id')
                ->select('leave_types.*', 'leave_setups.*', 'leave_setups.id as leave_setup_id')
                ->where('leave_short_type', '!=', 'ML')
                ->get();
            }
        }

        // if($data['employee_data']['employee_gender'] == 1)

        // foreach ($leaveInfo as $value) {
        //     if($user_employee_data->employee_type == 2){
        //       if($value['leave_short_type'] == 'CL'){
        //         array_push($data['leave_type_data'],['id'=>$value['id'],'text'=>$value['leave_type_name']]);
        //       }
        //     }else{
        //       array_push($data['leave_type_data'],['id'=>$value['id'],'text'=>$value['leave_type_name']]);
        //     }
        //   }

        //  echo "<pre>";
        // print_r($data['leave_type_info']);
        // exit();

        /* Leave info for leave table*/
        $first_date_of_year=date('Y-m-d', strtotime(date('Y').'-01'.'-01'));
        // return $first_date_of_year;


        $leaveNo = LeaveApplication::valid()->project()
            ->select(DB::raw("SUM(leave_total_day) as leave_total_day,leave_applications.leave_type"))
            // ->where('leave_applications.leave_type', '=', $value['leave_type'])
            ->where('leave_applications.leave_apply_status', '=', 2)
            ->where('leave_to_date', '>=', $first_date_of_year)
            ->where('leave_applications.employee_id', '=', $employee['id'])
            ->groupBy('leave_applications.leave_type')
            ->get()->toArray();
        // echo "<pre>";
        // print_r( $leave_no);
        // exit();

        $leave_consumed = array();
        $leave_available = array();
        $earnedLeave=DB::table('earned_leave')->where('employee_id',$employee['id'])->where('leave_status',1)->where('date','<',$first_date_of_year)->get();
          
        foreach ($data['leave_type_info'] as $key => $value) {
            $leave_no = collect($leaveNo)->where('leave_type', $value['leave_type'])->first();
            $previousBalance=collect($earnedLeave)->where('leave_type',$value['leave_type'])->sum('earned_day');
            // echo "<pre>"; print_r($value['id']); echo "<pre>";
            if ($leave_no) {
                $leave_c_no = $leave_no['leave_total_day'];
                $leave_remaining = ($value['leave_day_no'] + $previousBalance) - $leave_c_no;
                $totalEntitle=($value['leave_day_no'] + $previousBalance);
            } else {
                $leave_c_no = 0;
                $leave_remaining = ($value['leave_day_no'] + $previousBalance) - $leave_c_no;
                $totalEntitle=($value['leave_day_no'] + $previousBalance);
            }
            array_push($leave_consumed, $leave_c_no);
            array_push(
                $leave_available,
                [
                    'leave_remaining' => $leave_remaining,
                    'leave_type' => $value['leave_type'],
                    'Prev'=>$previousBalance,
                    'totalEntitle'=>$totalEntitle
                ]
            );
        }
        // exit();
        // echo "<pre>"; print_r($leave_consumed); echo "<pre>";
        $data['leave_consumed'] = $leave_consumed;
        $data['leave_available'] = $leave_available;
        // leave data from hrm inner module
        if ($employee['employee_gender'] == 1) {
            $leaveInfo = LeaveType::valid()->project()->get();
        } else {
            $leaveInfo = LeaveType::valid()->project()->where('leave_short_type', '!=', 'ML')->get();
        }
        $authorizedLive = LeaveSetup::valid()->project()->where('leave_status', 1)->get();
        $availedLive = LeaveApplication::valid()->project()->where('employee_id', $employee['id'])->where('leave_apply_status', 2)
        ->where('leave_apply_date', '>=', $first_date_of_year)->where('leave_apply_date', '<=', date("Y-m-d"))
        ->where('leave_from_date','>=',$first_date_of_year)->where('leave_to_date','<=',date("Y-m-d"))
        ->get();
        $earnedLeave = DB::table('earned_leave')->where('employee_id', $employee['id'])->where('leave_status', 1)->where('date', '<', $first_date_of_year)->get();
        $data['find_confirmation_date'] = $find_confirmation_date = $employee['employee_confirmation_due_date'];
        $data['find_today'] = $find_today = date('Y-m-d');

        foreach ($leaveInfo as $key => $value) {
            //  code for meena bazar start
            if(Auth::guard('user')->user()->company_sbu == 2 || Auth::guard('user')->user()->company_sbu == 11 || Auth::guard('user')->user()->company_sbu == 27){
                $running_year = date('Y');
                $joining_year = date ('Y', strtotime($employee['employee_joining_date']));
                $year_end = new DateTime(date('Y-m-d', strtotime('12/31')));
                $today_date = new DateTime(date('Y-m-d'));
                if($joining_year == $running_year){
                  $joining_date = new DateTime($employee['employee_joining_date']);
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
                $authorizedLives=collect($availedLive)->where('leave_type',$value['id'])->sum('leave_total_day');
                $previousBalance=collect($earnedLeave)->where('leave_type',$value['id'])->sum('earned_day');
                $leaveInfo[$key]['entitlementThisYear']= $aviledLive_leave_day_no;
                $leaveInfo[$key]['previousBalance']= $previousBalance ?? 0;
                $leaveInfo[$key]['totalDay']= $authorizedLives; // availed
                $leaveInfo[$key]['totalEntitlement'] = $aviledLive_leave_day_no+$previousBalance;
                $leaveInfo[$key]['balance'] = (($aviledLive_leave_day_no+$previousBalance)-$authorizedLives);
            }else{
            //  code for meena bazar end

             if(($find_confirmation_date > $find_today) || ($employee->employee_type != 1)){
            // if($find_confirmation_date > $find_today){
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
                $joining_year = date ('Y', strtotime($employee['employee_joining_date']));
                $year_end = new DateTime(date('Y-m-d', strtotime('12/31')));
                $today_date = new DateTime(date('Y-m-d'));
                if($joining_year == $running_year){
                  $joining_date = new DateTime($employee['employee_joining_date']);
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
                $authorizedLives=collect($availedLive)->where('leave_type',$value['id'])->sum('leave_total_day');
                $previousBalance=collect($earnedLeave)->where('leave_type',$value['id'])->sum('earned_day');
                $leaveInfo[$key]['entitlementThisYear']= $aviledLive_leave_day_no;
                $leaveInfo[$key]['previousBalance']= $previousBalance ?? 0;
                $leaveInfo[$key]['totalDay']= $authorizedLives; // availed
                $leaveInfo[$key]['totalEntitlement'] = $aviledLive_leave_day_no+$previousBalance;
                $leaveInfo[$key]['balance'] = (($aviledLive_leave_day_no+$previousBalance)-$authorizedLives);
              }
            } 
        }
        $data['leaveInfo'] = $leaveInfo;

        $data['approvalfristId'] = Employee::valid()->project()->leftJoin('employee_approvals', 'employee_approvals.ea_approve_by', '=', 'employees.id')->where('ea_approval_lavel', 1)->where('employee_status',1)->where('ea_employee_id', $employee['id'])->first();

        $data['approval2ndId'] = Employee::valid()->project()->leftJoin('employee_approvals', 'employee_approvals.ea_approve_by', '=', 'employees.id')->where('ea_approval_lavel', 2)->where('employee_status',1)->where('ea_employee_id', $employee['id'])->first();
        /* Leave info for leave table*/

        $today_month = date('m');
        $today_day = date('d');
        $data['today_birthday_info'] = Employee::valid()->project()
            ->leftJoin('unit_models', 'unit_models.id', '=', 'employees.employee_unit')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->select(
                'employees.*',
                'employee_personal_infos.employee_dob_actual',
                'departments.department_name',
                'company_sbus.sbu_name',
                'unit_models.unit_name',
                'designations.designation_name'
            )
            ->whereMonth('employee_personal_infos.employee_dob_actual', '=', $today_month)
            ->whereDay('employee_personal_infos.employee_dob_actual', '=', $today_day)
            ->get();
        // $date=data('Y-m-d');
        // ->where('notice_sdate','>=',date('Y-m-d'))
        // ->where('end_date','>=',$start_date)
        //                ->where('start_date','<=',$end_date)
        $notices = NoticeModel::valid()->project()->where('notice_status', 1)->where('notice_edate', '>=', date('Y-m-d'))->get()->toArray();
        $noticesPasmition = NoticePermission::valid()->project()->where('notice_edate', '<=', date('Y-m-d'))->get();
        // ->where('notice_sdate','>=',date('Y-m-d'))
        // echo "<pre>";
        // print_r($noticesid['permission_type']);
        // exit();


        foreach ($notices as $key => $value) {
            $noticesid = collect($noticesPasmition)->where('notice_id', $value['id'])->toArray();
            // echo "<pre>";
            // print_r($noticesid['permission_type']);
            // exit();
            if (!empty($noticesid)) {
                foreach ($noticesid as $key => $value) {
                    if ($value['permission_type'] == 1 && $value['permission_id'] == Auth::guard('user')->user()->company_sbu) {
                        $notices[$key]['access'] = 1;
                    } elseif ($value['permission_type'] == 2 && $value['permission_id'] == Auth::guard('user')->user()->department) {
                        $notices[$key]['access'] = 1;
                    } elseif ($value['permission_type'] == 3 && $value['permission_id'] == Auth::guard('user')->user()->unit) {
                        $notices[$key]['access'] = 1;
                    } elseif ($value['permission_type'] == 4 && $value['permission_id'] == Auth::guard('user')->user()->sub_unit) {
                        $notices[$key]['access'] = 1;
                    } elseif ($value['permission_type'] == 5 && $value['permission_id'] == Auth::guard('user')->user()->section) {
                        $notices[$key]['access'] = 1;
                    } elseif ($value['permission_type'] == 6 && $value['permission_id'] == Auth::guard('user')->user()->sub_section) {
                        $notices[$key]['access'] = 1;
                    } elseif ($value['permission_type'] == 7 && $value['permission_id'] == Auth::guard('user')->user()->employee_card_no) {
                        $notices[$key]['access'] = 1;
                    } else {
                        $notices[$key]['access'] = 0;
                    }
                }
            } else {
                $notices[$key]['access'] = 1;
            }
        }

        $data['notice_viewers'] = [];
        $data['notice_vewing_info'] = [];
        if (!empty($value['id'])) {
            $data['notice_viewers'] = self::find_notice_viewer_info($value['id']);
            $data['notice_vewing_info'] = self::find_notice_vewing_info($value['id'], $employee['id']);
        }

        // echo "<pre>";
        $first_birthday_id = collect($data['today_birthday_info'])->first();
        // print_r($first_birthday_id['id']);
        // exit();
        $data['birthday_likers'] = [];
        $data['birthday_liking_info'] = [];
        if (!empty($first_birthday_id)) {
            $data['birthday_likers'] = self::find_birthday_likers($first_birthday_id['id']);
            $data['birthday_liking_info'] = self::find_birthday_liking_info($first_birthday_id['id'], $employee['id']);
        }


        $data['birthday_wishers'] = [];
        $data['birthday_wishing_info'] = [];
        if (!empty($first_birthday_id)) {
            $data['birthday_wishers'] = self::find_birthday_likers($first_birthday_id['id']);
            $data['birthday_wishing_info'] = self::find_birthday_liking_info($first_birthday_id['id'], $employee['id']);
        }


        // echo "<pre>";
        // print_r($notices);
        // exit();
        $data['notices'] = collect($notices)->where('access', 1)->toArray();
        /* Leave info */
        $data['all_employee_data'] = array();
        $all_employee_data = Employee::valid()->project()->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')->select('employees.*','designations.designation_name', 'company_sbus.sbu_name')->whereIn('employee_sbu', $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->get();

        foreach ($all_employee_data as $value) {
            array_push($data['all_employee_data'], [
                'id' => $value['id'], 
                'text'=>$value['employee_id_no']." - ". $value['employee_fullname']." - ". $value['designation_name']." - ". $value['sbu_name'],
            ]);
        }

        $data['leave_type_data'] = array();
        $leave_type_data = LeaveType::valid()->project()->get();
        foreach ($leave_type_data as $value) {
            array_push($data['leave_type_data'], ['id' => $value['id'], 'text' => $value['leave_type_name'], 'short_text' => $value['leave_short_type']]);
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
            ->leftJoin('employees as employees2', 'employees2.employee_id_no', '=', 'employees.employee_reporting_to')
            ->leftJoin('users_person', 'users_person.employee_id', '=', 'employees.id')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->whereIn('employees.employee_status', [1,2])
            ->where('employees.employee_sbu', Auth::guard('user')->user()->company_sbu)
            ->where('employees.employee_department', Auth::guard('user')->user()->department)

            // $employee_ids['department']
            ->orderBy('employees.id', 'desc');
        $all_employee_data = $employee_data_directory;
        // ->take(20)
        // ->get()

        $data['employee_data_directory'] = $all_employee_data->paginate(7);
        $data['allEmployeeData'] = $all_employee_data->get();
        // print_r($data['allEmployeeData']);


        $approve_late_request = LateRequest::valid()->project()
            ->where('employee_id', '=', $employee['id'])
            ->where('late_approve_status', '=', 2)
            ->get();
        $data['approve_late_request'] = $approve_late_request;

        $attendance_issues = AttendanceIssue::valid()->project()
            ->where('attendance_issue_status', '=', 1)
            ->get();
        $data['attendance_issues'] = $attendance_issues;

        $folderPermisss = DB::table('doc_folder_permissions')->where('permission_set', 1)->where('valid', 1)->get();
        $folderAllPermiss = [];

        foreach ($folderPermisss as $key => $folderPermiss) {
            if ($folderPermiss->permission_type == 1 && Auth::guard('user')->user()->company_sbu == $folderPermiss->permission_id) {
                $folderAllPermiss[$key] = $folderPermiss->folder_id;
            }
            if ($folderPermiss->permission_type == 2 && Auth::guard('user')->user()->department == $folderPermiss->permission_id) {
                $folderAllPermiss[$key] = $folderPermiss->folder_id;
            }
            if ($folderPermiss->permission_type == 3 && Auth::guard('user')->user()->unit == $folderPermiss->permission_id) {
                $folderAllPermiss[$key] = $folderPermiss->folder_id;
            }
            if ($folderPermiss->permission_type == 4 && Auth::guard('user')->user()->sub_unit == $folderPermiss->permission_id) {
                $folderAllPermiss[$key] = $folderPermiss->folder_id;
            }
            if ($folderPermiss->permission_type == 5 && Auth::guard('user')->user()->section == $folderPermiss->permission_id) {
                $folderAllPermiss[$key] = $folderPermiss->folder_id;
            }
            if ($folderPermiss->permission_type == 6 && Auth::guard('user')->user()->sub_section == $folderPermiss->permission_id) {
                $folderAllPermiss[$key] = $folderPermiss->folder_id;
            }
            if ($folderPermiss->permission_type == 7 && Auth::guard('user')->user()->employee_id == $folderPermiss->permission_id) {
                $folderAllPermiss[$key] = $folderPermiss->folder_id;
            }
        }

        $last = collect($folderPermisss)->pluck('folder_id')->toArray();
        $folderId = collect(DB::table('document_folders')->whereNotIn('id', $last)->get())->pluck('id')->toArray();
        $folderAllPermiss = array_merge($folderAllPermiss, $folderId);

        /* Worked on 20/1/2021 Start */
        $all_folder_info = DocumentFolder::valid()->project()
            ->leftJoin('employees', 'employees.id', '=', 'document_folders.created_by')
            ->select(
                'document_folders.*',
                'employees.employee_fullname'
            )
            ->whereIn('document_folders.id', $folderAllPermiss)
            ->where('document_folders.folder_status', 1)
            ->orwhere('document_folders.created_by', Auth::guard('user')->user()->id)
            ->where('document_folders.id', '!=', $last)
            // ->where('document_folders.sbu_id', Auth::guard('user')->user()->company_sbu)
            // ->where('document_folders.department_id', Auth::guard('user')->user()->department)
            ->orderBy('document_folders.id', 'desc');
        $all_folder_info_data = $all_folder_info;
        $data['all_folder_info'] = $all_folder_info_data->paginate();
        /* Worked on 20/1/2021 End */

        //  $employeesInfo=DB::table('employees')->where('id',Auth::guard('user')->user()->employee_id)->first();
        // $sbuThemesInfo=DB::table('company_sbus')->where('id',$employeesInfo->employee_sbu)->first();
        // $data['logos']=$sbuThemesInfo->sbu_logo;
        // $data['Sbu_name']=$sbuThemesInfo->sbu_name;



        /* Employee Salary Info*/
        $monthly_salary_info = PayrollList::valid()->project()
            ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            ->select(
                'payroll.*',
                'employees.employee_fullname',
                'payroll_process.paymonth'
            )
            ->selectRaw(
                'payroll.*,
                payroll_process.paymonth,
                employees.employee_id_no,
                employees.employee_fullname,
                sum(payroll.gross_salary) as gross_salary,
                sum(payroll.basic) as basic,
                sum(payroll.houserent) as houserent,
                sum(payroll.medical) as medical,
                sum(payroll.transport) as transport,
                sum(payroll.netpay) as netpay,
                 sum((payroll.arear+payroll.additional_mobile+payroll.allowance+payroll.car_allowance)) as total_additions,
                sum((payroll.deduction_pfbasic+payroll.deduction_others+payroll.deduction_uniform+payroll.deduction_deposit+payroll.deduction_mobilebill+payroll.deduction_loan+payroll.deduction_tax)) as total_deduction
                '
            )
            ->where('payroll.status', 1)
            ->where('payroll.empid', $employee['id'])
            ->where('payroll_process.settlement', 2)
            ->groupBy('payroll_process.paymonth')
            // ->groupBy('employees.id')
            ->orderBy('payroll.id', 'desc');





        $monthly_salary_info_data = $monthly_salary_info;
        $data['monthly_salary_info'] = $monthly_salary_info_data->paginate();

        /* Employee Provident Fund Info */
        $provident_fund_info = ProvidentFund::valid()->project()
            ->leftJoin('employees', 'employees.id', '=', 'provident_funds.employee_id')
            ->select(
                'provident_funds.*',
                'employees.employee_fullname'
            )
            ->where('provident_funds.employee_id', $employee['id'])
            ->where('provident_funds.pf_status', 1)
            ->orderBy('provident_funds.id', 'desc');
        $provident_fund_info_data = $provident_fund_info;
        $data['provident_fund_info'] = $provident_fund_info = $provident_fund_info_data->get();
        $data['no_of_month'] = count($provident_fund_info);
        $collection = collect($data['provident_fund_info']);
        $data['total_emp_contribution'] = $collection->sum('pf_employee_amount');
        $data['total_comp_contribution'] = collect($data['provident_fund_info'])->sum('pf_company_amount');

        $employee_loan_info = LoanAdvance::valid()->project()
            ->leftJoin('employees', 'employees.id', '=', 'employee_loans.employee_id')
            ->leftJoin('loan_adv_transactions', 'loan_adv_transactions.loan_adv_id', '=', 'employee_loans.id')
            ->selectRaw(
                'employee_loans.*,
                employees.employee_fullname,
                sum(loan_adv_amount) as paid_amount
                '
            )
            ->where('employee_loans.employee_id', $employee['id'])
            ->where('employee_loans.loan_status', 1)
            ->groupBy('loan_adv_id')
            ->orderBy('employee_loans.id', 'desc');
        $employee_loan_info_data = $employee_loan_info;
        $data['employee_loan_info'] = $emp_loan_info = $employee_loan_info_data->get();
        $data['total_loan_amount'] = collect($data['employee_loan_info'])->sum('loan_amount');
        $data['current_loan_amount'] = collect($data['employee_loan_info'])->where('loan_clearance_status', 2)->sum('loan_amount');
        $data['emp_loan_info_remaining'] = $emp_loan_info_remaining = collect($emp_loan_info)->where('loan_clearance_status', 2)->sortByDesc('disburse_date')->first();

        $data['paid_loan_amount'] = LoanTransaction::valid()->project()
            ->leftJoin('employee_loans', 'employee_loans.id', '=', 'loan_adv_transactions.loan_adv_id')
            ->selectRaw(
                'employee_loans.loan_clearance_status as loan_clearance_status,
                loan_adv_transactions.loan_adv_id as loan_adv_id,
                loan_adv_amount as paid_amount'
            )
            ->where('loan_adv_transactions.loan_trns_status', 1)
            ->where('employee_loans.employee_id', $employee['id'])
            ->where('employee_loans.loan_status', 1)
            ->get();
        $data['paid_loan_amountttt'] = collect($data['paid_loan_amount'])->where('loan_clearance_status', 2)->toArray();
        $data['total_paid_loan_amount'] = collect($data['paid_loan_amount'])->sum('paid_amount');
        $data['paid_no_of_loan'] = count(collect($data['paid_loan_amount'])->where('loan_clearance_status', 2));


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
            ->where('employee_id', $employee['id'])
            ->groupBy('entry_date')
            ->groupBy('salary_goes_to')
            ->orderBy('salary_goes_to', 'asc')
            ->get();

        $data['bank_salary'] = collect($emp_salary)->where('salary_goes_to', 2)->first();
        $data['cash_salary'] = collect($emp_salary)->where('salary_goes_to', 1)->first();
        $data['gross_salary'] = collect($emp_salary)->sum('gross_salary');
        $data['emp_salary'] = $emp_salary;
        
        // $timeStart = microtime($emp_salary);
        // dd($timeStart);
        return view('layouts.app', $data);
    }

    public function get_holiday_list_info($id = NULL){
        $holiday_setups_list_data = DB::table('holiday_setups')
            ->leftJoin('holiday_permissions','holiday_permissions.holiday_id','=','holiday_setups.id')
            ->leftJoin('employees','employees.employee_work_location','=','holiday_permissions.work_location_permission')
            ->where('holiday_status', 1)
            ->where('sbu_permission', Auth::guard('user')->user()->company_sbu)
            ->where('employees.id', $id)
            ->get();
        $holidayList = [];    
        foreach ($holiday_setups_list_data as $key => $value) {
            $holidayList[] = [
                'Type' => $value->holiday_event,
                'type_id' => 1,
                's_date' => $value->holiday_start_date,
                'e_date' => $value->holiday_end_date,
                'purpose' => $value->holiday_note,
                'id' => $value->id,
            ];
        }    
        $data['holidayList'] = $holidayList;
        return response($data);    
    }

    public function pay_slip_info($id = false, $employee_id = false)
    {
        $payslipDetails = PayrollList::valid()
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            ->selectRaw(
                'payroll.*,
                    payroll_process.paymonth,
                    payroll_process.startdate,
                    payroll_process.type,
                    payroll_process.process_date,
                    payroll_process.enddate,
                    (payroll.arear+payroll.additional_mobile+payroll.allowance) as total_additions,
                    (payroll.deduction_others+payroll.deduction_uniform+payroll.deduction_deposit+payroll.deduction_mobilebill+payroll.deduction_loan) as total_deduction
                    '
            )
            ->where('payroll.id', $id)->first();

        if ($payslipDetails['type'] == 1) {
            $data['salary_type_cash'] = 1;
            $data['paySlipCash'] = $payslipDetails;
            $paySlipDetails = PayrollList::valid()
                ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
                ->selectRaw(
                    'payroll.*,
                    payroll_process.paymonth,
                    payroll_process.type,
                    payroll_process.process_date,
                    payroll_process.enddate,
                    (payroll.arear+payroll.additional_mobile+payroll.allowance) as total_additions,
                    (payroll.deduction_others+payroll.deduction_uniform+payroll.deduction_deposit+payroll.deduction_mobilebill+payroll.deduction_loan) as total_deduction
                    '
                )
                ->where('paymonth', $payslipDetails['paymonth'])
                ->where('empid', $payslipDetails['empid'])
                ->where('type', 2)
                ->where('payroll.companysbu_id', $payslipDetails['companysbu_id'])
                ->first();
            if (!empty($paySlipDetails)) {
                $data['paySlipDetails'] = $paySlipDetails;
                $data['salary_type_bank'] = 2;
            } else {
                $data['paySlipDetails'] = [];
                $data['salary_type_bank'] = 1;
            }
        } else {
            $data['salary_type_bank'] = 2;
            $data['paySlipDetails'] = $payslipDetails;
            $paySlipCash = PayrollList::valid()
                ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
                ->selectRaw(
                    'payroll.*,
                    payroll_process.paymonth,
                    payroll_process.type,
                    payroll_process.process_date,
                    payroll_process.enddate,
                    (payroll.arear+payroll.additional_mobile+payroll.allowance) as total_additions,
                    (payroll.deduction_others+payroll.deduction_uniform+payroll.deduction_deposit+payroll.deduction_mobilebill+payroll.deduction_loan) as total_deduction
                    '
                )
                ->where('paymonth', $payslipDetails['paymonth'])
                ->where('empid', $payslipDetails['empid'])
                ->where('type', 1)
                ->where('payroll.companysbu_id', $payslipDetails['companysbu_id'])
                ->first();
            if (!empty($paySlipCash)) {
                $data['paySlipCash'] = $paySlipCash;
                $data['salary_type_cash'] = 1;
            } else {
                $data['paySlipCash'] = [];
                $data['salary_type_cash'] = 2;
            }
        }

        // if($payslipDetails['type']==2){
        // $data['paySlipDetails']=$payslipDetails;
        // $data['salary_type']=2;
        // }else{
        // $data['salary_type']=1;
        // $data['paySlipCash']=PayrollList::valid()
        //           ->leftJoin('payroll_process','payroll_process.id','=','payroll.procsid')
        //           ->selectRaw(
        //             'payroll.*,
        //             payroll_process.paymonth,
        //             payroll_process.type,
        //             payroll_process.process_date,
        //             (payroll.arear+payroll.additional_mobile+payroll.allowance) as total_additions,
        //             (payroll.deduction_others+payroll.deduction_uniform+payroll.deduction_deposit+payroll.deduction_mobilebill+payroll.deduction_loan) as total_deduction'
        //           )
        //           ->where('paymonth',$payslipDetails['paymonth'])
        //           ->where('empid',$payslipDetails['empid'])
        //           ->where('type',1)
        //           ->where('payroll.companysbu_id',$payslipDetails['companysbu_id'])
        //           ->first();

        // }
        // if($payslipDetails['type']==2){
        // $data['paySlipCash']=$payslipDetails;
        // $data['salary_type']=2;

        // }else{
        // $data['salary_type']=1;
        // $data['paySlipDetailsBank']=PayrollList::valid()
        //           ->leftJoin('payroll_process','payroll_process.id','=','payroll.procsid')
        //           ->selectRaw(
        //             'payroll.*,
        //             payroll_process.paymonth,
        //             payroll_process.type,
        //             payroll_process.process_date,
        //             (payroll.arear+payroll.additional_mobile+payroll.allowance) as total_additions,
        //             (payroll.deduction_others+payroll.deduction_uniform+payroll.deduction_deposit+payroll.deduction_mobilebill+payroll.deduction_loan) as total_deduction
        //             '
        //           )
        //           ->where('paymonth',$payslipDetails['paymonth'])
        //           ->where('empid',$payslipDetails['empid'])
        //           ->where('type',2)
        //           ->where('payroll.companysbu_id',$payslipDetails['companysbu_id'])
        //           ->first();
        // }

        // $paySlip=PayrollProcessList::valid()->
        $allPf = ProvidentFund::valid()->where('employee_id', $payslipDetails['empid'])
            ->where('company_sbu_id', $payslipDetails['companysbu_id'])
            ->whereDate('pf_date', '<=', $payslipDetails['enddate'])
            ->get();
        $data['openigPf'] = collect($allPf)->where('pf_date', '<', $payslipDetails['enddate'])
            ->sum('pf_employee_amount');
        $data['Pf'] = collect($allPf)->where('pf_date', '=', $payslipDetails['enddate'])
            ->sum('pf_employee_amount');
        $data['clPf'] = collect($allPf)->sum('pf_employee_amount');

        $pay_slip_details = Employee::valid()->project()
            // ->leftJoin('employees',  'employees.id', '=', 'payroll.empid')
            ->leftJoin('company_sbus',  'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->selectRaw(
                'employees.*,
          employees.employee_id_no,
          employees.employee_fullname,
          designations.designation_name,
          departments.department_name,
          company_sbus.sbu_name,
          company_sbus.sbu_logo,
          work_locations.work_location_name
          '
            )->where('employees.id', $payslipDetails['empid'])->first();

        $data['pay_slip_details'] = $pay_slip_details;
        $data['sbu_name'] = $pay_slip_details['sbu_name'];
        $data['sbu_logo'] = $pay_slip_details['sbu_logo'];
        $data['print_date'] = date('l d F Y');
        $data['salary_date'] = date('F Y', strtotime($payslipDetails['startdate']));
        return response($data);
    }

    public function loan_schedule_info($id = false, $employee_id = false)
    {
        $paid_loan_amount = LoanTransaction::valid()->project()
            ->leftJoin('employee_loans', 'employee_loans.id', '=', 'loan_adv_transactions.loan_adv_id')
            ->selectRaw(
                'sum(loan_adv_amount) as paid_amount'
            )
            ->where('loan_adv_transactions.loan_trns_status', 1)
            ->where('loan_adv_transactions.loan_adv_id', $id)
            ->where('employee_loans.employee_id', $employee_id)
            ->where('employee_loans.loan_status', 1)
            ->where('employee_loans.loan_clearance_status', 2)
            ->groupBy('employee_loans.employee_id')->first();

        $employee_loan = LoanAdvance::valid()->project()->where('employee_id', $employee_id)->where('id', $id)->first();
        if (!empty($employee_loan)) {
            $loan_amount = $employee_loan->loan_amount;
            $no_of_installment = $employee_loan->no_of_installment;
            $installment_amount = $loan_amount / $no_of_installment;
            $first_installment_date = $employee_loan->first_installment_date;
            $last_installment_date = $employee_loan->last_installment_date;
            $loan_deduct_policy = $employee_loan->loan_deduct_policy;
            if ($loan_deduct_policy == 1) {
                $loan_deduct_policy_text = 'Auto';
            } else {
                $loan_deduct_policy_text = 'Manual';
            }
            $loan_schedule[] = '';
            for ($i = 0; $i < $no_of_installment; $i++) {
                $loan_schedule[$i] = array(
                    'serial_no' => $i + 1,
                    'installment_date' => date('d M Y', strtotime("+" . $i . " months", strtotime($first_installment_date))),
                    'loan_amount' => $loan_amount,
                    'installment_amount' => $installment_amount,
                    'loan_deduct_policy' => $loan_deduct_policy_text,
                    'installment_status' => '-'
                );
            }
            $data['loan_schedule'] = $loan_schedule;
            $data['loan_amount'] = number_format($loan_amount, 2, '.', ',');
            $data['loan_amount_int'] = $loan_amount;
        } else {
            $data['loan_schedule'] = [];
        }
        if (!empty($paid_loan_amount)) {
            $data['paid_loan_amounttt'] = number_format($paid_loan_amount->paid_amount, 2, '.', ',');
            $data['paid_loan_amount'] = $paid_loan_amount->paid_amount;
        } else {
            $data['paid_loan_amounttt'] = '';
            $data['paid_loan_amount'] = '';
        }
        return response($data);
    }

    function attendances_finds($start, $end, $employee_data, $joining_date, $attendance_data, $attendanceTime)
    {
        $start_date = $end;
        $end_date = $start;
        $start = new DateTime($start);
        $end = new DateTime($end);
        $diff = $end->diff($start);

        $interval = DateInterval::createFromDateString('-1 day');

        $period_main = new DatePeriod($start, $interval, $diff->days);


        $attendance_data = collect($attendance_data)->where('TransactionDate', '>=', $start_date)->where('TransactionDate', '<=', $end_date)->toArray();
        // $attendance_data;
        // $attendance_data=DB::table('attendance_log')
        //                 ->where('attendance_log.employee_id',Auth::guard('user')->user()->employee_card_no)
        //                 ->whereBetween('TransactionDate', [$start_date, $end_date])
        //                 ->where('valid', '=', 1)
        //                 ->get()->toArray();
        $manulAttendance = DB::table('manual_attendances')
            ->where('employee_id_no', Auth::guard('user')->user()->employee_card_no)
            ->whereBetween('manual_attendance_date', [$start_date, $end_date])
            ->where('manual_atten_approve_status', 2)
            ->where('manual_attendance_status', 1)
            ->where('valid', '=', 1)
            ->get()->toArray();

        $attendanceTime = collect($attendanceTime)->where('end_date', '>=', $start_date)->where('start_date', '<=', $end_date)->toArray();
        // return  $attendanceTime;
        

        // AttendanceSetup::valid()->project()
        //                     ->select('attendance_setups.*','office_time_setups.office_start_time as office_start_time','office_time_setups.office_end_time as office_end_time','office_time_setups.lateConsiderTime as lateConsiderTime','office_time_setups.office_type as office_type','office_time_setups.type as type')
        //                     ->leftJoin('office_time_setups','office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
        //                     ->where('employee_id', Auth::guard('user')->user()->employee_id) 
        //                     // ->where('office_time_end_date','>=',$start_date)
        //                     // ->where('office_time_start_date','<=',$end_date)
        //                      ->where('end_date','>=',$start_date)
        //                     ->where('start_date','<=',$end_date)
        //                     ->get(); 
        $approve_late_request = LateRequest::valid()->project()
            ->where('employee_id', '=', Auth::guard('user')->user()->employee_id)
            ->whereBetween('late_date', [$start_date, $end_date])
            ->where('late_approve_status', '=', 2)
            ->get();
        $company_sbu_data = CompanySbu::valid()->project()->where('id', Auth::guard('user')->user()->company_sbu)->first();
       
        $weekend = explode(",", $company_sbu_data['weekend']);


        
        $approve_late_find = array();
        if ($approve_late_request) {
            foreach ($approve_late_request as $date) {
                array_push($approve_late_find, $date['late_date']);
            }
        }

          $holidayFind = HolidaySetup::valid()->project()
        ->leftJoin('holiday_permissions', 'holiday_permissions.holiday_id', '=', 'holiday_setups.id')
        ->select('holiday_setups.*', 'holiday_permissions.*')
        // ->where('holiday_start_date', '<=', $end_date)
        // ->where('holiday_end_date', '>=', $start_date)
        ->whereBetween('holiday_start_date', [$start_date, $end_date])
        ->get();
        if(count($holidayFind) == 0){
            $holidayFind = HolidaySetup::valid()->project()
            ->leftJoin('holiday_permissions', 'holiday_permissions.holiday_id', '=', 'holiday_setups.id')
            ->select('holiday_setups.*', 'holiday_permissions.*')
            ->whereBetween('holiday_end_date', [$start_date, $end_date])
            ->get();
        }

        // $holidayFind = HolidaySetup::valid()->project()
        //     ->select('holiday_setups.*')
        //     ->whereBetween('holiday_start_date', [$start_date, $end_date])
        //     ->get();
        //  $holidayFind = HolidaySetup::valid()->project()
        // ->leftJoin('holiday_permissions', 'holiday_permissions.holiday_id', '=', 'holiday_setups.id')
        // ->select('holiday_setups.*', 'holiday_permissions.*')
        // ->where('holiday_start_date', '<=', $start_date)
        // ->where('holiday_end_date', '>=', $end_date)
        // ->get();
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
        // $indLeaveInfo1 = LeaveApplication::valid()->project()
        //     ->leftJoin('leave_types', 'leave_types.id', '=', 'leave_applications.leave_type')
        //     // ->whereBetween('leave_from_date', [$start_date, $end_date])
        //     ->where('leave_from_date', '<=', $start_date)
        //      ->where('leave_to_date', '>=', $end_date)
        //     ->where('leave_applications.leave_apply_status', '=', 2)
        //     ->where('leave_applications.employee_id', '=', Auth::guard('user')->user()->employee_id)
        //     ->get()->toArray(); 

        $indLeaveInfo1 = LeaveApplication::valid()->project()
        ->leftJoin('leave_types', 'leave_types.id', '=', 'leave_applications.leave_type')
        ->whereBetween('leave_from_date', [$start_date, $end_date])
        // ->where('leave_from_date', '<=', $start_date)
        //  ->where('leave_to_date', '>=', $end_date)
        ->where('leave_applications.leave_apply_status', '=', 2)
        ->where('leave_applications.employee_id', '=', Auth::guard('user')->user()->employee_id)
        ->get()->toArray();
        if(count($indLeaveInfo1) == 0){
            $indLeaveInfo1 = LeaveApplication::valid()->project()
            ->leftJoin('leave_types', 'leave_types.id', '=', 'leave_applications.leave_type')
            ->whereBetween('leave_to_date', [$start_date, $end_date])
            // ->where('leave_from_date', '<=', $start_date)
            // ->where('leave_to_date', '>=', $end_date)
            ->where('leave_applications.leave_apply_status', '=', 2)
            ->where('leave_applications.employee_id', '=', Auth::guard('user')->user()->employee_id)
            ->get()->toArray();
        }
        
        $leave_adjustments =LeaveAdjustment::select('employee_id','leave_adjutment_date as leave_from_date','leave_adjutment_date as leave_to_date')
            // ->where('leave_adjutment_date', $from_date_formated)
            ->whereBetween('leave_adjutment_date', [$start_date, $end_date])
            ->where('employee_id', Auth::guard('user')->user()->employee_id)
            ->where('leave_adj_approve_status', '=', 2)
            ->get()->toArray();  
          $indLeaveInfo =array_merge(
          $indLeaveInfo1, $leave_adjustments); 

        $ind_leave_info = array();
        if ($indLeaveInfo) {
            foreach ($indLeaveInfo as $key => $value) {
                $period_live = CarbonPeriod::create($value['leave_from_date'], $value['leave_to_date']);
                foreach ($period_live as $date) {
                    array_push($ind_leave_info, $date->format('Y-m-d'));
                }
            }
        }

        $ramadan_office_time = OfficeTimeSetup::valid()->where('type', 1)->where('office_time_status', 1)->first(); // for Ramadan office time profile attendance view purposes
        // dd($ramadan_office_time->office_start_time);

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
        $late_time = "";
        $attendances = [];

        // if($date->format("Y-m-d") == "2024-03-10"){
            // }
            
            foreach ($period_main as $date) {
                if ($date->format("Y-m-d") == date('Y-m-d', strtotime(' +1 day'))) {
                    continue;
                }
                $dataLength++;
                $pay_days_count++;
                
                
               

            $attendance_time = $attendance_time_ramadan =  $attendance_setups_data = collect($attendanceTime)
                ->where('start_date', '<=', $date->format("Y-m-d"))
                ->where('end_date', '>=', $date->format("Y-m-d"))
                ->first();

                
                if (empty($attendance_time)) {
                    $attendance_time = $company_sbu_data;
                    $attendance_time['office_type'] = 1;
                    $attendance_time['type'] = 1;
                }
                //  Holiday permission task by Faruk Khan start
                // $holiday_permission = [];
                if(!empty($attendance_setups_data)){
                    $holiday_permission = collect($holidayFind)->where('holiday_start_date', '<=', $date->format("Y-m-d"))->where('holiday_end_date', '>=', $date->format("Y-m-d"))->where('sbu_permission', $employee_data['employee_sbu'])
                    ;
                    if(!empty($employee_data['employee_id'])){
                        $holiday_permission = collect($holiday_permission)->where('employee_id', $employee_data['employee_id']);
                    }
                    if(!empty($employee_data['employee_sbu'])){
                        $holiday_permission = collect($holiday_permission)->where('sbu_permission', $employee_data['employee_sbu']);
                    }
                    if(!empty($employee_data['employee_unit'])){
                        $holiday_permission = collect($holiday_permission)->where('unit_permission', $employee_data['employee_unit']);
                    }
                    if(!empty($employee_data['employee_sub_unit'])){
                        $holiday_permission = collect($holiday_permission)->where('sub_unit_permission', $employee_data['employee_sub_unit']);
                    }
                    if(!empty($employee_data['employee_department'])){
                        $holiday_permission = collect($holiday_permission)->where('department_permission', $employee_data['employee_department']);
                    }
                    if(!empty($employee_data['employee_section'])){
                        $holiday_permission = collect($holiday_permission)->where('section_permission', $employee_data['employee_section']);
                    }
                    if(!empty($employee_data['employee_sub_section'])){
                        $holiday_permission = collect($holiday_permission)->where('sub_section_permission', $employee_data['employee_sub_section']);
                    }
                    if(!empty($employee_data['employee_work_location'])){
                        $holiday_permission = collect($holiday_permission)->where('work_location_permission', $employee_data['employee_work_location']);
                    }

                }
                if(!empty($holiday_permission) && count($holiday_permission) == 0){
                    $holiday_find = array();
                }
                //  Holiday permission task by Faruk Khan end
               
                // dd($holiday_permission, $holiday_find);

              
            $intime = collect(collect($attendance_data)->where('TransactionDate', $date->format("Y-m-d"))->sortBy('id')->values()->all())->first();
            $outtime = collect(collect($attendance_data)->where('TransactionDate', $date->format("Y-m-d"))->sortByDesc('id')->values()->all())->first();
            $manulAttendances = collect($manulAttendance)->where('manual_attendance_date', $date->format("Y-m-d"))->first();
            //     echo "<pre>";
            // print_r([$attendance_time]);
            // exit();
            // if($date->format("Y-m-d") == )
            // echo '<pre>'; print_r($date->format("Y-m-d")); die();
            
            // $office_start_time = isset($attendance_time['office_start_time']) ? $attendance_time['office_start_time'] : '00:00:00';
            // $office_end_time = isset($attendance_time['office_end_time']) ? $attendance_time['office_end_time'] : '00:00:00';
            // dd($attendanceTime);
            $lateConsiderTime = '00:00:00';
            $office_start_time = '00:00:00';
            $office_end_time = '00:00:00';
            if(empty($attendance_setups_data) && !empty($ramadan_office_time) && ($date->format("Y-m-d") >= $ramadan_office_time['office_time_start_date']) && ($date->format("Y-m-d") <= $ramadan_office_time['office_time_end_date'])){
                $office_start_time = isset($ramadan_office_time['office_start_time']) ? $ramadan_office_time['office_start_time'] : '00:00:00';
                $office_end_time = isset($ramadan_office_time['office_end_time']) ? $ramadan_office_time['office_end_time'] : '00:00:00';
                $lateConsiderTime = isset($ramadan_office_time['lateConsiderTime']) ? $ramadan_office_time['lateConsiderTime'] : '00:00:00';
                // echo '<pre>';
                // echo $lateConsiderTime;
                // echo 'after ramadan';
            }
            elseif(empty($attendance_setups_data) && !empty($ramadan_office_time) && $date->format("Y-m-d") < $ramadan_office_time['office_time_start_date']){
                $lateConsiderTime =  $attendance_time['lateConsiderTime'] = '';
                $company_sbu_data = CompanySbu::valid()->project()->where('id', Auth::guard('user')->user()->company_sbu)->first();
                $office_start_time = isset($attendance_time['office_start_time']) ? $attendance_time['office_start_time'] : '00:00:00';
                $office_end_time = isset($attendance_time['office_end_time']) ? $attendance_time['office_end_time'] : '00:00:00';
                $lateConsiderTime = $company_sbu_data['lateConsiderTime'] ?? '00:00:00';
                // echo '<pre>';
                // echo $lateConsiderTime;
                // echo '<br>';
                // print_r ($company_sbu_data);
                // echo 'before ramadan';
            }
            else{
                $office_start_time = isset($attendance_time['office_start_time']) ? $attendance_time['office_start_time'] : '00:00:00';
                $office_end_time = isset($attendance_time['office_end_time']) ? $attendance_time['office_end_time'] : '00:00:00';
                $lateConsiderTime = $attendance_time['lateConsiderTime'] ?? '00:00:00';
            }
            // if($date->format("Y-m-d") == '2024-03-01'){
            //     die();
            // }
            // dd($company_sbu_data);

            // elseif(!empty($attendance_setups_data) && !empty($ramadan_office_time) && ($date->format("Y-m-d") >= $ramadan_office_time['office_time_start_date']) && ($date->format("Y-m-d") <= $ramadan_office_time['office_time_end_date'])){

            //     if(!empty($attendance_time) && ($date->format("Y-m-d") >= $attendance_time['start_date']) && ($date->format("Y-m-d") <= $attendance_time['end_date'])){
            //         $office_start_time = isset($attendance_time['office_start_time']) ? $attendance_time['office_start_time'] : '00:00:00';
            //         $office_end_time = isset($attendance_time['office_end_time']) ? $attendance_time['office_end_time'] : '00:00:00';
            //         $lateConsiderTime = $attendance_time['lateConsiderTime'] ?? '00:00:00';
            //     }
            // }
            // else{
            //     $office_start_time = isset($attendance_time['office_start_time']) ? $attendance_time['office_start_time'] : '00:00:00';
            //     $office_end_time = isset($attendance_time['office_end_time']) ? $attendance_time['office_end_time'] : '00:00:00';
            //     $lateConsiderTime = $attendance_time['lateConsiderTime'] ?? '00:00:00';
            // }


            $attendance_time['lateConsiderTime']  = $lateConsiderTime;
            
            
            // elseif(!empty($ramadan_office_time) && $date->format("Y-m-d") < $ramadan_office_time['office_time_start_date']){
                // if(!empty($attendance_time) && ($date->format("Y-m-d") >= $attendance_time['start_date']) && ($date->format("Y-m-d") <= $attendance_time['end_date'])){
                //     $office_start_time = isset($attendance_time['office_start_time']) ? $attendance_time['office_start_time'] : '00:00:00';
                //     $office_end_time = isset($attendance_time['office_end_time']) ? $attendance_time['office_end_time'] : '00:00:00';
                //     $attendance_time['lateConsiderTime'] = "09:15:00";
                // }
                // else{
                //     $office_start_time = isset($attendance_time['office_start_time']) ? $attendance_time['office_start_time'] : '00:00:00';
                //     $office_end_time = isset($attendance_time['office_end_time']) ? $attendance_time['office_end_time'] : '00:00:00';
                //     $attendance_time['lateConsiderTime'] = $attendance_time['lateConsiderTime'] ?? '00:00:00';
                // }
            // }else{
            //     $office_start_time = isset($attendance_time['office_start_time']) ? $attendance_time['office_start_time'] : '00:00:00';
            //     $office_end_time = isset($attendance_time['office_end_time']) ? $attendance_time['office_end_time'] : '00:00:00';
            //     $attendance_time['lateConsiderTime'] = "09:15:00";
            // }
           

            // dd($office_start_time, $office_end_time);

            if ($joining_date <= $date->format("Y-m-d")) {
                if (!empty($attendance_time)) {
                    if (!empty($manulAttendances)) {
                        $intimes = date('H:i', strtotime($manulAttendances->manual_start_time));
                        $outtimes = date('H:i', strtotime($manulAttendances->manual_end_time));

                        if (!empty($attendance_time['lateConsiderTime']) && date('H:i', strtotime($attendance_time['lateConsiderTime'])) !=  date('H:i', strtotime('00:00:00'))) {
                            $lateConsiderTime = date('H:i', strtotime($attendance_time['lateConsiderTime']));
                        } else {
                            $lateConsiderTime = date('H:i', strtotime($office_start_time));
                        }

                        if ($intimes <= $lateConsiderTime) {
                            $late_time = '00:00';
                            $status = "P";
                            $statusId = 1;
                        } else {
                            if (!empty($approve_late_find) && in_array($date->format("Y-m-d"), $approve_late_find)) {
                                $late_time = strtotime($intimes) - strtotime($office_start_time);
                                $late_time = date('H:i', $late_time);
                                $status = "L";
                                $statusId = 1;
                            } else {
                                $late_time = strtotime($intimes) - strtotime($office_start_time);
                                $late_time = date('H:i', $late_time);
                                $status = "L";
                                $statusId = 2;
                            }
                        }

                        $work_time = strtotime($outtimes) - strtotime($intimes);
                        $attendances[] = [
                            "date" => $date->format("j M, Y"),
                            "dates" => $date->format("Y-m-d"),
                            "office_start_time" => date('H:i', strtotime($office_start_time)),
                            "office_end_time" => date('H:i', strtotime($office_end_time)),
                            "shift_time" => date('H:i', strtotime($office_start_time)) . " - " . date('H:i', strtotime($office_end_time)),
                            "intime" => $intimes,
                            "outtime" => $outtimes,
                            "late_time" => $late_time,
                            "work_time" => date('H:i', $work_time),
                            "Status" => $status,
                            "statusId" => $statusId,
                        ];
                    } else if ($attendance_time['type'] == 2) {
                        if (!empty($intime) && !empty($outtime)) {
                            $intimes = date('H:i', strtotime($intime->TransactionTime));
                            $outtimes = date('H:i', strtotime($outtime->TransactionTime));

                            if ($attendance_time['office_type'] == 2) {
                                $status = "W";
                                $statusId = 1;
                            } else {
                                // if(!empty($attendance_time->lateConsiderTime)){
                                //     $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                                // }else{
                                //     $lateConsiderTime=strtotime($office_start_time);
                                // }
                                if (!empty($attendance_time['lateConsiderTime']) && date('H:i', strtotime($attendance_time['lateConsiderTime'])) !=  date('H:i', strtotime('00:00:00'))) {
                                    $lateConsiderTime = date('H:i', strtotime($attendance_time['lateConsiderTime']));
                                } else {
                                    $lateConsiderTime = date('H:i', strtotime($office_start_time));
                                }


                                if ($intimes <= $lateConsiderTime) {
                                    $late_time = '00:00';
                                    $status = "P";
                                    $statusId = 1;
                                } else {
                                    if (!empty($approve_late_find) && in_array($date->format("Y-m-d"), $approve_late_find)) {
                                        $late_time = strtotime($intimes) - strtotime($office_start_time);
                                        $late_time = date('H:i', $late_time);
                                        $status = "L";
                                        $statusId = 1;
                                    } else {
                                        $late_time = strtotime($intimes) - strtotime($office_start_time);
                                        $late_time = date('H:i', $late_time);
                                        $status = "L";
                                        $statusId = 2;
                                    }
                                }
                            }


                            $work_time = strtotime($outtimes) - strtotime($intimes);


                            // if($intime >= date('H:i', strtotime($attendance_time->lateConsiderTime)) && (date('D',strtotime($date->format("Y-m-d"))) == 'Sat' || date('D',strtotime($date->format("Y-m-d"))) == 'Fri')){
                            // }

                            $attendances[] = [
                                "date" => $date->format("j M, Y"),
                                "dates" => $date->format("Y-m-d"),
                                "office_start_time" => date('H:i', strtotime($office_start_time)),
                                "office_end_time" => date('H:i', strtotime($office_end_time)),
                                "shift_time" => date('H:i', strtotime($office_start_time)) . " - " . date('H:i', strtotime($office_end_time)),
                                "intime" => $intimes,
                                "outtime" => $outtimes,
                                "late_time" => $late_time,
                                "work_time" => date('H:i', $work_time),
                                "Status" => $status,
                                "statusId" => $statusId,
                            ];

                            // exit();
                        } else {
                            if ($attendance_time['office_type'] == 2) {
                                $status = "W";
                                $statusId = 4;
                            } elseif (!empty($holiday_find) && in_array($date->format("Y-m-d"), $holiday_find)) {
                                $status = "H";
                                $statusId = 4;
                            } elseif (!empty($ind_leave_info) && in_array($date->format("Y-m-d"), $ind_leave_info)) {
                                $laveType = collect($indLeaveInfo)->where('leave_from_date', '<=', $date->format("Y-m-d"))->where('leave_to_date', '>=', $date->format("Y-m-d"))->first();
                                // $status = $laveType['leave_short_type'];
                                if (!empty($laveType['leave_short_type']) && ($laveType['leave_short_type'] == 'LWP')) {
                                    $status = $laveType['leave_short_type'];
                                    $statusId = 5;
                                } else {
                                    if (!empty($laveType['leave_short_type'])) {
                                        $status = $laveType['leave_short_type'];
                                    } else {
                                        $status ='RL';
                                    }
                                    $statusId = 3;
                                }
                            } else {
                                $status = "A";
                                $statusId = 5;
                            }

                            $attendances[] = [
                                "date" => $date->format("j M, Y"),
                                "dates" => $date->format("Y-m-d"),
                                "office_start_time" => date('H:i', strtotime($office_start_time)),
                                "office_end_time" => date('H:i', strtotime($office_end_time)),
                                "shift_time" => date('H:i', strtotime($office_start_time)) . " - " . date('H:i', strtotime($office_end_time)),
                                "intime" => '00:00',
                                "outtime" => '00:00',
                                "late_time" => '00:00',
                                "work_time" => '00:00',
                                "Status" => $status,
                                "statusId" => $statusId,
                            ];
                        }
                    } else {
                        if (!empty($intime) && !empty($outtime)) {
                            $intimes = date('H:i', strtotime($intime->TransactionTime));
                            $outtimes = date('H:i', strtotime($outtime->TransactionTime));

                            if (in_array(date('D', strtotime($date->format("Y-m-d"))), $weekend)) {
                                $status = "W";
                                $statusId = 1;
                            } else {
                                // if(!empty($attendance_time->lateConsiderTime)){
                                //     $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                                // }else{
                                //     $lateConsiderTime=strtotime($office_start_time);
                                // }
                                if (!empty($attendance_time['lateConsiderTime']) && date('H:i', strtotime($attendance_time['lateConsiderTime'])) !=  date('H:i', strtotime('00:00:00'))) {
                                    $lateConsiderTime = date('H:i', strtotime($attendance_time['lateConsiderTime']));
                                } else {
                                    $lateConsiderTime = date('H:i', strtotime($office_start_time));
                                }

                                if ($intimes <= $lateConsiderTime) {
                                    $late_time = '00:00';
                                    $status = "P";
                                    $statusId = 1;
                                } else {
                                    if (!empty($approve_late_find) && in_array($date->format("Y-m-d"), $approve_late_find)) {
                                        $late_time = strtotime($intimes) - strtotime($office_start_time);
                                        $late_time = date('H:i', $late_time);
                                        $status = "L";
                                        $statusId = 1;
                                    } else {
                                        $late_time = strtotime($intimes) - strtotime($office_start_time);
                                        $late_time = date('H:i', $late_time);
                                        $status = "L";
                                        $statusId = 2;
                                    }
                                }
                            }


                            $work_time = strtotime($outtimes) - strtotime($intimes);


                            // if($intime >= date('H:i', strtotime($attendance_time->lateConsiderTime)) && (date('D',strtotime($date->format("Y-m-d"))) == 'Sat' || date('D',strtotime($date->format("Y-m-d"))) == 'Fri')){
                            // }

                            $attendances[] = [
                                "date" => $date->format("j M, Y"),
                                "dates" => $date->format("Y-m-d"),
                                "office_start_time" => date('H:i', strtotime($office_start_time)),
                                "office_end_time" => date('H:i', strtotime($office_end_time)),
                                "shift_time" => date('H:i', strtotime($office_start_time)) . " - " . date('H:i', strtotime($office_end_time)),
                                "intime" => $intimes,
                                "outtime" => $outtimes,
                                "late_time" => $late_time,
                                "work_time" => date('H:i', $work_time),
                                "Status" => $status,
                                "statusId" => $statusId,
                            ];

                            // exit();
                        } else {
                            if ((in_array(date('D', strtotime($date->format("Y-m-d"))), $weekend))) {
                                $status = "W";
                                $statusId = 4;
                            } elseif (!empty($holiday_find) && in_array($date->format("Y-m-d"), $holiday_find)) {
                                $status = "H";
                                $statusId = 4;
                            } elseif (!empty($ind_leave_info) && in_array($date->format("Y-m-d"), $ind_leave_info)) {
                                $laveType = collect($indLeaveInfo)->where('leave_from_date', '<=', $date->format("Y-m-d"))->where('leave_to_date', '>=', $date->format("Y-m-d"))->first();
                                if (!empty($laveType['leave_short_type']) && ($laveType['leave_short_type'] == 'LWP')) {
                                    $status = $laveType['leave_short_type'];
                                    $statusId = 5;
                                } else {
                                    if (!empty($laveType['leave_short_type'])) {
                                        $status = $laveType['leave_short_type'];
                                    } else {
                                        $status ='RL';
                                    }
                                    $statusId = 3;
                                }
                            } else {
                                $status = "A";
                                $statusId = 5;
                            }

                            $attendances[] = [
                                "date" => $date->format("j M, Y"),
                                "dates" => $date->format("Y-m-d"),
                                "office_start_time" => date('H:i', strtotime($office_start_time)),
                                "office_end_time" => date('H:i', strtotime($office_end_time)),
                                "shift_time" => date('H:i', strtotime($office_start_time)) . " - " . date('H:i', strtotime($office_end_time)),
                                "intime" => '00:00',
                                "outtime" => '00:00',
                                "late_time" => '00:00',
                                "work_time" => '00:00',
                                "Status" => $status,
                                "statusId" => $statusId,
                            ];
                        }
                    }
                }
            }
            // $attendance_time['lateConsiderTime'] = "00:00:00";
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

        if (!empty(Auth::guard('user')->user()->id)) {
            $id = Auth::guard('user')->user()->id;
        } else {
            return redirect('/');
        }
        
        if ($request->ajax()) {

            $sort_by = 'employees.' . $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            if (!empty($request->get('query'))) {

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
                    ->leftJoin('employees as employees2', 'employees2.employee_id_no', '=', 'employees.employee_reporting_to')
                    ->leftJoin('users_person', 'users_person.employee_id', '=', 'employees.id')
                    ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
                    ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
                    ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
                    ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
                    ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
                    ->whereIn('employees.employee_status', [1,2])
                    ->where('employees.employee_id_no', 'like', '%' . $query . '%')
                    ->orWhere('employees.employee_fullname', 'like', '%' . $query . '%')
                    // ->orWhere('post_description', 'like', '%'.$query.'%')
                    ->orderBy($sort_by, $sort_type)
                    ->paginate(7);
            } else {

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
                    ->leftJoin('employees as employees2', 'employees2.employee_id_no', '=', 'employees.employee_reporting_to')
                    ->leftJoin('users_person', 'users_person.employee_id', '=', 'employees.id')
                    ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
                    ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
                    ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
                    ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
                    ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
                    ->whereIn('employees.employee_status', [1,2])
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

            if ($request->get('viewType') == 1) {
                return view('layouts.pagination_data', compact('employee_data_directory'))->render();
            } elseif ($request->get('viewType') == 2) {
                // echo "<pre>";
                // print_r($employee_data_directory);
                // exit();
                return view('layouts.pagination_data_grid', compact('employee_data_directory'))->render();
            }
        }
    }
    // pagination_data_grid

    function pagination_data_grid($employee_data_directory)
    {

        // echo "<pre>";
        // print_r('sss');
        // exit();
        return view('layouts.pagination_data_grid', compact('employee_data_directory'))->render();
    }

    function countDays($year, $month, $ignore)
    {
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

    public function get_last_service_info($id)
    {
        $service_data = ServiceRequest::valid()->project()
            ->where('service_requests.service_type', $id)->where('employee_id', Auth::guard('user')->user()->employee_id)
            // ->where('service_requests.approve_status', 2)
            ->first();
        return response($service_data);
    }


    public function dashboard(Request $request)
    {
        //  echo "<pre>";
        // print_r();
        // exit();
        //   echo "<pre>";
        // print_r("sss");
        // exit();
        if (!empty(Auth::guard('user')->user())) {
            $id = Auth::guard('user')->user()->id;
        } else {
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
            ->leftJoin('employees as employees2', 'employees2.id', '=', 'employees.employee_reporting_to')
            ->leftJoin('users_person', 'users_person.employee_id', '=', 'employees.id')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->where('users_person.id', $id)
            ->whereIn('employees.employee_status', [1,2])
            ->first();
        $data['user'] = UsersPersonModel::where('id', $id)->first();

        return view('layouts.dashboard', $data);
    }
    public function getUserMenuList()
    {
        // return response()->json("sssss");
        /* $where = ['panel_type' => 2];
        $menuList = MenuTable::where($where)->where('status',1)->orderBy('order_no', 'asc')->get();
        $data['menu_list'] = self::buildMenu($menuList->all());
        return response()->json($data);*/

        $id = Auth::guard('user')->user()->role_id;
        $employeesInfo = DB::table('employees')->where('id', Auth::guard('user')->user()->employee_id)->first();
        $sbuThemesInfo = DB::table('company_sbus')->where('id', $employeesInfo->employee_sbu)->first();
        $data['logos'] = $sbuThemesInfo->sbu_logo;
        $data['Sbu_name'] = $sbuThemesInfo->sbu_name;
        // return response()->json($id);
        $menu_ids = UserRoleAccess::where('role_id', $id)->pluck('menu_id')->all();
        $menuList = MenuTable::whereIn('id', $menu_ids)->where('status', 1)->where('panel_type', 2)->get();
        $data['menuTopbar'] = MenuTable::whereIn('id', $menu_ids)->where('status', 1)->where('is_top_bar', '=', '1')->get();
        $data['menu_list'] = self::buildMenu($menuList->all());
        return response()->json($data);
    }


    public static function buildMenu(array $elements, $parentId = 0)
    {
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

    public function autoLogOutAction(Request $request)
    {
        $data['status'] = 'logout';
        $from  = Session::get('from');
        if ($from == 'admin') {
            $data['url'] = url('admin/login');
        } else {
            $data['url'] = url('/');
        }

        return response($data);
    }

    public function dashboardSummary()
    {
        $company_sbu_data = CompanySbu::valid()->project()->where('sbu_status', '=', 1)->get();
        $data['company_count'] = $company_sbu_data->count();
        $department_data = Department::valid()->project()->where('department_status', '=', 1)->get();
        $data['department_count'] = $department_data->count();
        $designation_data = Designation::valid()->project()->where('designation_status', '=', 1)->get();
        $data['designation_count'] = $designation_data->count();
        $employee_data = Employee::valid()->project()->where('employee_status', '=', 1)->get();
        $data['employee_count'] = $employee_data->count();
        return response($data);
    }



    public function changePassword(Request $request)
    {

        // echo "<pre>"; print_r($request); die();

        if (!empty($request)) {
            $request_data = $request->All();
            $validator = $this->admin_credential_rules($request_data);
            // dd($validator);
            if ($validator->fails()) {
                // return response()->json(array('error' => $validator->getMessageBag()->toArray()), 400);
                return redirect()->back()->with("error", 'The new password and confirmation password not match.');
            } else {
                $current_password = Auth::guard('user')->user()->password;
                if (Hash::check($request_data['current-password'], $current_password)) {
                    $user_id = Auth::guard('user')->user()->id;
                    $obj_user = UsersPersonModel::find($user_id);
                    $obj_user->password = Hash::make($request_data['password']);
                    $obj_user->password_change = 1;
                    $obj_user->save();
                    session()->put('password_change', 1);
                    // return "ok";
                    return redirect()->back()->with("success", "Password changed successfully !");
                } else {
                    $error = array('current-password' => 'Please enter correct current password');
                    // return response()->json(array('error' => $error), 400);   
                    return redirect()->back()->with("error", "Please enter correct current password.");
                }
            }
        } else {
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

    public function get_responsible_info($id)
    {
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













    public function generalInfoSubmit(Request $request)
    {
        // echo "<pre>"; print_r($request); die();
        $user_id = Auth::guard('user')->user()->id;
        $employee_id = Auth::guard('user')->user()->employee_id;
        $user_data = DB::table('general_info_temp')->where('created_by', '=', $user_id)->first();

        $data['personal_email_id'] = $request->personal_email_id;
        $data['personal_mobile_no'] = $request->personal_mobile_no;
        $data['desk_phone'] = $request->desk_phone;
        $data['whatsapp'] = $request->whatsapp;
        $data['skype_no'] = $request->skype_no;
        $data['created_by'] = Auth::guard('user')->user()->id;
        if (empty($user_data)) {
            // return response($user_data);
            DB::table('general_info_temp')->insert($data);
            DB::table('employees')->where('id', '=', $employee_id)->update(array(
                'update_request' => 1,
            ));
        } else {
            DB::table('general_info_temp')->where('created_by', '=', $user_id)->update($data);
            DB::table('employees')->where('id', '=', $employee_id)->update(array(
                'update_request' => 1,
            ));
        }
    }

    public function get_service_list_info($id)
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
            } elseif ($value['service_type'] == 4){
                $serves_type = 'Manual Attendance';
            } elseif ($value['service_type'] == 5){
                $serves_type = 'Employment Certificate';
            } elseif ($value['service_type'] == 6){
                $serves_type = 'Experience Certificate';
            } else{
                $serves_type = '';
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

    public function findServiceRequestData($id)
    {
        $employee_id = Auth::guard('user')->user()->employee_id;
        $service_list_data = ServiceRequest::valid()->project()
            ->where('service_requests.id', $id)
            ->where('service_requests.employee_id', $employee_id)
            ->first();
        $data['service_list_data'] = $service_list_data;
        return response($service_list_data);
    }
    public function findLateRequestData($id)
    {
        $employee_id = Auth::guard('user')->user()->employee_id;
        $late_list_data = LateRequest::valid()->project()
            ->where('late_approve_requests.id', $id)
            ->where('late_approve_requests.employee_id', $employee_id)
            ->first();
        $data['late_list_data'] = $late_list_data;
        return response($late_list_data);
    }

    public function findLeaveRequestData($id)
    {
        $employee_id = Auth::guard('user')->user()->employee_id;
        $leave_list_data = LeaveApplication::valid()->project()
            ->leftJoin('leave_types', 'leave_types.id', '=', 'leave_applications.leave_type')
            ->leftJoin('employees as emp', 'emp.id', '=', 'leave_applications.leave_reliever')
            ->select('leave_applications.*', 'leave_applications.id as id', 'leave_types.leave_type_name', 'emp.employee_fullname as reliever_name', 'emp.id as reliever_id')
            ->where('leave_applications.id', $id)
            ->where('leave_applications.employee_id', $employee_id)
            ->first();
        $data['leave_list_data'] = $leave_list_data;
        return response($leave_list_data);
    }

    public function findManualAttendanceData($id)
    {
        $employee_id = Auth::guard('user')->user()->employee_id;
        $manual_attendance_data = ManualAttendance::valid()->project()
            ->where('id', $id)
            ->where('employee_id', $employee_id)
            ->first();
        $data['manual_attendance_data'] = $manual_attendance_data;
        return response($manual_attendance_data);
    }

    public function findFileList($id)
    {
        // return response($id);
        $employee_id = Auth::guard('user')->user()->employee_id;
        $file_list_data = DocumentFile::valid()->project()
            ->leftJoin('document_folders', 'document_folders.id', '=', 'document_files.folder_id')
            ->leftJoin('file_types', 'file_types.id', '=', 'document_files.file_type')
            ->select('document_files.*', 'document_folders.folder_name', 'file_types.type_name')
            ->where('document_files.folder_id', $id)
            ->get();
        $data['file_list_data'] = $file_list_data;
        return response($data);
    }


    public function zoom_meeting(Request $request)
    {
        $data['id'] = 0;
        return view('zoom.zoom_index', $data);
    }

    public function zoom_meeting_connect($id)
    {
        $data['id'] = 0;
        return view('zoom.meeting', $data);
    }

    public function announcement_view($id = False)
    {
        $data['notice_id'] = isset($id) ? $id : NULL;
        $data['viewer_employee_id'] = Auth::guard('user')->user()->id;
        $data['view_like_status'] = 1;
        $data['view_date'] = date('Y-m-d H:i:s');
        $data['project_id'] = 8;
        $data['branch_id'] = 8;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = Auth::guard('user')->user()->id;
        $notice_log_data = DB::table('notification_logs')->where('notice_id', '=', $id)->where('viewer_employee_id', '=', $data['viewer_employee_id'])->where('valid', 1)->first();
        if (empty($notice_log_data)) {
            DB::table('notification_logs')->insert($data);
            $data['view_message'] = 'Notice Viewed!';
            return $data;
        } else {
            $data['view_message'] = 'Already Viewed!';
            return $data;
            // DB::table('general_info_temp')->where('created_by', '=', $user_id)->update($data);
        }
    }

    public function birthday_view($employee_id = False, $wish_id = False)
    {
        $data['employee_id'] = isset($employee_id) ? $employee_id : NULL;
        $data['wisher_employee_id'] = Auth::guard('user')->user()->id;
        $data['view_like_status'] = 1;
        $data['like_wish_type'] = isset($wish_id) ? $wish_id : NULL;
        $data['like_wish_date'] = date('Y-m-d H:i:s');
        $data['project_id'] = 8;
        $data['branch_id'] = 8;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = Auth::guard('user')->user()->id;
        $birthday_log_data = DB::table('birthday_wish_logs')->where('like_wish_type', '=', $wish_id)->where('wisher_employee_id', '=', $data['wisher_employee_id'])->where('valid', 1)->where('employee_id', '=', $data['employee_id'])->first();
        if (empty($birthday_log_data)) {
            DB::table('birthday_wish_logs')->insert($data);
            if ($wish_id == 1) {
                $data['view_message'] = 'Liked!';
            } else {
                $data['view_message'] = 'Wished!';
            }
            return $data;
        } else {
            if ($wish_id == 1) {
                $data['view_message'] = 'Already Liked!';
            } else {
                $data['view_message'] = 'Already Wished!';
            }
            return $data;
        }
    }

    public function find_notice_viewer_info($id = False)
    {
        $notice_viewers = DB::table('notification_logs')
            ->leftJoin('employees', 'employees.id', '=', 'notification_logs.viewer_employee_id')
            ->select('notification_logs.id as notice_log_id', 'employees.id as employee_id_primary', 'employees.employee_fullname', 'employees.employee_id_no')
            ->where('view_like_status', '=', 1)
            ->where('notice_id', '=', $id)
            ->where('notification_logs.valid', '=', 1)
            ->get();
        return $notice_viewers;
    }

    public function find_notice_vewing_info($notice_id = False, $employee_id = False)
    {
        $notice_viewers = DB::table('notification_logs')
            ->where('notice_id', '=', $notice_id)
            ->where('viewer_employee_id', '=', $employee_id)
            ->where('view_like_status', '=', 1)
            ->where('valid', '=', 1)
            ->get();
        return $notice_viewers;
    }

    public function find_birthday_likers($id = False)
    {
        $birthday_likers_wishers = DB::table('birthday_wish_logs')
            ->leftJoin('employees', 'employees.id', '=', 'birthday_wish_logs.wisher_employee_id')
            ->select('birthday_wish_logs.like_wish_type', 'birthday_wish_logs.id as birthday_log_id', 'employees.id as employee_id_primary', 'employees.employee_fullname', 'employees.employee_id_no')
            ->where('birthday_wish_logs.employee_id', '=', $id)
            ->where('view_like_status', '=', 1)
            ->where('birthday_wish_logs.valid', '=', 1)
            ->get();
        $data['birthday_likers'] = collect($birthday_likers_wishers)->where('like_wish_type', '=', 1);

        $data['birthday_wishers'] = collect($birthday_likers_wishers)->where('like_wish_type', '=', 2);

        // echo "<pre>";
        // print_r($data);
        // die();
        return $data;
    }

    public function find_birthday_liking_info($birthday_id = False, $employee_id = False)
    {
        $birthday_liking_wishing = DB::table('birthday_wish_logs')
            ->where('employee_id', '=', $birthday_id)
            ->where('wisher_employee_id', '=', $employee_id)
            ->where('view_like_status', '=', 1)
            ->where('valid', '=', 1)
            ->get();
        $data['birthday_liking_no'] = collect($birthday_liking_wishing)->where('like_wish_type', '=', 1);
        $data['birthday_wishing_no'] = collect($birthday_liking_wishing)->where('like_wish_type', '=', 2);
        return $data;
    }

    public function assets_component(){
        return view('layouts.assets_component');
    }
    public function my_profile_component(){
        return view('layouts.my_profile_component');
    }
}