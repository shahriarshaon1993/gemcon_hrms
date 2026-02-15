<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Attendance;
use Auth;
use Session;
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
use App\Model\AttendanceSetup;
use App\Model\DistrictModel;
use App\Model\EmployeeApproval;
use App\Model\ManualOT;
use App\Model\OfficeTimeSetup;
use App\Model\RosterMaping;
use Cache;
use Carbon\Carbon;
use permission;
use DB;
use DateTime;
use DateInterval;
use DatePeriod;

// use App\Model\UserRoleAccess;

class OtAdjustmentController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $cache = Cache::get('permission');
        $permission = collect($cache)->where('menu_uid', '=', 'OtAdjustment')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
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
        $project_id = Auth::guard('user')->user()->project_id;
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        $employee_id = $employee_ids['employee_id'];

        $report_data = $employee_list->report_filter_data();

        // $employee_data_approval = Employee::valid()->project()
        // ->select('employees.*', 'designations.designation_name', 'attendance.pdate', 'attendance.ot_time', 'attendance.id as att_id', 'attendance.ot_entry')
        // ->join('designations', 'designations.id', '=', 'employees.employee_designation')
        // ->join('attendance', 'attendance.employee_id', '=', 'employees.id')
        // ->whereNotNull('ot_entry')
        // ->orderBy('attendance.id', 'DESC')
        // ->get();
        // $data['employee_data_approvaldat'] = $employee_data_approval;

        $data['AllcompanySbuData'] = $report_data['Allcompany_sbu_data'];
        $data['company_sbu_data'] = $report_data['company_sbu_data'];
        $data['AllsectionData'] = $report_data['Allsection_data'];
        $data['section_data'] = $report_data['section_data'];
        $data['AllsubSectionData'] = $report_data['Allsub_section_data'];
        $data['sub_section_data'] = $report_data['sub_section_data'];
        $data['AllsubUnitData'] = $report_data['Allsub_unit_data'];
        $data['sub_unit_data'] = $report_data['sub_unit_data'];
        $data['AllunitData'] = $report_data['Allunit_data'];
        $data['unit_data'] = $report_data['unit_data'];
        $data['AllworkLocationData'] = $report_data['Allwork_location_data'];
        $data['work_location_data'] = $report_data['work_location_data'];
        $data['AlldepartmentData'] = $report_data['Alldepartment_data'];
        $data['department_data'] = $report_data['department_data'];

        $data['AllemployeeData'] = $data['employee_data'] = $report_data['employee_data'];

        $officeTime = OfficeTimeSetup::valid()->project()->whereIn('type', ['2', '3'])->where('office_time_status', 1)->orderBy('priority', 'ASC')->get();
        $data['officeTime'] = array();
        foreach ($officeTime as $value) {
            array_push($data['officeTime'], ['id' => $value['id'], 'text' => $value['title'] . " [ " . date('h:i A', strtotime($value['office_start_time'])) . " - " . date('h:i A', strtotime($value['office_end_time'])) . " ] "]);
        }


        $data['months_array'] = [];
        array_push($data['months_array'], ['id' => date('m'), 'text' => date('F')]);
        array_push($data['months_array'], ['id' => date('m', strtotime('+1 months')), 'text' => date('F', strtotime('+1 months'))]);
        array_push($data['months_array'], ['id' => date('m', strtotime('+2 months')), 'text' => date('F', strtotime('+2 months'))]);


        return response()->json($data);
    }
    public function ot_report()
    {
        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        $employee_id = $employee_ids['employee_id'];

        $data['AllcompanySbuData'] = $employee_list->report_filter_data()['Allcompany_sbu_data'];
        $data['company_sbu_data'] = $employee_list->report_filter_data()['company_sbu_data'];
        $data['AllsectionData'] = $employee_list->report_filter_data()['Allsection_data'];
        $data['section_data'] = $employee_list->report_filter_data()['section_data'];
        $data['AllsubSectionData'] = $employee_list->report_filter_data()['Allsub_section_data'];
        $data['sub_section_data'] = $employee_list->report_filter_data()['sub_section_data'];
        $data['AllsubUnitData'] = $employee_list->report_filter_data()['Allsub_unit_data'];
        $data['sub_unit_data'] = $employee_list->report_filter_data()['sub_unit_data'];
        $data['AllunitData'] = $employee_list->report_filter_data()['Allunit_data'];
        $data['unit_data'] = $employee_list->report_filter_data()['unit_data'];
        $data['AllworkLocationData'] = $employee_list->report_filter_data()['Allwork_location_data'];
        $data['work_location_data'] = $employee_list->report_filter_data()['work_location_data'];
        $data['AlldepartmentData'] = $employee_list->report_filter_data()['Alldepartment_data'];
        $data['department_data'] = $employee_list->report_filter_data()['department_data'];

        $officeTime = OfficeTimeSetup::valid()->project()->whereIn('type', ['2', '3'])->where('office_time_status', 1)->orderBy('priority', 'ASC')->get();
        $data['officeTime'] = array();
        foreach ($officeTime as $value) {
            array_push($data['officeTime'], ['id' => $value['id'], 'text' => $value['title'] . " [ " . date('h:i A', strtotime($value['office_start_time'])) . " - " . date('h:i A', strtotime($value['office_end_time'])) . " ] "]);
        }

        $data['designation_data'] = array();
        $data['jobgrade_data'] = array();
        $data['employee_data'] = array();
        $data['employee_data_approval'] = array();
        $data['employee_group_data'] = array();



        $designation_data = Designation::valid()->project()->whereIn('id', $employee_ids['designation'])->orderBy('priority', 'ASC')->get();
        $jobgrade_data = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get();
        $employee_data_approval = Employee::valid()->project()->whereIn('employee_sbu', $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->get();
        $employee_data = Employee::valid()->project()->get()->keyBy('employee_id_no')->all();

        $employee_group_data = EmployeeGroup::valid()->project()->orderBy('priority', 'ASC')->get();


        array_push($data['employee_group_data'], ['id' => '', 'text' => 'All Select']);
        foreach ($employee_group_data as $value) {
            array_push($data['employee_group_data'], ['id' => $value['id'], 'text' => $value['employee_group_name']]);
        }

        array_push($data['designation_data'], ['id' => '', 'text' => 'All Select']);
        foreach ($designation_data as $value) {
            array_push($data['designation_data'], ['id' => $value['id'], 'text' => $value['designation_name']]);
        }
        array_push($data['jobgrade_data'], ['id' => '', 'text' => 'All Select']);
        foreach ($jobgrade_data as $value) {
            array_push($data['jobgrade_data'], ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
        }
        array_push($data['employee_data'], ['id' => '', 'text' => 'All Select']);
        foreach ($employee_data as $value) {
            array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . ':' . $value['employee_fullname'] . '-' . $value['designation_name']]);
        }
        array_push($data['employee_data_approval'], ['id' => '', 'text' => 'All Select']);
        foreach ($employee_data_approval as $value) {
            array_push($data['employee_data_approval'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . ':' . $value['employee_fullname'] . '-' . $value['designation_name']]);
        }

        $data['AttStatus'] = [];
        array_push($data['AttStatus'], ['id' => '', 'text' => 'All']);
        array_push($data['AttStatus'], ['id' => '1', 'text' => 'Present']);
        array_push($data['AttStatus'], ['id' => '2', 'text' => 'Late']);
        array_push($data['AttStatus'], ['id' => '6', 'text' => 'Leave']);
        array_push($data['AttStatus'], ['id' => '3', 'text' => 'Absent']);

        $data['emplyeeCategory'] = [];
        array_push($data['emplyeeCategory'], ['id' => '', 'text' => 'All']);
        array_push($data['emplyeeCategory'], ['id' => '1', 'text' => 'Management']);
        array_push($data['emplyeeCategory'], ['id' => '2', 'text' => 'Non-Management']);

        $data['employeeType'] = [];
        array_push($data['employeeType'], ['id' => '', 'text' => 'All']);
        array_push($data['employeeType'], ['id' => '1', 'text' => 'Permanent']);
        array_push($data['employeeType'], ['id' => '2', 'text' => 'Probationary']);
        array_push($data['employeeType'], ['id' => '3', 'text' => 'Cotractual']);
        array_push($data['employeeType'], ['id' => '6', 'text' => 'Casual']);
        array_push($data['employeeType'], ['id' => '4', 'text' => 'Temporary']);
        array_push($data['employeeType'], ['id' => '5', 'text' => 'Intern']);




        $data['attendanceColumn'] = array();
        array_push($data['attendanceColumn'], ['id' => 'section_name', 'text' => 'Section']);
        array_push($data['attendanceColumn'], ['id' => 'sub_section_name', 'text' => 'Sub Section']);
        array_push($data['attendanceColumn'], ['id' => 'age', 'text' => 'Age']);
        array_push($data['attendanceColumn'], ['id' => 'adob', 'text' => 'DOB Actual']);
        array_push($data['attendanceColumn'], ['id' => 'cdob', 'text' => 'DOB Certificate']);
        // array_push($data['attendanceColumn'],['id'=>'salary','text'=>'Salary']);
        array_push($data['attendanceColumn'], ['id' => 'permanent_district', 'text' => 'District']);
        array_push($data['attendanceColumn'], ['id' => 'employee_marital_status', 'text' => 'Marital Status']);
        array_push($data['attendanceColumn'], ['id' => 'employee_blood_group', 'text' => 'Blood Group']);
        array_push($data['attendanceColumn'], ['id' => 'employee_children_no', 'text' => 'Kids']);
        array_push($data['attendanceColumn'], ['id' => 'employee_work_location', 'text' => 'Work Location']);
        array_push($data['attendanceColumn'], ['id' => 'employee_job_grade', 'text' => 'Grade']);
        array_push($data['attendanceColumn'], ['id' => 'service_length', 'text' => 'Service Length']);
        array_push($data['attendanceColumn'], ['id' => 'emplyee_category_mgt_non_mgt', 'text' => 'Employee Category']);
        array_push($data['attendanceColumn'], ['id' => 'employee_type', 'text' => 'Employee Type']);
        array_push($data['attendanceColumn'], ['id' => 'employee_group', 'text' => 'Employee Group']);
        array_push($data['attendanceColumn'], ['id' => 'employee_gender', 'text' => 'Gender']);
        // array_push($data['attendanceColumn'],['id'=>'employee_group','text'=>'Employee Group']);

        // array_push($data['attendanceColumn'],['id'=>'employee_work_location','text'=>'Work Location']);
        // array_push($data['attendanceColumn'],['id'=>'employee_children_no','text'=>'Kids']);

        $data['district_data'] = array();
        $district_data = DistrictModel::orderBy('name', 'ASC')->get();
        array_push($data['district_data'], ['id' => '', 'text' => 'All Select']);
        foreach ($district_data as $value) {
            array_push($data['district_data'], ['id' => $value['id'], 'text' => $value['name'] . ' - ' . $value['bn_name']]);
        }

        $data['approval_infos'] = EmployeeApproval::valid()->project()->get();
        // $data['approval_infos']=EmployeeApproval::valid()->project()->where('ea_employee_id',$id)->get();
        $data['from_date'] = date('Y-m-d');
        $data['to_date'] = date('Y-m-d');
        return response($data);
    }
    public function empploy_report(Request $request)
    {
        $from_date = isset(request()->from_date) ? request()->from_date : '';
        $to_date = isset(request()->to_date) ? request()->to_date : '';
        $strDate1 = substr($from_date, 4, 11);
        $strDate2 = substr($to_date, 4, 11);
        $search_option['from_date_formated'] = $from_date_formated = date('Y-m-d', strtotime($from_date));
        $search_option['to_date_formated'] = $to_date_formated = date('Y-m-d', strtotime($to_date));
        $search_option['employee_id'] = $employee_id = collect($request->designation_name_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_ids'] = $employee_ids = request()->employee_id;
        // request()->employee_id;
        // dd( $from_date_formated);
        $date_print['from_date_formated'] = $from_date_formated;
        $search_option['checkedattcolsadd'] = $checkedattcolsadd = $request->checkedattcolsadd;
        $search_option['report_type'] = $report_type = $request->report_type;
        $search_option['att_report_type'] = $att_report_type = $request->att_report_type;
        $search_option['employee_sbu'] = $employee_sbu = collect($request['sbu_name_value'])->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_sbus'] = $employee_sbus = $request->employee_sbu;
        // $request->employee_sbu;
        $search_option['employee_department'] = $employee_department = collect($request->department_name_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_departments'] = $employee_departments = $request->employee_department;
        // $request->employee_department;
        $search_option['employee_designation'] = $employee_designation = collect($request->designation_name_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_designations'] = $employee_designations = $request->employee_designation;
        // $request->employee_designation;
        $search_option['employee_section'] = $employee_section = collect($request->section_value)->where('id', '!=', '')->pluck('id')->toArray();
        // $request->employee_section;
        $search_option['employee_sub_section'] = $employee_sub_section = collect($request->sub_section_value)->where('id', '!=', '')->pluck('id')->toArray();
        // $request->employee_sub_section;
        $search_option['employee_work_location'] = $employee_work_location = collect($request->work_location_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_job_grade'] = $employee_job_grade = collect($request->jobgradeData_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['OfficeTime'] = $OfficeTime = collect($request->OfficeTime)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['sub_unit'] = $sub_unit = collect($request->sub_unit_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['unit'] = $unit = collect($request->unit_value)->where('id', '!=', '')->pluck('id')->toArray();
        // $request->jobgradeData_value;

        $search_option['service_length_from'] = $service_length_from = $request->service_length_from;
        $search_option['service_length_to'] = $service_length_to = $request->service_length_to;

        $search_option['age_from'] = $age_from = $request->age_from;
        $search_option['age_to'] = $age_to = $request->age_to;
        $search_option['salary_from'] = $salary_from = $request->salary_from;
        $search_option['salary_to'] = $salary_to = $request->salary_to;
        $search_option['permanent_district'] = $permanent_district = collect($request->district_value)->where('id', '!=', '')->pluck('id')->toArray();
        // $request->permanent_district;
        $search_option['employee_marital_status'] = $employee_marital_status = $request->employee_marital_status;
        $search_option['employee_gender'] = $employee_gender = $request->employee_gender;
        $search_option['employee_blood_group'] = $employee_blood_group = $request->employee_blood_group;
        $search_option['att_status'] = $att_status = collect($request['AttStatus_value'])->where('id', '!=', '')->pluck('id')->toArray();

        $search_option['emplyee_category_mgt_non_mgt'] = $emplyee_category_mgt_non_mgt = collect($request->employee_Category_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_type'] = $employee_type = collect($request->employee_type_value)->where('id', '!=', '')->pluck('id')->toArray();
        $search_option['employee_group'] = $employee_group = collect($request->employee_group_value)->where('id', '!=', '')->pluck('id')->toArray();

        $search_option['employee_status'] = $employee_status = $request->employee_status;
        return $this->find_daily_ot($report_type, $att_report_type, $employee_sbu, $from_date_formated, $to_date_formated, $checkedattcolsadd, $search_option);
    }
    public function find_daily_ot($report_type, $att_report_type, $employee_sbu, $from_date_formated, $to_date_formated, $checkedattcolsadd, $search_option)
    {
        $column_data = [];
        if (count($column_data) > 1) {
            $column_name_data = $this->column_real_name($columnArray);
        } else {
            $column_data = $columNameArray = array("employee_id_no", "employee_full_name", "designation_name", "department_name", "employee_work_location", "sbu_name",  "shift_time", "in_time", "out_time", "late", "status", "remarks");
            $column_name_data = $this->column_real_name($columNameArray);
        }
        // echo "<pre>";
        // print_r($search_option);
        // exit();
        // return $search_option;
        $employee_list = new Employee();
        $employee_id_call = $employee_list->Employee_id();
        $employee_id = $employee_id_call['employee_id'];


        $employeeSbu = [];
        if (count($employee_sbu) > 0) {
            $employeeSbu = $employee_sbu;
        } else {
            $employeeSbu = $employee_id_call['sub'];
        }

        $employeeDepartment = [];
        if (!empty($search_option['employee_department'])) {
            $employeeDepartment = $search_option['employee_department'];
        } else {
            $employeeDepartment = $employee_id_call['department'];
        }

        $date_print['from_date_formated'] = $from_date_formated;
        $emplyId = Employee::whereIn('employee_sbu', $employeeSbu)->where('employees.employee_status', 1)
          ->whereIn('employee_department', $employeeDepartment);
        if (!empty($search_option['employee_ids'])) {
            $emplyId->where('id', $search_option['employee_ids']);
        }
        if (!empty($search_option['employee_designation'])) {
            $emplyId->whereIn('employee_designation', $search_option['employee_designation']);
        }
        if (!empty($search_option['employee_work_location'])) {
            $emplyId->whereIn('employee_work_location', $search_option['employee_work_location']);
        }
        if (!empty($search_option['unit'])) {
            $emplyId->whereIn('employee_unit', $search_option['unit']);
        }
        if (!empty($search_option['sub_unit'])) {
            $emplyId->whereIn('employee_sub_unit', $search_option['sub_unit']);
        }

        $emplyIds = $emplyId->pluck('id')->toarray();

        $resignationsEmpId = DB::table('resignations')->where('resignation_status', 2)
          ->where('effective_date', '>=', $to_date_formated)->pluck('employee_id')->toarray();

        $allemplyid = array_merge($emplyIds, $resignationsEmpId);
        if (!empty($search_option['OfficeTime'])) {
            $attendanceTime = AttendanceSetup::select('attendance_setups.*', 'office_time_setups.office_start_time as office_start_time', 'office_time_setups.office_end_time as office_end_time', 'office_time_setups.lateConsiderTime as lateConsiderTime', 'office_time_setups.office_type as office_type', 'office_time_setups.type as type', 'office_time_end_date', 'office_time_start_date')
              ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
              ->whereIn('attendance_setups.employee_id', $allemplyid)

              ->where('start_date', '<=', $from_date_formated)
              ->where('end_date', '>=', $to_date_formated);
            if (!empty($search_option['OfficeTime'])) {
                $attendanceTime->whereIn('attendance_setups.attendance_office_time', $search_option['OfficeTime']);
            }
            $attendanceTime = $attendanceTime->get();

            $AllemplyIds = collect($attendanceTime)->pluck('employee_id')->toarray();
        } else {
            $AllemplyIds = $allemplyid;
        }

        // echo "<pre>";
        // print_r($AllemplyIds);
        // exit();

        $employee_info = Employee::select('employees.id', 'employees.employee_id_no', 'employees.employee_fullname as employee_full_name', 'employees.employee_sbu', 'employees.employee_section', 'employees.employee_department', 'employees.employee_designation', 'employees.employee_sub_unit', 'employees.employee_sub_unit', 'employees.employee_work_location')
          ->valid()
          ->whereIn('employee_sbu', $employeeSbu)
          ->WhereIn('id', $AllemplyIds)
          ->whereIn('employee_department', $employeeDepartment);
        if (!empty($search_option['employee_designation'])) {
            $employee_info->whereIn('employee_designation', $search_option['employee_designation']);
        }
        if (!empty($search_option['employee_work_location'])) {
            $employee_info->whereIn('employee_work_location', $search_option['employee_work_location']);
        }
        if (!empty($search_option['unit'])) {
            $emplyId->whereIn('employee_unit', $search_option['unit']);
        }
        if (!empty($search_option['sub_unit'])) {
            $emplyId->whereIn('employee_sub_unit', $search_option['sub_unit']);
        }

        $employee_info = $employee_info->orderBy('employees.employee_sbu')->orderBy('employees.employee_section')->orderBy('employees.employee_department')->get();


        $employee_ids = collect($employee_info)->pluck('employee_id_no')->toArray();
    //      echo "<pre>";
        // print_r($employee_ids);
        // exit();
        // return $employee_sbu;
        $employee_primary_ids = collect($employee_info)->pluck('id')->toArray();

        $employee_ids = collect($employee_info)->pluck('employee_id_no')->toArray();
        $employee_primary_ids = collect($employee_info)->pluck('id')->toArray();
        if (!empty($employeeSbu)) {
            $company_sbus = CompanySbu::valid()->whereIn('id', $employeeSbu)->get()->toArray();
            $sbuName = collect($company_sbus)->first();

            $sbuNames = $sbuName['sbu_name'];
        } else {
            $company_sbus = CompanySbu::valid()->whereIn('id', $employee_id_call['sub'])->get()->toArray();
            $sbuNames = 'All';
        }
        // $employee_section = Section::valid()->whereIn('id', $employee_id_call['section'])->get()->toArray();
        // $employee_department = Department::valid()->whereIn('id', $employeeDepartment)->get()->toArray();
        // $employee_designation = Designation::valid()->whereIn('id', $employee_id_call['designation'])->get()->toArray();
        // $employee_sub_unit = SubUnit::valid()->whereIn('id', $employee_id_call['subunit'])->get()->toArray();
        // $WorkLocation = WorkLocation::valid()->get()->toArray();

        // $search_option['OfficeTime']
        // dd($from_date_formated);
        $attendance_data = DB::table('attendance')
          ->select(
              'attendance.*',
              'employees.*',
              'office_time_setups.title',
              'employees.employee_fullname',
              'designations.designation_name',
              'departments.department_name',
              'work_locations.work_location_name',
              'company_sbus.sbu_name'
          )
          ->leftJoin('employees', 'employees.id', '=', 'attendance.employee_id')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
          // ->leftJoin('attendance_setups', 'attendance_setups.employee_id', '=', 'employees.id')
          ->leftJoin('attendance_setups', function ($join) use ($from_date_formated, $to_date_formated) {
              $join->on('attendance_setups.employee_id', '=', 'employees.id')
                ->where('attendance_setups.start_date', '<=', DB::raw('pdate'))
                ->where('attendance_setups.end_date', '>=', DB::raw('pdate'));
              // ('start_date', '=', DB::raw($from_date_formated));
              // $join->on('end_date', '<=', DB::raw($from_date_formated));
          })
          ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
          ->whereIn('attendance.employee_id', $employee_primary_ids)
          // ->where('pdate', '=', $from_date_formated)
          // ->where('pdate', '>=', $to_date_formated)
          ->whereBetween('pdate', [$from_date_formated, $to_date_formated])

          // ->where('pdate', $from_date_formated)
          ->where('attendance.valid', '=', 1)
          ->where('attendance.ot_entry', '!=', '')
          ->groupBy('attendance.pdate')
          ->groupBy('attendance.employee_id')
          ->orderBy('attendance.pdate','ASC')
          ->orderBy('attendance.employee_id','ASC')
          ->get()->toArray();
        // dd($to_date_formated);
        $data['status'] = 1;
        $data['attendance_data'] = $attendance_data;
        return $data;

        // return view('layouts.report',compact('all_data','column_data','column_name_data','date_report','company_id','company_sbus','created_by','report_name'));
    }
    public function ot_list(Request $request)
    {
        $cache = Cache::get('permission');
        $permission = collect($cache)->where('menu_uid', '=', 'ot_adjustment_list')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
        foreach ($permission as $child) {
            if ($child['link_uid'] == 'add') {
                $data['add'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'edit') {
                $data['edit'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'delete') {
                $data['delete'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'status') {
                $data['status'] = $child['link_uid'];
            } else {
                $data['view'] = $child['link_uid'];
            }
        }
        $employee_data = Attendance::whereNotNull('ot_entry');
      

        if ($request->from_date != '' && $request->to_date != '') {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $to_date = date('Y-m-d', strtotime($request->to_date));
            $employee_data->whereBetween('pdate', [$from_date, $to_date]);
        } else {
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d');
            $employee_data->whereBetween('pdate', [$from_date, $to_date]);
        }
        // $employee_data->whereNotNull('ot_entry');
        $employee_data->groupBy('pdate');
        $employee_data->with('getalldata');
        $employee_data->with(['getalldata' => function ($q) {
            $q->whereNotNull('ot_entry');
        }]);
        if ($request->from_date == '' && $request->to_date == '') {
            $employee_data->limit(10);
        } else {
            $employee_data->limit(10);
        }
        $data['daily_ot_data'] = $employee_data->get();
        // dd($data);
        // Attendance::where('valid', '=', 1)->update(['valid' => 0]);
        return response($data);
    }
    public function change_status_all(Request $request)
    {
        $data = array();
        try {
            DB::beginTransaction();
            if ($request->all_date != '') {
                $all_date = date('Y-m-d', strtotime($request->all_date));
                $update_data = Attendance::valid()->where('pdate', $all_date)->get();

                foreach ($update_data as $value) {
                    $value->status = 0;
                    $value->save();
                }
                $message = ['status' => 1, 'message' => 'Your data is successfully updated'];

                DB::commit();
            } else {
                $message = ['status' => 0, 'message' => 'Please select date'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['status' => 0, 'message' => 'Your data is not updated'];
        }
        return response($message);
    }
    public function change_status(Request $request)
    {
        $data = array();
        $update_data = Attendance::valid()->findOrFail($request->id);
        $update_data->status = $request->status;
        if ($update_data->save()) {
            $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
        }
        return response($message);
    }
    public function shift_time(Request $request)
    {
        // return response()->json($request['department_id']);
        if (!empty($request['employeeId'])) {
            $employee_id[] = $request['employeeId'];
        } else {
            $employee_list = new Employee();
            $employee_ids = $employee_list->Employee_id();
            $employee_id = $employee_ids['employee_id'];
        }



        $employee_data_approval = [];
        $section_id = $request['section_id'];
        $subsection_id = $request['subsection_id'];
        $employee_groupsubunit_id = $request['employee_groupsubunit_id'];
        $subunit_id = $request['subunit_id'];
        $unit_id = $request['unit_id'];
        $employee_work_location = $request['employee_work_location'];
        $department_id = $request['department_id'];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));

        $employee_data_approval_biulder = Employee::valid()->project()
          ->select('employees.*', 'designations.designation_name', DB::raw('DATE_FORMAT(attendance.pdate, "%d-%b-%Y") as pdate'), 'attendance.ot_time', 'attendance.id as att_id', 'attendance.ot_entry')
          ->leftjoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftjoin('attendance', 'attendance.employee_id', '=', 'employees.id');
        if ($request->shift) {
            // dd($request->shift);
            $employee_data_approval_biulder->leftjoin('attendance_setups', function ($join) use ($request) {
                $join->on('attendance_setups.employee_id', '=', 'employees.id');
                $join->where('attendance_setups.attendance_office_time', $request->shift['id']);
            });
            // $employee_data_approval_biulder->join('attendance_setups', 'attendance_setups.employee_id', '=', 'employees.id')

            //   ->where('attendance_setups.attendance_office_time',  $request->shift['id']);

            $employee_data_approval_biulder->whereRaw("attendance_setups.start_date <=  '$start_date'");
            $employee_data_approval_biulder->whereRaw("attendance_setups.end_date >=  '$end_date'");
        }
        $employee_data_approval_biulder->where('attendance.pdate', '>=', $start_date)
          ->where('attendance.pdate', '<=', $end_date)
          ->where('employee_sbu', $request['sbu_id'])
          ->where('employee_status', 1)
          ->whereIn('attendance.pstatus', [1,2,4])
          ->whereIn('employees.id', $employee_id)
          ->where(function ($employee_data_approval_biulder) use ($section_id, $subsection_id, $subunit_id, $unit_id, $employee_work_location, $department_id) {
              if (!empty($section_id)) {
                  $employee_data_approval_biulder->where('employee_section', $section_id);
              }
              if (!empty($subsection_id)) {
                  $employee_data_approval_biulder->where('employee_sub_section', $subsection_id);
              }
              if (!empty($subunit_id)) {
                  $employee_data_approval_biulder->where('employee_sub_unit', $subunit_id);
              }
              if (!empty($unit_id)) {
                  $employee_data_approval_biulder->where('employee_unit', $unit_id);
              }
              if (!empty($employee_work_location)) {
                  $employee_data_approval_biulder->where('employee_work_location', $employee_work_location);
              }
              if (!empty($department_id)) {
                  $employee_data_approval_biulder->where('employee_department', $department_id);
              }
          });
        $employee_data_approval = $employee_data_approval_biulder->groupBy('attendance.employee_id')->groupBy('attendance.pdate')->get();
        $data['employee_data_approvaldat'] = $employee_data_approval;

        return response()->json($data);
    }

    public function column_real_name($columnArray)
    {
        $column_data = array();
        foreach ($columnArray as $key => $value) {
            // echo "<pre>"; print_r($columnArray); die();
            if ($value == 'employee_id_no') {
                $column_data[] = 'Employee ID';
            }
            if ($value == 'employee_full_name') {
                $column_data[] = 'Employee Name';
            }

            if ($value == 'sbu_name') {
                $column_data[] = 'Company';
            }
            if ($value == 'department_name') {
                $column_data[] = 'Department';
            }
            if ($value == 'designation_name') {
                $column_data[] = 'Designation';
            }
            if ($value == 'section_name') {
                $column_data[] = 'Section';
            }
            if ($value == 'sub_section_name') {
                $column_data[] = 'Sub Section';
            }
            if ($value == 'shift_time') {
                $column_data[] = 'Shift Time';
            }
            if ($value == 'in_time') {
                $column_data[] = 'In Time';
            }
            if ($value == 'out_time') {
                $column_data[] = 'Out Time';
            }
            if ($value == 'late') {
                $column_data[] = 'Late By';
            }
            if ($value == 'status') {
                $column_data[] = 'Status';
            }
            if ($value == 'remarks') {
                $column_data[] = 'Remarks';
            }

            if ($value == 'employee_joining_date') {
                $column_data[] = 'Date of Joining';
            }
            if ($value == 'employee_mobile') {
                $column_data[] = 'Mobile Number';
            }
            if ($value == 'employee_marital_status') {
                $column_data[] = 'Marital Status';
            }
            if ($value == 'employee_blood_group') {
                $column_data[] = 'Blood Group';
            }
            if ($value == 'permanent_district') {
                $column_data[] = 'Home District';
            }
            if ($value == 'employee_children_no') {
                $column_data[] = 'Kids';
            }
            if ($value == 'age') {
                $column_data[] = 'Age';
            }
            if ($value == 'salary') {
                $column_data[] = 'Salary';
            }
            if ($value == 'employee_work_location') {
                $column_data[] = 'Work Location';
            }
            if ($value == 'employee_status') {
                $column_data[] = 'Status';
            }
            if ($value == 'employee_job_grade') {
                $column_data[] = 'Job Grade';
            }
            if ($value == 'service_length') {
                $column_data[] = 'Service Length';
            }

            if ($value == 'emplyee_category_mgt_non_mgt') {
                $column_data[] = 'Employee Category';
            }
            if ($value == 'employee_type') {
                $column_data[] = 'Employee Type';
            }
            if ($value == 'employee_group') {
                $column_data[] = 'Employee Group';
            }
            if ($value == 'employee_gender') {
                $column_data[] = 'Gender';
            }
            if ($value == 'adob') {
                $column_data[] = 'DOB Actual';
            }
            if ($value == 'cdob') {
                $column_data[] = 'DOB Certificate';
            }
        }

        return $column_data;
    }
    public function store(Request $request)
    {
        // DD($request);
        try {
            DB::beginTransaction();
            foreach ($request->employee_data_approvaldat as $key => $value) {
                if (isset($value['ot_entry'])) {
                    $attendance = Attendance::whereNotIn('pstatus', [3,4,5,6])->where('intime', '!=', '00:00:00')->where('id', $value['att_id'])->first();
                    if (!empty($attendance)) {
                        $attendance->ot_entry = $value['ot_entry'];
                        $attendance->save();

                        // insert or update data in ManualOT table
                        $manualOT = ManualOT::where('attendance_id', $value['att_id'])->first();
                        if ($manualOT) {
                            $manualOT->ot_entry = $value['ot_entry'];
                            $manualOT->save();
                        } else {
                            $manualOT = new ManualOT();
                            $manualOT->attendance_id = $value['att_id'];
                            $manualOT->insert_date = date('Y-m-d');
                            $manualOT->ot_date = $value['pdate'];
                            $manualOT->ot_entry = $value['ot_entry'];
                            $manualOT->save();
                        }
                    } else {
                        // $message = ['status' => 0, 'message' => 'Sorry! This Employee Attendance Data does not fund'];
                        // return response($message);
                    }
                }
            }

            DB::commit();
            $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
            // return response($message);
        } catch (\Exception $exception) {
            DB::rollBack();
            $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
            // return response($exception);
        }

        return response($message);
    }

    public function edit($id)
    {
        $data = NoticeModel::valid()->project()->findOrFail($id);
        $companysbu_data_list = CompanySbu::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $section_data_list = Section::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $sub_section_data_list = SubSection::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $employee_group_data_list = EmployeeGroup::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $department_list = Department::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $designation_data_list = Designation::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $jobgrade_data_list = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $employee_data_list = Employee::valid()->project()->where('employee_status', 1)->get()->keyBy('id')->all();
        $employee_reporting = Employee::valid()->project()->where('employee_status', 1)->get()->keyBy('employee_id_no')->all();
        $sub_unit_data_list = SubUnit::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $unit_data_list = UnitModel::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $work_location_data_list = WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        if (!$data->sbu_id) {
            $data->sbu_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->sbu_name_value = ['id' => $data->sbu_id, 'text' => $companysbu_data_list[$data->sbu_id]->sbu_name];
        }
        if (!$data->section_id) {
            $data->section_value = ['id' => '', 'text' => ''];
        } else {
            $data->section_value = ['id' => $data->section_id, 'text' => $section_data_list[$data->section_id]->section_name];
        }
        if (!$data->subsection_id) {
            $data->sub_section_value = ['id' => '', 'text' => ''];
        } else {
            $data->sub_section_value = ['id' => $data->subsection_id, 'text' => $sub_section_data_list[$data->subsection_id]->sub_section_name];
        }
        if (!$data->employee_id) {
            $data->employee_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->employee_name_value = ['id' => $data->employee_id, 'text' => $employee_data_list[$data->employee_id]->employee_fullname];
        }
        if (!$data->department_id) {
            $data->department_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->department_name_value = ['id' => $data->department_id, 'text' => $department_list[$data->department_id]->department_name];
        }

        if (!$data->subunit_id) {
            $data->sub_unit_value = ['id' => '', 'text' => ''];
        } else {
            $data->sub_unit_value = ['id' => $data->subunit_id, 'text' => $sub_unit_data_list[$data->subunit_id]->sub_unit_name];
        }
        if (!$data->unit_id) {
            $data->unit_value = ['id' => '', 'text' => ''];
        } else {
            $data->unit_value = ['id' => $data->unit_id, 'text' => $unit_data_list[$data->unit_id]->unit_name];
        }

        $company_sbu_data = array();
        $section_data = array();
        $sub_section_data = array();
        $employee_group_data = array();
        $department_data = array();
        $designation_data = array();
        $jobgrade_data = array();
        $employee_data = array();
        $employee_data_approval = array();
        $unit_data = array();
        $sub_unit_data = array();
        $work_location_data = array();
        foreach ($companysbu_data_list as $value) {
            array_push($company_sbu_data, ['id' => $value['id'], 'text' => $value['sbu_name']]);
        }
        foreach ($section_data_list as $value) {
            array_push($section_data, ['id' => $value['id'], 'text' => $value['section_name']]);
        }
        foreach ($sub_section_data_list as $value) {
            array_push($sub_section_data, ['id' => $value['id'], 'text' => $value['sub_section_name']]);
        }
        foreach ($employee_group_data_list as $value) {
            array_push($employee_group_data, ['id' => $value['id'], 'text' => $value['employee_group_name']]);
        }
        foreach ($department_list as $value) {
            array_push($department_data, ['id' => $value['id'], 'text' => $value['department_name']]);
        }
        foreach ($designation_data_list as $value) {
            array_push($designation_data, ['id' => $value['id'], 'text' => $value['designation_name']]);
        }
        foreach ($jobgrade_data_list as $value) {
            array_push($jobgrade_data, ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
        }
        foreach ($employee_data_list as $value) {
            array_push($employee_data, ['id' => $value['id'], 'text' => $value['employee_id_no'] . ' - ' . $value['employee_fullname']]);
        }
        foreach ($sub_unit_data_list as $value) {
            array_push($sub_unit_data, ['id' => $value['id'], 'text' => $value['sub_unit_name']]);
        }
        foreach ($unit_data_list as $value) {
            array_push($unit_data, ['id' => $value['id'], 'text' => $value['unit_name']]);
        }
        foreach ($work_location_data_list as $value) {
            array_push($work_location_data, ['id' => $value['id'], 'text' => $value['department_name']]);
        }

        $approvalInfos = NoticePermission::valid()->project()->where('notice_id', $id)->get();
        // return response($approvalInfos);
        if (!empty($approvalInfos)) {
            $data->approval_infos = $approvalInfos;
        } else {
            $date->approval_infos = ['0' => ['id' => 0, 'permission_type' => '', 'permission_id' => '']];
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
        $delete_data = NoticeModel::valid()->project()->findOrFail($id);
        if ($delete_data->delete()) {
            $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
        }
        return response($message);
    }

    public function create()
    {
        $data['company_sbu_data'] = array();
        $data['section_data'] = array();
        $data['sub_section_data'] = array();
        $data['sub_unit_data'] = array();
        $data['unit_data'] = array();
        $data['work_location_data'] = array();
        $data['department_data'] = array();
        $data['designation_data'] = array();
        $data['jobgrade_data'] = array();
        $data['employee_data'] = array();
        $data['employee_data_approval'] = array();
        $data['employee_group_data'] = array();
        $company_sbu_data = CompanySbu::valid()->project()->orderBy('priority', 'ASC')->get();
        $section_data = Section::valid()->project()->orderBy('priority', 'ASC')->get();
        $sub_section_data = SubSection::valid()->project()->orderBy('priority', 'ASC')->get();
        $department_data = Department::valid()->project()->orderBy('priority', 'ASC')->get();
        $designation_data = Designation::valid()->project()->orderBy('priority', 'ASC')->get();
        $jobgrade_data = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get();
        $employee_data_approval = Employee::valid()->project()->get();
        $employee_data = Employee::valid()->project()->get()->keyBy('id')->all();
        $unit_data = UnitModel::valid()->project()->orderBy('priority', 'ASC')->get();
        $sub_unit_data = SubUnit::valid()->project()->orderBy('priority', 'ASC')->get();
        $work_location_data = WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get();
        $employee_group_data = EmployeeGroup::valid()->project()->orderBy('priority', 'ASC')->get();
        foreach ($company_sbu_data as $value) {
            array_push($data['company_sbu_data'], ['id' => $value['id'], 'text' => $value['sbu_name']]);
        }
        foreach ($section_data as $value) {
            array_push($data['section_data'], ['id' => $value['id'], 'text' => $value['section_name']]);
        }
        foreach ($sub_section_data as $value) {
            array_push($data['sub_section_data'], ['id' => $value['id'], 'text' => $value['sub_section_name']]);
        }
        foreach ($employee_group_data as $value) {
            array_push($data['employee_group_data'], ['id' => $value['id'], 'text' => $value['employee_group_name']]);
        }
        foreach ($department_data as $value) {
            array_push($data['department_data'], ['id' => $value['id'], 'text' => $value['department_name'],]);
        }
        foreach ($designation_data as $value) {
            array_push($data['designation_data'], ['id' => $value['id'], 'text' => $value['designation_name']]);
        }
        foreach ($jobgrade_data as $value) {
            array_push($data['jobgrade_data'], ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
        }
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

        $data['approval_infos'] = ['0' => ['id' => 0, 'permission_type' => '', 'permission_id' => '']];
        return response($data);
    }
}
