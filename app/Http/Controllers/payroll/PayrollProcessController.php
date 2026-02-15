<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
// use Session;
use App\Model\NoticeModel;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\Section;
use App\Model\SubSection;
use App\Model\EmployeeGroup;
use App\Model\Department;
use App\Model\Designation;
use App\Model\JobGrade;
use App\Model\SubUnit;
use App\Model\UnitModel;
use App\Model\WorkLocation;
use App\Model\NoticePermission;
// use App\Model\Attendance;
// use App\Model\AttendanceSetup;
// use App\Model\EmployeeBankAccountDetail;
// use App\Model\OfficeTimeSetup;
// use App\Model\payroll\GradeSetting;
use App\Model\payroll\Salary;
use App\Model\payroll\TaxSetting;
use App\Model\payroll\PayrollPermission;
use App\Model\payroll\ProvidentFund;
use App\Model\payroll\LoanTransaction;
use App\Model\payroll\PayrollList;
use App\Model\payroll\PayrollProcessList;
use Cache;
// use permission;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateInterval;
use Illuminate\Support\Arr;

// use DatePeriod;

// use App\Model\UserRoleAccess;

class PayrollProcessController extends Controller
{
    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */

    public function index(Request $request)
    {
        // $cache=Cache::get('permission');
        // $permission=collect($cache)->where('menu_uid', '=', 'ShiftingSetup')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
        // foreach ($permission as $child) {
        //     if ($child['link_uid']=='add') {
        //         $data['add']=$child['link_uid'];
        //     } elseif ($child['link_uid']=='edit') {
        //         $data['edit']=$child['link_uid'];
        //     } elseif ($child['link_uid']=='delete') {
        //         $data['delete']=$child['link_uid'];
        //     } else {
        //         $data['approve']=$child['link_uid'];
        //     }
        // }
        // $project_id=Auth::guard('user')->user()->project_id;
        // $paginate_num = $request->input('paginate_num');
        // $search_key = $request->input('search_key');
        // $order = $request->input('order');
        // $sort = $request->input('sort');
        $employee_list = new Employee();
        // $employee_ids=$employee_list->Employee_id();
        // $employee_id=$employee_ids['employee_id'];


        $payroll_permissions=PayrollPermission::valid()->project()->whereIn('id', ['2','3'])->get();
        $data['payroll_permissions']=array();
        foreach ($payroll_permissions as $value) {
            array_push($data['payroll_permissions'], ['id'=>$value['id'],'text'=>$value['permission_group']]);
        }
        // $company_sbu_data=CompanySbu::valid()->project()->whereIn('id',$employee_ids['sub'])->get();
        // foreach ($company_sbu_data as $value) {
        //   array_push($data['company_sbu_data'],['id'=>$value['id'],'text'=>$value['sbu_name']]);
        // }
        $data['approval_infos']=['0' =>['id'=>0,'permission_type'=>'','permission_id'=>'']];

        $present_year = date('Y');
        // $previous_year =
        if(date('m', strtotime('-1 months')) == '12'){
            $previous_year = date('Y', strtotime('-1 years'));
        }
        if(date('m', strtotime('-2 months')) == '11'){
            $previous_year = date('Y', strtotime('-1 years'));
        }else{
            $previous_year = date('Y', strtotime('-0 years'));
        }
        $data['months_array']=[];
        array_push($data['months_array'],
        [
            'id' => date('m', strtotime('-2 months')),
            'text' => date('F', strtotime('-2 months')).'-'.$previous_year
        ]);

        array_push($data['months_array'],
        [
            'id'=>date('m', strtotime('-1 months')),
            'text'=>date('F', strtotime('-1 months')).'-'.$previous_year
        ]);
        array_push($data['months_array'],
        [
            'id'=>date('m'),
            'text'=>date('F').'-'.$present_year
        ]);
        array_push($data['months_array'],
        [
            'id'=>date('m', strtotime('+1 months')),
            'text'=>date('F', strtotime('+1 months')).'-'.$present_year
        ]);
        array_push($data['months_array'],
        [
            'id'=>date('m', strtotime('+2 months')),
            'text'=>date('F', strtotime('+2 months')).'-'.$present_year
        ]);
        $payrollPermissionassing=collect(DB::table('payroll_permissions_assign')->where('employee_id', Auth::guard('user')->user()->employee_id)->where('valid', 1)->get())->pluck('assign_id')->toArray();
        $data['payrollPermissions']=array();
        $payrollPermission=PayrollPermission::valid()->project()->whereIn('id', $payrollPermissionassing)->get();
        foreach ($payrollPermission as $value) {
            array_push($data['payrollPermissions'], ['id'=>$value['id'],'text'=>$value['permission_group']]);
        }
        // $data['AllcompanySbuData']=$employee_list->report_filter_data()['Allcompany_sbu_data'];
        $data['company_sbu_data']=$employee_list->report_filter_data()['company_sbu_data'];
        // $data['AllsectionData']=$employee_list->report_filter_data()['Allsection_data'];
        // $data['section_data'] = $employee_list->report_filter_data()['section_data'];
        // $data['AllsubSectionData']=$employee_list->report_filter_data()['Allsub_section_data'];
        // $data['sub_section_data'] = $employee_list->report_filter_data()['sub_section_data'];
        // $data['AllsubUnitData']= $employee_list->report_filter_data()['Allsub_unit_data'];
        // $data['sub_unit_data'] = $employee_list->report_filter_data()['sub_unit_data'];
        // $data['AllunitData']= $employee_list->report_filter_data()['Allunit_data'];
        // $data['unit_data'] = $employee_list->report_filter_data()['unit_data'];
        // $data['AllworkLocationData']= $employee_list->report_filter_data()['Allwork_location_data'];
        // $data['work_location_data'] = $employee_list->report_filter_data()['work_location_data'];
        // $data['AlldepartmentData']=$employee_list->report_filter_data()['Alldepartment_data'];
        $data['department_data'] =$employee_list->report_filter_data()['department_data'];
        // $data['AllemployeeData']=$data['employee_data'] = $employee_list->report_filter_data()['employee_data'];

        $data['employee_data'] = $employee_list->report_filter_data()['employee_data'];

        $data['AllcompanySbuData']=array();
        $data['AllsectionData']=array();
        $data['section_data']=array();
        $data['AllsubSectionData']=array();
        $data['sub_section_data']=array();
        $data['sub_unit_data']=array();
        $data['AllsubUnitData']=array();
        $data['unit_data']=array();
        $data['AllworkLocationData']=array();
        $data['work_location_data']=array();
        $data['AlldepartmentData']=array();
        $data['AllemployeeData']=array();

        $data['salary_type_id'] = 1;
        $data['jobgrade_data']=array();
        $jobgrade_data=JobGrade::valid()->project()->get();
        foreach ($jobgrade_data as $value) {
            array_push($data['jobgrade_data'], ['id'=>$value['id'],'text'=>$value['jobgrade_name']]);
        }
        return response()->json($data);
    }

