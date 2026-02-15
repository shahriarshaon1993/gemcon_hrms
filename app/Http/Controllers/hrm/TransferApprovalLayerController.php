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

class TransferApprovalLayerController extends Controller
{
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  

  public function transfer_approval_setup($id=0){
    $employee_data_approval = array();
    $employee_data_list = Employee::valid()->project()->get()->keyBy('id')->all();
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
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
    $data['AllemployeeData']=$data['employee_data'] = $employee_list->report_filter_data()['employee_data'];
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

  public function transfer_approval_layer(Request $request){
    $validate=[
      'sbu_id'=>'required',
    ];
    $request->validate($validate);
    $sbu_id = $request['sbu_id'];
    $unit_id = $request['unit_id'];
    $subunit_id = $request['subunit_id'];
    $department_id = $request['department_id'];
    $section_id = $request['section_id'];
    $subsection_id = $request['subsection_id'];
    $employee_work_location = $request['employee_work_location'];
    $employee_id = $request['employee_id'];
    $employee_data_approval = Employee::valid()->project()
      ->where('employee_sbu', $request['sbu_id'])
      ->where('employee_status', 1)
      ->where(function ($employeeInfo) use ($section_id, $subsection_id, $subunit_id, $unit_id, $employee_work_location, $department_id, $employee_id) {
        if (!empty($section_id)) {
          $employeeInfo->where('employee_section', $section_id);
        }
        if (!empty($subsection_id)) {
          $employeeInfo->where('employee_sub_section', $subsection_id);
        }
        if (!empty($employee_groupsubunit_id)) {
          $employeeInfo->where('employee_group', $employee_groupsubunit_id);
        }
        if (!empty($subunit_id)) {
          $employeeInfo->where('employee_sub_unit', $subunit_id);
        }
        if (!empty($unit_id)) {
          $employeeInfo->where('employee_unit', $unit_id);
        }
        if (!empty($employee_work_location)) {
          $employeeInfo->where('employee_work_location', $employee_work_location);
        }
        if (!empty($department_id)) {
          $employeeInfo->where('employee_department', $department_id);
        }
        if (!empty($employee_id)) {
          $employeeInfo->where('employee_department', $employee_id);
        }
      })
    ->get();
    
    // return response($request);


    // $employee_id_old = $request['employee_id_old'];
    // $employee_id_new = $request['employee_id_new'];
    // $reporting_old = Employee::valid()->project()->select('id', 'employee_id_no')->where('id',$employee_id_old)->first();
    // $reporting_new = Employee::valid()->project()->select('id', 'employee_id_no')->where('id',$employee_id_new)->first();
    // $employee_data_old_reporting = Employee::valid()->project()
    // ->where('employee_reporting_to', $reporting_old->employee_id_no)
    // ->where('employee_status', 1)
    // ->get();

    if(empty($request['sbu_id'])){
      $message = ['status' => 0, 'message' => 'Company/SBU not selected!'];
      return response($message);
    }

    // $employee_data_old_reporting=[];
    // $reporting_data=[];
    try {
      DB::beginTransaction();
      $approval_infos = collect($request['approval_infos'])->where('ea_approve_by', '!=', '')->toArray();
      foreach ($employee_data_approval as $key => $value) {
          // $reporting_data['employee_reporting_to'] = $reporting_new->employee_id_no;
          // $reporting_data['project_id'] = Auth::guard('user')->user()->project_id;
          // $reporting_data['branch_id'] = Auth::guard('user')->user()->branch_id;
          // $reporting_data['created_by'] = Auth::guard('user')->user()->id;
          // $reporting_data['created_at'] = date('Y-m-d H:i:s');
          // DB::table('employees')->where('employee_reporting_to', $value->employee_reporting_to)->where('employee_status', 1)->update($reporting_data);
          DB::table('employee_approvals')->where('ea_employee_id', '=', $value->id)->where('approval_type', '=', 2)->delete();
          $i = 0;
          foreach ($approval_infos as $key => $value1) {
            $i++;
            $approval_data['ea_employee_id'] = $value->id;
            $approval_data['ea_approval_lavel'] = $i;
            $approval_data['ea_approve_by'] = $value1['ea_approve_by'];
            $approval_data['approval_type'] = 2;
            $approval_data['project_id'] = Auth::guard('user')->user()->project_id;
            $approval_data['branch_id'] = Auth::guard('user')->user()->branch_id;
            $approval_data['created_by'] = Auth::guard('user')->user()->id;
            DB::table('employee_approvals')->insert($approval_data);
          }
        }
        DB::commit();
        $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
        return response($message);
    }catch (\Exception $exception) {
        DB::rollBack();
        $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
        return response($exception);
    }
  }


}
