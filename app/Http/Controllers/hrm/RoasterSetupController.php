<?php

namespace App\Http\Controllers\hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AttendanceSetup;
use App\Model\CompanySbu;
use App\Model\Department;
use App\Model\Designation;
use App\Model\DistrictModel;
use App\Model\Employee;
use App\Model\EmployeeApproval;
use App\Model\EmployeeGroup;
use App\Model\JobGrade;
use Auth;
use Session;
use App\Model\OfficeTimeSetup;
use App\Model\Section;
use App\Model\SubUnit;
use App\Model\WorkLocation;
use Cache;
use Illuminate\Support\Facades\DB;
use permission;
// use App\Model\UserRoleAccess;

class RoasterSetupController extends Controller
{
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */

  public function index(Request $request)
  {
    $cache = Cache::get('permission');
    $permission = collect($cache)->where('menu_uid', '=', 'RoasterSetup')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
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
    $data['paginate_data'] = OfficeTimeSetup::valid()->project()->when($search_key, function ($query, $search_key) {
      $query->where(function ($query2) use ($search_key) {
        $query2->where('title', 'LIKE', '%' . $search_key . '%');
      });
      return $query;
    })->where('project_id', $project_id)->where('type', 3)->orderBy($sort, $order)->paginate($paginate_num);

    return response()->json($data);
  }


