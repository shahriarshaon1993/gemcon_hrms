<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\JobGrade;
use App\Model\Employee;
use App\Model\Designation;
use App\Model\InsuranceEligible;
use App\Model\EmployeeGroup;
use App\Model\CompanySbu;
use Auth;
use Session;
use Cache;
use DateTime;
use DB;
// use App\Model\UserRoleAccess;

class InsuranceController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function insurance_eligible_list(Request $request){
  $paginate_num = $request->input('paginate_num');
  $search_key = $request->input('search_key');
  if ($request->input('sort') =='id') {
    $order = 'ASC';
    $sort = 'designations.priority';
  } else {
    $order = $request->input('order');
    $sort = $request->input('sort');
  }
  // $employee_list = new Employee();
  // $employee_ids=$employee_list->Employee_id();
  $cache = Cache::get('permission');
  $permission = collect($cache)->where('menu_uid','=','InsuranceEligibleList')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
  foreach($permission as $child) {
    if($child['link_uid']=='add'){
        $data['add']=$child['link_uid'];
    }elseif($child['link_uid']=='edit'){
        $data['edit']=$child['link_uid'];
    }elseif($child['link_uid']=='delete') {
        $data['delete']=$child['link_uid'];
    }else {
        $data['approve']=$child['link_uid'];
    }
  }
  $today = date('Y-m-d');
  $paginate_data = InsuranceEligible::valid()->project()
  ->select(
    'insurance_eligible_employees.*', 
    'employees.*', 
    'employees.id as employee_id', 
    'insurance_eligible_employees.id as id', 
    'designations.designation_name',
    'departments.department_name',
    'company_sbus.sbu_name',
    'work_locations.work_location_name',
    'job_grades.jobgrade_name',
    'job_grades.insurance_amount',
    'job_grades.yearly_premium_cost',
    'employee_personal_infos.employee_dob_certificate',
    DB::raw('(DATEDIFF(NOW(), employee_joining_date))/365 as service_length'),
    DB::raw('(DATEDIFF(NOW(), employee_dob_certificate))/365 as employee_age')
  )
  ->leftJoin('employees', 'employees.id', '=', 'insurance_eligible_employees.employee_id')
  ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
  ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
  ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
  ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
  ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
  ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
  ->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('employee_id_no', 'LIKE', '%' . $search_key . '%')
      ->orWhere('employee_fullname','LIKE','%'.$search_key.'%')
      ->orWhere('designation_name','LIKE','%'.$search_key.'%')
      ->orWhere('department_name','LIKE','%'.$search_key.'%')
      ->orWhere('sbu_name','LIKE','%'.$search_key.'%')
      ->orWhere('work_location_name','LIKE','%'.$search_key.'%')
      // ->orWhere('service_length','LIKE','%'.$search_key.'%')
      // ->orWhere('employee_age','LIKE','%'.$search_key.'%')
      ->orWhere('jobgrade_name','LIKE','%'.$search_key.'%')
      ->orWhere('insurance_amount','LIKE','%'.$search_key.'%')
      ->orWhere('yearly_premium_cost','LIKE','%'.$search_key.'%');
    });
    return $query;
  })
  // ->where('employees.valid', 1)
  ->where('employees.employee_joining_date', '<=', $today)
  ->where('employees.employee_status', '=', 1)
  ->groupBy('employees.id')
  ->orderBy($sort,$order);
  $sortData=$paginate_data;
  $sortGetData=$sortData->get();
  $data['total_data']=count($sortGetData);
  $data['inactive_data']=count(collect($sortGetData)->whereIn('status', 2)->toArray());
  $data['active_data']=count(collect($sortGetData)->where('status', 1)->toArray());
  $data['paginate_data'] =$sortData->paginate($paginate_num);
  return response()->json($data);
}
public function insurance_eligible_find(Request $request)
{
  $employee_ids = Session::get('employee_ids');
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
  $data['designation_data'] = array();
  $data['jobgrade_data'] = array();
  $data['employee_status_data'] = array();
  $data['employee_data'] = array();
  $data['employee_group_data'] = array();
  $designation_data = Designation::valid()->project()->whereIn('id', $employee_ids['designation'])->orderBy('priority', 'ASC')->get();
  $jobgrade_data = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get();

  $ins_eligibel_query = InsuranceEligible::valid()->project()->select('employee_id')->get();
  $eligbilbe_employees = collect($ins_eligibel_query)->pluck('employee_id');

  $employee_data = Employee::valid()->project()
  ->select('employees.*','designations.designation_name')
  ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
  ->whereNotIn('employees.id', $eligbilbe_employees)
  ->get()->keyBy('employee_id_no')->all();
  $data['leave_type_data']=array();
  $employee_group_data = EmployeeGroup::valid()->project()->orderBy('priority', 'ASC')->get();
  array_push($data['employee_group_data'], ['id' => '', 'text' => 'All']);
  foreach ($employee_group_data as $value) {
      array_push($data['employee_group_data'], ['id' => $value['id'], 'text' => $value['employee_group_name']]);
  }
  array_push($data['designation_data'], ['id' => '', 'text' => 'All']);
  foreach ($designation_data as $value) {
      array_push($data['designation_data'], ['id' => $value['id'], 'text' => $value['designation_name']]);
  }
  array_push($data['jobgrade_data'], ['id' => '', 'text' => 'All']);
  foreach ($jobgrade_data as $value) {
    array_push($data['jobgrade_data'], ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
  }
  
  $employee_status_data = array(
    [
      'id' => '',
      'status' => 'All',
    ],
    [
      'id' => 1,
      'status' => 'Active',
    ],
    [
      'id' => 0,
      'status' => 'Inactive',
    ],
    [
      'id' => 2,
      'status' => 'Resign',
    ],
  );
  // dd($employee_status_data);
  // array_push($data['employee_status_data'], ['id' => '', 'text' => 'All']);
  foreach ($employee_status_data as $value) {
      array_push($data['employee_status_data'], ['id' => $value['id'], 'text' => $value['status']]);
  }

  array_push($data['employee_data'], ['id' => '', 'text' => 'All']);
  foreach ($employee_data as $value) {
      array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . ':' . $value['employee_fullname'] . '-' . $value['designation_name']]);
  }
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
  $data['from_date'] = '';
  $data['to_date'] = date('Y-m-d');
  $data['age_from'] = 18;
  $data['age_to'] = 60;
  $data['service_length_from'] = 0;
  $data['service_length_to'] = 46;
  $data['employee_status'] = [[ "id"=> 1, "text" => "Active" ]] ;
  $data['employee_type_value'] = '';
  $data['employee_Category_value'] = '';
  $data['insurance_eligible_type'] = 1;
  return response($data);
}

