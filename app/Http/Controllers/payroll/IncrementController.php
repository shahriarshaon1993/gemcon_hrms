<?php
namespace App\Http\Controllers\payroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
// use Session;
use App\Model\payroll\Increment;
use App\Model\Employee;
// use App\Model\UserMultiLevelPermission;
// use App\Model\Department;
// use App\Model\Designation;
// use App\Model\JobGrade;
// use App\Model\LeaveType;
// use App\Model\LeaveApplication;
// use App\Model\EmployeeApproval;
use App\Model\UsersPersonModel;
use App\Model\payroll\SalarySetting;
use App\Model\payroll\Salary;
use Cache;
// use permission;
use DB;
// use App\Model\UserRoleAccess;

class IncrementController extends Controller
{
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */

  public function getDownload()
  {
    //PDF file is stored under project/public/download/info.pdf
    $file = public_path() . "/download/salary_inc.xlsx";
    return response()->download($file);
  }
  public function index(Request $request)
  {
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $employee_id = $employee_ids['employee_id'];
    // return response($employee_id);
    $cache = Cache::get('permission');
    $permission = collect($cache)->where('menu_uid', '=', 'Increment')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
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
    $data['paginate_data'] = Salary::valid()->project()
      ->leftJoin('employees',  'employees.id', '=', 'salaries.employee_id')
      ->select(
        'salaries.*',
        'employees.employee_id_no',
        'employees.employee_fullname',
        'employees.employee_joining_date',
      )
      ->when($search_key, function ($query, $search_key) {
        $query->where(function ($query2) use ($search_key) {
          $query2->where('salaries.gross_salary', 'LIKE', '%' . $search_key . '%')
            ->orWhere('employees.employee_id_no', 'LIKE', '%' . $search_key . '%')
            ->orWhere('employees.employee_fullname', 'LIKE', '%' . $search_key . '%');
        });
        return $query;
      })->whereIn('employees.id', $employee_id)->where('salaries.project_id', $project_id)->where('type', 2)->orderBy($sort, $order)->paginate($paginate_num);

    return response()->json($data);
  }