  public function store(Request $request)
  {
    // echo "<pre>";print_r($this->findDepartmentMaxCode()); die();
    // return response($request['office_start_time']['HH']);

    $validate = [
      'office_time_start_date' => 'required',
      'office_time_end_date' => 'required',
      'office_start_time' => 'required',
      'office_end_time' => 'required',
      'office_time_status' => 'required'
    ];

    $request->validate($validate);
    $data = $request->only('title', 'office_time_start_date', 'office_time_end_date', 'office_start_time', 'office_end_time', 'office_time_note', 'office_time_status', 'lateConsiderTime');

    if (!empty($request->id)) {
      $update_data = OfficeTimeSetup::valid()->project()->findOrFail($request->id);
      $data['updated_by'] = Auth::guard('user')->user()->branch_id;
      $save_data = $update_data->update($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
    } else {
      // $data['department_code'] = $this->findDepartmentMaxCode();
      $data['office_start_time'] = $request['office_start_time']['HH'] . ':' . $request['office_start_time']['mm'] . ':' . '00';
      $data['office_end_time'] = $request['office_end_time']['HH'] . ':' . $request['office_end_time']['mm'] . ':' . '00';
      // $data['lateConsiderTime']=$request['lateConsiderTime']['HH'].':'.$request['lateConsiderTime']['mm'].':'.'00';
      $data['project_id'] = Auth::guard('user')->user()->project_id;
      $data['branch_id'] = Auth::guard('user')->user()->branch_id;
      $data['created_by'] = Auth::guard('user')->user()->id;
      $data['type'] = 3;
      $save_data = OfficeTimeSetup::create($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
    }

    if (!$save_data) {
      $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
    }
    return response($message);
  }

  public function edit($id)
  {
    $edit_data = OfficeTimeSetup::valid()->project()->findOrFail($id);
    return response($edit_data);
  }

  public function destroy($id)
  {

    $delete_data = OfficeTimeSetup::valid()->project()->findOrFail($id);
    if ($delete_data->delete()) {
      $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
    }
    return response($message);
  }

  public function find_report()
  {
    // $employee_list = new Employee();
    // $employee_ids = $employee_list->Employee_id();
    // $employee_id = $employee_ids['employee_id'];

    // $data['AllcompanySbuData'] = $employee_list->report_filter_data()['Allcompany_sbu_data'];
    // $data['company_sbu_data'] = $employee_list->report_filter_data()['company_sbu_data'];
    // $data['AllsectionData'] = $employee_list->report_filter_data()['Allsection_data'];
    // $data['section_data'] = $employee_list->report_filter_data()['section_data'];
    // $data['AllsubSectionData'] = $employee_list->report_filter_data()['Allsub_section_data'];
    // $data['sub_section_data'] = $employee_list->report_filter_data()['sub_section_data'];
    // $data['AllsubUnitData'] = $employee_list->report_filter_data()['Allsub_unit_data'];
    // $data['sub_unit_data'] = $employee_list->report_filter_data()['sub_unit_data'];
    // $data['AllunitData'] = $employee_list->report_filter_data()['Allunit_data'];
    // $data['unit_data'] = $employee_list->report_filter_data()['unit_data'];
    // $data['AllworkLocationData'] = $employee_list->report_filter_data()['Allwork_location_data'];
    // $data['work_location_data'] = $employee_list->report_filter_data()['work_location_data'];
    // $data['AlldepartmentData'] = $employee_list->report_filter_data()['Alldepartment_data'];
    // $data['department_data'] = $employee_list->report_filter_data()['department_data'];
    // $employee_data =$employee_list->report_filter_data()['employee_data'];
    $employee_ids = Session::get('employee_ids');
    $employee_id = $employee_ids['employee_id'];

    $data['AllcompanySbuData'] = Session::get('Allcompany_sbu_data'); 
    $data['company_sbu_data'] = Session::get('company_sbu_data'); 
    $data['AllsectionData'] =  Session::get('Allsection_data');
    $data['section_data'] = Session::get('section_data');
    $data['AllsubSectionData'] = Session::get('Allsub_section_data');
    $data['sub_section_data'] = Session::get('sub_section_data');
    $data['AllsubUnitData'] = Session::get('Allsub_unit_data');
    $data['sub_unit_data'] = Session::get('sub_unit_data');
    $data['AllunitData'] = Session::get('Allunit_data');
    $data['unit_data'] = Session::get('unit_data');
    $data['AllworkLocationData'] = Session::get('Allwork_location_data');
    $data['work_location_data'] = Session::get('work_location_data');
    $data['AlldepartmentData'] = Session::get('Alldepartment_data');
    $data['department_data'] = Session::get('department_data');


    $officeTime = OfficeTimeSetup::valid()->project()->whereIn('type', ['2', '3'])->where('office_time_status', 1)->orderBy('priority', 'ASC')->get();
    $data['officeTime'] = array();
    foreach ($officeTime as $value) {
      array_push($data['officeTime'], ['id' => $value['id'], 'text' => $value['title'] . " [ " . date('h:i A', strtotime($value['office_start_time'])) . " - " . date('h:i A', strtotime($value['office_end_time'])) . " ] "]);
    }

    // $data['company_sbu_data']=array();
    // $data['section_data']=array();
    // $data['sub_section_data']=array();
    // $data['sub_unit_data']=array();
    // $data['work_location_data']=array();
    // $data['department_data']=array();
    $data['designation_data'] = array();
    $data['jobgrade_data'] = array();
    $data['employee_data'] = array();
    $data['employee_data_approval'] = array();
    $data['employee_group_data'] = array();


    // $company_sbu_data=CompanySbu::valid()->project()->whereIn('id',$employee_ids['sub'])->orderBy('priority', 'ASC')->get();
    // $section_data=Section::valid()->project()->whereIn('id',$employee_ids['section'])->orderBy('priority', 'ASC')->get();
    // $sub_section_data=SubSection::valid()->project()->whereIn('id',$employee_ids['subsection'])->orderBy('priority', 'ASC')->get();
    // $department_data=Department::valid()->project()->whereIn('id',$employee_ids['department'])->orderBy('priority', 'ASC')->get();

    $designation_data = Designation::valid()->project()->whereIn('id', $employee_ids['designation'])->orderBy('priority', 'ASC')->get();
    $jobgrade_data = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get();
    $employee_data_approval = Employee::valid()->project()->whereIn('employee_sbu', $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->get();
    // return response($employee_data_approval);
    $employee_data = Employee::valid()->project()->get()->keyBy('employee_id_no')->all();
    // $employee_data=Employee::valid()->project()
    //               ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
    //               ->select(
    //                 'employees.*',
    //                 'designations.designation_name'
    //               )
    //               ->whereIn('employee_sbu',$employee_ids['sub'])->whereIn('employee_department',$employee_ids['department'])
    //               ->orderBy('priority', 'ASC')->get();
    // $sub_unit_data=SubUnit::valid()->project()->whereIn('id',$employee_ids['subunit'])->orderBy('priority', 'ASC')->get();
    // $work_location_data=WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get();
    $employee_group_data = EmployeeGroup::valid()->project()->orderBy('priority', 'ASC')->get();

    // array_push($data['company_sbu_data'],['id'=>'','text'=>'All Select']);
    // foreach ($company_sbu_data as $value) {
    //   array_push($data['company_sbu_data'],['id'=>$value['id'],'text'=>$value['sbu_name']]);
    // } 
    //   array_push($data['section_data'],['id'=>'','text'=>'All Select']);
    // foreach ($section_data as $value) {
    //   array_push($data['section_data'],['id'=>$value['id'],'text'=>$value['section_name']]);
    // } 
    //  array_push($data['sub_section_data'],['id'=>'','text'=>'All Select']);
    // foreach ($sub_section_data as $value) {
    //   array_push($data['sub_section_data'],['id'=>$value['id'],'text'=>$value['sub_section_name']]);
    // }
    array_push($data['employee_group_data'], ['id' => '', 'text' => 'All Select']);
    foreach ($employee_group_data as $value) {
      array_push($data['employee_group_data'], ['id' => $value['id'], 'text' => $value['employee_group_name']]);
    }
    //  array_push($data['department_data'],['id'=>'','text'=>'All Select']);
    // foreach ($department_data as $value) {
    //   array_push($data['department_data'],['id'=>$value['id'],'text'=>$value['department_name']]);
    // }
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
      // return response($value);
      // array_push($data['employee_data_approval'],['id'=>$value['id'],'text'=>$value['employee_id_no'].' : '.$value['employee_fullname']]);
      array_push($data['employee_data_approval'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . ':' . $value['employee_fullname'] . '-' . $value['designation_name']]);
    }
    // array_push($data['sub_unit_data'],['id'=>'','text'=>'All Select']);
    // foreach ($sub_unit_data as $value) {
    //   array_push($data['sub_unit_data'],['id'=>$value['id'],'text'=>$value['sub_unit_name']]);
    // }
    // array_push($data['work_location_data'],['id'=>'','text'=>'All Select']);
    // foreach ($work_location_data as $value) {
    //   array_push($data['work_location_data'],['id'=>$value['id'],'text'=>$value['work_location_name']]);
    // }

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


    // return request()->employee_id;
    // $employee_sbu=collect($request['sbu_name_value'])->pluck('id')->toArray();
    // $employee_department=collect($request->department_name_value)->pluck('id')->toArray();
    // $employee_designation=collect($request->designation_name_value)->pluck('id')->toArray();
    // $employee_id=collect($request->designation_name_value)->pluck('id')->toArray();
    $from_date = isset(request()->from_date) ? request()->from_date : '';
    $to_date = isset(request()->to_date) ? request()->to_date : '';
    $strDate1 = substr($from_date, 4, 11);
    $strDate2 = substr($to_date, 4, 11);
    $search_option['from_date_formated'] = $from_date_formated = date('Y-m-d', strtotime($strDate1));
    $search_option['to_date_formated'] = $to_date_formated = date('Y-m-d', strtotime($strDate2));
    $search_option['employee_id'] = $employee_id = collect($request->designation_name_value)->where('id', '!=', '')->pluck('id')->toArray();
    $search_option['employee_ids'] = $employee_ids = request()->employee_id;
    // request()->employee_id;
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
    // return $att_status;
    // echo "<pre>";
    // print_r(collect($request->AttStatus_value)->where('id','!=','')->pluck('id')->toArray());
    // exit();
    return $this->find_daily_attendance($report_type, $att_report_type, $employee_sbu, $from_date_formated, $to_date_formated, $checkedattcolsadd, $search_option);
  }

  public function find_daily_attendance($report_type, $att_report_type, $employee_sbu, $from_date_formated, $to_date_formated, $checkedattcolsadd, $search_option)
  {
    $column_data = [];
    if (count($column_data) > 1) {
      $column_name_data = $this->column_real_name($columnArray);
    } else {
      $column_data = $columNameArray = array("employee_id_no", "employee_full_name", "designation_name", "department_name", "employee_work_location", "sbu_name",  "shift_time", "in_time", "out_time", "late", "status", "remarks");
      $column_name_data = $this->column_real_name($columNameArray);
    }
    // echo "<pre>";
    // print_r($employee_sbu);
    // exit();
    // return $employee_sbu;
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
    $emplyId = Employee::whereIn('employee_sbu', $employeeSbu)->where('employees.employee_status', 1);
      // ->whereIn('employee_department', $employeeDepartment);
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
    if (!empty($search_option['employee_section'])) {
      $emplyId->whereIn('employee_section', $search_option['employee_section']);
    }
    if (!empty($search_option['employee_sub_section'])) {
      $emplyId->whereIn('employee_sub_section', $search_option['employee_sub_section']);
    }
    if (!empty($search_option['employee_department'])) {
      $emplyId->whereIn('employee_department', $search_option['employee_department']);
    }
    if (!empty($search_option['employee_designation'])) {
      $emplyId->whereIn('employee_designation', $search_option['employee_designation']);
    }

    $emplyIds = $emplyId->pluck('id')->toarray();

    $resignationsEmpId = DB::table('resignations')->where('resignation_status', 2)->where('effective_date', '>=', $from_date_formated)->pluck('employee_id')->toarray();

    $allemplyid = array_merge($emplyIds, $resignationsEmpId);
    if (!empty($search_option['OfficeTime'])) {
      $attendanceTime = AttendanceSetup::select('attendance_setups.*', 'office_time_setups.office_start_time as office_start_time', 'office_time_setups.office_end_time as office_end_time', 'office_time_setups.lateConsiderTime as lateConsiderTime', 'office_time_setups.office_type as office_type', 'office_time_setups.type as type', 'office_time_end_date', 'office_time_start_date')
        ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
        ->whereIn('attendance_setups.employee_id', $allemplyid)

        ->where('start_date', '>=', $from_date_formated)
        ->where('end_date', '<=', $from_date_formated);
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
      ->WhereIn('id', $AllemplyIds);
      // ->whereIn('employee_department', $employeeDepartment);
    if (!empty($search_option['employee_designation'])) {
      $employee_info->whereIn('employee_designation', $search_option['employee_designation']);
    }
    if (!empty($search_option['employee_work_location'])) {
      $employee_info->whereIn('employee_work_location', $search_option['employee_work_location']);
    }
    if (!empty($search_option['unit'])) {
      $employee_info->whereIn('employee_unit', $search_option['unit']);
    }
    if (!empty($search_option['sub_unit'])) {
      $employee_info->whereIn('employee_sub_unit', $search_option['sub_unit']);
    }

    if (!empty($search_option['employee_section'])) {
      $employee_info->whereIn('employee_section', $search_option['employee_section']);
    }
    if (!empty($search_option['employee_sub_section'])) {
      $employee_info->whereIn('employee_sub_section', $search_option['employee_sub_section']);
    }
    if (!empty($search_option['employee_department'])) {
      $employee_info->whereIn('employee_department', $search_option['employee_department']);
    }
    if (!empty($search_option['employee_designation'])) {
      $employee_info->whereIn('employee_designation', $search_option['employee_designation']);
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
    $employee_section = Section::valid()->whereIn('id', $employee_id_call['section'])->get()->toArray();
    $employee_department = Department::valid()->whereIn('id', $employeeDepartment)->get()->toArray();
    $employee_designation = Designation::valid()->whereIn('id', $employee_id_call['designation'])->get()->toArray();
    $employee_sub_unit = SubUnit::valid()->whereIn('id', $employee_id_call['subunit'])->get()->toArray();
    $WorkLocation = WorkLocation::valid()->get()->toArray();

    // $search_option['OfficeTime']


    $attendance_data = DB::table('attendance_log')
      ->whereIn('employee_id', $employee_ids)
      ->where('TransactionDate', $from_date_formated)
      ->where('valid', '=', 1)
      ->get()->toArray();
    $manulAttendance = DB::table('manual_attendances')
      ->whereIn('employee_id_no', $employee_ids)
      ->where('manual_attendance_date', $from_date_formated)
      ->where('manual_attendance_status', 1)
      ->where('valid', '=', 1)
      ->get()->toArray();
    if (!empty($search_option['OfficeTime'])) {
      $attendanceTime = $attendanceTime;
    } else {

      $attendanceTime = AttendanceSetup::select('attendance_setups.*', 'office_time_setups.title', 'office_time_setups.office_start_time as office_start_time', 'office_time_setups.office_end_time as office_end_time', 'office_time_setups.lateConsiderTime as lateConsiderTime', 'office_time_setups.office_type as office_type', 'office_time_setups.type as type', 'office_time_end_date', 'office_time_start_date')
        ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'attendance_setups.attendance_office_time')
        ->whereIn('attendance_setups.employee_id', $allemplyid)
        ->where('start_date', '>=', $from_date_formated)

        ->where('end_date', '<=', $from_date_formated);

      if (!empty($search_option['OfficeTime'])) {

        $attendanceTime->whereIn('attendance_setups.attendance_office_time', $search_option['OfficeTime']);
      }

      $attendanceTime = $attendanceTime->get();
    }

    // echo "<pre>";
    // print_r($attendanceTime);
    // exit();
    $approve_late_request = DB::table('late_approve_requests')
      ->whereIn('employee_id', $employee_primary_ids)
      ->where('late_date', $from_date_formated)
      ->where('late_approve_status', '=', 2)
      ->get();

    $company_sbu_data = DB::table('company_sbus')->get();


    $approve_late_find = array();
    if ($approve_late_request) {
      foreach ($approve_late_request as $date) {
        array_push($approve_late_find, $date->late_date);
      }
    }

    $holidayFind = DB::table('holiday_setups')
      ->select('holiday_setups.*')
      ->where('holiday_start_date', $from_date_formated)
      ->get();
    // echo"<pre>";
    // print_r($holidayFind);
    // exit();               
    $holiday_find = array();

    if ($holidayFind) {

      foreach ($holidayFind as $key => $value) {
        $period_holiday = CarbonPeriod::create($value->holiday_start_date, $value->holiday_end_date);
        foreach ($period_holiday as $date) {
          array_push($holiday_find, $date->format('Y-m-d'));
        }
      }
    }
    $indLeaveInfo1 = DB::table('leave_applications')
      ->leftJoin('leave_types', 'leave_types.id', '=', 'leave_applications.leave_type')
      ->where('leave_from_date', $from_date_formated)
      ->whereIn('employee_id', $employee_primary_ids)
      ->where('leave_applications.leave_apply_status', '=', 2)
      ->get();


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
    $emaploeeAttendall = DB::table('attendance')->where('pdate', $from_date_formated)->get()->toArray();

    // return $indLeaveInfo1;
    foreach ($employee_info as $key => $value) {
      // $attendance_time=collect($attendanceTime)->where('employee_id',$value->id)->first();
      $companySbu_data = collect($company_sbu_data)->where('id', $value->employee_sbu)->first();
      $weekend = explode(",", $companySbu_data->weekend);

      $attendance_time = collect($attendanceTime)->where('employee_id', $value->id)
        ->where('start_date', '<=', $from_date_formated)
        ->where('end_date', '>=', $from_date_formated)
        ->first();

      if (empty($attendance_time)) {
        $attendance_time = $companySbu_data;
        $attendance_time->office_type = 1;
        $attendance_time->type = 1;
      }

      $sbu_name = collect($company_sbus)->where('id', $value->employee_sbu)->first();
      $WorkLocations = collect($WorkLocation)->where('id', $value->employee_work_location)->first();
      $section_name = collect($employee_section)->where('id', $value->employee_section)->first();
      $department_name = collect($employee_department)->where('id', $value->employee_department)->first();
      $designation_name = collect($employee_designation)->where('id', $value->employee_designation)->first();
      $sub_section_name = collect($employee_sub_unit)->where('id', $value->employee_sub_unit)->first();


      $indLeaveInfo = collect($indLeaveInfo1)->where('employee_id', $value->id)->toArray();
      $ind_leave_info = array();
      if ($indLeaveInfo) {
        foreach ($indLeaveInfo as $key => $value_a) {
          $period_live = CarbonPeriod::create($value_a->leave_from_date, $value_a->leave_to_date);
          foreach ($period_live as $date) {
            array_push($ind_leave_info, $date->format('Y-m-d'));
          }
        }
      }

      // exit();
      $intime = collect(collect($attendance_data)->where('TransactionDate', $from_date_formated)->where('employee_id', $value->employee_id_no)->sortBy('id')->values()->all())->first();
      $outtime = collect(collect($attendance_data)->where('TransactionDate', $from_date_formated)->where('employee_id', $value->employee_id_no)->sortByDesc('id')->values()->all())->first();
      $manulAttendances = collect($manulAttendance)->where('manual_attendance_date', $from_date_formated)->where('employee_id_no', $value->employee_id_no)->first();
      $office_start_time = isset($attendance_time->office_start_time) ? $attendance_time->office_start_time : '00:00:00';
      if (isset($attendance_time->attendance_office_time)) {
        $attendance_shift_id = ['id' => $attendance_time->attendance_office_time, 'text' => $attendance_time->title];
        $attendance_shift_setup_id = $attendance_time->id;
      } else {
        $attendance_shift_id = 0;
        $attendance_shift_setup_id = 0;
      }

      $office_end_time = isset($attendance_time->office_end_time) ? $attendance_time->office_end_time : '00:00:00';

      if (!empty($attendance_time)) {


        if (!empty($manulAttendances)) {
          $intimes = $manulAttendances->manual_start_time;
          $outtimes = $manulAttendances->manual_end_time;

          // if(!empty($attendance_time->lateConsiderTime)){
          //      $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
          //  }else{
          //      $lateConsiderTime=strtotime($office_start_time);
          //  }
          if (!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) !=  date('H:i', strtotime('00:00:00'))) {
            $lateConsiderTime = date('H:i', strtotime($attendance_time->lateConsiderTime));
          } else {
            $lateConsiderTime = date('H:i', strtotime($office_start_time));
          }

          if (strtotime($intimes) <=  strtotime($lateConsiderTime)) {
            $late_time = '00:00';
            $status = "P";
            $statusId = 1;
            $remarks = "";
          } else {
            if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
              $late_time = strtotime($intimes) - strtotime($office_start_time);
              $late_time = date('H:i', $late_time);
              $status = "L(A)";
              $statusId = 1;
              $remarks = "Late Approved";
            } else {
              $late_time = strtotime($intimes) - strtotime($office_start_time);
              $late_time = date('H:i', $late_time);
              $status = "L";
              $statusId = 2;
              $remarks = "";
            }
          }

          $work_time = strtotime($outtimes) - strtotime($intimes);
          $attendances = [
            "employee_id_no" => $value['employee_id_no'],
            "employee_full_name" => $value['employee_full_name'],
            "sub_section_name" => isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : '',
            "designation_name" => isset($designation_name['designation_name']) ? $designation_name['designation_name'] : '',
            "department_name" => isset($department_name['department_name']) ? $department_name['department_name'] : '',
            "section_name" => isset($section_name['section_name']) ? $section_name['section_name'] : '',
            "sbu_name" => isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : '',
            "employee_work_location" => isset($WorkLocations['work_location_name']) ? $WorkLocations['work_location_name'] : '',
            "machineno" => 0,
            "uploadid" => 0,
            "employee_id" => $value->id,
            "employee_card_no" => $value->employee_id_no,
            "pdate" => $from_date_formated,
            "in_time" => date('h:i A', strtotime($intimes)),
            "out_time" => date('h:i A', strtotime($outtimes)),
            "late" => $late_time,
            "start_time" => date('h:i A', strtotime($office_start_time)),
            "end_time" => date('h:i A', strtotime($office_end_time)),
            "pstatus" => $statusId,
            "status" => $status,
            "remarks" => $remarks,
            "shift_time" => date('h:i A', strtotime($office_start_time)) . " - " . date('h:i A', strtotime($office_end_time)),
            "shift_id" => $attendance_shift_id,
            "attendance_shift_setup_id" => $attendance_shift_setup_id,
            "shift_is_change" => 0,
          ];
        } else if ($attendance_time->type == 2) {

          if (!empty($intime) && !empty($outtime)) {
            $intimes = $intime->TransactionTime;
            $outtimes = $outtime->TransactionTime;
            $late_time = '00:00';
            if ($attendance_time->office_type == 2) {
              $status = "W";
              $statusId = 1;
              $remarks = "";
              $late_time = '00:00';
            } else {
              // if(!empty($attendance_time->lateConsiderTime)){
              //     $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
              // }else{
              //     $lateConsiderTime=strtotime($office_start_time);
              // }
              $late_time = '00:00';
              if (!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) !=  date('H:i', strtotime('00:00:00'))) {
                $lateConsiderTime = date('H:i', strtotime($attendance_time->lateConsiderTime));
              } else {
                $lateConsiderTime = date('H:i', strtotime($office_start_time));
              }

              if (strtotime($intimes) <=  strtotime($lateConsiderTime)) {
                $late_time = '00:00';
                $status = "P";
                $statusId = 1;
                $remarks = "";
              } else {
                if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
                  $late_time = strtotime($intimes) - strtotime($office_start_time);
                  $late_time = date('H:i', $late_time);
                  $status = "L(A)";
                  $statusId = 1;
                  $remarks = "Late Approved";
                } else {
                  $late_time = strtotime($intimes) - strtotime($office_start_time);
                  $late_time = date('H:i', $late_time);
                  $status = "L";
                  $statusId = 2;
                  $remarks = "";
                }
              }
            }
            $work_time = strtotime($outtimes) - strtotime($intimes);

            // return $ $late_time;
            
            $attendances = [
              "employee_id_no" => $value['employee_id_no'],
              "employee_full_name" => $value['employee_full_name'],
              "sub_section_name" => isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : '',
              "designation_name" => isset($designation_name['designation_name']) ? $designation_name['designation_name'] : '',
              "department_name" => isset($department_name['department_name']) ? $department_name['department_name'] : '',
              "section_name" => isset($section_name['section_name']) ? $section_name['section_name'] : '',
              "sbu_name" => isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : '',
              "employee_work_location" => isset($WorkLocations['work_location_name']) ? $WorkLocations['work_location_name'] : '',
              "machineno" => 0,
              "uploadid" => 0,
              "employee_id" => $value->id,
              "employee_card_no" => $value->employee_id_no,
              "pdate" => $from_date_formated,
              "in_time" => date('h:i A', strtotime($intimes)),
              "out_time" => date('h:i A', strtotime($outtimes)),
              "late" => $late_time,
              "start_time" => date('h:i A', strtotime($office_start_time)),
              "end_time" => date('h:i A', strtotime($office_end_time)),
              "pstatus" => $statusId,
              "status" => $status,
              "remarks" => $remarks,
              "shift_time" => date('h:i A', strtotime($office_start_time)) . " - " . date('h:i A', strtotime($office_end_time)),
              "shift_id" => $attendance_shift_id,
              "attendance_shift_setup_id" => $attendance_shift_setup_id,
              "shift_is_change" => 0,
            ];
          } else {
            if ($attendance_time['office_type'] == 2) {
              $status = "W";
              $statusId = 4;
              $remarks = "";
            } elseif (!empty($holiday_find) && in_array($from_date_formated, $holiday_find)) {
              $status = "H";
              $statusId = 5;
              $remarks = "";
            } elseif (!empty($ind_leave_info) && in_array($from_date_formated, $ind_leave_info)) {
              $laveType = collect($indLeaveInfo)->where('leave_from_date', '<=', $from_date_formated)->where('leave_to_date', '>=', $from_date_formated)->first();
              $status = $laveType->leave_short_type;
              $statusId = 6;
              $remarks = "";
            } else {
              $status = "A";
              $statusId = 3;
              $remarks = "";
            }

            $attendances = [
              "employee_id_no" => $value['employee_id_no'],
              "employee_full_name" => $value['employee_full_name'],
              "sub_section_name" => isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : '',
              "designation_name" => isset($designation_name['designation_name']) ? $designation_name['designation_name'] : '',
              "department_name" => isset($department_name['department_name']) ? $department_name['department_name'] : '',
              "section_name" => isset($section_name['section_name']) ? $section_name['section_name'] : '',
              "sbu_name" => isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : '',
              "employee_work_location" => isset($WorkLocations['work_location_name']) ? $WorkLocations['work_location_name'] : '',
              "machineno" => 0,
              "uploadid" => 0,
              "employee_id" => $value->id,
              "employee_card_no" => $value->employee_id_no,
              "pdate" => $from_date_formated,
              "in_time" => '00:00',
              "out_time" => '00:00',
              "late" => '00:00',
              "start_time" => date('h:i A', strtotime($office_start_time)),
              "end_time" => date('h:i A', strtotime($office_end_time)),
              "pstatus" => $statusId,
              "status" => $status,
              "remarks" => $remarks,
              "shift_time" => date('h:i A', strtotime($office_start_time)) . " - " . date('h:i A', strtotime($office_end_time)),
              "shift_id" => $attendance_shift_id,
              "attendance_shift_setup_id" => $attendance_shift_setup_id,
              "shift_is_change" => 0,
            ];
          }
        } else {

          if (!empty($intime) && !empty($outtime)) {
            $intimes = $intime->TransactionTime;
            $outtimes = $outtime->TransactionTime;
            $late_time = '00:00';
            if (in_array(date('D', strtotime($from_date_formated)), $weekend)) {
              $status = "W";
              $statusId = 1;
              $remarks = "";
            } else {
              //  if(!empty($attendance_time->lateConsiderTime)){
              //     $lateConsiderTime=date('H:i', strtotime($attendance_time->lateConsiderTime));
              // }else{
              //     $lateConsiderTime=strtotime($office_start_time);
              // }
              $late_time = '00:00';
              if (!empty($attendance_time->lateConsiderTime) && date('H:i', strtotime($attendance_time->lateConsiderTime)) !=  date('H:i', strtotime('00:00:00'))) {
                $lateConsiderTime = date('H:i', strtotime($attendance_time->lateConsiderTime));
              } else {
                $lateConsiderTime = date('H:i', strtotime($office_start_time));
              }
              // echo"<pre>";
              // print_r(strtotime($intimes));
              // echo"<pre>";
              // print_r(strtotime($lateConsiderTime));

              if (strtotime($intimes) <=  strtotime($lateConsiderTime)) {
                $late_time = '00:00';
                $status = "P";
                $statusId = 1;
                $remarks = "";
              } else {
                if (!empty($approve_late_find) && in_array($from_date_formated, $approve_late_find)) {
                  $late_time = strtotime($intimes) - strtotime($office_start_time);
                  $late_time = date('H:i', $late_time);
                  $status = "L(A)";
                  $statusId = 1;
                  $remarks = "Late Approved";
                } else {
                  $late_time = strtotime($intimes) - strtotime($office_start_time);
                  $late_time = date('H:i', $late_time);
                  $status = "L";
                  $statusId = 2;
                  $remarks = "";
                }
              }
            }
            $work_time = strtotime($outtimes) - strtotime($intimes);

            $attendances = [
              "employee_id_no" => $value['employee_id_no'],
              "employee_full_name" => $value['employee_full_name'],
              "sub_section_name" => isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : '',
              "designation_name" => isset($designation_name['designation_name']) ? $designation_name['designation_name'] : '',
              "department_name" => isset($department_name['department_name']) ? $department_name['department_name'] : '',
              "section_name" => isset($section_name['section_name']) ? $section_name['section_name'] : '',
              "sbu_name" => isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : '',
              "employee_work_location" => isset($WorkLocations['work_location_name']) ? $WorkLocations['work_location_name'] : '',
              "machineno" => 0,
              "uploadid" => 0,
              "employee_id" => $value->id,
              "employee_card_no" => $value->employee_id_no,
              "pdate" => $from_date_formated,
              "in_time" => date('h:i A', strtotime($intimes)),
              "out_time" => date('h:i A', strtotime($outtimes)),
              "late" => $late_time,
              "start_time" => date('h:i A', strtotime($office_start_time)),
              "end_time" => date('h:i A', strtotime($office_end_time)),
              "pstatus" => $statusId,
              "status" => $status,
              "remarks" => $remarks,
              "shift_time" => date('h:i A', strtotime($office_start_time)) . " - " . date('h:i A', strtotime($office_end_time)),
              "shift_id" => $attendance_shift_id,
              "attendance_shift_setup_id" => $attendance_shift_setup_id,
              "shift_is_change" => 0,
            ];
          } else {
            // return $ind_leave_info;
            // print_r($ind_leave_info);
            if ((in_array(date('D', strtotime($from_date_formated)), $weekend))) {
              $status = "W";
              $statusId = 4;
              $remarks = "";
            } elseif (!empty($holiday_find) && in_array($from_date_formated, $holiday_find)) {
              $status = "H";
              $statusId = 5;
              $remarks = "";
            } elseif (!empty($ind_leave_info) && in_array($from_date_formated, $ind_leave_info)) {
              $laveType = collect($indLeaveInfo)->where('leave_from_date', '<=', $from_date_formated)->where('leave_to_date', '>=', $from_date_formated)->first();
              $status = $laveType->leave_short_type;
              $statusId = 6;
              $remarks = "";
            } else {
              $status = "A";
              $statusId = 3;
              $remarks = "";
            }
            //      $all_data[$key]['shift_time'] ='09:00-18:00';
            // $all_data[$key]['in_time'] ='00:00';
            // $all_data[$key]['out_time'] ='00:00';
            // $all_data[$key]['late'] ='00:00';
            // $all_data[$key]['status'] = '';
            // $all_data[$key]['remarks'] ='Office Time not Set';

            $attendances = [
              "employee_id_no" => $value['employee_id_no'],
              "employee_full_name" => $value['employee_full_name'],
              "sub_section_name" => isset($sub_section_name['sub_section_name']) ? $sub_section_name['sub_section_name'] : '',
              "designation_name" => isset($designation_name['designation_name']) ? $designation_name['designation_name'] : '',
              "department_name" => isset($department_name['department_name']) ? $department_name['department_name'] : '',
              "section_name" => isset($section_name['section_name']) ? $section_name['section_name'] : '',
              "sbu_name" => isset($sbu_name['sbu_name']) ? $sbu_name['sbu_name'] : '',
              "employee_work_location" => isset($WorkLocations['work_location_name']) ? $WorkLocations['work_location_name'] : '',
              "machineno" => 0,
              "uploadid" => 0,
              "employee_id" => $value->id,
              "employee_card_no" => $value->employee_id_no,
              "pdate" => $from_date_formated,
              "in_time" => '00:00',
              "out_time" => '00:00',
              "late" => '00:00',
              "start_time" => date('h:i A', strtotime($office_start_time)),
              "end_time" => date('h:i A', strtotime($office_end_time)),
              "pstatus" => $statusId,
              "status" => $status,
              "remarks" => $remarks,
              "shift_time" => date('h:i A', strtotime($office_start_time)) . " - " . date('h:i A', strtotime($office_end_time)),
              "shift_id" => $attendance_shift_id,
              "attendance_shift_setup_id" => $attendance_shift_setup_id,
              "shift_is_change" => 0,
            ];
          }
        }
      }
      $attendance_dataNew[] = $attendances;
    }

