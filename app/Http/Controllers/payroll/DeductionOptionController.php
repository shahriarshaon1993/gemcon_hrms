<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\payroll\DeductionOption;
use App\Model\Employee;
use App\Model\UsersPersonModel;
use App\Model\EmployeeApproval;
use App\Model\payroll\SalarySetting;
use App\Model\payroll\DeductionOptionTransaction;
use App\Model\payroll\Salary;
use Cache;
use permission;
use DateTime;
use DB;

class DeductionOptionController extends Controller
{
  public function index(Request $request)
  {
    $paginate_num = $request->input('paginate_num');
    $search_key = $request->input('search_key');
    $order = $request->input('order');
    $sort = $request->input('sort');
    $project_id = Auth::guard('user')->user()->project_id;
    $branch_id = Auth::guard('user')->user()->branch_id;
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $employee_id = $employee_ids['employee_id'];
    $cache = Cache::get('permission');
    $permission = collect($cache)->where('menu_uid', '=', 'DeductionOption')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
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
    $paginate_data = DeductionOption::valid()->project()
      ->leftJoin('employees',  'employees.id', '=', 'deduction_option.employee_id')
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->select(
        'deduction_option.*',
        'employees.employee_id_no',
        'employees.employee_fullname',
        'employees.employee_joining_date',
        'departments.department_name',
        'designations.designation_name',
        'company_sbus.sbu_name'
      )
      ->when($search_key, function ($query, $search_key) {
        $query->where(function ($query2) use ($search_key) {
          $query2->where('deduction_option.gross_salary', 'LIKE', '%' . $search_key . '%')
            ->orWhere('employees.employee_id_no', 'LIKE', '%' . $search_key . '%')
            ->orWhere('employees.employee_fullname', 'LIKE', '%' . $search_key . '%');
        });
        return $query;
      })->where('deduction_option.project_id', $project_id)->whereIn('employees.id', $employee_id)->orderBy($sort, $order);
    // ->paginate($paginate_num);

    $sortData = $paginate_data;
    $sortGetData = $sortData->get();
    $data['total_data'] = count($sortGetData);
    $data['inactive_data'] = count(collect($sortGetData)->whereIn('loan_status', 0)->toArray());
    $data['active_data'] = count(collect($sortGetData)->where('loan_status', 1)->toArray());
    $loan_amount = collect($sortGetData)->where('loan_status', 1)->where('loan_clearance_status', 2)->toArray();
    $data['total_loan_amount'] = $loan_amount = collect($loan_amount)->sum('loan_amount');
    $data['total_paid_amount'] = $paid_amount = collect($loan_amount)->sum('loan_amount');

    // $collection->sum('pages');
    $data['total_due_amount'] = $loan_amount - $paid_amount;
    $data['paid_loan_no'] = count(collect($sortGetData)->where('loan_status', 1)->where('loan_clearance_status', 1)->toArray());

    // $employee_data_list=DeductionOptionTransaction::valid()->project()->whereIn('employees.id',$employee_id)->groupBy('')->get();

    $data['paginate_data'] = $sortData->paginate($paginate_num);


    $data['paid_loan_amount'] = DeductionOptionTransaction::valid()->project()
      ->leftJoin('deduction_option', 'deduction_option.id', '=', 'deduction_option_transaction.loan_adv_id')
      ->selectRaw(
        'deduction_option.loan_clearance_status as loan_clearance_status,
              deduction_option_transaction.loan_adv_id as loan_adv_id,
              loan_adv_amount as paid_amount'
      )
      ->where('deduction_option_transaction.loan_trns_status', 1)
      // ->where('deduction_option.employee_id', $employee['id'])
      ->where('deduction_option.loan_status', 1)
      ->get();
    $data['total_paid_loan_amount'] = collect($data['paid_loan_amount'])->sum('paid_amount');
    $data['paid_no_of_loan'] = count(collect($data['paid_loan_amount'])->where('loan_clearance_status', 2));
    return response()->json($data);
  }

