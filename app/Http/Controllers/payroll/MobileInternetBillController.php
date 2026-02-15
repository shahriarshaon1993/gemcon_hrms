<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\payroll\Salary;
use App\Model\payroll\Increment;
use App\Model\payroll\MobileInternetBill;
use App\Model\Employee;
use App\Model\payroll\SimAllocation;
use App\Model\UsersPersonModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Cache;
use permission;
use DB;
// use App\Model\UserRoleAccess;

class MobileInternetBillController extends Controller
{
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */

  public function index(Request $request)
  {
    $employee_list = new Employee();
    $employee_ids=$employee_list->Employee_id();
    $employee_id=$employee_ids['employee_id'];
    $cache = Cache::get('permission');
    $permission = collect($cache)->where('menu_uid', '=', 'MobileInternetBills')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
    foreach ($permission as $child) {
      if ($child['link_uid'] == 'add') {
        $data['add'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'edit') {
        $data['edit'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'delete') {
        $data['delete'] = $child['link_uid'];
      } else {
        $data['view'] = $child['link_uid'];
      }
    }

    $paginate_num = $request->input('paginate_num');
    $search_key = $request->input('search_key');
    $order = $request->input('order');
    $sort = $request->input('sort');
    $project_id = Auth::guard('user')->user()->project_id;
    $branch_id = Auth::guard('user')->user()->branch_id;
    $paginate_data = MobileInternetBill::valid()->project()
      ->leftJoin('employees',  'employees.id', '=', 'mobile_internet_bills.employee_id')
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->selectRaw(
        'mobile_internet_bills.*,
     employees.employee_id_no,
     employees.employee_fullname,
     employees.employee_joining_date,
     company_sbus.sbu_name,
     departments.department_name,
     designations.designation_name
    '
      )
      ->when($search_key, function ($query, $search_key) {
        $query->where(function ($query2) use ($search_key) {
          $query2->where('employees.employee_id_no', 'LIKE', '%' . $search_key . '%')
            // ->orWhere('employees.employee_id_no', 'LIKE', '%' . $search_key . '%')
            ->orWhere('employees.employee_fullname', 'LIKE', '%' . $search_key . '%')
            ->orWhere('company_sbus.sbu_name', 'LIKE', '%' . $search_key . '%')
            ->orWhere('departments.department_name', 'LIKE', '%' . $search_key . '%')
            ->orWhere('designations.designation_name', 'LIKE', '%' . $search_key . '%');
        });
        return $query;
      })->whereIn('employees.id',$employee_id)->whereIn('company_sbus.id',$employee_ids['sub'])->where('mobile_internet_bills.project_id', $project_id)->orderBy($sort, $order);
    // ->paginate($paginate_num);
    $sortData = $paginate_data;
    $sortGetData = $sortData->get();
    $data['total_data'] = count($sortGetData);
    $data['active_data'] = count(collect($sortGetData)->where('gf_status', 1)->toArray());
    $data['inactive_data'] = count(collect($sortGetData)->whereIn('gf_status', 2)->toArray());
    $data['mobile_bill'] = collect($sortGetData)->where('bill_types', 1)->sum('bill_amount');
    $data['internet_bill'] = collect($sortGetData)->where('bill_types', 2)->sum('bill_amount');
    $data['paginate_data'] = $sortData->paginate($paginate_num);

    return response()->json($data);
  }
  public function getDownload()
  {
    //PDF file is stored under project/public/download/info.pdf
    $file = public_path() . "/download/mobile_bill_data.xlsx";
    return response()->download($file);
  }

  public function mobile_bill_update_request(Request $request){
    if($request->approve_amount_id){
      $update_data = MobileInternetBill::valid()->project()->findOrFail($request->approve_amount_id);
      $data['request_bill'] =  1;
      $save_data = $update_data->update($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
    }
    else{
      $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
    }
    return response($message);
  }
  public function mobile_bill_update(Request $request){
    if($request->approve_amount_id){
      $update_data = MobileInternetBill::valid()->project()->findOrFail($request->approve_amount_id);
      $data['bill_amount'] =  $update_data->bill_amount + $request->approveamount;
      $data['approve_bill'] =  $update_data->approve_bill + $request->approveamount;
      $data['bill_amount_extra'] =  $update_data->bill_amount_extra - $request->approveamount;
      $data['request_bill'] =  0;
      $save_data = $update_data->update($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
    }
    else{
      $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
    }
    return response($message);
  }

  public function excel(Request $request)
  {
    try {
      DB::beginTransaction();
      $file = collect($request->form_data)->toArray();
      // return response($file);
      // bill_amount: 1000
      // bill_date: 44256
      // bill_status: 1
      // bill_types: 1
      // branch_id: 3
      // company_sbu_id: 10
      // created_at: 44257.375
      // created_by: 560
      // deleted_at: "NULL"
      // deleted_by: 0
      // employee_id: 560
      // project_id: 8
      // updated_at: 44257.375
      // updated_by: 0
      // valid: 1

      $no_insert = array();
      foreach ($file as $key => $value) {
        $data = SimAllocation::valid()->project()->where('sim_assign_to', $value['employee_id'])->first();
        if ($data) {
          
          if ($data->sim_ceiling_limit < $value['bill_amount']) {
            $value['bill_amount_extra'] = $value['bill_amount'] - $data->sim_ceiling_limit;
            $value['bill_amount'] = $data->sim_ceiling_limit;
          }
          $value['bill_date'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value['bill_date'])->format('Y-m-d');
          $bill_month = date('m', strtotime($value['bill_date']));
          $bill_year = date('Y', strtotime($value['bill_date']));

          if(!$value['bill_date'] < '2000-01-01'){
            $exit = MobileInternetBill::whereMonth('bill_date', $bill_month)
            ->whereYear('bill_date', $bill_year)
            ->where('employee_id', $value['employee_id'])->first();
            // dd($exit);
          if (!$exit) {
            MobileInternetBill::insert($value);
          } else {
            array_push($no_insert, "This month bill already exist for employee id -> " . $value['employee_id']);
          }
          }else{
            array_push($no_insert, "Invalid date for employee id -> " . $value['employee_id']);
          }
          
        } else {
          // return response()->json(['error' => 'SIM Not Assigned']);
          array_push($no_insert, "SIM Not Assigned employee id -> " . $value['employee_id']);
        }
      }

      DB::commit();
      $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
    } catch (\Exception $exception) {
      DB::rollBack();
      $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
      return response($exception);
    }
    if (count($no_insert) > 0) {
      $error_data['status'] = 3;
      $error_data['error'] = $no_insert;
      return response()->json($error_data);
    }
    return response($message);
    // return response()->json($request);
  }


  public function store(Request $request)
  {
    // echo "<pre>";print_r($this->findDepartmentMaxCode()); die();
    $validate = [
      'employee_id' => 'required',
      'bill_types' => 'required'
    ];

    $request->validate($validate);
    $data = $request->only('employee_id', 'bill_types', 'bill_date', 'bill_amount', 'bill_status', 'medical_allowance', 'bill_remarks');

    if (!empty($request->id)) {
      $update_data = MobileInternetBill::valid()->project()->findOrFail($request->id);
      $data['updated_by'] = Auth::guard('user')->user()->branch_id;
      $save_data = $update_data->update($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
    } else {
      // $data['department_code'] = $this->findDepartmentMaxCode();
      $data['project_id'] = Auth::guard('user')->user()->project_id;
      $data['branch_id'] = Auth::guard('user')->user()->branch_id;
      $data['created_by'] = Auth::guard('user')->user()->id;
      $data['bill_status'] = 1;
      $save_data = MobileInternetBill::create($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
    }

    if (!$save_data) {
      $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
    }
    return response($message);
  }

  public function edit($id)
  {
    $employee_list = new Employee();
    $employee_ids=$employee_list->Employee_id();
    $employee_id=$employee_ids['employee_id'];
    // $edit_data=MobileInternetBill::valid()->project()->findOrFail($id);
    // return response($edit_data);
    // return response($id);
    $data = MobileInternetBill::valid()->project()->findOrFail($id);
    $employee_data = array();
    $employee_data_list = Employee::valid()->project()->whereIn('employees.id',$employee_id)->get()->keyBy('id')->all();
    foreach ($employee_data_list as $value) {
      array_push($employee_data, ['id' => $value['id'], 'text' => $value['employee_id_no'] . " - " . $value['employee_fullname']]);
    }

    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $employee_id = $employee_ids['employee_id'];

    $user_employee_data = Employee::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name',
        'employee_personal_infos.employee_gender'
      )
      ->where('employees.id', $data->employee_id)->first();


    $user_employee_data_all = Employee::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name',
        'employee_personal_infos.employee_gender'
      )->whereIn('employee_sbu', $employee_ids['sub'])
      ->whereIn('employee_department', $employee_ids['department'])
      ->get()->keyBy('id');

    if (!$data->employee_id) {
      $data->employee_name_value = ['id' => '', 'text' => ''];
    } else {
      $data->employee_name_value = ['id' => $data->employee_id, 'text' => $employee_data_list[$data->employee_id]->employee_fullname];
    }

    // $salary_setting=SalarySetting::valid()->project()->where('status', 1)->first();
    // $data->salary_setting = $salary_setting;  
    $data->user_employee_data_all = $user_employee_data_all;
    $data->user_employee_data = $user_employee_data;
    $data->employee_data =  $employee_data;
    // return response($salary_setting);
    return response($data);
  }

  public function destroy($id)
  {

    $delete_data = MobileInternetBill::valid()->project()->findOrFail($id);
    if ($delete_data->delete()) {
      $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
    }
    return response($message);
  }

  public function create()
  {
    $user_id = Auth::guard('user')->user()->id;
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    

    $user_data = UsersPersonModel::valid()->project()->where('id', $user_id)->first();
    if (!empty($id)) {
      $employee_id = $id;
    } else {
      $employee_id = $user_data->employee_id;
    }
    $user_employee_data = Employee::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name',
        'employee_personal_infos.employee_gender'
      )
      ->where('employees.id', $employee_id)->first();
      $employee_id = $employee_ids['employee_id'];
    $data['employee_data'] = array();
    $employee_data = Employee::valid()->whereIn('employees.id',$employee_id)->project()->get();
    foreach ($employee_data as $value) {
      array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . " - " . $value['employee_fullname']]);
    }
    $data['user_employee_data'] = $user_employee_data;
    return response($data);
  }

  public function findDepartmentMaxCode()
  {
    $last_entry_data = MobileInternetBill::latest()->where('type', 2)->first();
    $department_last_code = $last_entry_data['department_code'];
    if ($department_last_code == 0) {
      $department_last_code = 101;
    } else {
      $department_last_code = $department_last_code + 1;
    }
    return $department_last_code;
  }

  public function salary_details($employee_id)
  {
    $user_employee_data = Employee::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name',
        'employee_personal_infos.employee_gender'
      )
      ->where('employees.id', $employee_id)->first();

    $emp_salary = MobileInternetBill::valid()->project()->where('employee_id', $employee_id)->get();

    $data['emp_info'] = Employee::valid()->project()->where('id', $employee_id)->first();
    $data['user_employee_data'] = $user_employee_data;
    $data['emp_salary'] = $emp_salary;
    return response($data);
  }

  public function gratuity_fund_details(Request $request)
  {
    // return response($request);
    $user_employee_data = Employee::valid()->project()
      ->leftJoin('salaries', 'salaries.employee_id', '=', 'employees.id')
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name',
        'employee_personal_infos.employee_gender',
        'salaries.confirmation_date'
      )
      ->where('employees.id', $request->page_ref_id)->where('salaries.type', 1)->first();
    $emp_gratuity_fund = MobileInternetBill::valid()->project()->where('employee_id', $request->page_ref_id)->get();
    $emp_salary = Salary::valid()->project()->where('employee_id', $request->page_ref_id)->get();
    $data['user_employee_data'] = $user_employee_data;
    $data['emp_salary'] = $emp_salary;
    $data['emp_gratuity_fund'] = $emp_gratuity_fund;
    return response($data);
  }
}