    // echo "<pre>";
    // print_r($attendance_dataNew);
    // exit();
    $date_report = date("d M,Y", strtotime($from_date_formated));

    $company_id = $employee_sbu;
    $created_by = Auth::guard('user')->user()->name;
    if (!empty($search_option['att_status'])) {
      $att_types = '';
      // if ($search_option['att_status']==1) {
      //   $att_types=$att_types.',Present';
      // }else if ($search_option['att_status']==2) {
      //   $att_types=$att_types.', Late';
      // }else if ($search_option['att_status']==6) {
      //   $att_types=$att_types.', Leave';
      // }else if ($search_option['att_status']==3) {
      //   $att_types=$att_types.', Absent';
      // }

      foreach ($search_option['att_status'] as  $value) {
        if ($value == 1) {
          $att_types = $att_types . 'Present';
        } else if ($value == 2) {
          $att_types = $att_types . ', Late';
        } else if ($value == 6) {
          $att_types = $att_types . ', Leave';
        } else if ($value == 3) {
          $att_types = $att_types . ', Absent';
        }
      }
      $report_name = "Daily Attendance [ " . $att_types . " ] Report";
      $all_data = collect($attendance_dataNew)->whereIn('pstatus', $search_option['att_status'])->toArray();
    } else {
      $report_name = "Daily Attendance Report";
      $all_data = $attendance_dataNew;
    }

