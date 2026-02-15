<?php

namespace App\Http\Controllers\hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
use App\Model\OfficeTimeSetup;
use App\Model\RosterMaping;
use App\Model\EmployeeApproval;
use Cache;
use permission;
use DB;
use DateTime;
use DateInterval;
use DatePeriod;
// use App\Model\UserRoleAccess;

class ChangingReportingController extends Controller
{
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  

  public function reporting_to_setup($id=0){
    $employee_data_approval = array();
    $employee_data_list = Employee::valid()->project()->get()->keyBy('id')->all();
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $employee_id = $employee_ids['employee_id'];
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
    // $data['AllemployeeData']=$data['employee_data'] = $employee_list->report_filter_data()['employee_data'];
    $data['employee_data'] = array();
    $employee_data = Employee::valid()->project()->whereIn('employee_sbu', $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->where('employee_status', 1)->get()->keyBy('employee_id_no')->all();
    foreach ($employee_data as $value) {
      array_push($data['employee_data'], ['id' => $value['employee_id_no'], 'employeeNo' => $value['id'], 'text' => $value['employee_id_no'] . ' - ' . $value['employee_fullname']]);
    }
    $data['today_date'] = date('Y-m-d');
    $data['report_print_date'] = date('d F Y');
    $approvalInfos = EmployeeApproval::valid()->project()
      ->select('employee_approvals.*', 'employee_approvals.ea_approval_lavel as indexid', 'employees.employee_id_no as employees_ids', 'employees.employee_fullname as ea_approve_by_name')
      ->join('employees', 'employee_approvals.ea_approve_by', '=', 'employees.id')
      ->where('ea_employee_id', $id)->get();
    if (!empty($approvalInfos)) {
      $data['approval_infos'] = $approvalInfos;
    } else {
      $data['approval_infos'] = ['0' => ['id' => 0, 'ea_approve_by' => '', 'employees_ids' => '', 'ea_approve_by_name' => '']];
    }
    array_push($employee_data_approval, ['id' => '', 'text' => 'Deselect']);
    foreach ($employee_data_list as $value) {
      array_push($employee_data_approval, ['id' => $value['id'], 'employee_name' => $value['employee_fullname'], 'employee_ids' => $value['employee_id_no'], 'text' => $value['employee_id_no'] . ' : ' . $value['employee_fullname']]);
    }
    $data['employee_data_approval'] =  $employee_data_approval;
    return response()->json($data);
  } 

  public function ReportingChangeStore(Request $request){
    // return response($request);
    $validate=[
      'employee_id'=>'employee_id_old',
      'employee_id'=>'employee_id_new',
    ];
    $request->validate($validate);
    $employee_id_old = $request['employee_id_old'];
    $employee_id_new = $request['employee_id_new'];
    
    $reporting_old = Employee::valid()->project()->select('id', 'employee_id_no')->where('employee_id_no',$employee_id_old)->first();
    $reporting_new = Employee::valid()->project()->select('id', 'employee_id_no')->where('employee_id_no',$employee_id_new)->first();
    if(empty($reporting_old) || empty($reporting_new)){
      $message = ['status' => 0, 'message' => 'Old/New Reporting to required!'];
      return response($message);
    }
    // return response($reporting_old);
    $employee_data_old = Employee::valid()->project()
    ->where('employee_reporting_to', $reporting_old->employee_id_no)
    ->where('employee_status', 1)
    ->where('employees.employee_sbu', $request['sbu_id']);

    if (!empty($request['unit_id'])) {
      $employee_data_old->where('employees.employee_unit',$request['unit_id']);
    }
    if (!empty($request['subunit_id'])) {
      $employee_data_old->where('employees.sub_unit',$request['subunit_id']);
    }
    if (!empty($request['department_id'])) {
      $employee_data_old->where('employees.employee_department',$request['department_id']);
    }
    if (!empty($request['section_id'])) {
      $employee_data_old->where('employees.employee_section',$request['section_id']);
    }
    if (!empty($request['subsection_id'])) {
      $employee_data_old->where('employees.employee_sub_section',$request['subsection_id']);
    }
    if (!empty($request['employee_work_location'])) {
      $employee_data_old->where('employees.employee_work_location',$request['employee_work_location']);
    }
    $employee_data_old_reporting = $employee_data_old->get();
    
    // return response($employee_data_old_reporting); 
    $reporting_data=[];
    try {
      DB::beginTransaction();

      $approval_infos = collect($request['approval_infos'])->where('ea_approve_by', '!=', '')->toArray();
      // return response($employee_data_old_reporting); 
      foreach ($employee_data_old_reporting as $key => $value) {
          $reporting_data['employee_reporting_to'] = $reporting_new->employee_id_no;
          $reporting_data['project_id'] = Auth::guard('user')->user()->project_id;
          $reporting_data['branch_id'] = Auth::guard('user')->user()->branch_id;
          $reporting_data['updated_by'] = Auth::guard('user')->user()->id;
          $reporting_data['updated_at'] = date('Y-m-d H:i:s');
          DB::table('employees')->where('employee_reporting_to', $value->employee_reporting_to)->where('employee_status', 1)->update($reporting_data);
          DB::table('employee_approvals')->where('ea_employee_id', '=', $value->id)->delete();
          $i = 0;
          foreach ($approval_infos as $key => $value1) {
            // return response($value1);
            $i++;
            $approval_data['ea_employee_id'] = $value->id;
            $approval_data['ea_approval_lavel'] = $i;
            $approval_data['ea_approve_by'] = $value1['ea_approve_by'];
            $approval_data['project_id'] = Auth::guard('user')->user()->project_id;
            $approval_data['branch_id'] = Auth::guard('user')->user()->branch_id;
            $approval_data['updated_by'] = Auth::guard('user')->user()->id;
            $approval_data['updated_at'] = date('Y-m-d H:i:s');
            DB::table('employee_approvals')->insert($approval_data);
          }
        }
        DB::commit();
        $message = ['status' => 1, 'message' => 'Your data is successfully Saved!'];
        return response($message);
    }catch (\Exception $exception) {
        DB::rollBack();
        $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
        return response($exception);
    }
  }


}
