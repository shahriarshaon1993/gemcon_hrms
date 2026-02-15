<?php

namespace App\Http\Controllers\hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Attendance;
use App\Model\AttendanceLog;
use App\Model\Employee;
use Auth;
use Session;
use Cache;
use permission;
use DB;
// use App\Model\UserRoleAccess;

class AbsentController extends Controller
{

  public function index(Request $request)
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

    $data['AllemployeeData'] = $data['employee_data'] = $employee_list->report_filter_data()['employee_data'];


    return response()->json($data);
  }
  public function report_find(Request $request)
  {
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $employee_id = collect($request['employee_name_value'])->where('id', '!=', '')->pluck('id')->toArray();
    // $employee_ids['employee_id'];
    $employee_data_approval = [];
    $section_id = collect($request['section_value'])->where('id', '!=', '')->pluck('id')->toArray();
    // $request['section_id'];
    $subsection_id = collect($request['sub_section_value'])->where('id', '!=', '')->pluck('id')->toArray();
    // $request['subsection_id'];
    $employee_groupsubunit_id = $request['employee_groupsubunit_id'];
    $subunit_id = collect($request['sub_unit_value'])->where('id', '!=', '')->pluck('id')->toArray();
    // $request['subunit_id'];
    $unit_id = collect($request['unit_value'])->where('id', '!=', '')->pluck('id')->toArray();
    // $request['unit_id'];
    $employee_work_location = collect($request['work_location_value'])->where('id', '!=', '')->pluck('id')->toArray();
    // $request['employee_work_location'];
    $department_id = collect($request['department_name_value'])->where('id', '!=', '')->pluck('id')->toArray();
    // $request['department_id'];
    $sbu_id = collect($request['sbu_name_value'])->where('id', '!=', '')->pluck('id')->toArray();

    // echo "<pre>";
    // print_r($sbu_id);
    // exit();

    // unit_value:this.unit_value,
    // sub_unit_value:this.sub_unit_value,
    // department_name_value:this.department_name_value,
    // section_value:this.section_value,
    // sub_section_value:this.sub_section_value,
    // work_location_value:this.work_location_value,
    // employee_name_value:this.employee_name_value,

    $employee_data_approval = Employee::valid()->project()->where('employee_status', 1)
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->select(
        'employees.employee_id_no'
      )
      ->whereIn('employee_sbu', $sbu_id)
      ->where(function ($loanInfo) use ($section_id, $subsection_id, $employee_groupsubunit_id, $subunit_id, $unit_id, $employee_work_location, $department_id) {
        if (!empty($section_id)) {
          $loanInfo->whereIn('employee_section', $section_id);
        }
        if (!empty($subsection_id)) {
          $loanInfo->whereIn('employee_sub_section', $subsection_id);
        }
        if (!empty($employee_groupsubunit_id)) {
          $loanInfo->whereIn('employee_group', $employee_groupsubunit_id);
        }
        if (!empty($subunit_id)) {
          $loanInfo->whereIn('employee_sub_unit', $subunit_id);
        }
        if (!empty($unit_id)) {
          $loanInfo->whereIn('employee_unit', $unit_id);
        }
        if (!empty($employee_work_location)) {
          $loanInfo->whereIn('employee_work_location', $employee_work_location);
        }
        if (!empty($department_id)) {
          $loanInfo->whereIn('employee_department', $department_id);
        }
      })
      ->get()->pluck('employee_id_no')->toArray();

    $end_date = date('Y-m-d');
    // start date with 10 days sum
    $start_date_def = $request->absent_day_value-1;
    $start_date = date('Y-m-d', strtotime('-' . $start_date_def . ' days', strtotime($end_date)));
    // dd($start_date, $end_date, $start_date_def);
    $attendance = AttendanceLog::valid()
      ->whereIn('employee_id', $employee_data_approval)
      ->whereBetween('TransactionDate', [$start_date, $end_date])
      ->groupBy('employee_id')
      ->get()->pluck('employee_id')->toArray();

    $not_in = array_diff($employee_data_approval, $attendance);
    $list_data = Employee::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->select('employees.*', 'company_sbus.sbu_name', 'departments.department_name',  'designations.designation_name')
      ->whereIn('employees.employee_id_no', $not_in)
      ->get();
    // ->paginate($paginate_num);

    $end_date = date('d-M-Y');
    // start date with 10 days sum
    $start_date = date('d-M-Y', strtotime('-' . $start_date_def . ' days', strtotime($end_date)));
    $data['total_absent'] = $request->absent_day_value ;
    $data['date_absent'] = $start_date . ' to ' . $end_date;
    $data['not_attendance'] = $list_data;
    $data['report_name'] = "Absent Report [ ".date('d F Y', strtotime($start_date_def))." To ". date('d F Y', strtotime($end_date))." ]";
    $data['report_title'] = "Absent Report";
    $data['reportDate'] = date('d F Y');
    $data['sbuname']=collect($list_data)->first()->sbu_name;

    return response()->json($data);
  }
}
