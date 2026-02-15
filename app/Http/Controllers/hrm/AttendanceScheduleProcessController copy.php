<?php

namespace App\Http\Controllers\hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Auth;
// use Session;
// use App\Model\NoticeModel;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\Section;
use App\Model\SubSection;
// use App\Model\EmployeeGroup;
use App\Model\Department;
// use App\Model\Designation;
// use App\Model\JobGrade;
use App\Model\SubUnit;
use App\Model\UnitModel;
use App\Model\WorkLocation;
// use App\Model\NoticePermission;
// use App\Model\AttendanceSetup;
use App\Model\OfficeTimeSetup;
// use App\Model\RosterMaping;
use App\Model\LeaveApplication;
use App\Model\LeaveAdjustment;

// use Cache;
// use permission;
use DB;
use DateTime;
use DateInterval;
use DatePeriod;


// use Hash;
// use Response;
use Carbon\CarbonPeriod;
// use Artisan;

// use App\Model\UserRoleAccess;

class AttendanceScheduleProcessController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request)
    {
        // Dublication attendance delete function
        // $dates = '2023-01-28';
        // // ->where('employee_card_no',904177)
        // $abs =   DB::table('attendance') ->where('pdate',$dates)->get()->toArray();
        // foreach ($abs as $value) {
        //     $getData = collect($abs)->where('employee_card_no',$value->employee_card_no)
        //     ->where('pdate',$dates)->toArray();
        //     $ids = DB::table('attendance')->where('pdate',$dates)->where('employee_card_no',$value->employee_card_no)
        //     ->whereIn('pstatus',[1,2])->first();
        //     if(!empty($ids)){
        //         $idsot = $ids->id;
        //     }else{
        //         $ids = DB::table('attendance')->where('pdate',$dates)->where('employee_card_no',$value->employee_card_no)
        //         ->first();
        //         $idsot = $ids->id;
        //     }

        //     if(count($getData) > 1){
        //         DB::table('attendance')->where('pdate',$dates)->where('employee_card_no',$value->employee_card_no)
        //         ->where('ot_entry',0)->where('id','!=',$idsot)->delete();
        //         // return response($getData);
        //     }
        // }
         // Dublication attendance delete function
        $data['company_sbu_data'] = array();
        $data['section_data'] = array();
        $data['sub_section_data'] = array();
        $data['sub_unit_data'] = array();
        $data['unit_data'] = array();
        $data['work_location_data'] = array();
        $data['department_data'] = array();
        // $data['designation_data'] = array();
        // $data['jobgrade_data'] = array();
        $data['employee_data'] = array();
        // $data['employee_data_approval'] = array();
        // $data['employee_group_data'] = array();
        $company_sbu_data = CompanySbu::valid()->project()->orderBy('priority', 'ASC')->get();
        $section_data = Section::valid()->project()->orderBy('priority', 'ASC')->get();
        $sub_section_data = SubSection::valid()->project()->orderBy('priority', 'ASC')->get();
        $department_data = Department::valid()->project()->orderBy('priority', 'ASC')->get();
        // $designation_data = Designation::valid()->project()->orderBy('priority', 'ASC')->get();
        // $jobgrade_data = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get();
        // $employee_data_approval = Employee::valid()->project()->get();
        $employee_data = Employee::valid()->project()->get()->keyBy('id')->all();
        $unit_data = UnitModel::valid()->project()->orderBy('priority', 'ASC')->get();
        $sub_unit_data = SubUnit::valid()->project()->orderBy('priority', 'ASC')->get();
        $work_location_data = WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get();
        // $employee_group_data = EmployeeGroup::valid()->project()->orderBy('priority', 'ASC')->get();
        foreach ($company_sbu_data as $value) {
            array_push($data['company_sbu_data'], ['id' => $value['id'], 'text' => $value['sbu_name']]);
        }
        foreach ($section_data as $value) {
            array_push($data['section_data'], ['id' => $value['id'], 'text' => $value['section_name']]);
        }
        foreach ($sub_section_data as $value) {
            array_push($data['sub_section_data'], ['id' => $value['id'], 'text' => $value['sub_section_name']]);
        }
        // foreach ($employee_group_data as $value) {
        //   array_push($data['employee_group_data'], ['id' => $value['id'], 'text' => $value['employee_group_name']]);
        // }
        foreach ($department_data as $value) {
            array_push($data['department_data'], ['id' => $value['id'], 'text' => $value['department_name'],]);
        }
        // foreach ($designation_data as $value) {
        //   array_push($data['designation_data'], ['id' => $value['id'], 'text' => $value['designation_name']]);
        // }
        // foreach ($jobgrade_data as $value) {
        //   array_push($data['jobgrade_data'], ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
        // }
        foreach ($employee_data as $value) {
            array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . ' - ' . $value['employee_fullname']]);
        }
        foreach ($sub_unit_data as $value) {
            array_push($data['sub_unit_data'], ['id' => $value['id'], 'text' => $value['sub_unit_name']]);
        }
        foreach ($unit_data as $value) {
            array_push($data['unit_data'], ['id' => $value['id'], 'text' => $value['unit_name']]);
        }
        foreach ($work_location_data as $value) {
            array_push($data['work_location_data'], ['id' => $value['id'], 'text' => $value['work_location_name']]);
        }

        $data['from_date'] = date('Y-m-d');
        $data['to_date'] = date('Y-m-d');

       

        return response($data);
    }

    public function attendanceProcessStore(Request $request)
    {
        
        // ini_set('memory_limit','1GB');
       // ini_set('memory_limit', '-1');
        $validate = [
          'sbu_id' => 'required',
        //   'employee_id' => 'required',
          'to_date' => 'required',
          'from_date' => 'required',
        ];
        $request->validate($validate);

        $unit_data = $request['unit_id'];
        $sub_unit_data = $request['sub_unit_id'];
        $department_data = $request['department_id'];
        $section_data = $request['section_id'];
        $sub_section_data = $request['sub_section_id'];
        $work_location_data = $request['work_location_id'];
        $employee_data = $request['employee_id'];
        $start = $request['from_date'];
        $end = $request['to_date'];
        if ($start != $end) {
            $start = new DateTime($start);
            $end = new DateTime($end);
            $diff = $start->diff($end);
            $interval = DateInterval::createFromDateString('+1 day');
            $period_main = new DatePeriod($start, $interval, $diff->days);
        } else {
            $period_main = [$start];
        }
        // echo "<pre>";
        // print_r($period_main);
        // exit();
        // $file=[];
        // $file1=[];
         try {
                DB::beginTransaction();
                $as =0;
                foreach ($period_main as $key => $value1) {

                    if ($start != $end) {
                        $from_date_formated = $value1->format('Y-m-d');
                    } else {
                        $from_date_formated = $value1;
                    }
                    $privesDaay = date('Y-m-d', strtotime('-1 day', strtotime($from_date_formated)));
                    $prives2Daay = date('Y-m-d', strtotime('-2 day', strtotime($from_date_formated)));

                    $employee_info = DB::table('employees')
                                ->select(
                                    'employees.id',
                                    'employees.employee_id_no',
                                    'salary_duration_type',
                                    'emplyee_category_mgt_non_mgt',
                                    'employees.employee_joining_date',
                                    'employees.employee_sbu',
                                    'employees.employee_work_location',
                                    'employees.employee_id_no',
                                    'employees.employee_fullname as employee_full_name',
                                    'employees.employee_department',
                                    'employees.employee_designation',
                                    'employees.employee_unit',
                                    'employees.employee_sub_unit',
                                    'employees.employee_section',
                                    'employees.employee_sub_section'
                                )
                                // ->valid()
                                ->where('valid', 1)
                                ->where('employee_status', 1)
                                ->where('employee_sbu', $request['sbu_id']);
                    if (!empty($unit_data)) {
                        $employee_info->where('employee_unit', $unit_data);
                    }
                    if (!empty($sub_unit_data)) {
                        $employee_info->where('employee_sub_unit', $sub_unit_data);
                    }
                    if (!empty($department_data)) {
                        $employee_info->where('employee_department', $department_data);
                    }
                    if (!empty($section_data)) {
                        $employee_info->where('employee_section', $section_data);
                    }
                    if (!empty($sub_section_data)) {
                        $employee_info->where('employee_sub_section', $sub_section_data);
                    }
                    if (!empty($work_location_data)) {
                        $employee_info->where('employees.employee_work_location', $work_location_data);
                    }
                    if (!empty($employee_data)) {
                        $employee_info->where('employees.id', $employee_data);
                    }

                    $employee_info = $employee_info->get()->toArray();

                    // echo "<pre>";
                    // print_r($employee_data);
                    // exit();   
                    // ->get()->toArray();
                    $employee_ids = collect($employee_info)->pluck('employee_id_no')->toArray();
                    $employee_primary_ids = collect($employee_info)->pluck('id')->toArray();

                    $attendance_data = DB::table('attendance_log')
                                    ->whereIn('employee_id', $employee_ids)
                                    ->where('TransactionDate', $from_date_formated)
                                    ->where('valid', '=', 1)
                                    ->get()->toArray();
                    $manulAttendance =DB::table('manual_attendances')
                                    ->whereIn('employee_id_no', $employee_ids)
                                    ->where('manual_attendance_date', $from_date_formated)
                                     ->where('manual_atten_approve_status', 2)
                                    ->where('manual_attendance_status', 1)
                                    ->where('valid', '=', 1)
                                    ->get()->toArray();
                   

                    $attendanceTime = DB::table('attendance_setups')
                                    ->select('attendance_setups.*', 'office_time_setups.office_start_time as office_start_time', 'office_time_setups.office_end_time as office_end_time', 'office_time_setups.lateConsiderTime as lateConsiderTime', 'office_time_setups.office_type as office_type', 'office_time_setups.type as type')
                                    ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
                                    ->whereIn('attendance_setups.employee_id', $employee_primary_ids)
                                        ->where('start_date', '>=', $from_date_formated)
                                        ->where('end_date', '<=', $from_date_formated)
                                        ->get();
                    $approve_late_request = DB::table('late_approve_requests')
                                        ->whereIn('employee_id', $employee_primary_ids)
                                        ->where('late_date', $from_date_formated)
                                        ->where('late_approve_status', '=', 2)
                                        ->get();
                    $company_sbu_data = DB::table('company_sbus')->get();

                    $attendanceInfo = DB::table('attendance')
                                    ->whereIn('employee_id', $employee_primary_ids)
                                    ->where('pdate', $privesDaay)
                                    ->whereIn('pstatus', [4,5])
                                    ->get();
                    $attendanceInfo2 = DB::table('attendance')
                                    ->whereIn('employee_id', $employee_primary_ids)
                                    ->where('pdate', $prives2Daay)
                                    ->whereIn('pstatus', [3])
                                    ->get();

                    
                    // $approve_late_find = array();
                    // if ($approve_late_request) {
                    //     foreach ($approve_late_request as $date) {
                    //         array_push($approve_late_find, $date->late_date);
                    //     }
                    // }

                    $holidayFind = DB::table('holiday_permissions')
                    ->leftJoin('holiday_setups', 'holiday_permissions.holiday_id', '=', 'holiday_setups.id')
                    ->select('holiday_setups.*', 'holiday_permissions.*')
                    ->where('holiday_start_date', '<=', $from_date_formated)
                    ->where('holiday_end_date', '>=', $from_date_formated)
                    ->where('sbu_permission', $request['sbu_id'])
                    ->get();


                    // $holiday_find = array();
                    // if ($holidayFind) {
                    //     foreach ($holidayFind as $key => $value) {
                    //         $period_holiday = CarbonPeriod::create($value->holiday_start_date, $value->holiday_end_date);
                    //         foreach ($period_holiday as $date) {
                    //             array_push($holiday_find, $date->format('Y-m-d'));
                    //         }
                    //     }
                    // }


                    $indLeaveInfo1 = LeaveApplication::leftJoin('leave_types', 'leave_types.id', '=', 'leave_applications.leave_type')
                    ->where('leave_from_date', '<=', $from_date_formated)
                    ->where('leave_to_date', '>=', $from_date_formated)
                    ->whereIn('employee_id', $employee_primary_ids)
                    ->where('leave_applications.leave_apply_status', '=', 2)
                    ->get()->toArray();

                    $leave_adjustments =LeaveAdjustment::select('employee_id', 'leave_adjutment_date as leave_from_date', 'leave_adjutment_date as leave_to_date')
                    ->where('leave_adjutment_date', $from_date_formated)
                    ->whereIn('employee_id', $employee_primary_ids)
                    ->where('leave_adj_approve_status', '=', 2)
                    ->get()->toArray();
                    $indLeaveInfo1 =array_merge(
                        $indLeaveInfo1,
                        $leave_adjustments
                    );

                    $pay_days_count = 0;
                    $holiday_count = 0;
                    $leave_count = 0;
                    $present_day_count = 0;
                    $late_day_count = 0;
                    $absent_day_count = 0;
                    $total_late_time = 0;
                    $total_work_time = 0;

                    $late_times = array();
                    $work_times = array();
                    $dataLength = 0;
                    $attendance_dataNew = [];
                    $attendances = [];
                    // $from_date_formated
                    $from_date_formated = date('Y-m-d', strtotime($from_date_formated));
                    $emaploeeAttendall = DB::table('attendance')->where('pdate',$from_date_formated)->get()->toArray();
                    $asss = [];   
                    
                    foreach ($employee_info as $key => $value) {
                        $employeePId = $value->id;
                        $attadesDate = $from_date_formated;
                        
                        $indLeaveInfo = collect($indLeaveInfo1)->where('employee_id', $value->id)->toArray();
                        $ind_leave_info = array();
                        if ($indLeaveInfo) {
                            foreach ($indLeaveInfo as $key => $value_a) {
                                $period_live = CarbonPeriod::create($value_a['leave_from_date'], $value_a['leave_to_date']);
                                foreach ($period_live as $date) {
                                    array_push($ind_leave_info, $date->format('Y-m-d'));
                                }
                            }
                        }
                        $attendancesingelInfo = collect($attendanceInfo)->where('employee_id', $value->id)->first();
                        $attendancesingelInfo2 = collect($attendanceInfo2)->where('employee_id', $value->id)->first();


                        $attendance_time = collect($attendanceTime)->where('employee_id', $value->id)->first();
                        $companySbu_data = collect($company_sbu_data)->where('id', $value->employee_sbu)->first();
                        $absentLocation = json_decode($companySbu_data->location_permission);
                        
                        if ($companySbu_data->casual_absent == 1 && !in_array($value->employee_work_location, $absentLocation)) {
                            $weekend = [];
                        } else {
                            $weekend = explode(",", $companySbu_data->weekend);
                        }
                        // casual_absent
                        $attendance_time =  $attendance_setups_data = collect($attendanceTime)->where('employee_id', $value->id)
                                        ->where('start_date', '<=', $from_date_formated)
                                        ->where('end_date', '>=', $from_date_formated)
                                            ->first();
                        $shiftid = 0;
                        if (empty($attendance_time)) {
                            $attendance_time = $companySbu_data;
                            $attendance_time->office_type = 1;
                            $attendance_time->type = 1;
                            $shiftid = 1;
                        }
                        
                        // Ramadan time setup task by Faruk Khan Start
                        $ramadan_office_time = OfficeTimeSetup::valid()->where('type', 1)->where('office_time_status', 1)->first(); // for Ramadan office time profile attendance view purposes
                        // if($value1->format("Y-m-d") == "2024-03-12"){
                        //     dd($attendance_time, $attendance_setups_data,  $ramadan_office_time);
                            
                        // }
                        // dd($value1->format("Y-m-d"));
                        if(empty($attendance_setups_data) && !empty($ramadan_office_time) && ($from_date_formated >= $ramadan_office_time->office_time_start_date) && ($from_date_formated <= $ramadan_office_time->office_time_end_date)){

                           
                            $attendance_time->office_start_time = isset($ramadan_office_time->office_start_time) ? $ramadan_office_time->office_start_time : '00:00:00';

                            $attendance_time->office_end_time = isset($ramadan_office_time->office_end_time) ? $ramadan_office_time->office_end_time : '00:00:00';

                            $attendance_time->lateConsiderTime = isset($ramadan_office_time->lateConsiderTime) ? $ramadan_office_time->lateConsiderTime : '00:00:00';

                        }elseif(!empty($ramadan_office_time) && $from_date_formated < $ramadan_office_time->office_time_start_date){
                            if(!empty($attendance_time) && !empty($attendance_time->start_date) && ($from_date_formated >= $attendance_time->start_date) && ($from_date_formated <= $attendance_time->end_date)){
                                $attendance_time->office_start_time = isset($attendance_time->office_start_time) ? $attendance_time->office_start_time : '00:00:00';
                                $attendance_time->office_end_time = isset($attendance_time->office_end_time) ? $attendance_time->office_end_time : '00:00:00';
                            }else{
                                $attendance_time->office_start_time = isset($attendance_time->office_start_time) ? $attendance_time->office_start_time : '00:00:00';
                                $attendance_time->office_end_time = isset($attendance_time->office_end_time) ? $attendance_time->office_end_time : '00:00:00';
                            }
                        }else{
                            $attendance_time->office_start_time = isset($attendance_time->office_start_time) ? $attendance_time->office_start_time : '00:00:00';
                            $attendance_time->office_end_time = isset($attendance_time->office_end_time) ? $attendance_time->office_end_time : '00:00:00';
                        }
                        // Ramadan time setup task by Faruk Khan End


                        // dd($attendance_time, $attendance_setups_data, $value1->format("Y-m-d"), $ramadan_office_time);







                        $approve_lateRequest = collect($approve_late_request)->where('employee_id', $value->id)->toArray();
                        $approve_late_find = array();
                        if ($approve_late_request) {
                            foreach ($approve_lateRequest as $date) {
                                array_push($approve_late_find, $date->late_date);
                            }
                        }

                        // employees.employee_sbu',
                        //   'employees.employee_work_location',
                        $holidayFinds = collect($holidayFind)
                        // ->where('sbu_permission', $value->employee_sbu)
                    //    ->where('work_location_permission', $value->employee_work_location)
                        ->toArray();
                        // return response([$holidayFind,$value->id,$value->employee_sbu,$value->employee_work_location, $holidayFinds]);
                        $holiday_find = array();
                        if ($holidayFinds) {
                            foreach ($holidayFinds as $key => $value1) {
                                $period_holiday = CarbonPeriod::create($value1->holiday_start_date, $value1->holiday_end_date);
                                foreach ($period_holiday as $date) {
                                    array_push($holiday_find, $date->format('Y-m-d'));
                                }
                            }
                        }
                        // echo "<pre>";
                        // print_r($holidayFinds);
                        // exit();
                        // dd($holiday_find);
                       
                    //  Holiday permission task by Faruk Khan start
                        $holiday_permission = $holiday_find;
                    // if(!empty($attendance_setups_data)){
                        // $holiday_permission = collect($holidayFind)->where('holiday_start_date', '<=', $from_date_formated)->where('holiday_end_date', '>=', $from_date_formated)
                        // ->where('sbu_permission', $value->employee_sbu)
                        ;
                        $collect_unit_permission = [];
                        if(!empty($value->employee_unit)){
                            $collect_unit_permission = collect($holiday_permission)->where('unit_permission', '!=', 0)->pluck('unit_permission')->toArray();
                        }
                        $collect_sub_unit_permission = [];
                        if(!empty($value->employee_sub_unit)){
                            $collect_sub_unit_permission = collect($holiday_permission)->where('sub_unit_permission', '!=', 0)->pluck('sub_unit_permission')->toArray();
                        }
                        $collect_department_permission = [];
                        if(!empty($value->employee_department)){
                            $collect_department_permission = collect($holiday_permission)->where('department_permission', '!=', 0)->pluck('department_permission')->toArray();
                        }
                        $collect_section_permission = [];
                        if(!empty($value->employee_section)){
                            $collect_section_permission = collect($holiday_permission)->where('section_permission', '!=', 0)->pluck('section_permission')->toArray();
                        }
                        $collect_sub_section_permission = [];
                        if(!empty($value->employee_sub_section)){
                            $collect_sub_section_permission = collect($holiday_permission)->where('sub_section_permission', '!=', 0)->pluck('sub_section_permission')->toArray();
                        }
                        $collect_work_location_permission = [];
                        if(!empty($value->employee_work_location)){
                            $collect_work_location_permission = collect($holiday_permission)->where('work_location_permission', '!=', 0)->pluck('work_location_permission')->toArray();
                        }
                        $collect_employee_id_permission = [];
                        if(!empty($value->id)){
                            $collect_employee_id_permission = collect($holiday_permission)->where('employee_id', '!=', 0)->pluck('employee_id')->toArray();
                        }

                        // dd($collect_work_location_permission);

                        // !empty($holiday_find) && in_array($from_date_formated, $holiday_find)
                        
                       
                        // if(!empty($value->employee_sbu)){
                        //     $holiday_permission = collect($holiday_permission)->where('sbu_permission', $value->employee_sbu);
                        // }
                        $check_holiday_permission = [];
                        if(!empty($collect_unit_permission) && count($collect_unit_permission) > 0 && in_array($value->employee_unit, $collect_unit_permission)){
                            // $holiday_permission = collect($holiday_permission)->where('unit_permission', $value->employee_unit);
                            $check_holiday_permission = [1];
                        }
                        if(!empty($collect_sub_unit_permission) && count($collect_sub_unit_permission) > 0 && in_array($value->employee_sub_unit, $collect_sub_unit_permission)){
                            // $holiday_permission = collect($holiday_permission)->where('sub_unit_permission', $value->employee_sub_unit);
                            $check_holiday_permission = [1];
                        }
                        if(!empty($collect_department_permission) && count($collect_department_permission) > 0 && in_array($value->employee_department, $collect_department_permission)){
                            // $holiday_permission = collect($holiday_permission)->where('department_permission', $value->employee_department);
                            $check_holiday_permission = [1];
                        }
                        if(!empty($collect_section_permission) && count($collect_section_permission) > 0 && in_array($value->employee_section, $collect_section_permission)){
                            // $holiday_permission = collect($holiday_permission)->where('section_permission', $value->employee_section);
                            $check_holiday_permission = [1];
                        }
                        if(!empty($collect_sub_section_permission) && count($collect_sub_section_permission) > 0 && in_array($value->employee_sub_section, $collect_sub_section_permission)){
                            // $holiday_permission = collect($holiday_permission)->where('sub_section_permission', $value->employee_sub_section);
                            $check_holiday_permission = [1];
                        }
                        if(!empty($collect_work_location_permission) && count($collect_work_location_permission) > 0 && in_array($value->employee_work_location, $collect_work_location_permission)){
                            // $holiday_permission = collect($holiday_permission)->where('work_location_permission', $value->employee_work_location);
                            $check_holiday_permission = [1];
                        }
                        if(!empty($collect_employee_id_permission) && count($collect_employee_id_permission) > 0 && in_array($value->id, $collect_employee_id_permission)){
                            // $holiday_permission = collect($holiday_permission)->where('employee_id', $value->id);
                            $check_holiday_permission = [1];
                        }

                    // }
                    
                    if(!empty($check_holiday_permission) && count($check_holiday_permission) == 0){
                        $holiday_find = array();
                    }
                    // dd($check_holiday_permission, $holiday_find, $attendance_setups_data);
                    
                    if(!empty($check_holiday_permission) && count($check_holiday_permission) > 0){
                        if(!empty($attendance_setups_data)){
                            $holiday_find = array();
                        }
                    }

                    // dd($check_holiday_permission, $collect_work_location_permission, $holiday_permission);

                    //  Holiday permission task by Faruk Khan end


                  $start_timeall=date('A', strtotime($attendance_time->office_start_time));
                  $end_timeall=date('A', strtotime($attendance_time->office_end_time));
              // if(!empty($attendance_time)){
                // return response([$start_timeall,$end_timeall]);
                  if ($start_timeall == 'PM' && $end_timeall == 'AM') {
                      $date = new DateTime($from_date_formated);
                      $date->modify('+1 day');
                      $lastDate= $date->format('Y-m-d');
                      $endTime=date('h:i A', strtotime($attendance_time->office_end_time));
                      $startTime=date('h:i A', strtotime($attendance_time->office_start_time));
                        if(date('Y-m-d') == $from_date_formated ){
                                if (date('A') != 'PM'  ) {
                                    $intime=collect(collect($attendance_data)->where('TransactionDate', $from_date_formated)
                                        ->where('ServerRecordTime', '<=', strtotime($endTime))
                                        ->where('employee_id', $value->employee_id_no)->sortByDesc('ServerRecordTime')->values()->all())->first();
                                        // return response([$from_date_formated,$value->employee_id_no,$intime]);   
                                } else {
                                    
                                    $intime=collect(collect($attendance_data)->where('TransactionDate', $from_date_formated)
                                    ->where('employee_id', $value->employee_id_no)->sortByDesc('ServerRecordTime')->values()->all())->first();
                                }
                        }else{
                            $intime=collect(collect($attendance_data)->where('TransactionDate', $from_date_formated)
                                    ->where('employee_id', $value->employee_id_no)->sortByDesc('ServerRecordTime')->values()->all())->first();
                        }

                      if (!empty($intime)) {
                          if (date('A', strtotime($intime->TransactionTime)) == 'PM') {
                              $intime=$intime;
                          } else {
                              $intime=[];
                          }
                      } else {
                          $intime=[];
                      }

                      $outtime = DB::table('attendance_log')
                               ->where('TransactionDate', $lastDate)
                               ->where('employee_id', $value->employee_id_no)
                               ->where('valid', '=', 1)
                               ->orderBy('ServerRecordTime', 'ASC')
                               ->first();
                  } else {
                      if($value->salary_duration_type == 1 && $value->emplyee_category_mgt_non_mgt == 2 && $shiftid == 1){
                         $intime=[];
                         $outtime=[];
                      }else{
                         $intime=collect(collect($attendance_data)->where('TransactionDate', $from_date_formated)->where('employee_id', $value->employee_id_no)
                            // ->sortBy('ServerRecordTime')
                             ->sortBy('id')
                            ->values()->all())->first();
                          $outtime=collect(collect($attendance_data)->where('TransactionDate', $from_date_formated) ->where('employee_id', $value->employee_id_no)
                            // ->sortByDesc('ServerRecordTime')
                            ->sortByDesc('id')
                            ->values()->all())->first();
                      }
                       
                  }

                // return response([$attendance_time]);
              // }else{
              //   $intime=[];
              //   $outtime=[];
              // }

            //   return response([$intime,$outtime]);

              //return response([$value->salary_duration_type,$value->emplyee_category_mgt_non_mgt]);
                         
                        // $intime = collect(collect($attendance_data)->where('TransactionDate', $from_date_formated)->where('employee_id', $value->employee_id_no)->sortBy('id')->values()->all())->first();
                        // $outtime = collect(collect($attendance_data)->where('TransactionDate', $from_date_formated)->where('employee_id', $value->employee_id_no)->sortByDesc('id')->values()->all())->first();


                        $manulAttendances = collect($manulAttendance)->where('manual_attendance_date', $from_date_formated)
                        ->where('employee_id', $employeePId)->first();
                        // return response($manulAttendances->employee_id_no);
                        $office_start_time = isset($attendance_time->office_start_time) ? $attendance_time->office_start_time : '00:00:00';
                        $office_end_time = isset($attendance_time->office_end_time) ? $attendance_time->office_end_time : '00:00:00';
                        // $attendancesingelInfo2   attendancesingelInfo
                        // !empty($intime['TransactionTime'])  && (date('H:i', strtotime($intime['TransactionTime'])) != '00:00') && !empty($attendancesingelInfo2) && empty($holiday_find) && empty($ind_leave_info) &&  !empty($attendancesingelInfo) &&  ($attendancesingelInfo->pstatus == 4)
                        // empty($holiday_find) &&
                        if ($companySbu_data->casual_absent == 1 && !in_array($value->employee_work_location, $absentLocation) && empty($intime) &&  empty($ind_leave_info) &&  !empty($attendancesingelInfo2) &&  !empty($attendancesingelInfo) &&   in_array($attendancesingelInfo->pstatus, [4,5])) {
                            DB::table('attendance')
                            ->where('id', $attendancesingelInfo->id)
                            ->whereIn('pstatus', [4,5])
                            ->update([
                                "pstatus" => 3,
                                "remarks" => 'Absent',
                            ]);
                        } 
                        
                        
                        if (!empty($attendance_time) && $value->employee_joining_date <= $from_date_formated) {
                            if (!empty($manulAttendances)) {
                                if($manulAttendances->attendance_type == 1){
                                        $intimes = date('H:i', strtotime($manulAttendances->manual_start_time));
                                        $outtimes = date('H:i', strtotime($manulAttendances->manual_end_time));

                                        if (!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) !=  date('H:i', strtotime('00:00:00'))) {
                                            $lateConsiderTime = date('H:i', strtotime($attendance_time->lateConsiderTime));
                                        } else {
                                            $lateConsiderTime = date('H:i', strtotime($office_start_time));
                                        }

                                        if ($intimes <= $lateConsiderTime) {
                                            $late_time = '00:00';
                                            $status = "Present";
                                            $statusId = 1;
                                        } else {
                                            if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
                                                $late_time = strtotime($intimes) - strtotime($office_start_time);
                                                $late_time = date('H:i', $late_time);
                                                $status = "Late(Approved)";
                                                $statusId = 1;
                                            } else {
                                                $late_time = strtotime($intimes) - strtotime($office_start_time);
                                                $late_time = date('H:i', $late_time);
                                                $status = "Late";
                                                $statusId = 2;
                                            }
                                        }
                                }else{
                                    $intimes = date('H:i', strtotime($manulAttendances->manual_start_time));
                                    $outtimes = date('H:i', strtotime($manulAttendances->manual_end_time));
                                    $late_time = '00:00';
                                    $status = "Absent3";
                                    $statusId = 3;
                                }

                                $work_time = strtotime($outtimes) - strtotime($intimes);
                                $attendances = [
                                    "machineno" => 0,
                                    "uploadid" => 0,
                                    "employee_id" => $value->id,
                                    "employee_card_no" => $value->employee_id_no,
                                    "pdate" => $from_date_formated,
                                    "intime" => $intimes,
                                    "outime" => $outtimes,
                                    "latetime" => $late_time,
                                    "start_time" => date('H:i', strtotime($office_start_time)),
                                    "end_time" => date('H:i', strtotime($office_end_time)),
                                    "pstatus" => $statusId,
                                    "status" => 1,
                                    "remarks" => $status,
                                    'manual_id' => 1,
                                    "shift_time" => date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
                                    ];
                            } elseif ($attendance_time->type == 2) {
                               
                                if (!empty($intime) && !empty($outtime)) {
                                    $intimes = date('H:i', strtotime($intime->TransactionTime));
                                    $outtimes = date('H:i', strtotime($outtime->TransactionTime));

                                    if ($attendance_time->office_type == 2) {
                                        // attendanceInfo
                                        // if (!empty($attendancesingelInfo) && $companySbu_data->casual_absent == 1 && in_array($value->employee_work_location, $absentLocation)) {
                                        //     $status = "Absent";
                                        //     $statusId = 3;
                                        //     $late_time = '00:00';
                                        // } else {
                                        $status = "Weekend";
                                        $statusId = 1;
                                        $late_time = '00:00';
                                    // }
                                    } else {
                                        // if(!empty($attendance_time->lateConsiderTime)){
                                        //     $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                                        // }else{
                                        //     $lateConsiderTime=strtotime($office_start_time);
                                        // }
                                        if (!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) !=  date('H:i', strtotime('00:00:00'))) {
                                            $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                                        } else {
                                            $lateConsiderTime=date('H:i', strtotime($office_start_time));
                                        }
                                        if ($intimes <= $lateConsiderTime) {
                                            $late_time = '00:00';
                                            $status="Present";
                                            $statusId=1;
                                        } else {
                                            if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
                                                $late_time = strtotime($intimes) - strtotime($office_start_time);
                                                $late_time = date('H:i', $late_time);
                                                $status="Late(Approved)";
                                                $statusId=1;
                                            } else {
                                                $late_time = strtotime($intimes) - strtotime($office_start_time);
                                                $late_time = date('H:i', $late_time);
                                                $status="Late";
                                                $statusId=2;
                                            }
                                        }
                                    }
                                    $work_time = strtotime($outtimes) - strtotime($intimes);

                                    $attendances=[
                                    "machineno"=>0,
                                    "uploadid"=>0,
                                    "employee_id"=>$value->id,
                                    "employee_card_no"=>$value->employee_id_no,
                                    "pdate"=>$from_date_formated,
                                    "intime" => $intimes,
                                    "outime" => $outtimes,
                                    "latetime"=>$late_time,
                                    "start_time" => date('H:i', strtotime($office_start_time)),
                                    "end_time" => date('H:i', strtotime($office_end_time)),
                                    "pstatus"=>$statusId,
                                    "status"=>1,
                                    "remarks"=>$status,
                                    'manual_id' => 1,
                                    "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
                                    ];
                                }elseif(!empty($intime) && empty($outtime)) {
                                    //$intimes = date('H:i', strtotime($intime->TransactionTime));
                                   // $outtimes = date('H:i', strtotime($outtime->TransactionTime));
                                    if (!empty($intime->TransactionTime)) {
                                       $intimes = $intime->TransactionTime;
                                    } else {
                                       $intimes ="00:00";
                                    }
                                      $outtimes='0:00';

                                    if ($attendance_time->office_type == 2) {
                                        // attendanceInfo
                                        // if (!empty($attendancesingelInfo) && $companySbu_data->casual_absent == 1 && in_array($value->employee_work_location, $absentLocation)) {
                                        //     $status = "Absent";
                                        //     $statusId = 3;
                                        //     $late_time = '00:00';
                                        // } else {
                                        $status = "Weekend";
                                        $statusId = 1;
                                        $late_time = '00:00';
                                    // }
                                    } else {
                                       
                                        // if(!empty($attendance_time->lateConsiderTime)){
                                        //     $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                                        // }else{
                                        //     $lateConsiderTime=strtotime($office_start_time);
                                        // }
                                        if (!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) !=  date('H:i', strtotime('00:00:00'))) {
                                            $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                                        } else {
                                            $lateConsiderTime=date('H:i', strtotime($office_start_time));
                                        }
                                        if ($intimes <= $lateConsiderTime) {
                                            $late_time = '00:00';
                                            $status="Present";
                                            $statusId=1;
                                        } else {
                                            if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
                                                $late_time = strtotime($intimes) - strtotime($office_start_time);
                                                $late_time = date('H:i', $late_time);
                                                $status="Late(Approved)";
                                                $statusId=1;
                                            } else {
                                                $late_time = strtotime($intimes) - strtotime($office_start_time);
                                                $late_time = date('H:i', $late_time);
                                                $status="Late";
                                                $statusId=2;
                                            }
                                        }
                                    }
                                    $work_time = strtotime($outtimes) - strtotime($intimes);

                                    $attendances=[
                                    "machineno"=>0,
                                    "uploadid"=>0,
                                    "employee_id"=>$value->id,
                                    "employee_card_no"=>$value->employee_id_no,
                                    "pdate"=>$from_date_formated,
                                    "intime" => $intimes,
                                    "outime" => $outtimes,
                                    "latetime"=>$late_time,
                                    "start_time" => date('H:i', strtotime($office_start_time)),
                                    "end_time" => date('H:i', strtotime($office_end_time)),
                                    "pstatus"=>$statusId,
                                    "status"=>1,
                                    "remarks"=>$status,
                                    'manual_id' => 1,
                                    "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
                                    ];
                                } else {
                                    // return response([$outtime]);
                                    if ($attendance_time->office_type==2) {
                                        // if (!empty($attendancesingelInfo) && $companySbu_data->casual_absent == 1 && in_array($value->employee_work_location, $absentLocation)) {
                                        //     $status = "Absent";
                                        //     $statusId = 3;
                                        // } else {
                                        $status = "Weekend";
                                        $statusId = 4;
                                    // }
                                    // $status="Weekend";
                                    // $statusId=4;
                                    } elseif (!empty($holiday_find) && in_array($from_date_formated, $holiday_find)) {
                                        $status="Holiday";
                                        $statusId=5;
                                    } elseif (!empty($ind_leave_info) && in_array($from_date_formated, $ind_leave_info)) {
                                        $laveType=collect($indLeaveInfo)->where('leave_from_date', '<=', $from_date_formated)->where('leave_to_date', '>=', $from_date_formated)->first();

                                        if (!empty($laveType['leave_short_type']) && ($laveType['leave_short_type'] == 'LWP')) {
                                            $status = $laveType['leave_short_type'];
                                            $statusId = 3;
                                        } else {
                                            if (!empty($laveType['leave_short_type'])) {
                                                $status = $laveType['leave_short_type'];
                                            } else {
                                                $status = 'RL';
                                            }
                                            $statusId = 6;
                                        }
                                    } else {
                                        $status = "Absent";
                                        $statusId = 3;
                                    }

                                    $attendances=[
                                        "machineno"=>0,
                                        "uploadid"=>0,
                                        "employee_id"=>$value->id,
                                        "employee_card_no"=>$value->employee_id_no,
                                        "pdate"=>$from_date_formated,
                                        "intime" => '00:00:00',
                                        "outime" => '00:00:00',
                                        "latetime"=>'00:00:00',
                                        "start_time" => date('H:i', strtotime($office_start_time)),
                                        "end_time" => date('H:i', strtotime($office_end_time)),
                                        "pstatus"=>$statusId,
                                        "status"=>1,
                                        "remarks"=>$status,
                                        'manual_id' => 1,
                                        "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
                                    ];
                                }
                            } else {
                                // return response([$intime,$outtime]);
                                if (!empty($intime) && !empty($outtime)) {
                                    $intimes =date('H:i', strtotime($intime->TransactionTime));
                                    $outtimes =date('H:i', strtotime($outtime->TransactionTime));

                                    if (in_array(date('D', strtotime($from_date_formated)), $weekend)) {
                                        $status="Weekend";
                                        $statusId=1;
                                        $late_time = '00:00';
                                    } else {
                                        if (!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) !=  date('H:i', strtotime('00:00:00'))) {
                                            $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
                                        } else {
                                            $lateConsiderTime=date('H:i', strtotime($office_start_time));
                                        }

                                        if ($intimes <= $lateConsiderTime) {
                                            $late_time = '00:00';
                                            $status="Present";
                                            $statusId=1;
                                        } else {
                                            if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
                                                $late_time = strtotime($intimes) - strtotime($office_start_time);
                                                $late_time = date('H:i', $late_time);
                                                $status="Late(Approved)";
                                                $statusId=1;
                                            } else {
                                                $late_time = strtotime($intimes) - strtotime($office_start_time);
                                                $late_time = date('H:i', $late_time);
                                                $status="Late";
                                                $statusId=2;
                                            }
                                        }
                                    }
                                    $work_time = strtotime($outtimes) - strtotime($intimes);

                                    $attendances=[
                                        "machineno"=>0,
                                        "uploadid"=>0,
                                        "employee_id"=>$value->id,
                                        "employee_card_no"=>$value->employee_id_no,
                                        "pdate"=>$from_date_formated,
                                        "intime" => $intimes,
                                        "outime" => $outtimes,
                                        "latetime"=>$late_time,
                                        "start_time" => date('H:i', strtotime($office_start_time)),
                                        "end_time" => date('H:i', strtotime($office_end_time)),
                                        "pstatus"=>$statusId,
                                        "status"=>1,
                                        "remarks"=>$status,
                                        'manual_id' => 1,
                                        "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
                                    ];
                                } else {
                                    if ((in_array(date('D', strtotime($from_date_formated)), $weekend))) {
                                        $status="Weekend";
                                        $statusId=4;
                                        $late_time = '00:00';
                                    } elseif (!empty($holiday_find) && in_array($from_date_formated, $holiday_find)) {
                                        $status="Holiday";
                                        $statusId=5;
                                        $late_time = '00:00';
                                    } elseif (!empty($ind_leave_info) && in_array($from_date_formated, $ind_leave_info)) {
                                        $laveType=collect($indLeaveInfo)->where('leave_from_date', '<=', $from_date_formated)->where('leave_to_date', '>=', $from_date_formated)->first();
                                        if (!empty($laveType['leave_short_type']) && ($laveType['leave_short_type'] == 'LWP')) {
                                            $status = $laveType['leave_short_type'];
                                            $statusId = 3;
                                        } else {
                                            if (!empty($laveType['leave_short_type'])) {
                                                $status = $laveType['leave_short_type'];
                                            } else {
                                                $status = 'RL';
                                            }
                                            $statusId = 6;
                                        }
                                    } else {
                                        $status = "Absent";
                                        $statusId = 3;
                                        $late_time = '00:00';
                                    }

                                    $attendances=[
                                        "machineno"=>0,
                                        "uploadid"=>0,
                                        "employee_id"=>$value->id,
                                        "employee_card_no"=>$value->employee_id_no,
                                        "pdate"=>$from_date_formated,
                                        "intime" => '00:00:00',
                                        "outime" => '00:00:00',
                                        "latetime"=>'00:00:00',
                                        "start_time" => date('H:i', strtotime($office_start_time)),
                                        "end_time" => date('H:i', strtotime($office_end_time)),
                                        "pstatus"=>$statusId,
                                        "status"=>1,
                                        "remarks"=>$status,
                                        'manual_id' => 1,
                                        "shift_time"=> date('H:i', strtotime($office_start_time))." - ". date('H:i', strtotime($office_end_time)),
                                    ];
                                }
                            }
                        }
                        
                        $emaploeeAttends = collect($emaploeeAttendall)
                                        // ->where('employee_card_no', $value->employee_id_no)
                                        ->where('employee_id', $employeePId)
                                        ->where('pdate', $attadesDate)
                                        ->first();
                        
                                                  
                       // return response([$attendances]);
                       
                        $as =0;  
                         

                        //return response($emaploeeAttendall);  
                        // return response($attendances);        // from_date_formated 
                        // echo "<pre>";
                        // print_r($attendances);
                        // exit();
                        if (!empty($emaploeeAttends)) {
                            
                            $ot = collect($emaploeeAttendall)
                                        ->where('employee_id', $employeePId)
                                        ->where('pdate', $attadesDate)
                                        ->where('ot_entry','!=',0)
                                        ->first();
                            if(!empty($ot)){
                                $notDeleteId = $ot->id;
                            }else{
                                $notDeleteId = $emaploeeAttends->id;
                            }
                            // $deelee =   DB::table('attendance')->where('pdate',$attadesDate)->where('employee_id', $employeePId)
                            //             ->where('ot_entry',0)->where('id','!=',$notDeleteId)->delete();
                            $deelee =   DB::table('attendance')
                                        ->where('pdate',$attadesDate)
                                        ->where('employee_id', $employeePId)
                                        ->where(function ($deelee) {
                                            $deelee->where('ot_entry', 0)->orWhere('ot_entry' , Null);
                                        })->where('id','!=',$notDeleteId)->delete();
                            // return response([$deelee,$notDeleteId]);   
                                        // ->delete();      
                            $aaa = DB::table('attendance')
                                    // ->where('employee_card_no', $value->employee_id_no)
                                    ->where('id', $notDeleteId)
                                    ->where('employee_id', $value->id)
                                    ->where('pdate', $from_date_formated)
                                    ->update($attendances);
                                    $as = 1;
                        } else {
                            DB::table('attendance')->insert($attendances);
                            $as = 1;
                            // $attendance_dataNew[] = $attendances;
                        }
                    }
                    
                    // $dd=DB::table('attendance')->insert($attendance_dataNew);
                    //return response($attendance_dataNew);
                }
                if($as == 1){
                    $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
                }else{
                    $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
                }
           
           
               DB::commit();
           
        } catch (\Exception $exception) {
            DB::rollBack();
            $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
            return response($exception);
        }
        return response($message);
    }
}
