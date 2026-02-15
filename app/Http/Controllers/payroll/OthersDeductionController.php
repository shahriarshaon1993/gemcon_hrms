<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\payroll\OthersDeduction;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\Department;
use App\Model\Designation;
use App\Model\JobGrade;
use App\Model\LeaveType;
use App\Model\LeaveApplication;
use App\Model\EmployeeApproval;
use App\Model\payroll\DeductionType;
use App\Model\UsersPersonModel;
use App\Model\payroll\SalarySetting;
use App\Model\payroll\Salary;
use Cache;
use Illuminate\Support\Facades\DB;
use permission;
// use App\Model\UserRoleAccess;

class OthersDeductionController extends Controller
{
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function get_deduction_type()
  {
    $deductionType = DeductionType::valid()->get();
    return response()->json($deductionType);
  }
  public function index(Request $request)
  {
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $cache = Cache::get('permission');
    $permission = collect($cache)->where('menu_uid', '=', 'OthersDeduction')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
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
    $paginate_data = OthersDeduction::valid()->project()
      ->leftJoin('employees',  'employees.id', '=', 'others_deduction.employee_id')
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->leftJoin('deduction_type', 'deduction_type.id', '=', 'others_deduction.deduction_type_id')
      ->select(
        'others_deduction.*',
        'employees.employee_id_no',
        'employees.employee_fullname',
        'employees.employee_joining_date',
        'company_sbus.sbu_name',
        'departments.department_name',
        'designations.designation_name',
        'work_locations.work_location_name',
        'deduction_type.type_name'
      )
      ->when($search_key, function ($query, $search_key) {
        $query->where(function ($query2) use ($search_key) {
          $query2->where('others_deduction.gross_salary', 'LIKE', '%' . $search_key . '%')
            ->orWhere('employees.employee_id_no', 'LIKE', '%' . $search_key . '%')
            ->orWhere('employees.employee_fullname', 'LIKE', '%' . $search_key . '%')
            ->orWhere('employees.employee_joining_date', 'LIKE', '%' . $search_key . '%')
            ->orWhere('company_sbus.sbu_name', 'LIKE', '%' . $search_key . '%')
            ->orWhere('departments.department_name', 'LIKE', '%' . $search_key . '%')
            ->orWhere('designations.designation_name', 'LIKE', '%' . $search_key . '%')
            ->orWhere('work_locations.work_location_name', 'LIKE', '%' . $search_key . '%');
        });
        return $query;
      })->where('others_deduction.project_id', $project_id)->orderBy($sort, $order);
    // ->paginate($paginate_num);
    $sortData = $paginate_data;

    $sortGetData = $sortData->get();
    $data['total_data'] = count($sortGetData);
    $data['inactive_data'] = count(collect($sortGetData)->whereIn('deduction_status', "!=", 1));
    $data['active_data'] = count(collect($sortGetData)->where('deduction_status', 1)->toArray());
    $data['total_uniform'] = collect($sortGetData)->where('deduction_types', 1)->sum('deduction_amount');
    $data['total_deposit'] = collect($sortGetData)->where('deduction_types', 2)->sum('deduction_amount');
    $data['total_others'] = collect($sortGetData)->where('deduction_types', 3)->sum('deduction_amount');
    $data['paginate_data'] = $sortData->paginate($paginate_num);

    return response()->json($data);
  }
  public function getDownload()
  {
    // dd('ok');
    //PDF file is stored under project/public/download/info.pdf
    $file = public_path() . "/download/others.xlsx";
    return response()->download($file);
  }
  public function excel(Request $request)
  {
    try {
      DB::beginTransaction();
      $file = collect($request->form_data)->toArray();
      $no_insert = array();
      foreach ($file as $key => $value) {
        $employee_data = Employee::valid()->project()->where('employee_id_no', $value['employee_id'])->first();
        if ($employee_data) {

          $data["employee_id"] = $employee_data->id;
          $data["company_sbu_id"] = $employee_data->employee_sbu;

          $data["branch_id"] = $employee_data->branch_id;
          $data["project_id"] = $employee_data->project_id;
          $data["deduction_status"] = 1;
          $data["deduction_amount"] = $value["deduction_amount"];
          $data["deduction_type_id"] = $value["deduction_type_id"];
          $data["deduction_date"] =  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value['deduction_date'])->format('Y-m-d');
          $data["deduction_remarks"] =  $value["deduction_remarks"] ?? '';


          OthersDeduction::create($data);
        } else {
          array_push($no_insert, "Employee data not found -> " . $value['employee_id']);
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
    // return response()->json($request);
    $validate = [
      'employee_id' => 'required',
      'company_sbu_id' => 'required'
    ];
    try {
      DB::beginTransaction();
      foreach ($request->deduction_multiple as $key => $value) {

        $request->validate($validate);
        $data = $request->only('deduction_types', 'employee_id', 'company_sbu_id', 'deduction_status', 'deduction_amount', 'deduction_date', 'deduction_remarks');
        $data['deduction_type_id'] = $value['deduction_type'];
        $data['deduction_amount'] = $value['deduction_amount'];
        $data['deduction_remarks'] = $value['deduction_remarks'];
        if (!empty($request->id)) {
          $update_data = OthersDeduction::valid()->project()->findOrFail($request->id);
          $data['updated_by'] = Auth::guard('user')->user()->id;
          $save_data = $update_data->update($data);
          $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
        } else {
          $data['project_id'] = Auth::guard('user')->user()->project_id;
          $data['branch_id'] = Auth::guard('user')->user()->branch_id;
          $data['created_by'] = Auth::guard('user')->user()->id;
          $data['deduction_status'] = 1;
          $save_data = OthersDeduction::create($data);
          $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
        }
      }
      DB::commit();
    } catch (\Exception $e) {
      dd($e);
      DB::rollback();
      $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
      // $message = ['status' => 0, 'message' => $e->getMessage()];
    }

    return response($message);
  }

  public function edit($id)
  {
    $data = OthersDeduction::valid()->project()->findOrFail($id);
    $employee_data = array();
    $employee_data_list = Employee::valid()->project()->get()->keyBy('id')->all();
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

    $salary_setting = SalarySetting::valid()->project()->where('status', 1)->where('company_sbu_id', $user_employee_data->employee_sbu)->first();
    $data->salary_setting = $salary_setting;

    $employee_salary = OthersDeduction::valid()->project()->where('employee_id', $data->employee_id)->first();
    $data->employee_salary = $employee_salary;

    $data->user_employee_data_all = $user_employee_data_all;
    $data->user_employee_data = $user_employee_data;
    $data->employee_data =  $employee_data;
    // return response($salary_setting);
    return response($data);
  }

  public function destroy($id)
  {

    $delete_data = OthersDeduction::valid()->project()->findOrFail($id);
    if ($delete_data->delete()) {
      $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
    }
    return response($message);
  }

  public function create($id = False)
  {
    $user_id = Auth::guard('user')->user()->id;
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $employee_id = $employee_ids['employee_id'];

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
    // return response($user_employee_data->employee_sbu);
    $data['employee_data'] = array();
    $employee_data = Employee::valid()->project()->get();
    foreach ($employee_data as $value) {
      array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . " - " . $value['employee_fullname']]);
    }

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
        'company_sbus.id as company_sbu_id',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name',
        'employee_personal_infos.employee_gender'
      )->whereIn('employee_sbu', $employee_ids['sub'])
      ->whereIn('employee_department', $employee_ids['department'])
      ->get()->keyBy('id');

    $salary_setting = SalarySetting::valid()->project()->where('status', 1)->where('company_sbu_id', $user_employee_data->employee_sbu)->first();
    $employee_salary = OthersDeduction::valid()
      // ->selectRaw(
      //   'others_deduction.*
      //   '
      // )
      ->project()->where('employee_id', $id)->get();

    $data['salary_setting'] = $salary_setting;
    // $data['employee_salary']= $employee_salary;
    $data['employee_salary']['gross_salary'] = collect($employee_salary)->sum('gross_salary');
    $data['employee_salary']['basic_salary'] = collect($employee_salary)->sum('basic_salary');
    $data['user_employee_data_all'] = $user_employee_data_all;
    $data['user_employee_data'] = $user_employee_data;
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