    // $this->reportMail($company_id,$company_sbus,$sbuNames,$report_name,$date_report,$created_by,$column_name_data,$all_data,$column_data);

    // return $table;
    return response()->json($all_data);

    // return view('layouts.report',compact('all_data','column_data','column_name_data','date_report','company_id','company_sbus','created_by','report_name'));

  }
  public function shift_update(Request $request)
  {
    DB::beginTransaction();

    try {
      foreach ($request->shift_data as $key => $value) {
        if ($value['shift_is_change'] == 1 && $value['attendance_shift_setup_id'] != 0) {
          $update_shift_id = $value['shift_id']['id'];
          $shift_update = AttendanceSetup::where('id', $value['attendance_shift_setup_id'])->update(['attendance_office_time' => $update_shift_id]);
        } elseif ($value['shift_is_change'] == 1 && $value['attendance_shift_setup_id'] == 0) {

          $update_shift_id = $value['shift_id']['id'];
          $insert_array = [
            // "emp_name"=>$emp_name,
            "employee_id" => $value['employee_id'],
            // "employee_id_no"=>$emp_id_no,
            "start_date" => $value['pdate'],
            "end_date" => $value['pdate'],
            "attendance_office_time" => $update_shift_id,
            "attendance_setup_status" => 1,
            "attendance_type" => 1,
            "attendance_category" => 1,
            "attendance_machine_no" => 4,
            "project_id" => Auth::guard('user')->user()->project_id,
            "branch_id" => Auth::guard('user')->user()->branch_id,
            "created_by" => Auth::guard('user')->user()->id,
            "created_by" => date('Y-m-d H:i:s'),
          ];
          $rr = AttendanceSetup::insert($insert_array);
          // dd($rr);
        }
      }
      DB::commit();
      // all good
    } catch (\Exception $e) {
      DB::rollback();
      // something went wrong
      $message = ['status' => 0, 'message' => 'Sorry'];
      return response($message);
    }
    $message = ['status' => 1, 'message' => 'Successfully Updated!'];
    return response($message);
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

  // public function create(){
  //     $data['employee_data']=array();
  //     $employee_data=Employee::valid()->project()->get();
  //     foreach ($employee_data as $value) {
  //       array_push($data['employee_data'],['id'=>$value['id'],'text'=>$value['employee_fullname']]);
  //     }
  //     return response($data);
  // }

  // public function findDepartmentMaxCode(){
  //   $last_entry_data=OfficeTimeSetup::latest()->first();
  //   $department_last_code = $last_entry_data['department_code'];
  //   if ($department_last_code==0) {
  //     $department_last_code = 101;
  //   }else{
  //     $department_last_code = $department_last_code+1;
  //   }
  //   return $department_last_code;
  // }


}