  public function store(Request $request)
  {
    if ($request->employee_id) {
      $user_id = $request->employee_id;
      $user_data = Employee::valid()->project()->where('id', $user_id)->first();
    } else {
      $user_id = Auth::guard('user')->user()->id;
      $user_data = UsersPersonModel::valid()->project()->join('employees', 'employees.id', '=', 'users_person.employee_id')->select('users_person.*', 'employees.employee_reporting_to', 'employees.id as emp_id')->where('users_person.id', $user_id)->first();
    }
    if (!empty($user_data->employee_reporting_to)) {
      $employee_reporting_to = Employee::valid()->project()->select('id')->where('employee_id_no', '=', $user_data->employee_reporting_to)->first();
    } else {
      $employee_reporting_to = [];
    }


    $validate = [
      'employee_id' => 'required'
    ];

    $request->validate($validate);

    $data = $request->only('employee_id', 'disburse_date', 'loan_amount', 'no_of_installment', 'loan_deduct_policy', 'loan_type', 'loan_purpose', 'first_installment_date', 'last_installment_date', 'loan_status');
    if (!empty($employee_reporting_to)) {
      if (!empty($request->id)) {
        $update_data = DeductionOption::valid()->project()->findOrFail($request->id);
        if ($update_data->loan_approve_status == 1 && count($request->list) > 0) {
          DeductionOption::destroy($request->id);
          DB::table('deduction_option_approvals')->where('loan_apply_id', $request->id)->delete();
          foreach ($request->list as $key => $data_new) {
            $data_new['employee_id'] = $request->employee_id;


            $data_new['project_id'] = Auth::guard('user')->user()->project_id;
            $data_new['branch_id'] = Auth::guard('user')->user()->branch_id;
            $data_new['created_by'] = Auth::guard('user')->user()->id;
            $data_new['loan_status'] = 1;
            $data_new['refundable'] = isset($data_new['refundable']) ? 1 : 0;
            $save_data = DeductionOption::create($data_new);
            /* Data sent to approval table */
            $employee_approvals_data = EmployeeApproval::valid()->project()->where('ea_employee_id', $user_data->id)->get();
            $save_ids = $save_data->id;

            
            if (!$employee_approvals_data->isEmpty() && !empty($save_data)) {
              $i = 0;
              foreach ($employee_approvals_data as $key => $value) {
                $i++;
                $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
                $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id;
                $approve_data['created_by'] = Auth::guard('user')->user()->id;
                $approve_data['loan_apply_id'] = $save_ids;
                $approve_data['loan_approve_by'] = $value['ea_approve_by'];
                $approve_data['loan_approve_status'] = 1;
                $save_data = DB::table('deduction_option_approvals')->insert($approve_data);
                $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
              }
            } else {
              $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
              $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id;
              $approve_data['created_by'] = Auth::guard('user')->user()->id;
              $approve_data['loan_apply_id'] = $save_data->id;
              $approve_data['loan_approve_by'] = $employee_reporting_to->id;
              $approve_data['loan_approve_status'] = 1;
              $save_data = DB::table('deduction_option_approvals')->insert($approve_data);
              $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
            }
          }
        }

        // $data['updated_by']=Auth::guard('user')->user()->branch_id; 
        // $save_data=$update_data->update($data);
        $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
      } else {
        foreach ($request->list as $key => $data_new) {
          $data_new['employee_id'] = $request->employee_id;


          $data_new['project_id'] = Auth::guard('user')->user()->project_id;
          $data_new['branch_id'] = Auth::guard('user')->user()->branch_id;
          $data_new['created_by'] = Auth::guard('user')->user()->id;
          $data_new['loan_status'] = 1;
          $data_new['refundable'] = isset($data_new['refundable']) ? 1 : 0;
          $save_data = DeductionOption::create($data_new);
          /* Data sent to approval table */
          $employee_approvals_data = EmployeeApproval::valid()->project()->where('ea_employee_id', $user_data->id)->get();
          $save_ids = $save_data->id;


          if (!$employee_approvals_data->isEmpty() && !empty($save_data)) {
            $i = 0;
            foreach ($employee_approvals_data as $key => $value) {
              $i++;
              $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
              $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id;
              $approve_data['created_by'] = Auth::guard('user')->user()->id;
              $approve_data['loan_apply_id'] = $save_ids;
              $approve_data['loan_approve_by'] = $value['ea_approve_by'];
              $approve_data['loan_approve_status'] = 1;
              $save_data = DB::table('deduction_option_approvals')->insert($approve_data);
              $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
            }
          } else {
            $approve_data['project_id'] = Auth::guard('user')->user()->project_id;
            $approve_data['branch_id'] = Auth::guard('user')->user()->branch_id;
            $approve_data['created_by'] = Auth::guard('user')->user()->id;
            $approve_data['loan_apply_id'] = $save_data->id;
            $approve_data['loan_approve_by'] = $employee_reporting_to->id;
            $approve_data['loan_approve_status'] = 1;
            $save_data = DB::table('deduction_option_approvals')->insert($approve_data);
            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
          }
        }
      }
      if (!$save_data) {
        $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
      }
    } else {
      $message = ['status' => 0, 'message' => 'Sorry!, Reporting to/Superior Not Set'];
      return response($message);
    }
    return response($message);
  }

