<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\payroll\Salary;
use App\Model\payroll\Increment;
use App\Model\payroll\SimAllocation;
use App\Model\payroll\SimInventory;
use App\Model\Employee;
use App\Model\UsersPersonModel;
use Cache;
use Illuminate\Support\Facades\DB;
use permission;
// use App\Model\UserRoleAccess;

class SimAllocationController extends Controller
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
    $permission = collect($cache)->where('menu_uid', '=', 'SimAllocation')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
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
    $paginate_data = SimAllocation::valid()->project()
      ->leftJoin('employees',  'employees.id', '=', 'sim_assignings.sim_assign_to')
      ->leftJoin('sim_inventory',  'sim_inventory.id', '=', 'sim_assignings.sim_inventory_id')
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->selectRaw(
        'sim_assignings.*,
     sim_inventory.sim_number,
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
          $query2->where('sim_assignings.sim_ceiling_limit', 'LIKE', '%' . $search_key . '%')
            ->orWhere('sim_assignings.sim_assign_date', 'LIKE', '%' . $search_key . '%')
            ->orWhere('employees.employee_id_no', 'LIKE', '%' . $search_key . '%')
            ->orWhere('employees.employee_fullname', 'LIKE', '%' . $search_key . '%')
            ->orWhere('company_sbus.sbu_name', 'LIKE', '%' . $search_key . '%')
            ->orWhere('departments.department_name', 'LIKE', '%' . $search_key . '%')
            ->orWhere('designations.designation_name', 'LIKE', '%' . $search_key . '%');
        });
        return $query;
      })->whereIn('employees.id',$employee_id)->whereIn('company_sbus.id',$employee_ids['sub'])->where('sim_assignings.project_id', $project_id)->orderBy($sort, $order);
    // ->paginate($paginate_num);
    $sortData = $paginate_data;
    $sortGetData = $sortData->get();
    $data['total_data'] = count($sortGetData);
    $data['active_data'] = count(collect($sortGetData)->where('sim_assign_status', 1)->toArray());
    $data['inactive_data'] = count(collect($sortGetData)->whereIn('sim_assign_status', 0)->groupBy('sim_inventory_id')->toArray());
    $data['total_amount'] = collect($sortGetData)->where('sim_assign_status', 1)->sum('sim_ceiling_limit');
    $data['paginate_data'] = $sortData->paginate($paginate_num);
    return response()->json($data);
  }


  public function store(Request $request)
  {
    // echo "<pre>";print_r($this->findDepartmentMaxCode()); die();
    $validate = [
      'sim_assign_to' => 'required',
      'sim_inventory_id' => 'required'
    ];

    $request->validate($validate);
    $data = $request->only('sim_assign_to', 'sim_inventory_id', 'company_sbu_id', 'sim_assign_date', 'sim_ceiling_limit', 'sim_assign_status', 'sim_assign_remarks');

    if (!empty($request->id)) {
      $update_data = SimAllocation::valid()->project()->findOrFail($request->id);
      $first_data = SimAllocation::valid()->project()->where('id', '!=', $request->id)->where('sim_inventory_id', $update_data->sim_inventory_id)->where('sim_assign_status', 1)->first();

      if ($request->sim_assign_status == 1 && !$first_data) {

        $data['project_id'] = Auth::guard('user')->user()->project_id;
        $data['branch_id'] = Auth::guard('user')->user()->branch_id;
        $data['created_by'] = Auth::guard('user')->user()->id;
        $data['sim_assign_status'] = 1;
        $save_data = SimAllocation::create($data);
      } elseif ($request->sim_assign_status == 1 && $first_data) {
        $message = ['status' => 0, 'message' => 'Already Assigned'];
        return response($message);
      } else {
        $first_data =  null;
      }
      if (empty($first_data)) {
        if ($request->sim_assign_status == 1) {
          $onlydata['sim_assign_status'] = 0;
          // $onlydata['inactive_date'] = date('Y-m-d H:i:s');
          $onlydata['updated_by'] = Auth::guard('user')->user()->branch_id;
          $save_data = $update_data->update($onlydata);
        } else {
          $data['inactive_date'] = date('Y-m-d H:i:s');
          $data['updated_by'] = Auth::guard('user')->user()->branch_id;
          $save_data = $update_data->update($data);
        }
      } else {
        $message = ['status' => 0, 'message' => 'Already Assigned'];
        return response($message);
      }

      $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
    } else {
      $data['project_id'] = Auth::guard('user')->user()->project_id;
      $data['branch_id'] = Auth::guard('user')->user()->branch_id;
      $data['created_by'] = Auth::guard('user')->user()->id;
      $data['sim_assign_status'] = 1;
      // $data['type']=1; 
      $first_data = SimAllocation::valid()->project()->where('sim_inventory_id', $request->sim_inventory_id)->where('sim_assign_status', 1)->first();
      if (empty($first_data)) {
        $save_data = SimAllocation::create($data);
      } else {
        $message = ['status' => 0, 'message' => 'Already Assigned'];
        return response($message);
      }
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
    $data = SimAllocation::valid()->project()->findOrFail($id);
    $employee_data = array();
    $employee_data_list = Employee::valid()->project()->whereIn('employees.id',$employee_id)->get()->keyBy('id')->all();
    foreach ($employee_data_list as $value) {
      array_push($employee_data, ['id' => $value['id'], 'text' => $value['employee_id_no'] . " - " . $value['employee_fullname']]);
    }

    $sim_number_data = array();
    $sim_number_data_list = SimInventory::valid()->project()->get()->keyBy('id')->all();
    foreach ($sim_number_data_list as $key => $value) {
      array_push($sim_number_data, ['id' => $key, 'text' => $value['sim_number']]);
    }

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
      ->where('employees.id', $data->sim_assign_to)->first();



    if (!$data->sim_assign_to) {
      $data->employee_name_value = ['id' => '', 'text' => ''];
    } else {
      $data->employee_name_value = ['id' => $data->sim_assign_to, 'text' => $employee_data_list[$data->sim_assign_to]->employee_fullname];
    }

    if (!$data->sim_inventory_id) {
      $data->sim_number_value = ['id' => '', 'text' => ''];
    } else {
      $data->sim_number_value = ['id' => $data->sim_inventory_id, 'text' => $sim_number_data_list[$data->sim_inventory_id]->sim_number];
    }


    $data->user_employee_data = $user_employee_data;
    $data->sim_number_data = $sim_number_data;
    $data->employee_data =  $employee_data;
    // return response($salary_setting);
    return response($data);
  }

  public function destroy($id)
  {

    $delete_data = SimAllocation::valid()->project()->findOrFail($id);
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
    $employee_data = Employee::valid()->project()->whereIn('employees.id',$employee_id)->get();
    foreach ($employee_data as $value) {
      array_push($data['employee_data'], [
        'id' => $value['id'],
        'text' => $value['employee_id_no'] . " - " . $value['employee_fullname']
      ]);
    }
    $data['sim_number_data'] = array();
    $sim_number_data = SimInventory::valid()->project()
    ->select('sim_inventory.id', 'sim_number')
      ->leftJoin('sim_assignings', function ($join) {
        $join->on('sim_assignings.sim_inventory_id', '=', 'sim_inventory.id');
        $join->on('sim_assignings.sim_assign_status', '=', DB::raw(1));
      })
      ->get();
    foreach ($sim_number_data as $value) {
      if (!isset($value['sim_inventory_id'])) {
        array_push(
          $data['sim_number_data'],
          [
            'id' => $value['id'],
            'text' => $value['sim_number']
          ]
        );
      }
    }
    // sim_number_value
    $data['user_employee_data'] = $user_employee_data;
    return response($data);
  }

  public function findDepartmentMaxCode()
  {
    $last_entry_data = SimAllocation::latest()->where('type', 2)->first();
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

    $emp_salary = SimAllocation::valid()->project()->where('employee_id', $employee_id)->get();

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
    $emp_gratuity_fund = SimAllocation::valid()->project()->where('employee_id', $request->page_ref_id)->get();
    $emp_salary = Salary::valid()->project()->where('employee_id', $request->page_ref_id)->get();
    $data['user_employee_data'] = $user_employee_data;
    $data['emp_salary'] = $emp_salary;
    $data['emp_gratuity_fund'] = $emp_gratuity_fund;
    return response($data);
  }
}