  public function excel(Request $request)
  {
    try {
      DB::beginTransaction();
      $file = collect($request->form_data)->toArray();
      // return response($file);
      // MobileInternetBill::insert($file);
      $no_insert = array();
      foreach ($file as $key => $value) {
        # code...
        $employee_data = Employee::valid()->project()->where('employee_id_no', $value['employee_id'])->first();
        // dd($employee_data);
        if ($employee_data) {
          $salary_data = Salary::valid()->project()->where('employee_id', $employee_data->id)->first();
          if ($salary_data) {
            $data["employee_id"] = $employee_data->id;
            $data["gross_salary"] = $value["gross_salary"];
            $data["basic_salary"] = $value["basic_salary"];
            $data["confirmation_date"] =  $value["confirmation_date"] ?? 0;
            $data["housing_allowance"] =  $value["housing_allowance"] ?? 0;
            $data["medical_allowance"] =  $value["medical_allowance"] ?? 0;
            $data["conveyance_allowance"] =   $value["conveyance_allowance"] ?? 0;
            $data["overtime_work_compensation"] =   $value["overtime_work_compensation"] ?? 0;
            $data["others_allowance"] =   $value["others_allowance"] ?? 0;
            $data["salary_goes_to"] =   $value["salary_goes_to"] == "bank" ? 2 : 1;
            $data["car_allowance_amount"] =   $value["car_allowance_amount"] ?? 0;
            $data["salary_sbu_id"] =  $salary_data->salary_sbu_id;
            $data["company_sbu_id"] =  $salary_data->company_sbu_id;
            $data["provident_fund"] =   $value["provident_fund"];

            $data['project_id'] = Auth::guard('user')->user()->project_id;
            $data['branch_id'] = Auth::guard('user')->user()->branch_id;
            $data['created_by'] = Auth::guard('user')->user()->id;
            $data['salary_status'] = 1;
            $data['type'] = 2;
            Salary::create($data);
          } else {
            array_push($no_insert, "Salary data not found -> " . $value['employee_id']);
          }
        } else {
          array_push($no_insert, "Employee data not found -> " . $value['employee_id']);
        }
      }

      // $data = $request->only('gross_salary', 'employee_id', 'basic_salary', 'confirmation_date', 'housing_allowance', 'medical_allowance', 'conveyance_allowance', 'overtime_work_compensation', 'salary_status', 'type', 'others_allowance', 'increment_type', 'increment_percentage', 'salary_goes_to', 'car_allowance_status', 'car_allowance_amount', 'salary_sbu_id', 'company_sbu_id', 'provident_fund', 'car_allowance_status');

      // dd($no_insert);
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
    // return response()->json($request);
    $validate = [
      'employee_id' => 'required',
      'basic_salary' => 'required'
    ];

    $request->validate($validate);
    $data = $request->only('gross_salary', 'employee_id', 'basic_salary', 'confirmation_date', 'housing_allowance', 'medical_allowance', 'conveyance_allowance', 'overtime_work_compensation', 'salary_status', 'type', 'others_allowance', 'increment_type', 'increment_percentage', 'salary_goes_to', 'car_allowance_status', 'car_allowance_amount', 'salary_sbu_id', 'company_sbu_id', 'provident_fund', 'car_allowance_status');

    if ($request['car_allowance_status'] == 1) {
      $car_allowance_amount = $request['car_allowance_amount'];
    } else {
      $car_allowance_amount = 0;
    }
    if ($request['provident_fund'] == 0) {
      $provident_fund_amount = 0;
    } else {
      $provident_fund_amount = $request['provident_fund_amount'];
    }

    if (!empty($request->id)) {
      $data['car_allowance_amount'] = $car_allowance_amount;
      $data['provident_fund_amount'] = $provident_fund_amount;
      // return response()->json($request);
      $update_data = Salary::valid()->project()->findOrFail($request->id);
      $data['updated_by'] = Auth::guard('user')->user()->id;
      $save_data = $update_data->update($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
    } else {
      $data['car_allowance_amount'] = $car_allowance_amount;
      $data['provident_fund_amount'] = $provident_fund_amount;
      $data['project_id'] = Auth::guard('user')->user()->project_id;
      $data['branch_id'] = Auth::guard('user')->user()->branch_id;
      $data['created_by'] = Auth::guard('user')->user()->id;
      $data['salary_status'] = 1;
      $data['type'] = 2;
      $save_data = Salary::create($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
    }

    if (!$save_data) {
      $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
    }
    return response($message);
  }

  public function edit($id)
  {
    // $employee_list = new Employee();
    // $employee_ids=$employee_list->Employee_id();
    // $employee_id=$employee_ids['employee_id'];

    $data = Salary::valid()->project()->where('type', 2)->findOrFail($id);
    // $employee_data = array();
    // $employee_data_list = Employee::valid()->project()->whereIn('employees.id', $employee_id)->get()->keyBy('id')->all();
    // foreach ($employee_data_list as $value) {
    //   array_push($employee_data, ['id' => $value['id'], 'text' => $value['employee_id_no'] . " - " . $value['employee_fullname']]);
    // }

    

    $user_employee_data = Employee::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
      ->leftJoin('employee_bank_account_details', 'employee_bank_account_details.ebc_employee_id', '=', 'employees.id')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name',
        'employee_bank_account_details.ebc_account_number',
        'employee_personal_infos.employee_gender'
      )
      ->where('employees.id', $data->employee_id)->first();

    // $user_employee_data_all = Employee::valid()->project()
    //   ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
    //   ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
    //   ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
    //   ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
    //   ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
    //   ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
    //   ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
    //   ->select(
    //     'employees.*',
    //     'company_sbus.sbu_name',
    //     'sections.section_name',
    //     'departments.department_name',
    //     'designations.designation_name',
    //     'sub_units.sub_unit_name',
    //     'work_locations.work_location_name',
    //     'employee_personal_infos.employee_gender'
    //   )->whereIn('employees.id', $employee_id)
    //   ->whereIn('employee_sbu', $employee_ids['sub'])
    //   ->whereIn('employee_department', $employee_ids['department'])
    //   ->get()->keyBy('id');

    // if (!$data->employee_id) {
    //   $data->employee_name_value = ['id' => '', 'text' => ''];
    // } else {
    //   $data->employee_name_value = ['id' => $data->employee_id, 'text' => $employee_data_list[$data->employee_id]->employee_fullname];
    // }

    $salary_setting=SalarySetting::valid()->project()->where('status', 1)->first();
    $data->salary_setting = $salary_setting;  
    // $data->user_employee_data_all = $user_employee_data_all;
    $data->user_employee_data = $user_employee_data;
    // $data->employee_data =  $employee_data;

    $emp_salary = Salary::valid()->project()
      ->selectRaw(
        'salaries.*,
          sum(gross_salary) as gross_salary,
          sum(provident_fund_amount) as pf,
          sum(car_allowance_amount) as car_allowance_amount,
          sum(others_allowance) as others_allowance,
          sum(conveyance_allowance) as conveyance_allowance
          '
      )
      ->where('confirmation_date', '<=', date('Y-m-d'))
      ->where('employee_id', $data->employee_id)
      ->groupBy('confirmation_date')
      ->groupBy('type')
      ->groupBy('salary_goes_to')
      ->get();
    $sub_id = collect($emp_salary)->first();
    // return response($emp_salary);
    if (!empty($sub_id)) {
      $data['company_sbu_id'] = $sub_id['company_sbu_id'];
      $data['salary_sbu_id'] = $sub_id['salary_sbu_id'];
    } else {
      $data['company_sbu_id'] = 0;
      $data['salary_sbu_id'] = 0;
    }

    $data['emp_salary'] = $emp_salary;
    $gross_salary = collect($emp_salary)->sum('gross_salary');
    $car_allowance_amount = collect($emp_salary)->sum('car_allowance_amount');
    $others_allowance = collect($emp_salary)->sum('others_allowance');
    $pf = collect($emp_salary)->sum('pf');
    $data['totalSalary'] = number_format((($gross_salary + $car_allowance_amount + $others_allowance)), 2);

    // return response($salary_setting);
    return response($data);
  }

  public function destroy($id)
  {

    $delete_data = Salary::valid()->project()->where('type', 2)->findOrFail($id);
    if ($delete_data->delete()) {
      $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
    }
    return response($message);
  }

  public function create($id = False)
  {
    $employee_data = Employee::valid()->project()
    // ->whereIn('employees.id', $employee_id)
    ->get();
  
    $user_id = Auth::guard('user')->user()->id;
    // $employee_list = new Employee();
    // $employee_ids = $employee_list->Employee_id();

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
      ->leftJoin('employee_bank_account_details', 'employee_bank_account_details.ebc_employee_id', '=', 'employees.id')
      ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name',
        'employee_bank_account_details.ebc_account_number',
        'employee_personal_infos.employee_gender'
      )
      ->where('employees.id', $employee_id)->first();
    // return response($user_employee_data->employee_sbu);
    $data['employee_data'] = array();
    // $employee_id = $employee_ids['employee_id'];

  
    foreach ($employee_data as $value) {
      array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . " - " . $value['employee_fullname']]);
    }