  public function edit($id)
  {
    $data = DeductionOption::valid()->project()->findOrFail($id);
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

    // $salary_setting=SalarySetting::valid()->project()->where('status', 1)->first();
    // $data->salary_setting = $salary_setting;  
    $employee_salary = Salary::valid()->project()
      ->groupBy('employee_id')
      ->selectRaw('sum(gross_salary) as total_salary, sum(basic_salary) as total_basic, sum(housing_allowance) as total_house, sum(medical_allowance) as total_medical, sum(conveyance_allowance) as total_transport')
      ->where('employee_id', $data->employee_id)->first();

    $employee_loan = DeductionOption::valid()->project()
      ->where('employee_id', $data->employee_id)->where('loan_status', 1)->get();

    $data->employee_salary = $employee_salary;
    $data->employee_loan = $employee_loan;
    $data->user_employee_data_all = $user_employee_data_all;
    $data->user_employee_data = $user_employee_data;
    $data->employee_data =  $employee_data;
    // return response($salary_setting);
    return response($data);
    // return response($edit_data);

  }

  public function destroy($id)
  {
    $delete_data = DeductionOption::valid()->project()->findOrFail($id);
    $loanTrangstion = DeductionOptionTransaction::valid()->where('loan_adv_id', $id)->get();
    // dd($loanTrangstion);
    if (count($loanTrangstion) != 0) {
      $message = ['status' => 0, 'message' => 'Transactions already exist'];
    } else {
      if ($delete_data->delete()) {
        $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
      }
    }
    return response($message);
  }

  public function findMaxCode()
  {
    $last_entry_data = DeductionOption::latest()->first();
    $last_code = $last_entry_data['designation_code'];
    if ($last_code == 0) {
      $last_code = 101;
    } else {
      $last_code = $last_code + 1;
    }
    return $last_code;
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

    $employee_salary = Salary::valid()->project()
      ->groupBy('employee_id')
      ->selectRaw('sum(gross_salary) as total_salary, sum(basic_salary) as total_basic, sum(housing_allowance) as total_house, sum(medical_allowance) as total_medical, sum(conveyance_allowance) as total_transport')
      ->where('employee_id', $id)->first();

    $employee_loan = DeductionOption::valid()->project()
      ->where('employee_id', $id)->where('loan_status', 1)->get();
    $lpanCheck = collect($employee_loan)->where('loan_clearance_status', 2)->toArray();


    if (!empty($lpanCheck)) {
      $data['loanEligblity'] = 'loanEligblity1';
      $data['loanEligblitys'] = 0;
    } else {
      $lpanChecks = collect($employee_loan)->where('loan_clearance_status', 1)->sortByDesc('disburse_date')->first();
      if (!empty($lpanChecks)) {
        $today = new Datetime(date('Y-m-d'));
        $loanClosingDate = $today->diff($lpanChecks['loan_closing_date']);
        $loanAge = $loanClosingDate->m . ' M ';

        if ($loanAge > $salary_setting['loan_eligible_period']) {
          $data['loanEligblity'] = 'loanEligblity';
          $data['loanEligblitys'] = 1;
        } else {
          $data['loanEligblity'] = 'loanEligblity1';
          $data['loanEligblitys'] = 0;
        }
      } else {
        $data['loanEligblity'] = 'loanEligblity1';
        $data['loanEligblitys'] = 0;
      }
    }

    if (empty($salary_setting)) {
      $message = ['status' => 0, 'message' => 'At first payroll setting'];
      return response($message);
    }

    $data['no_of_installment'] = $salary_setting['loan_settlement_period'];
    $data['salary_setting'] = $salary_setting;
    $data['employee_salary'] = $employee_salary;
    $data['employee_loan'] = $employee_loan;
    $data['user_employee_data_all'] = $user_employee_data_all;
    $data['user_employee_data'] = $user_employee_data;

    // $data['profile_open'] = 1;
    // this.profile_open = 1;
    return response($data);
  }

  public function findPriority()
  {
    $last_entry_data = DeductionOption::max('priority');
    $last_code = $last_entry_data;
    if ($last_code == 0) {
      $last_code = 1;
    } else {
      $last_code = $last_code + 1;
    }
    return $last_code;
  }