public function find_insurance_eligible_employee(Request $request){
  // dd($request);
  if($request->from_date != '' && $request->to_date != ''){
    $from_date = isset(request()->from_date) ? request()->from_date : '';
    $to_date = isset(request()->to_date) ? request()->to_date : '';
    // $strDate1 = substr($from_date, 4, 11);
    // $strDate2 = substr($to_date, 4, 11);
    $search_option['from_date_formated'] = $from_date_formated = date('Y-m-d', strtotime($from_date));
    $search_option['to_date_formated'] = $to_date_formated = date('Y-m-d', strtotime($to_date));
  }else{
    $search_option['from_date_formated'] = $from_date_formated ='';
    $search_option['to_date_formated'] = $to_date_formated =  '';
  }
  // dd( $search_option);
  $search_option['employee_id'] = $employee_id = collect($request->employee_name_value)->where('id', '!=', '')->pluck('id')->toArray();
  $search_option['employee_ids'] = $employee_ids = request()->employee_id;
  // request()->employee_id;
  $date_print['from_date_formated'] = $from_date_formated;
  // $search_option['checkedattcolsadd'] = $checkedattcolsadd = $request->checkedattcolsadd;
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
  $search_option['leave_view_type'] = $leave_view_type = $request->leave_view_type;
  $search_option['permanent_district'] = $permanent_district = collect($request->district_value)->where('id', '!=', '')->pluck('id')->toArray();
  // $request->permanent_district;
  $search_option['employee_marital_status'] = $employee_marital_status = $request->employee_marital_status;
  $search_option['employee_gender'] = $employee_gender = $request->employee_gender;
  $search_option['employee_blood_group'] = $employee_blood_group = $request->employee_blood_group;
  $search_option['att_status'] = $att_status = collect($request['AttStatus_value'])->where('id', '!=', '')->pluck('id')->toArray();

  $search_option['emplyee_category_mgt_non_mgt'] = $emplyee_category_mgt_non_mgt = collect($request->employee_Category_value)->where('id', '!=', '')->pluck('id')->toArray();
  $search_option['employee_type'] = $employee_type = collect($request->employee_type_value)->where('id', '!=', '')->pluck('id')->toArray();
  $search_option['employee_group'] = $employee_group = collect($request->employee_group_value)->where('id', '!=', '')->pluck('id')->toArray();
  $search_option['reporting_to'] = $reporting_to = collect($request->reporting_name_value)->where('id', '!=', '')->pluck('id')->toArray();
  $search_option['employee_status'] = $employee_status = collect($request->employee_status)->where('id', '!=', '')->pluck('id')->toArray();
  // $search_option['reporting_to'] = $reporting_to = $request->employee_reporting_to;
  // $search_option['employee_status'] = $employee_status = $request->employee_status;
  $search_option['insurance_eligible_type'] = $insurance_eligible_type = $request->insurance_eligible_type;

  // dd($request);
  if (!empty($search_option) && $search_option['insurance_eligible_type'] == 1) {
      return $this->insurance_eligible_employee($search_option);
  }elseif(!empty($search_option) && $search_option['insurance_eligible_type'] == 2){
      return $this->insurance_inclusion_employee($search_option);
  }elseif(!empty($search_option) && $search_option['insurance_eligible_type'] == 3){
      return $this->insurance_exclusion_employee($search_option);
  }else {
      echo "No Data Found!";
  }
}
public function insurance_exclusion_employee($search_option)
{
  $employee_sbu = [];
  // if ($search_option['employee_sbu']) {
        $employee_sbu = $search_option['employee_sbu'];
        $sbu_count = count($search_option['employee_sbu']);
        // $eligbilbe_employees = InsuranceEligible::valid()->project()->whereIn('employee_sbu', $employee_sbu)->get();

        $employee_info = Employee::valid()
          ->select('employees.*', 'employee_personal_infos.employee_mobile as p_employee_mobile','employee_personal_infos.employee_blood_group', 'employee_personal_infos.employee_dob_certificate', 'work_locations.work_location_name', 'designations.designation_name', 'company_sbus.sbu_name', 'departments.department_name',
          DB::raw('(DATEDIFF(NOW(), employee_joining_date))/365 as service_length1'),
          DB::raw('(DATEDIFF(NOW(), employee_dob_certificate))/365 as age1'),
          'insurance_eligible_employees.status',
          )
          ->leftjoin('employee_personal_infos', 'employees.id', '=', 'employee_personal_infos.employee_id')
          ->leftjoin('designations', 'employees.employee_designation', '=', 'designations.id')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
          ->leftJoin('insurance_eligible_employees', 'insurance_eligible_employees.employee_id', '=', 'employees.id')
          // ->whereNotIn('employees.id', $eligbilbe_employees)
          // ->whereIn('employee_sbu', $employee_sbu)
          // ->whereIn('employee_department', $employee_department)
          ;
        if ($search_option['employee_sbu']) {
            $employee_info->whereIn('employee_sbu', $employee_sbu);
        }
        if ($search_option['from_date_formated'] && $search_option['to_date_formated']) {
            $employee_info->whereBetween('employees.employee_joining_date', [$search_option['from_date_formated'], $search_option['to_date_formated']]);
        }
        if ($search_option['employee_department']) {
            $employee_info->whereIn('employee_department', $search_option['employee_department']);
        }
        if ($search_option['employee_designation']) {
            $employee_info->whereIn('employee_designation', $search_option['employee_designation']);
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
        if (!empty($search_option['employee_id'])) {
            $employee_info->whereIn('employees.id', $search_option['employee_id']);
        }
        if ($search_option['employee_work_location']) {
            $employee_info->whereIn('employee_work_location', $search_option['employee_work_location']);
        }
        if ($search_option['emplyee_category_mgt_non_mgt']) {
            $employee_info->whereIn('emplyee_category_mgt_non_mgt', $search_option['emplyee_category_mgt_non_mgt']);
        }
        if ($search_option['employee_type']) {
            $employee_info->whereIn('employee_type', $search_option['employee_type']);
        }
        if ($search_option['employee_group']) {
            $employee_info->whereIn('employee_group', $search_option['employee_group']);
        }
        if ($search_option['employee_job_grade']) {
            $employee_info->whereIn('employee_job_grade', $search_option['employee_job_grade']);
        }
        // dd($search_option['employee_status']);
        if (!empty($search_option['employee_status'])) {
            $employee_info->whereIn('employee_status', $search_option['employee_status']);
        }

        $employee_info1 = $employee_info->orderBy('designations.priority')->get()->toArray();
   
        //  dd($eligbilbe_employees);

        $ins_eligibel_query = InsuranceEligible::valid()->project()->select('employee_id')->get();
        $eligbilbe_employees = collect($ins_eligibel_query)->pluck('employee_id');

       //  dd($eligbilbe_employees);

        $employee_info = collect($employee_info1)->whereIn('id', $eligbilbe_employees)->toArray();


       if(!empty($eligbilbe_employees) && empty($employee_info)){
         return "<h6 style='text-align:center; color: #cd9e00'><b >No data found!</b></h6>";
       }

        $all_data = $employee_info;
        // dd($all_data);
        if (!empty($search_option['age_from']) || !empty($search_option['age_to'])) {
            if (!empty($search_option['age_from']) && !empty($search_option['age_to'])) {
                $all_data = collect($all_data)->where('age1', '!=', 0)->where('age1', '>=', $search_option['age_from'])->where('age1', '<=', $search_option['age_to'])->toArray();
            } elseif (!empty($search_option['age_from'])) {
                $all_data = collect($all_data)->where('age1', '!=', 0)->where('age1', '>=', $search_option['age_from'])->toArray();
            } elseif (!empty($search_option['age_to'])) {
                $all_data = collect($all_data)->where('age1', '!=', 0)->where('age1', '<=', $search_option['age_to'])->toArray();
            } else {
              $all_data;
            }
        }
       
        if (!empty($search_option['service_length_from']) || !empty($search_option['service_length_to'])) {
            if (!empty($search_option['service_length_from']) && !empty($search_option['service_length_to'])) {
                $all_data = collect($all_data)->where('service_length', '!=', 'No Data!')->where('service_length1', '>=', $search_option['service_length_from'])->where('service_length1', '<=', $search_option['service_length_to'])->toArray();
            } elseif (!empty($search_option['service_length_from'])) {
                $all_data = collect($all_data)->where('service_length', '!=', 'No Data!')->where('service_length1', '>=', $search_option['service_length_from'])->toArray();
            } elseif (!empty($search_option['service_length_to'])) {
                $all_data = collect($all_data)->where('service_length', '!=', 'No Data!')->where('service_length1', '<=', $search_option['service_length_to'])->toArray();
            } else {
                 $all_data;
            }
        }
        // dd([$all_data1]);
        
        // $employee_ids = collect($employee_info)->pluck('employee_id_no')->toArray();

       
        $all_data =  collect($all_data)->toArray();
        //  dd([$all_data]);
        $company_id = $search_option['employee_sbu'];
        $employeeSbu = [];
        if (!empty($search_option['employee_sbu'])) {
            $employeeSbu = $search_option['employee_sbu'];
        }
        if (!empty($employeeSbu)) {
            $company_sbus = CompanySbu::valid()->whereIn('id', $employeeSbu)->get()->toArray();
        } else {
            $company_sbus = CompanySbu::valid()->get()->toArray();
        }

        // action='". url('hrm/insurance_eligible_store')."'
        $table = "
        <form method='POST'>
        <input type='hidden' name='_token' value='".csrf_token()."' /> 
        <table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'>
            <div   class='section-to-print col-md-12'>
            <table style='width:100%'> <tr> <td style='width:20%'>
            <div class='row' style='margin-left: 21px;'>
            <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";

        if (!empty($company_id)) {
            $companyLogo1 = collect($company_sbus)->where('id', $company_id[0])->first();
            // echo "<pre>";
            // print_r($companyLogo1['sbu_name']);
            if (!empty($companyLogo1)) {
                if ($companyLogo1['sbu_logo'] != "") {
                    $url = '/company_logo/' . $companyLogo1["sbu_logo"];
                    $table .= '<img src="' . $url . '" style="width:50%;">';
                } else {
                    echo 'No Logo Found';
                }
            } else {
                echo 'No Logo Found';
            }
        } else {
            $url = '/company_logo/group_company_logo.png';
            $table .= '<img src="' . $url . '" style="width:50%;">';
        }
        $table .= " </div></td><td style='width:60%'>
  <div class='col-md-12' style='padding: 0px'>
    <h5 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h5>";
    if($sbu_count > 1){
      $table .= "<h4 class='text-center' style='margin:0px;text-align: center!important;'>" . $companyLogo1['sbu_name'] ?? '' . "</h4>";
    }  
    
        $table .= "
  </div> </td> <td style='width:20%'>
  <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
    <p style='margin-top: -7px'><strong> Created :</strong> " . Auth::guard('user')->user()->name . "</p>
    <p style='margin-top: -7px'><strong> Total :</strong> " . count($all_data) . "</p>
  </div>
  </div></td></tr></table>
        <h6 style='text-align: left; border-bottom: 1px solid #ddd; font-weight: bold; padding-left: 15px;'>Insurance Eligible List</h6>
        <table class='table table-bordered table-striped' border='0' style='width:100%'>
                  <thead>
                    <tr style='background: #eee;'>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Sl.</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>ID</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Name</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Designation</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Department</th>";
                      if($sbu_count > 1){
                        $table .= "<th class='ths' style='padding:2px 10px; text-align: center;'>SBU</th>";
                      }
                      $table .="
                      <th class='ths' style='padding:2px 10px; text-align: center;'>W. Location</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>DOJ</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>DOB</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Age(Year)</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>S. Length(Year)</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Emp. Status</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Insur. Status</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Action</th>
                    </tr>
                  </thead>";
              $i = 0;
              // csrf_token();
              foreach ($all_data as $key => $value) {
                // dd($value);
                if($value['employee_status'] == 1){
                  $emp_status = 'Active';
                }elseif($value['employee_status'] == 2){
                  $emp_status = 'Resign';
                }elseif($value['employee_status'] == 0){
                  $emp_status = 'Inactive';
                }else{
                  $emp_status = '';
                }
                if($value['status'] == 1){
                  $eligible_status = 'Eligible';
                }elseif($value['status'] == 2){
                  $eligible_status = 'Not Eligible';
                }else{
                  $eligible_status = '';
                }
                $service_length = 0;
                if (!empty($value['employee_joining_date'])) {
                    $Joining = new DateTime($value['employee_joining_date']);
                    $today = new Datetime(date('Y-m-d'));
                    $diff = $today->diff($Joining);
                    $service_length = round((float)($diff->days)/365, 1);
                }
                $i++;
                $table .= "<tr class='body_td ths'>
                      <input name='employee_id[]' type='hidden' value='".$value['id']."'>
                      <td style='text-align: center;'>" . $i . "</td>
                      <td class='text-center ths'>" . $value['employee_id_no'] . "</td>
                      <td >" . $value['employee_fullname'] . "</td>
                      <td >" . $value['designation_name'] . "</td>
                      <td >" . $value['department_name'] . "</td>";
                      if($sbu_count > 1){
                        $table .= "<td >" . $value['sbu_name'] . "</td>";
                      }
                $table .= "
                      <td class='ths text-left'>" . $value['work_location_name'] . "</td>
                      <td  class='ths text-center'>" . date("d-M-Y", strtotime($value['employee_joining_date'])) . "</td>
                      <td class='ths text-center'>" . date("d-M-Y", strtotime($value['employee_dob_certificate'])). "</td>
                      <td class='ths text-center'>" . $value['age1'] . "</td>
                      <td class='ths text-center'>" . $service_length . "</td>
                      <td class='ths text-center'>" . $emp_status . "</td>
                      <td class='ths text-center'>" . $eligible_status . "</td>
                      <td class='ths text-center'>"; 
                      if($value['status'] == 1){
                      $table .= " <a onclick='eligibleExclution(". $value['id'] .")' value='Submit' type='submit' class='btn btn-xs btn-warning float-left' style='margin-left: 15px;'><i class='fa fa-times-circle' aria-hidden='false'></i> Exclude</a>";
                        } 
                        $table .= "</td>
                    </tr>";
            }
            $table .= "</tbody>
              </table>
            </div></td></tr>
            <!-- <input value='Submit' type='submit' class='btn btn-sm btn-success float-left col-md-1' style='margin-left: 15px;'> -->
        </table>
      </form>
      <script>
        function eligibleExclution(employee_id){
            // event.preventDefault();
            // $.ajaxSetup({
            //   headers: {
            //     'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
            //   }
            // });
           // var formdata = $(this).serialize(); // here $(this) refere to the form its submitting
           // console.log(formdata);
            $.ajax({
                type: 'get',
                url: '/insurance_exclution_submit/'+ employee_id,
                success: function(data) {
                  console.log(data);
                  if (data.status == 1) {
                    var success_error_message = data.message;
                    var color = 'green';
                  } else {
                    var success_error_message = data.message;
                    var color = 'red';
                  }
                  $('.local_excel_print').css('display', 'none');
                  $('.success_error_message').css('display', 'block');
                  $('.success_error_message').text(success_error_message);
                  $('.success_error_message').css({ 'color': color, 'font-size': '20px' , 'font-weight': 'bold'});
                  setTimeout(function () {
                      $('.success_error_message').hide();
                  }, 4000);
                },
                error: function() {
                    console.log('Error occured!');
                }
            });
        }      
      </script>
      ";
      return $table;
    // } else {
    //   return "Please select SBU first!";
    // }
}
public function insurance_inclusion_employee($search_option)
{
    $employee_sbu = [];
    // if ($search_option['employee_sbu']) {
        $employee_sbu = $search_option['employee_sbu'];
        $sbu_count = count($search_option['employee_sbu']);
        $employee_info = Employee::valid()
          ->select('employees.*', 'employee_personal_infos.employee_mobile as p_employee_mobile','employee_personal_infos.employee_blood_group', 'employee_personal_infos.employee_dob_certificate', 'work_locations.work_location_name', 'designations.designation_name', 'company_sbus.sbu_name', 'departments.department_name',
          DB::raw('(DATEDIFF(NOW(), employee_joining_date))/365 as service_length1'),
          DB::raw('(DATEDIFF(NOW(), employee_dob_certificate))/365 as age1')
          )
          ->leftjoin('employee_personal_infos', 'employees.id', '=', 'employee_personal_infos.employee_id')
          ->leftjoin('designations', 'employees.employee_designation', '=', 'designations.id')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
          ->whereIn('employee_sbu', $employee_sbu)
          ;
        if ($search_option['employee_sbu']) {
            $employee_info->whereIn('employee_sbu', $employee_sbu);
        }
        if ($search_option['from_date_formated'] && $search_option['to_date_formated']) {
            $employee_info->whereBetween('employees.employee_joining_date', [$search_option['from_date_formated'], $search_option['to_date_formated']]);
        }
        if ($search_option['employee_department']) {
            $employee_info->whereIn('employee_department', $search_option['employee_department']);
        }
        if ($search_option['employee_designation']) {
            $employee_info->whereIn('employee_designation', $search_option['employee_designation']);
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
        if (!empty($search_option['employee_id'])) {
            $employee_info->whereIn('employees.id', $search_option['employee_id']);
        }
        if ($search_option['employee_work_location']) {
            $employee_info->whereIn('employee_work_location', $search_option['employee_work_location']);
        }
        if ($search_option['emplyee_category_mgt_non_mgt']) {
            $employee_info->whereIn('emplyee_category_mgt_non_mgt', $search_option['emplyee_category_mgt_non_mgt']);
        }
        if ($search_option['employee_type']) {
            $employee_info->whereIn('employee_type', $search_option['employee_type']);
        }
        if ($search_option['employee_group']) {
            $employee_info->whereIn('employee_group', $search_option['employee_group']);
        }
        if ($search_option['employee_job_grade']) {
            $employee_info->whereIn('employee_job_grade', $search_option['employee_job_grade']);
        }
        if ($search_option['employee_status']) {
            $employee_info->whereIn('employee_status', $search_option['employee_status']);
        }

        $all_data_employee_info = $employee_info->orderBy('designations.priority');
        $all_data = $employee_info = $employee_info->orderBy('designations.priority')->get();

        if (!empty($search_option['age_from']) || !empty($search_option['age_to'])) {
          if (!empty($search_option['age_from']) && !empty($search_option['age_to'])) {
              $all_data = collect($all_data)->where('age1', '!=', 0)->where('age1', '>=', $search_option['age_from'])->where('age1', '<=', $search_option['age_to']);
          } elseif (!empty($search_option['age_from'])) {
              $all_data = collect($all_data)->where('age1', '!=', 0)->where('age1', '>=', $search_option['age_from']);
          } elseif (!empty($search_option['age_to'])) {
              $all_data = collect($all_data)->where('age1', '!=', 0)->where('age1', '<=', $search_option['age_to']);
          } else {
              $all_data;
          }
        }else{
          $all_data;
        }

        if (!empty($search_option['service_length_from']) || !empty($search_option['service_length_to'])) {
          if (!empty($search_option['service_length_from']) && !empty($search_option['service_length_to'])) {
              $all_data = collect($all_data)->where('service_length1', '>=', $search_option['service_length_from'])->where('service_length1', '<=', $search_option['service_length_to'])->toArray();
          } elseif (!empty($search_option['service_length_from'])) {
              $all_data = collect($all_data)->where('service_length1', '>=', $search_option['service_length_from'])->toArray();
          } elseif (!empty($search_option['service_length_to'])) {
              $all_data = collect($all_data)->where('service_length1', '<=', $search_option['service_length_to'])->toArray();
          } else {
              $all_data;
          }
      }else{
        $all_data;
      }
      
        $ins_eligibel_query = InsuranceEligible::valid()->project()->leftJoin('employees', 'employees.id', '=', 'insurance_eligible_employees.employee_id')->select('employee_id')->get();
        $eligbilbe_employees = collect($ins_eligibel_query)->pluck('employee_id');
        
        $all_data_new_joining = collect($all_data)->whereNotIn('id', $eligbilbe_employees)->where('employee_status', 1)->toArray();
        // dd([$eligbilbe_employees]);

        $all_data_resigned = (clone $all_data_employee_info)->leftJoin('insurance_eligible_employees', 'employees.id', '=', 'insurance_eligible_employees.employee_id')->whereIn('employees.id', $eligbilbe_employees)->where('employee_status', 2)->distinct()->get()->toArray();

      
        // dd([$all_data_resigned]);

        if (!empty($search_option['age_from']) || !empty($search_option['age_to'])) {
            if (!empty($search_option['age_from']) && !empty($search_option['age_to'])) {
                $all_data_resigned = collect($all_data_resigned)->where('age1', '!=', 0)->where('age1', '>=', $search_option['age_from'])->where('age1', '<=', $search_option['age_to'])->toArray();
            } elseif (!empty($search_option['age_from'])) {
                $all_data_resigned = collect($all_data_resigned)->where('age1', '!=', 0)->where('age1', '>=', $search_option['age_from'])->toArray();
            } elseif (!empty($search_option['age_to'])) {
                $all_data_resigned = collect($all_data_resigned)->where('age1', '!=', 0)->where('age1', '<=', $search_option['age_to'])->toArray();
            } else {
              $all_data_resigned;
            }
          }

        if (!empty($search_option['service_length_from']) || !empty($search_option['service_length_to'])) {
            if (!empty($search_option['service_length_from']) && !empty($search_option['service_length_to'])) {
                $all_data_resigned = collect($all_data_resigned)->where('service_length1', '>=', $search_option['service_length_from'])->where('service_length1', '<=', $search_option['service_length_to'])->toArray();
            } elseif (!empty($search_option['service_length_from'])) {
                $all_data_resigned = collect($all_data_resigned)->where('service_length1', '>=', $search_option['service_length_from'])->toArray();
            } elseif (!empty($search_option['service_length_to'])) {
                $all_data_resigned = collect($all_data_resigned)->where('service_length1', '<=', $search_option['service_length_to'])->toArray();
            } else {
              $all_data_resigned;
            }
        }

        $company_id = $search_option['employee_sbu'];
        $employeeSbu = [];
        if (!empty($search_option['employee_sbu'])) {
          $employeeSbu = $search_option['employee_sbu'];
        }
        if (!empty($employeeSbu)) {
            $company_sbus = CompanySbu::valid()->whereIn('id', $employeeSbu)->get()->toArray();
        } else {
            $company_sbus = CompanySbu::valid()->get()->toArray();
        }

        // <form method='POST' action='". url('hrm/insurance_eligible_store')."'>
        $table = "
        <form id='assigning_form_submit'>
        <table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'>
            <div   class='section-to-print col-md-12'>
            <table style='width:100%'> <tr> <td style='width:20%'>
            <div class='row' style='margin-left: 21px;'>
            <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";

        if (!empty($company_id)) {
            $companyLogo1 = collect($company_sbus)->where('id', $company_id[0])->first();
            // echo "<pre>";
            // print_r($companyLogo1['sbu_name']);
            if (!empty($companyLogo1)) {
                if ($companyLogo1['sbu_logo'] != "") {
                    $url = '/company_logo/' . $companyLogo1["sbu_logo"];
                    $table .= '<img src="' . $url . '" style="width:50%;">';
                } else {
                    echo 'No Logo Found';
                }
            } else {
                echo 'No Logo Found';
            }
        } else {
            $url = '/company_logo/group_company_logo.png';
            $table .= '<img src="' . $url . '" style="width:50%;">';
        }
        $table .= " </div></td><td style='width:60%'>
  <div class='col-md-12' style='padding: 0px'>
    <h5 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h5>";
    if($sbu_count > 1){
      $table .= "<h4 class='text-center' style='margin:0px;text-align: center!important;'>" . $companyLogo1['sbu_name'] ?? '' . "</h4>";
    }  
    
        $table .= "
  </div> </td> <td style='width:20%'>
  <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
    <p style='margin-top: -7px'><strong> Created :</strong> " . Auth::guard('user')->user()->name . "</p>
    <p style='margin-top: -7px'><strong> Total :</strong> " . count($all_data_new_joining + $all_data_resigned) . "</p>
  </div>
  </div></td></tr></table>
        <div class='col-md-12'>
            <p style='padding-bottom: 5px; border-bottom: 1px solid #ddd; font-weight: bold;'>Joining List (". count($all_data_new_joining) . ")</p>
        </div>
          <input type='hidden' name='_token' value='".csrf_token()."' />  
          <table class='table table-bordered table-striped' border='0' style='width:100%'>
                    <thead>
                      <tr style='background: #eee;'>
                        <th class='ths' style='padding:2px 10px; text-align: center;'>Sl.</th>
                        <th class='ths' style='padding:2px 10px; text-align: center;'>ID</th>
                        <th class='ths' style='padding:2px 10px; text-align: center;'>Name</th>
                        <th class='ths' style='padding:2px 10px; text-align: center;'>Designation</th>
                        <th class='ths' style='padding:2px 10px; text-align: center;'>Department</th>";
                        if($sbu_count > 1){
                          $table .= "<th class='ths' style='padding:2px 10px; text-align: center;'>SBU</th>";
                        }
                        $table .="
                        <th class='ths' style='padding:2px 10px; text-align: center;'>W. Location</th>
                        <th class='ths' style='padding:2px 10px; text-align: center;'>DOJ</th>
                        <th class='ths' style='padding:2px 10px; text-align: center;'>DOB</th>
                        <th class='ths' style='padding:2px 10px; text-align: center;'>Age(Year)</th>
                        <th class='ths' style='padding:2px 10px; text-align: center;'>S. Length(Year)</th>
                        <th class='ths' style='padding:2px 10px; text-align: center;'>Status</th>
                        <th class='ths' style='padding:2px 10px; text-align: center;'>Assigning</th>
                      </tr>
                    </thead>";
                $i = 0;
                foreach ($all_data_new_joining as $key => $value) {
                  $service_length = 0;
                  if (!empty($value['employee_joining_date'])) {
                      $Joining = new DateTime($value['employee_joining_date']);
                      $today = new Datetime(date('Y-m-d'));
                      $diff = $today->diff($Joining);
                      $service_length = round((float)($diff->days)/365, 1);
                  }
                  $i++;
                  $table .= "<tr class='body_td ths'>
                        <input name='employee_id[]' type='hidden' value='".$value['id']."'>
                        <td style='text-align: center;'>" . $i . "</td>
                        <td class='text-center ths'>" . $value['employee_id_no'] . "</td>
                        <td  >" . $value['employee_fullname'] . "</td>
                        <td >" . $value['designation_name'] . "</td>
                        <td >" . $value['department_name'] . "</td>";
                        if($sbu_count > 1){
                          $table .= "<td >" . $value['sbu_name'] . "</td>";
                        }
                  $table .= "
                        <td class='ths text-left'>" . $value['work_location_name'] . "</td>
                        <td  class='ths text-center'>" . date("d-M-Y", strtotime($value['employee_joining_date'])) . "</td>
                        <td class='ths text-center'>" . date("d-M-Y", strtotime($value['employee_dob_certificate'])) . "</td>
                        <td class='ths text-center'>" . round($value['age1']) . "</td>
                        <td class='ths text-center'>" . $service_length . "</td>
                        <td class='ths text-center'>" .  'Eligible' . "</td>
                        <td class='ths text-center' style='width: 10%;'>
                          <select  id='select_resigned".$key."' name='employee_status[]' class='form-control select_resigned' >
                            <option value='0' selected>-- Select --</option>
                            ";
                            foreach ($all_data_resigned as $value) {
                              $table .= "<option value='". $value['id'] ."'>". $value['employee_id_no'] ." : ". $value['employee_fullname'] . " - ". $value['designation_name'] ."</option>";
                            }
                            $table .= "
                          </select>
                      
                        </td>
                      </tr>
                      <script>
                        $(document).ready(function() {
                          $('#select_resigned$key').select2();
                          $('#select_resigned$key option:selected').text('--Select--');
                        });
                      </script>
                      
                      ";
              }
              $table .= "</tbody>
                </table>
              </div></td></tr>
            <input value='Submit' type='submit' class='btn btn-sm btn-success float-left col-md-1' style='margin-left: 15px;'>
          </table>
        </form>
        <div class='col-md-12'>
            <p style='padding-bottom: 5px; border-bottom: 1px solid #ddd; font-weight: bold; font-size: medium;'>Resigned List (". count($all_data_resigned) . ")</p>
        </div>
        <table class='table table-bordered table-striped' border='0' style='width:100%'>
                  <thead>
                    <tr style='background: #eee;'>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Sl.</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>ID</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Name</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Designation</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Department</th>";
                      if($sbu_count > 1){
                        $table .= "<th class='ths' style='padding:2px 10px; text-align: center;'>SBU</th>";
                      }
                      $table .="
                      <th class='ths' style='padding:2px 10px; text-align: center;'>W. Location</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>DOJ</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>DOB</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Age(Year)</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>S. Length(Year)</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Status</th>
                    </tr>
                  </thead>";
              $i = 0;
              // csrf_token();
              foreach ($all_data_resigned as $key => $value) {
                $service_length = 0;
                if (!empty($value['employee_joining_date'])) {
                    $Joining = new DateTime($value['employee_joining_date']);
                    $today = new Datetime(date('Y-m-d'));
                    $diff = $today->diff($Joining);
                    $service_length = round((float)($diff->days)/365, 1);
                }
                $i++;
                $table .= "<tr class='body_td ths'>
                      <input name='employee_id[]' type='hidden' value='".$value['id']."'>
                      <td style='text-align: center;'>" . $i . "</td>
                      <td class='text-center ths'>" . $value['employee_id_no'] . "</td>
                      <td  >" . $value['employee_fullname'] . "</td>
                      <td >" . $value['designation_name'] . "</td>
                      <td >" . $value['department_name'] . "</td>";
                      if($sbu_count > 1){
                        $table .= "<td >" . $value['sbu_name'] . "</td>";
                      }
                $table .= "
                      <td class='ths text-left'>" . $value['work_location_name'] . "</td>
                      <td  class='ths text-center'>" . date("d-M-Y", strtotime($value['employee_joining_date'])) . "</td>
                      <td class='ths text-center'>" . date("d-M-Y", strtotime($value['employee_dob_certificate'])) . "</td>
                      <td class='ths text-center'>" . round($value['age1']) . "</td>
                      <td class='ths text-center'>" . $service_length . "</td>
                      <td class='ths text-center' style='color: red;'>" .  'Resigned' . "</td>
                 
                      
                    </tr>";
            }
            $table .= "</tbody>
              </table>
            </div></td></tr>
            <!-- <input value='Submit' type='submit' class='btn btn-sm btn-success float-left col-md-1' style='margin-left: 15px;'> -->
        </table>
    
      <script>
          $('#assigning_form_submit').submit(function() {
              event.preventDefault();
              var formdata = $(this).serialize(); // here $(this) refere to the form its submitting
              // console.log(formdata);
              $.ajax({
                  type: 'POST',
                  url: '/insurance_assign_submit',
                  data: formdata,
                  success: function(data) {
                      console.log(data);
                      if (data.status == 1) {
                          var success_error_message = 'Succesfully Form Submitted!';
                          var color = 'green';
                      } else {
                          var success_error_message = 'Oops! Data not submitted!';
                          var color = 'red';
                      }
                      $('.local_excel_print').css('display', 'none');
                      $('.success_error_message').css('display', 'block');
                      $('.success_error_message').text(success_error_message);
                      $('.success_error_message').css({ 'color': color, 'font-size': '20px' , 'font-weight': 'bold'});
                      setTimeout(function () {
                          $('.success_error_message').hide();
                      }, 4000);
                  },
                  error: function() {
                      console.log('Error occured!');
                  }
              });
          });

    
          </script>
          "
          ;
          
          return $table;
        // } else {
        //   return "Please select SBU first!";
        // }
}
public function insurance_eligible_employee($search_option)
{
  $today = date('Y-m-d');
  $employee_sbu = [];
  // if ($search_option['employee_sbu']) {
        $employee_sbu = $search_option['employee_sbu'];
        $sbu_count = count($search_option['employee_sbu']);
        // $eligbilbe_employees = InsuranceEligible::valid()->project()->whereIn('employee_sbu', $employee_sbu)->get();

        $employee_info = Employee::valid()
          ->select('employees.*', 'employee_personal_infos.employee_mobile as p_employee_mobile','employee_personal_infos.employee_blood_group', 'employee_personal_infos.employee_dob_certificate', 'work_locations.work_location_name', 'designations.designation_name', 'company_sbus.sbu_name', 'departments.department_name',
          'job_grades.jobgrade_name',
          'job_grades.insurance_amount',
          'job_grades.yearly_premium_cost',
          DB::raw('(DATEDIFF(NOW(), employee_joining_date))/365 as service_length1'),
          DB::raw('(DATEDIFF(NOW(), employee_dob_certificate))/365 as age1')
          )
          ->leftjoin('employee_personal_infos', 'employees.id', '=', 'employee_personal_infos.employee_id')
          ->leftjoin('designations', 'employees.employee_designation', '=', 'designations.id')
          ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
          ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
          // ->whereNotIn('employees.id', $eligbilbe_employees)
          // ->whereIn('employee_sbu', $employee_sbu)
          // ->whereIn('employee_department', $employee_department)
          ;

        if ($search_option['employee_sbu']) {
            $employee_info->whereIn('employee_sbu', $employee_sbu);
        }

        if (empty($search_option['from_date_formated']) && $search_option['to_date_formated']) {
            // $employee_info->whereBetween('employees.employee_joining_date', [$search_option['from_date_formated'], $search_option['to_date_formated']]);
            $employee_info->where('employee_joining_date', '<=', $search_option['to_date_formated']);
        }
        if ($search_option['from_date_formated'] && $search_option['to_date_formated']) {
            $employee_info->whereBetween('employees.employee_joining_date', [$search_option['from_date_formated'], $search_option['to_date_formated']]);
        }
        // if($request['date_range_value']==2){
        //   $employee_data_info->where('employee_joining_date', '<=', $request['to_date']);
        // }else{
        //   $employee_data_info->whereDate('employee_joining_date', '>=', $request['from_date']);
        //   $employee_data_info->whereDate('employee_joining_date', '<=', $request['to_date']);
        // }

        if ($search_option['employee_department']) {
            $employee_info->whereIn('employee_department', $search_option['employee_department']);
        }
        if ($search_option['employee_designation']) {
            $employee_info->whereIn('employee_designation', $search_option['employee_designation']);
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
        if (!empty($search_option['employee_id'])) {
            $employee_info->whereIn('employees.id', $search_option['employee_id']);
        }
        if ($search_option['employee_work_location']) {
            $employee_info->whereIn('employee_work_location', $search_option['employee_work_location']);
        }
        if ($search_option['emplyee_category_mgt_non_mgt']) {
            $employee_info->whereIn('emplyee_category_mgt_non_mgt', $search_option['emplyee_category_mgt_non_mgt']);
        }
        if ($search_option['employee_type']) {
            $employee_info->whereIn('employee_type', $search_option['employee_type']);
        }
        if ($search_option['employee_group']) {
            $employee_info->whereIn('employee_group', $search_option['employee_group']);
        }
        if ($search_option['employee_job_grade']) {
            $employee_info->whereIn('employee_job_grade', $search_option['employee_job_grade']);
        }
        // dd($search_option['employee_status']);
        if (!empty($search_option['employee_status'])) {
            $employee_info->whereIn('employee_status', $search_option['employee_status']);
        }

        $employee_info1 = $employee_info
        ->where('employees.employee_joining_date', '<=', $today)
        ->orderBy('designations.priority')->get()->toArray();
   
         $ins_eligibel_query = InsuranceEligible::valid()->project()->select('employee_id')->get();
         $eligbilbe_employees = collect($ins_eligibel_query)->pluck('employee_id');

        //  dd($eligbilbe_employees);

         $employee_info = collect($employee_info1)->whereNotIn('id', $eligbilbe_employees)->toArray();


        if(!empty($eligbilbe_employees) && empty($employee_info)){
          return "<h6 style='text-align:center; color: #cd9e00'><b >No data found!</b></h6>";
        }

        $all_data = $employee_info;

        // dd($all_data);
        if (!empty($search_option['age_from']) || !empty($search_option['age_to'])) {
            if (!empty($search_option['age_from']) && !empty($search_option['age_to'])) {
                $all_data = collect($all_data)->where('age1', '!=', 0)->where('age1', '>=', $search_option['age_from'])->where('age1', '<=', $search_option['age_to'])->toArray();
            } elseif (!empty($search_option['age_from'])) {
                $all_data = collect($all_data)->where('age1', '!=', 0)->where('age1', '>=', $search_option['age_from'])->toArray();
            } elseif (!empty($search_option['age_to'])) {
                $all_data = collect($all_data)->where('age1', '!=', 0)->where('age1', '<=', $search_option['age_to'])->toArray();
            } else {
              $all_data;
            }
        }
       
        if (!empty($search_option['service_length_from']) || !empty($search_option['service_length_to'])) {
            if (!empty($search_option['service_length_from']) && !empty($search_option['service_length_to'])) {
                $all_data = collect($all_data)->where('service_length', '!=', 'No Data!')->where('service_length1', '>=', $search_option['service_length_from'])->where('service_length1', '<=', $search_option['service_length_to'])->toArray();
            } elseif (!empty($search_option['service_length_from'])) {
                $all_data = collect($all_data)->where('service_length', '!=', 'No Data!')->where('service_length1', '>=', $search_option['service_length_from'])->toArray();
            } elseif (!empty($search_option['service_length_to'])) {
                $all_data = collect($all_data)->where('service_length', '!=', 'No Data!')->where('service_length1', '<=', $search_option['service_length_to'])->toArray();
            } else {
                 $all_data;
            }
        }
        // dd([$all_data1]);
        
        // $employee_ids = collect($employee_info)->pluck('employee_id_no')->toArray();

       
        $all_data =  collect($all_data)->toArray();
        //  dd([$all_data]);
        $company_id = $search_option['employee_sbu'];
        $employeeSbu = [];
        if (!empty($search_option['employee_sbu'])) {
            $employeeSbu = $search_option['employee_sbu'];
        }
        if (!empty($employeeSbu)) {
            $company_sbus = CompanySbu::valid()->whereIn('id', $employeeSbu)->get()->toArray();
        } else {
            $company_sbus = CompanySbu::valid()->get()->toArray();
        }

        $table = "
        <form method='POST' action='". url('hrm/insurance_eligible_store')."'>
        <input id='csrf_token' type='hidden' name='_token' value='".csrf_token()."' /> 
        <table id='tblCustomers' style='width:100%'> <tr> <td > <div class='row'>
            <div   class='section-to-print col-md-12'>
            <table style='width:100%'> <tr> <td style='width:20%'>
            <div class='row' style='margin-left: 21px;'>
            <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>";

            // $companyLogo1 = [];
        if (!empty($company_id)) {
            $companyLogo1 = collect($company_sbus)->where('id', $company_id[0])->first();
            // echo "<pre>";
            // print_r($companyLogo1['sbu_name']);
            if (!empty($companyLogo1)) {
                if ($companyLogo1['sbu_logo'] != "") {
                    $url = '/company_logo/' . $companyLogo1["sbu_logo"];
                    $table .= '<img src="' . $url . '" style="width:50%;">';
                } else {
                    echo 'No Logo Found';
                }
            } else {
                echo 'No Logo Found';
            }
        } else {
            $url = '/company_logo/group_company_logo.png';
            $table .= '<img src="' . $url . '" style="width:50%;">';
        }
        $table .= " </div></td><td style='width:60%'>
  <div class='col-md-12' style='padding: 0px'>
    <h5 class='text-center' style='margin:0px;text-align: center!important;'>Gemcon Group</h5>";
    // echo $sbu_count ; die();
    if($sbu_count > 1){
      $table .= "<h4 class='text-center' style='margin:0px;text-align: center!important;'>" . $companyLogo1['sbu_name'] ?? '' . "</h4>";
    }  
    
        $table .= "
  </div> </td> <td style='width:20%'>
  <div class='col-md-12' style='padding: 0px;margin-top: 17px;'>
    <p style='margin-top: -7px'><strong> Created :</strong> " . Auth::guard('user')->user()->name . "</p>
    <p style='margin-top: -7px'><strong> Total :</strong> " . count($all_data) . "</p>
  </div>
  </div></td></tr></table>

        <table class='table table-bordered table-striped' border='0' style='width:100%'>
                  <thead>
                    <tr style='background: #eee;'>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Sl.</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>ID</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Name</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Designation</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Department</th>";
                      if($sbu_count > 1 || $sbu_count == 0){
                        $table .= "<th class='ths' style='padding:2px 10px; text-align: center;'>SBU</th>";
                      }
                      $table .="
                      <th class='ths' style='padding:2px 10px; text-align: center;'>W. Location</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>DOJ</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>DOB</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Age(Year)</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Grade</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Category</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Type</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Insurance Amount</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Yearly Premium</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>S. Length(Year)</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Emp. Status</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Insurance Status</th>
                      <th class='ths' style='padding:2px 10px; text-align: center;'>Action</th>
                    </tr>
                  </thead>";
              $i = 0;
              // csrf_token();
              foreach ($all_data as $key => $value) {
                if($value['employee_status'] == 1){
                  $emp_status = 'Active';
                }elseif($value['employee_status'] == 2){
                  $emp_status = 'Resign';
                }elseif($value['employee_status'] == 0){
                  $emp_status = 'Inactive';
                }else{
                  $emp_status = '';
                }
                $service_length = 0;
                if (!empty($value['employee_joining_date'])) {
                    $Joining = new DateTime($value['employee_joining_date']);
                    $today = new Datetime(date('Y-m-d'));
                    $diff = $today->diff($Joining);
                    $service_length = round((float)($diff->days)/365, 1);
                }

                if($value['employee_type'] == 1){
                  $employee_type = 'Permanent'; 
                }
                elseif($value['employee_type'] == 2){
                  $employee_type = 'Probationary'; 
                }
                elseif($value['employee_type'] == 3){
                  $employee_type = 'Cotractual'; 
                }
                elseif($value['employee_type'] == 4){
                  $employee_type = 'Casual'; 
                }
                elseif($value['employee_type'] == 5){
                  $employee_type = 'Temporary'; 
                }
                elseif($value['employee_type'] == 6){
                  $employee_type = 'Intern'; 
                }else{
                  $employee_type = '';
                }

                if($value['emplyee_category_mgt_non_mgt'] == 1){
                  $employee_category = 'Management'; 
                }
                if($value['emplyee_category_mgt_non_mgt'] == 2){
                  $employee_category = 'Non-Management'; 
                }

                $i++;
                $table .= "<tr class='body_td ths'>
                      <input name='employee_id[]' type='hidden' value='".$value['id']."'>
                      <td style='text-align: center;'>" . $i . "</td>
                      <td class='text-center ths'>" . $value['employee_id_no'] . "</td>
                      <td  >" . $value['employee_fullname'] . "</td>
                      <td >" . $value['designation_name'] . "</td>
                      <td >" . $value['department_name'] . "</td>";
                      if($sbu_count > 1 || $sbu_count == 0){
                        $table .= "<td >" . $value['sbu_name'] . "</td>";
                      }
                $table .= "
                      <td class='ths text-left'>" . $value['work_location_name'] . "</td>
                      <td  class='ths text-center'>" . date("d-M-Y", strtotime($value['employee_joining_date'])) . "</td>
                      <td class='ths text-center'>" . date("d-M-Y", strtotime($value['employee_dob_certificate'])) . "</td>
                      <td class='ths text-center'>" . $value['age1'] . "</td>
                      <td class='ths text-center'>" . $value['jobgrade_name'] . "</td>
                      <td class='ths text-center'>" . $employee_category . "</td>
                      <td class='ths text-center'>" . $employee_type ."</td>
                      <td class='ths text-center'>" . $value['insurance_amount'] . "</td>
                      <td class='ths text-center'>" . $value['yearly_premium_cost'] . "</td>
                      <td class='ths text-center'>" . $service_length . "</td>
                      <td class='ths text-center'>" .  $emp_status . "</td>
                      <td class='ths text-center'>" .  'Eligible' . "</td>
                      <td class='ths text-center'>";
                      // if($value['status'] == 1){
                        $table .= " <a id='".$value['id']."' value=".$value['id']." onclick='eligibleSubmit(". $value['id'] .")' type='submit' class='btn btn-xs btn-success float-left' style='margin-left: 15px; color: #fff;'>
                      Submit</a>";
                      // }
                      $table .= "</td>
                    </tr>";
            }
            $table .= "</tbody>
              </table>
            </div></td></tr>
            <input value='All Submit' type='submit' class='btn btn-sm btn-success float-left col-md-1' style='position:absolute; z-index:1; right: 2px; top: 9%;'>
        </table>
      </form>


      <script>
        function eligibleSubmit(employee_id){
           var token = document.getElementById('csrf_token').value ;
           var eligible_emp_id = document.getElementById(employee_id).value;
           $('#' + employee_id).text('Done');
           $('#' + employee_id).attr('disabled', true);
           $('#' + employee_id).removeAttr('onClick');
           $('#' + employee_id).removeAttr('class');
           $('#' + employee_id).css({'color':'green'});

           console.log(eligible_emp_id);
            $.ajax({
                type: 'post',
                url: '/hrm/insurance_eligible_store',
                data: { 
                    employee_id: employee_id,
                    _token: token,
                },
                success: function(data) {
                  console.log(data.message);
                  if (data.status == 1) {
                    var success_error_message = data.message;
                    var color = 'green';
                  } else {
                    var success_error_message = data.message;
                    var color = 'red';
                  }
                  // $('.local_excel_print').css('display', 'none');
                  // $('.success_error_message').css('display', 'block');
                  // $('.success_error_message').text(success_error_message);
                  // $('.success_error_message').css({ 'color': color, 'font-size': '20px' , 'font-weight': 'bold'});
                  setTimeout(function () {
                      $('.success_error_message').hide();
                  }, 4000);
                },
                error: function() {
                    console.log('Error occured!');
                }
            });
        }      
      </script>
      
      "
      ;

        return $table;
    // } else {
    //     return "Please select SBU first!";
    // }
}
public function insurance_eligible_store(Request $request)
{
  // dd($request->employee_id);
  // return response($request);
  $empoyee_count = count((array)$request['employee_id']);
  
  if($empoyee_count == 1){
    $request['employee_id'] = array(
      $request->employee_id);
  }
  try {
    DB::beginTransaction();
    if(!empty($request->employee_id)){
      $date = date('Y-m-d');
      $year = date('Y');
      foreach ($request->employee_id as $key => $value) {
        $data['employee_id'] = $value;
        $data['eligible_date_entry'] = $date;
        $data['eligible_year'] = $year;
        $data['status'] = 1;
        $data['valid'] = 1;
        $data['project_id'] = Auth::guard('user')->user()->project_id;
        $data['branch_id'] = Auth::guard('user')->user()->branch_id; 
        $data['created_by'] = Auth::guard('user')->user()->id; 
        // $save_data = InsuranceEligible::create($data);
        InsuranceEligible::updateOrCreate(
            ['employee_id' => $value],
            $data
        );
      }
    }
    $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
    DB::commit();
    if($empoyee_count == 1){
      return response($message);
    }
    return redirect('dashboards#/insurance_eligible_find')->with('status', $message);
  }catch (\Exception $exception) {
    DB::rollBack();
    $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
    return response($exception);
  }
}

public function insurance_assign_submit(Request $request){
  // dd($request);
  try {
    DB::beginTransaction();
    if(!empty($request->employee_id)){
      $date = date('Y-m-d');
      $year = date('Y');
      foreach ($request->employee_id as $key => $value) {
        $employee_assigned_id = $request->employee_status[$key];
       
        if($employee_assigned_id != 0){
          // return response([$value, $employee_assigned_id]);
          $data['employee_id'] = $value;
          $data['eligible_date_entry'] = $date;
          $data['eligible_year'] = $year;
          $data['status'] = 1;
          $data['project_id'] = Auth::guard('user')->user()->project_id;
          $data['branch_id'] = Auth::guard('user')->user()->branch_id; 
          $data['created_by'] = Auth::guard('user')->user()->id; 
          $data['previous_emp_id'] = $employee_assigned_id; 
          // $save_data = InsuranceEligible::create($data);
          $data_exists = InsuranceEligible::where('employee_id', $employee_assigned_id)->first();
          // return response([$value]);
          if($data_exists){
            $data['updated_by'] = Auth::guard('user')->user()->id; 
            $data['updated_at'] = date('Y-m-d H:i:s'); 
            InsuranceEligible::where('employee_id', $employee_assigned_id)->update($data);
            // $save_data = InsuranceEligible::create($data);
          }else{
            $save_data = InsuranceEligible::create($data);
          }
          // return $data['status'] = 1;
        }else{
          // return $data['status'] = 0;
          $message = ['status' => 0, 'message' => 'Your data is successfully saved'];

        }
      }
    }
    $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
    DB::commit();
    return response($message);
  }catch (\Exception $exception) {
    DB::rollBack();
    $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
    return response($exception);
  }
}

public function insurance_exclution_submit($employee_id = NULL){
  try {
    DB::beginTransaction();
    $data_get = InsuranceEligible::where('employee_id', $employee_id)->first();
    if(empty($data_get)){
      $message = ['status' => 0, 'message' => 'Oops! data not found!'];
      return response($message);
    }
    if(!empty($data_get)){
      $data['updated_by'] = Auth::guard('user')->user()->id; 
      $data['updated_at'] = date('Y-m-d H:i:s'); 
      $data['status'] = 2; 
      InsuranceEligible::where('employee_id', $employee_id)->update($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
    }
    DB::commit();
    return response($message);
  }catch (\Exception $exception) {
    DB::rollBack();
    $message = ['status' => 0, 'message' => 'Ops! Your data not saved!'];
    return response($message);
  }
}






public function index(Request $request){
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','JobGrade')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
  foreach($permission as $child) {
      if($child['link_uid']=='add'){
          $data['add']=$child['link_uid'];
      }elseif($child['link_uid']=='edit'){
          $data['edit']=$child['link_uid'];
      }elseif($child['link_uid']=='delete') {
          $data['delete']=$child['link_uid'];
      }else {
          $data['approve']=$child['link_uid'];
      }
  }   
  $paginate_num = $request->input('paginate_num');
  $search_key = $request->input('search_key');
  if ($request->input('sort') =='id') {
    $order = 'ASC';
    $sort = 'priority';
  } else {
    $order = $request->input('order');
    $sort = $request->input('sort');
  }
  $project_id=Auth::guard('user')->user()->project_id;
  // $branch_id=Auth::guard('user')->user()->branch_id;
  $paginate_data =JobGrade::valid()->project()->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('jobgrade_name','LIKE','%'.$search_key.'%');
    });
    return $query;
  })->where('project_id',$project_id)->orderBy($sort,$order);
  $sortData=$paginate_data;
  $sortGetData=$sortData->get();
  $data['total_data']=count($sortGetData);
  $data['inactive_data']=count(collect($sortGetData)->whereIn('jobgrade_status',2)->toArray());
  $data['active_data']=count(collect($sortGetData)->where('jobgrade_status',1)->toArray());
  $data['paginate_data'] =$sortData->paginate($paginate_num);
    // $employee_list = new Employee();
    // $employee_ids = $employee_list->Employee_id();
    // $employee_id = $employee_ids['employee_id'];
    // $data['AllcompanySbuData']=$employee_list->report_filter_data()['Allcompany_sbu_data'];
    // $data['AllsectionData']=$employee_list->report_filter_data()['Allsection_data'];
    // $data['AllsubSectionData']=$employee_list->report_filter_data()['Allsub_section_data'];
    // $data['AllsubUnitData']= $employee_list->report_filter_data()['Allsub_unit_data'];
    // $data['AllunitData']= $employee_list->report_filter_data()['Allunit_data'];
    // $data['AllworkLocationData']= $employee_list->report_filter_data()['Allwork_location_data'];
    // $data['AlldepartmentData']=$employee_list->report_filter_data()['Alldepartment_data'];
    // $data['AllemployeeData']=$data['employee_data'] = $employee_list->report_filter_data()['employee_data'];
    // $data['company_sbu_data']=$employee_list->report_filter_data()['company_sbu_data'];
    // $data['section_data'] = $employee_list->report_filter_data()['section_data'];
    // $data['sub_section_data'] = $employee_list->report_filter_data()['sub_section_data'];
    // $data['sub_unit_data'] = $employee_list->report_filter_data()['sub_unit_data'];
    // $data['unit_data'] = $employee_list->report_filter_data()['unit_data'];
    // $data['work_location_data'] = $employee_list->report_filter_data()['work_location_data'];
    // $data['department_data'] =$employee_list->report_filter_data()['department_data'];
    // $data['employee_data'] = $employee_list->report_filter_data()['employee_data'];

    $employee_ids = Session::get('employee_ids');
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
    $data['designation_data'] = array();

    $data['jobgrade_data'] = array();
    $data['employee_status_data'] = array();
    $data['employee_data'] = array();
    $data['employee_group_data'] = array();
    $designation_data = Designation::valid()->project()->whereIn('id', $employee_ids['designation'])->orderBy('priority', 'ASC')->get();
    // $jobgrade_data = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get();

    $employee_data = Employee::valid()->project()
    ->select('employees.*','designations.designation_name')
    ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
    // ->whereNotIn('employees.id', $eligbilbe_employees)
    ->get()->keyBy('employee_id_no')->all();
    $data['leave_type_data']=array();
    $employee_group_data = EmployeeGroup::valid()->project()->orderBy('priority', 'ASC')->get();
    array_push($data['employee_group_data'], ['id' => '', 'text' => 'All']);
    foreach ($employee_group_data as $value) {
        array_push($data['employee_group_data'], ['id' => $value['id'], 'text' => $value['employee_group_name']]);
    }
    array_push($data['designation_data'], ['id' => '', 'text' => 'All']);
    foreach ($designation_data as $value) {
        array_push($data['designation_data'], ['id' => $value['id'], 'text' => $value['designation_name']]);
    }
    // array_push($data['jobgrade_data'], ['id' => '', 'text' => 'All']);
    // foreach ($jobgrade_data as $value) {
    //   array_push($data['jobgrade_data'], ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
    // }
    array_push($data['employee_data'], ['id' => '', 'text' => 'All']);
    foreach ($employee_data as $value) {
        array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . ':' . $value['employee_fullname'] . '-' . $value['designation_name']]);
    }


    $data['months_array'] = [];
    $data['today_date'] = date('Y-m-d');
    array_push($data['months_array'], ['id' => date('m'), 'text' => date('F')]);
    array_push($data['months_array'], ['id' => date('m', strtotime('+1 months')), 'text' => date('F', strtotime('+1 months'))]);
    array_push($data['months_array'], ['id' => date('m', strtotime('+2 months')), 'text' => date('F', strtotime('+2 months'))]);
  return response()->json($data);
}

