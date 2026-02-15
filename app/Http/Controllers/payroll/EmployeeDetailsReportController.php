<?php
namespace App\Http\Controllers\payroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Employee;
use App\Model\EmployeeGroup;
use App\Model\Designation;
use App\Model\JobGrade;
use App\Model\EmployeeApproval;
use App\Model\OfficeTimeSetup;
use App\Model\DistrictModel;
use App\Model\EmployeeEducationalQualification;
use DateTime;
use DB;
class EmployeeDetailsReportController extends Controller
{
  public function index(Request $request)
  {
    // return response($request);
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
    $data['district_data'] = array();
    $district_data = DistrictModel::orderBy('name', 'ASC')->get();
    array_push($data['district_data'], ['id' => '', 'text' => 'All Select']);
    foreach ($district_data as $value) {
      array_push($data['district_data'], ['id' => $value['id'], 'text' => $value['name'] . ' - ' . $value['bn_name']]);
    }

    $data['approval_infos'] = EmployeeApproval::valid()->project()->get();
    // $data['approval_infos']=EmployeeApproval::valid()->project()->where('ea_employee_id',$id)->get();
    // $data['from_date'] = date('Y-m-d');
    $data['employee_status'] = 1;
    return response($data);
  }


  public function empploy_info_payroll_report(Request $request){
    // return response($request);
    $from_date = isset(request()->from_date) ? request()->from_date : '';
    $to_date = isset(request()->to_date) ? request()->to_date : '';
    $strDate1 = substr($from_date, 4, 11);
    $strDate2 = substr($to_date, 4, 11);
    $search_option['from_date_formated'] = $from_date_formated = date('Y-m-d', strtotime($strDate1));
    $search_option['to_date_formated'] = $to_date_formated = date('Y-m-d', strtotime($strDate2));
    $search_option['employee_id'] = $employee_id = collect($request->designation_name_value)->where('id', '!=', '')->pluck('id')->toArray();
    $search_option['employee_ids'] = $employee_ids = request()->employee_id;
    $search_option['employee_status'] = $employee_status = request()->employee_status;
    // request()->employee_id;
    $date_print['from_date_formated'] = $from_date_formated;
    $search_option['checkedattcolsadd'] = $checkedattcolsadd = $request->checkedattcolsadd;
    $search_option['report_type'] = $report_type = $request->report_type;
    $search_option['att_report_type'] = $att_report_type = $request->att_report_type;
    $search_option['employee_sbu'] = $employee_sbu = collect($request['sbu_name_value'])->where('id', '!=', '')->pluck('id')->toArray();
    // return response($employee_sbu);
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

    $employee_data_info=Employee::valid()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('salaries', 'salaries.employee_id', '=', 'employees.id')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('sub_sections', 'sub_sections.id', '=', 'employees.employee_sub_section')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
      ->leftjoin('employee_personal_infos','employees.id','=','employee_personal_infos.employee_id')
      ->leftjoin('employee_adress_details','employees.id','=','employee_adress_details.ead_employee_id')
      ->leftjoin('employee_educational_qualifications','employees.id','=','employee_educational_qualifications.eeq_employee_id')
      ->leftjoin('employee_identification_supportings','employees.id','=','employee_identification_supportings.eis_employee_id')
      ->leftjoin('districts','employee_adress_details.permanent_district','=','districts.id')
      ->select(
          'employees.*',
          'designations.designation_name',
          'departments.department_name',
          'sections.section_name',
          'sub_sections.sub_section_name',
          'work_locations.work_location_name',
          'company_sbus.sbu_name',
          'job_grades.jobgrade_name',
          'employee_adress_details.*',
          'employee_adress_details.id as ead_id',
          'employee_personal_infos.employee_nick_name',
          'employee_personal_infos.employee_dob_actual',
          'employee_personal_infos.employee_dob_certificate',
          'employee_personal_infos.employee_gender',
          'employee_personal_infos.employee_blood_group',
          
          'employee_educational_qualifications.eeq_degree_name',
          'employee_identification_supportings.nid_number',
          'employee_identification_supportings.passport_number',
          'districts.name as district_name','salaries.gross_salary'
      )
      ->whereIn('employees.employee_sbu', $employee_sbu);
      // DB::raw('SUM(salaries.gross_salary) AS gross_salary',
    // if ($search_option['from_date_formated'] && $search_option['to_date_formated']) {
    //   $employee_data_info->whereDate('employees.employee_joining_date', '>=', $search_option['from_date_formated']);
    //   $employee_data_info->whereDate('employees.employee_joining_date', '<=', $search_option['to_date_formated']);
    // }    
    if (!empty($unit)) {
      $employee_data_info->whereIn('employees.employee_unit',$unit);
    }
    if (!empty($sub_unit)) {
      $employee_data_info->whereIn('employees.sub_unit',$sub_unit);
    }
    if (!empty($employee_section)) {
      $employee_data_info->whereIn('employees.employee_section',$employee_section);
    }
    if (!empty($employee_sub_section)) {
      $employee_data_info->whereIn('employees.employee_sub_section',$employee_sub_section);
    }
    if (!empty($employee_department)) {
      $employee_data_info->whereIn('employees.employee_department',$employee_department);
    }
    if (!empty($employee_designation)) {
      $employee_data_info->whereIn('employees.employee_designation',$employee_designation);
    }
    if (!empty($employee_work_location)) {
      $employee_data_info->whereIn('employees.employee_work_location',$employee_work_location);
    }
    if (!empty($employee_status)) {
      $employee_data_info->where('employees.employee_status',$employee_status);
    }
    // if ($request['employee_status']==1 || $request['employee_status']==2) {
    //   $employee_data_info->where('employees.employee_status',$request['employee_status']);
    // }
    // if ($request['employee_status']==0) {
    //   $employee_data_info->where('employees.employee_status',$request['employee_status']);
    // }
    $data['employee_info_payroll'] = $employee_data_info->groupBy('salaries.employee_id')->orderBy('designations.priority')->get();
    // return response($data);
    $collect_employee_id = collect($data['employee_info_payroll'])->pluck('id')->toArray();
    $find_employee_reporting = Employee::whereIn('id',$collect_employee_id)->get();
    $find_employee_education = EmployeeEducationalQualification::whereIn('eeq_employee_id',$collect_employee_id)->where('eeq_highest_education', 1)->get();
    foreach ($data['employee_info_payroll'] as $key => $value) {
      $reporting_to_id = collect($find_employee_reporting)->where('id',$value->id)->pluck('employee_reporting_to')->first();
      $find_reporting_boss = Employee::where('employee_id_no',$reporting_to_id)->first();

      $employee_highest_education = collect($find_employee_education)->where('eeq_employee_id',$value->id)->first();
      // return response($employee_highest_education);
      // $data['employee_info_payroll'][$key]['employee_reporting_to'] = $employee_reporting_to['employee_fullname'];
       
      $employee_dob = isset($value['employee_dob_actual'])?$value['employee_dob_actual']:'';
      if (empty($employee_dob) || $employee_dob=='0000-00-00') {
        $employee_dob = isset($value['employee_dob_certificate'])?$value['employee_dob_certificate']:'';
        if ($employee_dob==0 || $employee_dob=='0000-00-00') {
          $employee_dob = '';
        }
      }
      $employee_dob1 = strtotime($employee_dob);
      if ($employee_dob1) {
        $bday = new DateTime($employee_dob);
        $today = new Datetime(date('Y-m-d'));
        $diff = $today->diff($bday);
        $dobdate = date_create($employee_dob);
        $employee_dobs= date_format($dobdate, 'd-M-Y');
        if($diff->y==0 || $diff->y==''){
          $birthDates=$diff->m.'m '. $diff->d .'d';
        }else{
          $birthDates=$diff->y.'.'. $diff->m;
        }
        $birthDates1=$diff->y;
      }else{
        $birthDates='No Data!';
        $birthDates1=0;
      }
      $employee_age=$birthDates;
      $employee_age1=(int)$birthDates1;
      $employee_joining_date = isset($value['employee_joining_date'])?$value['employee_joining_date']:'';
      if (empty($employee_joining_date) || $employee_joining_date=='0000-00-00') {
        $employeoJoining = isset($value['employee_joining_date'])?$value['employee_joining_date']:'';
        if ($employeoJoining==0 || $employeoJoining=='0000-00-00') {
          $employeoJoining = '';
        }
      }
      $employeoJoining=$employee_joining_date;
      $employeoJoining1 = strtotime($employee_joining_date);
      $date2 = date('Y-m-d');
      if ($employeoJoining1) {
        $Joining = new DateTime($employeoJoining);
        $today = new Datetime(date('Y-m-d'));
        $diff = $today->diff($Joining);
        $JoiningDates=$diff->y.'.'. $diff->m;
        $JoiningDates1=$diff->y;
      }else{
        $JoiningDates='No Data!';
        $JoiningDates1=0;
      }
      $service_length=$JoiningDates;
      $service_length1=$JoiningDates1;

      $joining_date = isset($value['employee_joining_date']) ? $value['employee_joining_date'] : '';
      if (empty($joining_date) || $joining_date=='0000-00-00') {
        $Joining = 'Not Available';
      }else{
        $date = date_create($joining_date);
        $Joining =  date_format($date, 'd-M-Y');
      }

      if($value['employee_status'] == '1'){
        $data['employee_status'] = 'Active';
        $color = 'green';
      }elseif($value['employee_status'] == '0'){
          $data['employee_status'] = 'Inactive';
          $color = 'red';
      }elseif($value['employee_status'] == '2'){
          $data['employee_status'] = 'Resigned';
          $color = '#dddddd';
      }else{
          $data['employee_status'] = '';
          $color = '';
      }

      if($value['employee_gender'] == '1'){
        $data['employee_gender'] = 'Female';
        $color = 'green';
      }elseif($value['employee_gender'] == '0'){
          $data['employee_gender'] = 'Others';
          $color = 'red';
      }elseif($value['employee_gender'] == '2'){
          $data['employee_gender'] = 'Male';
          $color = '#dddddd';
      }else{
          $data['employee_gender'] = '';
          $color = '';
      }
      if($value['emplyee_category_mgt_non_mgt'] == '1'){
        $data['emplyee_category_mgt_non_mgt'] = 'Management';
        $color = 'green';
      }elseif($value['emplyee_category_mgt_non_mgt'] == '2'){
          $data['emplyee_category_mgt_non_mgt'] = 'Non-Management';
          $color = '#dddddd';
      }else{
          $data['emplyee_category_mgt_non_mgt'] = '';
          $color = '';
      }

      $official_mobile = isset($value['employee_mobile']) ? $value['employee_mobile'] : '';
      if (!empty($official_mobile)) {
          $data['mobile_no'] = $official_mobile;
      } else {
          $data['mobile_no'] = isset($value['employee_mobile']) ? $value['employee_mobile'] : 'Not Found!';
      }

      $data['employee_infos'][$key]['employee_id_no'] = isset($value['employee_id_no'])?$value['employee_id_no']:'';
      $data['employee_infos'][$key]['eeq_degree_name'] = isset($employee_highest_education['eeq_degree_name'])?$employee_highest_education['eeq_degree_name']:'';
      
      $data['employee_infos'][$key]['section_name'] = isset($value['section_name'])?$value['section_name']:'';
      $data['employee_infos'][$key]['sub_section_name'] = isset($value['sub_section_name'])?$value['sub_section_name']:'';
      $data['employee_infos'][$key]['employee_fullname'] = isset($value['employee_fullname'])?$value['employee_fullname']:'';
      $data['employee_infos'][$key]['designation_name'] = isset($value['designation_name'])?$value['designation_name']:'';
      $data['employee_infos'][$key]['department_name'] = isset($value['department_name'])?$value['department_name']:'';
      $data['employee_infos'][$key]['work_location_name'] = isset($value['work_location_name'])?$value['work_location_name']:'';
      $data['employee_infos'][$key]['sbu_name'] = isset($value['sbu_name'])?$value['sbu_name']:'';
      $data['employee_infos'][$key]['gross_salary'] = isset($value['gross_salary'])?$value['gross_salary']:'';
      $data['employee_infos'][$key]['employee_nick_name'] = isset($value['employee_nick_name'])?$value['employee_nick_name']:'';
      // $data['employee_infos'][$key]['eeq_degree_name'] = isset($value['eeq_degree_name'])?$value['eeq_degree_name']:'';
      $data['employee_infos'][$key]['employee_joining_date'] = isset($Joining)?$Joining:'';
      $data['employee_infos'][$key]['service_length'] = isset($service_length)?$service_length:'';
      $data['employee_infos'][$key]['employee_dob'] = isset($employee_dobs)?$employee_dobs:'';
      $data['employee_infos'][$key]['employee_age'] = isset($employee_age)?$employee_age:'';
      $data['employee_infos'][$key]['jobgrade_name'] = isset($value['jobgrade_name'])?$value['jobgrade_name']:'';
      $data['employee_infos'][$key]['insurance_amount'] = isset( $value['insurance_amount'])?$value['insurance_amount']:0;
      $data['employee_infos'][$key]['yearly_premium_cost'] = isset($value['yearly_premium_cost'])?$value['yearly_premium_cost']:0;
      $data['employee_infos'][$key]['employee_sbu'] = isset($value['sbu_name'])?$value['sbu_name']:'';
      $data['employee_infos'][$key]['employee_status'] = isset($data['employee_status'])?$data['employee_status']:'';
      $data['employee_infos'][$key]['mobile_no'] = isset($data['mobile_no'])?$data['mobile_no']:'';
      $data['employee_infos'][$key]['employee_gender'] = isset($data['employee_gender'])?$data['employee_gender']:'';
      $data['employee_infos'][$key]['nid_number'] = isset($value['nid_number'])?$value['nid_number']:'';
      $data['employee_infos'][$key]['passport_number'] = isset($value['passport_number'])?$value['passport_number']:'';
      $data['employee_infos'][$key]['employee_blood_group'] = isset($value['employee_blood_group'])?$value['employee_blood_group']:'';
      
      $data['employee_infos'][$key]['emplyee_category_mgt_non_mgt'] = isset($data['emplyee_category_mgt_non_mgt'])?$data['emplyee_category_mgt_non_mgt']:'';
      $data['employee_infos'][$key]['district_name'] = isset($value['district_name'])?$value['district_name']:'';
      $data['employee_infos'][$key]['reporting_to'] = isset($find_reporting_boss['employee_fullname'])?$find_reporting_boss['employee_fullname']:'';
      $data['employee_infos'][$key]['reporting_to_id'] = isset($find_reporting_boss['employee_id_no'])?$find_reporting_boss['employee_id_no']:'';
      $data['employee_infos'][$key]['permanent_holding_no'] = isset($value['permanent_holding_no'])?$value['permanent_holding_no']:'';
      $data['employee_infos'][$key]['permanent_house_name'] = isset($value['permanent_house_name'])?$value['permanent_house_name']:'';
      $data['employee_infos'][$key]['permanent_road_no'] = isset($value['permanent_road_no'])?$value['permanent_road_no']:'';
      $data['employee_infos'][$key]['permanent_road_name'] = isset($value['permanent_road_name'])?$value['permanent_road_name']:'';
      $data['employee_infos'][$key]['permanent_vill_area'] = isset($value['permanent_vill_area'])?$value['permanent_vill_area']:'';
      $data['employee_infos'][$key]['permanent_post_office'] = isset($value['permanent_post_office'])?$value['permanent_post_office']:'';
      $data['employee_infos'][$key]['permanent_thana'] = isset($value['permanent_thana'])?$value['permanent_thana']:'';
      $data['employee_infos'][$key]['present_holding_no'] = isset($value['present_holding_no'])?$value['present_holding_no']:'';
      $data['employee_infos'][$key]['present_house_name'] = isset($value['present_house_name'])?$value['present_house_name']:'';
      $data['employee_infos'][$key]['present_road_no'] = isset($value['present_road_no'])?$value['present_road_no']:'';
      $data['employee_infos'][$key]['present_road_name'] = isset($value['present_road_name'])?$value['present_road_name']:'';
    }
    $data['report_hade']['report_print_date'] =  date('d F Y');
    $data['report_hade']['sbu_name'] = collect($request['sbu_name_value'])->where('id', '!=', '')->pluck('text')->first();

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
    return response($data);
  }





}