  public function schedule($id = false)
  {
    $data = DeductionOption::valid()->project()->findOrFail($id);

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

    $employee_salary = Salary::valid()->project()
      ->groupBy('employee_id')
      ->selectRaw('sum(gross_salary) as total_salary, sum(basic_salary) as total_basic, sum(housing_allowance) as total_house, sum(medical_allowance) as total_medical, sum(conveyance_allowance) as total_transport')
      ->where('employee_id', $data->employee_id)->first();

    $employee_loan = DeductionOption::valid()->project()->where('employee_id', $data->employee_id)->where('id', $id)->where('loan_clearance_status', 2)->where('loan_status', 1)->first();

    $paid_amount =  DeductionOptionTransaction::valid()->project()
      ->where('loan_trns_status', 1)
      ->where('loan_adv_id', $id)
      ->get()->sum('loan_adv_amount');

    if (!empty($employee_loan)) {
      $no_of_installment = $employee_loan->no_of_installment;
      $loan_amount = $employee_loan->loan_amount;
      $installment_amount = $loan_amount / $no_of_installment;
      $first_installment_date = $employee_loan->first_installment_date;
      $last_installment_date = $employee_loan->last_installment_date;
      $loan_deduct_policy = $employee_loan->loan_deduct_policy;
      $data['paid_amount'] = $paid_amount;
      $data['loan_amount'] = $employee_loan->loan_amount;
      $paid_due_amount = 0;
      $c = 0;
      $total_loan_paid = $paid_amount;
      $loan_schedule[] = '';
      for ($i = 0; $i < $no_of_installment; $i++) {
        // $j = $i+1; 
        $paid_status = '-';
        $color_code = '';
        if ($total_loan_paid == 0) {
          $paid_status = 'Due';
          $color_code = 'red';
        } else {
          $paid_due_amount = $total_loan_paid - $installment_amount;
          $total_loan_paid = $paid_due_amount;
          if ($paid_due_amount < 0) {
            $total_loan_paid = 0;
            $paid_status = 'Partial';
            $color_code = 'orange';
          } else if ($paid_due_amount >= 0) {
            $paid_status = 'Paid';
            $color_code = 'green';
          }
        }

        /* Loan Deduct Calculation*/
        $loan_amount_int = $loan_amount;
        $schedule_amount = $installment_amount;
        if ($i == 0) {
          $a = $loan_amount_int;
        } else {
          $a = $c;
        }
        if ($schedule_amount) {
          $b = $schedule_amount;
        } else {
          $b = 0;
        }
        $c = $a - $b;

        if ($loan_deduct_policy == 1) {
          $loan_deduct_policy_text = 'Auto';
        } else {
          $loan_deduct_policy_text = 'Manual';
        }
        // loan_deduct_policy

        $loan_schedule[$i] = array(
          'serial_no' => $i + 1,
          'installment_date' => date('Y-m-d', strtotime("+" . $i . " months", strtotime($first_installment_date))),
          'loan_amount' => round($a),
          'installment_amount' => round($b),
          'remaining_amount' => round($c),
          'loan_deduct_policy' => $loan_deduct_policy_text,
          'installment_status' => $paid_status,
          'color_code' => $color_code,
        );
      }
      $data['loan_schedule'] = $loan_schedule;
    } else {
      $data['loan_schedule'] = [];
    }
    $data->employee_salary = $employee_salary;
    $data->employee_loan = $employee_loan;
    $data->user_employee_data = $user_employee_data;
    return response($data);
  }

  public function approveOrReject(Request $request)
  {
    $loan_id = $request->id;
    $user_id = Auth::guard('user')->user()->id;
    $user_data = UsersPersonModel::valid()->project()->where('id', $user_id)->first();
    $approval_info = EmployeeApproval::valid()->project()->where('ea_approve_by', $user_data->employee_id)->where('ea_employee_id', $request->employee_id)->first();
    if (empty($approval_info)) {
      $message = ['status' => 0, 'message' => 'You have no permission!'];
      return response($message);
    }
    if (!empty($approval_info)) {
      $ea_approval_lavel = $approval_info->ea_approval_lavel;
      $ea_employee_id = $approval_info->ea_employee_id;
      $ea_approve_by = $approval_info->ea_approve_by;
      if ($ea_approval_lavel == 1) {
        if ($request->approve_reject_status == 1) {
          $data['loan_approve_status'] = 2;
        } else {
          $data['loan_approve_status'] = 4;
        }
      } else {
        if ($request->approve_reject_status == 1) {
          $data['loan_approve_status'] = 3;
        } else {
          $data['loan_approve_status'] = 4;
        }
      }
      $data['loan_approve_date'] = date("Y-m-d");
      $data['loan_comments'] = $request->comments;
      $data['updated_at'] = date("Y-m-d H:i:s");
      $udate_data = DB::table('deduction_option_approvals')->where('loan_apply_id', $loan_id)->where('loan_approve_by', $ea_approve_by)->update($data);
      $udate_data = DeductionOption::valid()->project()->where('id', $loan_id)->update(array('loan_approve_status' => $data['loan_approve_status']));
      if ($udate_data && $request->approve_reject_status == 1) {
        $message = ['status' => 1, 'message' => 'Loan Approved!'];
      } else {
        $message = ['status' => 0, 'message' => 'Loan rejected!'];
      }
      return response($message);
    }
  }
}
