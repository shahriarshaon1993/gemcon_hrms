<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Employee;
use App\Model\EmployeeApproval;
use App\Model\DashboardSettingModel;
use App\Model\EvaluationCommentsSuggestions;
use App\Models\MOS;
use App\Helper\ResponseUtil;
use App\Model\CompanySbu;
use App\Model\LateRequest;
use App\Model\LeaveApplication;
use App\Model\ManualAttendance;
use App\Model\ServiceRequest;
use DB;
use Cache;
use Auth;
use DateTime;

class HomeDashboarController extends Controller
{
    public function index(Request $request){
        // $data['employee_from'] = DB::table('employee_adress_details')
        //                         ->select('districts.name',  DB::raw('COUNT(employee_adress_details.ead_employee_id) as numberOfEmployee'))
        //                         ->leftJoin('districts', 'employee_adress_details.permanent_district', '=', 'districts.id' ) ->groupBy('districts.name')->get();
                                // return $data;
        // $employee_list = new Employee();
        // $data['company_sbu_data'] = $employee_list->report_filter_data()['company_sbu_data']; 

        

    }

    public function find_dashboard_data(Request $request){
        $sbu_id = $request->sbu_id;
        $year = $request->year;
        $first_from_date = $request->first_from_date;
        $last_to_date = $request->last_to_date;
        // dd($sbu_id);
        $get_sbu_list = CompanySbu::valid()->project()->select('id', 'sbu_name')->orderBy('sbu_name')->get()->toArray();
        $sbu_all_selected = [
           [
            'id'=> 0,
            'sbu_name'=> '---------- ALL SBU ----------',            
           ] 
        ];
        $data['get_sbu_list'] = array_merge($sbu_all_selected, $get_sbu_list);
        // return response($result);

        // Declare and define two dates
        $now_date_time = date('Y-m-d H:i:s');
        $date1 = strtotime("1979-01-01 00:00:00");
        $date2 = strtotime($now_date_time);

        // Formulate the Difference between two dates
        $diff = abs($date2 - $date1);
        $years = floor($diff / (365*60*60*24));

        $months = floor(($diff - $years * 365*60*60*24)
                                        / (30*60*60*24));

        $days = floor(($diff - $years * 365*60*60*24 -
                    $months*30*60*60*24)/ (60*60*24));

        $hours = floor(($diff - $years * 365*60*60*24
                - $months*30*60*60*24 - $days*60*60*24)
                                            / (60*60));

        $minutes = floor(($diff - $years * 365*60*60*24
                - $months*30*60*60*24 - $days*60*60*24
                                    - $hours*60*60)/ 60);

        $seconds = floor(($diff - $years * 365*60*60*24
                - $months*30*60*60*24 - $days*60*60*24
                        - $hours*60*60 - $minutes*60));

        $data['establishement_date_time'] =  $years." years ".$months. " months ".$days. " days ".$hours. " hours ".$minutes. " minutes ".$seconds. " seconds";  

        $employee_data = DB::table('employees')
        ->leftJoin('employee_personal_infos','employee_personal_infos.employee_id','=','employees.id')
        ->leftJoin('designations', 'employees.employee_designation', '=', 'designations.id')
        ->leftJoin('departments','employees.employee_department','=','departments.id')
        ->leftJoin('company_sbus', 'employees.employee_sbu', '=', 'company_sbus.id')
        ->select(
            'employees.employee_joining_date',
            'employees.employee_id_no',
            'employees.employee_fullname',
            'designations.designation_name',
            'company_sbus.sbu_name',
            DB::raw('DATE_FORMAT(employee_confirmation_due_date, "%d %b %Y") as employee_confirmation_due_date'),
            DB::raw('DATE_FORMAT(employee_joining_date, "%d %b %Y") as employee_confirmation_due_date'),
            'employee_type',
        )
        ->where('employees.valid', '=', 1)
        ->where('employees.employee_status', '=', 1)
        // ->where('employees.employee_joining_date', '<=', '2024-10-02')
        ;   
        if(!empty($sbu_id)){
            $employee_data = $employee_data->where('employees.employee_sbu','=', $sbu_id);
        }
        if(empty($first_from_date) && !empty($last_to_date)){
            $employee_data = $employee_data->where('employees.employee_joining_date','<=', $last_to_date);
        }
        if(!empty($first_from_date) && !empty($last_to_date)){
            $employee_data = $employee_data->whereBetween('employees.employee_joining_date', [$first_from_date, $last_to_date]);
        }
        
        // headcount
        $data['dept_headcount'] = (clone $employee_data)->select('departments.department_name', DB::raw('count(employee_department) as employee_no'))->groupBy(['employee_department'])->get();
        $data['total_headcount'] = ($data['dept_headcount'])->sum('employee_no');
        // dd($data['total_headcount']);

        //Gender wise employee
        $gender_wise_emp = DB::table('employees')
        ->leftJoin('employee_personal_infos','employee_personal_infos.employee_id','=','employees.id')
        ->select(
            'employees.employee_joining_date',
            'employee_personal_infos.employee_gender',
            DB::raw('
                (case 
                    when employee_gender = 1 then "Female" 
                    when employee_gender = 2 then "Male" 
                    when employee_gender = 0 then "Others" 
                end)  as gender_name
            '),
            DB::raw('count(employees.id) as employee_no'),
        )
        // ->where('employee_gender', '!=', '')
        ->where('employees.valid', '=', 1)
        ->where('employees.employee_status', '=', 1)
        ->groupBy(['employee_gender'])
        ;
        if(!empty($sbu_id)){
            $gender_wise_emp = $gender_wise_emp->where('employees.employee_sbu','=', $sbu_id);
        }
        if(empty($first_from_date) && !empty($last_to_date)){
            $gender_wise_emp = $gender_wise_emp->where('employees.employee_joining_date','<=', $last_to_date);
        }
        if(!empty($first_from_date) && !empty($last_to_date)){
            $gender_wise_emp = $gender_wise_emp->whereBetween('employees.employee_joining_date', [$first_from_date, $last_to_date]);
        }
        $data['female_employee'] = (clone $gender_wise_emp)->where('employee_gender', '=', 1)->first();
        $data['male_employee'] = (clone $gender_wise_emp)->where('employee_gender', '=', 2)->first();
        $data['others_employee'] = (clone $gender_wise_emp)->where('employee_gender', '=', 0)->first();
        $data['total_employee'] = (clone $gender_wise_emp)->whereIn('employee_gender', [0,1,2])->first();

        // Job Confirmation Due List
        $today_date = date('Y-m-d');
        $nextmonth_date = date($today_date, strtotime('+1 month'));

        // Job Confirmation Due List
        $data['red_due_employee'] = (clone $employee_data)->where('employee_type', 2)->where('employees.employee_confirmation_due_date', '<', $today_date)->orderBy('employees.employee_confirmation_due_date','desc')->get()->toArray();
        $data['yellow_due_employee'] = (clone $employee_data)->where('employee_type', 2)->whereBetween('employees.employee_confirmation_due_date', [$today_date, $nextmonth_date])->orderBy('employees.employee_confirmation_due_date','desc')->get()->toArray();

        // Contractual Employee Due List
        $data['contractual_red_due_employee'] = (clone $employee_data)->where('employee_type', 3)->where('employees.employee_confirmation_due_date', '<', $today_date)->orderBy('employees.employee_confirmation_due_date','desc')->get()->toArray();
        $data['contractual_yellow_due_employee'] = (clone $employee_data)->where('employee_type', 3)->whereBetween('employees.employee_confirmation_due_date', [$today_date, $nextmonth_date])->orderBy('employees.employee_confirmation_due_date','desc')->get()->toArray();

        // upcoming event
        // $today_date = date('2022-01-12');
        // if($first_from_date == $last_to_date){
        //     $today_date = date('Y-m-d');
        // }
        $data_upcoming_event = DB::table('notices')->select('notice_title', 'notice_details', DB::raw('DATE_FORMAT(notice_sdate, "%d %b %Y") as notice_sdate'), DB::raw('DATE_FORMAT(notice_edate, "%d %b %Y") as notice_edate'),)
        ->where('valid', '=', 1);
        // if(!empty($today_date)){
        //     $data_upcoming_event = $data_upcoming_event->where('notice_sdate', '>=', $today_date);
        // }
        if(empty($first_from_date) && !empty($last_to_date)){
            $data_upcoming_event = $data_upcoming_event->where('notice_sdate','>=', $last_to_date);
        }
        if(!empty($first_from_date) && !empty($last_to_date)){
            $data_upcoming_event = $data_upcoming_event->whereBetween('notice_sdate', [$first_from_date, $last_to_date]);
        }
        $data['upcoming_event'] = $data_upcoming_event->orderBy('notice_sdate','desc')->get();

        $year = $request->year;
        $first_from_date = $request->first_from_date;
        $last_to_date = $request->last_to_date;
        // Employee Blood Group
        $data['employee_blood_group'] = $this->employeeBloodGroup($sbu_id, $first_from_date, $last_to_date);
        
        // Turn over employee
        $data['turn_over_employee'] = $this->employeeTurnover($employee_data);
        return response($data);
    }

    public function find_recuiting_outgoing(Request $request){
        // dd($request);
        // $current_year = $request->year;
        $sbu_id = $request->sbu_id;
        $year = $request->year ?? date("Y", strtotime($request->last_to_date));
        // $year = date("Y", strtotime($request->last_to_date));
        $first_from_date = $request->first_from_date;
        $last_to_date = $request->last_to_date;
        $baseQuery = DB::table('employees')
        ->select(
            'employee_sbu',
            DB::raw('count(id) as employee_no'),
            DB::raw('YEAR(employee_joining_date) year, MONTH(employee_joining_date) month_no'),
            DB::raw('
                (case 
                    when (MONTH(employee_joining_date) = 1) then "Jan" 
                    when (MONTH(employee_joining_date) = 2) then "Feb" 
                    when (MONTH(employee_joining_date) = 3) then "Mar" 
                    when (MONTH(employee_joining_date) = 4) then "Apr" 
                    when (MONTH(employee_joining_date) = 5) then "May" 
                    when (MONTH(employee_joining_date) = 6) then "Jun" 
                    when (MONTH(employee_joining_date) = 7) then "July" 
                    when (MONTH(employee_joining_date) = 8) then "Aug" 
                    when (MONTH(employee_joining_date) = 9) then "Sep" 
                    when (MONTH(employee_joining_date) = 10) then "Oct" 
                    when (MONTH(employee_joining_date) = 11) then "Nov" 
                    when (MONTH(employee_joining_date) = 12) then "Dec" 
                end)  as month_name
            ')
        )
        ->where('employees.valid', '=', 1)
        ->whereIn('employee_status', [1,2])
        ;
        if(!empty($sbu_id)){
            $baseQuery = $baseQuery->where('employees.employee_sbu','=', $sbu_id);
        }
        // if(!empty($year)){
        //     $baseQuery = $baseQuery->whereYear('employees.employee_joining_date','=', $year);
        // }

        if(empty($first_from_date) && !empty($last_to_date)){
            $baseQuery = $baseQuery->whereYear('employees.employee_joining_date','=', $year);
        }
        if(!empty($first_from_date) && !empty($last_to_date)){
            $baseQuery = $baseQuery->whereBetween('employees.employee_joining_date', [$first_from_date, $last_to_date]);
        }
        $active = (clone $baseQuery)->where('employee_status', 1)->groupBy(['year','month_no'])->get() ?? null;
        $resign = (clone $baseQuery)->where('employee_status', 2)->groupBy(['year','month_no'])->get() ?? null;

        // dd($baseQuery->get());

        $data['xAxis'] = [];
        foreach ($active  as $key => $value) {
            $data['xAxis']['categories'][] = $value->month_name;
        }
        if(count($data['xAxis']) == 0){
            $data['xAxis']['categories'] = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
        }
        $recruitment_series = [];
        foreach ($active as $key => $value) {
            $recruitment_series[] = $value->employee_no;
        }

        $outgoing_series = [];
        foreach ($resign as $key => $value) {
            $outgoing_series[] = $value->employee_no;
        }

        $data['series'] = [
            [
                'name' => 'Recruitment',
                'color' => '#2fa95e',
                'data' => $recruitment_series ?? [],
            ],
            [
                'name'=> 'Outgoing',
                'color' => '#f41127',
                'data'=> $outgoing_series ?? [],
            ],
        ];
        return response($data);
    }

    public function employeesFrom(Request $request){
        $sbu_id = $request->sbu_id;
        $year = $request->year;
        $first_from_date = $request->first_from_date;
        $last_to_date = $request->last_to_date;
        $employee_from = DB::table('employee_adress_details')
        ->select('divisions.name',  DB::raw('COUNT(DISTINCT employee_adress_details.ead_employee_id) as number_of_employee'))
        ->leftJoin('districts', 'employee_adress_details.permanent_district', '=', 'districts.id' ) 
        ->leftJoin('divisions', 'divisions.id', '=', 'districts.division_id' ) 
        ->leftJoin('employees', 'employees.id', '=', 'employee_adress_details.ead_employee_id') 
        ->groupBy(['divisions.id'])
        ->where('employee_adress_details.valid', '=', 1)
        ->where('employees.valid', '=', 1)
        ->where('employees.employee_status', '=', 1);
        if(!empty($sbu_id) || $sbu_id != 0){
            $employee_from = $employee_from->where('employees.employee_sbu','=', $sbu_id);
        }
        if(empty($first_from_date) && !empty($last_to_date)){
            $employee_from = $employee_from->where('employees.employee_joining_date','<=', $last_to_date);
        }
        if(!empty($first_from_date) && !empty($last_to_date)){
            $employee_from = $employee_from->whereBetween('employees.employee_joining_date', [$first_from_date, $last_to_date]);
        }
        $employee_from = $employee_from->get();
        $data['data'] = [];
        foreach ($employee_from as $key => $value) {
            if(!empty($value->name)){
                $number_of_employee = $value->name.'<br/> ('.$value->number_of_employee.')';
            }else{
                $number_of_employee = '<br/> N/A'.' ('.$value->number_of_employee.')';
            }
            $data['data'][] = [
                'name' => $number_of_employee,
                'y' => $value->number_of_employee,
            ];
        }
        $data["series"][]['data'] = $data['data'];
        return response($data);
    }

    public function todayAttendance(Request $request){
        
        $sbu_id = $request->sbu_id;
        $year = $request->year;
        $first_from_date = $request->first_from_date;
        $last_to_date = $request->last_to_date;
        if($first_from_date == date('Y-m-d') && $last_to_date == date('Y-m-d')){
            $todays = date('Y-m-d');
        }
        if(empty($first_from_date) && $last_to_date == date('Y-m-d')){
            $todays = date('Y-m-d');
        }
        // $todays=date('Y-m-d');
        // $todays=date('2022-01-01');
        $today_employees_attendance = DB::table('attendance')
                                    ->leftJoin('employees','employees.id','=','attendance.employee_id')
                                    ->select('attendance.remarks','attendance.pstatus', DB::raw('COUNT(attendance.employee_id) as today_employee_attendance'))
                                    ->where('attendance.valid', '=', 1)
                                    ->groupBy(['attendance.pstatus'])
                                    // ->groupBy(['attendance.employee_id'])
                                    ;
                                    if(!empty($sbu_id)){
                                        $today_employees_attendance = $today_employees_attendance->where('employees.employee_sbu','=', $sbu_id);
                                    }
                                    if(!empty($todays)){
                                        $today_employees_attendance = $today_employees_attendance->where('pdate', $todays);
                                    }
                                    if(!empty($first_from_date) && !empty($last_to_date)){
                                        $today_employees_attendance = $today_employees_attendance->whereBetween('pdate', [$first_from_date, $last_to_date]);
                                    }
        $today_employees_attendance =  $today_employees_attendance->get();

        // dd($today_employees_attendance);
        $data['seriesData'] = [];
       
        foreach ($today_employees_attendance as $key => $value) {
                if($value->pstatus == 1){
                    $data['seriesData'][] = [
                    'x' => 'Present',
                    'y' => $value->today_employee_attendance ?? 0,
                    'fill' => "#28a745",
                    'text' => 'P',
                    ]; 
                }else
                if ($value->pstatus == 2) {
                    $data['seriesData'][] = [
                    'x' => "Late",
                    'y' => $value->today_employee_attendance ?? 0,
                    'fill' => "#ffc107",
                    'text' => "L",
                    ]; 
                }else
                if ($value->pstatus == 3) {
                    $data['seriesData'][] = [
                        'x' => "Absent",
                        'y' =>$value->today_employee_attendance ?? 0,
                        'fill' => "#dc3545",
                        'text' => "A",
                    ]; 
                }else
                if ($value->pstatus == 6) {
                    $data['seriesData'][] = [
                    'x' => "Leave",
                    'y' => $value->today_employee_attendance ?? 0,
                    'fill' => "#007bff",
                    'text' => "LV",
                    ]; 
                }else
                if ($value->pstatus == 4) {
                    $data['seriesData'][] = [
                    'x' => "Weekend",
                    'y' => $value->today_employee_attendance ?? 0,
                    'fill' => "#343a40",
                    'text' => "W",
                    ];                    
                }else
                if ($value->pstatus == 5) {
                    $data['seriesData'][] = [
                    'x' => "Holiday",
                    'y' => $value->today_employee_attendance ?? 0,
                    'fill' => "#555657",
                    'text' => "H",
                    ]; 
                }else{
                    $data['seriesData'][] = []; 
                }                   
            }
            if(count($data['seriesData']) == 0){
                $data['seriesData'][] = [
                    'x' => "N/A",
                    'y' => 0,
                    'fill' => "#fff",
                    'text' => "No data found!",
                    ]; 
            }    
        return response($data);        
    }


    public function employeeTurnover($employee_data){
        $data['this_year'] = date('F  Y');
        $year_start_date = date('Y-m-d', strtotime('01/01'));
        $year_end_date = date('Y-m-d');
        // $year_end_date = date('Y-m-d', strtotime('12/31'));
        $total_employee = (clone $employee_data)->count();
        $data['resigned_employee'] = (clone $employee_data)->leftJoin('resignations', 'resignations.employee_id', '=', 'employees.id')->where('employee_status', 2)->whereBetween('separation_date',  [$year_start_date, $year_end_date])->count();
        $joining_start_year_employee = (clone $employee_data)->where('employee_joining_date', '>=', $year_start_date)->count();
        $joining_end_year_employee = (clone $employee_data)->whereBetween('employee_joining_date',  [$year_start_date, $year_end_date])->count();
        $average_employee = ($joining_start_year_employee + $joining_end_year_employee)/2;
        if($average_employee != 0){
            $data['to_employee'] = round(($data['resigned_employee']/$average_employee) * 100, 2);
        }else{
            $data['to_employee'] = 0;
        }
        return $data;
    }

    public function employeeAgeGroup(Request $request){
        $sbu_id = $request->sbu_id;
        $year = $request->year;
        $first_from_date = $request->first_from_date;
        $last_to_date = $request->last_to_date;
        $employee_age_group = DB::table('employee_personal_infos')
                            ->leftJoin('employees','employees.id','=','employee_personal_infos.employee_id')
                            ->select('employee_joining_date','employee_dob_certificate', 'employee_dob_actual','employee_id')
                            ->where('employee_personal_infos.valid', '=', 1)
                            // ->get()
                            ;
                            if(!empty($sbu_id) || $sbu_id != 0){
                                $employee_age_group = $employee_age_group->where('employees.employee_sbu','=', $sbu_id);
                            }
                            if(empty($first_from_date) && !empty($last_to_date)){
                                $employee_age_group = $employee_age_group->where('employees.employee_joining_date','<=', $last_to_date);
                            }
                            if(!empty($first_from_date) && !empty($last_to_date)){
                                $employee_age_group = $employee_age_group->whereBetween('employees.employee_joining_date', [$first_from_date, $last_to_date]);
                            }
        $employee_age_group = $employee_age_group->get();   
        // return response($employee_age_group);              
        $emplyAge=[];   
        foreach ($employee_age_group as $key => $value) {
            $employee_dob = isset($value->employee_dob_actual) ? $value->employee_dob_actual : '';
            if (empty($employee_dob) || $employee_dob == '0000-00-00') {
                $employee_dob = isset($value->employee_dob_certificate) ? $value->employee_dob_certificate : '';
                if ($employee_dob == 0 || $employee_dob == '0000-00-00') {
                    $employee_dob = '';
                }
            }
            $employee_dob1 = strtotime($employee_dob);
            if ($employee_dob1) {
                $bday = new DateTime($employee_dob); // Your date of birth
                $today = new Datetime(date('Y-m-d'));
                $diff = $today->diff($bday);
                $birthDates = $diff->y . '.' . $diff->m;
                $birthDates1 = $diff->y;
            } else {
                $birthDates = 'No Data!';
                $birthDates1 = 0;
            }
            $emplyAge[]=[
                'age' => $birthDates,
                'age1' => (int)$birthDates1,
                'employee_id' =>  $value->employee_id ?? 0,
                'employee_dob_actual' => $value->employee_dob_actual ?? '',
                'employee_dob_certificate' => $value->employee_dob_certificate ?? ''
            ];
        }
        $totalEmplys=collect($emplyAge)->count('employee_id');

        // return $totalEmplys;
        $data['data'] = [];
        if ($totalEmplys > 0) {
            $data['data'][0] = [
                'name' =>  "18-25Y",
                // 'y' =>  collect($emplyAge)->whereBetween('age1',[18,25])->count('employee_id'),
                'y' =>  round((((collect($emplyAge)->whereBetween('age1',[18,25])->count('employee_id') ?? 0)/$totalEmplys)*100)),
                
                'drilldown' => "18-25Y",
            ];
            $data['data'][1] = [
                'name' =>  "26-35Y",
                // 'y' => collect($emplyAge)->whereBetween('age1',[26,35])->count('employee_id'),
                'y' => round((((collect($emplyAge)->whereBetween('age1',[26,35])->count('employee_id') ?? 0)/$totalEmplys)*100)),
                'drilldown' => "26-35Y"
            ];
            
            $data['data'][2] = [
                'name' =>  "36-45Y",
                'y' => collect($emplyAge)->whereBetween('age1',[36,45])->count('employee_id'),
                'y' => round((((collect($emplyAge)->whereBetween('age1',[36,45])->count('employee_id') ?? 0)/$totalEmplys)*100)),
                'drilldown' => "36-45Y"
            ];

            $data['data'][3] = [
                'name' =>  "46-55Y",
                // 'y' => collect($emplyAge)->whereBetween('age1',[46,55])->count('employee_id'),
                'y' => round((((collect($emplyAge)->whereBetween('age1',[46,55])->count('employee_id') ?? 0)/$totalEmplys)*100)),
                'drilldown' => "46-55Y"
            ];

            $data['data'][4] = [
                'name' =>  "56-60Y",
                // 'y' => collect($emplyAge)->whereBetween('age1',[56,60])->count('employee_id'),
                'y' => round((((collect($emplyAge)->whereBetween('age1',[56,60])->count('employee_id') ?? 0)/$totalEmplys)*100)),
                'drilldown' => "56-60Y"
            ];

            $data['data'][5] = [
                'name' =>  "60+ Y",
                // 'y' =>collect($emplyAge)->where('age1','>',60)->count('employee_id'),
                'y' => round((((collect($emplyAge)->where('age1','>',60)->count('employee_id') ?? 0)/$totalEmplys)*100)),
                'drilldown' => "60+ Y"
            ];
        }
        // else{
        //     $data['data'][0] = [
        //         'name' =>  "No data found!",
        //         'y' =>  0,
        //         'drilldown' => "N/A",
        //     ];
        // }    
        $data["series"][]['data'] = $data['data'];
        return response($data);
    }
    public function headcountToday(Request $request){
        $data['headcount_today'] = DB::table('employees')
                    ->select('departments.department_name', DB::raw('COUNT(employees.id) as number_of_emplyee'))
                    ->leftJoin('departments', 'employees.employee_department', '=', 'departments.id')
                    ->groupBy('departments.department_name')
                    ->where('employees.valid', '=', 1)
                    ->where('employees.employee_status', '=', 1)
                    ->get();
                    return $data;
                    // return response($data);
    }

    public function employeesGender(Request $request){
         $sbuid = $request->sbuid;
         $employee_by_gender = DB::table('employee_personal_infos')
                                    ->select('employee_gender', DB::raw('COUNT(employee_personal_infos.id) as number_of_emplyee'))
                                    ->where('employee_personal_infos.valid', '=', 1)
                                     // ->when($employee_by_gender, function ($sbuid) {
                                     //    if(!empty($sbuid)){
                                     //        ->where('employees.employee_fullname', 'LIKE', '%' . $search_key . '%');
                                     //    }
                                    // })
                                    ->groupBy('employee_personal_infos.employee_gender')
                                    ->get();
        $data['male_emplyee'] = collect($employee_by_gender)->where('employee_gender',2)->first()->number_of_emplyee ?? 0;
        $data['fmale_emplyee'] = collect($employee_by_gender)->where('employee_gender',1)->first()->number_of_emplyee ?? 0;

        return response($data);
    }

    public function employeesType(Request $request){
        $sbu_id = $request->sbu_id;
        $year = $request->year;
        $first_from_date = $request->first_from_date;
        $last_to_date = $request->last_to_date;
        // $sbuid=$request->sbuid;
        $employee_by_type = DB::table('employees')
                            ->select(
                                'employee_joining_date',
                                'employee_type', 
                                DB::raw('COUNT(DISTINCT employees.id) as number_of_emplyee_type')
                            )
                            ->where('employees.valid', '=', 1)
                            ->where('employees.employee_status', '=', 1)
                            ->groupBy(['employees.employee_type']);
                            if(!empty($sbu_id)){
                                $employee_by_type = $employee_by_type->where('employees.employee_sbu','=', $sbu_id);
                            }
                            if(empty($first_from_date) && !empty($last_to_date)){
                                $employee_by_type = $employee_by_type->where('employees.employee_joining_date','<=', $last_to_date);
                            }
                            if(!empty($first_from_date) && !empty($last_to_date)){
                                $employee_by_type = $employee_by_type->whereBetween('employees.employee_joining_date', [$first_from_date, $last_to_date]);
                            }
        $employee_by_type = $employee_by_type->get();

        $data['seriesData'] = [];
            foreach ($employee_by_type as $key => $value) {
                if($value->employee_type == 1){
                    $data['seriesData'][] = [
                        'x' =>'Permanent',
                        'y' => $value->number_of_emplyee_type,
                        'fill' => '#2fa95e',
                        'text' => 'Perm.',
                    ];
                }elseif ($value->employee_type == 2) {
                   $data['seriesData'][] = [
                        'x' => 'Probationary',
                        'y' => $value->number_of_emplyee_type,
                        'fill' => '#9399ff',
                        'text' => 'Prob.',
                    ];
                }elseif ($value->employee_type == 3) {
                   $data['seriesData'][] = [
                        'x' => 'Cotractual',
                        'y' => $value->number_of_emplyee_type,
                        'fill' => '#fd7e14',
                        'text' => 'Cont.',
                    ];
                }elseif ($value->employee_type == 4) {
                    $data['seriesData'][] = [
                        'x' => 'Casual',
                        'y' => $value->number_of_emplyee_type,
                        'fill' => '#ffc107',
                        'text' => 'Casu',
                    ];
                }elseif ($value->employee_type == 5) {
                    $data['seriesData'][] = [
                        'x' => 'Temporary',
                        'y' => $value->number_of_emplyee_type,
                        'fill' => '#ee14e0',
                        'text' => 'Temp',
                    ];
                }elseif ($value->employee_type == 6) {
                    $data['seriesData'][] = [
                        'x' => 'Intern',
                        'y' => $value->number_of_emplyee_type,
                        'fill' => '#0fcfa5',
                        'text' => 'Intern',
                    ];
                }else{
                   $data['seriesData'][] = [
                        'x' => 'N/A',
                        'y' => $value->number_of_emplyee_type,
                        'fill' => '#000',
                        'text' => 'N/A',
                    ];
                }
        }

        return response($data);
    }

    public function employeeBloodGroup($sbu_id = null, $first_from_date = null, $last_to_date = null){
         // $data['employee_blood_group'] = DB::table('employees')
        //  return [$sbu_id, $first_from_date, $last_to_date];
        $employee_blood_group = DB::table('employees')
            ->leftJoin('employee_personal_infos', 'employees.id', '=', 'employee_personal_infos.employee_id')
            ->select('employees.employee_joining_date','employee_personal_infos.employee_blood_group', DB::raw('COUNT(employees.id) as number_of_emplyee'))
            ->where('employees.valid', '=', 1)
            ->where('employees.employee_status', '=', 1)
            ->where('employee_personal_infos.employee_blood_group', '!=', '')
            ->where('employee_personal_infos.employee_blood_group', '!=', '0')
            ->groupBy(['employee_personal_infos.employee_blood_group'])
            ->orderBy('employee_personal_infos.employee_blood_group','ASC');
        if(!empty($sbu_id)){
            $employee_blood_group = $employee_blood_group->where('employees.employee_sbu','=', $sbu_id);
        }
        if(empty($first_from_date) && !empty($last_to_date)){
            $employee_blood_group = $employee_blood_group->where('employees.employee_joining_date','<=', $last_to_date);
        }
        if(!empty($first_from_date) && !empty($last_to_date)){
            $employee_blood_group = $employee_blood_group->whereBetween('employees.employee_joining_date', [$first_from_date, $last_to_date]);
        }
        $employee_blood_group = $employee_blood_group->get();
        $total_emp_blood_group = collect($employee_blood_group)->sum('number_of_emplyee');
        $employee_blood_glist = [];
        $data['total_emp_blood_group'] = 0;
        foreach ($employee_blood_group as $key => $value) {
            $number_of_employee = $value->number_of_emplyee ?? 0;
            if(!empty($number_of_employee)){
                $percentage = round(($number_of_employee/$total_emp_blood_group)*100, 2);
            }else{
                $percentage = 0;
            }
            // $percentage = $number_of_employee/$total_emp_blood_group;
            $data['total_emp_blood_group'] += $number_of_employee;
            $employee_blood_glist[] = [
                // 'id' => $value->employee_id,
                'text' => $value->employee_blood_group ?? "N/A",
                'numbers' =>  $number_of_employee,
                'percentage' =>  $percentage,
            ];
        }
        return $employee_blood_glist;
    }
    

    public function jobConfirmationDueList(Request $request){
        $data['confirmation_due_list'] = DB::table('employees')
        ->select('employee_personal_infos.employee_blood_group',
            DB::raw('COUNT(employees.id) as number_of_emplyee')
        )
        ->leftJoin('employee_personal_infos', 'employees.id', '=', 'employee_personal_infos.employee_id')
        ->where('employees.valid', '=', 1)
        ->where('employees.employee_status', '=', 1)
        ->groupBy('employee_personal_infos.employee_blood_group')
        ->orderBy('employee_personal_infos.employee_blood_group','ASC')
        ->get();   
        return response($data);                    
    }
   

    // public function recruitmentOutgoing(Request $request){

    // }

    // public function employeeAgeGroup(Request $request){

    // }

  

    public function upcomingEvent(Request $request){
        $date = date('Y-m-d');
        $paginate_num = $request->input('paginate_num') ?? 3;
        $order = $request->input('order') ?? 'DESC';
        $sort = $request->input('sort') ?? 'id';
        $data['paginate_data'] = DB::table('notices')->select('notice_title', DB::raw('DATE_FORMAT(notice_sdate, "%d-%b-%Y") as notice_sdate'))
        ->where('valid', '=', 1)->where('notice_sdate', '>=', $date)->orderBy($sort,$order)->paginate($paginate_num);
        return response()->json($data);
    }

    // public function unitWiseEmployeeSalary(Request $request){

    // }

    

    public function indexOld(Request $request)
    {
        $cache = Cache::get('permission');
        $permission = collect($cache)->where('menu_uid', '=', 'PerformanceEvaluation')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
        foreach ($permission as $child) {
            if ($child['link_uid'] == 'add') {
                $data['add'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'edit') {
                $data['edit'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'delete') {
                $data['delete'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'self') {
                $data['self'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'others') {
                $data['others'] = $child['link_uid'];
            } else {
                $data['approve'] = $child['link_uid'];
            }
        }
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        $employee_id = $employee_ids['employee_id'];
        $paginate_data = Employee::valid()->project()
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->select('employees.*', 'company_sbus.sbu_name', 'departments.department_name', 'employees.id as id', 'employees.id as employee_id', 'employees.employee_id_no', 'employees.employee_fullname', 'designations.designation_name')
            ->when($search_key, function ($query, $search_key) {
                $query->where(function ($query2) use ($search_key) {
                    $query2->where('employees.employee_fullname', 'LIKE', '%' . $search_key . '%');
                });
                return $query;
            })->whereIn('employees.id', $employee_id);
        $sortData = $paginate_data;
        $data['paginate_data'] = $sortData->paginate(5);

        if (!empty(Auth::guard('user')->user())) {
            $id = Auth::guard('user')->user()->id;
        } else {
            return redirect('/');
        }
        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        $employee_id = $employee_ids['employee_id'];

        $employeeAlls = Employee::valid()->project()->whereIn('id', $employee_id)->get();
        $employeesCounts = collect(collect($employeeAlls)->pluck('employee_designation')->unique()->values('employee_designation')->all())->toArray();
        $data['company_count'] = count($employee_ids['sub']);
        $data['department_count'] = count($employee_ids['department']);
        $data['designation_count'] = count($employeesCounts);
        $data['employee_count'] = count(collect(collect($employeeAlls)->where('employee_status', 1)->pluck('id')->unique()->values('id')->all())->toArray());
        $data['inactive_employee_count'] = count(collect(collect($employeeAlls)->where('employee_status', 0)->pluck('id')->unique()->values('id')->all())->toArray());
        $data['resign_semployee_count'] = count(collect(collect($employeeAlls)->where('employee_status', 2)->pluck('id')->unique()->values('id')->all())->toArray());
        $data['permanent_emp'] = count(collect(collect($employeeAlls)->where('employee_type', 1)->pluck('id')->unique()->values('id')->all())->toArray());
        $data['probationary_emp'] = count(collect(collect($employeeAlls)->where('employee_type', 2)->pluck('id')->unique()->values('id')->all())->toArray());
        $data['contractual_emp'] = count(collect(collect($employeeAlls)->where('employee_type', 3)->pluck('id')->unique()->values('id')->all())->toArray());
        $data['temporary_emp'] = count(collect(collect($employeeAlls)->where('employee_type', 4)->pluck('id')->unique()->values('id')->all())->toArray());
        $data['intern_emp'] = count(collect(collect($employeeAlls)->where('employee_type', 5)->pluck('id')->unique()->values('id')->all())->toArray());

        /* Attendance Data Finding */
        $emaploeeAttendall = DB::table('attendance')->whereMonth('pdate', date('m'))->whereYear('pdate', date('Y'))->get()->toArray();
        $data['present_emp'] = count(collect(collect($emaploeeAttendall)->where('pstatus', 1)->pluck('id')->unique()->values('id')->all())->toArray());
        $data['late_emp'] = count(collect(collect($emaploeeAttendall)->where('pstatus', 2)->pluck('id')->unique()->values('id')->all())->toArray());
        $data['absent_emp'] = count(collect(collect($emaploeeAttendall)->where('pstatus', 3)->pluck('id')->unique()->values('id')->all())->toArray());
        $data['leave_emp'] = count(collect(collect($emaploeeAttendall)->where('pstatus', 6)->pluck('id')->unique()->values('id')->all())->toArray());
        $data['weekend_day'] = count(collect(collect($emaploeeAttendall)->where('pstatus', 4)->pluck('id')->unique()->values('id')->all())->toArray());
        $data['holiday_day'] = count(collect(collect($emaploeeAttendall)->where('pstatus', 5)->pluck('id')->unique()->values('id')->all())->toArray());
        return response($data);
    }

    public function activityLog(Request $request)
    {
        $cache = Cache::get('permission');
        $permission = collect($cache)->where('menu_uid', '=', 'activityLog')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
        foreach ($permission as $child) {
            if ($child['link_uid'] == 'add') {
                $data['add'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'edit') {
                $data['edit'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'delete') {
                $data['delete'] = $child['link_uid'];
            } else {
                $data['approve'] = $child['link_uid'];
            }
        }
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $project_id = Auth::guard('user')->user()->project_id;
        $branch_id = Auth::guard('user')->user()->branch_id;

        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        $employee_id = $employee_ids['employee_id'];

        $paginate_data = DB::table('activity_log')
        ->when($search_key, function ($query, $search_key) {
            $query->where(function ($query2) use ($search_key) {
                $query2->where('user_name', 'LIKE', '%'.$search_key.'%');
                $query2->orWhere('employee_id', 'LIKE', '%'.$search_key.'%');
                $query2->orWhere('log_name', 'LIKE', '%'.$search_key.'%');
            });
            return $query;
        })->whereIn('created_by', $employee_id)->orderBy($sort, $order)->paginate($paginate_num);
        $data['paginate_data'] = $paginate_data;
        return response()->json($data);
    }

    public function employee_joining()
    {
        if (!empty(Auth::guard('user')->user())) {
            $id = Auth::guard('user')->user()->id;
        } else {
            return redirect('/');
        }

        $employeeJoining = array();
        for ($i = 1; $i <= 12; $i++) {
            $employeeJoining[] = Employee::valid()->project()
                ->whereYear('employee_joining_date', '=', date('Y'))
                ->whereMonth('employee_joining_date', '=', date($i))
                ->count();
        }
        $data['employee_joining_data'] = $employeeJoining;

        $employeeResign = array();
        for ($i = 1; $i <= 12; $i++) {
            $employeeResign[] = Employee::valid()->project()
                ->whereYear('emplyee_resign_date', '=', date('Y'))
                ->whereMonth('emplyee_resign_date', '=', date($i))
                ->count();
        }
        $data['employee_resigning_data'] = $employeeResign;
        return response($data);
    }

    public function find_widget_list()
    {
        // $user_id = Auth::guard('user')->user()->id;
        $data['dashboard_widget_list'] = DashboardSettingModel::valid()->project()->where('status', 1)->get();
        return response($data);
    }

    public function dashboardUpdate(Request $request)
    {
        // return response('ss');
        $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
        return response($message);
    }

    public function performance_evaluation($employee_id = false)
    {
        if (!empty(Auth::guard('user')->user())) {
            $id = Auth::guard('user')->user()->id;
        } else {
            return redirect('/');
        }
        $employee_data = Employee::valid()->project()
            ->leftJoin('employees as emp_reporting', 'emp_reporting.employee_id_no', '=', 'employees.employee_reporting_to')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->leftJoin('sub_sections', 'sub_sections.id', '=', 'employees.employee_section')
            ->leftJoin('employee_groups', 'employee_groups.id', '=', 'employees.employee_section')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->select(
            'employees.*',
            'emp_reporting.employee_fullname as reporting_name',
            'emp_reporting.id as reporting_id',
            'company_sbus.sbu_name',
            'sections.section_name',
            'sub_sections.sub_section_name',
            'employee_groups.employee_group_name',
            'departments.department_name',
            'designations.designation_name',
            'sub_units.sub_unit_name',
            'work_locations.work_location_name'
            )->where('employees.id', $employee_id)->first();
        if ($employee_data->employee_reporting_to) {
            $data_return['supervisor_designation'] = Employee::valid()->project()->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')->select('employees.id', 'employees.employee_id_no', 'employees.employee_fullname', 'designations.designation_name')->where('employees.employee_id_no', $employee_data->employee_reporting_to)->first();
        } else {
            $data_return['supervisor_designation'] = '';
        }
        $supervisors = EmployeeApproval::valid()->project()
            ->select('employee_approvals.*', 'employee_approvals.ea_approval_lavel as indexid', 'employees.employee_id_no as employees_ids', 'employees.employee_fullname as ea_approve_by_name', 'designations.designation_name')
            ->leftJoin('employees', 'employee_approvals.ea_approve_by', '=', 'employees.id')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->where('ea_employee_id', $employee_id)->where('ea_approval_lavel', 2)->get();
        $data_return['employee_data'] = $employee_data;
        $data_return['supervisors'] = $supervisors;
        // Performance Assessment Form Data
        $task = MOS::leftJoin('user_m_os', 'user_m_os.mos_id', '=', 'm_o_s.id')->Join('k_r_a_s', 'k_r_a_s.id', '=', 'user_m_os.kra_id');
        $task->select('m_o_s.*', 'user_m_os.emp_id','user_m_os.supervisors_marks','user_m_os.kra_id');
        $task->orderBy('m_o_s.kra_id', 'ASC');
        $task->orderBy('m_o_s.kpi_id', 'ASC');
        $task->orderBy('m_o_s.id', 'ASC');
        if ($employee_id) {
            $task->where('emp_id', $employee_id);
            $task->where('k_r_a_s.assessment_part', 1);
        }
        $result  = $task->with('mosuserachievementjoin')
            ->with('mosachievementjoin')
            ->with('mostargetjoin')
            ->with('krajoin')
            ->with('kpijoin')
            ->get();
        $data_return['mos_data']  = $result;
        // Competency Assessment Form Data
        $task1 = MOS::leftJoin('user_m_os', 'user_m_os.mos_id', '=', 'm_o_s.id')->leftJoin('k_r_a_s', 'k_r_a_s.id', '=', 'user_m_os.kra_id');
        $task1->select('m_o_s.*', 'user_m_os.emp_id','user_m_os.supervisors_marks','user_m_os.kra_id');
        $task1->orderBy('m_o_s.kra_id', 'ASC');
        $task1->orderBy('m_o_s.kpi_id', 'ASC');
        $task1->orderBy('m_o_s.id', 'ASC');
        $task1->where('k_r_a_s.assessment_part', 2);
        if ($employee_id) {
            $task1->where('emp_id', $employee_id);
        }
        // dd($task1);
        $result1  = $task1->with('mosuserachievementjoin')
            ->with('mosachievementjoin')
            ->with('mostargetjoin')
            ->with('krajoin')
            ->with('kpijoin')
            ->get();
        $data_return['mos_data1']  = $result1;

        // dd($task1);
        // Talent assessment Form Data
        $task2 = MOS::leftJoin('user_m_os', 'user_m_os.mos_id', '=', 'm_o_s.id')->Join('k_r_a_s', 'k_r_a_s.id', '=', 'user_m_os.kra_id');
        $task2->select('m_o_s.*', 'user_m_os.emp_id','user_m_os.supervisors_marks','user_m_os.kra_id');
        $task2->orderBy('m_o_s.kra_id', 'ASC');
        $task2->orderBy('m_o_s.kpi_id', 'ASC');
        $task2->orderBy('m_o_s.id', 'ASC');
        if ($employee_id) {
            $task2->where('emp_id', $employee_id);
            $task2->where('k_r_a_s.assessment_part', 4);
        }
        $result2  = $task2->with('mosuserachievementjoin')
            ->with('mosachievementjoin')
            ->with('mostargetjoin')
            ->with('krajoin')
            ->with('kpijoin')
            ->get();
        // dd($result2);
        $data_return['mos_data2']  = $result2;
        return response()->json(ResponseUtil::makeResponse('K P I S retrieved successfully', $data_return));
    }

    public function store_performance_assessment(Request $request){
        // return response($request->val );
        $step = '';
        if($request->val==3 || 5){
            $data['ev_comments_date']=date('Y-m-d'); 
            $data['compentency_comments1']= isset($request->compentency_comments1) ? $request->compentency_comments1 : '';
            $data['compentency_comments2']= isset($request->compentency_comments2) ? $request->compentency_comments2 : '';
            $data['compentency_suggestions1']= isset($request->compentency_suggestions1) ? $request->compentency_suggestions1 : '';
            $data['compentency_suggestions2']= isset($request->compentency_suggestions2) ? $request->compentency_suggestions2 : '';
            $data['supervisors_rec_status']= isset($request->supervisors_rec_status) ? $request->supervisors_rec_status : '';
            $data['supervisors_rec_comment']= isset($request->supervisors_rec_comment) ? $request->supervisors_rec_comment : '';
            $data['hr_rec_status']= isset($request->hr_rec_status) ? $request->hr_rec_status : '';
            $data['hr_rec_comment']= isset($request->hr_rec_comment) ? $request->hr_rec_comment : '';
            $get_evaluation_data = EvaluationCommentsSuggestions::valid()->where('employee_id', $request->employee_id)->get(); 
            if(count($get_evaluation_data)>0){
                $data['updated_at']=date('Y-m-d H:i:s'); 
                $data['updated_by']=Auth::guard('user')->user()->id;
                $save_data = DB::table('evaluation_comments_suggestions')->where('employee_id', $request->employee_id)->update($data);
            }else{
                $data['employee_id']=$request->employee_id;
                $data['created_at']=date('Y-m-d H:i:s'); 
                $data['created_by']=Auth::guard('user')->user()->id; 
                $save_data = DB::table('evaluation_comments_suggestions')->insert($data);
            }
        }else{
            $allData=$request->all();
            $step=collect($allData)->where('id','step')->first()['val'];  
            $filterAllData = collect($allData)->where('id','!=','step')->where('id','!=','_token')->toArray();
        }
        if($step==1){
            foreach($filterAllData as $key => $value) {
                $data['updated_at']=date('Y-m-d H:i:s'); 
                $data['updated_by']=Auth::guard('user')->user()->id; 
                $data['supervisors_marks']=$value['supervisors_marks'];
                $save_data = DB::table('user_m_os')->where('mos_id', $value['id'])->where('emp_id', $value['emp_id'])->update($data);
            }
        }elseif($step==2){
            foreach($filterAllData as $key => $value) {
                $data['updated_at']=date('Y-m-d H:i:s'); 
                $data['updated_by']=Auth::guard('user')->user()->id; 
                $data['supervisors_marks']=$value['supervisors_marks'];
                $save_data = DB::table('user_m_os')->where('mos_id', $value['id'])->where('emp_id', $value['emp_id'])->update($data);
            }
        }elseif($step==4){
            foreach($filterAllData as $key => $value) {
                $data['updated_at']=date('Y-m-d H:i:s'); 
                $data['updated_by']=Auth::guard('user')->user()->id; 
                $data['supervisors_marks']=$value['supervisors_marks'];
                $save_data = DB::table('user_m_os')->where('mos_id', $value['id'])->where('emp_id', $value['emp_id'])->update($data);
            }
        }
        if($save_data){
            $message=['status' => 1, 'message' => 'Successfully updated.'];
        }else{
            $message=['status' => 0, 'message' => 'Oops! Something went worng.'];
        }
        return response($message);
    }


    public function find_unreadNotifications($employee_id){
        $data['get_leave_application'] = LeaveApplication::valid()->project()
        ->leftJoin('leave_approval', 'leave_applications.id', '=', 'leave_approval.leave_apply_id')
        // ->where('leave_approve_by', $employee_id)
        ->where('leave_approve_by', 2026)
        ->whereIn('leave_approve_status', [1, 3])
        ->count();

        $data['get_late_application'] = LateRequest::valid()->project()
        ->leftJoin('late_request_approvals', 'late_approve_requests.id', '=', 'late_request_approvals.late_request_id')
        // ->where('late_approve_by', $employee_id)
        ->where('late_approve_by', 2026)
        ->whereIn('late_request_approvals.late_approve_status', [1, 3])
        ->count();

        $data['get_manual_attendance'] = ManualAttendance::valid()->project()
        ->leftJoin('manual_attendances_approval', 'manual_attendances.id', '=', 'manual_attendances_approval.manual_atten_id')
        // ->where('manual_atten_approve_by', $employee_id)
        ->where('manual_atten_approve_by', 2026)
        ->whereIn('manual_attendances_approval.manual_atten_approve_status', [1, 3])
        ->count();

        $data['get_service_requests'] = ServiceRequest::valid()->project()
        ->leftJoin('service_request_approvals', 'service_requests.id', '=', 'service_request_approvals.service_request_id')
        // ->where('manual_atten_approve_by', $employee_id)
        ->where('service_approve_by', 2026)
        ->whereIn('service_request_approvals.approve_status', [1,3])
        ->count();

        $data['get_stationery_services'] = DB::connection('mysql2')->table('hr_stationary_summary')
        ->where('employee_reporting_id', 2026)
        ->where('status', 1)
        ->count();

        $data['summary_data'] = count($data);
        return response($data);
    }
}