public function insurance_report_finding(Request $request){
  // return response($request);
  $today = date('Y-m-d');
  $employee_data_info =
    InsuranceEligible::valid()
    ->leftJoin('employees', 'employees.id', '=', 'insurance_eligible_employees.employee_id')
    ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
    ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
    ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
    ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
    ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
    ->leftjoin('employee_personal_infos','employees.id','=','employee_personal_infos.employee_id')
    ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'departments.department_name',
        'designations.designation_name',
        'work_locations.work_location_name',
        'job_grades.jobgrade_name',
        'job_grades.insurance_amount',
        'job_grades.yearly_premium_cost',
        'employee_personal_infos.employee_dob_actual',
        'employee_personal_infos.employee_dob_certificate',
        DB::raw('(DATEDIFF(NOW(), employee_joining_date))/365 as service_length1'),
        DB::raw('(DATEDIFF(NOW(), employee_dob_certificate))/365 as age1'),
    );
    

    if($request['date_range_value']==2){
      // $today_date = date('Y-m-d');
      $employee_data_info->where('employee_joining_date', '<=', $request['to_date']);
    }else{
      $employee_data_info->whereDate('employee_joining_date', '>=', $request['from_date']);
      $employee_data_info->whereDate('employee_joining_date', '<=', $request['to_date']);
    }
    
    if (!empty($request['id'])) {
      $employee_data_info->where('employees.employee_sbu',$request['id']);
    }
    if (!empty($request['unit_id'])) {
      $employee_data_info->where('employees.employee_unit',$request['unit_id']);
    }
    if (!empty($request['subunit_id'])) {
      $employee_data_info->where('employees.employee_sub_unit',$request['subunit_id']);
    }
    if (!empty($request['department_id'])) {
      $employee_data_info->where('employees.employee_department',$request['department_id']);
    }
    if (!empty($request['section_id'])) {
      $employee_data_info->where('employees.employee_sub_section',$request['section_id']);
    }
    if (!empty($request['department_id'])) {
      $employee_data_info->where('employees.employee_department',$request['department_id']);
    }
    if (!empty($request['section_id'])) {
      $employee_data_info->where('employees.employee_section',$request['section_id']);
    }
    if (!empty($request['subsection_id'])) {
      $employee_data_info->where('employees.employee_sub_section',$request['subsection_id']);
    }
    if (!empty($request['employee_work_location'])) {
      $employee_data_info->where('employees.employee_work_location',$request['employee_work_location']);
    }
    if (!empty($request['employeeId'])) {
      $employee_data_info->where('employees.id',$request['employeeId']);
    }
    if ($request['employee_status']==1 || $request['employee_status']==2) {
      $employee_data_info->where('employees.employee_status',$request['employee_status']);
    }
    if ($request['employee_status']==0) {
      $employee_data_info->where('employees.employee_status',$request['employee_status']);
    }
    if (!empty($request['insurance_eligible_type'])) {
      $employee_data_info->where('employees.employee_status', $request['insurance_eligible_type']);
    }
    // if ($request['employee_status']==5) {
    //   $employee_data_info->whereNotIn('employees.employee_status','==','');
    // }
    $data['employee_insurance_info'] = $employee_data_info
    ->where('employees.employee_joining_date', '<=', $today)
    ->groupBy('employees.id')
    ->orderBy('designations.priority')->get();

    // return response($data['employee_insurance_info']);
    
    foreach ($data['employee_insurance_info'] as $key => $value) {
      $employee_dob = isset($value['employee_dob_certificate'])?$value['employee_dob_certificate']:'';
      if (empty($employee_dob) || $employee_dob=='0000-00-00') {
        $Joining = 'Not Available';
      }else{
        $date = date_create($employee_dob);
        $employee_dobs =  date_format($date, 'd-M-Y');
      }

      $joining_date = isset($value['employee_joining_date']) ? $value['employee_joining_date'] : '';
      if (empty($joining_date) || $joining_date=='0000-00-00') {
        $Joining = 'Not Available';
      }else{
        $date = date_create($joining_date);
        $Joining =  date_format($date, 'd-M-Y');
      }
      

      $data['insurance_info'][$key]['employee_id_no'] = isset($value['employee_id_no'])?$value['employee_id_no']:'';
      $data['insurance_info'][$key]['employee_fullname'] = isset($value['employee_fullname'])?$value['employee_fullname']:'';
      $data['insurance_info'][$key]['designation_name'] = isset($value['designation_name'])?$value['designation_name']:'';
      $data['insurance_info'][$key]['department_name'] = isset($value['department_name'])?$value['department_name']:'';
      $data['insurance_info'][$key]['work_location_name'] = isset($value['work_location_name'])?$value['work_location_name']:'';
      $data['insurance_info'][$key]['employee_joining_date'] = isset($Joining)?$Joining:'';
      $data['insurance_info'][$key]['service_length'] = isset($value['service_length1'])?$value['service_length1']:'';
      $data['insurance_info'][$key]['employee_dob'] = isset($employee_dobs)?$employee_dobs:'';
      $data['insurance_info'][$key]['employee_age'] = isset($value['age1'])?$value['age1']:'';
      $data['insurance_info'][$key]['jobgrade_name'] = isset($value['jobgrade_name'])?$value['jobgrade_name']:'';
      $data['insurance_info'][$key]['insurance_amount'] = isset( $value['insurance_amount'])?$value['insurance_amount']:0;
      $data['insurance_info'][$key]['yearly_premium_cost'] = isset($value['yearly_premium_cost'])?$value['yearly_premium_cost']:0;
      $data['insurance_info'][$key]['employee_sbu'] = isset($value['sbu_name'])?$value['sbu_name']:'';
      $data['insurance_info'][$key]['employee_type'] = isset($value['employee_type'])?$value['employee_type']:'';
      $data['insurance_info'][$key]['emplyee_category_mgt_non_mgt'] = isset($value['emplyee_category_mgt_non_mgt'])?$value['emplyee_category_mgt_non_mgt']:'';
    }
    $data['employee_status'] = $request['employee_status'];
    $data['total_insurance_employee'] = count($data['employee_insurance_info']);
    $data['report_print_date'] =  date('d F Y');
  return response($data);
}