    // $user_employee_data_all = Employee::valid()->project()
    //   ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
    //   ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
    //   ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
    //   ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
    //   ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
    //   ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
    //   ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
    //   ->select(
    //     'employees.*',
    //     'company_sbus.sbu_name',
    //     'sections.section_name',
    //     'departments.department_name',
    //     'designations.designation_name',
    //     'sub_units.sub_unit_name',
    //     'work_locations.work_location_name',
    //     'employee_personal_infos.employee_gender'
    //   )
      // ->whereIn('employees.id', $employee_id)
      // ->whereIn('employee_sbu', $employee_ids['sub'])
      // ->whereIn('employee_department', $employee_ids['department'])
      // ->get()->keyBy('id');

    $salary_setting = SalarySetting::valid()->project()->where('status', 1)->where('company_sbu_id', $user_employee_data->employee_sbu)->first();
    $employee_salary = Salary::valid()->project()->where('employee_id', $id)->where('type', 1)->first();

    $data['salary_setting'] = $salary_setting;
    $data['employee_salary'] = $employee_salary;
    // $data['user_employee_data_all'] = $user_employee_data_all;
    $data['user_employee_data'] = $user_employee_data;

    $emp_salary = Salary::valid()->project()
      ->selectRaw(
        'salaries.*,
          sum(gross_salary) as gross_salary,
          sum(provident_fund_amount) as pf,
          sum(car_allowance_amount) as car_allowance_amount,
          sum(others_allowance) as others_allowance,
          sum(conveyance_allowance) as conveyance_allowance
          '
      )
      ->where('confirmation_date', '<=', date('Y-m-d'))
      ->where('employee_id', $id)
      ->groupBy('confirmation_date')
      ->groupBy('type')
      ->groupBy('salary_goes_to')
      ->get();
    $sub_id = collect($emp_salary)->first();
    // return response($emp_salary);
    if (!empty($sub_id)) {
      $data['company_sbu_id'] = $sub_id['company_sbu_id'];
      $data['salary_sbu_id'] = $sub_id['salary_sbu_id'];
    } else {
      $data['company_sbu_id'] = 0;
      $data['salary_sbu_id'] = 0;
    }

    $data['emp_salary'] = $emp_salary;
    $gross_salary = collect($emp_salary)->sum('gross_salary');
    $car_allowance_amount = collect($emp_salary)->sum('car_allowance_amount');
    $others_allowance = collect($emp_salary)->sum('others_allowance');
    $pf = collect($emp_salary)->sum('pf');
    $data['totalSalary'] = number_format((($gross_salary + $car_allowance_amount + $others_allowance)), 2);
    // $data['profile_open'] = 1;
    // this.profile_open = 1;
    return response($data);
  }

  public function findDepartmentMaxCode()
  {
    $last_entry_data = Increment::latest()->first();
    $department_last_code = $last_entry_data['department_code'];
    if ($department_last_code == 0) {
      $department_last_code = 101;
    } else {
      $department_last_code = $department_last_code + 1;
    }
    return $department_last_code;
  }
}