    public function payrollprocess_fiends(Request $request)
    {


        // dd($fridays);
        // dd($request);
        // ini_set('memory_limit', '2G');
        if($request->months_id == '12'){
            $this_year = date('Y', strtotime('-1 years'));
        }
        elseif($request->months_id == '11'){
            $this_year = date('Y', strtotime('-1 years'));
        }else{
            $this_year = date('Y');
        }
        // if($this_year != date('Y')){
        //     $this_year = date('Y');
        // }
        $fist_date_of_month = $this_year.'-'.$request->months_id.'-'.'01';
        $dt = date_create($fist_date_of_month);
        $dt->modify('last day of this month');
        $last_date_of_month = date_format($dt, "Y-m-d");
        $mgt_non_mgt = $request->emplyee_category_mgt_non_mgt;

        // dd($fist_date_of_month, $last_date_of_month);

        if (!empty($request->from_date)) {
            $fist_date_of_month = date('Y-m-d', strtotime($request->from_date));
        }
        if (!empty($request->to_date)) {
            $last_date_of_month = date('Y-m-d', strtotime($request->to_date));
        }
        $datediff = abs(strtotime($last_date_of_month) - strtotime($fist_date_of_month));
        $total_month_day =  round($datediff / (60 * 60 * 24)) + 1;

        $section_id_pluck = collect($request->section_id)->pluck('id')->toArray();
        $subsection_id_pluck = collect($request->sub_section_id)->pluck('id')->toArray();
        $unit_id_pluck = collect($request->unit_id)->pluck('id')->toArray();
        $sub_unit_id_pluck = collect($request->sub_unit_id)->pluck('id')->toArray();
        $department_id_pluck = collect($request->department_id)->pluck('id')->toArray();
        $employee_work_location_id_pluck = collect($request->employee_work_location)->pluck('id')->toArray();
        $employeeId_pluck = collect($request->employeeId)->pluck('id')->toArray();
        $jobgrade_name_value_pluck = collect($request->jobgrade_name_value)->pluck('id')->toArray();

        // dd($request);
        $payrollPermission = PayrollPermission::valid()->project()
        ->where('id', $request['salary_grade'])->first();
        $jobGrade = array();
        if (!empty($payrollPermission)) {
            for ($x = $payrollPermission['permission_grade_start']; $x <= $payrollPermission['permission_grade_end']; $x++) {
                $jobGrade[] = $x;
            }
        }

        $emplyId = Employee::where('employees.employee_status', 1)->where('employees.employee_sbu', $request->id);

        if (!empty($department_id_pluck)) {
            $emplyId->whereIn('employees.employee_department', $department_id_pluck);
        }
        if (!empty($employee_work_location_id_pluck)) {
            $emplyId->whereIn('employee_work_location', $employee_work_location_id_pluck);
        }
        if (!empty($unit_id_pluck)) {
            $emplyId->whereIn('employee_unit', $unit_id_pluck);
        }
        if (!empty($sub_unit_id_pluck)) {
            $emplyId->whereIn('employee_sub_unit', $sub_unit_id_pluck);
        }
        if (!empty($section_id_pluck)) {
            $emplyId->whereIn('employee_section', $section_id_pluck);
        }

        if (!empty($subsection_id_pluck)) {
            $emplyId->whereIn('employee_sub_section', $subsection_id_pluck);
        }
        $emplyIds = $emplyId->pluck('id')->toarray();

        $resignationsEmpId = DB::table('resignations')->where('resignation_status', 2)
        // ->where('effective_date', '>=', $fist_date_of_month)
        ->where('effective_date', '>=', $last_date_of_month)
        ->pluck('employee_id')->toarray();

        // return response($last_date_of_month);
        $allemplyid = array_merge($emplyIds, $resignationsEmpId);

        // dd($allemplyid);

        $payrolInfo = Salary::valid()
        ->leftJoin('employees', 'employees.id', '=', 'salaries.employee_id')
        ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
        ->leftJoin('employee_bank_account_details', 'employee_bank_account_details.ebc_employee_id', '=', 'employees.id')
        ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
        ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
        ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
        ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
        ->select('salaries.*', 'employees.employee_section', 'salary_duration_type','employee_bank_account_details.ebc_employee_id',
            'employee_bank_account_details.status as ebc_status','salaries.salary_goes_to',
            'employees.*',
            'company_sbus.sbu_name',
            'company_sbus.sbu_short_name',
            'job_grades.jobgrade_name',
            'employee_bank_account_details.ebc_account_number',
            'employee_personal_infos.employee_gender',
            'employee_personal_infos.employee_dob_certificate',
            'designations.designation_name',
            'departments.department_name',
            'work_locations.work_location_name'
         )
        ->where('confirmation_date', '<=', $last_date_of_month)
        // ->where('employees.salary_duration_type',2) // 1 = weekly, 2 = Monthly
        //  ->whereDate('trns_date', '>=', $fist_date_of_month)
        // ->whereDate('trns_date', '<=', $last_date_of_month)
        ->where('salary_sbu_id', $request->id)
        ->whereIn('salaries.type', [1, 2]) // 1 = Salary, 2 = Increment
        ->where('salaries.gross_salary', '!=', '0')

        // ->whereIn('employee_job_grade', $jobGrade)
        ->whereIn('employees.id', $allemplyid)
        ->Where('salary_goes_to', $request['salary_type_id'])
        ;

        // dd($payrolInfo->get());
        if (!empty($employeeId_pluck)) {
            $payrolInfo->whereIn('salaries.employee_id', $employeeId_pluck);
        }
        if (!empty($section_id_pluck)) {
            $payrolInfo->whereIn('employees.employee_section', $section_id_pluck);
        }
        if (!empty($unit_id_pluck)) {
            $payrolInfo->whereIn('employees.employee_unit', $unit_id_pluck);
        }
        if (!empty($sub_unit_id_pluck)) {
            $payrolInfo->whereIn('employees.employee_sub_unit', $sub_unit_id_pluck);
        }
        if (!empty($department_id_pluck)) {
            $payrolInfo->whereIn('employees.employee_department', $department_id_pluck);
        }
        if (!empty($section_id_pluck)) {
            $payrolInfo->whereIn('employee_section', $section_id_pluck);
        }
        if (!empty($subsection_id_pluck)) {
            $payrolInfo->whereIn('employees.employee_sub_section', $subsection_id_pluck);
        }
        if (!empty($employee_work_location_id_pluck)) {
            $payrolInfo->whereIn('employees.employee_work_location', $employee_work_location_id_pluck);
        }
        if (!empty($jobgrade_name_value_pluck)) {
            $payrolInfo->whereIn('employees.employee_job_grade', $jobgrade_name_value_pluck);
        }
        // if (!empty($mgt_non_mgt)) {
        //     $payrolInfo->where('employees.emplyee_category_mgt_non_mgt', $mgt_non_mgt);
        // }
        $payrolInfo = $payrolInfo
        ->groupBy('employees.id')
        ->orderBy('designations.priority')->get();

        $employee_data = $payrolInfo;

        $employee_all_idno = collect($employee_data)->pluck('id')->toArray();

        $payroll_setting = DB::table('salary_settings')
                      ->where('company_sbu_id', $request['id'])
                      ->where('status', 1)
                      ->where('valid', 1)->get();
        $attendanceInfo = DB::table('attendance')
                        ->select('attendance.employee_id', 'pstatus', 'pdate', DB::raw('count(DISTINCT pdate) AS totalDay'))
                        ->whereDate('pdate', '<=', $last_date_of_month)
                        ->whereDate('pdate', '>=', $fist_date_of_month)
                        ->whereIn('employee_id', $employee_all_idno)
                        ->groupBy('attendance.employee_id')
                        ->groupBy('attendance.pstatus')->get();

        if($request['id'] == 26){
            // for security sbu
            $fridays = array();
            $fifth = strtotime('fifth friday of', strtotime($fist_date_of_month));
            $fridays[0] = date('Y-m-d', strtotime('first friday of', strtotime($fist_date_of_month)));
            $fridays[1] = date('Y-m-d', strtotime('second friday of', strtotime($fist_date_of_month)));
            $fridays[2] = date('Y-m-d', strtotime('third friday of', strtotime($fist_date_of_month)));
            $fridays[3] = date('Y-m-d', strtotime('fourth friday of', strtotime($fist_date_of_month)));
            if (date('m', strtotime($fist_date_of_month)) === date('m', $fifth)) {
                $fridays[4] = date($fist_date_of_month, $fifth);
            }
            // $friday_presents = [];
            $attendanceInfo_fridays = DB::table('attendance')
                            ->select('attendance.employee_id', 'pstatus', 'pdate', DB::raw('count(DISTINCT pdate) AS totalDay'))
                            ->whereIn('pdate', $fridays)
                            // ->whereDate('pdate', '>=', $fist_date_of_month)
                            ->whereIn('employee_id', $employee_all_idno)
                            ->groupBy('attendance.employee_id')
                            ->groupBy('attendance.pstatus')->get();
            // dd($employee_all_idno, $attendanceInfo_fridays);
        }

        $additionalAllowances = DB::table('additional_allowances')
                      ->where('company_sbu_id', $request['id'])
                      ->whereDate('additional_date', '>=', $fist_date_of_month)
                      ->whereDate('additional_date', '<=', $last_date_of_month)
                      ->where('salary_goes_to', $request['salary_type_id'])
                      ->where('valid', 1)->get();

        $mobileAddition = DB::table('sim_assignings')
                      ->where('company_sbu_id', $request['id'])
                      ->where('sim_assign_status', 1)
                      ->where('valid', 1)->get();

        $mobileInternetBills = DB::table('mobile_internet_bills')
                     ->where('company_sbu_id', $request['id'])
                     ->whereDate('bill_date', '>=', $fist_date_of_month)
                     ->whereDate('bill_date', '<=', $last_date_of_month)
                     ->where('bill_status', 1)
                     ->where('bill_types', 3)
                     ->where('valid', 1)->get();

        $salary_deductions = DB::table('salary_deductions')
                      ->where('company_sbu_id', $request['id'])
                      ->whereDate('deduction_date', '>=', $fist_date_of_month)
                      ->whereDate('deduction_date', '<=', $last_date_of_month)
                      ->where('valid', 1)->get();

        $employee_loans = DB::table('employee_loans')
                      ->where('company_sbu_id', $request['id'])
                      ->where('loan_status', 1)
                      ->where('loan_clearance_status', 2)
                      ->where('valid', 1)->get();

        $salary_info_both = DB::table('salaries')
                      ->where('salary_sbu_id', $request['id'])
                      ->where('salary_status', 1)
                      ->where('gross_salary', '!=', '0')
                      ->where('valid', 1)
                      ->get();


        $salary_increment = DB::table('salaries')
                ->where('salary_sbu_id', $request['id'])
                ->where('salary_status', 1)
                ->where('type', 2)
                ->where('valid', 1)
                ->get();

        $loan_adv_transactions = DB::table('loan_adv_transactions')
                      ->where('company_sbu_id', $request['id'])
                      ->whereDate('trns_date', '>=', $fist_date_of_month)
                      ->whereDate('trns_date', '<=', $last_date_of_month)
                      ->where('valid', 1)->get();
        // return response()->json($payrollEmployyId);
        $total_salary = 0;

        foreach ($employee_data as $key => $value) {
            $employee_payroll_setting = collect($payroll_setting)->where('company_sbu_id', $value['employee_sbu'])->first();

            $is_cash_salary = collect($salary_info_both)->where('employee_id', $value->id)->where('salary_goes_to', 1)->where('type', 1)->where('gross_salary', '!=', '0')->first();
            $is_bank_salary = collect($salary_info_both)->where('employee_id', $value->id)->where('salary_goes_to', 2)->where('type', 1)->where('gross_salary', '!=', '0')->first();

            $prtots = collect($attendanceInfo)->where('employee_id', $value->id)->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 1)->sum('totalDay');
            $lttots = collect($attendanceInfo)->where('employee_id', $value->id)->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 2)->sum('totalDay');
            $abtots = collect($attendanceInfo)->where('employee_id', $value->id)->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 3)->sum('totalDay');
            $whtotH = collect($attendanceInfo)->where('employee_id', $value->id)->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 4)->sum('totalDay');
            $whtotW = collect($attendanceInfo)->where('employee_id', $value->id)->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 5)->sum('totalDay');
            $levtot = collect($attendanceInfo)->where('employee_id', $value->id)->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 6)->sum('totalDay');
            $whtotHt = (int) $whtotH + (int) $whtotW ;
            $totals = (int) $prtots + (int) $lttots + (int) $abtots + (int) $whtotW + (int) $whtotH + (int) $levtot;
            $totalPD = (int) $prtots + (int) $lttots + (int) $whtotW + (int) $whtotH + (int) $levtot ;

            $employee_data[$key]['prtot'] = $prtots;
            $employee_data[$key]['lttot'] = $lttots;
            $employee_data[$key]['abtot'] = $abtots;
            $employee_data[$key]['whtot'] = $whtotHt;
            $employee_data[$key]['levtot'] = $levtot;
            $employee_data[$key]['total'] = $totals;
            $late_deduction_day = 0;
            if (!empty($employee_payroll_setting->late_deduction)) {
                if ($employee_payroll_setting->late_deduction == 1) {
                    if ($employee_payroll_setting->late_day > 0) {
                        $late_deduction_day = floor($employee_data[$key]['lttot'] / $employee_payroll_setting->late_day);
                    } else {
                        $late_deduction_day = 0;
                    }
                } else {
                    $late_deduction_day = 0;
                }
            }
            $absent_deduction_day = 0;
            if (!empty($employee_payroll_setting->absent_deduction)) {
                if ($employee_payroll_setting->absent_deduction == 1) {
                    if ($employee_payroll_setting->absent_day > 0) {
                        $absent_deduction_day = floor($employee_data[$key]['abtot'] / $employee_payroll_setting->absent_day);
                    } else {
                        $absent_deduction_day = 0;
                    }
                } else {
                    $absent_deduction_day = 0;
                }
            }
            if(!empty($employee_payroll_setting->absent_deduction) && $employee_payroll_setting->absent_deduction != 1){
                $totals = $total_month_day;
                $totalPD = $total_month_day;
            }
            $total_deduction_day =  $late_deduction_day + $absent_deduction_day;
            $employee_data[$key]['pay_day'] = $pay_day = $totals - $late_deduction_day - $absent_deduction_day;

            // dd($friday_presents);

            $employee_data[$key]['total_deduction_day'] =  $total_deduction_day;
            $g_salary_first = collect($payrolInfo)->where('employee_id', $value->id)->where('type', 1)->sum('gross_salary');

            $g_increment = collect($salary_increment)->where('employee_id', $value->id)->where('salary_goes_to', $request->salary_type_id)->sum('gross_salary');

            $salary_increment_cash = collect($salary_increment)->where('employee_id', $value->id)->where('salary_goes_to', 1)->where('type', 2)->where('gross_salary', '!=', '0')->first();
            
            $salary_increment_bank = collect($salary_increment)->where('employee_id', $value->id)->where('salary_goes_to', 2)->where('type', 2)->where('gross_salary', '!=', '0')->first();
            // if($value->id == 142){
            //     dd($salary_increment_cash, $salary_increment_bank);
            // }

            // if($value->employee_id == 4236){
            //     dd($is_cash_salary, $is_bank_salary);
            // }

            // if (!empty($is_cash_salary) && !empty($is_bank_salary) && ($request->salary_type_id == 1 || $request->salary_type_id == 2)) {
            //     $g_salary = $g_salary_first + $g_increment;
            // } else  if (!empty($is_cash_salary) && empty($is_bank_salary) && $request->salary_type_id == 1) {
            //     $g_salary = $g_salary_first + $g_increment;
            // } else if (empty($is_cash_salary) && !empty($is_bank_salary) && $request->salary_type_id == 2 ) {
            //     $g_salary = $g_salary_first + $g_increment;
            // } else {
            //     $g_salary = $g_salary_first;
            // }  
            $g_salary = $g_salary_first + $g_increment;


            // $g_salary = $g_salary_first + $g_increment;
            
            

            $employee_data[$key]['total_month_day'] =  $totals;
            $employee_data[$key]['g_increment'] =  $g_increment;

            $employee_data[$key]['g_salary'] = number_format((float)$g_salary, 2, '.', '');
            $day_off_allowance = 0;
            if($request['id'] == 26){
                // for security salary development
                $employee_data[$key]['total_day_off_worked'] = $total_day_off_worked = collect($attendanceInfo_fridays)->where('employee_id', $value->id)->whereIn('pstatus', [1,2])->sum('totalDay');

                // find day off allowance
                if($totals > 0){
                    $employee_data[$key]['day_off_allowance'] = $day_off_allowance = (($g_salary / $total_month_day) * $employee_data[$key]['total_day_off_worked']) + ((($g_salary / 2) / $total_month_day) * $employee_data[$key]['total_day_off_worked']);
                }else{
                    $employee_data[$key]['day_off_allowance'] = $day_off_allowance = 0;
                }
            }

            // dd($g_salary, $total_month_day, $employee_data[$key]['total_day_off_worked']);

            // dd($late_deduction_day, $absent_deduction_day);
            if(!empty($is_cash_salary) && !empty($is_bank_salary) && (!empty($employee_payroll_setting->cash_pf) && $employee_payroll_setting->cash_pf == 1) && $value->salary_goes_to == 1){
                $employee_data[$key]['absent_amount'] = 0;
            }else{
                $employee_data[$key]['absent_amount'] = round($g_salary / $total_month_day * $absent_deduction_day);
            }

            $employee_data[$key]['late_deduction'] = $late_deduction = round($g_salary / $total_month_day * $late_deduction_day);


            if(!empty($is_cash_salary) && !empty($is_bank_salary) && !empty($employee_payroll_setting->cash_pf) && $employee_payroll_setting->cash_pf == 1 && $value->salary_goes_to == 1){
                $g_payble = $g_salary;
            }else{
                $g_payble = $g_salary / $total_month_day * $totalPD;
            }
            if($totalPD == 0){
                if(!empty($is_cash_salary) && !empty($is_bank_salary) && !empty($employee_payroll_setting->cash_pf) && $employee_payroll_setting->cash_pf == 1 && $value->salary_goes_to == 1){
                    $g_payble = $g_salary;
                }else{
                    $per_day_salary = $g_salary / $total_month_day;
                    $g_payble = $per_day_salary * $total_month_day;
                }
            }

            $b_salary = ($g_payble * ($employee_payroll_setting->basic_salary ?? 0)) / 100;
            $h_allowance = ($g_payble * ($employee_payroll_setting->housing_allowance ?? 0)) / 100;
            $m_allowance = ($g_payble * ($employee_payroll_setting->medical_allowance ?? 0)) / 100;
            $c_allowance = ($g_payble * ($employee_payroll_setting->conveyance_allowance ?? 0)) / 100;
            if($value->provident_fund == 1){
                $p_fund = ($b_salary * ($employee_payroll_setting->provident_fund ?? 0)) / 100;
            }else{
                $p_fund = 0;
            }

            if ($g_salary > 0) {
                $employee_data[$key]['per_day_salary'] = $g_salary / $total_month_day ?? 0;

                $employee_data[$key]['per_day_b_salary'] = $b_salary / $total_month_day ?? 0;
                $employee_data[$key]['per_day_h_allowance'] = $h_allowance / $total_month_day ?? 0;
                $employee_data[$key]['per_day_m_allowance'] = $m_allowance / $total_month_day ?? 0;
                $employee_data[$key]['per_day_c_allowance'] = $c_allowance / $total_month_day ?? 0;
            } else {
                $employee_data[$key]['per_day_salary'] = 0;
                $employee_data[$key]['per_day_b_salary'] = 0;
                $employee_data[$key]['per_day_h_allowance'] = 0;
                $employee_data[$key]['per_day_m_allowance'] = 0;
                $employee_data[$key]['per_day_c_allowance'] = 0;
            }

            $employee_data[$key]['b_salary'] = number_format((float)$b_salary, 0, '.', '');
            $employee_data[$key]['b_salary_daywise'] = number_format((float)$b_salary, 0, '.', '');
            $employee_data[$key]['h_allowance'] = number_format((float)$h_allowance, 0, '.', '');
            $employee_data[$key]['h_allowance_daywise'] = number_format((float)$h_allowance, 0, '.', '');
            $employee_data[$key]['m_allowance'] = number_format((float)$m_allowance, 0, '.', '');
            $employee_data[$key]['m_allowance_daywise'] = number_format((float)$m_allowance, 0, '.', '');
            $employee_data[$key]['c_allowance'] = number_format((float)$c_allowance, 0, '.', '');
            $employee_data[$key]['c_allowance_daywise'] = number_format((float)$c_allowance, 0, '.', '');
            $employee_data[$key]['g_payble'] = number_format((float)$g_payble, 0, '.', '');

            $employee_data[$key]['g_payble_daywise'] = number_format((float)$g_payble, 0, '.', '');
            $overTime_comperensation = collect($payrolInfo)->where('employee_id', $value->id)->sum('overtime_work_compensation');
            $employee_data[$key]['overTime_comperensation'] = $overTime_comperensation;

            $arrear_amount = collect($additionalAllowances)->where('additional_allow_type', 1)->where('employee_id', $value->id)->sum('additional_amount');

            $employee_data[$key]['arrear_amount'] = number_format((float)$arrear_amount, 0, '.', '');

            $addition_allownce = collect($additionalAllowances)->where('additional_allow_type', 3)->where('employee_id', $value->id)->sum('additional_amount');
            $employee_data[$key]['addition_allownce'] = number_format((float)$addition_allownce, 0, '.', '');

            $incentive = collect($additionalAllowances)->where('additional_allow_type', 4)->where('employee_id', $value->id)->sum('additional_amount');
            $employee_data[$key]['incentive'] = number_format((float)$incentive, 0, '.', '');

            $phone_allowance = collect($payrolInfo)->where('employee_id', $value->id)->sum('phone_allowance');
            $employee_data[$key]['phone_allowance'] = number_format((float)$phone_allowance, 0, '.', '');
            $car_allowance = collect($payrolInfo)->where('employee_id', $value->id)->sum('car_allowance_amount');
            $employee_data[$key]['car_allowance'] = number_format((float)$car_allowance, 0, '.', '');
            if ($request['salary_type_id'] == 2) {
                // Addition allowance
                $mobile_addition = collect($mobileAddition)->where('sim_assign_to', $value->id)->sum('sim_ceiling_limit');
                $employee_data[$key]['mobile_addition'] = number_format((float)$mobile_addition, 0, '.', '');
                $car_allowance = collect($payrolInfo)->where('employee_id', $value->id)->sum('car_allowance_amount');
                $employee_data[$key]['car_allowance'] = number_format((float)$car_allowance, 0, '.', '');
                $other_allowance = collect($payrolInfo)->where('employee_id', $value->id)->sum('others_allowance');
                $employee_data[$key]['other_allowance'] = number_format((float)$other_allowance, 0, '.', '');
                $totalAddition = ($arrear_amount + $mobile_addition + $car_allowance + $other_allowance + $incentive + $addition_allownce);
                // Deduction
                $employeeLoans = collect($employee_loans)->where('employee_id', $value->id)->first();
                if (!empty($employeeLoans)) {
                    if ($employeeLoans->loan_deduct_policy == 1) {
                        $ad_or_lone = round(($employeeLoans->loan_amount / $employeeLoans->no_of_installment));
                        $employee_data[$key]['ad_or_lone'] = number_format((float)$ad_or_lone, 0, '.', '');
                        $employee_data[$key]['loan_deduct_policy'] = 1;
                    } else {
                        $ad_or_lone = collect($loan_adv_transactions)->where('employee_id', $value->id)->sum('loan_adv_amount');
                        $employee_data[$key]['loan_deduct_policy'] = 2;
                        $employee_data[$key]['ad_or_lone'] = number_format((float)$ad_or_lone, 0, '.', '');
                    }
                } else {
                    $ad_or_lone = 0;
                    $employee_data[$key]['ad_or_lone'] = number_format((float)$ad_or_lone, 0, '.', '');
                }

                $uniform = collect($salary_deductions)->where('deduction_types', 1)->where('employee_id', $value->id)->sum('deduction_amount');
                $employee_data[$key]['uniform'] = number_format((float)$uniform, 0, '.', '');

                $deposit = collect($salary_deductions)->where('deduction_types', 0)->where('employee_id', $value->id)->sum('deduction_amount');
                $employee_data[$key]['deposit'] = number_format((float)$deposit, 0, '.', '');


                $tax_amount = $this->tax_calculation($g_salary, $b_salary, $h_allowance, $m_allowance, $c_allowance, $p_fund, $value->employee_gender, $value->employee_dob_certificate);


                $employee_data[$key]['tax_amount'] = number_format((float)$tax_amount, 0, '.', '');

                $mobileBills = collect($mobileInternetBills)->where('employee_id', $value->id)->where('bill_types', 3)->sum('bill_amount');
                if (($mobileBills - $mobile_addition) > 0) {
                    $mobile_amount = $mobileBills - $mobile_addition;
                    $employee_data[$key]['mobile_amount'] = number_format((float)$mobile_amount, 0, '.', '');
                } else {
                    $mobile_amount = 0;
                    $employee_data[$key]['mobile_amount'] = number_format((float)$mobile_amount, 0, '.', '');
                }

                $other_amount = collect($salary_deductions)->where('deduction_types', 3)->where('employee_id', $value->id)->sum('deduction_amount');
                $employee_data[$key]['other_amount'] = number_format((float)$other_amount, 0, '.', '');
            } else {
                $ad_or_lone = 0;
                $employee_data[$key]['ad_or_lone'] = number_format((float)$ad_or_lone, 0, '.', '');
                $uniform = 0;
                $employee_data[$key]['uniform'] = number_format((float)$uniform, 0, '.', '');
                $deposit = 0;
                $employee_data[$key]['deposit'] = number_format((float)$deposit, 0, '.', '');

                $tax_amount = 0;

                $employee_data[$key]['tax_amount'] = number_format((float)$tax_amount, 0, '.', '');
                $mobile_amount = 0;
                $employee_data[$key]['mobile_amount'] = number_format((float)$mobile_amount, 0, '.', '');
                $other_amount = 0;
                $employee_data[$key]['other_amount'] = number_format((float)$other_amount, 0, '.', '');

                $mobile_addition = 0;
                $employee_data[$key]['mobile_addition'] = number_format((float)$mobile_addition, 0, '.', '');
                $car_allowance = collect($payrolInfo)->where('employee_id', $value->id)->sum('car_allowance_amount');
                $employee_data[$key]['car_allowance'] = number_format((float)$car_allowance, 0, '.', '');
                $other_allowance = 0;
                $employee_data[$key]['other_allowance'] = number_format((float)$other_allowance, 0, '.', '');
                $totalAddition = ($arrear_amount + $mobile_addition + $car_allowance + $other_allowance + $incentive + $addition_allownce);
            }
            $total_p_fund = $p_fund + $p_fund;
            $employee_data[$key]['p_fund'] = number_format((float)$p_fund, 0, '.', '');
            $employee_data[$key]['c_p_fund'] = number_format((float)$p_fund, 0, '.', '');
            $employee_data[$key]['t_p_fund'] = number_format((float)$total_p_fund, 0, '.', '');
            $employee_data[$key]['total_addition'] = number_format((float)$totalAddition, 0, '.', '');

            if(!empty($is_cash_salary) && !empty($is_bank_salary) && !empty($employee_payroll_setting->cash_pf) && $employee_payroll_setting->cash_pf == 1 && $value->salary_goes_to == 1){
                $totalDeduction  = ($ad_or_lone + $uniform + $deposit + $tax_amount + $mobile_amount + $other_amount + $late_deduction);
            }else{
                $totalDeduction  = ($p_fund + $ad_or_lone + $uniform + $deposit + $tax_amount + $mobile_amount + $other_amount + $late_deduction);
            }
            $employee_data[$key]['total_deduction'] = number_format((float)$totalDeduction, 0, '.', '');

            // Deduction
            if(!empty($is_cash_salary) && !empty($is_bank_salary) && !empty($employee_payroll_setting->cash_pf) && $employee_payroll_setting->cash_pf == 1 && $value->salary_goes_to == 1){
                $net_payable = $p_fund + $g_payble + $totalAddition + $day_off_allowance - $totalDeduction;
            }else{
                $net_payable = $g_payble + $totalAddition + $day_off_allowance - $totalDeduction;
            }
            // $employee_data[$key]['net_payable']= number_format((float)$net_payable, 0, '.', '');
            $total_salary += ($g_payble - $totalDeduction);
            $late_abset_deduction = $net_payable - (($net_payable) / $total_month_day) * $employee_data[$key]['pay_day'];
            $employee_data[$key]['late_abset_deduction'] = number_format((float)$late_abset_deduction, 0, '.', '');
            // $employee_data[$key]['late_deduction'] = 0;
            $employee_data[$key]['net_payable'] = number_format(((float)$net_payable), 0, '.', '');
            ;
        }

        $employeeData['fist_date_of_month'] = $fist_date_of_month;
        $employeeData['last_date_of_month'] = $last_date_of_month;
        $employeeData['employee_sbu_id'] = $request['id'];
        $employeeData['salary_type_id'] = $request['salary_type_id'];
        $employeeData['months_id'] = $request->months_id;
        $employeeData['total_salary'] = $total_salary;
        $employeeData['salary_type'] = $request['salary_type_id'];
        $employeeData['employee_payroll_setting'] = $payroll_setting;
        $data['payroll_employee_data'] = $employee_data;
        $data['employeeData'] = $employeeData;
        $find_comapny_info = CompanySbu::valid()->where('id', $request->id)->first();
        $data['company_name'] = isset($find_comapny_info->sbu_name) ? $find_comapny_info->sbu_name : 'Gemcon Group';
        $data['company_id'] = $request->id;
        return response()->json($data);
    }

    public function tax_calculation($g_salary, $b_salary, $h_allowance, $m_allowance, $c_allowance, $p_fund, $gender, $date_of)
    {
        $taxInfo = TaxSetting::first();
        if (!empty($date_of)) {
            $birthDate = date($date_of);
            $bday = new DateTime($birthDate); // Your date of birth
            $today = new Datetime(date('Y-m-d'));
            $diff = $today->diff($bday);
            $birthDates = $diff->y;
        } else {
            $birthDates = 0;
        }

        $bonus = ($g_salary / 12);
        $total_taxable_income = ($b_salary + $h_allowance + $m_allowance + $c_allowance + $bonus + $p_fund);

        if ($h_allowance >= 300000) {
            $exp_h_allowance = 300000;
        } else {
            $exp_h_allowance = $h_allowance;
        }
        if ($m_allowance >= 120000) {
            $exp_m_allowance = 120000;
        } else {
            $exp_m_allowance = $m_allowance;
        }
        if ($c_allowance >= 30000) {
            $exp_c_allowance = 30000;
        } else {
            $exp_c_allowance = $c_allowance;
        }

        $total_exemption = ($exp_h_allowance + $exp_m_allowance + $exp_c_allowance);

        $net_taxable_income = (($total_taxable_income - $total_exemption) * 12);

        if ($birthDates >= $taxInfo['taxable_maximum_age']) {
            $taxable_incomes = ($net_taxable_income - $taxInfo['taxable_income_age']);
        } else {
            if ($gender == 2) {
                $taxable_incomes = ($net_taxable_income - $taxInfo['taxable_income_male']);
            } elseif ($gender == 1) {
                $taxable_incomes = ($net_taxable_income - $taxInfo['taxable_income_female']);
            } else {
                return $net_tax_payable = 0;
            }
        }

        $tax_on_slab1 = 0;
        if ($taxable_incomes < 0) {
            $tax_on_slab1 += (0 * ($taxInfo['taxable_slot1_per'] / 100));
        } elseif ($taxable_incomes > $taxInfo['taxable_slot1']) {
            $tax_on_slab1 += ($taxInfo['taxable_slot1'] * ($taxInfo['taxable_slot1_per'] / 100));
        } elseif ($taxable_incomes < $taxInfo['taxable_slot1']) {
            $tax_on_slab1 += ($taxable_incomes * ($taxInfo['taxable_slot1_per'] / 100));
        }
        $tax_on_slab2 = 0;
        if (($taxable_incomes - $taxInfo['taxable_slot1']) < 0) {
            $tax_on_slab2 += (0 * ($taxInfo['taxable_slot2_per'] / 100));
        } elseif (($taxable_incomes - $taxInfo['taxable_slot1']) >  $taxInfo['taxable_slot2']) {
            $tax_on_slab2 += ($taxInfo['taxable_slot2'] * ($taxInfo['taxable_slot2_per'] / 100));
        } elseif (($taxable_incomes - $taxInfo['taxable_slot1']) <  $taxInfo['taxable_slot2']) {
            $tax_on_slab2 += (($taxable_incomes - $taxInfo['taxable_slot1']) * ($taxInfo['taxable_slot2_per'] / 100));
        }

        $tax_on_slab3 = 0;
        if (($taxable_incomes - ($taxInfo['taxable_slot1'] + $taxInfo['taxable_slot2'])) < 0) {
            $tax_on_slab3 += (0 * ($taxInfo['taxable_slot3_per'] / 100));
        } elseif (($taxable_incomes - ($taxInfo['taxable_slot1'] + $taxInfo['taxable_slot2'])) >  $taxInfo['taxable_slot3']) {
            $tax_on_slab3 += (($taxInfo['taxable_slot1'] + $taxInfo['taxable_slot2'])) * ($taxInfo['taxable_slot3_per'] / 100);
        } elseif (($taxable_incomes - ($taxInfo['taxable_slot1'] + $taxInfo['taxable_slot2'])) <  $taxInfo['taxable_slot3']) {
            $tax_on_slab3 += (($taxable_incomes - ($taxInfo['taxable_slot1'] + $taxInfo['taxable_slot2'])) * ($taxInfo['taxable_slot3_per'] / 100));
        }

        $tax_on_slab4 = 0;
        if (($taxable_incomes - ($taxInfo['taxable_slot1'] + $taxInfo['taxable_slot2'] + $taxInfo['taxable_slot2'])) < 0) {
            $tax_on_slab4 += (0 * ($taxInfo['taxable_slot4_per'] / 100));
        } elseif (($taxable_incomes - ($taxInfo['taxable_slot1'] + $taxInfo['taxable_slot2'] + $taxInfo['taxable_slot3'])) >  $taxInfo['taxable_slot4']) {
            $tax_on_slab4 += ($taxInfo['taxable_slot4'] * ($taxInfo['taxable_slot4_per'] / 100));
        } elseif (($taxable_incomes - ($taxInfo['taxable_slot1'] + $taxInfo['taxable_slot2'] + $taxInfo['taxable_slot3'])) <  $taxInfo['taxable_slot4']) {
            $tax_on_slab4 += (($taxable_incomes - ($taxInfo['taxable_slot1'] + $taxInfo['taxable_slot2'] + $taxInfo['taxable_slot3'])) * ($taxInfo['taxable_slot4_per'] / 100));
        }

        $tax_on_slab5 = 0;
        if (($taxable_incomes - ($taxInfo['taxable_slot1'] + $taxInfo['taxable_slot2'] + $taxInfo['taxable_slot3'] + $taxInfo['taxable_slot4'])) < 0) {
            $tax_on_slab5 += (0 * ($taxInfo['taxable_slot5_per'] / 100));
        } else {
            $tax_on_slab5 += (($taxable_incomes - ($taxInfo['taxable_slot1'] + $taxInfo['taxable_slot2'] + $taxInfo['taxable_slot3'] + $taxInfo['taxable_slot4'])) * ($taxInfo['taxable_slot5_per'] / 100));
        }

        $tax_payable = ($tax_on_slab1 + $tax_on_slab2 + $tax_on_slab3 + $tax_on_slab4 + $tax_on_slab5);
        $maximum_investment_allowed = (($net_taxable_income - $p_fund) * 0.25);
        if ($maximum_investment_allowed > 15000000) {
            $maximum_investment_alloweds = 15000000;
        } else {
            $maximum_investment_alloweds = $maximum_investment_allowed;
        }

        $investment_on_slab1 = 0;
        if ($maximum_investment_alloweds > 1500000) {
            $investment_on_slab1 += (1500000 * 0.15);
        } else {
            $investment_on_slab1 += ($maximum_investment_alloweds * 0.15);
        }
        $investment_on_slab2 = 0;
        if (($maximum_investment_alloweds - 1500000) < 0) {
            $investment_on_slab2 += (0 * 0.1);
        } elseif (($maximum_investment_alloweds - 1500000) > 500000) {
            $investment_on_slab2 += (500000 * 0.1);
        } else {
            $investment_on_slab2 += (($maximum_investment_alloweds - 1500000) * 0.1);
        }

        $investment_on_slab3 = 0;
        if (($maximum_investment_alloweds - 2000000) < 0) {
            $investment_on_slab3 += (0 * 0.1);
        } else {
            $investment_on_slab3 += (($maximum_investment_alloweds - 2000000) * 0.1);
        }
        $investment_tax_credit = ($investment_on_slab1 + $investment_on_slab2 + $investment_on_slab3);
        $net_tax_payable = 0;
        if ($tax_payable <= 0) {
            $net_tax_payable += (0 / 12);
        } elseif (($tax_payable - $investment_tax_credit) > 5000) {
            $net_tax_payable += (($tax_payable - $investment_tax_credit) / 12);
        } else {
            $net_tax_payable += (5000 / 12);
        }

        return $net_tax_payable;
    }
    public function weeks_in_month($month, $year)
    {
        $dates = [];

        $week = 1;
        $date = new DateTime("$year-$month-01");
        $days = (int)$date->format('t'); // total number of days in the month

        $oneDay = new DateInterval('P1D');

        for ($day = 1; $day <= $days; $day++) {
            $dates["$week"] []=[
                'date'=>$date->format('Y-m-d'),
                'day_name'=>$date->format('l'),
                'day_names'=>$date->format('D'),
                'day'=>$date->format('d')
                ];

            $dayOfWeek = $date->format('l');
            if ($dayOfWeek === 'Saturday') {
                $week++;
            }

            $date->add($oneDay);
        }

        return $dates;
    }

    public function week_fiends(request $request)
    {
        $year=date('Y');
        $aa=$this->weeks_in_month($request->id, $year);
        $found_key=[];
        $week=[];
        foreach ($aa as $key => $value) {
            if ($key==2) {
                $found_key=$value;
            }
            // if(){
            $week[]=[
            "id"=>$key,
            "text"=>"Week ".$key,
            ];
            // }
        }
        $data['week']=$week;
        return response($data);
    }

    public function store(Request $request)
    {
        if ($request->employeeData['months_id'] != 0) {
            $month_num =date("F", mktime(0, 0, 0, $request->employeeData['months_id'], 10));
        } else {
            $month_num =date("F", strtotime($request->employeeData['fist_date_of_month']));
        }
        if($request->employeeData['months_id'] == '11' || $request->employeeData['months_id'] == '12'){
            $pay_year = date('Y', strtotime('-1 years'));
            if($request->employeeData['months_id'] == '11'){
                $last_day = 30;
            }
            if($request->employeeData['months_id'] == '12'){
                $last_day = 31;
            }
            $fist_date_of_month = $pay_year.'-'.$request->employeeData['months_id'].'-1';
            $last_date_of_month = $pay_year.'-'.$request->employeeData['months_id'].'-'.$last_day;
        }else{
            $pay_year = date('Y');
            $fist_date_of_month = $request->employeeData['fist_date_of_month'];
            $last_date_of_month = $request->employeeData['last_date_of_month'];
        }


        // dd($request->employeeData['months_id'],$last_date_of_month, $fist_date_of_month, $pay_year);
        try {
            DB::beginTransaction();
            // $payroll_process_check = PayrollProcessList::where('type', $request->employeeData['salary_type_id'])
            // ->where('companysbu_id', $request->employeeData['employee_sbu_id'])
            // ->whereDate('startdate', '<=', $request->employeeData['fist_date_of_month'])
            // ->whereDate('enddate', '>=', $request->employeeData['last_date_of_month'])
            // ->where('valid', 1)
            // ->first();
            $collect_employee_id = collect($request->payroll_employee_data)->pluck('id')->toArray();
            if (!empty($collect_employee_id)) {
                $employee_checking = PayrollList::leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')->where('payroll_process.companysbu_id', $request->employeeData['employee_sbu_id'])
                ->whereDate('payroll_process.startdate', '<=', $fist_date_of_month)
                ->whereDate('payroll_process.enddate', '>=', $last_date_of_month)
                ->where('payroll_process.type', $request->employeeData['salary_type_id'])
                ->whereIn('empid', $collect_employee_id)->where('payroll.valid', 1)->get();
            }
            // return response($employee_checking);
            if (count($employee_checking)>0) {
                $message=['status' => 0, 'message' => 'Payroll already processed!'];
                return response()->json($message);
            }

            $payroll_process=[
                "companysbu_id"=>$request->employeeData['employee_sbu_id'],
                "paymonth"=>$month_num,
                "process_date"=>date('Y-m-d'),
                "pay_year"=> $pay_year,
                "startdate"=>$fist_date_of_month,
                "enddate"=>$last_date_of_month,
                "remarks"=>isset($request->summary_remarks) ? $request->summary_remarks : '',
                "type"=>$request->employeeData['salary_type_id'] ?? 0,
                "total_salary_amount"=>round($request->employeeData['total_salary']) ?? 0,
                "status" => 1,
                "settlement" => 1,
                "salary_weekly_monthly" => 2,
                "project_id"=>Auth::guard('user')->user()->project_id,
                "branch_id"=>Auth::guard('user')->user()->branch_id,
                "created_by"=>Auth::guard('user')->user()->id,
                "created_at"=>date('Y-m-d H:i:s'),
            ];
            $save_id=PayrollProcessList::create($payroll_process);

            $payroll=[];
            $p_fund=[];
            $loan_adv_transactions=[];
            $employee_data=collect($request->payroll_employee_data)->where('employee_sbu', '!=', '')->toArray();
            // return response($request);
            foreach ($employee_data as $key => $value) {
                if ($value['b_salary_daywise']<0) {
                    $late_abset_deduction = 0;
                } else {
                    $late_abset_deduction = $value['late_abset_deduction'];
                }
                $payroll[]=[
                  "procsid" => $save_id->id,
                  "companysbu_id" => $value['employee_sbu'],
                  "empid" => $value['id'],
                  "gross_salary" => $value['g_salary'],
                  "absent_deduction" => $value['absent_amount'],
                  "gross_payable" => $value['g_payble_daywise'],
                  "attendance_bonus" => 0,
                  "night_allownce" => 0,
                  "residential_allowance" => 0,
                  "basic" => isset($value['b_salary_daywise']) ? $value['b_salary_daywise'] : $value['b_salary'],
                  "houserent" => isset($value['h_allowance_daywise']) ? $value['h_allowance_daywise'] : $value['h_allowance'],
                  "medical"=> isset($value['m_allowance_daywise']) ? $value['m_allowance_daywise'] : $value['m_allowance'],
                  "transport"=> isset($value['c_allowance_daywise']) ? $value['c_allowance_daywise'] : $value['c_allowance'],
                  "day_off_allowance"=> isset($value['day_off_allowance']) ? $value['day_off_allowance'] : 0,
                  "overtime"=>0,
                  "stdays"=>$value['pay_day'],
                  "total_day_off_worked"=>$value['total_day_off_worked'] ?? 0,
                  "total_deduction_day"=>$value['total_deduction_day'],
                  "paydays"=>$value['pay_day'],
                  "arear"=>$value['arrear_amount'],
                  "additional_mobile"=>$value['phone_allowance'],
                  "car_allowance"=>$value['car_allowance'],
                  "allowance"=>$value['addition_allownce'],
                  "other_allownce"=>$value['other_allowance'],
                  "deduction_pfbasic"=>$value['p_fund'],
                  "deduction_others"=>$value['other_amount'],
                  "deduction_uniform"=>$value['uniform'],
                  "deduction_deposit"=>$value['deposit'],
                  "deduction_mobilebill"=>$value['mobile_amount'],
                  "deduction_loan"=>$value['ad_or_lone'],
                  "deduction_tax"=>round($value['tax_amount']),
                  "late_abset_deduction"=>round($late_abset_deduction),
                  "late_deduction"=>$value['late_deduction'],
                  "netpay"=>round($value['net_payable']),
                  "remarks"=>isset($value['ind_remarks']) ? $value['ind_remarks'] : '',
                  "project_id"=>Auth::guard('user')->user()->project_id,
                  "branch_id"=>Auth::guard('user')->user()->branch_id,
                  "created_by"=>Auth::guard('user')->user()->id,
                  "created_at"=>date('Y-m-d H:i:s'),
                ];
                if ($request->employeeData['salary_type_id']==2) {
                    $p_fund[]=[
                    "employee_id"=>$value['id'],
                    "company_sbu_id"=>$value['employee_sbu'],
                    "pf_date"=>$request->employeeData['last_date_of_month'],
                    "pf_employee_amount"=>$value['p_fund'],
                    "pf_company_amount"=>$value['p_fund'],
                    "pf_profit_interest"=>0,
                    "pf_status"=>1,
                    "project_id"=>Auth::guard('user')->user()->project_id,
                    "branch_id"=>Auth::guard('user')->user()->branch_id,
                    "created_by"=>Auth::guard('user')->user()->id,
                    "created_at"=>date('Y-m-d H:i:s'),
                    ];
                }


                if (!empty($value['ad_or_lone']) && (!empty($value['loan_deduct_policy'])==1)) {
                    $loan_info=DB::table('employee_loans')->where('loan_clearance_status', 2)->where('employee_id', $value['id'])->first();
                    $loan_adv_transactions[]=[
                    "loan_adv_id"=>$loan_info->id,
                    "employee_id"=>$value['id'],
                    "company_sbu_id"=>$value['employee_sbu'],
                    "trns_date"=>$last_date_of_month,
                    "loan_adv_amount"=>$value['ad_or_lone'],
                    "loan_trns_status"=>1,
                    "project_id"=>Auth::guard('user')->user()->project_id,
                    "branch_id"=>Auth::guard('user')->user()->branch_id,
                    "created_by"=>Auth::guard('user')->user()->id,
                    "created_at"=>date('Y-m-d H:i:s'),
                    ];
                }
            }
            if (!empty($p_fund)) {
                ProvidentFund::insert($p_fund);
            }
            // ProvidentFund::insert($p_fund);
            PayrollList::insert($payroll);
            if (!empty($loan_adv_transactions)) {
                LoanTransaction::insert($loan_adv_transactions);
            }
            DB::commit();
            $message=['status' => 1, 'message' => 'Your data is successfully Saved'];
            return response($message);
        } catch (\Exception $exception) {
            DB::rollBack();
            $message=['status' => 0, 'message' => 'Ops! Something went worng.'];
            return response($exception);
        }

  // return response($message);
    }

    public function edit($id)
    {
        $data=NoticeModel::valid()->project()->findOrFail($id);
        $companysbu_data_list=CompanySbu::valid()->project()->get()->keyBy('id')->all();
        $section_data_list=Section::valid()->project()->get()->keyBy('id')->all();
        $sub_section_data_list=SubSection::valid()->project()->get()->keyBy('id')->all();
        $employee_group_data_list=EmployeeGroup::valid()->project()->get()->keyBy('id')->all();
        $department_list=Department::valid()->project()->get()->keyBy('id')->all();
        $designation_data_list=Designation::valid()->project()->get()->keyBy('id')->all();
        $jobgrade_data_list=JobGrade::valid()->project()->get()->keyBy('id')->all();
        $employee_data_list=Employee::valid()->project()->get()->keyBy('id')->all();
        $employee_reporting=Employee::valid()->project()->get()->keyBy('employee_id_no')->all();
        $sub_unit_data_list=SubUnit::valid()->project()->get()->keyBy('id')->all();
        $unit_data_list=UnitModel::valid()->project()->get()->keyBy('id')->all();
        $work_location_data_list=WorkLocation::valid()->project()->get()->keyBy('id')->all();
        if (!$data->sbu_id) {
            $data->sbu_name_value = ['id'=>'','text'=>''];
        } else {
            $data->sbu_name_value = ['id'=>$data->sbu_id,'text'=>$companysbu_data_list[$data->sbu_id]->sbu_name];
        }
        if (!$data->section_id) {
            $data->section_value = ['id'=>'','text'=>''];
        } else {
            $data->section_value = ['id'=>$data->section_id,'text'=>$section_data_list[$data->section_id]->section_name];
        }
        if (!$data->subsection_id) {
            $data->sub_section_value = ['id'=>'','text'=>''];
        } else {
            $data->sub_section_value = ['id'=>$data->subsection_id,'text'=>$sub_section_data_list[$data->subsection_id]->sub_section_name];
        }
        if (!$data->employee_id) {
            $data->employee_name_value = ['id'=>'','text'=>''];
        } else {
            $data->employee_name_value = ['id'=>$data->employee_id,'text'=>$employee_data_list[$data->employee_id]->employee_fullname];
        }
        if (!$data->department_id) {
            $data->department_name_value = ['id'=>'','text'=>''];
        } else {
            $data->department_name_value = ['id'=>$data->department_id,'text'=>$department_list[$data->department_id]->department_name];
        }

        if (!$data->subunit_id) {
            $data->sub_unit_value = ['id'=>'','text'=>''];
        } else {
            $data->sub_unit_value = ['id'=>$data->subunit_id,'text'=>$sub_unit_data_list[$data->subunit_id]->sub_unit_name];
        }
        if (!$data->unit_id) {
            $data->unit_value = ['id'=>'','text'=>''];
        } else {
            $data->unit_value = ['id'=>$data->unit_id,'text'=>$unit_data_list[$data->unit_id]->unit_name];
        }

        $company_sbu_data=array();
        $section_data=array();
        $sub_section_data=array();
        $employee_group_data=array();
        $department_data=array();
        $designation_data=array();
        $jobgrade_data=array();
        $employee_data=array();
        $employee_data_approval=array();
        $unit_data=array();
        $sub_unit_data=array();
        $work_location_data=array();
        foreach ($companysbu_data_list as $value) {
            array_push($company_sbu_data, ['id'=>$value['id'],'text'=>$value['sbu_name']]);
        }
        foreach ($section_data_list as $value) {
            array_push($section_data, ['id'=>$value['id'],'text'=>$value['section_name']]);
        }
        foreach ($sub_section_data_list as $value) {
            array_push($sub_section_data, ['id'=>$value['id'],'text'=>$value['sub_section_name']]);
        }
        foreach ($employee_group_data_list as $value) {
            array_push($employee_group_data, ['id'=>$value['id'],'text'=>$value['employee_group_name']]);
        }
        foreach ($department_list as $value) {
            array_push($department_data, ['id'=>$value['id'],'text'=>$value['department_name']]);
        }
        foreach ($designation_data_list as $value) {
            array_push($designation_data, ['id'=>$value['id'],'text'=>$value['designation_name']]);
        }
        foreach ($jobgrade_data_list as $value) {
            array_push($jobgrade_data, ['id'=>$value['id'],'text'=>$value['jobgrade_name']]);
        }
        foreach ($employee_data_list as $value) {
            array_push($employee_data, ['id'=>$value['id'],'text'=>$value['employee_id_no'].' - '.$value['employee_fullname']]);
        }
        foreach ($sub_unit_data_list as $value) {
            array_push($sub_unit_data, ['id'=>$value['id'],'text'=>$value['sub_unit_name']]);
        }
        foreach ($unit_data_list as $value) {
            array_push($unit_data, ['id'=>$value['id'],'text'=>$value['unit_name']]);
        }
        foreach ($work_location_data_list as $value) {
            array_push($work_location_data, ['id'=>$value['id'],'text'=>$value['department_name']]);
        }

        $approvalInfos=NoticePermission::valid()->project()->where('notice_id', $id)->get();
        // return response($approvalInfos);
        if (!empty($approvalInfos)) {
            $data->approval_infos=$approvalInfos;
        } else {
            $data->approval_infos=['0' =>['id'=>0,'permission_type'=>'','permission_id'=>'']];
        }

        $data->company_sbu_data =  $company_sbu_data;
        $data->section_data =  $section_data;
        $data->sub_section_data =  $sub_section_data;
        $data->employee_group_data =  $employee_group_data;
        $data->department_data =  $department_data;
        $data->designation_data =  $designation_data;
        $data->jobgrade_data =  $jobgrade_data;
        $data->employee_data =  $employee_data;
        $data->sub_unit_data =  $sub_unit_data;
        $data->unit_data =  $unit_data;
        $data->work_location_data =  $work_location_data;
        return response($data);
    }

    public function destroy($id)
    {
        $delete_data=NoticeModel::valid()->project()->findOrFail($id);
        if ($delete_data->delete()) {
            $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
        }
        return response($message);
    }

    public function create()
    {
        $data['company_sbu_data']=array();
        $data['section_data']=array();
        $data['sub_section_data']=array();
        $data['sub_unit_data']=array();
        $data['unit_data']=array();
        $data['work_location_data']=array();
        $data['department_data']=array();
        $data['designation_data']=array();
        $data['jobgrade_data']=array();
        $data['employee_data']=array();
        $data['employee_data_approval']=array();
        $data['employee_group_data']=array();
        $company_sbu_data=CompanySbu::valid()->project()->get();
        $section_data=Section::valid()->project()->get();
        $sub_section_data=SubSection::valid()->project()->get();
        $department_data=Department::valid()->project()->get();
        $designation_data=Designation::valid()->project()->get();
        $jobgrade_data=JobGrade::valid()->project()->get();
        $employee_data_approval=Employee::valid()->project()->get();
        // return response($employee_data_approval);
        $employee_data=Employee::valid()->project()->get()->keyBy('id')->all();
        $unit_data=UnitModel::valid()->project()->get();
        $sub_unit_data=SubUnit::valid()->project()->get();
        $work_location_data=WorkLocation::valid()->project()->get();
        $employee_group_data=EmployeeGroup::valid()->project()->get();
        foreach ($company_sbu_data as $value) {
            array_push($data['company_sbu_data'], ['id'=>$value['id'],'text'=>$value['sbu_name']]);
        }
        foreach ($section_data as $value) {
            array_push($data['section_data'], ['id'=>$value['id'],'text'=>$value['section_name']]);
        }
        foreach ($sub_section_data as $value) {
            array_push($data['sub_section_data'], ['id'=>$value['id'],'text'=>$value['sub_section_name']]);
        }
        foreach ($employee_group_data as $value) {
            array_push($data['employee_group_data'], ['id'=>$value['id'],'text'=>$value['employee_group_name']]);
        }
        foreach ($department_data as $value) {
            array_push($data['department_data'], ['id'=>$value['id'],'text'=>$value['department_name'],]);
        }
        foreach ($designation_data as $value) {
            array_push($data['designation_data'], ['id'=>$value['id'],'text'=>$value['designation_name']]);
        }
        foreach ($jobgrade_data as $value) {
            array_push($data['jobgrade_data'], ['id'=>$value['id'],'text'=>$value['jobgrade_name']]);
        }
        foreach ($employee_data as $value) {
            array_push($data['employee_data'], ['id'=>$value['id'],'text'=>$value['employee_id_no'].' - '.$value['employee_fullname']]);
        }

        foreach ($sub_unit_data as $value) {
            array_push($data['sub_unit_data'], ['id'=>$value['id'],'text'=>$value['sub_unit_name']]);
        }

        foreach ($unit_data as $value) {
            // return response($value);
            array_push($data['unit_data'], ['id'=>$value['id'],'text'=>$value['unit_name']]);
        }

        foreach ($work_location_data as $value) {
            array_push($data['work_location_data'], ['id'=>$value['id'],'text'=>$value['work_location_name']]);
        }

        $data['approval_infos']=['0' =>['id'=>0,'permission_type'=>'','permission_id'=>'']];





        return response($data);
    }
}
