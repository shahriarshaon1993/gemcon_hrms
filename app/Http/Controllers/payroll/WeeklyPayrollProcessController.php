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
// use App\Model\AttendanceSetup;
// use App\Model\OfficeTimeSetup;
use App\Model\payroll\Salary;
// use App\Model\payroll\TaxSetting;
use App\Model\payroll\PayrollPermission;
use App\Model\payroll\ProvidentFund;
use App\Model\payroll\DailyProduction;
use App\Model\payroll\PayrollList;
use App\Model\payroll\PayrollProcessList;
use Cache;
// use permission;
use DB;
// use DateTime;
// use DateInterval;
// use DatePeriod;

// use App\Model\UserRoleAccess;

class WeeklyPayrollProcessController extends Controller
{
    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */

    public function index(Request $request)
    {
        $cache=Cache::get('permission');
        $permission=collect($cache)->where('menu_uid', '=', 'ShiftingSetup')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
        foreach ($permission as $child) {
            if ($child['link_uid']=='add') {
                $data['add']=$child['link_uid'];
            } elseif ($child['link_uid']=='edit') {
                $data['edit']=$child['link_uid'];
            } elseif ($child['link_uid']=='delete') {
                $data['delete']=$child['link_uid'];
            } else {
                $data['approve']=$child['link_uid'];
            }
        }
        $project_id=Auth::guard('user')->user()->project_id;
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $employee_list = new Employee();
        $employee_ids=$employee_list->Employee_id();
        $employee_id=$employee_ids['employee_id'];


        // $data['company_sbu_data']=array();
        // $data['section_data']=array();
        // $data['sub_section_data']=array();
        // $data['sub_unit_data']=array();
        // $data['unit_data']=array();
        // $data['work_location_data']=array();
        // $data['department_data']=array();
        // $data['designation_data']=array();
        // $data['jobgrade_data']=array();
        // $data['employee_data']=array();
        // $data['employee_data_approval']=array();
        // $data['employee_group_data']=array();

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

        $data['months_array']=[];
        array_push($data['months_array'], ['id'=>date('m', strtotime('-1 months')),'text'=>date('F', strtotime('-1 months'))]);
        array_push($data['months_array'], ['id'=>date('m'),'text'=>date('F')]);
        array_push($data['months_array'], ['id'=>date('m', strtotime('+1 months')),'text'=>date('F', strtotime('+1 months'))]);
        array_push($data['months_array'], ['id'=>date('m', strtotime('+2 months')),'text'=>date('F', strtotime('+2 months'))]);
        $payrollPermissionassing=collect(DB::table('payroll_permissions_assign')->where('employee_id', Auth::guard('user')->user()->employee_id)->where('valid', 1)->get())->pluck('assign_id')->toArray();
        $data['payrollPermissions']=array();

        $payrollPermission=PayrollPermission::valid()->project()->whereIn('id', $payrollPermissionassing)->get();
        foreach ($payrollPermission as $value) {
            array_push($data['payrollPermissions'], ['id'=>$value['id'],'text'=>$value['permission_group']]);
        }

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
        // $data['employee_data'] = $employee_list->report_filter_data()['employee_data'];
        $data['AllemployeeData']=$data['employee_data'] = $employee_list->report_filter_data()['employee_data'];
        $data['sbu_name_value'] = [
          'id'=>21,
          'text'=>'Gem Jute Ltd.'
        ];
        $data['sbu_id'] = 21;
        return response()->json($data);
    }

    public function payrollprocess_fiends(Request $request)
    {
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '0');
        $from_date = date('Y-m-d', strtotime($request->input('weekly_from_date')));
        $to_date = date('Y-m-d', strtotime($request->input('weekly_to_date')));
        
        $employee_list = new Employee();
        $employee_ids=$employee_list->Employee_id();
        $employee_id=$employee_ids['employee_id'];
        $employee_data_approval=[];
        $fist_date_of_month=date('Y').'-'.$request->months_id.'-'.'01';
        $dt=date_create($fist_date_of_month);
        $dt->modify('last day of this month');
        $last_date_of_month= date_format($dt, "Y-m-d");
        // ->whereIn('employee_designation,',[411,413])
        if ($request['process_type']==2) {
            $payrolInfo=DailyProduction::leftJoin('employees', 'employees.id', '=', 'daily_production_entries.employee_id')
              ->whereBetween('production_date',[$from_date,$to_date])
              // ->where('salary_goes_to',$request['salary_type_id'])
              ->where('employees.salary_duration_type', 1)
              ->where('daily_production_entries.valid', 1)
              ->where('sbu_id', $request['id']);

            if (!empty($request['employeeId'])) {
                $payrolInfo->where('daily_production_entries.employee_id', $request['employeeId']);
            }
        } elseif($request['process_type'] == 4){
            $payrolInfo=DailyProduction::leftJoin('employees', 'employees.id', '=', 'daily_production_entries.employee_id')
              ->whereBetween('production_date',[$from_date,$to_date])
              // ->where('salary_goes_to',$request['salary_type_id'])
              ->where('employees.salary_duration_type', 1)
              ->where('daily_production_entries.valid', 1)
              ->where('sbu_id', $request['id'])
              ->whereIn('employee_designation',[411,413]);
            if (!empty($request['employeeId'])) {
                $payrolInfo->where('daily_production_entries.employee_id', $request['employeeId']);
            }
        //     $payrolInfo=Salary::valid()
        //     ->leftJoin('employees', 'employees.id', '=', 'salaries.employee_id')
        //   //   ->where('confirmation_date', '<=', date('Y-m-d'))
        //     ->where('salary_goes_to', $request['salary_type_id'])
        //     ->where('employees.employee_salary_type', 2)
        //     ->whereIn('employee_designation',[411,413])
        //     ->where('salary_sbu_id', $request['id']);
        //   if (!empty($request['employeeId'])) {
        //       $payrolInfo->where('salaries.employee_id', $request['employeeId']);
        //   }
            // $payrolInfo=DailyProduction::leftJoin('employees', 'employees.id', '=', 'daily_production_entries.employee_id')
            // ->whereBetween('production_date',[$from_date,$to_date])
            // // ->where('salary_goes_to',$request['salary_type_id'])
            // ->where('employees.salary_duration_type', 1)
            // ->where('daily_production_entries.valid', 1)
            // ->where('sbu_id', $request['id']);

            // if (!empty($request['employeeId'])) {
            //     $payrolInfo->where('daily_production_entries.employee_id', $request['employeeId']);
            // }
        } else {
            $payrolInfo=Salary::valid()
              ->leftJoin('employees', 'employees.id', '=', 'salaries.employee_id')
            //   ->where('confirmation_date', '<=', date('Y-m-d'))
              ->where('salary_goes_to', $request['salary_type_id'])

              ->where('employees.salary_duration_type', 1);
            //   ->where('salary_sbu_id', $request['id']);
            // employee_salary_type

            if (!empty($request['employeeId'])) {
                $payrolInfo->where('salaries.employee_id', $request['employeeId']);
            }
        }

        if (!empty($request['section_id'])) {
            $payrolInfo->where('employees.employee_section', $request['section_id']);
        }
        if (!empty($request['unit_id'])) {
            $payrolInfo->where('employees.employee_unit', $request['unit_id']);
        }
        if (!empty($request['subunit_id'])) {
            $payrolInfo->where('employees.employee_sub_unit', $request['subunit_id']);
        }
        if (!empty($request['department_id'])) {
            $payrolInfo->where('employees.employee_department', $request['department_id']);
        }
        if (!empty($request['section_id'])) {
            $payrolInfo->where('employees.employee_section', $request['section_id']);
        }
        if (!empty($request['subsection_id'])) {
            $payrolInfo->where('employees.employee_sub_section', $request['subsection_id']);
        }
        if (!empty($request['employee_work_location'])) {
            $payrolInfo->where('employees.employee_work_location', $request['employee_work_location']);
        }
        if (!empty($request['process_type'])) {
            if ($request['process_type']==4) {
                $payrolInfo->whereIn('employees.employee_salary_type', ['1','2','3']);
            } else {
                $payrolInfo->where('employees.employee_salary_type', $request['process_type']);
            }
        }
        $payrolInfo=$payrolInfo->where('employee_status',1)->orderBy('employees.id')->get();
        //return response()->json($payrolInfo);
        $payrolInfo_employee_id=collect($payrolInfo)->pluck('employee_id')->toArray();
       

        // $payrolInfo_employee_designation=collect($payrolInfo)->pluck('employee_designation')->toArray();
        $payrollPermission=PayrollPermission::valid()->project()
                    ->where('id', $request['salary_grade'])->first();
        $jobGrade=array();
        if (!empty($payrollPermission)) {
            for ($x =$payrollPermission['permission_grade_start']; $x <= $payrollPermission['permission_grade_end']; $x++) {
                $jobGrade[]=$x;
            }
        }

        $payroll_employee=DB::table('payroll_process')
                          ->join('payroll', 'payroll_process.id', '=', 'payroll.procsid')
                          ->whereDate('startdate', '=', $fist_date_of_month)
                          ->whereDate('enddate', '=', $last_date_of_month)
                          ->where('payroll_process.valid', 1)
                          ->where('payroll_process.type', $request['salary_type_id'])
                          ->where('settlement', 2)
                          ->get();
        $payrollEmployyId=collect($payroll_employee)->pluck('empid')->toArray();
        if ($request['process_type']==4){
            $departmentId = collect(collect($payrolInfo)->unique('employee_department')->values()->all())->pluck('employee_department')->toArray();
            $TrpayrollData = PayrollList::valid()->project()
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            // ->leftJoin('attendance_setups', 'attendance_setups.employee_id', '=', 'payroll.empid')
            ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'payroll.shift_id')
            ->leftJoin('office_time_setups as psShift', 'psShift.id', '=', 'payroll.ps_id')
            ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->selectRaw(
                'employees.employee_department,employees.employee_id_no,employees.employee_fullname,
                payroll.shift_id,payroll.empid,psShift.title as present_shift_name,payroll.empid,
                office_time_setups.title as shift_name,payroll.gross_salary,payroll.attendance_bonus,payroll.paydays as prtot, 
                payroll.gross_salary as g_salary, payroll.netpay as net_wages,
                sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,
                sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,
                designations.designation_name,payroll.overtime,payroll.arear,payroll.night_allownce as night_allownce,
                payroll.residential_allowance,payroll.deduction_canteen,
                payroll_process.remarks as process_type,
                
                (gross_salary+overtime+night_allownce+attendance_bonus+residential_allowance+arear) as final_total_wages,
                (deduction_others+deduction_canteen+deduction_uniform) as total_deduction'
                
            )
            ->whereDate('payroll_process.startdate', '>=', $from_date)
            ->whereDate('payroll_process.enddate', '<=', $to_date)
            ->where('payroll_process.remarks', 2)
            ->where('employees.employee_sbu', $request['id']);
            if (count($departmentId) > 0) {
                $TrpayrollData->whereIn('employee_department', $departmentId);
            }
        