public function edit($id)
{
  // $edit_data = InsuranceEligible::valid()->project()->findOrFail($id);
  $edit_data = InsuranceEligible::valid()->project()
  ->select(
    'insurance_eligible_employees.*', 
    'employees.*', 
    'employees.id as employee_id', 
    'insurance_eligible_employees.id as id', 
    'designations.designation_name',
    'departments.department_name',
    'company_sbus.sbu_name',
    'work_locations.work_location_name',
    'job_grades.jobgrade_name',
    'employee_personal_infos.employee_dob_certificate',
    DB::raw('(DATEDIFF(NOW(), employee_joining_date))/365 as service_length'),
    DB::raw('(DATEDIFF(NOW(), employee_dob_certificate))/365 as employee_age')
  )
  ->leftJoin('employees', 'employees.id', '=', 'insurance_eligible_employees.employee_id')
  ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
  ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
  ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
  ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
  ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
  ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
  ->findOrFail($id);
  return response($edit_data);

}

public function update(Request $request){
  if($request->id){
    $data['eligible_date_entry'] = $request->eligible_date_entry;
    $data['eligible_year'] = date('Y', strtotime($request->eligible_date_entry));
    $data['status'] = $request->status;
    $data['updated_at'] = date('Y-m-d H:i:s'); 
    $data['updated_by'] = Auth::guard('user')->user()->id; 
    DB::table('insurance_eligible_employees')->where('id', $request->id)->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated!'];
    return response($message);
  }else{
    $message=['status' => 0, 'message' => 'Oops, Your data is not updated!'];
    return response($message);
  }
}
public function destroy($id)
{
  $delete_data = InsuranceEligible::valid()->project()->findOrFail($id);
  // $delete_data->delete()
  if($delete_data)
  {
    $data['valid'] = 0;
    $data['status'] = 2;
    $data['updated_at'] = date('Y-m-d H:i:s'); 
    $data['updated_by'] = Auth::guard('user')->user()->id; 
    $save_data = $delete_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
  }
  return response($message);
}



}
