<?php
namespace App\Http\Controllers\payroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
// use Session;
use App\Model\payroll\Salary;
// use App\Model\payroll\Increment;
use App\Model\payroll\ArrearOthers;
use App\Model\Employee;
use App\Model\UsersPersonModel;
use Cache;
use DB;
// use permission;
// use App\Model\UserRoleAccess;

class ArrearOthersController extends Controller
{
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */

  public function index(Request $request)
  {
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $employee_id = $employee_ids['employee_id'];
    $cache = Cache::get('permission');
    $permission = collect($cache)->where('menu_uid', '=', 'ArrearOthersAllowances')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
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
    // $branch_id = Auth::guard('user')->user()->branch_id;edit
    $paginate_data = ArrearOthers::valid()->project()
      ->leftJoin('employees',  'employees.id', '=', 'additional_allowances.employee_id')
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->selectRaw(
        'additional_allowances.*,
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
            // ->orWhere('employees.employee_id_no','LIKE','%'.$search_key.'%')
            ->orWhere('employees.employee_fullname', 'LIKE', '%' . $search_key . '%')
            ->orWhere('company_sbus.sbu_name', 'LIKE', '%' . $search_key . '%')
            ->orWhere('departments.department_name', 'LIKE', '%' . $search_key . '%')
            ->orWhere('designations.designation_name', 'LIKE', '%' . $search_key . '%');
        });
        return $query;
      })->whereIn('employees.id', $employee_id)->where('additional_allowances.project_id', $project_id)->orderBy($sort, $order);
    // ->paginate($paginate_num);
    $sortData = $paginate_data;
    $sortGetData = $sortData->get();
    $data['total_data'] = count($sortGetData);
    $data['active_data'] = count(collect($sortGetData)->where('gf_status', 1)->toArray());
    $data['inactive_data'] = count(collect($sortGetData)->whereIn('gf_status', 2)->toArray());
    $data['total_arrear'] = collect($sortGetData)->where('additional_allow_type', 1)->sum('additional_amount');
    $data['total_others'] = collect($sortGetData)->where('additional_allow_type', 3)->sum('additional_amount');
    $data['paginate_data'] = $sortData->paginate($paginate_num);
    return response()->json($data);
  }


  public function store(Request $request)
  {
    // return response()->json($request);
    // echo "<pre>";print_r($request); die();
    $validate = [
      'employee_id' => 'required',
      'additional_allow_type' => 'required',
      'salary_goes_to' => 'required'
    ];

    $request->validate($validate);
    $data = $request->only('employee_id', 'additional_allow_type', 'additional_date', 'additional_amount', 'additional_status', 'additional_remarks', 'salary_goes_to');

    if (!empty($request->id)) {
      $update_data = ArrearOthers::valid()->project()->findOrFail($request->id);
      $data['updated_by'] = Auth::guard('user')->user()->branch_id;
      $save_data = $update_data->update($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
    } else {
      $data['project_id'] = Auth::guard('user')->user()->project_id;
      $data['branch_id'] = Auth::guard('user')->user()->branch_id;
      $data['created_by'] = Auth::guard('user')->user()->id;
      $data['additional_status'] = 1;
      // $data['type']=1; 
      $save_data = ArrearOthers::create($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
    }

    if (!$save_data) {
      $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
    }
    return response($message);
  }

  public function getDownload()
  {
    // dd('ok');
    //PDF file is stored under project/public/download/info.pdf
    $file = public_path() . "/download/arrear_others_allowance.xlsx";
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

          $data = $request->only('employee_id', 'additional_allow_type', 'additional_date', 'additional_amount', 'additional_status', 'additional_remarks', 'salary_goes_to');


          $data["employee_id"] = $employee_data->id;
          $data["additional_allow_type"] = $value["additional_allow_type"];
          $data["additional_amount"] = $value["additional_amount"];
          $data["additional_remarks"] = $value["additional_remarks"] ?? '';
          $data["additional_date"] =  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value['additional_date'])->format('Y-m-d');
          $data['project_id'] = Auth::guard('user')->user()->project_id;
          $data['branch_id'] = Auth::guard('user')->user()->branch_id;
          $data['created_by'] = Auth::guard('user')->user()->id;
          $data['additional_status'] = 1;

          ArrearOthers::create($data);
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

  public function edit($id)
  {
    // $employee_list = new Employee();
    // $employee_ids = $employee_list->Employee_id();
    // $employee_id = $employee_ids['employee_id'];
    $data = ArrearOthers::valid()->project()->findOrFail($id);
    $employee_data = array();
    // $employee_data_list = Employee::valid()->project()
    // ->whereIn('employees.id', $employee_id)
    // ->get()->keyBy('id')->all();
    // foreach ($employee_data_list as $value) {
    //   array_push($employee_data, ['id' => $value['id'], 'text' => $value['employee_id_no'] . " - " . $value['employee_fullname']]);
    // }

    // $employee_list = new Employee();
    // $employee_ids = $employee_list->Employee_id();
    // $employee_id = $employee_ids['employee_id'];

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
    //   )->whereIn('employees.id', $employee_id)->whereIn('employee_sbu', $employee_ids['sub'])
    //   ->whereIn('employee_department', $employee_ids['department'])
    //   ->get()->keyBy('id');

    // if (!$data->employee_id) {
    //   $data->employee_name_value = ['id' => '', 'text' => ''];
    // } else {
    //   $data->employee_name_value = ['id' => $data->employee_id, 'text' => $employee_data_list[$data->employee_id]->employee_fullname];
    // }

    // $salary_setting=SalarySetting::valid()->project()->where('status', 1)->first();
    // $data->salary_setting = $salary_setting;  
    // $data->user_employee_data_all = $user_employee_data_all;
    $data->user_employee_data = $user_employee_data;
    $data->employee_data =  $employee_data;
    // return response($salary_setting);
    return response($data);
  }

  public function destroy($id)
  {

    $delete_data = ArrearOthers::valid()->project()->findOrFail($id);
    if ($delete_data->delete()) {
      $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
    }
    return response($message);
  }

  public function create()
  {
    $user_id = Auth::guard('user')->user()->id;
    // $employee_list = new Employee();
    // $employee_ids = $employee_list->Employee_id();
    // $employee_id = $employee_ids['employee_id'];

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

    $data['employee_data'] = array();
    // $employee_id = $employee_ids['employee_id'];
    $employee_data = Employee::valid()->project()
    // ->whereIn('employees.id', $employee_id)
    ->get();
    foreach ($employee_data as $value) {
      array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_id_no'] . " - " . $value['employee_fullname']]);
    }
    $data['user_employee_data'] = $user_employee_data;
    return response($data);
  }

  public function findDepartmentMaxCode()
  {
    $last_entry_data = ArrearOthers::latest()->where('type', 2)->first();
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

    $emp_salary = ArrearOthers::valid()->project()->where('employee_id', $employee_id)->get();

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
    $emp_gratuity_fund = ArrearOthers::valid()->project()->where('employee_id', $request->page_ref_id)->get();
    $emp_salary = Salary::valid()->project()->where('employee_id', $request->page_ref_id)->get();
    $data['user_employee_data'] = $user_employee_data;
    $data['emp_salary'] = $emp_salary;
    $data['emp_gratuity_fund'] = $emp_gratuity_fund;
    return response($data);
  }
}