            $TrpayrollDatas = $TrpayrollData->get()->toArray();
        }




        $employee_data=Employee::valid()->project()
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
            ->leftJoin('employee_bank_account_details', 'employee_bank_account_details.ebc_employee_id', '=', 'employees.id')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('unit_models', 'unit_models.id', '=', 'employees.employee_unit')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->select(
                'employees.*',
                'company_sbus.sbu_name',
                'job_grades.jobgrade_name',
                'employee_bank_account_details.ebc_account_number',
                'employee_personal_infos.employee_gender',
                'employee_personal_infos.employee_dob_certificate',
                'designations.designation_name',
                'designations.priority',
                'departments.department_name',
                'unit_models.unit_name',
                'sub_units.sub_unit_name'
            )
            ->whereNotIn('employees.id', $payrollEmployyId)
            ->whereIn('employees.id', $payrolInfo_employee_id)
            // ->whereIn('job_grades.priority',$jobGrade)
            ->orderBy('designations.priority')
            ->get();
        $employee_all_id=collect($employee_data)->pluck('employee_id_no')->toArray();
        $employee_all_idno=collect($employee_data)->pluck('id')->toArray();
        $attendanceInfo=DB::table('attendance')
                        ->whereDate('pdate', '>=', $from_date)
                        ->whereDate('pdate', '<=', $to_date)
                        ->whereIn('employee_card_no', $employee_all_id)
                        ->get();
                        

        $overtime_datas=DB::table('over_times')
                      ->where('ot_status', 1)
                      ->where('valid', 1)->get();

        $weekly_bonus_ot = DB::table('weekly_bonus_settings')
                        ->where('status', 1)
                        ->where('company_sbu_id', $request['id'])
                        ->where('valid', 1)->get();

        $shifting_data=DB::table('attendance_setups')
                      ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
                      ->select('attendance_setups.*', 'office_time_setups.title as shift_name', 'office_time_setups.id as shift_id')
                      ->whereIn('employee_id', $payrolInfo_employee_id)
                      ->whereDate('attendance_setups.start_date', '<=', $to_date)
                      ->whereDate('attendance_setups.end_date', '>=', $from_date)
                      ->where('office_type',1)
                      ->where('attendance_setups.valid', 1)->get();

        $one_day_past = date('Y-m-d', strtotime($to_date . ' +2 day'));

        $find_present_shift = DB::table('attendance_setups')
        ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
        ->select('office_time_setups.title as present_shift_name', 'attendance_setups.employee_id', 'office_time_setups.id as present_shift_id')
        ->whereIn('attendance_setups.employee_id', $payrolInfo_employee_id)
        ->whereDate('attendance_setups.start_date', $one_day_past)
        // ->whereDate('attendance_setups.end_date', '>=', $one_day_past)
        ->where('attendance_setups.valid', 1)
        ->where('office_type',1)
        ->get();
        // return response()->json([$find_present_shift,$payrolInfo_employee_id,$one_day_past]);
        $additionalAllowances=DB::table('additional_allowances')
                      // ->where('company_sbu_id',$request['id'])
                      ->whereDate('additional_date', '>=', $from_date)
                      ->whereDate('additional_date', '<=', $to_date)
                      ->where('salary_goes_to', $request['salary_type_id'])
                      ->where('valid', 1)->get();
        // return response()->json($additionalAllowances);
        $mobileAddition=DB::table('sim_assignings')
                      ->where('company_sbu_id', $request['id'])
                      ->where('sim_assign_status', 1)
                      ->where('valid', 1)->get();

        $mobileInternetBills = DB::table('mobile_internet_bills')
                     ->where('company_sbu_id', $request['id'])
                     ->whereDate('bill_date', '>=', $from_date)
                     ->whereDate('bill_date', '<=', $to_date)
                     ->where('bill_status', 1)
                     ->where('bill_types', 3)
                     ->where('valid', 1)->get();

        $salary_deductions = DB::table('salary_deductions')
                      ->where('company_sbu_id', $request['id'])
                      ->whereDate('deduction_date', '>=', $from_date)
                      ->whereDate('deduction_date', '<=', $to_date)
                      ->where('valid', 1)->get();

        $others_cant_deductions = DB::table('others_deduction')
                      ->where('company_sbu_id', $request['id'])
                      ->whereDate('deduction_date', '>=', $from_date)
                      ->whereDate('deduction_date', '<=', $to_date)
                      ->where('valid', 1)->get();


        $uniform_advance = DB::table('deduction_option')
                      ->where('company_sbu_id', $request['id'])
                      ->where('loan_status', 1)
                      ->where('loan_clearance_status', 2)
                      ->where('valid', 1)->get();

        // 901459
        // 901459
        $total_salary=0;
        foreach ($employee_data as $key => $value) {
            $employee_data[$key]['ot_time']=collect($attendanceInfo)->where('employee_id', $value->id)->sum('ot_entry') ?? collect($attendanceInfo)->where('employee_id', $value->id)->sum('ot_time') ?? 0;
            $employee_shift_info=collect($shifting_data)->where('employee_id', $value->id)->first();
            $employee_present_shift_info=collect($find_present_shift)->where('employee_id', $value->id)->first();
            // return response()->json($employee_present_shift_info->present_shift_id);
            $employee_data[$key]['shift_name']=isset($employee_shift_info->shift_name) ? $employee_shift_info->shift_name : '-';
            $employee_data[$key]['present_shift_name']= isset($employee_present_shift_info->present_shift_name) ? $employee_present_shift_info->present_shift_name : '-';
            $employee_data[$key]['shift_name_id']=isset($employee_shift_info->shift_id) ? $employee_shift_info->shift_id : '';
            $employee_data[$key]['present_shift_name_id']= isset($employee_present_shift_info->present_shift_id) ? $employee_present_shift_info->present_shift_id : '';
            $atteentdsPas = collect($attendanceInfo)->where('employee_id', $value->id)->whereIn('pstatus', [1,2])->where('remarks', 'Weekend')->groupBy('pdate')->count();
            if($atteentdsPas <= 5){
                $employee_data[$key]['prtot'] = $atteentdsPas;
                $employee_data[$key]['holiday']= 0;
            }else{
                $employee_data[$key]['prtot'] = 5;
                $employee_data[$key]['holiday']= ($atteentdsPas -5);
            }
            
            // $employee_data[$key]['holiday']= collect($attendanceInfo)->where('employee_id', $value->id)->whereIn('pstatus', [4,5])->groupBy('pdate')->count();

            if(($employee_data[$key]['prtot']) <= 5){
                $totalDaays = ($employee_data[$key]['prtot']);
            }else{
                $totalDaays = 5;
            }
            $employee_data[$key]['total_pd_hd'] = $totalDaays;
            $employee_data[$key]['pay_day'] = $totalDaays;
            $employee_data[$key]['attendance_bonus_get'] = $value->attendance_bonus_get;




            $employee_data[$key]['attendance_bonus'] = 0;
            if (!empty($weekly_bonus_ot)) {
                $weekly_bonus_otInfos = collect($weekly_bonus_ot)->where('bonus_ot_type', 1)->toArray();
                $idas =[];
                // $idas1 =[];
                foreach ($weekly_bonus_otInfos as $key2 => $siftA) {
                    if (!empty($siftA)) {
                        if ($employee_data[$key]['total_pd_hd'] <= $siftA->office_day && $employee_data[$key]['total_pd_hd'] >= $siftA->office_day && $siftA->bonus_ot_type == 1) {
                            $employee_data[$key]['attendance_bonus'] = $siftA->bonus_ot_amount;
                        }
                    }
                }
            } else {
                $employee_data[$key]['attendance_bonus'] = 0;
            }
        //    return response()->json($employee_data[$key]['attendance_bonus']);
            $employee_data[$key]['night_allownce'] = 0;
            if (!empty($employee_shift_info->shift_id)) {
                $shift_infos = collect($weekly_bonus_ot)->where('shift_id', $employee_shift_info->shift_id)->where('bonus_ot_type', 4)->toArray();
                if (!empty($shift_infos)) {
                    foreach ($shift_infos as $key3 => $sifts) {
                        if (!empty($sifts)) {
                            if ($employee_data[$key]['total_pd_hd'] <= $sifts->office_day && $employee_data[$key]['total_pd_hd'] >= $sifts->office_day && $sifts->bonus_ot_type == 4) {
                                $employee_data[$key]['night_allownce'] = $sifts->bonus_ot_amount;
                            }
                        }
                    }
                }
            } else {
                $employee_data[$key]['night_allownce'] = 0;
            }


            if ($value->employee_salary_type == 3) {
                $employee_data[$key]['residential_allowance'] = 0;
                if(!empty($employee_shift_info)){
                    
                    if($employee_shift_info->shift_id == 40 || $employee_shift_info->shift_id == 39){
                        $weeklyBonusOt = collect($weekly_bonus_ot)->where('office_day',$employee_data[$key]['total_pd_hd'])->where('shift_id', $employee_shift_info->shift_id)->where('bonus_ot_type', 2)->toArray();
                        // return response()->json($weeklyBonusOt);
                        foreach ($weeklyBonusOt as $key1 => $value1) {
                            if ($value1->bonus_ot_type == 2 && $employee_data[$key]['total_pd_hd'] = $value1->office_day && $employee_data[$key]['ot_time'] >= 24) {
                                $employee_data[$key]['residential_allowance'] =200; //$value1->bonus_ot_amount;
                                //return response()->json([]);
                                break;
                            } elseif ($value1->bonus_ot_type == 2 && $employee_data[$key]['total_pd_hd'] = $value1->office_day && $employee_data[$key]['ot_time']  <= 24 && $employee_data[$key]['ot_time'] >= 20) {
                                $employee_data[$key]['residential_allowance'] = 200; //$value1->bonus_ot_amount;
                                break;
                            } elseif ($value1->bonus_ot_type == 2 && $employee_data[$key]['total_pd_hd'] = $value1->office_day && $employee_data[$key]['ot_time']  <= 20 && $employee_data[$key]['ot_time'] >= 16) {
                                $employee_data[$key]['residential_allowance'] = 160; //$value1->bonus_ot_amount;
                                break;
                            } else {
                                $employee_data[$key]['residential_allowance'] = 0;
                            }
                        }
                    }else{
                        $weeklyBonusOtScoryt = collect($weekly_bonus_ot)->where('office_day',$employee_data[$key]['total_pd_hd'])->where('bonus_ot_type', 2)->toArray();
                        foreach ($weeklyBonusOtScoryt as $key1 => $value3) {
                           
                            if ($value3->bonus_ot_type == 2 && $employee_data[$key]['total_pd_hd'] = $value3->office_day && $employee_data[$key]['ot_time']  >= 24) {
                                $employee_data[$key]['residential_allowance'] = 200;
                                //$value3->bonus_ot_amount; //$value1->bonus_ot_amount;
                                break;
                            } elseif ($value3->bonus_ot_type == 2 && $employee_data[$key]['total_pd_hd'] = $value3->office_day && $employee_data[$key]['ot_time']  <= 24 && $employee_data[$key]['ot_time'] >= 20) {
                                $employee_data[$key]['residential_allowance'] = 200;
                                //$value3->bonus_ot_amount; //$value1->bonus_ot_amount;
                                break;
                            } elseif ($value3->bonus_ot_type == 2 && $employee_data[$key]['total_pd_hd'] = $value3->office_day && $employee_data[$key]['ot_time']  <= 20 && $employee_data[$key]['ot_time'] >= 16) {
                                
                                $employee_data[$key]['residential_allowance'] =160; 
                                //$value3->bonus_ot_amount; //$value1->bonus_ot_amount;
                                break;
                            } else {
                                $employee_data[$key]['residential_allowance'] = 0;
                            }
                        }

                    }

                } else {
                    $employee_data[$key]['residential_allowance'] = 0;
                }
            }
            // return response()->json($value1->office_day);

            // $employee_data[$key]['lttot']=collect($attendanceInfo)->where('employee_id',$value->id)->where('pstatus',2)->count();
            // $employee_data[$key]['abtot']=collect($attendanceInfo)->where('employee_id',$value->id)->where('pstatus',3)->count();
            // $employee_data[$key]['whtot']=collect($attendanceInfo)->where('employee_id',$value->id)->whereIn('pstatus',['4','5'])->count();
            // $employee_data[$key]['levtot']=collect($attendanceInfo)->where('employee_id',$value->id)->where('pstatus',6)->count();
            // $employee_data[$key]['total']=collect($attendanceInfo)->where('employee_id',$value->id)->count();
            // $employee_data[$key]['pay_day']=(collect($attendanceInfo)->where('employee_id',$value->id)->count()-collect($attendanceInfo)->where('employee_id',$value->id)->where('pstatus',3)->count());

            $ot_hour_rate = collect($overtime_datas)->where('employee_id', $value->id)->sum('hour_rate');
            $employee_data[$key]['ot_hour_rate'] = $ot_hour_rate;

            if ($request->process_type == 2) {
                $g_salary = collect($payrolInfo)->where('employee_id', $value->id)->sum('amount');
                $ot_qty = collect($payrolInfo)->where('employee_id', $value->id)->sum('product_qt_quantity');
                $product_rate = collect($payrolInfo)->where('employee_id', $value->id)->sum('product_rate');
                $ot_amount = $ot_qty*$product_rate;
                $employee_data[$key]['g_salary'] = round($g_salary);
                $employee_data[$key]['net_wages'] = round($g_salary);
                $employee_data[$key]['ot_wages'] = isset($ot_amount) ? $ot_amount : 0;
            } elseif($request->process_type == 4){
                // TrpayrollDatas
                // $getDataTr = collect($TrpayrollDatas)->where('employee_department',$value->employee_department)
                //             ->where('shift_id',$employee_data[$key]['shift_name_id'])->sortBy('gross_salary')->toArray();
                // if(count($getDataTr) > 12 ){

                // }else{

                // }
                            //gross_salary
                $g_salary = collect($payrolInfo)->where('employee_id', $value->id)->sum('amount');
                $ot_qty = collect($payrolInfo)->where('employee_id', $value->id)->sum('product_qt_quantity');
                $product_rate = collect($payrolInfo)->where('employee_id', $value->id)->sum('product_rate');
                $ot_amount = $ot_qty*$product_rate;
                $employee_data[$key]['g_salary'] = round($g_salary);
                $employee_data[$key]['net_wages'] = round($g_salary);
                $employee_data[$key]['ot_wages'] = isset($ot_amount) ? $ot_amount : 0;

            } else {
                $g_salary=collect($payrolInfo)->where('employee_id', $value->id)->sum('gross_salary');
                $employee_data[$key]['g_salary'] = round($g_salary);
                $employee_data[$key]['net_wages'] = round($g_salary*$employee_data[$key]['prtot']);
                $employee_data[$key]['ot_wages']= round(($g_salary/8)*$employee_data[$key]['ot_time']);
            }


            $overTime_comperensation=collect($payrolInfo)->where('employee_id', $value->id)->sum('overtime_work_compensation');
            $employee_data[$key]['overTime_comperensation']=$overTime_comperensation;
            $p_fund=collect($payrolInfo)->where('employee_id', $value->id)->sum('provident_fund_amount');
            $arrear_amount=collect($additionalAllowances)->where('additional_allow_type', 1)->where('employee_id', $value->id)->sum('additional_amount');
            $employee_data[$key]['arrear_amount']=$arrear_amount;
            if ($request['salary_type_id']==2) {
                // Addition allowance
                $mobile_addition=collect($mobileAddition)->where('sim_assign_to', $value->id)->sum('sim_ceiling_limit');
                $employee_data[$key]['mobile_addition']=$mobile_addition;
                $car_allowance=collect($payrolInfo)->where('employee_id', $value->id)->sum('car_allowance_amount');
                $employee_data[$key]['car_allowance']=$car_allowance;
                $other_allowance=collect($payrolInfo)->where('employee_id', $value->id)->sum('others_allowance');
                $employee_data[$key]['other_allowance']=$other_allowance;
                $totalAddition=($arrear_amount+$mobile_addition+$car_allowance+$other_allowance);
                // Addition allowance
                // Deduction
                $employeeLoans=collect($uniform_advance)->where('employee_id', $value->id)->first();
                if (!empty($employeeLoans)) {
                    if ($employeeLoans->loan_deduct_policy == 1) {
                        $ad_or_lone=round(($employeeLoans->loan_amount/$employeeLoans->no_of_installment));
                        $employee_data[$key]['uniform_ad_or_lone']= $uniform = $ad_or_lone;
                        $employee_data[$key]['loan_deduct_policy']=1;
                    } else {
                        $ad_or_lone=collect($salary_deductions)->where('employee_id', $value->id)->sum('deduction_amount');
                        $employee_data[$key]['loan_deduct_policy']=2;
                        $employee_data[$key]['uniform_ad_or_lone']= $uniform = $ad_or_lone;
                    }
                } else {
                    $ad_or_lone=0;
                    $employee_data[$key]['uniform_ad_or_lone']= $uniform = $ad_or_lone;
                }

                // $uniform=collect($uniform_advance)->where('loan_type',1)->where('employee_id',$value->id)->sum('loan_amount');
                $employee_data[$key]['uniform']=$uniform;

                $canteen_amount=collect($others_cant_deductions)->where('deduction_type_id', 2)->where('employee_id', $value->id)->sum('deduction_amount');
                $employee_data[$key]['canteen_amount']=$canteen_amount;
                $dad_deduction = collect($others_cant_deductions)->where('deduction_type_id', 5)->where('employee_id', $value->id)->sum('deduction_amount');
                $employee_data[$key]['dad_deduction']=$dad_deduction;
                

                $other_amount=collect($others_cant_deductions)->where('deduction_type_id', 4)->where('employee_id', $value->id)->sum('deduction_amount');
                $employee_data[$key]['other_amount']=$other_amount;
            } else {
                $canteen_amount=collect($others_cant_deductions)->where('deduction_type_id', 2)->where('employee_id', $value->id)->sum('deduction_amount');
                $employee_data[$key]['canteen_amount']=$canteen_amount;
                $dad_deduction = collect($others_cant_deductions)->where('deduction_type_id', 5)->where('employee_id', $value->id)->sum('deduction_amount');
                $employee_data[$key]['dad_deduction']=$dad_deduction;
                $other_amount=collect($others_cant_deductions)->where('deduction_type_id', 4)->where('employee_id', $value->id)->sum('deduction_amount');
                $employee_data[$key]['other_amount']=$other_amount;
                // $ad_or_lone=0;
                // $employee_data[$key]['ad_or_lone']=$ad_or_lone;

                $employeeLoans=collect($uniform_advance)->where('employee_id', $value->id)->first();

                if (!empty($employeeLoans)) {
                    if ($employeeLoans->loan_deduct_policy == 1) {
                        $ad_or_lone=round(($employeeLoans->loan_amount/$employeeLoans->no_of_installment));
                        $employee_data[$key]['uniform_ad_or_lone']= $uniform = $ad_or_lone;
                        $employee_data[$key]['loan_deduct_policy']=1;
                    } else {
                        $ad_or_lone=collect($salary_deductions)->where('employee_id', $value->id)->sum('deduction_amount');
                        $employee_data[$key]['loan_deduct_policy']=2;
                        $employee_data[$key]['uniform_ad_or_lone']= $uniform = $ad_or_lone;
                    }
                } else {
                    $ad_or_lone=0;
                    $employee_data[$key]['uniform_ad_or_lone']= $uniform = $ad_or_lone;
                }
                $employee_data[$key]['uniform']=$uniform;
            }



            // final total wages for factory
            $totalDeduction=($uniform+$other_amount+$canteen_amount+$dad_deduction);
            $employee_data[$key]['total_deduction']=$totalDeduction;
            $employee_data[$key]['final_total_wages']= $g_payble = $employee_data[$key]['net_wages']+$employee_data[$key]['ot_wages']+$employee_data[$key]['attendance_bonus']+$employee_data[$key]['night_allownce']+$employee_data[$key]['residential_allowance']+$employee_data[$key]['arrear_amount'];
            $employee_data[$key]['g_payble']=$g_payble;
            $total_salary+=($g_payble-$totalDeduction);
            $employee_data[$key]['final_net_wages']=$employee_data[$key]['final_total_wages']-$totalDeduction;
            if($request['process_type'] == 4){
                $process_type = 2;
            }else{
                $process_type = $request['process_type'];
            }
            $employee_data[$key]['process_type']= $process_type;
        }
        $employeeData['fist_date_of_month']=$from_date;
        $employeeData['last_date_of_month']=$to_date;
        $employeeData['employee_sbu_id']=$request['id'];
        $employeeData['salary_type_id']=$request['salary_type_id'];
        $employeeData['months_id']=$request->months_id;
        $employeeData['total_salary']=$total_salary;
        $employeeData['salary_type']=$request['salary_type_id'];

        $data['payroll_employee_data']=$employee_data;
        $data['employeeData']=$employeeData;
        if($request['process_type'] == 4){
            $process_type = 2;
        }else{
            $process_type = $request['process_type'];
        }
        $data['process_type'] = $process_type;
        return response()->json($data);
    }

    public function store(Request $request)
    {
        // $month_num =date("F", mktime(0, 0, 0, $request->employeeData['fist_date_of_month'], 10));
        // return response($request);
        $month_num = date('F', strtotime($request->employeeData['fist_date_of_month']));
        try {
            DB::beginTransaction();
            // $payroll_process_check = PayrollProcessList::where('type',$request->employeeData['salary_type_id'])
            // ->where('companysbu_id',$request->employeeData['employee_sbu_id'])
            // ->whereDate('startdate', '<=', $request->employeeData['fist_date_of_month'])
            // ->whereDate('enddate', '>=', $request->employeeData['last_date_of_month'])
            // ->where('valid',1)
            // ->first();
            $collect_employee_id = collect($request->payroll_employee_data)->pluck('id')->toArray();
            if (!empty($collect_employee_id)) {
                $employee_checking = PayrollList::leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')->where('payroll_process.companysbu_id', $request->employeeData['employee_sbu_id'])
                        ->whereDate('payroll_process.startdate', '<=', $request->employeeData['fist_date_of_month'])
                        ->whereDate('payroll_process.enddate', '>=', $request->employeeData['last_date_of_month'])
                        ->where('payroll_process.valid', 1)
                        // ->where('payroll_process.settlement', 2)
                        ->whereIn('empid', $collect_employee_id)->where('payroll.valid', 1)->get();
            }
            if (count($employee_checking)>0) {
                $message=['status' => 0, 'message' => 'Payroll already processed for this week!'];
                return response()->json($message);
            }
            $payroll_process=[
                    "companysbu_id"=>$request->employeeData['employee_sbu_id'],
                    "paymonth"=>$month_num,
                    "process_date"=>date('Y-m-d'),
                    "startdate"=>$request->employeeData['fist_date_of_month'],
                    "enddate"=>$request->employeeData['last_date_of_month'],
                    "remarks"=>$request->process_type,
                    "type"=>$request->employeeData['salary_type_id'],
                    "salary_weekly_monthly"=>1,
                    "total_salary_amount"=>round($request->employeeData['total_salary']),
                    "status"=>1,
                    "settlement"=>1,
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

            // return response($employee_data);
            foreach ($employee_data as $key => $value) {
                $payroll[]=[
                  "procsid"=>$save_id->id,
                  "companysbu_id"=>$value['employee_sbu'],
                  "empid"=>$value['id'],
                  "shift_id" => $value['shift_name_id'],
                  "ps_id" => $value['present_shift_name_id'],
                  "gross_salary"=>$value['g_salary'] ?? 0,
                  "attendance_bonus"=>$value['attendance_bonus'] ?? 0,
                  "night_allownce"=>$value['night_allownce'] ?? 0,
                  "residential_allowance"=>$value['residential_allowance'] ?? 0,
                  "basic"=>0,
                  "houserent"=>0,
                  "medical"=>0,
                  "transport"=>0,
                  "overtime"=>$value['ot_wages'] ?? 0,
                  "stdays"=>$value['prtot'],
                  "paydays"=>$value['prtot'],
                  "arear"=>$value['arrear_amount'],
                  "additional_mobile"=>0,
                  "car_allowance"=>0,
                  "allowance"=>0,
                  "deduction_pfbasic"=>0,
                  "deduction_others"=>$value['other_amount'],
                  "deduction_canteen"=>$value['canteen_amount'],
                  "deduction_uniform"=>$value['uniform'],
                  "deduction_deposit"=>0,
                  "late_abset_deduction"=> $value['dad_deduction'],
                  "deduction_mobilebill"=>0,
                  "deduction_loan"=>0,
                  "deduction_tax"=>0,
                  "netpay"=>round($value['final_net_wages']),
                  "remarks"=>$request->process_type,
                  "project_id"=>Auth::guard('user')->user()->project_id,
                  "branch_id"=>Auth::guard('user')->user()->branch_id,
                  "created_by"=>Auth::guard('user')->user()->id,
                  "created_at"=>date('Y-m-d H:i:s'),
                ];
            }
            // ProvidentFund::insert($p_fund);
            PayrollList::insert($payroll);
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

      public function weekly_payroll_report()
      {
          $employee_list = new Employee();
        //   $employee_ids = $employee_list->Employee_id();
        //   $employee_id = $employee_ids['employee_id'];
          $data['AllcompanySbuData'] = array();
        //   $data['company_sbu_data'] = $employee_list->report_filter_data()['company_sbu_data'];
          
          $data['AllsectionData'] = array();
        //   $data['section_data'] = $employee_list->report_filter_data()['section_data'];
          $data['AllsubSectionData'] = array();
        //   $data['sub_section_data'] = $employee_list->report_filter_data()['sub_section_data'];
          $data['AllsubUnitData'] = array();
        //   $data['sub_unit_data'] = $employee_list->report_filter_data()['sub_unit_data'];
          $data['AllunitData'] = array();
        //   $data['unit_data'] = $employee_list->report_filter_data()['unit_data'];
          $data['AllworkLocationData'] = array();
        //   $data['work_location_data'] = $employee_list->report_filter_data()['work_location_data'];
          $data['AlldepartmentData'] = array();
          $data['AllemployeeData'] = $data['AllemployeeData']=$data['employee_data'] = $employee_list->report_filter_data()['employee_data'];
        //   $data['department_data'] = $employee_list->report_filter_data()['department_data'];
        //   $officeTime = OfficeTimeSetup::valid()->project()->whereIn('type', ['2', '3'])->where('office_time_status', 1)->orderBy('priority', 'ASC')->get();
        //   $data['officeTime'] = array();
        //   foreach ($officeTime as $value) {
        //       array_push($data['officeTime'], ['id' => $value['id'], 'text' => $value['title'] . " [ " . date('h:i A', strtotime($value['office_start_time'])) . " - " . date('h:i A', strtotime($value['office_end_time'])) . " ] "]);
        //   }
        $data['company_sbu_data'] = array();
        $data['employee_data'] = array();
        $data['designation_data'] = array();

        $data['section_data'] = array();
        $data['sub_section_data'] = array();
        $data['sub_unit_data'] = array();
        $data['unit_data'] = array();
        $data['work_location_data'] = array();
        $data['department_data'] = array();
        $data['officeTime'] = array();
        //   $designation_data = Designation::valid()->project()->whereIn('id', $employee_ids['designation'])->orderBy('priority', 'ASC')->get();
        //   $jobgrade_data = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get();
        //   $employee_data_approval = Employee::valid()->project()->whereIn('employee_sbu', $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->get();
        //   $employee_group_data = EmployeeGroup::valid()->project()->orderBy('priority', 'ASC')->get();
        //   array_push($data['employee_group_data'], ['id' => '', 'text' => 'All Select']);
        //   foreach ($employee_group_data as $value) {
        //       array_push($data['employee_group_data'], ['id' => $value['id'], 'text' => $value['employee_group_name']]);
        //   }
        //   array_push($data['designation_data'], ['id' => '', 'text' => 'All Select']);
        //   foreach ($designation_data as $value) {
        //       array_push($data['designation_data'], ['id' => $value['id'], 'text' => $value['designation_name']]);
        //   }
        $employee_sbu_list = CompanySbu::valid()->project()->get()->keyBy('id')->all();
          array_push($data['company_sbu_data'], ['id' => '', 'text' => 'All Select']);
          foreach ($employee_sbu_list as $value) {
              array_push($data['company_sbu_data'], ['id' => $value['id'], 'text' => $value['sbu_name']]);
          }

        $employee_department_list = Department::valid()->project()->get()->keyBy('id')->all();
          array_push($data['department_data'], ['id' => '', 'text' => 'All Select']);
          foreach ($employee_department_list as $value) {
              array_push($data['department_data'], ['id' => $value['id'], 'text' => $value['department_name']]);
          }

        $employee_worklocation_list = WorkLocation::valid()->project()->get()->keyBy('id')->all();
          array_push($data['work_location_data'], ['id' => '', 'text' => 'All Select']);
          foreach ($employee_worklocation_list as $value) {
              array_push($data['work_location_data'], ['id' => $value['id'], 'text' => $value['work_location_name']]);
          }

        $employee_data = Employee::valid()->project()->get()->keyBy('employee_id_no')->all();
          array_push($data['employee_data'], ['id' => '', 'text' => 'All Select']);
          foreach ($employee_data as $value) {
              array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . ':' . $value['employee_fullname'] . '-' . $value['designation_name']]);
          }
        //   array_push($data['employee_data_approval'], ['id' => '', 'text' => 'All Select']);
        //   foreach ($employee_data_approval as $value) {
        //       array_push($data['employee_data_approval'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . ':' . $value['employee_fullname'] . '-' . $value['designation_name']]);
        //   }
        $data['from_date'] = date('Y-m-d');
        $data['to_date'] = date('Y-m-d');

        $data['year_lists'] = [];
        $firstYear = (int)date('Y') - 50;
        $lastYear = (int)date('Y') + 10;
        for($i=$firstYear; $i<=$lastYear; $i++)
        {
            $data['year_lists'][] = $i;
        }
        $data['report_type'] = 0;
        return response($data);
      }
    // $report_type,$att_report_type,$employee_sbu,$from_date_formated,$to_date_formated,$checkedattcolsadd,$search_option
    public function get_weekly_report1(Request $request)
    {
        

           ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '0');
        $unit_value = collect($request->unit_value)->where('id','!=',0)->pluck('id');
        $sub_unit_value = collect($request->sub_unit_value)->where('id','!=',0)->pluck('id');
        $department_name_value = collect($request->department_name_value)->where('id','!=',0)->pluck('id');
        $designation_name_value = collect($request->designation_name_value)->where('id','!=',0)->pluck('id');
        $section_value = collect($request->section_value)->where('id','!=',0)->pluck('id');
        $sub_section_value = collect($request->sub_section_value)->where('id','!=',0)->pluck('id');
        $work_location_value = collect($request->work_location_value)->where('id','!=',0)->pluck('id');
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->where('id','!=',0)->pluck('id');
        
        if (!empty($request->OfficeTime)) {
            $OfficeTime = $request->OfficeTime['id'];
           }else{
            $OfficeTime = '';
           }
        $data['process_type'] = $request->process_type;
     
            $AllpayrollData = PayrollList::valid()->project()
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            // ->leftJoin('attendance_setups', 'attendance_setups.employee_id', '=', 'payroll.empid')
            ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'payroll.shift_id')
            ->leftJoin('office_time_setups as psShift', 'psShift.id', '=', 'payroll.ps_id')
            ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->selectRaw(
                'employees.employee_department,employees.employee_id_no,employees.employee_fullname,
                payroll.shift_id,payroll.empid,psShift.title as present_shift_name,
                office_time_setups.title as shift_name,payroll.gross_salary,payroll.attendance_bonus,payroll.paydays as prtot, 
                payroll.gross_salary as g_salary, payroll.netpay as net_wages,
                sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,
                sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,
                designations.designation_name,payroll.overtime,payroll.arear,payroll.night_allownce as night_allownce,
                payroll.residential_allowance,payroll.deduction_canteen,
                payroll_process.remarks as process_type, (gross_salary*paydays) as total_wages,
                
                ((gross_salary*paydays)+night_allownce+overtime+attendance_bonus+residential_allowance+arear) as final_total_wages,
                (deduction_others+deduction_canteen+deduction_uniform) as total_deduction'
                
            )
            ->whereDate('payroll_process.startdate', '>=', $from_date)
            ->whereDate('payroll_process.enddate', '<=', $to_date);
            if(!empty($request->process_type)){
                $AllpayrollData->where('payroll_process.remarks', $request->process_type);
            }
            if (!empty($OfficeTime)) {
                $AllpayrollData->where('shift_id', $OfficeTime);
            }
            if(count($company_sbu_id) > 0){
                $AllpayrollData->whereIn('employees.employee_sbu', $company_sbu_id);
            }
            
        
            if (count($unit_value) > 0) {
                $AllpayrollData->whereIn('employee_unit', $unit_value);
            }
            if (count($sub_unit_value) > 0) {
                $AllpayrollData->whereIn('employee_sub_unit', $sub_unit_value);
            }
        
            if (count($department_name_value) > 0) {
                $AllpayrollData->whereIn('employee_department', $department_name_value);
            }
            
            $payrollDataDetels = $AllpayrollData->get()->toArray();
            $data['TotalNet_wages'] = collect($payrollDataDetels)->sum('net_wages');
            $data['Twagess'] = collect($payrollDataDetels)->sum('total_wages');

        // }}
        $employee_all_id = collect($payrollDataDetels)->pluck('empid')->toArray();
        $attendanceInfo=DB::table('attendance')
                            ->whereDate('pdate', '>=', $from_date)
                        ->whereDate('pdate', '<=', $to_date)
                        ->whereDate('pdate', '<=', $to_date)
                        ->whereIn('employee_id', $employee_all_id)
                        ->get();
    //  foreach ($payrollDataDetels as $key => $value) {
    //     $payrollDataDetels[$key]['ot_time']=collect($attendanceInfo)->where('employee_id', $value['empid'])->sum('ot_entry') ?? collect($attendanceInfo)->where('employee_id', $value['empid'])->sum('ot_time') ?? 0;
    //     $payrollDataDetels[$key]['process_type'] = $request->process_type;

    // } 
    

        $reportType = collect($payrollDataDetels)->first();
        // return response($payrollDataDetels);
        $name = '';
        if(!empty($reportType)){
            if($reportType['process_type'] == 1 ){
                $name = 'Time Rate ';
            }else if($reportType['process_type'] == 2){
                $name = 'Production Based ';
            }else if($reportType['process_type'] == 3){
                $name = 'Residential Based ';
            }
        }
        // return response($payrollDataDetels);
        $data['payrollDataDetels'] = $payrollDataDetels;
        // 'Wages Sheet'.$reportType->remarks ?? ''. date('d M, Y',strtotime($from_date)). " To ". date('d M, Y',strtotime($to_date));
        // $repoerNamae = 'Wages Sheet '. $name .date('d M, Y',strtotime($from_date)). " To ". date('d M, Y',strtotime($to_date));
        // $data['report_name'] = $repoerNamae;
        // $data['print_date'] =  date('d M, Y');
        // $data['tAmount'] = collect($payrollDataDetels)->sum('g_salary');
        // $data['totAmount'] = collect($payrollDataDetels)->sum('overtime');
        // $data['tattBonus'] = collect($payrollDataDetels)->sum('attendance_bonus');
        // $data['tadjAmount'] = collect($payrollDataDetels)->sum('arear');
        // $data['tnightAlwnc'] = collect($payrollDataDetels)->sum('night_allownce');
        // $data['TrA'] = collect($payrollDataDetels)->sum('residential_allowance');
        // $data['totalAmount'] = collect($payrollDataDetels)->sum('final_total_wages');
        // $data['TCantDed'] = collect($payrollDataDetels)->sum('deduction_canteen');
        // $data['tdeduction_uniform'] = collect($payrollDataDetels)->sum('tdeduction_uniform');
        // $data['TOtherDeduct'] = collect($payrollDataDetels)->sum('deduction_others');
        // $data['TotalDeduction'] = collect($payrollDataDetels)->sum('total_deduction');
        // $data['NetAmoun'] = ($data['totalAmount']- $data['TotalDeduction']) ?? 0;
         // return response($data);



        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '0');
        $unit_value = collect($request->unit_value)->pluck('id');
        $sub_unit_value = collect($request->sub_unit_value)->pluck('id');
        $department_name_value = collect($request->department_name_value)->pluck('id');
        $designation_name_value = collect($request->designation_name_value)->pluck('id');
        $section_value = collect($request->section_value)->pluck('id');
        $sub_section_value = collect($request->sub_section_value)->pluck('id');
        $work_location_value = collect($request->work_location_value)->pluck('id');

        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->pluck('id');
        $AllpayrollData = PayrollList::valid()->project()
          ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
          ->leftJoin('attendance_setups', 'attendance_setups.employee_id', '=', 'payroll.empid')
          ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
          ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->selectRaw(
              'employees.employee_department,payroll.gross_salary,payroll.attendance_bonus,sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,designations.designation_name,office_time_setups.title,office_time_setups.id as seft_id'
          )
          // ->whereDate('payroll_process.startdate', '=', $from_date)
          // ->whereDate('payroll_process.enddate', '=', $to_date)
          ->whereDate('payroll_process.startdate', '>=', $from_date)
          ->whereDate('payroll_process.enddate', '<=', $to_date)
          ->whereIn('employees.employee_sbu', [21]);
        // if (!empty($designation_name_value)) {
        //     $AllpayrollData->whereIn('employee_designation', $designation_name_value);
        // }
        // if (!empty($work_location_value)) {
        //     $AllpayrollData->whereIn('employee_work_location', $work_location_value);
        // }
        // if (!empty($unit_value)) {
        //     $AllpayrollData->whereIn('employee_unit', $unit_value);
        // }
        // if (!empty($sub_unit_value)) {
        //     $AllpayrollData->whereIn('employee_sub_unit', $sub_unit_value);
        // }
        // if (!empty($section_value)) {
        //     $AllpayrollData->whereIn('employee_section', $section_value);
        // }

        // if (!empty($sub_section_value)) {
        //     $AllpayrollData->whereIn('employee_sub_section', $sub_section_value);
        // }

        // if (!empty($department_name_value)) {
        //     $AllpayrollData->whereIn('employee_department', $department_name_value);
        // }
        // $payrollDataDetels=$AllpayrollData->get()->toArray();
        //  return response($payrollDataDetels);
        // $payroll_datas =$AllpayrollData->groupBy('employees.employee_department')
        //    ->groupBy('sub_units.id')
        //    ->groupBy('employees.employee_salary_type')
        //    ->orderBy('employees.employee_department')
        //    ->get()->toArray();
           
        $payroll_data=[];
        
        foreach ($payrollDataDetels as $key => $value) {
            $total_a_wages=collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])
            ->WhereIn('seft_id', [35,37,39,41])->sum('gross_salary');
            $total_b_wages=collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])
            ->WhereIn('seft_id', [34,38,42])->sum('gross_salary');
            $total_c_wages=collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])
            ->WhereIn('seft_id', [36,40])->sum('gross_salary');
            $top_sheet_head=collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])
            ->WhereIn('seft_id', [34,35,36,37,38,39,40,41,42])->count();
            $bonus_amount = collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])->WhereIn('seft_id', [34,35,36,37,38,39,40,41,42])->sum('attendance_bonus');
            $bonus_hands = collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])->WhereIn('seft_id', [34,35,36,37,38,39,40,41,42])->count();
            $deduction_loan = collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])->WhereIn('seft_id', [34,35,36,37,38,39,40,41,42])->sum('deduction_loan');
            $deduction_canteen = collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])->WhereIn('seft_id', [34,35,36,37,38,39,40,41,42])->sum('deduction_canteen');
            $deduction_uniform = collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])->WhereIn('seft_id', [34,35,36,37,38,39,40,41,42])->sum('deduction_uniform');
            $dad_deduction = 0;
            if ($value['employee_salary_type'] == 1) {
                $salary_type_remarks = 'Time Based';
            } elseif ($value['employee_salary_type'] == 2) {
                $salary_type_remarks = 'Production Based';
            } elseif ($value['employee_salary_type'] == 3) {
                $salary_type_remarks = 'Residential Based';
            } else {
                $salary_type_remarks = '';
            }
            return response($value->shift_id);

            if ($value['seft_id'] == 35) {
                $payroll_data[]=[
                        'sub_unit_name' => $value['sub_unit_name'] ,
                        'department_name' =>  $value['department_name'],
                        'total_a_wages' => $total_a_wages,
                        'total_b_wages' => $total_b_wages,
                        'total_c_wages' => $total_c_wages,
                        'total_wages' => ($total_a_wages + $total_b_wages + $total_c_wages),
                        'bonus_hands' => $bonus_hands,
                        'bonus_amount' => $bonus_amount,
                        'wages_and_bonus' => ($total_a_wages + $total_b_wages + $total_c_wages) + $bonus_amount,
                        'total_dad' => $dad_deduction,
                        'salary_loan' => $deduction_loan,
                        'total_canteen_deduct' => $deduction_canteen,
                        'total_appron' => $deduction_uniform,
                        'total_deduction' => ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'net_wages' => ($total_a_wages + $total_b_wages + $total_c_wages + $bonus_amount) - ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'top_sheet_remarks' => $salary_type_remarks,
                        'top_sheet_head' => $top_sheet_head,
                ];
            } elseif ($value['seft_id'] == 34) {
                $payroll_data[]=[
                    'sub_unit_name' => $value['sub_unit_name'] ,
                    'department_name' =>  $value['department_name'],
                    'total_a_wages' => $total_a_wages,
                    'total_b_wages' => $total_b_wages,
                    'total_c_wages' => $total_c_wages,
                    'total_wages' => ($total_a_wages + $total_b_wages + $total_c_wages),
                    'bonus_hands' => $bonus_hands,
                    'bonus_amount' => $bonus_amount,
                    'wages_and_bonus' => ($total_a_wages + $total_b_wages + $total_c_wages) + $bonus_amount,
                    'total_dad' => $dad_deduction,
                    'salary_loan' => $deduction_loan,
                    'total_canteen_deduct' => $deduction_canteen,
                    'total_appron' => $deduction_uniform,
                    'total_deduction' => ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                    'net_wages' => ($total_a_wages + $total_b_wages + $total_c_wages + $bonus_amount) - ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                    'top_sheet_remarks' => $salary_type_remarks,
                    'top_sheet_head' => $top_sheet_head,
                ];
            } elseif ($value['seft_id'] == 36) {
                $payroll_data[]=[
                    'sub_unit_name' => $value['sub_unit_name'] ,
                    'department_name' =>  $value['department_name'],
                    'total_a_wages' => $total_a_wages,
                    'total_b_wages' => $total_b_wages,
                    'total_c_wages' => $total_c_wages,
                    'total_wages' => ($total_a_wages + $total_b_wages + $total_c_wages),
                    'bonus_hands' => $bonus_hands,
                    'bonus_amount' => $bonus_amount,
                    'wages_and_bonus' => ($total_a_wages + $total_b_wages + $total_c_wages) + $bonus_amount,
                    'total_dad' => $dad_deduction,
                    'salary_loan' => $deduction_loan,
                    'total_canteen_deduct' => $deduction_canteen,
                    'total_appron' => $deduction_uniform,
                    'total_deduction' => ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                    'net_wages' => ($total_a_wages + $total_b_wages + $total_c_wages + $bonus_amount) - ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                    'top_sheet_remarks' => $salary_type_remarks,
                    'top_sheet_head' => $top_sheet_head,
                ];
            } else {
                $payroll_data[]=[
                    'sub_unit_name' => $value['sub_unit_name'] ,
                    'department_name' =>  $value['department_name'],
                    'total_a_wages' => $total_a_wages,
                    'total_b_wages' => $total_b_wages,
                    'total_c_wages' => $total_c_wages,
                    'total_wages' => ($total_a_wages + $total_b_wages + $total_c_wages),
                    'bonus_hands' => $bonus_hands,
                    'bonus_amount' => $bonus_amount,
                    'wages_and_bonus' => ($total_a_wages + $total_b_wages + $total_c_wages) + $bonus_amount,
                    'total_dad' => $dad_deduction,
                    'salary_loan' => $deduction_loan,
                    'total_canteen_deduct' => $deduction_canteen,
                    'total_appron' => $deduction_uniform,
                    'total_deduction' => ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                    'net_wages' => ($total_a_wages + $total_b_wages + $total_c_wages + $bonus_amount) - ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                    'top_sheet_remarks' => $salary_type_remarks,
                    'top_sheet_head' => $top_sheet_head,
                ];
            }
        }
        // echo "<pre>";
        // print_r($payroll_data);
        // exit();
        return response($payroll_data);
    }

    public function get_weekly_report_payment_a1(Request $request)
    {
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->pluck('id');
        // return response($company_sbu_id);
        $AllpayrollData = PayrollList::valid()->project()
          ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
          ->leftJoin('attendance_setups', 'attendance_setups.employee_id', '=', 'payroll.empid')
          ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
          ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->selectRaw(
              'employees.employee_department,payroll.gross_salary,payroll.attendance_bonus,sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,designations.designation_name,office_time_setups.title,office_time_setups.id as seft_id'
          )
        //   ->whereDate('payroll_process.startdate', '=', $from_date)
        //   ->whereDate('payroll_process.enddate', '=', $to_date)
          ->whereIn('employees.employee_sbu', $company_sbu_id);
        if (!empty($search_option['employee_designation'])) {
            $AllpayrollData->whereIn('employee_designation', $search_option['employee_designation']);
        }
        if (!empty($search_option['employee_work_location'])) {
            $AllpayrollData->whereIn('employee_work_location', $search_option['employee_work_location']);
        }
        if (!empty($search_option['unit'])) {
            $AllpayrollData->whereIn('employee_unit', $search_option['unit']);
        }
        if (!empty($search_option['sub_unit'])) {
            $AllpayrollData->whereIn('employee_sub_unit', $search_option['sub_unit']);
        }
        if (!empty($search_option['employee_section'])) {
            $AllpayrollData->whereIn('employee_section', $search_option['employee_section']);
        }
        if (!empty($search_option['employee_sub_section'])) {
            $AllpayrollData->whereIn('employee_sub_section', $search_option['employee_sub_section']);
        }
        $payrollDataDetels=$AllpayrollData->get()->toArray();
        $payroll_datas =$AllpayrollData->groupBy('employees.employee_department')
         //   ->groupBy('sub_units.id')
           ->groupBy('employees.employee_salary_type')
           ->orderBy('employees.employee_department')
           ->get()->toArray();

        //   echo "<pre>";
        //   print_r($payroll_datas);
        //   exit();
        $payroll_data=[];
        foreach ($payroll_datas as $key => $value) {
            $total_wages=collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])
            ->WhereIn('seft_id', [35,37,39,41])->sum('gross_salary'); // A shift

            $deduction_loan = collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])->WhereIn('seft_id', [34,35,36,37,38,39,40,41,42])->sum('deduction_loan');
            $deduction_canteen = collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])->WhereIn('seft_id', [34,35,36,37,38,39,40,41,42])->sum('deduction_canteen');
            $deduction_uniform = collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])->WhereIn('seft_id', [34,35,36,37,38,39,40,41,42])->sum('deduction_uniform');
            $dad_deduction = 0;
            if ($value['employee_salary_type'] == 1) {
                $salary_type_remarks = 'Time Based';
            } elseif ($value['employee_salary_type'] == 2) {
                $salary_type_remarks = 'Production Based';
            } elseif ($value['employee_salary_type'] == 3) {
                $salary_type_remarks = 'Residential Based';
            } else {
                $salary_type_remarks = '';
            }

            if ($value['seft_id'] == 35) {
                $payroll_data[]=[
                        'sub_unit_name' => $value['sub_unit_name'] ,
                        'department_name' =>  $value['department_name'],
                        'total_wages' => $total_wages,
                        'total_dad' => $dad_deduction,
                        'salary_loan' => $deduction_loan,
                        'total_canteen_deduct' => $deduction_canteen,
                        'total_appron' => $deduction_uniform,
                        'total_deduction' => ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'net_wages' => $total_wages - ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'top_sheet_remarks' => $salary_type_remarks,
                        // 'top_sheet_head' => $top_sheet_head,
                ];
            } elseif ($value['seft_id'] == 34) {
                $payroll_data[]=[
                        'sub_unit_name' => $value['sub_unit_name'] ,
                        'department_name' =>  $value['department_name'],
                        'total_wages' => $total_wages,
                        'total_dad' => $dad_deduction,
                        'salary_loan' => $deduction_loan,
                        'total_canteen_deduct' => $deduction_canteen,
                        'total_appron' => $deduction_uniform,
                        'total_deduction' => ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'net_wages' => $total_wages - ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'top_sheet_remarks' => $salary_type_remarks,
                        // 'top_sheet_head' => $top_sheet_head,
                ];
            } elseif ($value['seft_id'] == 36) {
                $payroll_data[]=[
                        'sub_unit_name' => $value['sub_unit_name'] ,
                        'department_name' =>  $value['department_name'],
                        'total_wages' => $total_wages,
                        'total_dad' => $dad_deduction,
                        'salary_loan' => $deduction_loan,
                        'total_canteen_deduct' => $deduction_canteen,
                        'total_appron' => $deduction_uniform,
                        'total_deduction' => ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'net_wages' => $total_wages - ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'top_sheet_remarks' => $salary_type_remarks,
                        // 'top_sheet_head' => $top_sheet_head,
                ];
            } else {
                $payroll_data[]=[
                        'sub_unit_name' => $value['sub_unit_name'] ,
                        'department_name' =>  $value['department_name'],
                        'total_wages' => $total_wages,
                        'total_dad' => $dad_deduction,
                        'salary_loan' => $deduction_loan,
                        'total_canteen_deduct' => $deduction_canteen,
                        'total_appron' => $deduction_uniform,
                        'total_deduction' => ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'net_wages' => $total_wages - ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'top_sheet_remarks' => $salary_type_remarks,
                        // 'top_sheet_head' => $top_sheet_head,
                ];
            }
        }

        return response($payroll_data);
    }

    public function get_weekly_report_payment_b1(Request $request)
    {
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->pluck('id');
        // return response($company_sbu_id);
        $AllpayrollData = PayrollList::valid()->project()
          ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
          ->leftJoin('attendance_setups', 'attendance_setups.employee_id', '=', 'payroll.empid')
          ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
          ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->selectRaw(
              'employees.employee_department,payroll.gross_salary,payroll.attendance_bonus,sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,designations.designation_name,office_time_setups.title,office_time_setups.id as seft_id'
          )
        //   ->whereDate('payroll_process.startdate', '=', $from_date)
        //   ->whereDate('payroll_process.enddate', '=', $to_date)
          ->whereIn('employees.employee_sbu', [21]);
        if (!empty($search_option['employee_designation'])) {
            $AllpayrollData->whereIn('employee_designation', $search_option['employee_designation']);
        }
        if (!empty($search_option['employee_work_location'])) {
            $AllpayrollData->whereIn('employee_work_location', $search_option['employee_work_location']);
        }
        if (!empty($search_option['unit'])) {
            $AllpayrollData->whereIn('employee_unit', $search_option['unit']);
        }
        if (!empty($search_option['sub_unit'])) {
            $AllpayrollData->whereIn('employee_sub_unit', $search_option['sub_unit']);
        }
        if (!empty($search_option['employee_section'])) {
            $AllpayrollData->whereIn('employee_section', $search_option['employee_section']);
        }
        if (!empty($search_option['employee_sub_section'])) {
            $AllpayrollData->whereIn('employee_sub_section', $search_option['employee_sub_section']);
        }
        $payrollDataDetels=$AllpayrollData->get()->toArray();
        $payroll_datas =$AllpayrollData->groupBy('employees.employee_department')
           ->groupBy('sub_units.id')
           ->groupBy('employees.employee_salary_type')
           ->orderBy('employees.employee_department')
           ->get()->toArray();
        $payroll_data=[];
        foreach ($payroll_datas as $key => $value) {
            $total_wages=collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])
            ->WhereIn('seft_id', [34,38,42])->sum('gross_salary');
            $deduction_loan = collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])->WhereIn('seft_id', [34,35,36,37,38,39,40,41,42])->sum('deduction_loan');
            $deduction_canteen = collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])->WhereIn('seft_id', [34,35,36,37,38,39,40,41,42])->sum('deduction_canteen');
            $deduction_uniform = collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])->WhereIn('seft_id', [34,35,36,37,38,39,40,41,42])->sum('deduction_uniform');
            $dad_deduction = 0;
            if ($value['employee_salary_type'] == 1) {
                $salary_type_remarks = 'Time Based';
            } elseif ($value['employee_salary_type'] == 2) {
                $salary_type_remarks = 'Production Based';
            } elseif ($value['employee_salary_type'] == 3) {
                $salary_type_remarks = 'Residential Based';
            } else {
                $salary_type_remarks = '';
            }

            if ($value['seft_id'] == 35) {
                $payroll_data[]=[
                        'sub_unit_name' => $value['sub_unit_name'] ,
                        'department_name' =>  $value['department_name'],
                        'total_wages' => $total_wages,
                        'total_dad' => $dad_deduction,
                        'salary_loan' => $deduction_loan,
                        'total_canteen_deduct' => $deduction_canteen,
                        'total_appron' => $deduction_uniform,
                        'total_deduction' => ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'net_wages' => $total_wages - ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'top_sheet_remarks' => $salary_type_remarks,
                        // 'top_sheet_head' => $top_sheet_head,
                ];
            } elseif ($value['seft_id'] == 34) {
                $payroll_data[]=[
                        'sub_unit_name' => $value['sub_unit_name'] ,
                        'department_name' =>  $value['department_name'],
                        'total_wages' => $total_wages,
                        'total_dad' => $dad_deduction,
                        'salary_loan' => $deduction_loan,
                        'total_canteen_deduct' => $deduction_canteen,
                        'total_appron' => $deduction_uniform,
                        'total_deduction' => ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'net_wages' => $total_wages - ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'top_sheet_remarks' => $salary_type_remarks,
                        // 'top_sheet_head' => $top_sheet_head,
                ];
            } elseif ($value['seft_id'] == 36) {
                $payroll_data[]=[
                        'sub_unit_name' => $value['sub_unit_name'] ,
                        'department_name' =>  $value['department_name'],
                        'total_wages' => $total_wages,
                        'total_dad' => $dad_deduction,
                        'salary_loan' => $deduction_loan,
                        'total_canteen_deduct' => $deduction_canteen,
                        'total_appron' => $deduction_uniform,
                        'total_deduction' => ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'net_wages' => $total_wages - ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'top_sheet_remarks' => $salary_type_remarks,
                        // 'top_sheet_head' => $top_sheet_head,
                ];
            } else {
                $payroll_data[]=[
                        'sub_unit_name' => $value['sub_unit_name'] ,
                        'department_name' =>  $value['department_name'],
                        'total_wages' => $total_wages,
                        'total_dad' => $dad_deduction,
                        'salary_loan' => $deduction_loan,
                        'total_canteen_deduct' => $deduction_canteen,
                        'total_appron' => $deduction_uniform,
                        'total_deduction' => ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'net_wages' => $total_wages - ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction),
                        'top_sheet_remarks' => $salary_type_remarks,
                        // 'top_sheet_head' => $top_sheet_head,
                ];
            }
        }
        // echo "<pre>";
        // print_r($payroll_data);
        // exit();
        return response($payroll_data);
    }

    public function get_weekly_report_payment_c1(Request $request)
    {
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->pluck('id');
        // return response($company_sbu_id);
        $AllpayrollData = PayrollList::valid()->project()
          ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
          ->leftJoin('attendance_setups', 'attendance_setups.employee_id', '=', 'payroll.empid')
          ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
          ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->selectRaw(
              'employees.employee_department,payroll.gross_salary,payroll.attendance_bonus,sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,designations.designation_name,office_time_setups.title,office_time_setups.id as seft_id'
          )
        //   ->whereDate('payroll_process.startdate', '=', $from_date)
        //   ->whereDate('payroll_process.enddate', '=', $to_date)
          ->whereIn('employees.employee_sbu', [21]);
        if (!empty($search_option['employee_designation'])) {
            $AllpayrollData->whereIn('employee_designation', $search_option['employee_designation']);
        }
        if (!empty($search_option['employee_work_location'])) {
            $AllpayrollData->whereIn('employee_work_location', $search_option['employee_work_location']);
        }
        if (!empty($search_option['unit'])) {
            $AllpayrollData->whereIn('employee_unit', $search_option['unit']);
        }
        if (!empty($search_option['sub_unit'])) {
            $AllpayrollData->whereIn('employee_sub_unit', $search_option['sub_unit']);
        }
        if (!empty($search_option['employee_section'])) {
            $AllpayrollData->whereIn('employee_section', $search_option['employee_section']);
        }
        if (!empty($search_option['employee_sub_section'])) {
            $AllpayrollData->whereIn('employee_sub_section', $search_option['employee_sub_section']);
        }
        $payrollDataDetels=$AllpayrollData->get()->toArray();
        $payroll_datas =$AllpayrollData->groupBy('employees.employee_department')
           ->groupBy('sub_units.id')
           ->groupBy('employees.employee_salary_type')
           ->orderBy('employees.employee_department')
           ->get()->toArray();
        $payroll_data=[];
        foreach ($payroll_datas as $key => $value) {
            $total_wages=collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])
            ->WhereIn('seft_id', [36,40])->sum('gross_salary');
            $deduction_loan = collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])->WhereIn('seft_id', [34,35,36,37,38,39,40,41,42])->sum('deduction_loan');
            $deduction_canteen = collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])->WhereIn('seft_id', [34,35,36,37,38,39,40,41,42])->sum('deduction_canteen');
            $deduction_uniform = collect($payrollDataDetels)->where('sub_units_id', $value['sub_units_id'])
            ->where('employee_department', $value['employee_department'])->where('employee_salary_type', $value['employee_salary_type'])->WhereIn('seft_id', [34,35,36,37,38,39,40,41,42])->sum('deduction_uniform');
            $dad_deduction = 0;
            if ($value['employee_salary_type'] == 1) {
                $salary_type_remarks = 'Time Based';
            } elseif ($value['employee_salary_type'] == 2) {
                $salary_type_remarks = 'Production Based';
            } elseif ($value['employee_salary_type'] == 3) {
                $salary_type_remarks = 'Residential Based';
            } else {
                $salary_type_remarks = '';
            }

            if ($value['seft_id'] == 35) {
                $payroll_data[]=[
                        'sub_unit_name' => $value['sub_unit_name'] ,
                        'department_name' =>  $value['department_name'],
                        'total_wages' => round($total_wages, 2),
                        'total_dad' => round($dad_deduction, 2),
                        'salary_loan' => round($deduction_loan, 2),
                        'total_canteen_deduct' => round($deduction_canteen, 2),
                        'total_appron' => round($deduction_uniform, 2),
                        'total_deduction' => round(($deduction_loan+ $deduction_canteen + $deduction_uniform + $dad_deduction), 2),
                        'net_wages' => round($total_wages - ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction), 2),
                        'top_sheet_remarks' => $salary_type_remarks,
                        // 'top_sheet_head' => $top_sheet_head,
                ];
            } elseif ($value['seft_id'] == 34) {
                $payroll_data[]=[
                        'sub_unit_name' => $value['sub_unit_name'] ,
                        'department_name' =>  $value['department_name'],
                        'total_wages' => round($total_wages, 2),
                        'total_dad' => round($dad_deduction, 2),
                        'salary_loan' => round($deduction_loan, 2),
                        'total_canteen_deduct' => round($deduction_canteen, 2),
                        'total_appron' => round($deduction_uniform, 2),
                        'total_deduction' => round(($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction), 2),
                        'net_wages' => round($total_wages - ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction), 2),
                        'top_sheet_remarks' => $salary_type_remarks,
                        // 'top_sheet_head' => $top_sheet_head,
                ];
            } elseif ($value['seft_id'] == 36) {
                $payroll_data[]=[
                        'sub_unit_name' => $value['sub_unit_name'] ,
                        'department_name' =>  $value['department_name'],
                        'total_wages' => round($total_wages, 2),
                        'total_dad' => round($dad_deduction, 2),
                        'salary_loan' => round($deduction_loan, 2),
                        'total_canteen_deduct' => round($deduction_canteen, 2),
                        'total_appron' => round($deduction_uniform, 2),
                        'total_deduction' => round(($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction), 2),
                        'net_wages' => round($total_wages - ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction), 2),
                        'top_sheet_remarks' => $salary_type_remarks,
                        // 'top_sheet_head' => $top_sheet_head,
                ];
            } else {
                $payroll_data[]=[
                        'sub_unit_name' => $value['sub_unit_name'] ,
                        'department_name' =>  $value['department_name'],
                        'total_wages' => round($total_wages, 2),
                        'total_dad' => round($dad_deduction, 2),
                        'salary_loan' => round($deduction_loan, 2),
                        'total_canteen_deduct' => round($deduction_canteen, 2),
                        'total_appron' => round($deduction_uniform, 2),
                        'total_deduction' => round(($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction), 2),
                        'net_wages' => round($total_wages - ($deduction_loan + $deduction_canteen + $deduction_uniform + $dad_deduction), 2),
                        'top_sheet_remarks' => $salary_type_remarks,
                        // 'top_sheet_head' => $top_sheet_head,
                ];
            }
        }
        // echo "<pre>";
        // print_r($payroll_data);
        // exit();
        return response($payroll_data);
    }

    public function get_weekly_report_ledger(Request $request)
    {
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->pluck('id');
        // return response($company_sbu_id);
        $AllpayrollData = PayrollList::valid()->project()
        ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
        ->leftJoin('attendance_setups', 'attendance_setups.employee_id', '=', 'payroll.empid')
        ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
        ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
        ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
        ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
        ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
        ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
        ->selectRaw(
            'employees.employee_department,payroll.gross_salary,payroll.attendance_bonus,sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,designations.designation_name,office_time_setups.title,office_time_setups.id as seft_id'
        )
        //   ->whereDate('payroll_process.startdate', '=', $from_date)
        //   ->whereDate('payroll_process.enddate', '=', $to_date)
        ->whereIn('employees.employee_sbu', [21]);

        if (!empty($search_option['employee_designation'])) {
            $AllpayrollData->whereIn('employee_designation', $search_option['employee_designation']);
        }
        if (!empty($search_option['employee_work_location'])) {
            $AllpayrollData->whereIn('employee_work_location', $search_option['employee_work_location']);
        }
        if (!empty($search_option['unit'])) {
            $AllpayrollData->whereIn('employee_unit', $search_option['unit']);
        }
        if (!empty($search_option['sub_unit'])) {
            $AllpayrollData->whereIn('employee_sub_unit', $search_option['sub_unit']);
        }
        if (!empty($search_option['employee_section'])) {
            $AllpayrollData->whereIn('employee_section', $search_option['employee_section']);
        }
        if (!empty($search_option['employee_sub_section'])) {
            $AllpayrollData->whereIn('employee_sub_section', $search_option['employee_sub_section']);
        }
        $payrollDataDetels=$AllpayrollData->get()->toArray();


        $payroll_datas =$AllpayrollData
            ->whereIn('office_time_setups.id', [35,34,36])
            ->groupBy('office_time_setups.id')
            ->orderBy('office_time_setups.id')
            ->get()->toArray();
        $payroll_datas_depertment = collect(collect($AllpayrollData ->groupBy('departments.id')
        ->orderBy('departments.id')
        ->get()->toArray())->unique('employee_department')->values()->all())->keyBy('employee_department')->all();

        // echo "<pre>";
        // print_r([$payroll_datas,$payroll_datas_depertment]);
        // exit();


        $payroll_data=[];
        foreach ($payroll_datas_depertment as $key_dep => $value) {
            foreach ($payroll_datas as $key => $value) {
                $payrollDepermentid=$key_dep;
                $dad_deduction = 0;
                if ($value['employee_salary_type'] == 1) {
                    $salary_type_remarks = 'Time Based';
                } elseif ($value['employee_salary_type'] == 2) {
                    $salary_type_remarks = 'Production Based';
                } elseif ($value['employee_salary_type'] == 3) {
                    $salary_type_remarks = 'Residential Based';
                } else {
                    $salary_type_remarks = '';
                }
                if ($value['seft_id'] == 35) {
                    $total_a_wages=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [35,37,39,41])->sum('gross_salary');
                    $overtime=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [35,37,39,41])->sum('overtime');
                    $night_allownce=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [35,37,39,41])->sum('night_allownce');
                    $residential_allowance=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [35,37,39,41])->sum('residential_allowance');
                    $allowance=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [35,37,39,41])->sum('allowance');
                    $attendance_bonus=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [35,37,39,41])->sum('attendance_bonus');
                    $deduction_uniform=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [35,37,39,41])->sum('deduction_uniform');
                    $deduction_canteen=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [35,37,39,41])->sum('deduction_canteen');
                    $deduction_others=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [35,37,39,41])->sum('deduction_others');
                    $payroll_data[]=[
                            'sub_unit_name' => $value['sub_unit_name'] ,
                            'department_name' =>  $value['department_name'],
                            'title' =>  $value['title'],
                            'total_a_wages' => $total_a_wages,
                            'overtime' => $overtime,
                            'night_allownce' => $night_allownce,
                            'residential_allowance' => $residential_allowance,
                            'allowance' => $allowance,
                            'attendance_bonus' => $attendance_bonus,
                            'deduction_uniform' => $deduction_uniform,
                            'dad_deduction' => $dad_deduction,
                            'deduction_canteen' => $deduction_canteen,
                            'deduction_others' => $deduction_others,
                            'total_wages' => ($total_a_wages + $overtime + $night_allownce + $residential_allowance + $allowance),
                            'net_wages' => ($total_a_wages + $overtime + $night_allownce + $residential_allowance + $allowance) - ($deduction_uniform + $deduction_canteen + $deduction_uniform + $dad_deduction),
                    ];
                } elseif ($value['seft_id'] == 34) {
                    $total_b_wages=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [34,38,42])->sum('gross_salary');
                    $overtime=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [34,38,42])->sum('overtime');
                    $night_allownce=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [34,38,42])->sum('night_allownce');
                    $residential_allowance=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [34,38,42])->sum('residential_allowance');
                    $allowance=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [34,38,42])->sum('allowance');
                    $attendance_bonus=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [34,38,42])->sum('attendance_bonus');
                    $deduction_uniform=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [34,38,42])->sum('deduction_uniform');
                    $deduction_canteen=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [34,38,42])->sum('deduction_canteen');
                    $deduction_others=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [34,38,42])->sum('deduction_others');

                    $payroll_data[]=[
                        'sub_unit_name' => $value['sub_unit_name'] ,
                        'department_name' =>  $value['department_name'],
                        'title' =>  $value['title'],
                        'total_a_wages' => $total_b_wages,
                        'total_wages' => $total_b_wages,
                        'overtime' => $overtime,
                        'night_allownce' => $night_allownce,
                        'residential_allowance' => $residential_allowance,
                        'allowance' => $allowance,
                        'attendance_bonus' => $attendance_bonus,
                        'deduction_uniform' => $deduction_uniform,
                        'dad_deduction' => $dad_deduction,
                        'deduction_canteen' => $deduction_canteen,
                        'deduction_others' => $deduction_others,
                        'total_wages' => ($total_b_wages + $overtime + $night_allownce + $residential_allowance + $allowance),
                        'net_wages' => ($total_b_wages + $overtime + $night_allownce + $residential_allowance + $allowance) - ($deduction_uniform + $deduction_canteen + $deduction_uniform + $dad_deduction),
                    ];
                } elseif ($value['seft_id'] == 36) {
                    $total_c_wages=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [36,40])->sum('gross_salary');
                    $overtime=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [36,40])->sum('overtime');
                    $night_allownce=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [36,40])->sum('night_allownce');
                    $residential_allowance=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [36,40])->sum('residential_allowance');
                    $allowance=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [36,40])->sum('allowance');
                    $attendance_bonus=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [36,40])->sum('attendance_bonus');
                    $deduction_uniform=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [36,40])->sum('deduction_uniform');
                    $deduction_canteen=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [36,40])->sum('deduction_canteen');
                    $deduction_others=collect($payrollDataDetels)->where('employee_department', $payrollDepermentid)->WhereIn('seft_id', [36,40])->sum('deduction_others');
                    $payroll_data[]=[
                        'sub_unit_name' => $value['sub_unit_name'] ,
                        'department_name' =>  $value['department_name'],
                        'title' =>  $value['title'],
                        'total_a_wages' => $total_c_wages,
                        'total_wages' => ($total_c_wages),
                        'overtime' => $overtime,
                        'night_allownce' => $night_allownce,
                        'residential_allowance' => $residential_allowance,
                        'allowance' => $allowance,
                        'attendance_bonus' => $attendance_bonus,
                        'deduction_uniform' => $deduction_uniform,
                        'dad_deduction' => $dad_deduction,
                        'deduction_canteen' => $deduction_canteen,
                        'deduction_others' => $deduction_others,
                        'total_wages' => ($total_c_wages + $overtime + $night_allownce + $residential_allowance + $allowance),
                        'net_wages' => ($total_c_wages + $overtime + $night_allownce + $residential_allowance + $allowance) - ($deduction_uniform + $deduction_canteen + $deduction_uniform + $dad_deduction),
                    ];
                } else {
                    $payroll_data[]=[
                        'sub_unit_name' => $value['sub_unit_name'] ,
                        'department_name' =>  $value['department_name'],
                        'title' =>  $value['title'],
                        'total_a_wages' => 0,
                        'total_wages' => 0,
                        'overtime' => 0,
                        'night_allownce' => 0,
                        'residential_allowance' => 0,
                        'allowance' => 0,
                        'attendance_bonus' => 0,
                        'dad_deduction' => $dad_deduction,
                        'deduction_uniform' => 0,
                        'deduction_canteen' => 0,
                        'deduction_others' => 0,
                        'total_wages' => 0,
                        'net_wages' => 0,
                    ];
                }
            }
        }

        
        return response($payroll_data);
    }
    public function get_weekly_report_payment_c(Request $request) {
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '0');
        $unit_value = collect($request->unit_value)->where('id','!=',0)->pluck('id');
        $sub_unit_value = collect($request->sub_unit_value)->where('id','!=',0)->pluck('id');
        $department_name_value = collect($request->department_name_value)->where('id','!=',0)->pluck('id');
        $designation_name_value = collect($request->designation_name_value)->where('id','!=',0)->pluck('id');
        $section_value = collect($request->section_value)->where('id','!=',0)->pluck('id');
        $sub_section_value = collect($request->sub_section_value)->where('id','!=',0)->pluck('id');
        $work_location_value = collect($request->work_location_value)->where('id','!=',0)->pluck('id');
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->where('id','!=',0)->pluck('id');
        $OfficeTime =  collect($request->OfficeTime)->where('id','!=',0)->pluck('id');
        
        if (!empty($OfficeTime)) {
            $OfficeTime = $OfficeTime;
        }else{
            $OfficeTime = [];
        }
        $process_type = 0;
        if(!empty($request->process_type)){
            $process_type = $request->process_type;
        }
        $data['process_type'] = $request->process_type;
        
        if($process_type == 2){
            $AllpayrollData = PayrollList::valid()->project()
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'payroll.shift_id')
            ->leftJoin('office_time_setups as psShift', 'psShift.id', '=', 'payroll.ps_id')
            ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->selectRaw(
                'employees.employee_department,employees.employee_id_no,employees.employee_fullname,
                payroll.shift_id,payroll.empid,psShift.title as present_shift_name,payroll.empid,
                office_time_setups.title as shift_name,payroll.gross_salary,payroll.attendance_bonus,payroll.paydays as prtot, 
                payroll.gross_salary as g_salary, payroll.netpay as net_wages,
                sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,
                sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,
                designations.designation_name,payroll.overtime,payroll.arear,payroll.night_allownce as night_allownce,
                payroll.residential_allowance,payroll.deduction_canteen,payroll.deduction_loan,payroll.late_abset_deduction as dad_deduction,
                payroll_process.remarks as process_type,  (gross_salary+overtime+night_allownce+residential_allowance+arear) as final_total_wagesNotAtteedace2
                ((gross_salary*paydays)+night_allownce+overtime+residential_allowance+arear) as final_total_wagesNotAtteedace,
                (gross_salary+overtime+night_allownce+attendance_bonus+residential_allowance+arear) as final_total_wages2,
                ((gross_salary*paydays)+night_allownce+overtime+attendance_bonus+residential_allowance+arear) as final_total_wages,
                (deduction_others+deduction_canteen+late_abset_deduction+deduction_loan+deduction_uniform) as total_deduction'
            )
            ->whereDate('payroll_process.startdate', '>=', $from_date)
            ->whereDate('payroll_process.enddate', '<=', $to_date);
            if(!empty($request->process_type)){
                $AllpayrollData->where('payroll_process.remarks', $request->process_type);
            }
            if (count($OfficeTime) > 0) {
                $AllpayrollData->whereIn('ps_id', $OfficeTime);
            }
            if(count($company_sbu_id) > 0){
                $AllpayrollData->whereIn('employees.employee_sbu', $company_sbu_id);
            }
            if (count($unit_value) > 0) {
                $AllpayrollData->whereIn('employee_unit', $unit_value);
            }
            if (count($sub_unit_value) > 0) {
                $AllpayrollData->whereIn('employee_sub_unit', $sub_unit_value);
            }
            if (count($department_name_value) > 0) {
                $AllpayrollData->whereIn('employee_department', $department_name_value);
            }
            $payrollDataDetels = $AllpayrollData->get()->toArray();
        }else{
            $AllpayrollData = PayrollList::valid()->project()
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'payroll.shift_id')
            ->leftJoin('office_time_setups as psShift', 'psShift.id', '=', 'payroll.ps_id')
            ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->selectRaw(
                'employees.employee_department,employees.employee_id_no,employees.employee_fullname,
                payroll.shift_id,payroll.ps_id,payroll.empid,psShift.title as present_shift_name,
                office_time_setups.title as shift_name,payroll.gross_salary,payroll.attendance_bonus,payroll.paydays as prtot, 
                payroll.gross_salary as g_salary, payroll.netpay as net_wages,
                sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,
                sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,
                designations.designation_name,payroll.overtime,payroll.arear,payroll.night_allownce as night_allownce,
                payroll.residential_allowance,payroll.deduction_canteen,payroll.deduction_loan, payroll.late_abset_deduction as dad_deduction,
                payroll_process.remarks as process_type, (gross_salary*paydays) as total_wages,
                ((gross_salary*paydays)+night_allownce+overtime+attendance_bonus+residential_allowance+arear) as final_total_wages,
                ((gross_salary*paydays)+night_allownce+overtime+residential_allowance+arear) as final_total_wagesNotAtteedace,
                ((gross_salary)+night_allownce+overtime+residential_allowance+arear) as final_total_wagesNotAtteedace2,
                ((gross_salary)+night_allownce+overtime+attendance_bonus+residential_allowance+arear) as final_total_wages2,
                (deduction_others+late_abset_deduction+deduction_canteen+deduction_loan+deduction_uniform) as total_deduction'
                
            )
            ->whereDate('payroll_process.startdate', '>=', $from_date)
            ->whereDate('payroll_process.enddate', '<=', $to_date);
            if(!empty($request->process_type)){
                $AllpayrollData->where('payroll_process.remarks', $request->process_type);
            }
            if (count($OfficeTime) > 0) {
                $AllpayrollData->whereIn('ps_id', $OfficeTime);
            }
            if(count($company_sbu_id) > 0){
                $AllpayrollData->whereIn('employees.employee_sbu', $company_sbu_id);
            }
            if (count($unit_value) > 0) {
                $AllpayrollData->whereIn('employee_unit', $unit_value);
            }
            if (count($sub_unit_value) > 0) {
                $AllpayrollData->whereIn('employee_sub_unit', $sub_unit_value);
            }
            if (count($department_name_value) > 0) {
                $AllpayrollData->whereIn('employee_department', $department_name_value);
            }
            $payrollDataDetels = $AllpayrollData->get()->toArray();
            $data['TotalNet_wages'] = collect($payrollDataDetels)->sum('net_wages');
            $data['Twagess'] = collect($payrollDataDetels)->sum('total_wages');
        }
        
        // $subUnits = collect(collect($payrollDataDetels)->pluck('sub_units_id')->toArray())
                    // ->unique()->values()->toArray();
        $allDeduction = [];
        $salaryTypes =['1' => 'Time Based', '2' => 'Production Based', '3' => 'Residential Based'];
        $Ttotal_wages = 0; 
        $Ttotal_dad = 0; $Tsalary_loan = 0; 
        $Ttotal_canteen_deduct = 0; $Ttotal_appron = 0; $Ttotal_ticket = 0;  
        $Ttotal_deduction = 0;  $Tnet_wages = 0; 

        
        $subUnits = collect(collect($payrollDataDetels)->whereIn('ps_id',[36,40])->pluck('sub_units_id')->toArray())
        ->unique()->values()->toArray();
        foreach ($subUnits as $key => $value) {
        
            $filterData1 = collect($payrollDataDetels)->whereIn('ps_id',[36,40])
               //->where('process_type',$key_s)
            ->where('sub_units_id',$value)->toArray();
            $sub_units_name = collect($filterData1)->whereIn('ps_id',[36,40])
            ->where('sub_units_id',$value)->first();
            $departments = collect(collect($filterData1)->where('sub_units_id',$value)
            ->where('final_total_wages','!=',0)
            ->whereIn('ps_id',[36,40])->pluck('employee_department')->toArray())
            ->unique()->values()->toArray();
            foreach ($departments as $key2 => $value_d) {
                $filterData2 = collect($payrollDataDetels)
                ->where('final_total_wages','!=',0)
                ->whereIn('ps_id',[36,40]) ->where('sub_units_id',$value)->where('employee_department',$value_d)->toArray();
                $department_name = collect($filterData2)
                ->where('final_total_wages','!=',0) ->where('sub_units_id',$value)
                ->whereIn('ps_id',[36,40])->where('employee_department',$value_d)->first();

                $total_wages = collect($filterData2)->where('process_type',2)->sum('final_total_wages2')+collect($filterData2)->whereIn('process_type',[1,3])->sum('final_total_wages');
                $total_dad = collect($filterData2)->sum('dad_deduction');
                $salary_loan = collect($filterData2)->sum('deduction_loan');
                $total_canteen_deduct = collect($filterData2)->sum('deduction_canteen');
                $total_appron_deduct = collect($filterData2)->sum('deduction_uniform');
                $total_ticket_deduct = collect($filterData2)->sum('deduction_ticket');
                $total_deduction = collect($filterData2)->sum('total_deduction');
                $allDeduction[] = [
                    'department_name' => $department_name['department_name'] ?? '',
                    'sub_unit_name' => $sub_units_name['sub_unit_name'] ?? '',
                    'total_wages' => $total_wages ?? 0,
                    'total_dad' => $total_dad ?? 0,
                    'salary_loan' => $salary_loan ?? 0,
                    'total_canteen_deduct' => $total_canteen_deduct ?? 0,
                    'total_appron_deduct' => $total_appron_deduct ?? 0,
                    'total_ticket_deduct' => $total_ticket_deduct ?? 0,
                    'total_deduction' => $total_deduction ?? 0,
                    'net_wages' => ($total_wages - $total_deduction) ?? 0,
                ];
                    $Ttotal_wages += $total_wages; 
                    $Ttotal_dad += $total_dad; $Tsalary_loan += $salary_loan; 
                    $Ttotal_canteen_deduct += $total_canteen_deduct; $Ttotal_appron += $total_appron_deduct; $Ttotal_ticket += $total_ticket_deduct;  
                    $Ttotal_deduction += $total_deduction;
                    $Tnet_wages += ($total_wages - $total_deduction);
                
            }
        }
        $data['payrollDataDetels'] = $allDeduction;
        $repoerNamae = 'Payment List - C Shift From ' .date('d M, Y',strtotime($from_date)). " To ". date('d M, Y',strtotime($to_date));
        $data['report_name'] = $repoerNamae;
        $data['print_date'] =  date('d M, Y');
        $data['search_button'] = 4;


        $data['total_gross_wages'] = $Ttotal_wages;
        $data['total_dad_wages'] = $Ttotal_dad;
        $data['total_loan_deduct'] = $Tsalary_loan;
        $data['total_canteen_deduct'] = $Ttotal_canteen_deduct;
        $data['total_appron_deduct'] = $Ttotal_appron;
        $data['total_tic_deduct'] = $Ttotal_ticket;
        $data['total_total_deduct'] = $Ttotal_deduction;
        $data['total_net_amount'] = $Tnet_wages;
        

        return response($data);
    }

    public function get_weekly_report_payment_b(Request $request) {
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '0');
        $unit_value = collect($request->unit_value)->where('id','!=',0)->pluck('id');
        $sub_unit_value = collect($request->sub_unit_value)->where('id','!=',0)->pluck('id');
        $department_name_value = collect($request->department_name_value)->where('id','!=',0)->pluck('id');
        $designation_name_value = collect($request->designation_name_value)->where('id','!=',0)->pluck('id');
        $section_value = collect($request->section_value)->where('id','!=',0)->pluck('id');
        $sub_section_value = collect($request->sub_section_value)->where('id','!=',0)->pluck('id');
        $work_location_value = collect($request->work_location_value)->where('id','!=',0)->pluck('id');
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->where('id','!=',0)->pluck('id');
        $OfficeTime =  collect($request->OfficeTime)->where('id','!=',0)->pluck('id');
        
        if (!empty($OfficeTime)) {
            $OfficeTime = $OfficeTime;
        }else{
            $OfficeTime = [];
        }
        $process_type = 0;
        if(!empty($request->process_type)){
            $process_type = $request->process_type;
        }
        $data['process_type'] = $request->process_type;
        if($process_type == 2){
            $AllpayrollData = PayrollList::valid()->project()
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'payroll.shift_id')
            ->leftJoin('office_time_setups as psShift', 'psShift.id', '=', 'payroll.ps_id')
            ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->selectRaw(
                'employees.employee_department,employees.employee_id_no,employees.employee_fullname,
                payroll.shift_id,payroll.empid,psShift.title as present_shift_name,payroll.empid,
                office_time_setups.title as shift_name,payroll.gross_salary,payroll.attendance_bonus,payroll.paydays as prtot, 
                payroll.gross_salary as g_salary, payroll.netpay as net_wages,
                sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,
                sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,
                designations.designation_name,payroll.overtime,payroll.arear,payroll.night_allownce as night_allownce,
                payroll.residential_allowance,payroll.deduction_canteen,payroll.deduction_loan,payroll.late_abset_deduction as dad_deduction,
                payroll_process.remarks as process_type,  (gross_salary+overtime+night_allownce+residential_allowance+arear) as final_total_wagesNotAtteedace2
                ((gross_salary*paydays)+night_allownce+overtime+residential_allowance+arear) as final_total_wagesNotAtteedace,
                (gross_salary+overtime+night_allownce+attendance_bonus+residential_allowance+arear) as final_total_wages2,
                ((gross_salary*paydays)+night_allownce+overtime+attendance_bonus+residential_allowance+arear) as final_total_wages,
                (deduction_others+deduction_canteen+late_abset_deduction+deduction_loan+deduction_uniform) as total_deduction'
            )
            ->whereDate('payroll_process.startdate', '>=', $from_date)
            ->whereDate('payroll_process.enddate', '<=', $to_date);
            if(!empty($request->process_type)){
                $AllpayrollData->where('payroll_process.remarks', $request->process_type);
            }
            if (count($OfficeTime) > 0) {
                $AllpayrollData->whereIn('ps_id', $OfficeTime);
            }
            if(count($company_sbu_id) > 0){
                $AllpayrollData->whereIn('employees.employee_sbu', $company_sbu_id);
            }
            if (count($unit_value) > 0) {
                $AllpayrollData->whereIn('employee_unit', $unit_value);
            }
            if (count($sub_unit_value) > 0) {
                $AllpayrollData->whereIn('employee_sub_unit', $sub_unit_value);
            }
            if (count($department_name_value) > 0) {
                $AllpayrollData->whereIn('employee_department', $department_name_value);
            }
            $payrollDataDetels = $AllpayrollData->get()->toArray();
        }else{
            $AllpayrollData = PayrollList::valid()->project()
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'payroll.shift_id')
            ->leftJoin('office_time_setups as psShift', 'psShift.id', '=', 'payroll.ps_id')
            ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->selectRaw(
                'employees.employee_department,employees.employee_id_no,employees.employee_fullname,
                payroll.shift_id,payroll.ps_id,payroll.empid,psShift.title as present_shift_name,
                office_time_setups.title as shift_name,payroll.gross_salary,payroll.attendance_bonus,payroll.paydays as prtot, 
                payroll.gross_salary as g_salary, payroll.netpay as net_wages,
                sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,
                sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,
                designations.designation_name,payroll.overtime,payroll.arear,payroll.night_allownce as night_allownce,
                payroll.residential_allowance,payroll.deduction_canteen,payroll.deduction_loan, payroll.late_abset_deduction as dad_deduction,
                payroll_process.remarks as process_type, (gross_salary*paydays) as total_wages,
                ((gross_salary*paydays)+night_allownce+overtime+attendance_bonus+residential_allowance+arear) as final_total_wages,
                ((gross_salary*paydays)+night_allownce+overtime+residential_allowance+arear) as final_total_wagesNotAtteedace,
                ((gross_salary)+night_allownce+overtime+residential_allowance+arear) as final_total_wagesNotAtteedace2,
                ((gross_salary)+night_allownce+overtime+attendance_bonus+residential_allowance+arear) as final_total_wages2,
                (deduction_others+late_abset_deduction+deduction_canteen+deduction_loan+deduction_uniform) as total_deduction'
                
            )
            ->whereDate('payroll_process.startdate', '>=', $from_date)
            ->whereDate('payroll_process.enddate', '<=', $to_date);
            if(!empty($request->process_type)){
                $AllpayrollData->where('payroll_process.remarks', $request->process_type);
            }
            if (count($OfficeTime) > 0) {
                $AllpayrollData->whereIn('ps_id', $OfficeTime);
            }
            if(count($company_sbu_id) > 0){
                $AllpayrollData->whereIn('employees.employee_sbu', $company_sbu_id);
            }
            if (count($unit_value) > 0) {
                $AllpayrollData->whereIn('employee_unit', $unit_value);
            }
            if (count($sub_unit_value) > 0) {
                $AllpayrollData->whereIn('employee_sub_unit', $sub_unit_value);
            }
            if (count($department_name_value) > 0) {
                $AllpayrollData->whereIn('employee_department', $department_name_value);
            }
            $payrollDataDetels = $AllpayrollData->get()->toArray();
            $data['TotalNet_wages'] = collect($payrollDataDetels)->sum('net_wages');
            $data['Twagess'] = collect($payrollDataDetels)->sum('total_wages');
        }
        
        
        // $subUnits = collect(collect($payrollDataDetels)->pluck('sub_units_id')->toArray())
                    // ->unique()->values()->toArray();
        $allDeduction = [];
        $salaryTypes =['1' => 'Time Based', '2' => 'Production Based', '3' => 'Residential Based'];
        $Ttotal_wages = 0; 
        $Ttotal_dad = 0; $Tsalary_loan = 0; 
        $Ttotal_canteen_deduct = 0; $Ttotal_appron = 0; $Ttotal_ticket = 0;  
        $Ttotal_deduction = 0;  $Tnet_wages = 0; 
        
        $subUnits = collect(collect($payrollDataDetels)->whereIn('ps_id',[34,45,38,42])->pluck('sub_units_id')->toArray())
        ->unique()->values()->toArray();
        foreach ($subUnits as $key => $value) {
            $filterData1 = collect($payrollDataDetels)->whereIn('ps_id',[34,45,38,42])
               //->where('process_type',$key_s)
            ->where('sub_units_id',$value)->toArray();
            $sub_units_name = collect($filterData1)->whereIn('ps_id',[34,45,38,42])
            ->where('sub_units_id',$value)->first();
            $departments = collect(collect($filterData1)
            ->where('final_total_wages','!=',0)
            ->whereIn('ps_id',[34,45,38,42])->pluck('employee_department')->toArray())
            ->unique()->values()->toArray();
            foreach ($departments as $key2 => $value_d) {
                $filterData2 = collect($payrollDataDetels)
                ->where('final_total_wages','!=',0)
                ->whereIn('ps_id',[34,45,38,42])->where('sub_units_id',$value)
                ->where('employee_department',$value_d)->toArray();
                $department_name = collect($filterData2)
                ->where('final_total_wages','!=',0)
                ->whereIn('ps_id',[34,45,38,42])->where('sub_units_id',$value)
                ->where('employee_department',$value_d)->first();
                
                $total_wages = collect($filterData2)->where('process_type',2)->sum('final_total_wages2')+collect($filterData2)->whereIn('process_type',[1,3])->sum('final_total_wages');
                $total_dad = collect($filterData2)->sum('dad_deduction');
                $salary_loan = collect($filterData2)->sum('deduction_loan');
                $total_canteen_deduct = collect($filterData2)->sum('deduction_canteen');
                $total_appron_deduct = collect($filterData2)->sum('deduction_uniform');
                $total_ticket_deduct = collect($filterData2)->sum('deduction_ticket');
                $total_deduction = collect($filterData2)->sum('total_deduction');
                $allDeduction[] = [
                    'department_name' => $department_name['department_name'] ?? '',
                    'sub_unit_name' => $sub_units_name['sub_unit_name'] ?? '',
                    'total_wages' => $total_wages ?? 0,
                    'total_dad' => $total_dad ?? 0,
                    'salary_loan' => $salary_loan ?? 0,
                    'total_canteen_deduct' => $total_canteen_deduct ?? 0,
                    'total_appron_deduct' => $total_appron_deduct ?? 0,
                    'total_ticket_deduct' => $total_ticket_deduct ?? 0,
                    'total_deduction' => $total_deduction ?? 0,
                    'net_wages' => ($total_wages - $total_deduction) ?? 0,
                ];
                    $Ttotal_wages += $total_wages; 
                    $Ttotal_dad += $total_dad; $Tsalary_loan += $salary_loan; 
                    $Ttotal_canteen_deduct += $total_canteen_deduct; $Ttotal_appron += $total_appron_deduct; $Ttotal_ticket += $total_ticket_deduct;  
                    $Ttotal_deduction += $total_deduction;
                    $Tnet_wages += ($total_wages - $total_deduction);
                
            }
        }
        $data['payrollDataDetels'] = $allDeduction;
        $repoerNamae = 'Payment List - B Shift From ' .date('d M, Y',strtotime($from_date)). " To ". date('d M, Y',strtotime($to_date));
        $data['report_name'] = $repoerNamae;
        $data['print_date'] =  date('d M, Y');
        $data['search_button'] = 3;


        $data['total_gross_wages'] = $Ttotal_wages;
        $data['total_dad_wages'] = $Ttotal_dad;
        $data['total_loan_deduct'] = $Tsalary_loan;
        $data['total_canteen_deduct'] = $Ttotal_canteen_deduct;
        $data['total_appron_deduct'] = $Ttotal_appron;
        $data['total_tic_deduct'] = $Ttotal_ticket;
        $data['total_total_deduct'] = $Ttotal_deduction;
        $data['total_net_amount'] = $Tnet_wages;
        

        return response($data);
    }
    public function get_weekly_report_payment_a(Request $request) {
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '0');
        $unit_value = collect($request->unit_value)->where('id','!=',0)->pluck('id');
        $sub_unit_value = collect($request->sub_unit_value)->where('id','!=',0)->pluck('id');
        $department_name_value = collect($request->department_name_value)->where('id','!=',0)->pluck('id');
        $designation_name_value = collect($request->designation_name_value)->where('id','!=',0)->pluck('id');
        $section_value = collect($request->section_value)->where('id','!=',0)->pluck('id');
        $sub_section_value = collect($request->sub_section_value)->where('id','!=',0)->pluck('id');
        $work_location_value = collect($request->work_location_value)->where('id','!=',0)->pluck('id');
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->where('id','!=',0)->pluck('id');
        $OfficeTime =  collect($request->OfficeTime)->where('id','!=',0)->pluck('id');
        
        if (!empty($OfficeTime)) {
            $OfficeTime = $OfficeTime;
        }else{
            $OfficeTime = [];
        }
        $process_type = 0;
        if(!empty($request->process_type)){
            $process_type = $request->process_type;
        }
        $data['process_type'] = $request->process_type;
        
        if($process_type == 2){
            $AllpayrollData = PayrollList::valid()->project()
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'payroll.shift_id')
            ->leftJoin('office_time_setups as psShift', 'psShift.id', '=', 'payroll.ps_id')
            ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->selectRaw(
                'employees.employee_department,employees.employee_id_no,employees.employee_fullname,
                payroll.shift_id,payroll.empid,psShift.title as present_shift_name,payroll.empid,
                office_time_setups.title as shift_name,payroll.gross_salary,payroll.attendance_bonus,payroll.paydays as prtot, 
                payroll.gross_salary as g_salary, payroll.netpay as net_wages,
                sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,
                sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,
                designations.designation_name,payroll.overtime,payroll.arear,payroll.night_allownce as night_allownce,
                payroll.residential_allowance,payroll.deduction_canteen,payroll.deduction_loan,payroll.late_abset_deduction as dad_deduction,
                payroll_process.remarks as process_type,  (gross_salary+overtime+night_allownce+residential_allowance+arear) as final_total_wagesNotAtteedace2
                ((gross_salary*paydays)+night_allownce+overtime+residential_allowance+arear) as final_total_wagesNotAtteedace,
                (gross_salary+overtime+night_allownce+attendance_bonus+residential_allowance+arear) as final_total_wages2,
                ((gross_salary*paydays)+night_allownce+overtime+attendance_bonus+residential_allowance+arear) as final_total_wages,
                (deduction_others+deduction_canteen+late_abset_deduction+deduction_loan+deduction_uniform) as total_deduction'
            )
            ->whereDate('payroll_process.startdate', '>=', $from_date)
            ->whereDate('payroll_process.enddate', '<=', $to_date);
            if(!empty($request->process_type)){
                $AllpayrollData->where('payroll_process.remarks', $request->process_type);
            }
            if (count($OfficeTime) > 0) {
                $AllpayrollData->whereIn('ps_id', $OfficeTime);
            }
            if(count($company_sbu_id) > 0){
                $AllpayrollData->whereIn('employees.employee_sbu', $company_sbu_id);
            }
            if (count($unit_value) > 0) {
                $AllpayrollData->whereIn('employee_unit', $unit_value);
            }
            if (count($sub_unit_value) > 0) {
                $AllpayrollData->whereIn('employee_sub_unit', $sub_unit_value);
            }
            if (count($department_name_value) > 0) {
                $AllpayrollData->whereIn('employee_department', $department_name_value);
            }
            $payrollDataDetels = $AllpayrollData->get()->toArray();
        }else{
            $AllpayrollData = PayrollList::valid()->project()
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'payroll.shift_id')
            ->leftJoin('office_time_setups as psShift', 'psShift.id', '=', 'payroll.ps_id')
            ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->selectRaw(
                'employees.employee_department,employees.employee_id_no,employees.employee_fullname,
                payroll.shift_id,payroll.ps_id,payroll.empid,psShift.title as present_shift_name,
                office_time_setups.title as shift_name,payroll.gross_salary,payroll.attendance_bonus,payroll.paydays as prtot, 
                payroll.gross_salary as g_salary, payroll.netpay as net_wages,
                sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,
                sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,
                designations.designation_name,payroll.overtime,payroll.arear,payroll.night_allownce as night_allownce,
                payroll.residential_allowance,payroll.deduction_canteen,payroll.deduction_loan, payroll.late_abset_deduction as dad_deduction,
                payroll_process.remarks as process_type, (gross_salary*paydays) as total_wages,
                ((gross_salary*paydays)+night_allownce+overtime+attendance_bonus+residential_allowance+arear) as final_total_wages,
                ((gross_salary*paydays)+night_allownce+overtime+residential_allowance+arear) as final_total_wagesNotAtteedace,
                ((gross_salary)+night_allownce+overtime+residential_allowance+arear) as final_total_wagesNotAtteedace2,
                ((gross_salary)+night_allownce+overtime+attendance_bonus+residential_allowance+arear) as final_total_wages2,
                (deduction_others+late_abset_deduction+deduction_canteen+deduction_loan+deduction_uniform) as total_deduction'
                
            )
            ->whereDate('payroll_process.startdate', '>=', $from_date)
            ->whereDate('payroll_process.enddate', '<=', $to_date);
            if(!empty($request->process_type)){
                $AllpayrollData->where('payroll_process.remarks', $request->process_type);
            }
            if (count($OfficeTime) > 0) {
                $AllpayrollData->whereIn('ps_id', $OfficeTime);
            }
            if(count($company_sbu_id) > 0){
                $AllpayrollData->whereIn('employees.employee_sbu', $company_sbu_id);
            }
            if (count($unit_value) > 0) {
                $AllpayrollData->whereIn('employee_unit', $unit_value);
            }
            if (count($sub_unit_value) > 0) {
                $AllpayrollData->whereIn('employee_sub_unit', $sub_unit_value);
            }
            if (count($department_name_value) > 0) {
                $AllpayrollData->whereIn('employee_department', $department_name_value);
            }
            $payrollDataDetels = $AllpayrollData->get()->toArray();
            $data['TotalNet_wages'] = collect($payrollDataDetels)->sum('net_wages');
            $data['Twagess'] = collect($payrollDataDetels)->sum('total_wages');
        }

        $allDeduction = [];
        $salaryTypes =['1' => 'Time Based', '2' => 'Production Based', '3' => 'Residential Based'];
        $Ttotal_wages = 0; 
        $Ttotal_dad = 0; $Tsalary_loan = 0; 
        $Ttotal_canteen_deduct = 0; $Ttotal_appron = 0; $Ttotal_ticket = 0;  
        $Ttotal_deduction = 0;  $Tnet_wages = 0; 
       
        $subUnits = collect(collect($payrollDataDetels)->whereIn('ps_id',[35,44,37,39,41,46,43])->pluck('sub_units_id')->toArray())
                    ->unique()->values()->toArray();
        foreach ($subUnits as $key => $value) {
               $filterData1 = collect($payrollDataDetels)->whereIn('ps_id',[35,44,37,39,41,46,43])
               //->where('process_type',$key_s)
                ->where('sub_units_id',$value)->toArray();
                $sub_units_name = collect($filterData1)->whereIn('ps_id',[35,44,37,39,41,46,43])
                ->where('sub_units_id',$value)->first();
                $departments = collect(collect($filterData1)
                ->where('final_total_wages','!=',0)
                ->whereIn('ps_id',[35,44,37,39,41,46,43])->pluck('employee_department')->toArray())
                ->unique()->values()->toArray();
            foreach ($departments as $key2 => $value_d) {
                $filterData2 = collect($payrollDataDetels)
                ->where('final_total_wages','!=',0)
                ->whereIn('ps_id',[35,44,37,39,41,46,43])->where('sub_units_id',$value) 
                ->where('employee_department',$value_d)->toArray();
                $department_name = collect($filterData2)
                ->where('final_total_wages','!=',0)
                ->whereIn('ps_id',[35,44,37,39,41,46,43])->where('sub_units_id',$value)
                ->where('employee_department',$value_d)->first();
                $total_wages = collect($filterData2)->whereIn('process_type',[2,4])->where('sub_units_id',$value)
                ->sum('final_total_wages2')+collect($filterData2)->whereIn('process_type',[1,3])->where('sub_units_id',$value)->sum('final_total_wages');
                $total_dad = collect($filterData2)->sum('dad_deduction');
                $salary_loan = collect($filterData2)->sum('deduction_loan');
                $total_canteen_deduct = collect($filterData2)->sum('deduction_canteen');
                $total_appron_deduct = collect($filterData2)->sum('deduction_uniform');
                $total_ticket_deduct = collect($filterData2)->sum('deduction_ticket');
                $total_deduction = collect($filterData2)->sum('total_deduction');
                $allDeduction[] = [
                    'department_name' => $department_name['department_name'] ?? '',
                    'sub_unit_name' => $sub_units_name['sub_unit_name'] ?? '',
                    'total_wages' => $total_wages ?? 0,
                    'total_dad' => $total_dad ?? 0,
                    'salary_loan' => $salary_loan ?? 0,
                    'total_canteen_deduct' => $total_canteen_deduct ?? 0,
                    'total_appron_deduct' => $total_appron_deduct ?? 0,
                    'total_ticket_deduct' => $total_ticket_deduct ?? 0,
                    'total_deduction' => $total_deduction ?? 0,
                    'net_wages' => ($total_wages - $total_deduction) ?? 0,
                ];
                    $Ttotal_wages += $total_wages; 
                    $Ttotal_dad += $total_dad; $Tsalary_loan += $salary_loan; 
                    $Ttotal_canteen_deduct += $total_canteen_deduct; $Ttotal_appron += $total_appron_deduct; $Ttotal_ticket += $total_ticket_deduct;  
                    $Ttotal_deduction += $total_deduction;
                    $Tnet_wages += ($total_wages - $total_deduction);
                
            }
        }
        $data['payrollDataDetels'] = $allDeduction;
        $repoerNamae = 'Payment List - A Shift From ' .date('d M, Y',strtotime($from_date)). " To ". date('d M, Y',strtotime($to_date));
        $data['report_name'] = $repoerNamae;
        $data['print_date'] =  date('d M, Y');
        $data['search_button'] = 2;


        $data['total_gross_wages'] = $Ttotal_wages;
        $data['total_dad_wages'] = $Ttotal_dad;
        $data['total_loan_deduct'] = $Tsalary_loan;
        $data['total_canteen_deduct'] = $Ttotal_canteen_deduct;
        $data['total_appron_deduct'] = $Ttotal_appron;
        $data['total_tic_deduct'] = $Ttotal_ticket;
        $data['total_total_deduct'] = $Ttotal_deduction;
        $data['total_net_amount'] = $Tnet_wages;
        

        return response($data);
    }
    public function get_weekly_report(Request $request) {
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '0');
        
        $unit_value = collect($request->unit_value)->where('id','!=',0)->pluck('id');
        $sub_unit_value = collect($request->sub_unit_value)->where('id','!=',0)->pluck('id');
        $department_name_value = collect($request->department_name_value)->where('id','!=',0)->pluck('id');
        $designation_name_value = collect($request->designation_name_value)->where('id','!=',0)->pluck('id');
        $section_value = collect($request->section_value)->where('id','!=',0)->pluck('id');
        $sub_section_value = collect($request->sub_section_value)->where('id','!=',0)->pluck('id');
        $work_location_value = collect($request->work_location_value)->where('id','!=',0)->pluck('id');
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->where('id','!=',0)->pluck('id');
        $OfficeTime =  collect($request->OfficeTime)->where('id','!=',0)->pluck('id');
        
        if (!empty($OfficeTime)) {
            $OfficeTime = $OfficeTime;
        }else{
            $OfficeTime = [];
        }
        $process_type = 0;
        if(!empty($request->process_type)){
            $process_type = $request->process_type;
        }
        $data['process_type'] = $request->process_type;
        
        if($process_type == 2){
            $AllpayrollData = PayrollList::valid()->project()
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'payroll.shift_id')
            ->leftJoin('office_time_setups as psShift', 'psShift.id', '=', 'payroll.ps_id')
            ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->selectRaw(
                'employees.employee_department,employees.employee_id_no,employees.employee_designation,employees.employee_fullname,
                payroll.shift_id,payroll.empid,psShift.title as present_shift_name,payroll.empid,
                office_time_setups.title as shift_name,payroll.gross_salary,payroll.attendance_bonus,payroll.paydays as prtot, 
                payroll.gross_salary as g_salary, payroll.netpay as net_wages,
                sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,
                sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,
                designations.designation_name,payroll.overtime,payroll.arear,payroll.night_allownce as night_allownce,
                payroll.residential_allowance,payroll.deduction_canteen,payroll.deduction_loan, payroll.late_abset_deduction as dad_deduction,
                payroll_process.remarks as process_type,  (gross_salary+overtime+night_allownce+residential_allowance+arear) as final_total_wagesNotAtteedace2
                ((gross_salary*paydays)+night_allownce+overtime+residential_allowance+arear) as final_total_wagesNotAtteedace,
                (gross_salary+overtime+night_allownce+attendance_bonus+residential_allowance+arear) as final_total_wages2,
                ((gross_salary*paydays)+night_allownce+overtime+attendance_bonus+residential_allowance+arear) as final_total_wages,
                (deduction_others+deduction_canteen+late_abset_deduction+deduction_loan+deduction_uniform) as total_deduction'
            )
            ->whereDate('payroll_process.startdate', '>=', $from_date)
            ->whereDate('payroll_process.enddate', '<=', $to_date);
            if(!empty($request->process_type)){
                $AllpayrollData->where('payroll_process.remarks', $request->process_type);
            }
            if (count($OfficeTime) > 0) {
                $AllpayrollData->whereIn('ps_id', $OfficeTime);
            }
            if(count($company_sbu_id) > 0){
                $AllpayrollData->whereIn('employees.employee_sbu', $company_sbu_id);
            }
            if (count($unit_value) > 0) {
                $AllpayrollData->whereIn('employee_unit', $unit_value);
            }
            if (count($sub_unit_value) > 0) {
                $AllpayrollData->whereIn('employee_sub_unit', $sub_unit_value);
            }
            if (count($department_name_value) > 0) {
                $AllpayrollData->whereIn('employee_department', $department_name_value);
            }
            $payrollDataDetels = $AllpayrollData->get()->toArray();
        }else{
            $AllpayrollData = PayrollList::valid()->project()
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'payroll.shift_id')
            ->leftJoin('office_time_setups as psShift', 'psShift.id', '=', 'payroll.ps_id')
            ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->selectRaw(
                'employees.employee_department,employees.employee_designation,employees.employee_id_no,employees.employee_fullname,
                payroll.shift_id,payroll.ps_id,payroll.empid,psShift.title as present_shift_name,
                office_time_setups.title as shift_name,payroll.gross_salary,payroll.attendance_bonus,payroll.paydays as prtot, 
                payroll.gross_salary as g_salary, payroll.netpay as net_wages,
                sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,
                sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,
                designations.designation_name,payroll.overtime,payroll.arear,payroll.night_allownce as night_allownce,
                payroll.residential_allowance,payroll.deduction_canteen,payroll.deduction_loan,
                payroll.late_abset_deduction as dad_deduction,
                payroll_process.remarks as process_type, (gross_salary*paydays) as total_wages,
                ((gross_salary)+night_allownce+overtime+attendance_bonus+residential_allowance+arear) as final_total_wages2,
                ((gross_salary*paydays)+night_allownce+overtime+attendance_bonus+residential_allowance+arear) as final_total_wages,
                ((gross_salary*paydays)+night_allownce+overtime+residential_allowance+arear) as final_total_wagesNotAtteedace,
                ((gross_salary)+night_allownce+overtime+residential_allowance+arear) as final_total_wagesNotAtteedace2,
                (deduction_others+deduction_canteen+late_abset_deduction+deduction_loan+deduction_uniform) as total_deduction'
                
            )
            ->whereDate('payroll_process.startdate', '>=', $from_date)
            ->whereDate('payroll_process.enddate', '<=', $to_date);
            if(!empty($request->process_type)){
                $AllpayrollData->where('payroll_process.remarks', $request->process_type);
            }
            if (count($OfficeTime) > 0) {
                $AllpayrollData->whereIn('ps_id', $OfficeTime);
            }
            if(count($company_sbu_id) > 0){
                $AllpayrollData->whereIn('employees.employee_sbu', $company_sbu_id);
            }
            if (count($unit_value) > 0) {
                $AllpayrollData->whereIn('employee_unit', $unit_value);
            }
            if (count($sub_unit_value) > 0) {
                $AllpayrollData->whereIn('employee_sub_unit', $sub_unit_value);
            }
            if (count($department_name_value) > 0) {
                $AllpayrollData->whereIn('employee_department', $department_name_value);
            }
            $payrollDataDetels = $AllpayrollData->get()->toArray();
            $data['TotalNet_wages'] = collect($payrollDataDetels)->sum('net_wages');
            $data['Twagess'] = collect($payrollDataDetels)->sum('total_wages');
        }
        
        $subUnits = collect(collect($payrollDataDetels)->pluck('sub_units_id')->toArray())
                    ->unique()->values()->toArray();
        $allDeduction = [];
        $salaryTypes =['1' => 'Time Based', '2' => 'Production Based', '3' => 'Residential Based'];
        $Ttotal_a_wages = 0; $Ttotal_b_wages = 0; $Ttotal_c_wages = 0; $Ttotal_wages = 0; 
        $Tbonus_hands = 0; $Tbonus_amount = 0; $Ttotal_dad = 0; $Tsalary_loan = 0; 
        $Ttotal_canteen_deduct = 0; $Ttotal_appron = 0; $Ttotal_ticket = 0;  
        $Ttotal_deduction = 0; $Ttop_sheet_head = 0; $Twages_and_bonus = 0; $Tnet_wages = 0; $Ttop_sheet_remarks = 0;
        foreach ($salaryTypes as $key_s => $salary_tid){
            foreach ($subUnits as $key => $value) {
                $filterData1 = collect($payrollDataDetels)->where('process_type',$key_s)
                ->where('sub_units_id',$value)->toArray();
                $sub_units_name = collect($payrollDataDetels)->where('process_type',$key_s)
                ->where('sub_units_id',$value)->first();
                $departments = collect(collect($filterData1)->pluck('employee_department')->toArray())
                        ->unique()->values()->toArray();
                        foreach ($departments as $key2 => $value_d) {
                            $filterData2 = collect($filterData1)->where('process_type',$key_s)
                            ->where('sub_units_id',$value)->where('employee_department',$value_d)->toArray();
                            $department_name = collect($filterData2)->where('process_type',$key_s)
                            ->where('sub_units_id',$value)->where('employee_department',$value_d)->first();

                            $shiftA = collect($filterData2)->where('process_type',$key_s)
                            ->where('sub_units_id',$value)->where('employee_department',$value_d)
                            ->whereIn('ps_id',[35,44,37,39,41,46,43])->toArray();
                            $shiftB = collect($filterData2)->where('process_type',$key_s)
                            ->where('sub_units_id',$value)->where('employee_department',$value_d)
                            ->whereIn('ps_id',[34,45,38,42])->toArray();
                            $shiftC = collect($filterData2)->where('process_type',$key_s)
                            ->where('sub_units_id',$value)->where('employee_department',$value_d)
                            ->whereIn('ps_id',[36,40])->toArray();
                            
                            if($key_s == 2){
                                $total_a_wages = collect($shiftA)->sum('final_total_wagesNotAtteedace2');
                                $total_b_wages = collect($shiftB)->sum('final_total_wagesNotAtteedace2');
                                $total_c_wages = collect($shiftC)->sum('final_total_wagesNotAtteedace2');
                                $wages_and_bonus =  collect($filterData2)->sum('final_total_wages2');
                            }else{
                                $total_a_wages = collect($shiftA)->sum('final_total_wagesNotAtteedace');
                                $total_b_wages = collect($shiftB)->sum('final_total_wagesNotAtteedace');
                                $total_c_wages = collect($shiftC)->sum('final_total_wagesNotAtteedace');
                                $wages_and_bonus =  collect($filterData2)->sum('final_total_wages');

                            }
                            

                            $bonus_hands = collect($filterData2)->where('attendance_bonus','!=',0)->count();
                            $bonus_amount = collect($filterData2)->where('attendance_bonus','!=',0)->sum('attendance_bonus');
                            //$total_dad = collect($filterData2)->where('deduction_others','!=',0)->sum('deduction_others');
                             $total_dad = collect($filterData2)->where('dad_deduction','!=',0)->sum('dad_deduction');
                            $salary_loan = collect($filterData2)->sum('deduction_loan');
                            $total_canteen_deduct = collect($filterData2)->sum('deduction_canteen');
                            $total_appron = collect($filterData2)->sum('deduction_uniform');
                            $total_ticket = collect($filterData2)->sum('deduction_ticket');
                            $total_deduction = collect($filterData2)->sum('total_deduction');
                            $top_sheet_head =  collect($filterData2)->where('final_total_wages','!=',0)->count();
                                    
                            $allDeduction[] = [
                                'department_name' => $department_name['department_name'] ?? '',
                                'sub_unit_name' => $sub_units_name['sub_unit_name'] ?? '',
                                'salary_type' => $salary_tid,
                                'total_a_wages' => $total_a_wages ?? 0,
                                'total_b_wages' => $total_b_wages ?? 0,
                                'total_c_wages' => $total_c_wages ?? 0,
                                'total_wages' => ($total_a_wages + $total_c_wages + $total_b_wages) ?? 0,
                                'bonus_hands' => $bonus_hands ?? 0,
                                'bonus_amount' => $bonus_amount ?? 0,
                                'wages_and_bonus' => $wages_and_bonus ?? 0,
                                'total_dad' => $total_dad ?? 0,
                                'salary_loan' => $salary_loan ?? 0,
                                'total_canteen_deduct' => $total_canteen_deduct ?? 0,
                                'total_appron' => $total_appron ?? 0,
                                'total_ticket' => $total_ticket ?? 0,
                                'total_deduction' => $total_deduction ?? 0,
                                'net_wages' => ($wages_and_bonus - $total_deduction) ?? 0,
                                'top_sheet_head' => $top_sheet_head ?? 0,
                            ];
                            $Ttotal_a_wages += $total_a_wages; $Ttotal_b_wages += $total_b_wages; $Ttotal_c_wages += $total_c_wages; 
                            $Ttotal_wages += ($total_a_wages + $total_b_wages + $total_c_wages); 
                            $Twages_and_bonus += $wages_and_bonus;
                            $Tbonus_hands += $bonus_hands; $Tbonus_amount += $bonus_amount; $Ttotal_dad += $total_dad; $Tsalary_loan += $salary_loan; 
                            $Ttotal_canteen_deduct += $total_canteen_deduct; $Ttotal_appron += $total_appron; $Ttotal_ticket += $total_ticket;  
                            $Ttotal_deduction += $total_deduction; $Ttop_sheet_head += $top_sheet_head;  $Ttop_sheet_remarks += 0;
                            $Tnet_wages += ($wages_and_bonus - $total_deduction);
                            
                        }
            }

            
         
        }
        
        $data['payrollDataDetels'] = $allDeduction;
        // ->whereNotIn('employee_designation,',[411,413])->toArray();
        // $data['payrollTRDataDetels'] = collect($allDeduction)->whereIn('employee_designation,',[411,413])->toArray();
        $repoerNamae = 'Top Sheet ' .date('d M, Y',strtotime($from_date)). " To ". date('d M, Y',strtotime($to_date));
        $data['report_name'] = $repoerNamae;
        $data['print_date'] =  date('d M, Y');
        $data['search_button'] = 1;

        $data['Ttotal_a_wages'] = $Ttotal_a_wages;
        $data['Ttotal_b_wages'] = $Ttotal_b_wages;
        $data['Ttotal_c_wages'] = $Ttotal_c_wages;
        $data['Ttotal_wages'] = $Ttotal_wages;
        $data['Tbonus_hands'] = $Tbonus_hands;
        $data['Tbonus_amount'] = $Tbonus_amount;
        $data['Ttotal_dad'] = $Ttotal_dad;
        $data['Tsalary_loan'] = $Tsalary_loan;
        $data['Ttotal_canteen_deduct'] = $Ttotal_canteen_deduct;
        $data['Ttotal_appron'] = $Ttotal_appron;
        $data['Ttotal_ticket'] = $Ttotal_ticket;
        $data['Ttotal_deduction'] = $Ttotal_deduction;
        $data['Ttop_sheet_head'] = $Ttop_sheet_head;
        $data['Ttop_sheet_remarks'] = 0;
        $data['Twages_and_bonus'] = $Twages_and_bonus;
        $data['Tnet_wages'] = $Tnet_wages;
        

        return response($data);
    }

    public function get_weekly_report_deduction(Request $request) {
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '0');
        $unit_value = collect($request->unit_value)->where('id','!=',0)->pluck('id');
        $sub_unit_value = collect($request->sub_unit_value)->where('id','!=',0)->pluck('id');
        $department_name_value = collect($request->department_name_value)->where('id','!=',0)->pluck('id');
        $designation_name_value = collect($request->designation_name_value)->where('id','!=',0)->pluck('id');
        $section_value = collect($request->section_value)->where('id','!=',0)->pluck('id');
        $sub_section_value = collect($request->sub_section_value)->where('id','!=',0)->pluck('id');
        $work_location_value = collect($request->work_location_value)->where('id','!=',0)->pluck('id');
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->where('id','!=',0)->pluck('id');
        $OfficeTime =  collect($request->OfficeTime)->where('id','!=',0)->pluck('id');
        
        if (!empty($OfficeTime)) {
            $OfficeTime = $OfficeTime;
        }else{
            $OfficeTime = [];
        }
     
        $process_type = 0;
        if(!empty($request->process_type)){
            $process_type = $request->process_type;
        }
        $data['process_type'] = $request->process_type;
        
        if($process_type == 2){
            $AllpayrollData = PayrollList::valid()->project()
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'payroll.shift_id')
            ->leftJoin('office_time_setups as psShift', 'psShift.id', '=', 'payroll.ps_id')
            ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->selectRaw(
                'employees.employee_department,employees.employee_designation,employees.employee_id_no,employees.employee_fullname,
                payroll.shift_id,payroll.empid,psShift.title as present_shift_name,payroll.empid,
                office_time_setups.title as shift_name,payroll.gross_salary,payroll.attendance_bonus,payroll.paydays as prtot, 
                payroll.gross_salary as g_salary, payroll.netpay as net_wages,
                sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,
                sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,
                designations.designation_name,payroll.overtime,payroll.arear,payroll.night_allownce as night_allownce,
                payroll.residential_allowance,payroll.deduction_canteen,payroll.late_abset_deduction as dad_deduction,
                payroll_process.remarks as process_type,
                (gross_salary+overtime+night_allownce+attendance_bonus+residential_allowance+arear) as final_total_wages,
                (deduction_others+late_abset_deduction+deduction_canteen+deduction_uniform) as total_deduction'
            )
            ->whereDate('payroll_process.startdate', '>=', $from_date)
            ->whereDate('payroll_process.enddate', '<=', $to_date);
            if(!empty($request->process_type)){
                $AllpayrollData->where('payroll_process.remarks', $request->process_type);
            }
            if (count($OfficeTime) > 0) {
                $AllpayrollData->whereIn('ps_id', $OfficeTime);
            }
            if(count($company_sbu_id) > 0){
                $AllpayrollData->whereIn('employees.employee_sbu', $company_sbu_id);
            }
            if (count($unit_value) > 0) {
                $AllpayrollData->whereIn('employee_unit', $unit_value);
            }
            if (count($sub_unit_value) > 0) {
                $AllpayrollData->whereIn('employee_sub_unit', $sub_unit_value);
            }
            if (count($department_name_value) > 0) {
                $AllpayrollData->whereIn('employee_department', $department_name_value);
            }
            $payrollDataDetels = $AllpayrollData->get()->toArray();
        }else{
            $AllpayrollData = PayrollList::valid()->project()
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'payroll.shift_id')
            ->leftJoin('office_time_setups as psShift', 'psShift.id', '=', 'payroll.ps_id')
            ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->selectRaw(
                'employees.employee_department,employees.employee_designation,employees.employee_id_no,employees.employee_fullname,
                payroll.shift_id,payroll.ps_id,payroll.empid,psShift.title as present_shift_name,
                office_time_setups.title as shift_name,payroll.gross_salary,payroll.attendance_bonus,payroll.paydays as prtot, 
                payroll.gross_salary as g_salary, payroll.netpay as net_wages,
                sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,
                sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,
                designations.designation_name,payroll.overtime,payroll.arear,payroll.night_allownce as night_allownce,
                payroll.residential_allowance,payroll.deduction_canteen,payroll.late_abset_deduction as dad_deduction,
                payroll_process.remarks as process_type, (gross_salary*paydays) as total_wages,
                ((gross_salary*paydays)+night_allownce+overtime+attendance_bonus+residential_allowance+arear) as final_total_wages,
                (deduction_others+late_abset_deduction+deduction_canteen+deduction_uniform) as total_deduction'
            )
            ->whereDate('payroll_process.startdate', '>=', $from_date)
            ->whereDate('payroll_process.enddate', '<=', $to_date);
            if(!empty($request->process_type)){
                $AllpayrollData->where('payroll_process.remarks', $request->process_type);
            }
            if (count($OfficeTime) > 0) {
                $AllpayrollData->whereIn('ps_id', $OfficeTime);
            }
            if(count($company_sbu_id) > 0){
                $AllpayrollData->whereIn('employees.employee_sbu', $company_sbu_id);
            }
            if (count($unit_value) > 0) {
                $AllpayrollData->whereIn('employee_unit', $unit_value);
            }
            if (count($sub_unit_value) > 0) {
                $AllpayrollData->whereIn('employee_sub_unit', $sub_unit_value);
            }
            if (count($department_name_value) > 0) {
                $AllpayrollData->whereIn('employee_department', $department_name_value);
            }
            $payrollDataDetels = $AllpayrollData->get()->toArray();
            $data['TotalNet_wages'] = collect($payrollDataDetels)->sum('net_wages');
            $data['Twagess'] = collect($payrollDataDetels)->sum('total_wages');
        }
        
        $subUnits = collect(collect($payrollDataDetels)->pluck('sub_units_id')->toArray())
                    ->unique()->values()->toArray();
        $allDeduction = [];
        $salaryTypes =['1' => 'Time Based', '2' => 'Production Based', '3' => 'Residential Based'];
        $SalaryType =[];
        $TdadAmount = 0; $TSalaryLoan = 0; $Tcanteen = 0; $TBusTicket = 0; $TTotalDeduction = 0;
        $Ta_deduction_loan = 0; $Tb_deduction_loan = 0; $Tc_deduction_loan = 0; 
        $Ta_deduction_canteen = 0; $Tb_deduction_canteen = 0; $Tc_deduction_canteen = 0;
        $Ta_deduction_uniform = 0; $Tb_deduction_uniform = 0; $Tc_deduction_uniform = 0; 
        $Ta_deduction_bus_ticket = 0; $Tb_deduction_bus_ticket = 0; $Tc_deduction_bus_ticket = 0;
        $Ta_deduction_dad = 0; $Tb_deduction_dad = 0; $Tc_deduction_dad = 0; $Ttotal_dad_deduction = 0;
        $Ttotal_bus_ticket_deduction  = 0; $Ttotal_canteen_deduction = 0; $Ttotal_loan_deduction = 0;
        foreach ($salaryTypes as $key_s => $salary_tid){
            $dadAmount =0; $SalaryLoan =0; $canteen =0; $BusTicket = 0; $TotalDeduction =0;
            foreach ($subUnits as $key => $value) {
                $filterData1 = collect($payrollDataDetels)->where('process_type',$key_s)
                ->where('sub_units_id',$value)->toArray();
                $sub_units_name = collect($payrollDataDetels)->where('process_type',$key_s)
                ->where('sub_units_id',$value)->first();
                $departments = collect(collect($filterData1)->pluck('employee_department')->toArray())
                        ->unique()->values()->toArray();
                        foreach ($departments as $key2 => $value_d) {
                            $filterData2 = collect($filterData1)->where('process_type',$key_s)
                            ->where('sub_units_id',$value)->where('employee_department',$value_d)->toArray();
                            $department_name = collect($filterData2)->where('process_type',$key_s)
                            ->where('sub_units_id',$value)->where('employee_department',$value_d)->first();

                            $shiftA = collect($filterData2)->where('process_type',$key_s)
                            ->where('sub_units_id',$value)->where('employee_department',$value_d)
                            ->whereIn('ps_id',[35,44,37,39,41,46,43])->toArray();
                            $shiftB = collect($filterData2)->where('process_type',$key_s)
                            ->where('sub_units_id',$value)->where('employee_department',$value_d)
                            ->whereIn('ps_id',[34,45,38,42])->toArray();
                            $shiftC = collect($filterData2)->where('process_type',$key_s)
                            ->where('sub_units_id',$value)->where('employee_department',$value_d)
                            ->whereIn('ps_id',[36,40])->toArray();

                            $a_deduction_loan = collect($shiftA)->sum('deduction_loan');
                            $b_deduction_loan = collect($shiftB)->sum('deduction_loan');
                            $c_deduction_loan = collect($shiftC)->sum('deduction_loan');
                             
                            $SalaryLoan += ($a_deduction_loan + $b_deduction_loan + $c_deduction_loan) ?? 0; 
                            $a_deduction_canteen = collect($shiftA)->sum('deduction_canteen');
                            $b_deduction_canteen = collect($shiftB)->sum('deduction_canteen');
                            $c_deduction_canteen = collect($shiftC)->sum('deduction_canteen');
                            $canteen += ($a_deduction_canteen + $b_deduction_canteen + $c_deduction_canteen) ?? 0; 
                            $a_deduction_uniform = collect($shiftA)->sum('deduction_uniform');
                            $b_deduction_uniform = collect($shiftB)->sum('deduction_uniform');
                            $c_deduction_uniform = collect($shiftC)->sum('deduction_uniform');
                            $a_deduction_dad = collect($shiftA)->sum('dad_deduction');
                            $b_deduction_dad = collect($shiftB)->sum('dad_deduction');
                            $c_deduction_dad = collect($shiftC)->sum('dad_deduction');
                            $dadAmount += ($a_deduction_dad+$b_deduction_dad+$c_deduction_dad);
                            
                            $a_deduction_bus_ticket = collect($shiftA)->sum('deduction_ticket');
                            $b_deduction_bus_ticket = collect($shiftB)->sum('deduction_ticket');
                            $c_deduction_bus_ticket = collect($shiftC)->sum('deduction_ticket');
                            $BusTicket += ($a_deduction_bus_ticket + $b_deduction_bus_ticket + $c_deduction_bus_ticket) ?? 0; 
                            // $total_dad_deduction += ($a_deduction_dad + $b_deduction_dad + $c_deduction_dad) ?? 0; 
                            $TotalDeduction = ($BusTicket + $canteen + $SalaryLoan + $dadAmount) ?? 0;
                            
                            $allDeduction[] = [
                                'department_name' => $department_name['department_name'] ?? '',
                                'sub_unit_name' => $sub_units_name['sub_unit_name'] ?? '',
                                'salary_type' => $salary_tid,
                                'a_deduction_loan' => $a_deduction_loan ?? 0,
                                'b_deduction_loan' => $b_deduction_loan ?? 0,
                                'c_deduction_loan' => $c_deduction_loan ?? 0,
                                'total_loan_deduction' => ($a_deduction_loan + $b_deduction_loan + $c_deduction_loan) ?? 0,
                                'a_deduction_canteen' => $a_deduction_canteen ?? 0,
                                'b_deduction_canteen' => $b_deduction_canteen ?? 0,
                                'c_deduction_canteen' => $c_deduction_canteen ?? 0,
                                'total_canteen_deduction' => ($a_deduction_canteen + $b_deduction_canteen + $c_deduction_canteen) ?? 0,
                                'a_deduction_uniform' => $a_deduction_uniform ?? 0,
                                'b_deduction_uniform' => $b_deduction_uniform ?? 0,
                                'c_deduction_uniform' => $c_deduction_uniform ?? 0,
                                'total_uniform_deduction' => ($a_deduction_uniform + $b_deduction_uniform + $c_deduction_uniform) ?? 0,
                                'a_deduction_dad' => $a_deduction_dad,
                                'b_deduction_dad' => $b_deduction_dad,
                                'c_deduction_dad' => $c_deduction_dad,
                                'total_dad_deduction' => ($a_deduction_dad + $b_deduction_dad + $c_deduction_dad),
                                'a_deduction_bus_ticket' =>  $a_deduction_bus_ticket ?? 0,
                                'b_deduction_bus_ticket' =>  $b_deduction_bus_ticket ?? 0,
                                'c_deduction_bus_ticket' =>  $c_deduction_bus_ticket ?? 0,
                                'total_bus_ticket_deduction' => ($a_deduction_bus_ticket + $b_deduction_bus_ticket + $c_deduction_bus_ticket),
                            ];

                            $Ta_deduction_loan += $a_deduction_loan; $Tb_deduction_loan += $b_deduction_loan; $Tc_deduction_loan += $c_deduction_loan; 
                            $Ta_deduction_canteen += $a_deduction_canteen; $Tb_deduction_canteen += $b_deduction_canteen; $Tc_deduction_canteen += $c_deduction_canteen;
                            $Ta_deduction_uniform += $a_deduction_uniform; $Tb_deduction_uniform += $b_deduction_uniform; $Tc_deduction_uniform += $c_deduction_uniform; 
                            $Ta_deduction_bus_ticket += $a_deduction_bus_ticket; $Tb_deduction_bus_ticket += $b_deduction_bus_ticket; $Tc_deduction_bus_ticket += $c_deduction_bus_ticket;
                            $Ta_deduction_dad += $a_deduction_dad; $Tb_deduction_dad += $b_deduction_dad; $Tc_deduction_dad += $c_deduction_dad; $Ttotal_dad_deduction +=  ($a_deduction_dad + $b_deduction_dad + $c_deduction_dad);
                            $Ttotal_bus_ticket_deduction  = $a_deduction_bus_ticket + $b_deduction_bus_ticket + $c_deduction_bus_ticket; 
                            $Ttotal_canteen_deduction += $a_deduction_canteen + $b_deduction_canteen + $c_deduction_canteen; 
                            $Ttotal_loan_deduction +=  $a_deduction_loan + $b_deduction_loan + $c_deduction_loan;
                            $Ttotal_dad_deduction =  ($a_deduction_dad + $b_deduction_dad + $c_deduction_dad);
                            
                        }
            }

            
            $SalaryType [] = [
                'Salary_Type_name' => $salary_tid,
                'dadAmount' => $dadAmount,
                'SalaryLoan' => $SalaryLoan,
                'canteen' => $canteen,
                'BusTicket' => $BusTicket,
                'TotalDeduction' => $TotalDeduction, 
             ];
             $TdadAmount += $dadAmount; $TSalaryLoan += $SalaryLoan; 
             $Tcanteen += $canteen; $TBusTicket += $BusTicket; 
             $TTotalDeduction += ($dadAmount + $TSalaryLoan + $SalaryLoan + $canteen + $BusTicket);
        }
        
        $data['payrollDataDetels'] = $allDeduction;
        $repoerNamae = 'Deduction Summary ' .date('d M, Y',strtotime($from_date)). " To ". date('d M, Y',strtotime($to_date));
        $data['report_name'] = $repoerNamae;
        $data['print_date'] =  date('d M, Y');
        $data['search_button'] = 6;
        $data['SalaryType'] = $SalaryType;

        $data['TdadAmount'] = $TdadAmount;
        $data['TSalaryLoan'] = $TSalaryLoan; 
        $data['Tcanteen'] = $Tcanteen;
        $data['TBusTicket'] = $TBusTicket;
        $data['TTotalDeduction'] = $TTotalDeduction;  
        
        $data['SRdadAmount'] = $SRdadAmount = 0;  
        $data['SRSalaryLoan'] = $SRSalaryLoan = collect($payrollDataDetels)->whereIn('employee_designation,',[411,413])->sum('deduction_loan'); 
        $data['SRcanteen'] = $SRcanteen = collect($payrollDataDetels)->whereIn('employee_designation',[411,413])->sum('deduction_canteen');
        $data['SRBusTicket'] = $SRBusTicket =collect($payrollDataDetels)->whereIn('employee_designation',[411,413])->sum('deduction_ticket');
        $data['SRTotalDeduction'] = $SRdadAmount + $SRSalaryLoan + $SRcanteen + $SRBusTicket;

        $data['GTdadAmount'] = ($SRdadAmount + $TdadAmount);
        $data['GTSalaryLoan'] = ($SRSalaryLoan + $TSalaryLoan); 
        $data['GTcanteen'] = ($SRcanteen + $Tcanteen);
        $data['GTBusTicket'] = ($SRBusTicket + $TBusTicket); 
        $data['GTTotalDeduction'] = ($SRdadAmount + $TdadAmount) + ($SRSalaryLoan + $TSalaryLoan) + ($SRcanteen + $Tcanteen) + ($SRBusTicket + $TBusTicket);

        $data['Ta_deduction_loan'] = $Ta_deduction_loan; $data['Tb_deduction_loan']= $Tb_deduction_loan; $data['Tc_deduction_loan']= $Tc_deduction_loan; 
        $data['Ta_deduction_canteen'] = $Ta_deduction_canteen; $data['Tb_deduction_canteen'] = $Tb_deduction_canteen; $data['Tc_deduction_canteen']= $Tc_deduction_canteen;
        $data['Ta_deduction_uniform'] = $Ta_deduction_uniform; $data['Tb_deduction_uniform'] = $Tb_deduction_uniform; $data['Tc_deduction_uniform'] = $Tc_deduction_uniform; 
        $data['Ta_deduction_bus_ticket'] = $Ta_deduction_bus_ticket; $data['Tb_deduction_bus_ticket']= $Tb_deduction_bus_ticket; $data['Tc_deduction_bus_ticket']= $Tc_deduction_bus_ticket;
        $data['Ta_deduction_dad'] = $Ta_deduction_dad; $data['Tb_deduction_dad'] = $Tb_deduction_dad; $data['Tc_deduction_dad']= $Tc_deduction_dad; $data['Ttotal_dad_deduction'] = $Ttotal_dad_deduction;
        $data['Ttotal_bus_ticket_deduction'] = $Ttotal_bus_ticket_deduction;
        $data['Ttotal_canteen_deduction']= $Ttotal_canteen_deduction; 
        $data['Ttotal_loan_deduction']= $Ttotal_loan_deduction; 
                           
                
        return response($data);
    }
    public function get_weekly_report_payroll(Request $request) {
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '0');
        $unit_value = collect($request->unit_value)->where('id','!=',0)->pluck('id');
        $sub_unit_value = collect($request->sub_unit_value)->where('id','!=',0)->pluck('id');
        $department_name_value = collect($request->department_name_value)->where('id','!=',0)->pluck('id');
        $designation_name_value = collect($request->designation_name_value)->where('id','!=',0)->pluck('id');
        $section_value = collect($request->section_value)->where('id','!=',0)->pluck('id');
        $sub_section_value = collect($request->sub_section_value)->where('id','!=',0)->pluck('id');
        $work_location_value = collect($request->work_location_value)->where('id','!=',0)->pluck('id');
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->where('id','!=',0)->pluck('id');
        $employee_name_value = collect($request->employee_name_value)->where('id','!=',0)->pluck('id');
        
        
        $OfficeTime =  collect($request->OfficeTime)->where('id','!=',0)->pluck('id');
        
        if (!empty($OfficeTime)) {
            $OfficeTime = $OfficeTime;
        }else{
            $OfficeTime = [];
        }
        if($request->process_type == 4){
            $process_type = 2;
        }else{
            $process_type = $request->process_type;
        }
        $data['process_type'] = $process_type;
        if(!empty($request->process_type)){
            if($request->process_type == 2 || $request->process_type == 4 ){
                    $AllpayrollData = PayrollList::valid()->project()
                    ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
                    // ->leftJoin('attendance_setups', 'attendance_setups.employee_id', '=', 'payroll.empid')
                    ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'payroll.shift_id')
                    ->leftJoin('office_time_setups as psShift', 'psShift.id', '=', 'payroll.ps_id')
                    ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
                    ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
                    ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
                    ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
                    ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
                    ->selectRaw(
                        'employees.employee_department,employees.employee_id_no,employees.employee_fullname,
                        payroll.shift_id,payroll.empid,psShift.title as present_shift_name,payroll.empid,
                        office_time_setups.title as shift_name,payroll.gross_salary,payroll.attendance_bonus,payroll.paydays as prtot, 
                        payroll.gross_salary as g_salary, payroll.netpay as net_wages,
                        sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,
                        sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,
                        designations.designation_name,payroll.overtime,payroll.arear,payroll.night_allownce as night_allownce,
                        payroll.residential_allowance,payroll.deduction_canteen,
                        payroll_process.remarks as process_type,payroll.late_abset_deduction as dad_deduction,
                        
                        (gross_salary+overtime+night_allownce+attendance_bonus+residential_allowance+arear) as final_total_wages,
                        (deduction_others+late_abset_deduction+deduction_canteen+deduction_uniform) as total_deduction'
                        
                    )
                    ->whereDate('payroll_process.startdate', '>=', $from_date)
                    ->whereDate('payroll_process.enddate', '<=', $to_date);
                    if(!empty($request->process_type)){
                        $AllpayrollData->where('payroll_process.remarks', $request->process_type);
                    }
                    if (count($OfficeTime) > 0) {
                        $AllpayrollData->whereIn('ps_id', $OfficeTime);
                    }
                    if(count($company_sbu_id) > 0){
                        $AllpayrollData->whereIn('employees.employee_sbu', $company_sbu_id);
                    }
                    

                    if (count($unit_value) > 0) {
                        $AllpayrollData->whereIn('employee_unit', $unit_value);
                    }
                    if (count($sub_unit_value) > 0) {
                        $AllpayrollData->whereIn('employee_sub_unit', $sub_unit_value);
                    }

                    if (count($department_name_value) > 0) {
                        $AllpayrollData->whereIn('employee_department', $department_name_value);
                    }
                    if (count($employee_name_value) > 0) {
                        $AllpayrollData->whereIn('payroll.empid', $employee_name_value);
                    }
                
                    
                    $payrollDataDetels = $AllpayrollData->orderBy('present_shift_name', 'ASC')->orderBy('employee_unit', 'ASC')
                    ->orderBy('employee_department', 'ASC')->orderBy('employee_id_no', 'ASC')->get()->toArray();
            }else{
                $AllpayrollData = PayrollList::valid()->project()
                ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
                // ->leftJoin('attendance_setups', 'attendance_setups.employee_id', '=', 'payroll.empid')
                ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'payroll.shift_id')
                ->leftJoin('office_time_setups as psShift', 'psShift.id', '=', 'payroll.ps_id')
                ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
                ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
                ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
                ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
                ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
                ->selectRaw(
                    'employees.employee_department,employees.employee_id_no,employees.employee_fullname,
                    payroll.shift_id,payroll.empid,psShift.title as present_shift_name,
                    office_time_setups.title as shift_name,payroll.gross_salary,payroll.attendance_bonus,payroll.paydays as prtot, 
                    payroll.gross_salary as g_salary, payroll.netpay as net_wages,
                    sub_units.id as sub_units_id,employees.employee_salary_type,departments.department_name,
                    sub_units.sub_unit_name,employees.employee_salary_type,work_locations.work_location_name,
                    designations.designation_name,payroll.overtime,payroll.arear,payroll.night_allownce as night_allownce,
                    payroll.residential_allowance,payroll.deduction_canteen,
                    payroll_process.remarks as process_type, (gross_salary*paydays) as total_wages,payroll.late_abset_deduction as dad_deduction,
                    
                    ((gross_salary*paydays)+night_allownce+overtime+attendance_bonus+residential_allowance+arear) as final_total_wages,
                    (deduction_others+late_abset_deduction+deduction_canteen+deduction_uniform) as total_deduction'
                    
                )
                ->whereDate('payroll_process.startdate', '>=', $from_date)
                ->whereDate('payroll_process.enddate', '<=', $to_date);
                if(!empty($request->process_type)){
                    $AllpayrollData->where('payroll_process.remarks', $request->process_type);
                }
                if (count($OfficeTime) > 0) {
                    $AllpayrollData->whereIn('ps_id', $OfficeTime);
                }
                if(count($company_sbu_id) > 0){
                    $AllpayrollData->whereIn('employees.employee_sbu', $company_sbu_id);
                }
                
            
                if (count($unit_value) > 0) {
                    $AllpayrollData->whereIn('employee_unit', $unit_value);
                }
                if (count($sub_unit_value) > 0) {
                    $AllpayrollData->whereIn('employee_sub_unit', $sub_unit_value);
                }
            
                if (count($department_name_value) > 0) {
                    $AllpayrollData->whereIn('employee_department', $department_name_value);
                }
                if (count($employee_name_value) > 0) {
                    $AllpayrollData->whereIn('payroll.empid', $employee_name_value);
                }
                
                $payrollDataDetels = $AllpayrollData->orderBy('present_shift_name', 'ASC')->orderBy('employee_unit', 'ASC')
                ->orderBy('employee_department', 'ASC')->orderBy('employee_id_no', 'ASC')->get()->toArray();
                $data['TotalNet_wages'] = collect($payrollDataDetels)->sum('net_wages');
                $data['Twagess'] = collect($payrollDataDetels)->sum('total_wages');

            }
        }
        $employee_all_id = collect($payrollDataDetels)->pluck('empid')->toArray();
        $attendanceInfo=DB::table('attendance')
                            ->whereDate('pdate', '>=', $from_date)
                            ->whereDate('pdate', '<=', $to_date)
                        ->whereDate('pdate', '<=', $to_date)
                        ->whereIn('employee_id', $employee_all_id)
                        ->get();
        foreach ($payrollDataDetels as $key => $value) {
            $payrollDataDetels[$key]['ot_time']=collect($attendanceInfo)->where('employee_id', $value['empid'])->sum('ot_entry') ?? collect($attendanceInfo)->where('employee_id', $value['empid'])->sum('ot_time') ?? 0;
            if($request->process_type == 4){
                $process_type = 2;
            }else{
                $process_type = $request->process_type;
            }
            $payrollDataDetels[$key]['process_type'] = $process_type;

        } 
    

        $reportType = collect($payrollDataDetels)->first();
        $name = '';
        if(!empty($reportType)){
            if($reportType['process_type'] == 1 ){
                $name = 'Time Rate ';
            }else if($reportType['process_type'] == 2){
                $name = 'Production Based ';
            }else if($reportType['process_type'] == 3){
                $name = 'Residential Based ';
            }else if($reportType['process_type'] == 4){
                $name = 'TR';
            }
        }
        $payrollDataDetels = $payrollDataDetels;
        $data['payrollDataDetels'] =$payrollDataDetels; 
        $repoerNamae = 'Wages Sheet '. $name .date('d M, Y',strtotime($from_date)). " To ". date('d M, Y',strtotime($to_date));
        $data['report_name'] = $repoerNamae;
        $data['print_date'] =  date('d M, Y');
        $data['search_button'] = 7;
        $data['tAmount'] = collect($payrollDataDetels)->sum('g_salary');
        $data['totAmount'] = collect($payrollDataDetels)->sum('overtime');
        $data['tattBonus'] = collect($payrollDataDetels)->sum('attendance_bonus');
        $data['tadjAmount'] = collect($payrollDataDetels)->sum('arear');
        $data['tnightAlwnc'] = collect($payrollDataDetels)->sum('night_allownce');
        $data['TrA'] = collect($payrollDataDetels)->sum('residential_allowance');
        $data['totalDadDeduction'] = collect($payrollDataDetels)->sum('dad_deduction');
        $data['totalAmount'] = collect($payrollDataDetels)->sum('final_total_wages');
        $data['TCantDed'] = collect($payrollDataDetels)->sum('deduction_canteen');
        $data['tdeduction_uniform'] = collect($payrollDataDetels)->sum('tdeduction_uniform');
        $data['TOtherDeduct'] = collect($payrollDataDetels)->sum('deduction_others');
        $data['TotalDeduction'] = collect($payrollDataDetels)->sum('total_deduction');
        $data['NetAmoun'] = ($data['totalAmount']- $data['TotalDeduction']) ?? 0;
        return response($data);
    }



    public function cash_salary_report(Request $request) {
        // return response($request);
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '0');
        
        $unit_value = collect($request->unit_value)->where('id','!=',0)->pluck('id');
        $sub_unit_value = collect($request->sub_unit_value)->where('id','!=',0)->pluck('id');
        $department_name_value = collect($request->department_name_value)->where('id','!=',0)->pluck('id');
        $designation_name_value = collect($request->designation_name_value)->where('id','!=',0)->pluck('id');
        $section_value = collect($request->section_value)->where('id','!=',0)->pluck('id');
        $sub_section_value = collect($request->sub_section_value)->where('id','!=',0)->pluck('id');
        $work_location_value = collect($request->work_location_value)->where('id','!=',0)->pluck('id');
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->where('id','!=',0)->pluck('id');
        $OfficeTime =  collect($request->OfficeTime)->where('id','!=',0)->pluck('id');
        $repoerNamae = 'Payroll Report ' .date('d M, Y',strtotime($from_date)). " To ". date('d M, Y',strtotime($to_date));
       
        $process_type = 0;
        if(!empty($request->process_type)){
            $process_type = $request->process_type;
        }
        $data['process_type'] = $request->process_type;
        $data['report_search_button'] = 1;
        $data['report_name'] = $repoerNamae;
        $data['print_date'] =  date('d M, Y');
        $data['search_button'] = 10;

        $data['paymonth'] = $request->process_type;
        $data['pay_year'] = date('Y');
        if(!empty($request->from_date)){
            $data['pay_year'] = date('Y', strtotime($request->from_date));
        }
        if(!empty($request->to_date)){
            $data['pay_year'] = date('Y', strtotime($request->to_date));
        }
        if(!empty($request->payroll_year)){
            $data['pay_year'] = $request->payroll_year;
        }
        $data['report_type'] = $request->report_type; // cash/bank/details
        if($data['report_type'] == 10){
            $data['type'] = 1;
        }elseif($data['report_type'] == 20){
            $data['type'] = 2;
        }else{
            $data['type'] = 0;
        }
        
        $payrollData = PayrollProcessList::valid()
        ->where('companysbu_id', $company_sbu_id)
        ->where('paymonth', $data['paymonth'])
        ->where('pay_year', $data['pay_year'])
        ->where('type', 1)
        ->first();

        if(empty($payrollData)){
            $data['error_message'] = 0;
            $data['message'] = 'Cash Salary Not Processed Yet!';
            return response($data);
        }
        // $payroll_process_id = collect($payrollData)->pluck('id');

        $payrolInfo = PayrollList::valid()
          ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->where('procsid', $payrollData->id)
          ->orderBy('designations.priority')
          ->get();
        
        // return response($payrolInfo);
          $employee_all_id =collect($payrolInfo)->pluck('empid')->toArray();
        //   $employee_all_id=collect($payrolInfo_unique)->pluck('empid')->toArray();
        //   return response($payrolInfo);
          $find_comapny_info = CompanySbu::valid()->where('id', $payrollData->companysbu_id)->first();
          $data['company_info'] = isset($find_comapny_info->sbu_name) ? $find_comapny_info->sbu_name : 'Gemcon Group';
          $data['final_settlement'] = $payrollData->settlement;
          // return response($request);
          $attendanceInfo = DB::table('attendance')
                            ->select('attendance.employee_id', 'pstatus', 'pdate', DB::raw('count(DISTINCT pdate) AS totalDay'))
                            ->whereDate('pdate', '>=', $payrollData['startdate'])
                            ->whereDate('pdate', '<=', $payrollData['enddate'])
                            ->whereIn('employee_id', $employee_all_id)
                            ->groupBy('attendance.employee_id')
                            ->groupBy('attendance.pstatus')->get();
          $data['month_name'] = $payrollData['paymonth'];

          $employee_data=Employee::valid()->project()
              ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
              ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
              ->leftJoin('employee_bank_account_details', 'employee_bank_account_details.ebc_employee_id', '=', 'employees.id')
              ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
              ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
              ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
              ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
              ->select(
                  'employees.*',
                  'company_sbus.sbu_name',
                  'company_sbus.sbu_short_name',
                  'job_grades.jobgrade_name',
                  'employee_bank_account_details.ebc_account_number',
                  'employee_personal_infos.employee_gender',
                  'designations.designation_name',
                  'departments.department_name',
                  'work_locations.work_location_name'
              )->whereIn('employees.id', $employee_all_id)
              ->get();

            $total_gross_salary = 0;  
            $total_absent_amount = 0;  
            $total_gross_payable = 0;  
            $total_basic = 0;  
            $total_houserent = 0;  
            $total_medical = 0;  
            $total_transport = 0;  
            $total_arear = 0;  
            $total_additional_mobile = 0;  
            $total_car_allowance = 0;  
            $total_incentive = 0;  
            $total_allowance = 0;  
            $total_other_allownce = 0;  
            $total_deduction_pfbasic = 0;  
            $total_deduction_loan = 0;  
            $total_deduction_uniform = 0;  
            $total_deduction_deposit = 0;  
            $total_deduction_tax = 0;  
            $total_deduction_mobilebill = 0;  
            $total_late_deduction = 0;  
            $total_deduction_others = 0;  
            $total_netpay = 0;
            foreach ($payrolInfo as $key => $value) {
                $prtots = collect($attendanceInfo)->where('employee_id', $value['empid'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 1)->sum('totalDay');
                $lttots = collect($attendanceInfo)->where('employee_id', $value['empid'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 2)->sum('totalDay');
                $abtots = collect($attendanceInfo)->where('employee_id', $value['empid'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 3)->sum('totalDay');
                $whtotH = collect($attendanceInfo)->where('employee_id', $value['empid'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 4)->sum('totalDay');
                $whtotW = collect($attendanceInfo)->where('employee_id', $value['empid'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 5)->sum('totalDay');
                $levtot = collect($attendanceInfo)->where('employee_id', $value['empid'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 6)->sum('totalDay');
                $whtotHt = (int) $whtotH + (int) $whtotW ;
                $totals = (int) $prtots + (int) $lttots + (int) $abtots + (int) $whtotW + (int) $whtotH + (int) $levtot ;
                $totalPD = (int) $prtots + (int) $lttots + (int) $whtotW + (int) $whtotH + (int) $levtot ;

                $payrolInfo[$key]['prtot'] = $prtots;
                $payrolInfo[$key]['lttot'] = $lttots;
                $payrolInfo[$key]['abtot'] = $abtots;
                $payrolInfo[$key]['whtot'] = $whtotHt;
                $payrolInfo[$key]['levtot'] = $levtot;
                $payrolInfo[$key]['total'] = $totals;
                $payrolInfo[$key]['pay_day'] = $value['paydays'];

                $employeeInfo=collect($employee_data)->where('id', $value['empid'])->first();
                $payrolInfo[$key]['employee_id_no']=isset($employeeInfo) ? $employeeInfo['employee_id_no'] : '-';
                $payrolInfo[$key]['employee_fullname']=isset($employeeInfo) ? $employeeInfo['employee_fullname'] : '-';
                $payrolInfo[$key]['designation_name']=isset($employeeInfo) ? $employeeInfo['designation_name'] : '-';
                $payrolInfo[$key]['department_name']=isset($employeeInfo) ? $employeeInfo['department_name'] : '-';
                $payrolInfo[$key]['sbu_short_name']=isset($employeeInfo) ? $employeeInfo['sbu_short_name'] : '-';
                $payrolInfo[$key]['work_location_name']=isset($employeeInfo) ? $employeeInfo['work_location_name'] : '-';
                $payrolInfo[$key]['jobgrade_name']=isset($employeeInfo) ? $employeeInfo['jobgrade_name'] : '-';
                $payrolInfo[$key]['employee_joining_date']=isset($employeeInfo) ? $employeeInfo['employee_joining_date'] : '-';
                $payrolInfo[$key]['ebc_account_number']=isset($employeeInfo) ? $employeeInfo['ebc_account_number'] : '-';


                $payrolInfo[$key]['g_salary']=isset($value) ? $value['gross_salary'] : '0';
                $payrolInfo[$key]['g_payble'] = isset($value) ? $value['gross_payable'] : '0';
                //   $payrolInfo[$key]['page_ref_id']=$request['page_ref_id'];

                $total_gross_salary += $value['gross_salary'];  
                $total_absent_amount += $value['absent_deduction'];  
                $total_gross_payable += $value['gross_payable'];  
                $total_basic += $value['basic'];  
                $total_houserent += $value['houserent'];  
                $total_medical += $value['medical'];  
                $total_transport += $value['transport'];  
                $total_arear += $value['arear'];  
                $total_additional_mobile += $value['additional_mobile'];  
                $total_car_allowance += $value['car_allowance'];  
                $total_incentive += $value['incentive'];  
                $total_allowance += $value['allowance'];  
                $total_other_allownce += $value['other_allownce'];  
                $total_deduction_pfbasic += $value['deduction_pfbasic'];  
                $total_deduction_loan += $value['deduction_loan'];  
                $total_deduction_uniform += $value['deduction_uniform'];  
                $total_deduction_deposit += $value['deduction_deposit'];  
                $total_deduction_tax += $value['deduction_tax'];  
                $total_deduction_mobilebill += $value['deduction_mobilebill'];  
                $total_late_deduction += $value['late_deduction'];  
                $total_deduction_others += $value['deduction_others'];  
                $total_netpay += $value['netpay'];

          }
          $data['report_date']=date('d F Y', strtotime($payrollData['startdate'])).' to '. date('d F Y', strtotime($payrollData['enddate']));
          $data['employee_data_cash']=$payrolInfo;

            $data['total_gross_salary'] = $total_gross_salary;
            $data['total_absent_amount'] = $total_absent_amount;
            $data['total_gross_payable'] = $total_gross_payable;
            $data['total_basic'] = $total_basic;
            $data['total_houserent'] = $total_houserent;
            $data['total_medical'] = $total_medical;
            $data['total_transport'] = $total_transport;
            $data['total_arear'] = $total_arear;
            $data['total_additional_mobile'] = $total_additional_mobile;
            $data['total_car_allowance'] = $total_car_allowance;
            $data['total_incentive'] = $total_incentive;
            $data['total_allowance'] = $total_allowance;
            $data['total_other_allownce'] = $total_other_allownce;
            $data['total_deduction_pfbasic'] = $total_deduction_pfbasic;
            $data['total_deduction_loan'] = $total_deduction_loan;
            $data['total_deduction_uniform'] = $total_deduction_uniform;
            $data['total_deduction_deposit'] = $total_deduction_deposit;
            $data['total_deduction_tax'] = $total_deduction_tax;
            $data['total_deduction_mobilebill'] = $total_deduction_mobilebill;
            $data['total_late_deduction'] = $total_late_deduction;
            $data['total_deduction_others'] = $total_deduction_others;
            $data['total_netpay'] = $total_netpay;
            // return response()->json($data);
        

        return response($data);
    }

    public function bank_salary_report(Request $request) {
        // return response($request);
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '0');
        
        $unit_value = collect($request->unit_value)->where('id','!=',0)->pluck('id');
        $sub_unit_value = collect($request->sub_unit_value)->where('id','!=',0)->pluck('id');
        $department_name_value = collect($request->department_name_value)->where('id','!=',0)->pluck('id');
        $designation_name_value = collect($request->designation_name_value)->where('id','!=',0)->pluck('id');
        $section_value = collect($request->section_value)->where('id','!=',0)->pluck('id');
        $sub_section_value = collect($request->sub_section_value)->where('id','!=',0)->pluck('id');
        $work_location_value = collect($request->work_location_value)->where('id','!=',0)->pluck('id');
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->where('id','!=',0)->pluck('id');
        $OfficeTime =  collect($request->OfficeTime)->where('id','!=',0)->pluck('id');
        
       
        $repoerNamae = 'Payroll Report ' .date('d M, Y',strtotime($from_date)). " To ". date('d M, Y',strtotime($to_date));
       
        $process_type = 0;
        if(!empty($request->process_type)){
            $process_type = $request->process_type;
        }
        $data['process_type'] = $request->process_type;
        $data['report_search_button'] = 2;
        $data['report_name'] = $repoerNamae;
        $data['print_date'] =  date('d M, Y');
        $data['search_button'] = 20;
        
        $data['paymonth'] = $request->process_type;

        $data['pay_year'] = date('Y');
        if(!empty($request->from_date)){
            $data['pay_year'] = date('Y', strtotime($request->from_date));
        }
        if(!empty($request->to_date)){
            $data['pay_year'] = date('Y', strtotime($request->to_date));
        }
        if(!empty($request->payroll_year)){
            $data['pay_year'] = $request->payroll_year;
        }
        
        $data['report_type'] = $request->report_type; // cash/bank/details
        if($data['report_type'] == 10){
            $data['type'] = 1;
        }elseif($data['report_type'] == 20){
            $data['type'] = 2;
        }else{
            $data['type'] = 0;
        }

        $payrollData = PayrollProcessList::valid()
        ->where('companysbu_id', $company_sbu_id)
        ->where('paymonth', $data['paymonth'])
        ->where('pay_year', $data['pay_year'])
        ->where('type', 2)
        ->first();

        // dd($payrollData, $company_sbu_id, $data['paymonth'], $data['pay_year']);

        if(empty($payrollData)){
            $data['error_message'] = 0;
            $data['message'] = 'Bank Salary Not Processed Yet!';
            return response($data);
        }
        // return response($payrollData);

        // $payroll_process_id = collect($payrollData)->pluck('id');

        $payrolInfo = PayrollList::valid()
          ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->where('procsid', $payrollData->id)
          ->orderBy('designations.priority')
          ->get();
        
        // return response($payrolInfo);
          $employee_all_id =collect($payrolInfo)->pluck('empid')->toArray();
        //   $employee_all_id=collect($payrolInfo_unique)->pluck('empid')->toArray();
        //   return response($payrolInfo);
          $find_comapny_info = CompanySbu::valid()->where('id', $payrollData->companysbu_id)->first();
          $data['company_info'] = isset($find_comapny_info->sbu_name) ? $find_comapny_info->sbu_name : 'Gemcon Group';
          $data['final_settlement'] = $payrollData->settlement;
          // return response($request);
          $attendanceInfo = DB::table('attendance')
                            ->select('attendance.employee_id', 'pstatus', 'pdate', DB::raw('count(DISTINCT pdate) AS totalDay'))
                            ->whereDate('pdate', '>=', $payrollData['startdate'])
                            ->whereDate('pdate', '<=', $payrollData['enddate'])
                            ->whereIn('employee_id', $employee_all_id)
                            ->groupBy('attendance.employee_id')
                            ->groupBy('attendance.pstatus')->get();
          $data['month_name'] = $payrollData['paymonth'];

          $employee_data=Employee::valid()->project()
              ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
              ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
              ->leftJoin('employee_bank_account_details', 'employee_bank_account_details.ebc_employee_id', '=', 'employees.id')
              ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
              ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
              ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
              ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
              ->select(
                  'employees.*',
                  'company_sbus.sbu_name',
                  'company_sbus.sbu_short_name',
                  'job_grades.jobgrade_name',
                  'employee_bank_account_details.ebc_account_number',
                  'employee_personal_infos.employee_gender',
                  'designations.designation_name',
                  'departments.department_name',
                  'work_locations.work_location_name'
              )->whereIn('employees.id', $employee_all_id)
              ->get();

            $total_gross_salary = 0;  
            $total_absent_amount = 0;  
            $total_gross_payable = 0;  
            $total_basic = 0;  
            $total_houserent = 0;  
            $total_medical = 0;  
            $total_transport = 0;  
            $total_arear = 0;  
            $total_additional_mobile = 0;  
            $total_car_allowance = 0;  
            $total_incentive = 0;  
            $total_allowance = 0;  
            $total_other_allownce = 0;  
            $total_deduction_pfbasic = 0;  
            $total_deduction_loan = 0;  
            $total_deduction_uniform = 0;  
            $total_deduction_deposit = 0;  
            $total_deduction_tax = 0;  
            $total_deduction_mobilebill = 0;  
            $total_late_deduction = 0;  
            $total_deduction_others = 0;  
            $total_netpay = 0;
            foreach ($payrolInfo as $key => $value) {
                $prtots = collect($attendanceInfo)->where('employee_id', $value['empid'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 1)->sum('totalDay');
                $lttots = collect($attendanceInfo)->where('employee_id', $value['empid'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 2)->sum('totalDay');
                $abtots = collect($attendanceInfo)->where('employee_id', $value['empid'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 3)->sum('totalDay');
                $whtotH = collect($attendanceInfo)->where('employee_id', $value['empid'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 4)->sum('totalDay');
                $whtotW = collect($attendanceInfo)->where('employee_id', $value['empid'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 5)->sum('totalDay');
                $levtot = collect($attendanceInfo)->where('employee_id', $value['empid'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 6)->sum('totalDay');
                $whtotHt = (int) $whtotH + (int) $whtotW ;
                $totals = (int) $prtots + (int) $lttots + (int) $abtots + (int) $whtotW + (int) $whtotH + (int) $levtot ;
                $totalPD = (int) $prtots + (int) $lttots + (int) $whtotW + (int) $whtotH + (int) $levtot ;

                $payrolInfo[$key]['prtot'] = $prtots;
                $payrolInfo[$key]['lttot'] = $lttots;
                $payrolInfo[$key]['abtot'] = $abtots;
                $payrolInfo[$key]['whtot'] = $whtotHt;
                $payrolInfo[$key]['levtot'] = $levtot;
                $payrolInfo[$key]['total'] = $totals;
                $payrolInfo[$key]['pay_day'] = $value['paydays'];

                $employeeInfo=collect($employee_data)->where('id', $value['empid'])->first();
                $payrolInfo[$key]['employee_id_no']=isset($employeeInfo) ? $employeeInfo['employee_id_no'] : '-';
                $payrolInfo[$key]['employee_fullname']=isset($employeeInfo) ? $employeeInfo['employee_fullname'] : '-';
                $payrolInfo[$key]['designation_name']=isset($employeeInfo) ? $employeeInfo['designation_name'] : '-';
                $payrolInfo[$key]['department_name']=isset($employeeInfo) ? $employeeInfo['department_name'] : '-';
                $payrolInfo[$key]['sbu_short_name']=isset($employeeInfo) ? $employeeInfo['sbu_short_name'] : '-';
                $payrolInfo[$key]['work_location_name']=isset($employeeInfo) ? $employeeInfo['work_location_name'] : '-';
                $payrolInfo[$key]['jobgrade_name']=isset($employeeInfo) ? $employeeInfo['jobgrade_name'] : '-';
                $payrolInfo[$key]['employee_joining_date']=isset($employeeInfo) ? $employeeInfo['employee_joining_date'] : '-';
                $payrolInfo[$key]['ebc_account_number']=isset($employeeInfo) ? $employeeInfo['ebc_account_number'] : '-';


                $payrolInfo[$key]['g_salary']=isset($value) ? $value['gross_salary'] : '0';
                $payrolInfo[$key]['g_payble'] = isset($value) ? $value['gross_payable'] : '0';
                //   $payrolInfo[$key]['page_ref_id']=$request['page_ref_id'];

                $total_gross_salary += $value['gross_salary'];  
                $total_absent_amount += $value['absent_deduction'];  
                $total_gross_payable += $value['gross_payable'];  
                $total_basic += $value['basic'];  
                $total_houserent += $value['houserent'];  
                $total_medical += $value['medical'];  
                $total_transport += $value['transport'];  
                $total_arear += $value['arear'];  
                $total_additional_mobile += $value['additional_mobile'];  
                $total_car_allowance += $value['car_allowance'];  
                $total_incentive += $value['incentive'];  
                $total_allowance += $value['allowance'];  
                $total_other_allownce += $value['other_allownce'];  
                $total_deduction_pfbasic += $value['deduction_pfbasic'];  
                $total_deduction_loan += $value['deduction_loan'];  
                $total_deduction_uniform += $value['deduction_uniform'];  
                $total_deduction_deposit += $value['deduction_deposit'];  
                $total_deduction_tax += $value['deduction_tax'];  
                $total_deduction_mobilebill += $value['deduction_mobilebill'];  
                $total_late_deduction += $value['late_deduction'];  
                $total_deduction_others += $value['deduction_others'];  
                $total_netpay += $value['netpay'];

          }
          $data['report_date']=date('d F Y', strtotime($payrollData['startdate'])).' to '. date('d F Y', strtotime($payrollData['enddate']));
          $data['employee_data_bank']=$payrolInfo;

            $data['total_gross_salary'] = $total_gross_salary;
            $data['total_absent_amount'] = $total_absent_amount;
            $data['total_gross_payable'] = $total_gross_payable;
            $data['total_basic'] = $total_basic;
            $data['total_houserent'] = $total_houserent;
            $data['total_medical'] = $total_medical;
            $data['total_transport'] = $total_transport;
            $data['total_arear'] = $total_arear;
            $data['total_additional_mobile'] = $total_additional_mobile;
            $data['total_car_allowance'] = $total_car_allowance;
            $data['total_incentive'] = $total_incentive;
            $data['total_allowance'] = $total_allowance;
            $data['total_other_allownce'] = $total_other_allownce;
            $data['total_deduction_pfbasic'] = $total_deduction_pfbasic;
            $data['total_deduction_loan'] = $total_deduction_loan;
            $data['total_deduction_uniform'] = $total_deduction_uniform;
            $data['total_deduction_deposit'] = $total_deduction_deposit;
            $data['total_deduction_tax'] = $total_deduction_tax;
            $data['total_deduction_mobilebill'] = $total_deduction_mobilebill;
            $data['total_late_deduction'] = $total_late_deduction;
            $data['total_deduction_others'] = $total_deduction_others;
            $data['total_netpay'] = $total_netpay;
            // return response()->json($data);
        
        

        return response($data);
    }

    public function details_salary_report(Request $request) {
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '0');
        
        // $unit_value = collect($request->unit_value)->where('id','!=',0)->pluck('id');
        // $sub_unit_value = collect($request->sub_unit_value)->where('id','!=',0)->pluck('id');
        // $department_name_value = collect($request->department_name_value)->where('id','!=',0)->pluck('id');
        // $designation_name_value = collect($request->designation_name_value)->where('id','!=',0)->pluck('id');
        // $section_value = collect($request->section_value)->where('id','!=',0)->pluck('id');
        // $sub_section_value = collect($request->sub_section_value)->where('id','!=',0)->pluck('id');
        // $work_location_value = collect($request->work_location_value)->where('id','!=',0)->pluck('id');
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->where('id','!=',0)->pluck('id');
        // $OfficeTime =  collect($request->OfficeTime)->where('id','!=',0)->pluck('id');
        
       
        $repoerNamae = 'Payroll Report ' .date('d M, Y',strtotime($from_date)). " To ". date('d M, Y',strtotime($to_date));
       
        $process_type = 0;
        if(!empty($request->process_type)){
            $process_type = $request->process_type;
        }
        $data['report_search_button'] = 3;
        $data['report_name'] = $repoerNamae;
        $data['print_date'] =  date('d M, Y');
        $data['search_button'] = 30;
        $data['addition_colspan'] = 6;
        $data['deduction_colspan'] = 8;
        
        $data['paymonth'] = $request->process_type;
        $data['pay_year'] = date('Y');
        if(!empty($request->from_date)){
            $data['pay_year'] = date('Y', strtotime($request->from_date));
        }
        if(!empty($request->to_date)){
            $data['pay_year'] = date('Y', strtotime($request->to_date));
        }
        if(!empty($request->payroll_year)){
            $data['pay_year'] = $request->payroll_year;
        }
        $data['report_type'] = $request->report_type; // cash/bank/details
        if($data['report_type'] == 10){
            $data['type'] = 1;
        }elseif($data['report_type'] == 20){
            $data['type'] = 2;
        }else{
            $data['type'] = 0;
        }

        $payrollData = PayrollProcessList::valid()
        // ->where('id', $request['page_ref_id'])
        ->where('companysbu_id', $company_sbu_id)
        ->where('paymonth', $data['paymonth'])
        ->where('pay_year', $data['pay_year'])
        ->whereIn('type', [1,2])
        ->get();

        if(count($payrollData) == 0){
            $data['error_message'] = 0;
            $data['message'] = 'Details Salary Not Processed Yet!';
            return response($data);
        }

        $payroll_process_id = collect($payrollData)->pluck('id');

        $payrolInfo = $payrolInfo_previous = PayrollList::valid()
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->whereIn('procsid', $payroll_process_id)
            ->orderBy('designations.priority')
            ->get();
        
        // return response($payrolInfo);
          $payrolInfo_unique = collect($payrolInfo)->unique('empid')->toArray();

        //   dd($payrolInfo_unique);

        //   $unique_values_by_key = array_unique(array_column($payrolInfo, 'empid'));

        //   $payrolInfo_unique = collect($payrolInfo_unique);
          $employee_all_id = collect($payrolInfo_unique)->pluck('empid')->toArray();

        //   dd($employee_all_id);

        //   return response($unique_employees);
          $find_comapny_info = CompanySbu::valid()->where('id', $payrollData[0]->companysbu_id)->first();
          $data['company_info'] = isset($find_comapny_info->sbu_name) ? $find_comapny_info->sbu_name : 'Gemcon Group';
          $data['final_settlement'] = $payrollData[0]->settlement;
          // return response($request);
          $attendanceInfo = DB::table('attendance')
                            ->select(
                                'attendance.employee_id', 
                                'pstatus', 
                                'pdate', 
                                DB::raw('count(DISTINCT pdate) AS totalDay')
                                )
                            ->whereDate('pdate', '>=', $payrollData[0]['startdate'])
                            ->whereDate('pdate', '<=', $payrollData[0]['enddate'])
                            ->whereIn('employee_id', $employee_all_id)
                            ->groupBy('attendance.employee_id')
                            ->groupBy('attendance.pstatus')
                            ->get();
            
        // $attendanceInfo = collect($attendanceInfo)->unique('employee_id')->toArray();  
          $data['month_name'] = $payrollData[0]['paymonth'];

          $employee_data=Employee::valid()
              ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
              ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
              ->leftJoin('employee_bank_account_details', 'employee_bank_account_details.ebc_employee_id', '=', 'employees.id')
              ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
              ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
              ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
              ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
              ->select(
                  'employees.*',
                  'company_sbus.sbu_name',
                  'company_sbus.sbu_short_name',
                  'job_grades.jobgrade_name',
                  'employee_bank_account_details.ebc_account_number',
                  'employee_personal_infos.employee_gender',
                  'designations.designation_name',
                  'departments.department_name',
                  'work_locations.work_location_name'
              )
              ->orderBy('designations.priority')
              ->whereIn('employees.id', $employee_all_id)
              ->groupBy('employee_id_no')
              ->get();
            //   dd($employee_data->toArray());


            $total_gross_salary = 0;  
            $total_absent_amount = 0;  
            $total_actual_salary = 0;  
            $total_bank = 0;  
            $total_cash = 0;  
            $total_pf_cash = 0;  
            $total_total_cash = 0;  
            $total_gross_payable = 0;  
            $total_basic = 0;  
            $total_houserent = 0;  
            $total_medical = 0;  
            $total_transport = 0;  
            $total_dayoff_allowance = 0;  
            $total_arear = 0;  
            $total_additional_mobile = 0;  
            $total_car_allowance = 0;  
            $total_incentive = 0;  
            $total_allowance = 0;  
            $total_other_allownce = 0;  
            $total_deduction_pfbasic = 0;  
            $total_deduction_loan = 0;  
            $total_deduction_uniform = 0;  
            $total_deduction_deposit = 0;  
            $total_deduction_tax = 0;  
            $total_deduction_mobilebill = 0;  
            $total_late_deduction = 0;  
            $total_deduction_others = 0;  
            $total_netpay = 0;
            $total_bank_payable = 0;
            $total_cash_payable = 0;
            foreach ($employee_data as $key => $value) {
                $prtots = collect($attendanceInfo)->where('employee_id', $value['id'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 1)->sum('totalDay');
                $lttots = collect($attendanceInfo)->where('employee_id', $value['id'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 2)->sum('totalDay');
                $abtots = collect($attendanceInfo)->where('employee_id', $value['id'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 3)->sum('totalDay');
                $whtotH = collect($attendanceInfo)->where('employee_id', $value['id'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 4)->sum('totalDay');
                $whtotW = collect($attendanceInfo)->where('employee_id', $value['id'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 5)->sum('totalDay');

                $levtot = collect($attendanceInfo)->where('employee_id', $value['id'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 6)->sum('totalDay');

                $whtotHt = (int) $whtotH + (int) $whtotW ;
                $totals = (int) $prtots + (int) $lttots + (int) $abtots + (int) $whtotW + (int) $whtotH + (int) $levtot ;
                $totalPD = (int) $prtots + (int) $lttots + (int) $whtotW + (int) $whtotH + (int) $levtot ;
                $employeeInfo=collect($employee_data)->where('id', $value['id'])->first();

                $employee_data[$key]['prtot'] = $prtots;
                $employee_data[$key]['lttot'] = $lttots;
                $employee_data[$key]['abtot'] = $abtots;
                $employee_data[$key]['whtot'] = $whtotHt;
                $employee_data[$key]['levtot'] = $levtot;
                $employee_data[$key]['total'] = $totals;
                // $employee_data[$key]['pay_day'] = $value['paydays'];

                $employee_data[$key]['employee_id_no']=isset($employeeInfo) ? $employeeInfo['employee_id_no'] : '-';
                $employee_data[$key]['employee_fullname']=isset($employeeInfo) ? $employeeInfo['employee_fullname'] : '-';
                $employee_data[$key]['designation_name']=isset($employeeInfo) ? $employeeInfo['designation_name'] : '-';
                $employee_data[$key]['department_name']=isset($employeeInfo) ? $employeeInfo['department_name'] : '-';
                $employee_data[$key]['sbu_short_name']=isset($employeeInfo) ? $employeeInfo['sbu_short_name'] : '-';
                $employee_data[$key]['work_location_name']=isset($employeeInfo) ? $employeeInfo['work_location_name'] : '-';
                $employee_data[$key]['jobgrade_name']=isset($employeeInfo) ? $employeeInfo['jobgrade_name'] : '-';
                $employee_data[$key]['employee_joining_date']=isset($employeeInfo) ? $employeeInfo['employee_joining_date'] : '-';
                $employee_data[$key]['ebc_account_number']=isset($employeeInfo) ? $employeeInfo['ebc_account_number'] : '-';

                $employee_data[$key]['total_deduction_day'] = collect($payrolInfo_unique)->where('empid', $value['id'])->sum('total_deduction_day');
                // $employee_data[$key]['pay_day'] = collect($payrolInfo)->where('empid', $value['id'])->sum('paydays');
                $employee_data[$key]['pay_day'] = collect($payrolInfo_unique)->where('empid', $value['id'])->pluck('paydays')->get(0);
                $employee_data[$key]['total_day_off_worked'] = collect($payrolInfo_unique)->where('empid', $value['id'])->pluck('total_day_off_worked')->get(0);
                // if($value->id == 144){
                //     dd(collect($payrolInfo_unique)->where('empid', 144));
                // }

                // if($employee_data[$key]['pay_day'] == 0){
                //     $employee_data[$key]['pay_day'] = collect($payrolInfo)->where('empid', $value['id'])->pluck('paydays')->get(1);
                // }

                $g_salary = collect($payrolInfo)->where('empid', $value['id'])->sum('gross_salary');
                
                $employee_data[$key]['g_salary'] = isset($g_salary) ? $g_salary : '0';
                

                $employee_data[$key]['bank_salary'] = collect($payrolInfo)->where('empid', $value['id'])->where('type', 2)->sum('gross_salary');
                $employee_data[$key]['cash_salary'] = collect($payrolInfo)->where('empid', $value['id'])->where('type', 1)->sum('gross_salary');
                $employee_data[$key]['bank_pf'] = collect($payrolInfo)->where('empid', $value['id'])->where('type', 2)->sum('deduction_pfbasic');
                $employee_data[$key]['cash_pf'] = collect($payrolInfo)->where('empid', $value['id'])->where('type', 1)->sum('deduction_pfbasic');
                // $employee_data[$key]['cash_payable'] = $employee_data[$key]['cash_salary'] + $employee_data[$key]['cash_pf'];

                
                // if salary both cash && bank 10 July 2024 start

                $is_cash_salary = collect($payrolInfo)->where('empid', $value->id)->where('type', 1)->where('gross_salary', '!=', '0')->first();

                $is_bank_salary = collect($payrolInfo)->where('empid', $value->id)->where('type', 2)->where('gross_salary', '!=', '0')->first();

                // if($value->id == 2337){
                //     dd($is_cash_salary, $is_bank_salary);
                // }

                if(!empty($is_cash_salary) && !empty($is_bank_salary)){
                    $payrolInfo_bank = collect($payrolInfo)->where('type', 2);
                    $payrolInfo = $payrolInfo_bank;
                    $employee_data[$key]['cash_payable'] = $employee_data[$key]['cash_salary'] + $employee_data[$key]['cash_pf'];
                }
                // if salary both cash && bank 10 July 2024 end


                $g_payble = collect($payrolInfo)->where('empid', $value['id'])->sum('gross_payable');
                $employee_data[$key]['absent_deduction'] = collect($payrolInfo)->where('empid', $value['id'])->sum('absent_deduction');

                $employee_data[$key]['g_payble'] = isset($g_payble) ? $g_payble: '0';


                $employee_data[$key]['basic'] = collect($payrolInfo)->where('empid', $value['id'])->sum('basic');
                $employee_data[$key]['houserent'] = collect($payrolInfo)->where('empid', $value['id'])->sum('houserent');
                $employee_data[$key]['medical'] = collect($payrolInfo)->where('empid', $value['id'])->sum('medical');
                $employee_data[$key]['transport'] = collect($payrolInfo)->where('empid', $value['id'])->sum('transport');
                $employee_data[$key]['day_off_allowance'] = collect($payrolInfo)->where('empid', $value['id'])->sum('day_off_allowance');
                $employee_data[$key]['arear'] = collect($payrolInfo)->where('empid', $value['id'])->sum('arear');
                $employee_data[$key]['additional_mobile'] = collect($payrolInfo)->where('empid', $value['id'])->sum('additional_mobile');
                $employee_data[$key]['car_allowance'] = collect($payrolInfo)->where('empid', $value['id'])->sum('car_allowance');
                $employee_data[$key]['incentive'] = collect($payrolInfo)->where('empid', $value['id'])->sum('incentive');
                $employee_data[$key]['allowance'] = collect($payrolInfo)->where('empid', $value['id'])->sum('allowance');
                $employee_data[$key]['other_allownce'] = collect($payrolInfo)->where('empid', $value['id'])->sum('other_allownce');

                $employee_data[$key]['deduction_pfbasic'] = collect($payrolInfo)->where('empid', $value['id'])->sum('deduction_pfbasic');
                
                $employee_data[$key]['deduction_loan'] = collect($payrolInfo)->where('empid', $value['id'])->sum('deduction_loan');
                $employee_data[$key]['deduction_uniform'] = collect($payrolInfo)->where('empid', $value['id'])->sum('deduction_uniform');
                $employee_data[$key]['deduction_deposit'] = collect($payrolInfo)->where('empid', $value['id'])->sum('deduction_deposit');
                $employee_data[$key]['deduction_tax'] = collect($payrolInfo)->where('empid', $value['id'])->sum('deduction_tax');
                $employee_data[$key]['deduction_mobilebill'] = collect($payrolInfo)->where('empid', $value['id'])->sum('deduction_mobilebill');
                $employee_data[$key]['late_deduction'] = collect($payrolInfo)->where('empid', $value['id'])->sum('late_deduction');
                $employee_data[$key]['deduction_others'] = collect($payrolInfo)->where('empid', $value['id'])->sum('deduction_others');

                $employee_data[$key]['netpay'] = collect($payrolInfo)->where('empid', $value['id'])->sum('netpay');

                if(!empty($is_cash_salary) && !empty($is_bank_salary)){
                    $employee_data[$key]['net_payable'] = collect($payrolInfo)->where('empid', $value['id'])->sum('netpay') +  $employee_data[$key]['cash_payable'];
                }else{
                    $employee_data[$key]['net_payable'] = collect($payrolInfo)->where('empid', $value['id'])->sum('netpay');
                }

                if(!empty($is_cash_salary) && !empty($is_bank_salary)){
                    $employee_data[$key]['bank_payable'] = collect($payrolInfo)->where('empid', $value['id'])->sum('netpay');
                    $employee_data[$key]['cash_payable_f'] = $employee_data[$key]['cash_payable'];
                }
                else{
                    $employee_data[$key]['bank_payable'] = collect($payrolInfo)->where('empid', $value['id'])->where('type', 2)->sum('netpay');
                    $employee_data[$key]['cash_payable_f'] = collect($payrolInfo)->where('empid', $value['id'])->where('type', 1)->sum('netpay');
                }
                
                $employee_data[$key]['actual_salary'] = $employee_data[$key]['g_salary'] - $employee_data[$key]['absent_deduction'] + $employee_data[$key]['arear'];
                
                // $employee_data[$key]['cash_payable_f'] = collect($payrolInfo)->where('empid', $value['id'])->where('type', 1)->sum('netpay');
              
                

               

                $total_gross_salary += $employee_data[$key]['g_salary'];  
                $total_absent_amount += $employee_data[$key]['absent_deduction'];  
                $total_bank += $employee_data[$key]['bank_salary'];  
                $total_cash += $employee_data[$key]['cash_salary'];  
                $total_pf_cash += $employee_data[$key]['cash_pf'];  
                $total_total_cash += $employee_data[$key]['cash_payable'];  
                $total_gross_payable += $employee_data[$key]['g_payble'];  
                $total_basic += $employee_data[$key]['basic'];  
                $total_houserent += $employee_data[$key]['houserent'];  
                $total_medical += $employee_data[$key]['medical'];  
                $total_transport += $employee_data[$key]['transport'];
                $total_dayoff_allowance += $employee_data[$key]['total_dayoff_allowance'];  
                $total_arear += $employee_data[$key]['arear'];  
                $total_additional_mobile += $employee_data[$key]['additional_mobile'];  
                $total_car_allowance += $employee_data[$key]['car_allowance'];  
                $total_incentive += $employee_data[$key]['incentive'];  
                $total_allowance += $employee_data[$key]['allowance'];  
                $total_other_allownce += $employee_data[$key]['other_allownce'];  

                $total_deduction_pfbasic += $employee_data[$key]['deduction_pfbasic'];  
                $total_deduction_loan += $employee_data[$key]['deduction_loan'];  
                $total_deduction_uniform += $employee_data[$key]['deduction_uniform'];  
                $total_deduction_deposit += $employee_data[$key]['deduction_deposit'];  
                $total_deduction_tax += $employee_data[$key]['deduction_tax'];  
                $total_deduction_mobilebill += $employee_data[$key]['deduction_mobilebill'];  
                $total_late_deduction += $employee_data[$key]['late_deduction'];  
                $total_deduction_others += $employee_data[$key]['deduction_others'];  
                $total_netpay += $employee_data[$key]['net_payable'];
                $total_bank_payable += $employee_data[$key]['bank_payable'];
                $total_cash_payable += $employee_data[$key]['cash_payable_f'];
                $total_actual_salary += $employee_data[$key]['actual_salary'];


                $payrolInfo = $payrolInfo_previous;

          }
          $data['report_date']=date('d F Y', strtotime($payrollData[0]['startdate'])).' to '. date('d F Y', strtotime($payrollData[0]['enddate']));
          $data['employee_data_ds']=$employee_data;

            $data['total_gross_salary'] = $total_gross_salary;
            $data['total_absent_amount'] = $total_absent_amount;
            $data['total_bank'] = $total_bank;
            $data['total_cash'] = $total_cash;
            $data['total_pf_cash'] = $total_pf_cash;
            $data['total_total_cash'] = $total_total_cash;
            $data['total_gross_payable'] = $total_gross_payable;
            $data['total_basic'] = $total_basic;
            $data['total_houserent'] = $total_houserent;
            $data['total_medical'] = $total_medical;
            $data['total_transport'] = $total_transport;
            $data['total_dayoff_allowance'] = $total_dayoff_allowance;
            $data['total_arear'] = $total_arear;
            $data['total_additional_mobile'] = $total_additional_mobile;
            $data['total_car_allowance'] = $total_car_allowance;
            $data['total_incentive'] = $total_incentive;
            $data['total_allowance'] = $total_allowance;
            $data['total_other_allownce'] = $total_other_allownce;
            $data['total_deduction_pfbasic'] = $total_deduction_pfbasic;
            $data['total_deduction_loan'] = $total_deduction_loan;
            $data['total_deduction_uniform'] = $total_deduction_uniform;
            $data['total_deduction_deposit'] = $total_deduction_deposit;
            $data['total_deduction_tax'] = $total_deduction_tax;
            $data['total_deduction_mobilebill'] = $total_deduction_mobilebill;
            $data['total_late_deduction'] = $total_late_deduction;
            $data['total_deduction_others'] = $total_deduction_others;
            $data['total_netpay'] = $total_netpay;
            $data['total_bank_payable'] = $total_bank_payable;
            $data['total_cash_payable'] = $total_cash_payable;
            $data['total_actual_salary'] = $total_actual_salary;
            // return response()->json($data);
        
        

        return response($data);
    }

    public function salary_list_report(Request $request) {
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '0');
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->where('id','!=',0)->pluck('id');
        $repoerNamae = 'Payroll Report ' .date('d M, Y',strtotime($from_date)). " To ". date('d M, Y',strtotime($to_date));
        $process_type = 0;
        if(!empty($request->process_type)){
            $process_type = $request->process_type;
        }
        $data['process_type'] = $request->process_type;
        $data['report_search_button'] = 1;
        $data['salary_list'] = 1;
        $data['report_name'] = 'Employee Salary List';
        $data['print_date'] =  date('d M, Y');
        $data['search_button'] = 1133;
        $data['paymonth'] = $request->process_type;
        $data['pay_year'] = date('Y');
        if(!empty($request->from_date)){
            $data['pay_year'] = date('Y', strtotime($request->from_date));
        }
        if(!empty($request->to_date)){
            $data['pay_year'] = date('Y', strtotime($request->to_date));
        }
        if(!empty($request->payroll_year)){
            $data['pay_year'] = $request->payroll_year;
        }
        $data['report_type'] = $request->report_type; // salary list type
        if($data['report_type'] == 1133){
            $data['type'] = 1;
        }elseif($data['report_type'] == 1133){
            $data['type'] = 2;
        }else{
            $data['type'] = 0;
        }

         $payrollData = PayrollProcessList::valid()
            ->where('companysbu_id', $company_sbu_id)
            ->where('settlement', 2)
            ->whereIn('type', [1,2])
            ->orderBy('id', 'desc')
            ->take(2)
            ->get();


        $payroll_process_id = collect($payrollData)->pluck('id');

        // dd( $payroll_process_id);

        $payrolInfo = Salary::valid()
          ->selectRaw('salaries.*,sum(gross_salary) as gross_salary')
          ->leftJoin('employees', 'employees.id', '=', 'salaries.employee_id')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->where('salary_sbu_id', $company_sbu_id)
          ->where('employees.valid', '=', 1)
        //   ->where('employees.employee_status', '=', 1)
          ->where('gross_salary', '>', 0)
          ->groupBy('salaries.employee_id')
          ->orderBy('designations.priority')
          ->get();

          $employee_all_id =collect($payrolInfo)->pluck('employee_id')->toArray();

          $find_comapny_info = CompanySbu::valid()->where('id', $payrollData[0]->companysbu_id)->first();
          $data['company_info'] = isset($find_comapny_info->sbu_name) ? $find_comapny_info->sbu_name : 'Gemcon Group';
          $data['final_settlement'] = $payrollData[0]->settlement;
          $data['month_name'] = $payrollData[0]['paymonth'];

          $employee_data=Employee::valid()->project()   
              ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
              ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
              ->leftJoin('employee_bank_account_details', 'employee_bank_account_details.ebc_employee_id', '=', 'employees.id')
              ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
              ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
              ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
              ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
              ->select(
                  'employees.*',
                  'company_sbus.sbu_name',
                  'company_sbus.sbu_short_name',
                  'job_grades.jobgrade_name',
                  'employee_bank_account_details.ebc_account_number',
                  'employee_personal_infos.employee_gender',
                  'designations.designation_name',
                  'departments.department_name',
                  'work_locations.work_location_name'
              )->whereIn('employees.id', $employee_all_id)
              ->get();
            
           

            $payrolInfo_previous = PayrollList::valid()
            ->selectRaw('payroll.*, sum(gross_salary)')
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            // ->where('payroll_process.settlement', 2)
            // ->whereIn('payroll_process.type', [1,2])
            ->whereIn('payroll.empid', $employee_all_id)
            ->whereIn('procsid', $payroll_process_id)
            ->groupBy('payroll.empid')
            ->groupBy('payroll.procsid')
            // ->orderBy('payroll.procsid', 'desc')
            ->get();
        
       
            foreach ($payrolInfo as $key => $value) {
                // $salary_data = collect($payrolInfo_previous)->where('empid', $value['employee_id'])->pluck('gross_salary');

                $salary_data=collect($payrolInfo_previous)->where('empid', $value['employee_id'])->sum('gross_salary');

                // dd('$salary_data1',$salary_data);
                $payrolInfo[$key]['pay_day'] = $value['paydays'];

                $employeeInfo=collect($employee_data)->where('id', $value['employee_id'])->where('employee_id_no', '!=', '')->first();

                $payrolInfo[$key]['previous_gross_salary']= isset($salary_data) ? $salary_data : '';
                // dd($payrolInfo[$key]['previous_gross_salary']);
                $payrolInfo[$key]['employee_id_no']=isset($employeeInfo) ? $employeeInfo['employee_id_no'] : '-';
                $payrolInfo[$key]['employee_fullname']=isset($employeeInfo) ? $employeeInfo['employee_fullname'] : '-';
                $payrolInfo[$key]['designation_name']=isset($employeeInfo) ? $employeeInfo['designation_name'] : '-';
                $payrolInfo[$key]['department_name']=isset($employeeInfo) ? $employeeInfo['department_name'] : '-';
                $payrolInfo[$key]['sbu_short_name']=isset($employeeInfo) ? $employeeInfo['sbu_short_name'] : '-';
                $payrolInfo[$key]['work_location_name']=isset($employeeInfo) ? $employeeInfo['work_location_name'] : '-';
                $payrolInfo[$key]['jobgrade_name']=isset($employeeInfo) ? $employeeInfo['jobgrade_name'] : '-';
                $payrolInfo[$key]['employee_joining_date']=isset($employeeInfo) ? $employeeInfo['employee_joining_date'] : '-';
                $payrolInfo[$key]['employee_status']=isset($employeeInfo) ? $employeeInfo['employee_status'] : '-';

                $payrolInfo[$key]['g_salary']=isset($value) ? $value['gross_salary'] : '0';
                $payrolInfo[$key]['g_payble'] = isset($value) ? $value['gross_payable'] : '0';
          }
          $data['report_date']=date('d F Y', strtotime($payrollData[0]['startdate'])).' to '. date('d F Y', strtotime($payrollData[0]['enddate']));
          $data['employee_data_salary_list']=$payrolInfo;
        return response($data);
    }

    public function pay_slip_report(Request $request){
        // return response($request);
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '0');
        
        $unit_value = collect($request->unit_value)->where('id','!=',0)->pluck('id');
        $sub_unit_value = collect($request->sub_unit_value)->where('id','!=',0)->pluck('id');
        $department_name_value = collect($request->department_name_value)->where('id','!=',0)->pluck('id');
        $designation_name_value = collect($request->designation_name_value)->where('id','!=',0)->pluck('id');
        $section_value = collect($request->section_value)->where('id','!=',0)->pluck('id');
        $sub_section_value = collect($request->sub_section_value)->where('id','!=',0)->pluck('id');
        $work_location_value = collect($request->work_location_value)->where('id','!=',0)->pluck('id');
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->where('id','!=',0)->pluck('id');
        $OfficeTime =  collect($request->OfficeTime)->where('id','!=',0)->pluck('id');
        
       
        $repoerNamae = 'Payroll Report ' .date('d M, Y',strtotime($from_date)). " To ". date('d M, Y',strtotime($to_date));
       
        $process_type = 0;
        if(!empty($request->process_type)){
            $process_type = $request->process_type;
        }
        $data['report_search_button'] = 3;
        $data['report_name'] = $repoerNamae;
        $data['print_date'] =  date('d M, Y');
        $data['search_button'] = 11;
        
        $data['paymonth'] = $request->process_type;
        $data['pay_year'] = date('Y');
        if(!empty($request->from_date)){
            $data['pay_year'] = date('Y', strtotime($request->from_date));
        }
        if(!empty($request->to_date)){
            $data['pay_year'] = date('Y', strtotime($request->to_date));
        }
        if(!empty($request->payroll_year)){
            $data['pay_year'] = $request->payroll_year;
        }
        $data['report_type'] = $request->report_type; // cash/bank/details
     

        // $payrollData = PayrollProcessList::valid()
        // ->where('companysbu_id', $company_sbu_id)
        // ->where('paymonth', $data['paymonth'])
        // ->where('pay_year', $data['pay_year'])
        // ->first();

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
            ->where('payroll_process.companysbu_id', $company_sbu_id)
            ->where('paymonth', $data['paymonth'])
            ->where('pay_year', $data['pay_year'])
            ->where('empid', $request['employee_id'])
            ->first();

            // return response($payslipDetails);

            if($payslipDetails['type'] == 1) {
                $data['salary_type_cash']=1;
                $data['paySlipCash']=$payslipDetails;
                $paySlipDetails=PayrollList::valid()
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
                    $data['paySlipDetails']=$paySlipDetails;
                    $data['salary_type_bank']=2;
                } else {
                    $data['paySlipDetails']=[];
                    $data['salary_type_bank']=1;
                }
            }else{
                $data['salary_type_bank']=2;
                $data['paySlipDetails']=$payslipDetails;
                $paySlipCash=PayrollList::valid()
                        ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
                        ->selectRaw(
                            'payroll.*,
                payroll_process.paymonth,
                payroll_process.enddate,
                payroll_process.type,
                payroll_process.process_date,
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
                    $data['paySlipCash']=$paySlipCash;
                    $data['salary_type_cash']=1;
                } else {
                    $data['paySlipCash']=[];
                    $data['salary_type_cash']=2;
                }
            }
            
        $allPf = ProvidentFund::valid()->where('employee_id', $payslipDetails['empid'])
                    ->where('company_sbu_id', $payslipDetails['companysbu_id'])
                    ->whereDate('pf_date', '<=', $payslipDetails['enddate'])
                    ->get();
        $data['openigPf']=collect($allPf)->where('pf_date', '<', $payslipDetails['enddate'])
                        ->sum('pf_employee_amount');
        $data['Pf']=collect($allPf)->where('pf_date', '=', $payslipDetails['enddate'])
                        ->sum('pf_employee_amount');
        $data['clPf']=collect($allPf)->sum('pf_employee_amount');

        $pay_slip_details= Employee::valid()->project()
        // ->leftJoin('employees',  'employees.id', '=', 'payroll.empid')
        ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
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
        $data['pay_slip_details']=$pay_slip_details;
        $data['sbu_name']=$pay_slip_details['sbu_name'];
        $data['sbu_logo']=$pay_slip_details['sbu_logo'];
        $data['print_date']=date('l d F Y');
        $data['salary_date']=date('F Y', strtotime($payslipDetails['startdate']));
        return response($data);  
    }


    public function ot_report(Request $request) {

        // dd($request);
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', '0');
        
        $unit_value = collect($request->unit_value)->where('id','!=',0)->pluck('id');
        $sub_unit_value = collect($request->sub_unit_value)->where('id','!=',0)->pluck('id');
        $department_name_value = collect($request->department_name_value)->where('id','!=',0)->pluck('id');
        $designation_name_value = collect($request->designation_name_value)->where('id','!=',0)->pluck('id');
        $section_value = collect($request->section_value)->where('id','!=',0)->pluck('id');
        $sub_section_value = collect($request->sub_section_value)->where('id','!=',0)->pluck('id');
        $work_location_value = collect($request->work_location_value)->where('id','!=',0)->pluck('id');
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $company_sbu_id = collect($request->sbu_name_value)->where('id','!=',0)->pluck('id');
        $OfficeTime =  collect($request->OfficeTime)->where('id','!=',0)->pluck('id');
        $repoerNamae = 'Payroll Report ' .date('d M, Y',strtotime($from_date)). " To ". date('d M, Y',strtotime($to_date));
        $process_type = 0;
        if(!empty($request->process_type)){
            $process_type = $request->process_type;
        }
        $data['report_search_button'] = 3;
        $data['report_name'] = $repoerNamae;
        $data['print_date'] =  date('d M, Y');
        $data['search_button'] = 30;
        $data['addition_colspan'] = 6;
        $data['deduction_colspan'] = 8;
        $data['paymonth'] = $request->process_type;
        $data['pay_year'] = date('Y');
        if(!empty($request->from_date)){
            $data['pay_year'] = date('Y', strtotime($request->from_date));
        }
        if(!empty($request->to_date)){
            $data['pay_year'] = date('Y', strtotime($request->to_date));
        }
        if(!empty($request->payroll_year)){
            $data['pay_year'] = $request->payroll_year;
        }
        $data['report_type'] = $request->report_type; // cash/bank/details
        if($data['report_type'] == 10){
            $data['type'] = 1;
        }elseif($data['report_type'] == 20){
            $data['type'] = 2;
        }else{
            $data['type'] = 0;
        }
        $payrollData = PayrollProcessList::valid()
        ->where('companysbu_id', $company_sbu_id)
        ->where('paymonth', $data['paymonth'])
        ->where('pay_year', $data['pay_year'])
        ->whereIn('type', [1,2])
        ->get();
        if(count($payrollData) == 0){
            $data['error_message'] = 0;
            $data['message'] = 'Details Salary Not Processed Yet!';
            return response($data);
        }
        $payroll_process_id = collect($payrollData)->pluck('id');
        $payrolInfo = $payrolInfo_previous = PayrollList::valid()
            ->leftJoin('payroll_process', 'payroll_process.id', '=', 'payroll.procsid')
            ->leftJoin('employees', 'employees.id', '=', 'payroll.empid')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->whereIn('procsid', $payroll_process_id)
            ->orderBy('designations.priority')
            ->get();
        // return response($payrolInfo);
          $payrolInfo_unique = collect($payrolInfo)->unique('empid')->toArray();
        //   $payrolInfo_unique = collect($payrolInfo_unique);
          $employee_all_id = collect($payrolInfo_unique)->pluck('empid')->toArray();
        //   return response($unique_employees);
          $find_comapny_info = CompanySbu::valid()->where('id', $payrollData[0]->companysbu_id)->first();
          $data['company_info'] = isset($find_comapny_info->sbu_name) ? $find_comapny_info->sbu_name : 'Gemcon Group';
          $data['final_settlement'] = $payrollData[0]->settlement;
          $attendanceInfo = DB::table('attendance')
            ->select(
                'attendance.employee_id', 
                'pstatus', 
                'pdate', 
                DB::raw('count(DISTINCT pdate) AS totalDay')
                )
            ->whereDate('pdate', '>=', $payrollData[0]['startdate'])
            ->whereDate('pdate', '<=', $payrollData[0]['enddate'])
            ->whereIn('employee_id', $employee_all_id)
            ->groupBy('attendance.employee_id')
            ->groupBy('attendance.pstatus')
            ->get();
          $data['month_name'] = $payrollData[0]['paymonth'];
          $employee_data=Employee::valid()
              ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
              ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
              ->leftJoin('employee_bank_account_details', 'employee_bank_account_details.ebc_employee_id', '=', 'employees.id')
              ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
              ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
              ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
              ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
              ->select(
                  'employees.*',
                  'company_sbus.sbu_name',
                  'company_sbus.sbu_short_name',
                  'job_grades.jobgrade_name',
                  'employee_bank_account_details.ebc_account_number',
                  'employee_personal_infos.employee_gender',
                  'designations.designation_name',
                  'departments.department_name',
                  'work_locations.work_location_name'
              )
              ->orderBy('designations.priority')
              ->whereIn('employees.id', $employee_all_id)
              ->groupBy('employee_id_no')
              ->get();
            $total_gross_salary = 0;  
            $total_absent_amount = 0;  
            $total_bank = 0;  
            $total_cash = 0;  
            $total_pf_cash = 0;  
            $total_total_cash = 0;  
            $total_gross_payable = 0;  
            $total_basic = 0;  
            $total_houserent = 0;  
            $total_medical = 0;  
            $total_transport = 0;  
            $total_arear = 0;  
            $total_additional_mobile = 0;  
            $total_car_allowance = 0;  
            $total_incentive = 0;  
            $total_allowance = 0;  
            $total_other_allownce = 0;  
            $total_deduction_pfbasic = 0;  
            $total_deduction_loan = 0;  
            $total_deduction_uniform = 0;  
            $total_deduction_deposit = 0;  
            $total_deduction_tax = 0;  
            $total_deduction_mobilebill = 0;  
            $total_late_deduction = 0;  
            $total_deduction_others = 0;  
            $total_netpay = 0;
            $total_bank_payable = 0;
            $total_cash_payable = 0;
            foreach ($employee_data as $key => $value) {
                $prtots = collect($attendanceInfo)->where('employee_id', $value['id'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 1)->sum('totalDay');
                $lttots = collect($attendanceInfo)->where('employee_id', $value['id'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 2)->sum('totalDay');
                $abtots = collect($attendanceInfo)->where('employee_id', $value['id'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 3)->sum('totalDay');
                $whtotH = collect($attendanceInfo)->where('employee_id', $value['id'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 4)->sum('totalDay');
                $whtotW = collect($attendanceInfo)->where('employee_id', $value['id'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 5)->sum('totalDay');
                $levtot = collect($attendanceInfo)->where('employee_id', $value['id'])->where('pdate', '>=', $value['employee_joining_date'])->where('pstatus', 6)->sum('totalDay');
                $whtotHt = (int) $whtotH + (int) $whtotW ;
                $totals = (int) $prtots + (int) $lttots + (int) $abtots + (int) $whtotW + (int) $whtotH + (int) $levtot ;
                $totalPD = (int) $prtots + (int) $lttots + (int) $whtotW + (int) $whtotH + (int) $levtot ;
                $employeeInfo=collect($employee_data)->where('id', $value['id'])->first();
                $employee_data[$key]['prtot'] = $prtots;
                $employee_data[$key]['lttot'] = $lttots;
                $employee_data[$key]['abtot'] = $abtots;
                $employee_data[$key]['whtot'] = $whtotHt;
                $employee_data[$key]['levtot'] = $levtot;
                $employee_data[$key]['total'] = $totals;
                $employee_data[$key]['employee_id_no']=isset($employeeInfo) ? $employeeInfo['employee_id_no'] : '-';
                $employee_data[$key]['employee_fullname']=isset($employeeInfo) ? $employeeInfo['employee_fullname'] : '-';
                $employee_data[$key]['designation_name']=isset($employeeInfo) ? $employeeInfo['designation_name'] : '-';
                $employee_data[$key]['department_name']=isset($employeeInfo) ? $employeeInfo['department_name'] : '-';
                $employee_data[$key]['sbu_short_name']=isset($employeeInfo) ? $employeeInfo['sbu_short_name'] : '-';
                $employee_data[$key]['work_location_name']=isset($employeeInfo) ? $employeeInfo['work_location_name'] : '-';
                $employee_data[$key]['jobgrade_name']=isset($employeeInfo) ? $employeeInfo['jobgrade_name'] : '-';
                $employee_data[$key]['employee_joining_date']=isset($employeeInfo) ? $employeeInfo['employee_joining_date'] : '-';
                $employee_data[$key]['ebc_account_number']=isset($employeeInfo) ? $employeeInfo['ebc_account_number'] : '-';
                $employee_data[$key]['total_deduction_day'] = collect($payrolInfo_unique)->where('empid', $value['id'])->sum('total_deduction_day');
                $employee_data[$key]['pay_day'] = collect($payrolInfo_unique)->where('empid', $value['id'])->pluck('paydays')->get(0);
                $employee_data[$key]['total_day_off_worked'] = collect($payrolInfo_unique)->where('empid', $value['id'])->pluck('total_day_off_worked')->get(0);
                $g_salary = collect($payrolInfo)->where('empid', $value['id'])->sum('gross_salary');
                $employee_data[$key]['g_salary'] = isset($g_salary) ? $g_salary : '0';
                $employee_data[$key]['bank_salary'] = collect($payrolInfo)->where('empid', $value['id'])->where('type', 2)->sum('gross_salary');
                $employee_data[$key]['cash_salary'] = collect($payrolInfo)->where('empid', $value['id'])->where('type', 1)->sum('gross_salary');
                $employee_data[$key]['bank_pf'] = collect($payrolInfo)->where('empid', $value['id'])->where('type', 2)->sum('deduction_pfbasic');
                $employee_data[$key]['cash_pf'] = collect($payrolInfo)->where('empid', $value['id'])->where('type', 1)->sum('deduction_pfbasic');
                $is_cash_salary = collect($payrolInfo)->where('empid', $value->id)->where('type', 1)->where('gross_salary', '!=', '0')->first();
                $is_bank_salary = collect($payrolInfo)->where('empid', $value->id)->where('type', 2)->where('gross_salary', '!=', '0')->first();
                if(!empty($is_cash_salary) && !empty($is_bank_salary)){
                    $payrolInfo_bank = collect($payrolInfo)->where('type', 2);
                    $payrolInfo = $payrolInfo_bank;
                    $employee_data[$key]['cash_payable'] = $employee_data[$key]['cash_salary'] + $employee_data[$key]['cash_pf'];
                }
                $g_payble = collect($payrolInfo)->where('empid', $value['id'])->sum('gross_payable');
                $employee_data[$key]['absent_deduction'] = collect($payrolInfo)->where('empid', $value['id'])->sum('absent_deduction');
                $employee_data[$key]['g_payble'] = isset($g_payble) ? $g_payble: '0';
                $employee_data[$key]['basic'] = collect($payrolInfo)->where('empid', $value['id'])->sum('basic');
                $employee_data[$key]['houserent'] = collect($payrolInfo)->where('empid', $value['id'])->sum('houserent');
                $employee_data[$key]['medical'] = collect($payrolInfo)->where('empid', $value['id'])->sum('medical');
                $employee_data[$key]['transport'] = collect($payrolInfo)->where('empid', $value['id'])->sum('transport');
                $employee_data[$key]['day_off_allowance'] = collect($payrolInfo)->where('empid', $value['id'])->sum('day_off_allowance');
                $employee_data[$key]['arear'] = collect($payrolInfo)->where('empid', $value['id'])->sum('arear');
                $employee_data[$key]['additional_mobile'] = collect($payrolInfo)->where('empid', $value['id'])->sum('additional_mobile');
                $employee_data[$key]['car_allowance'] = collect($payrolInfo)->where('empid', $value['id'])->sum('car_allowance');
                $employee_data[$key]['incentive'] = collect($payrolInfo)->where('empid', $value['id'])->sum('incentive');
                $employee_data[$key]['allowance'] = collect($payrolInfo)->where('empid', $value['id'])->sum('allowance');
                $employee_data[$key]['other_allownce'] = collect($payrolInfo)->where('empid', $value['id'])->sum('other_allownce');
                $employee_data[$key]['deduction_pfbasic'] = collect($payrolInfo)->where('empid', $value['id'])->sum('deduction_pfbasic');
                $employee_data[$key]['deduction_loan'] = collect($payrolInfo)->where('empid', $value['id'])->sum('deduction_loan');
                $employee_data[$key]['deduction_uniform'] = collect($payrolInfo)->where('empid', $value['id'])->sum('deduction_uniform');
                $employee_data[$key]['deduction_deposit'] = collect($payrolInfo)->where('empid', $value['id'])->sum('deduction_deposit');
                $employee_data[$key]['deduction_tax'] = collect($payrolInfo)->where('empid', $value['id'])->sum('deduction_tax');
                $employee_data[$key]['deduction_mobilebill'] = collect($payrolInfo)->where('empid', $value['id'])->sum('deduction_mobilebill');
                $employee_data[$key]['late_deduction'] = collect($payrolInfo)->where('empid', $value['id'])->sum('late_deduction');
                $employee_data[$key]['deduction_others'] = collect($payrolInfo)->where('empid', $value['id'])->sum('deduction_others');
                $employee_data[$key]['netpay'] = collect($payrolInfo)->where('empid', $value['id'])->sum('netpay');
                if(!empty($is_cash_salary) && !empty($is_bank_salary)){
                    $employee_data[$key]['net_payable'] = collect($payrolInfo)->where('empid', $value['id'])->sum('netpay') +  $employee_data[$key]['cash_payable'];
                }else{
                    $employee_data[$key]['net_payable'] = collect($payrolInfo)->where('empid', $value['id'])->sum('netpay');
                }
                if(!empty($is_cash_salary) && !empty($is_bank_salary)){
                    $employee_data[$key]['bank_payable'] = collect($payrolInfo)->where('empid', $value['id'])->sum('netpay');
                    $employee_data[$key]['cash_payable_f'] = $employee_data[$key]['cash_payable'];
                }
                else{
                    $employee_data[$key]['bank_payable'] = collect($payrolInfo)->where('empid', $value['id'])->where('type', 2)->sum('netpay');
                    $employee_data[$key]['cash_payable_f'] = collect($payrolInfo)->where('empid', $value['id'])->where('type', 1)->sum('netpay');
                }
                $total_gross_salary += $employee_data[$key]['g_salary'];  
                $total_absent_amount += $employee_data[$key]['absent_deduction'];  
                $total_bank += $employee_data[$key]['bank_salary'];  
                $total_cash += $employee_data[$key]['cash_salary'];  
                $total_pf_cash += $employee_data[$key]['cash_pf'];  
                $total_total_cash += $employee_data[$key]['cash_payable'];  
                $total_gross_payable += $employee_data[$key]['g_payble'];  
                $total_basic += $employee_data[$key]['basic'];  
                $total_houserent += $employee_data[$key]['houserent'];  
                $total_medical += $employee_data[$key]['medical'];  
                $total_transport += $employee_data[$key]['transport'];  
                $total_arear += $employee_data[$key]['arear'];  
                $total_additional_mobile += $employee_data[$key]['additional_mobile'];  
                $total_car_allowance += $employee_data[$key]['car_allowance'];  
                $total_incentive += $employee_data[$key]['incentive'];  
                $total_allowance += $employee_data[$key]['allowance'];  
                $total_other_allownce += $employee_data[$key]['other_allownce'];  
                $total_deduction_pfbasic += $employee_data[$key]['deduction_pfbasic'];  
                $total_deduction_loan += $employee_data[$key]['deduction_loan'];  
                $total_deduction_uniform += $employee_data[$key]['deduction_uniform'];  
                $total_deduction_deposit += $employee_data[$key]['deduction_deposit'];  
                $total_deduction_tax += $employee_data[$key]['deduction_tax'];  
                $total_deduction_mobilebill += $employee_data[$key]['deduction_mobilebill'];  
                $total_late_deduction += $employee_data[$key]['late_deduction'];  
                $total_deduction_others += $employee_data[$key]['deduction_others'];  
                $total_netpay += $employee_data[$key]['net_payable'];
                $total_bank_payable += $employee_data[$key]['bank_payable'];
                $total_cash_payable += $employee_data[$key]['cash_payable_f'];
                $payrolInfo = $payrolInfo_previous;
          }
        $data['report_date']=date('d F Y', strtotime($payrollData[0]['startdate'])).' to '. date('d F Y', strtotime($payrollData[0]['enddate']));
        $data['employee_data_ds']=$employee_data;
        $data['total_gross_salary'] = $total_gross_salary;
        $data['total_absent_amount'] = $total_absent_amount;
        $data['total_bank'] = $total_bank;
        $data['total_cash'] = $total_cash;
        $data['total_pf_cash'] = $total_pf_cash;
        $data['total_total_cash'] = $total_total_cash;
        $data['total_gross_payable'] = $total_gross_payable;
        $data['total_basic'] = $total_basic;
        $data['total_houserent'] = $total_houserent;
        $data['total_medical'] = $total_medical;
        $data['total_transport'] = $total_transport;
        $data['total_arear'] = $total_arear;
        $data['total_additional_mobile'] = $total_additional_mobile;
        $data['total_car_allowance'] = $total_car_allowance;
        $data['total_incentive'] = $total_incentive;
        $data['total_allowance'] = $total_allowance;
        $data['total_other_allownce'] = $total_other_allownce;
        $data['total_deduction_pfbasic'] = $total_deduction_pfbasic;
        $data['total_deduction_loan'] = $total_deduction_loan;
        $data['total_deduction_uniform'] = $total_deduction_uniform;
        $data['total_deduction_deposit'] = $total_deduction_deposit;
        $data['total_deduction_tax'] = $total_deduction_tax;
        $data['total_deduction_mobilebill'] = $total_deduction_mobilebill;
        $data['total_late_deduction'] = $total_late_deduction;
        $data['total_deduction_others'] = $total_deduction_others;
        $data['total_netpay'] = $total_netpay;
        $data['total_bank_payable'] = $total_bank_payable;
        $data['total_cash_payable'] = $total_cash_payable;
        return response($data);
    }

}
