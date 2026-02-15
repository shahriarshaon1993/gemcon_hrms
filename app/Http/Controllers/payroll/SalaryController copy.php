<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Requests\API\UpdateKPIAPIRequest;
use Auth;
use Session;
use App\Model\payroll\Salary;
// use App\Model\payroll\Increment;
use App\Model\payroll\SalarySetting;
use App\Model\payroll\PayrollList;
use App\Model\Employee;
use App\Model\EmployeeBankAccountDetail;
use App\Model\UsersPersonModel;
use App\Model\CompanySbu;
use App\Model\Department;
use App\Model\Designation;
use App\Model\EmployeeHistory;
use App\Model\WorkLocation;
use Cache;
use permission;
use DB;

// use App\Model\UserRoleAccess;

class SalaryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //  $salaryinfo = DB::table('tamp_salaries')
        //  ->leftjoin('employees', 'employees.employee_id_no', '=', 'tamp_salaries.employee_id')
        //  ->select('employees.*', 'tamp_salaries.employee_id', 'tamp_salaries.salaries','tamp_salaries.bank_account_number', 'tamp_salaries.id as t_id')
        //  ->where('tamp_salaries.status',0)
        //  ->get();
        // //  return response()->json($salaryinfo);

        //  $parolyInfo = DB::table('salary_settings')->get();
        // // Bank Account Entry
        //  foreach ($salaryinfo as $data) {
        //     $salaries = DB::table('employee_bank_account_details')->where('ebc_employee_id', $data->id)
        //      ->first();

        //      if (!empty($salaries)) {
        //         DB::table('employee_bank_account_details')->where('ebc_employee_id', $data->id)
        //            ->update([
        //                 'ebc_bank_name' => "DBBL",
        //                 'ebc_branch_district' => "",
        //                 'ebc_ac_holder_name' => $data->employee_fullname,
        //                 'ebc_account_number' => $data->bank_account_number ?? 0,
        //                 'status' => 1,
        //             ]);

        //      }else{

        //         $bankData = [
        //             'ebc_employee_id' => $data->id,
        //             'ebc_bank_name' => "DBBL",
        //             'ebc_branch_district' => "",
        //             'ebc_ac_holder_name' => $data->employee_fullname,
        //             'ebc_account_number' => $data->bank_account_number ?? 0,
        //             'status' => 1,
        //         ];

        //         DB::table('employee_bank_account_details')->insert($bankData);

        //     //    $a= EmployeeBankAccountDetail::create($bankData);
        //         // return response()->json([$salaries,  $bankData, $data->id,$data->bank_account_number]);
        //      }
        //     //  return response()->json([$data->id,$data->bank_account_number]);
        //      if(!empty($data->bank_account_number)){
        //         DB::table('salaries')->where('employee_id', $data->id)
        //        ->where('company_sbu_id', $data->employee_sbu)->update([
        //         'salary_goes_to' => 2,
        //         'gross_salary' => $data->salaries,
        //         'salary_on_gross_basic' => 2
        //        ]);
        //      }
        //     //  return response()->json([$salaries,  $bankData, $data->id,$data->bank_account_number]);


        //      DB::table('tamp_salaries')->where('id', $data->t_id)->update([
        //         'status' => 1,
        //       ]);


        //  }




        //  $parolyInfo = DB::table('salary_settings')->get();
        //  return response()->json($salaryinfo);
        //  foreach ($salaryinfo as $data) {
        //      $salariySeting = collect($parolyInfo)->where('company_sbu_id', $data->employee_sbu)->first();
        //      $basic_salary = ($data->salaries * $salariySeting->basic_salary) / 100;
        //      $housing_allowance = ($data->salaries * $salariySeting->housing_allowance) / 100;
        //      $medical_allowance = ($data->salaries * $salariySeting->medical_allowance) / 100;
        //      $conveyance_allowance = ($data->salaries * $salariySeting->conveyance_allowance) / 100;
        //      $overtime_work_compensation = ($data->salaries * $salariySeting->overtime_work_compensation) / 100;
        //      $provident_fund_amount = ($basic_salary * $salariySeting->provident_fund) / 100;
        //      $salaries = DB::table('salaries')->where('employee_id', $data->id)
        //      ->where('company_sbu_id', $data->employee_sbu)->first();

          // Managment salaray
            // if (!empty($salaries)) {
            //  DB::table('salaries')->where('employee_id', $data->id)
            //    ->where('company_sbu_id', $data->employee_sbu)->update([
            //           'employee_id' => $data->id,
            //           'company_sbu_id' => $data->employee_sbu,
            //           'salary_sbu_id' => $data->employee_sbu,
            //           'confirmation_date' => $data->employee_joining_date,
            //           'entry_date' => date('Y-m-d'),
            //           'salary_goes_to' => 1,
            //           'salary_on_gross_basic' => 1,
            //           'gross_salary' => $data->salaries,
            //           'gross_salary_bangla' => $data->salaries,
            //           'gross_salary_bangla_text' => "No Data",
            //           'basic_salary' => $basic_salary,
            //           'housing_allowance' => $housing_allowance,
            //           'medical_allowance' => $medical_allowance,
            //           'conveyance_allowance' => $conveyance_allowance,
            //           'overtime_work_compensation' => $overtime_work_compensation,
            //           'salary_status' => 1,
            //           'type' => 1,
            //           'provident_fund' => 1,
            //           'provident_fund_amount' => 0,
            //           //$provident_fund_amount,
            //           'car_allowance_status' => 0,
            //           'car_allowance_amount' => 0,
            //           'phone_allowance' => 0,
            //           'others_allowance' => 0,
            //           'increment_type' => 0,
            //           'increment_percentage' => 0,
            //           'project_id' => 8,
            //           'gratuity_fund' => 0,
            //           'branch_id' => 8,
            //           'created_at' => date('Y-m-d H:i:s'),
            //           'created_by' => 2023,
            //           'valid' => 1,
            //       ]);

            // } else {
            //     $data1 = [
            //          'employee_id' => $data->id,
            //          'company_sbu_id' => $data->employee_sbu,
            //          'salary_sbu_id' => $data->employee_sbu,
            //          'confirmation_date' => $data->employee_joining_date,
            //          'entry_date' => date('Y-m-d'),
            //          'salary_goes_to' => 1,
            //          'salary_on_gross_basic' => 1,
            //          'gross_salary' => $data->salaries,
            //          'gross_salary_bangla' => $data->salaries,
            //          'gross_salary_bangla_text' => "No Data",
            //          'basic_salary' => $basic_salary,
            //          'housing_allowance' => $housing_allowance,
            //          'medical_allowance' => $medical_allowance,
            //          'conveyance_allowance' => $conveyance_allowance,
            //          'overtime_work_compensation' => $overtime_work_compensation,
            //          'salary_status' => 1,
            //          'type' => 1,
            //          'provident_fund' => 1,
            //          'provident_fund_amount' => 0,
            //          //$provident_fund_amount,
            //          'car_allowance_status' => 0,
            //          'car_allowance_amount' => 0,
            //          'phone_allowance' => 0,
            //          'others_allowance' => 0,
            //          'increment_type' => 0,
            //          'increment_percentage' => 0,
            //          'project_id' => 8,
            //          'gratuity_fund' => 0,
            //          'branch_id' => 8,
            //          'created_at' => date('Y-m-d H:i:s'),
            //          'created_by' => 2023,
            //          'valid' => 1,
            //     ];
            //     // return response()->json($data1);
            //     Salary::create($data1);
            // }
            // Managment salaray
            // // NoManagment salaray
            // if (!empty($salaries)) {
            //     DB::table('salaries')->where('employee_id', $data->id)
            //     ->where('company_sbu_id', $data->employee_sbu)->update([
            //           'employee_id' => $data->id,
            //           'company_sbu_id' => $data->employee_sbu,
            //           'salary_sbu_id' => $data->employee_sbu,
            //           'confirmation_date' => $data->employee_joining_date,
            //           'entry_date' => date('Y-m-d'),
            //           'salary_goes_to' => 1,
            //           'salary_on_gross_basic' => 1,
            //           'gross_salary' => $data->salaries,
            //           'gross_salary_bangla' => $data->salaries,
            //           'gross_salary_bangla_text' => "No Data",
            //           'basic_salary' => 0,
            //           'housing_allowance' => 0,
            //           'medical_allowance' => 0,
            //           'conveyance_allowance' => 0,
            //           'overtime_work_compensation' => 0,
            //           'salary_status' => 1,
            //           'type' => 1,
            //           'provident_fund' => 1,
            //           'provident_fund_amount' => 0,
            //           'car_allowance_status' => 0,
            //           'car_allowance_amount' => 0,
            //           'phone_allowance' => 0,
            //           'others_allowance' => 0,
            //           'increment_type' => 0,
            //           'increment_percentage' => 0,
            //           'project_id' => 8,
            //           'gratuity_fund' => 0,
            //           'branch_id' => 8,
            //           'created_at' => date('Y-m-d H:i:s'),
            //           'created_by' => Auth::guard('user')->user()->id,
            //           'valid' => 1,
            //       ]);
            // } else {
            //     $data1 = [
            //          'employee_id' => $data->id,
            //          'company_sbu_id' => $data->employee_sbu,
            //          'salary_sbu_id' => $data->employee_sbu,
            //          'confirmation_date' => $data->employee_joining_date,
            //          'entry_date' => date('Y-m-d'),
            //          'salary_goes_to' => 1,
            //          'salary_on_gross_basic' => 1,
            //          'gross_salary' => $data->salaries,
            //          'gross_salary_bangla' => $data->salaries,
            //          'gross_salary_bangla_text' => "No Data",
            //          'basic_salary' => 0,
            //          'housing_allowance' => 0,
            //          'medical_allowance' => 0,
            //          'conveyance_allowance' => 0,
            //          'overtime_work_compensation' => 0,
            //          'salary_status' => 1,
            //          'type' => 1,
            //          'provident_fund' => 1,
            //          'provident_fund_amount' => 0,
            //          'car_allowance_status' => 0,
            //          'car_allowance_amount' => 0,
            //          'phone_allowance' => 0,
            //          'others_allowance' => 0,
            //          'increment_type' => 0,
            //          'increment_percentage' => 0,
            //          'project_id' => 8,
            //          'gratuity_fund' => 0,
            //          'branch_id' => 8,
            //          'created_at' => date('Y-m-d H:i:s'),
            //          'created_by' => Auth::guard('user')->user()->id,
            //          'valid' => 1,
            //     ];
            //     Salary::create($data1);
            // }
        //     DB::table('tamp_salaries')->where('id', $data->t_id)->update([
        //       'status' => 0,
        //     ]);
        //   }

        // return response()->json('ddd');

        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        $employee_id = $employee_ids['employee_id'];
        $cache = Cache::get('permission');
        $permission = collect($cache)->where('menu_uid', '=', 'Salary')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
        foreach ($permission as $child) {
            if ($child['link_uid'] == 'add') {
                $data['add'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'edit') {
                $data['edit'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'delete') {
                $data['delete'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'bank') {
                $data['bank'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'cash') {
                $data['cash'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'change') {
                $data['change'] = $child['link_uid'];
            }
            else {
                $data['view'] = $child['link_uid'];
            }
        }
        $paginate_num = $request->input('paginate_num') ?? 20;
        $search_key = $request->input('search_key');

        $order = $request->input('order') ? $request->input('order') : 'DESC';
        $sort = $request->input('sort') ? $request->input('sort') : 'id';
        $project_id = Auth::guard('user')->user()->project_id;
        // $branch_id = Auth::guard('user')->user()->branch_id;
        // return response()->json($search_key);
        $paginate_data = Salary::valid()
          ->leftJoin('employees', 'employees.id', '=', 'salaries.employee_id')
          ->selectRaw(
                'salaries.*,
                employees.employee_id_no,
                employees.employee_fullname,
                employees.employee_joining_date
                '
                )
                // up_b.updated_at
                // up_b.employee_card_no as updated_by_id,
                // up_b.name as updated_by_name,
          ->when($search_key, function ($query, $search_key) {
              $query->where(function ($query2) use ($search_key) {
                  $query2->where('employees.employee_id_no', 'LIKE', '%' . $search_key . '%')
                    // ->orWhere('employees.employee_id_no', 'LIKE', '%' . $search_key . '%')
                    // ->orWhere('employee_department', 'LIKE', '%' . $search_key . '%')
                    // ->orWhere('employee_designation', 'LIKE', '%' . $search_key . '%')
                    // ->orWhere('employee_sbu', 'LIKE', '%' . $search_key . '%')
                    ->orWhere('employees.employee_fullname', 'LIKE', '%' . $search_key . '%');
              });
              return $query;
          })
          ->where('salaries.project_id', $project_id)
          ->whereIn('employees.id', $employee_id)
          ->where('type', 1)

          ->where('salary_goes_to', '=', 2)
          ->orderBy($sort, $order);



        $sortData = $paginate_data;
        $sortGetData = $sortData->get();
        $data['total_data'] = count($sortGetData);
        $data['active_data'] = count(collect($sortGetData)->where('salary_status', 1)->toArray());
        $data['inactive_data'] = count(collect($sortGetData)->whereIn('salary_status', 2)->toArray());
        $data['paginate_data'] = $sortData->paginate($paginate_num);


        $paginate_dataaaa = Salary::valid()
          ->leftJoin('employees', 'employees.id', '=', 'salaries.employee_id')
          ->selectRaw(
              'salaries.*,
              employees.employee_id_no,
              employees.employee_fullname,
              employees.employee_joining_date
              '
          )
          ->when($search_key, function ($query, $search_key) {
              $query->where(function ($query2) use ($search_key) {
                  $query2->where('employees.employee_id_no', 'LIKE', '%' . $search_key . '%')
                    ->orWhere('employees.employee_fullname', 'LIKE', '%' . $search_key . '%');
                  // ->orWhere('employee_department', 'LIKE', '%' . $search_key . '%')
                  // ->orWhere('employee_designation', 'LIKE', '%' . $search_key . '%')
                  // ->orWhere('employee_sbu', 'LIKE', '%' . $search_key . '%');
                  // ->orWhere('employees.employee_fullname', 'LIKE', '%' . $search_key . '%');
              });
              return $query;
          })
          ->whereIn('employees.id', $employee_id)
        //   ->where('salaries.project_id', $project_id)
          ->where('type', 1)
          ->where('salary_goes_to', '=', 1)
          ->orderBy($sort, $order);
        $sortDataaaa = $paginate_dataaaa;
        $data['TotalcashSalary'] = collect($sortDataaaa)->count();
        $data['paginate_data1'] = $sortDataaaa->paginate($paginate_num);


        // $employee_id_salaries = Salary::valid()->get();
        // $employee_ids_salary = collect($employee_id_salaries)->pluck('employee_id');
        $paginate_data_2nd = Employee::valid()
        // ->project()
          ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
          ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
          ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
          ->leftJoin('salaries',  'employees.id', '=', 'salaries.employee_id')
          ->leftJoin('users_person',  'users_person.id', '=', 'salaries.created_by')
          ->leftJoin('users_person as up_b', 'salaries.updated_by', '=', 'up_b.id')
          ->leftJoin('employee_history', function($query) {
            $query->on('employee_history.employee_id','=','employees.id')
                ->whereRaw('employee_history.id IN (select MAX(a2.id) from employee_history as a2 join employees as u2 on u2.id = a2.employee_id group by u2.id)');
            })
        //   ->leftJoin('employee_history',  'employee_history.employee_id', '=', 'employees.id')
          ->selectRaw(
                'employees.*,
                employees.employee_type, 
                departments.department_name,
                designations.designation_name,
                company_sbus.sbu_name,
                job_grades.jobgrade_name,
                employee_history.one_off_bonus,
                sum(gross_salary) as gross_salary,
                users_person.employee_card_no as created_by_id,
                users_person.name as created_by_name,
                salaries.created_at as salary_created_at,
                up_b.employee_card_no as updated_by_id,
                up_b.name as updated_by_name,
                salaries.updated_at as salary_updated_at
              '
            //   salaries.gross_salary,
            // users_person.employee_card_no as created_by_id,
            //     users_person.name as created_by_name,
            //     users_person.created_at
          )
          ->when($search_key, function ($query, $search_key) {
              $query->where(function ($query2) use ($search_key) {
                  $query2->where('employees.employee_id_no', 'LIKE', '%' . $search_key . '%')
                  ->orWhere('employees.employee_fullname', 'LIKE', '%' . $search_key . '%')
                  ->orWhere('job_grades.jobgrade_name', 'LIKE', '%' . $search_key . '%')
                  ->orWhere('gross_salary', 'LIKE', '%' . $search_key . '%')
                  // ->orWhere('employee_designation', 'LIKE', '%' . $search_key . '%')
                  ->orWhere('company_sbus.sbu_name', 'LIKE', '%' . $search_key . '%');
              });
              return $query;
          })
          ->whereIn('employees.id', $employee_id)
        //   ->whereNotIn('employees.id', $employee_ids_salary)
          // ->where('salaries.type',1)
          ->where('employees.employee_status', '!=', 0)
          ;
        if ($request->department_name_value) {
            $paginate_data_2nd->where('employees.employee_department', '=', $request->department_name_value);
        }
        if ($request->sbu_name_value) {
            $paginate_data_2nd->where('employees.employee_sbu', '=', $request->sbu_name_value);
        }
        if ($request->work_location_value) {
            $paginate_data_2nd->where('employees.employee_work_location', '=', $request->work_location_value);
        }
        if ($request->designation_name_value) {
            $paginate_data_2nd->where('employees.employee_designation', '=', $request->designation_name_value);
        }
        // ->where('salary_goes_to','')
        $data['paginate_data_2nd'] = $paginate_data_2nd->groupBy('employees.id')->orderBy($sort, $order)->paginate($paginate_num);



        $data['salary_employee_list'] = 0;
        // $sortDataaaa = $paginate_dataaaa_employee;
        // $data['paginate_data_2nd'] = $sortDataaaa->paginate($paginate_num);

        $data['company_sbu_data'] = array();
        $data['work_location_data'] = array();
        $data['department_data'] = array();
        $data['designation_data'] = array();
        $work_location_data = WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get();
        $company_sbu_data = CompanySbu::valid()->project()->whereIn('id', $employee_ids['sub'])->orderBy('priority', 'ASC')->get();
        $department_data = Department::valid()->project()->whereIn('id', $employee_ids['department'])->orderBy('priority', 'ASC')->get();
        $designation_data = Designation::valid()->project()->whereIn('id', $employee_ids['designation'])->orderBy('priority', 'ASC')->get();
       
        array_push($data['work_location_data'], ['id' => '', 'text' => 'All Select']);
        foreach ($work_location_data as $value) {
            array_push($data['work_location_data'], ['id' => $value['id'], 'text' => $value['work_location_name']]);
        }

        array_push($data['company_sbu_data'], ['id' => '', 'text' => 'All Select']);
        foreach ($company_sbu_data as $value) {
            array_push($data['company_sbu_data'], ['id' => $value['id'], 'text' => $value['sbu_name']]);
        }
        array_push($data['department_data'], ['id' => '', 'text' => 'All Select']);
        foreach ($department_data as $value) {
            array_push($data['department_data'], ['id' => $value['id'], 'text' => $value['department_name']]);
        }
        array_push($data['designation_data'], ['id' => '', 'text' => 'All Select']);
        foreach ($designation_data as $value) {
            array_push($data['designation_data'], ['id' => $value['id'], 'text' => $value['designation_name']]);
        }

        if (!$request->sbu_name_value) {
            $data['company_sbu_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['company_sbu_value'] = [['id' => $request->sbu_name_value, 'text' => $company_sbu_data[$request->sbu_name_value]->sbu_name]];
        }
        // if (!$request->sbu_name_value) {
        //     $data['department_name_value'] = ['id' => '', 'text' => ''];
        // } else {
        //     $data['department_name_value'] = [['id' => $request->sbu_name_value, 'text' => $company_sbu_data[$request->sbu_name_value]->sbu_name]];
        // }
        // if (!$request->sbu_name_value) {
        //     $data['company_sbu_value'] = ['id' => '', 'text' => ''];
        // } else {
        //     $data['company_sbu_value'] = [['id' => $request->sbu_name_value, 'text' => $company_sbu_data[$request->sbu_name_value]->sbu_name]];
        // }
        // if (!$request->sbu_name_value) {
        //     $data['company_sbu_value'] = ['id' => '', 'text' => ''];
        // } else {
        //     $data['company_sbu_value'] = [['id' => $request->sbu_name_value, 'text' => $company_sbu_data[$request->sbu_name_value]->sbu_name]];
        // }

        return response()->json($data);
    }


    public function store(Request $request)
    {
        // return response()->json($request->user_employee_data['ebc_account_number']);

        // echo "<pre>";print_r($this->findDepartmentMaxCode()); die();

        $validate = [
          'employee_id' => 'required',
          'gross_salary' => 'required',
          'salary_sbu_id' => 'required',
          'confirmation_date' => 'required',
        ];

        $request->validate($validate);
        $data = $request->only('employee_id', 'gross_salary', 'company_sbu_id', 'confirmation_date', 'basic_salary', 'housing_allowance', 'medical_allowance', 'conveyance_allowance', 'overtime_work_compensation', 'salary_status', 'provident_fund', 'car_allowance_status', 'others_allowance', 'phone_allowance', 'salary_sbu_id', 'gratuity_fund', 'salary_goes_to', 'entry_date');

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
            $update_data = Salary::valid()->project()->findOrFail($request->id);
            $data['updated_by'] = Auth::guard('user')->user()->branch_id;
            $save_data = $update_data->update($data);
            if (empty($request->user_employee_data['ebc_account_number'])) {
                // $data1['salary_id']=$save_data->id;
                $data1['ebc_employee_id'] = $request->employee_id;
                $data1['ebc_bank_name'] = '';
                $data1['ebc_branch_district'] = '';
                $data1['ebc_ac_holder_name'] = '';
                $data1['ebc_account_number'] = $request->user_employee_data['ebc_account_number'];
                $data1['project_id'] = Auth::guard('user')->user()->project_id;
                $data1['branch_id'] = Auth::guard('user')->user()->branch_id;
                $data1['created_by'] = Auth::guard('user')->user()->id;
                $data1['created_at'] = date('Y-m-d');
                $data1['status'] = $request->user_employee_data['bank_status'] ?? 1;
                EmployeeBankAccountDetail::create($data1);
            } else {
                // dd(1);
                $data_user_employee = ['ebc_account_number' => $request->user_employee_data['ebc_account_number']];
                $data_user_employee['status'] = $request->user_employee_data['bank_status'] ?? 1;
                $update_data = EmployeeBankAccountDetail::where('ebc_employee_id', $request->employee_id)->first();
                $data_user_employee['updated_by'] = Auth::guard('user')->user()->branch_id;
                $save_data = $update_data->update($data_user_employee);
            }
            $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
        } else {
            // $data['department_code'] = $this->findDepartmentMaxCode();
            $data['car_allowance_amount'] = $car_allowance_amount;
            $data['provident_fund_amount'] = $provident_fund_amount;
            $data['project_id'] = Auth::guard('user')->user()->project_id;
            $data['branch_id'] = Auth::guard('user')->user()->branch_id;
            $data['created_by'] = Auth::guard('user')->user()->id;
            $data['salary_status'] = 1;
            $data['type'] = 1;
            $data['entry_date'] = date('Y-m-d');
            $save_data = Salary::create($data);
            if (empty($request->user_employee_data['ebc_account_number'])) {
                // $data1['salary_id']=$save_data->id;
                $data1['ebc_employee_id'] = $request->employee_id;
                $data1['ebc_bank_name'] = '';
                $data1['ebc_branch_district'] = '';
                $data1['ebc_ac_holder_name'] = '';
                $data1['ebc_account_number'] = $request->user_employee_data['ebc_account_number'];
                $data1['project_id'] = Auth::guard('user')->user()->project_id;
                $data1['branch_id'] = Auth::guard('user')->user()->branch_id;
                $data1['created_by'] = Auth::guard('user')->user()->id;
                $data1['created_at'] = date('Y-m-d');
                $data1['status'] = $request->user_employee_data['bank_status'] ?? 1;
                EmployeeBankAccountDetail::create($data1);
            } else {
                $data_user_employee = ['ebc_account_number' => $request->user_employee_data['ebc_account_number']];
                $data_user_employee['status'] = $request->user_employee_data['bank_status'] ?? 1;
                $update_data =  EmployeeBankAccountDetail::where('ebc_employee_id', $request->employee_id)->first();
                $data_user_employee['updated_by'] = Auth::guard('user')->user()->branch_id;
                $save_data = $update_data->update($data_user_employee);
            }


            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
        }

        if (!$save_data) {
            $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
        }
        return response($message);
    }

    public function store_or_update(Request $request)
    {
        // echo '<per>'; print_r($request); die();
        // return response($request);
        // echo "<pre>";print_r($this->findDepartmentMaxCode()); die();
        // if ($request->bank_gross_salary > 0 && $request->cash_gross_salary > 0) {
        $validate = [
            'employee_id' => 'required',
            'gross_salary' => 'required',
            'salary_sbu_id' => 'required',
            // 'confirmation_date' => 'required',
            // 'cash_gross_salary' => 'required',
            // 'cash_salary_sbu_id' => 'required',
            // 'cash_confirmation_date' => 'required',
        ];
        // } 
        // elseif ($request->bank_gross_salary > 0) {
        //     $validate = [
        //       'employee_id' => 'required',
        //       'gross_salary' => 'required',
        //       'salary_sbu_id' => 'required',
        //       'confirmation_date' => 'required',
        //     ];
        // } elseif ($request->cash_gross_salary > 0) {
        //     $validate = [
        //       'employee_id' => 'required',
        //       'cash_gross_salary' => 'required',
        //       'cash_salary_sbu_id' => 'required',
        //       'confirmation_date' => 'required',
        //     ];
        // }
        DB::beginTransaction();

        try {
            $request->validate($validate);
            $data_bank = $request->only(
                'employee_id', 
                // 'gross_salary', 
                'company_sbu_id', 
                'confirmation_date', 
                // 'basic_salary', 
                // 'housing_allowance', 
                // 'medical_allowance', 
                // 'conveyance_allowance', 
                // 'overtime_work_compensation', 
                // 'salary_status', 
                // 'provident_fund', 
                'car_allowance_status', 
                'others_allowance', 
                'phone_allowance', 
                'salary_sbu_id', 
                'gratuity_fund', 
                'provident_fund', 
                // 'salary_goes_to'
            );

           
            if($request['one_off_bonus'] >= 0){
                // $one_off_bonus = DB::table('employee_history')->where('employee_id', $request['employee_id'])->orderBy('id','desc')->take(1)->update(['one_off_bonus' => $request['one_off_bonus']]);
                $employee_info = Employee::valid()->where('id', $request->employee_id)->first();
                $employee_history = EmployeeHistory::valid()->where('employee_id', $request->employee_id)->first();

               
                if(!empty($employee_history->pi_first_date)){
                    $pi_first_date = $employee_history->pi_first_date;
                }else{
                    $pi_first_date = date('Y-m-d');
                }
                if(!empty($employee_history->pi_last_date)){
                    $pi_last_date = $employee_history->pi_last_date;
                }else{
                    $pi_last_date = date('Y-m-d');
                }
                if(!empty($employee_history->effective_date)){
                    $effective_date = $employee_history->effective_date;
                }else{
                    $effective_date = date('Y-m-d');
                }

                if(!empty($employee_history->gross_salary)){
                    $gross_salary = $employee_history->gross_salary;
                }else{
                    $gross_salary = $request->gross_salary ?? 0;
                }

                if(!empty($employee_history->increment_amount)){
                    $increment_amount = $employee_history->increment_amount;
                }else{
                    $increment_amount = $request->increment_amount;
                }

                
                $one_off_bonus = $request->one_off_bonus ?? 0;
                
                // dd($employee_info);

                $data['employee_id'] = $employee_info['id'];
                $data['employee_sbu'] = $employee_info['employee_sbu'];
                $data['employee_department'] = $employee_info['employee_department'];
                $data['employee_designation'] = $employee_info['employee_designation'];
                $data['employee_group'] = $employee_info['employee_group'];
                $data['employee_job_grade'] = $employee_info['employee_job_grade'];
                $data['employee_reporting_to'] = $employee_info['employee_reporting_to'];
                $data['employee_work_location'] = $employee_info['employee_work_location'];
                $data['employee_sub_section'] = $employee_info['employee_sub_section'];
                $data['employee_section'] = $employee_info['employee_section'];
                $data['employee_sub_unit'] = $employee_info['employee_sub_unit'];
                $data['employee_unit'] = $employee_info['employee_unit'];
                $data['employee_type'] = $employee_info['employee_type'];
                $data['effective_date'] = $effective_date;
                $data['pi_first_date'] = $pi_first_date;
                $data['pi_last_date'] = $pi_last_date;
                $data['history_status'] = 1;
                $data['previous_salary'] = $gross_salary;
                $data['new_salary'] = $gross_salary;
                $data['increment_amount'] = $increment_amount;
                $data['one_off_bonus'] = $one_off_bonus;
                $data['desk_phone_no'] = $employee_info['desk_phone_no'];
                // $data['remarks'] = '';
                $data['updated_at'] = date('Y-m-d');
                $data['updated_by'] = Auth::guard('user')->user()->id;
                EmployeeHistory::orderBy('id','desc')->take(1)->updateOrCreate(
                    [
                        'employee_id' => $request->employee_id
                    ],
                    $data
                );
            }

            if ($request['car_allowance_status'] == 1) {
                $car_allowance_amount = $request['car_allowance_amount'];
            } else {
                $car_allowance_amount = 0;
            }

            if ($request->bank_gross_salary >= 0) {
                if ($request->bank_id) {
                    if ($request['provident_fund'] == 1) {
                        $provident_fund_amount = $request['provident_fund_amount'];
                        $provident_fund = 1;
                    } else {
                        $provident_fund_amount = 0;
                        $provident_fund = 0;
                    }

                    $data_bank['gross_salary'] = $request['bank_gross_salary'] ?? 0;
                    $data_bank['basic_salary'] = $request['bank_basic_salary'] ?? 0;
                    $data_bank['housing_allowance'] = $request['bank_housing_allowance'] ?? 0;
                    $data_bank['medical_allowance'] = $request['bank_medical_allowance'] ?? 0;
                    $data_bank['conveyance_allowance'] = $request['bank_conveyance_allowance'] ?? 0;
                    $data_bank['overtime_work_compensation'] = $request['bank_overtime_work_compensation'] ?? 0;
                    $data_bank['car_allowance_amount'] = $car_allowance_amount;
                    $data_bank['provident_fund_amount'] = $provident_fund_amount;
                    $data_bank['salary_status'] = 1;
                    $data_bank['salary_goes_to'] = 2;
                    $data_bank['type'] = 1;
                    $data_bank['provident_fund'] = $provident_fund;
                    $data_bank['gratuity_fund'] = $request['gratuity_fund'] ?? 0;
                    $data_bank['updated_by'] = Auth::guard('user')->user()->id;
                    $data_bank['updated_at'] = date('Y-m-d');
                    $update_data = Salary::valid()->project()->findOrFail($request->bank_id);
                    $data_bank['updated_by'] = Auth::guard('user')->user()->branch_id;
                    if ($request->cash_gross_basic == 1) {
                        unset($data_bank['car_allowance_amount']);
                        unset($data_bank['provident_fund_amount']);
                        unset($data_bank['housing_allowance']);
                        unset($data_bank['medical_allowance']);
                        unset($data_bank['conveyance_allowance']);
                        unset($data_bank['overtime_work_compensation']);
                        unset($data_bank['provident_fund']);
                        unset($data_bank['car_allowance_status']);
                        unset($data_bank['others_allowance']);
                        unset($data_bank['phone_allowance']);
                        unset($data_bank['gratuity_fund']);
                        unset($data_bank['basic_salary']);
                    }
                    // dd($data_bank);
                    $save_data = $update_data->update($data_bank);
                    // if (empty($request->user_employee_data['ebc_account_number'])) {
                    // $data1['salary_id']=$save_data->id;
                    $data1['ebc_employee_id'] = $request->employee_id;
                    $data1['ebc_bank_name'] = '';
                    $data1['ebc_branch_district'] = '';
                    $data1['ebc_ac_holder_name'] = '';
                    $data1['ebc_account_number'] = $request->user_employee_data['ebc_account_number'];
                    $data1['project_id'] = Auth::guard('user')->user()->project_id;
                    $data1['branch_id'] = Auth::guard('user')->user()->branch_id;
                    $data1['created_by'] = Auth::guard('user')->user()->id;
                    $data1['created_at'] = date('Y-m-d');
                    $data1['status'] = $request['bank_status'] ?? 1;
                    // EmployeeBankAccountDetail::create($data1);
                    // dd($data1);
                    EmployeeBankAccountDetail::updateOrCreate(
                        [
                            'ebc_employee_id' => $request->employee_id
                            // 'ebc_account_number' => '11111'
                        ],
                        $data1
                    );
                    // } else {
                    //   $data_user_employee = ['ebc_account_number' => $request->user_employee_data['ebc_account_number']];
                    //   $update_data = EmployeeBankAccountDetail::valid()->findOrFail($request->employee_id);
                    //   $data_user_employee['updated_by'] = Auth::guard('user')->user()->branch_id;
                    //   $save_data = $update_data->update($data_user_employee);
                    // }
                    $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
                } else {
                    // $data['department_code'] = $this->findDepartmentMaxCode();
                    if ($request['provident_fund'] == 1) {
                        $provident_fund_amount = $request['provident_fund_amount'];
                        $provident_fund = 1;
                        // $provident_fund = $request['cash_provident_fund_amount'];
                    } else {
                        $provident_fund_amount = 0;
                        $provident_fund = 0;
                    }
                    $data_bank['gross_salary'] = $request['bank_gross_salary'] ?? 0;
                    $data_bank['basic_salary'] = $request['bank_basic_salary'] ?? 0;
                    $data_bank['housing_allowance'] = $request['bank_housing_allowance'] ?? 0;
                    $data_bank['medical_allowance'] = $request['bank_medical_allowance'] ?? 0;
                    $data_bank['conveyance_allowance'] = $request['bank_conveyance_allowance'] ?? 0;
                    $data_bank['overtime_work_compensation'] = $request['bank_overtime_work_compensation'] ?? 0;
                    $data_bank['car_allowance_amount'] = $car_allowance_amount;
                    $data_bank['provident_fund_amount'] = $provident_fund_amount;
                    $data_bank['salary_status'] = 1;
                    $data_bank['salary_goes_to'] = 2;
                    $data_bank['type'] = 1;
                    $data_bank['provident_fund'] = $provident_fund;
                    $data_bank['gratuity_fund'] = $request['gratuity_fund'] ?? 0;
                    // $data_bank['updated_by'] = Auth::guard('user')->user()->id;
                    // $data_bank['updated_at'] = date('Y-m-d');

                    // $data_bank['car_allowance_amount'] = $car_allowance_amount;
                    // $data_bank['provident_fund_amount'] = $provident_fund_amount;
                    $data_bank['project_id'] = Auth::guard('user')->user()->project_id;
                    $data_bank['branch_id'] = Auth::guard('user')->user()->branch_id;
                    $data_bank['created_by'] = Auth::guard('user')->user()->id;
                    // $data_bank['salary_status'] = 1;
                    // $data_bank['type'] = 1;
                    $data_bank['entry_date'] = date('Y-m-d H:i:s');
                    if ($request->bank_gross_basic==1) {
                        unset($data_bank['car_allowance_amount']);
                        unset($data_bank['provident_fund_amount']);
                        unset($data_bank['housing_allowance']);
                        unset($data_bank['medical_allowance']);
                        unset($data_bank['conveyance_allowance']);
                        unset($data_bank['overtime_work_compensation']);
                        unset($data_bank['provident_fund']);
                        unset($data_bank['car_allowance_status']);
                        unset($data_bank['others_allowance']);
                        unset($data_bank['phone_allowance']);
                        unset($data_bank['gratuity_fund']);
                        unset($data_bank['basic_salary']);
                    }

                    // dd($data_bank);
                    $save_data = Salary::create($data_bank);
                    if (EmployeeBankAccountDetail::valid()->where('ebc_employee_id', $request->employee_id)->first()) {
                        $data_user_employee = ['ebc_account_number' => $request->user_employee_data['ebc_account_number']];
                        $update_data = EmployeeBankAccountDetail::valid()->where('ebc_employee_id', $request->employee_id);
                        $data_user_employee['updated_by'] = Auth::guard('user')->user()->branch_id;
                        $save_data = $update_data->update($data_user_employee);
                    } else {
                        $data1['ebc_employee_id'] = $request->employee_id;
                        $data1['ebc_bank_name'] = '';
                        $data1['ebc_branch_district'] = '';
                        $data1['ebc_ac_holder_name'] = '';
                        $data1['ebc_account_number'] = $request->user_employee_data['ebc_account_number'] ?? 0;
                        $data1['project_id'] = Auth::guard('user')->user()->project_id;
                        $data1['branch_id'] = Auth::guard('user')->user()->branch_id;
                        $data1['created_by'] = Auth::guard('user')->user()->id;
                        $data1['created_at'] = date('Y-m-d');
                        $data1['status'] = $request['bank_status'] ?? 1;
                        EmployeeBankAccountDetail::updateOrCreate(
                            ['ebc_employee_id' => $request->employee_id],
                            $data1
                        );
                    }

                    //   EmployeeBankAccountDetail::create($data1);
                    // } else {
                    //   $data_user_employee = ['ebc_account_number' => $request->user_employee_data['ebc_account_number']];
                    //   $update_data = EmployeeBankAccountDetail::valid()->findOrFail($request->employee_id);
                    //   $data_user_employee['updated_by'] = Auth::guard('user')->user()->branch_id;
                    //   $save_data = $update_data->update($data_user_employee);
                    // }


                    $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
                }
            }
            if ($request->cash_gross_salary >=0) {
               
                if ($request['cash_car_allowance_status'] == 1) {
                    $cash_car_allowance_amount = $request['cash_car_allowance_amount'];
                } else {
                    $cash_car_allowance_amount = 0;
                }
               

                if ($request['provident_fund'] == 1) {
                    $cash_provident_fund_amount = $request['cash_provident_fund_amount'];
                    $provident_fund = 1;
                    // $provident_fund = $request['cash_provident_fund_amount'];
                } else {
                    $cash_provident_fund_amount = 0;
                    $provident_fund = 0;
                }
                if ($request->cash_id) {
                    $data_cash['employee_id'] = $request->employee_id;
                    $data_cash['gross_salary'] = $request->cash_gross_salary ?? 0;
                    $data_cash['company_sbu_id'] = $request->company_sbu_id;
                    $data_cash['confirmation_date'] = $request->confirmation_date;
                    $data_cash['basic_salary'] = $request->cash_basic_salary ?? 0;
                    $data_cash['housing_allowance'] = $request->cash_housing_allowance ?? 0;
                    $data_cash['medical_allowance'] = $request->cash_medical_allowance ?? 0;
                    $data_cash['conveyance_allowance'] = $request->cash_conveyance_allowance ?? 0;
                    $data_cash['overtime_work_compensation'] = $request->cash_overtime_work_compensation ?? 0;
                    $data_cash['provident_fund'] = $request->cash_provident_fund ?? 0;
                    $data_cash['car_allowance_status'] = $request->car_allowance_status ?? 0;
                    $data_cash['others_allowance'] = $request->cash_others_allowance ?? 0;
                    $data_cash['phone_allowance'] = $request->cash_phone_allowance ?? 0;
                    $data_cash['salary_sbu_id'] = $request->cash_salary_sbu_id ?? 0;
                    $data_cash['gratuity_fund'] = $request->gratuity_fund ?? 0;
                    $data_cash['salary_goes_to'] = 1;
                    $data_cash['entry_date'] = $request->cash_entry_date;

                    $data_cash['car_allowance_amount'] = $cash_car_allowance_amount;
                    $data_cash['provident_fund_amount'] = $cash_provident_fund_amount;
                    $data_cash['provident_fund'] = $provident_fund;
                    $update_data_cash = Salary::valid()->project()->findOrFail($request->cash_id);
                    $data_cash['updated_by'] = Auth::guard('user')->user()->branch_id;
                    if ($request->cash_gross_basic==1) {
                        unset($data_cash['car_allowance_amount']);
                        unset($data_cash['provident_fund_amount']);
                        unset($data_cash['housing_allowance']);
                        unset($data_cash['medical_allowance']);
                        unset($data_cash['conveyance_allowance']);
                        unset($data_cash['overtime_work_compensation']);
                        unset($data_cash['provident_fund']);
                        unset($data_cash['car_allowance_status']);
                        unset($data_cash['others_allowance']);
                        unset($data_cash['gratuity_fund']);
                        unset($data_cash['basic_salary']);
                    }
                    $save_data_cash = $update_data_cash->update($data_cash);

                    // if (empty($request->user_employee_data['ebc_account_number'])) {
                    // $data1['salary_id']=$save_data->id;
                    // $data1['ebc_employee_id'] = $request->employee_id;
                    // $data1['ebc_bank_name'] = '';
                    // $data1['ebc_branch_district'] = '';
                    // $data1['ebc_ac_holder_name'] = '';
                    // $data1['ebc_account_number'] = $request->user_employee_data['ebc_account_number'];
                    // $data1['project_id'] = Auth::guard('user')->user()->project_id;
                    // $data1['branch_id'] = Auth::guard('user')->user()->branch_id;
                    // $data1['created_by'] = Auth::guard('user')->user()->id;
                    // $data1['created_at'] = date('Y-m-d');
                    // EmployeeBankAccountDetail::create($data1);
                    // EmployeeBankAccountDetail::updateOrCreate(
                    //   ['ebc_account_number' => $request->user_employee_data['ebc_account_number']],
                    //   $data1
                    // );
                    // } else {
                    //   $data_user_employee = ['ebc_account_number' => $request->user_employee_data['ebc_account_number']];
                    //   $update_data = EmployeeBankAccountDetail::valid()->findOrFail($request->employee_id);
                    //   $data_user_employee['updated_by'] = Auth::guard('user')->user()->branch_id;
                    //   $save_data = $update_data->update($data_user_employee);
                    // }
                    $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
                } else {
                    // $data['department_code'] = $this->findDepartmentMaxCode();
                    $data_cash['employee_id'] = $request->employee_id;
                    $data_cash['gross_salary'] = $request->cash_gross_salary ?? 0;
                    $data_cash['company_sbu_id'] = $request->company_sbu_id;
                    $data_cash['confirmation_date'] = $request->confirmation_date;
                    $data_cash['basic_salary'] = $request->cash_basic_salary ?? 0;
                    $data_cash['housing_allowance'] = $request->cash_housing_allowance ?? 0;
                    $data_cash['medical_allowance'] = $request->cash_medical_allowance ?? 0;
                    $data_cash['conveyance_allowance'] = $request->cash_conveyance_allowance ?? 0;
                    $data_cash['overtime_work_compensation'] = $request->cash_overtime_work_compensation ?? 0;
                    // $data_cash['provident_fund'] = $request->cash_provident_fund;
                    $data_cash['provident_fund'] = $request->provident_fund ?? 0;
                    $data_cash['car_allowance_status'] = $request->car_allowance_status ?? 0;
                    $data_cash['others_allowance'] = $request->cash_others_allowance ?? 0;
                    $data_cash['salary_sbu_id'] = $request->cash_salary_sbu_id;
                    $data_cash['gratuity_fund'] = $request->gratuity_fund ?? 0;
                    $data_cash['salary_goes_to'] = 1;
                    $data_cash['entry_date'] = $request->cash_entry_date;


                    $data_cash['car_allowance_amount'] = $cash_car_allowance_amount ?? 0;
                    $data_cash['provident_fund_amount'] = $cash_provident_fund_amount ?? 0;
                    $data_cash['project_id'] = Auth::guard('user')->user()->project_id;
                    $data_cash['branch_id'] = Auth::guard('user')->user()->branch_id;
                    $data_cash['created_by'] = Auth::guard('user')->user()->id;
                    $data_cash['salary_status'] = 1;
                    $data_cash['type'] = 1;
                    $data_cash['entry_date'] = date('Y-m-d');
                    if ($request->cash_gross_basic==1) {
                        unset($data_cash['car_allowance_amount']);
                        unset($data_cash['provident_fund_amount']);
                        unset($data_cash['housing_allowance']);
                        unset($data_cash['medical_allowance']);
                        unset($data_cash['conveyance_allowance']);
                        unset($data_cash['overtime_work_compensation']);
                        unset($data_cash['provident_fund']);
                        unset($data_cash['car_allowance_status']);
                        unset($data_cash['others_allowance']);
                        unset($data_cash['phone_allowance']);
                        unset($data_cash['gratuity_fund']);
                        unset($data_cash['basic_salary']);
                    }
                    $save_data_cash = Salary::create($data_cash);
                    // if (EmployeeBankAccountDetail::valid()->where('ebc_employee_id', $request->employee_id)->first()) {
                    //   $data_user_employee = ['ebc_account_number' => $request->user_employee_data['ebc_account_number']];
                    //   $update_data = EmployeeBankAccountDetail::valid()->where('ebc_employee_id', $request->employee_id);
                    //   $data_user_employee['updated_by'] = Auth::guard('user')->user()->branch_id;
                    //   $save_data_cash = $update_data->update($data_user_employee);
                    // } else {
                    //   $data1['ebc_employee_id'] = $request->employee_id;
                    //   $data1['ebc_bank_name'] = '';
                    //   $data1['ebc_branch_district'] = '';
                    //   $data1['ebc_ac_holder_name'] = '';
                    //   $data1['ebc_account_number'] = $request->user_employee_data['ebc_account_number'];
                    //   $data1['project_id'] = Auth::guard('user')->user()->project_id;
                    //   $data1['branch_id'] = Auth::guard('user')->user()->branch_id;
                    //   $data1['created_by'] = Auth::guard('user')->user()->id;
                    //   $data1['created_at'] = date('Y-m-d');
                    //   EmployeeBankAccountDetail::updateOrCreate(
          //     ['ebc_account_number' => $request->user_employee_data['ebc_account_number']],
          //     $data1
                    //   );
                    // }

                    //   EmployeeBankAccountDetail::create($data1);
                    // } else {
                    //   $data_user_employee = ['ebc_account_number' => $request->user_employee_data['ebc_account_number']];
                    //   $update_data = EmployeeBankAccountDetail::valid()->findOrFail($request->employee_id);
                    //   $data_user_employee['updated_by'] = Auth::guard('user')->user()->branch_id;
                    //   $save_data_cash = $update_data->update($data_user_employee);
                    // }


                    $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
                }
            }
            // if (!$save_data_cash) {
            //   $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
            // }
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
            // $message = ['status' => 0, 'message' => $message];
            return response()->json($e->message);
        }
        // $message = ['status' => 0, 'message' => 'Please Enter Gross Salary!'];
        return response($message);
    }

    public function edit($id)
    {
        // $edit_data=Salary::valid()->project()->findOrFail($id);
        // return response($edit_data);
        // return response($id);

        $data = Salary::valid()->project()->where('type', 1)->findOrFail($id);
        // $employee_data = array();
        // $employee_data_list = Employee::valid()->project()->get()->keyBy('id')->all();
        // foreach ($employee_data_list as $value) {
        //     array_push($employee_data, ['id' => $value['id'], 'text' => $value['employee_id_no'] . " - " . $value['employee_fullname']]);
        // }

        // $employee_list = new Employee();
        // $employee_ids = $employee_list->Employee_id();
        // $employee_id = $employee_ids['employee_id'];
        $company_sbudata = CompanySbu::valid()->project()
        // ->whereIn('id', $employee_ids['sub'])
        ->get()->keyBy('id')->all();

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
              'employee_bank_account_details.status as bank_status',
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
        //       'employees.*',
        //       'company_sbus.sbu_name',
        //       'sections.section_name',
        //       'departments.department_name',
        //       'designations.designation_name',
        //       'sub_units.sub_unit_name',
        //       'work_locations.work_location_name',
        //       'employee_personal_infos.employee_gender'
        //   )
        //   ->whereIn('employee_sbu', $employee_ids['sub'])
        //   ->whereIn('employee_department', $employee_ids['department'])
        //   ->get()->keyBy('id');


        // if (!$data->employee_id) {
        //     $data->employee_name_value = ['id' => '', 'text' => ''];
        // } else {
        //     $data->employee_name_value = ['id' => $data->employee_id, 'text' => $employee_data_list[$data->employee_id]->employee_fullname];
        // }

        if (!$data->salary_sbu_id) {
            $data->company_sbu_value = ['id' => '', 'text' => ''];
        } else {
            $data->company_sbu_value = ['id' => $data->salary_sbu_id, 'text' => $company_sbudata[$data->salary_sbu_id]->sbu_name];
        }

        $company_sbu_data = array();
        foreach ($company_sbudata as $value) {
            array_push($company_sbu_data, [
              'id' => $value['id'],
              'text' => $value['sbu_name']
            ]);
        }


        $salary_setting = SalarySetting::valid()->project()->where('status', 1)->where('company_sbu_id', $user_employee_data->employee_sbu)->first();

        $data->salary_setting = $salary_setting;

        // $data->user_employee_data_all = $user_employee_data_all;
        $data->user_employee_data = $user_employee_data;
        // $data->employee_data =  $employee_data;
        $data->company_sbu_data =  $company_sbu_data;
        // return response($salary_setting);
        return response($data);
    }

    public function destroy($id)
    {
        $delete_data = Salary::valid()->project()->where('type', 1)->findOrFail($id);
        $payrollCheck = PayrollList::valid()->project()->where('empid', $delete_data->employee_id)->first();
        if (!empty($payrollCheck)) {
            $message = ['status' => 0, 'message' => 'Delete not possible! Payroll data exist.'];
        } else {
            if ($delete_data->delete()) {
                $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
            }
        }
        return response($message);
    }

    public function create()
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

        $data['employee_data'] = array();
        $employee_data = Employee::valid()->project()->get();
        $company_sbu_data = CompanySbu::valid()->project()->whereIn('id', $employee_ids['sub'])->get();

        foreach ($employee_data as $value) {
            array_push($data['employee_data'], ['id' => $value['id'], 'employee_sbu' => $value['employee_sbu'], 'text' => $value['employee_id_no'] . " - " . $value['employee_fullname']]);
        }
        $data['company_sbu_data'] = array();
        foreach ($company_sbu_data as $value) {
            array_push($data['company_sbu_data'], [
              'id' => $value['id'],
              'text' => $value['sbu_name']
            ]);
        }
        $data['user_employee_data'] = $user_employee_data;
        $data['confirmation_date'] = $user_employee_data['employee_joining_date'];
        $data['cash_confirmation_dates'] = $user_employee_data['employee_joining_date'];

        return response($data);
    }

    public function user_update_salary($employee_id)
    {
        $employee_data = Employee::where('id', $employee_id);
        $employee_sbu = $employee_data->first()->employee_sbu;

        $cache = Cache::get('permission');
        $permission = collect($cache)->where('menu_uid', '=', 'Salary')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
        foreach ($permission as $child) {
            if ($child['link_uid'] == 'add') {
                $data['add'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'edit') {
                $data['edit'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'delete') {
                $data['delete'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'bank') {
                $data['bank'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'cash') {
                $data['cash'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'change') {
                $data['change'] = $child['link_uid'];
            }
            else {
                $data['view'] = $child['link_uid'];
            }
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
          ->leftJoin('employee_history', function($query) {
            $query->on('employee_history.employee_id','=','employees.id')
                ->whereRaw('employee_history.id IN (select MAX(a2.id) from employee_history as a2 join employees as u2 on u2.id = a2.employee_id group by u2.id)');
            })
          ->select(
              'employees.*',
              'company_sbus.sbu_name',
              'sections.section_name',
              'departments.department_name',
              'designations.designation_name',
              'sub_units.sub_unit_name',
              'employee_bank_account_details.ebc_account_number',
              'work_locations.work_location_name',
              'employee_personal_infos.employee_gender',
              DB::raw('(DATEDIFF(NOW(), employees.employee_joining_date))/365 as service_length'),
              'employee_history.one_off_bonus'
          )
          ->where('employees.id', $employee_id)->first();

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
        // ->where('confirmation_date', '<=', date('Y-m-d'))
        ->where('employee_id', $employee_id)
        // ->groupBy('confirmation_date')
        ->groupBy('type')
        ->groupBy('salary_goes_to')
        ->get();
        $data['emp_salary'] = $emp_salary;

        $company_sbu_data = CompanySbu::valid()->project()->get();  
        $data['company_sbu_data'] = array();
        $data['department_data'] = array();
        $data['work_location_data'] = array();
        $data['designation_data'] = array();

        $data['salary_sbu_id'] = $user_employee_data['employee_sbu'];
        $data['cash_salary_sbu_id'] = $user_employee_data['employee_sbu'];
        if (!$user_employee_data['employee_sbu']) {
            $data['company_sbu_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['company_sbu_value'] = ['id' => $user_employee_data['employee_sbu'], 'text' => $user_employee_data['sbu_name']];
        }
        if (!$user_employee_data['employee_sbu']) {
            $data['cash_company_sbu_value'] = ['id' => '', 'text' => ''];
        } else {
            $data['cash_company_sbu_value'] = ['id' => $user_employee_data['employee_sbu'], 'text' => $user_employee_data['sbu_name']];
        }

        if (!$user_employee_data['ebc_account_number']) {
            $data['bank_status']=0;
        } else {
            $data['bank_status']=1;
        }
        foreach ($company_sbu_data as $value) {
            array_push($data['company_sbu_data'], [
              'id' => $value['id'],
              'text' => $value['sbu_name']
            ]);
        }
        $data['salary_goes_to'] = 2;
        $data['cash_salary_goes_to'] = 1;
        $data['user_employee_data'] = $user_employee_data;
        $salary_setting = SalarySetting::valid()->project()->where('status', 1)->where('company_sbu_id', $employee_sbu)->first();
        // dd($salary_setting);
        $employee_salary_bank = Salary::valid()->where('employee_id', $employee_id)
          ->where(
              'type',
              1
          )
            ->select('*', DB::raw('SUM(gross_salary) as gross_salary'))
          ->where('salary_goes_to', 2)
          ->groupBy('salary_goes_to')
          ->first();
        //   $employee_salary_bank = collect($employee_salary_bank);
        $data['bank_gross_salary'] = 0;
        if ($employee_salary_bank) {
            $company_sbudata = CompanySbu::valid()->project()->where('id', $employee_salary_bank->salary_sbu_id)->first();
            if (!$company_sbudata) {
                $data['company_sbu_value'] = ['id' => '', 'text' => ''];
            } else {
                $data['company_sbu_value'] = ['id' => $company_sbudata->id, 'text' => $company_sbudata->sbu_name];
            }
            $data['salary_sbu_id'] = $employee_salary_bank->salary_sbu_id;
            $data['bank_gross_salary'] = $employee_salary_bank->gross_salary ?? 0;
            $data['salary_goes_to'] = $employee_salary_bank->salary_goes_to;
            $data['confirmation_date'] = $employee_salary_bank->confirmation_date;
            $data['car_allowance_status'] = $employee_salary_bank->car_allowance_status ?? 2;
            $data['car_allowance_amount'] = $employee_salary_bank->car_allowance_amount;
            $data['others_allowance'] = $employee_salary_bank->others_allowance;
            $data['phone_allowance'] = $employee_salary_bank->phone_allowance;
            $data['gratuity_fund'] = $employee_salary_bank->gratuity_fund;
            $data['provident_fund'] = $employee_salary_bank->provident_fund;
            $data['provident_fund_amount'] = $employee_salary_bank->provident_fund_amount;
            // $data['company_sbu_value'] = $employee_salary_bank->company_sbu_id;
            $data['salary_status'] = $employee_salary_bank->salary_status;
            $data['bank_id'] = $employee_salary_bank->id;
        }
        $employee_salary_cash = Salary::valid()->project()->where('employee_id', $employee_id)
          ->where(
              'type',
              1
          )
            ->select('*', DB::raw('SUM(gross_salary) as gross_salary'))
            ->where('salary_goes_to', 1)
            ->groupBy('salary_goes_to')
            ->first();
            // dd($employee_salary_cash);
        if ($employee_salary_cash) {
            $company_sbudata = CompanySbu::valid()->project()->where('id', $employee_salary_cash->salary_sbu_id)->first();
            if (!$company_sbudata) {
                $data['cash_company_sbu_value'] = ['id' => '', 'text' => ''];
            } else {
                $data['cash_company_sbu_value'] = ['id' => $company_sbudata->id, 'text' => $company_sbudata->sbu_name];
            }
            // dd($employee_salary_cash);
            $data['cash_salary_sbu_id'] = $employee_salary_cash->salary_sbu_id;
            $data['cash_gross_salary'] = $employee_salary_cash->gross_salary ?? 0;
            $data['cash_salary_goes_to'] = $employee_salary_cash->salary_goes_to;
            $data['cash_confirmation_date'] = $employee_salary_cash->confirmation_date;
            $data['cash_car_allowance_status'] = $employee_salary_cash->car_allowance_status ?? 2;
            $data['cash_car_allowance_amount'] = $employee_salary_cash->car_allowance_amount;
            $data['cash_others_allowance'] = $employee_salary_cash->others_allowance;
            $data['cash_phone_allowance'] = $employee_salary_cash->phone_allowance;
            $data['cash_gratuity_fund'] = $employee_salary_cash->gratuity_fund;
            $data['cash_salary_status'] = $employee_salary_cash->salary_status;
            $data['cash_id'] = $employee_salary_cash->id;
            $data['cash_confirmation_date'] = $employee_salary_cash->id;
            $data['gratuity_fund'] = $employee_salary_cash->gratuity_fund;
            $data['provident_fund'] = $employee_salary_cash->provident_fund;
            $data['cash_provident_fund_amount'] = $employee_salary_cash->provident_fund_amount;
            $data['car_allowance_status'] = $employee_salary_cash->car_allowance_status ?? 2;
        }

        // $data['id'] = $employee_id;
        $data['salary_setting'] = $salary_setting;
        // $data['bank_gross_basic'] = 1;
        $data['confirmation_date'] = $user_employee_data['employee_joining_date'];
        $data['one_off_bonus'] = $user_employee_data['one_off_bonus'] ?? 0;
        $data['gross_salary'] = ($data['bank_gross_salary'] ?? 0) + ($data['cash_gross_salary'] ?? 0); 
        if(!empty($data['car_allowance_status']) && $data['car_allowance_status'] == 0){
            $data['car_allowance_status'] = 2;
        }
        if($data['car_allowance_status'] == 0){
            $data['car_allowance_status'] = 2;
        }
        if(empty($data['salary_status'])){
            $data['salary_status'] = 1;
        }
        // $data['car_allowance_status'] = $data['car_allowance_status'] ?? 2;
        if(!empty($employee_salary_bank->gratuity_fund)){
            $gratuity_fund = $employee_salary_bank->gratuity_fund;
        }elseif(!empty($employee_salary_cash->gratuity_fund)){
            $gratuity_fund = $employee_salary_cash->gratuity_fund;
        }else{
            $gratuity_fund = 1;
        }

        if(!empty($employee_salary_bank->provident_fund)){
            $provident_fund = $employee_salary_bank->provident_fund;
        }elseif(!empty($employee_salary_cash->provident_fund)){
            $provident_fund = $employee_salary_cash->provident_fund;
        }else{
            // $employee_sbu = $employee_data->first()->employee_sbu;
            if($employee_data->first()->emplyee_category_mgt_non_mgt == 1){
                $provident_fund = 1;
            }
            // elseif($employee_data->first()->emplyee_category_mgt_non_mgt == 2 && $employee_data->first()->employee_joining_date == date('Y-m-d')){
            //     $provident_fund = 1;
            // }
            else{
                $provident_fund = 0;
            }
        }
        $data['gratuity_fund'] = $gratuity_fund;
        $data['provident_fund'] = $provident_fund;
        $data['car_allowance_amount'] = $data['car_allowance_amount'] ?? 0;
        $data['others_allowance'] = $data['others_allowance'] ?? 0;
        $data['phone_allowance'] = $data['phone_allowance'] ?? 0;

        $all_gross_salary = collect($emp_salary)->sum('gross_salary');
        $data['total_gross_salary'] = ($all_gross_salary ?? 0) + ($data['cash_car_allowance_amount'] ?? 0) + ($data['car_allowance_amount'] ?? 0) + ($data['cash_others_allowance'] ?? 0) + ($data['others_allowance'] ?? 0) + ($data['cash_phone_allowance'] ?? 0) + ($data['phone_allowance'] ?? 0); 

        return response($data);
    }

    public function findDepartmentMaxCode()
    {
        $last_entry_data = Salary::latest()->where('type', 1)->first();
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
          ->where('employee_id', $employee_id)
          ->groupBy('entry_date')
          ->groupBy('salary_goes_to')
          ->get();

        $gross_salary = collect($emp_salary)->sum('gross_salary');
        $car_allowance_amount = collect($emp_salary)->sum('car_allowance_amount');
        $others_allowance = collect($emp_salary)->sum('others_allowance');
        $pf = collect($emp_salary)->sum('pf');
        $data['totalSalary'] = number_format((($gross_salary + $car_allowance_amount + $others_allowance)), 2);

        $data['emp_info'] = Employee::valid()->project()->where('id', $employee_id)->first();
        $data['user_employee_data'] = $user_employee_data;
        $data['emp_salary'] = $emp_salary;
        return response($data);
    }
}
