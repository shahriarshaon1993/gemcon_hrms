<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Employee;
use App\Model\UsersPersonModel;
use App\Model\FinalSettlement;
use Cache;
use Auth;
use DB;
use DateTime;
class FinalSettlementController extends Controller
{
  public function index(Request $request)
  {
    $cache = Cache::get('permission');
    $permission = collect($cache)->where('menu_uid', '=', 'FinalSettlement')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
    foreach ($permission as $child) {
      if ($child['link_uid'] == 'add') {
        $data['add'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'edit') {
        $data['edit'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'delete') {
        $data['delete'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'self') {
        $data['self'] = $child['link_uid'];
      } elseif ($child['link_uid'] == 'others') {
        $data['others'] = $child['link_uid'];
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
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $employee_id = $employee_ids['employee_id'];

    $paginate_data = FinalSettlement::valid()->project()
      ->leftJoin('employees', 'employees.id', '=', 'final_settlement.fs_employee_id')
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('resignations', 'resignations.id', '=', 'final_settlement.fs_resign_id')
      // ->leftJoin('leave_types','leave_types.id','=','resignations.leave_type')
      // ->leftJoin('employees as emp','emp.id','=','resignations.leave_reliever')
      ->select('final_settlement.*', 'company_sbus.sbu_name', 'departments.department_name', 'employees.id as employee_id', 'employees.employee_id_no', 'employees.employee_fullname', 'designations.designation_name', 'employees.employee_joining_date', 'resignations.separation_date', 'resignations.last_working_date')
      ->when($search_key, function ($query, $search_key) {
        $query->where(function ($query2) use ($search_key) {
          $query2->where('employees.employee_fullname', 'LIKE', '%' . $search_key . '%')
          ->orWhere('employees.employee_id_no', 'LIKE', '%' . $search_key . '%');
        });
        return $query;
      })->whereIn('employees.id', $employee_id)->orderBy($sort, $order);
    // ->paginate($paginate_num);
    $sortData = $paginate_data;
    $data['paginate_data'] = $sortData->paginate($paginate_num);
    $sortGetData = $sortData->get();
    $data['requestApplications'] = count($sortGetData);
    $data['pendingApplications'] = count(collect($sortGetData)->whereIn('settlement_status', ['1', '3'])->toArray());
    $data['acceptedApplications'] = count(collect($sortGetData)->where('settlement_status', 2)->toArray());
    $data['rejectedApplications'] = count(collect($sortGetData)->where('settlement_status', 4)->toArray());

    return response()->json($data);

    // return response()->json($data);
  }

  public function create()
  {
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $user_id = Auth::guard('user')->user()->id;
    $user_data = UsersPersonModel::valid()->project()->where('id', $user_id)->first();
    $user_employee_data = Employee::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
      ->leftJoin('resignations', 'resignations.employee_id', '=', 'employees.id')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name',
        'job_grades.jobgrade_name',
        'resignations.last_working_date',
        'resignations.separation_date',
        'resignations.effective_date',
        'resignations.id as resign_id',
      )
      ->where('employees.id', $user_data->employee_id)->first();
    $data['employee_joining_date_custom'] = date('j M Y', strtotime($user_employee_data->employee_joining_date));
    $user_employee_data_all = Employee::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
      ->leftJoin('resignations', 'resignations.employee_id', '=', 'employees.id')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name',
        'job_grades.jobgrade_name',
        'resignations.last_working_date',
        'resignations.id as resign_id',
        'resignations.effective_date',
        'resignations.separation_date',
      )
      ->whereIn('employee_sbu', $employee_ids['sub'])
      ->whereIn('employee_department', $employee_ids['department'])
      ->where('employee_status', 2)
      ->get()->keyBy('id');
    $data['user_employee_data'] = $user_employee_data;
    $data['last_working_date'] = $user_employee_data->last_working_date;
    $data['effective_date'] = $user_employee_data->effective_date;
    $data['separation_date'] = $user_employee_data->separation_date;
    $data['resign_id'] = $user_employee_data->resign_id;
    $data['user_employee_data_all'] = $user_employee_data_all;
    $data['employee_data'] = array();
    foreach ($user_employee_data_all as $value) {
      array_push(
        $data['employee_data'], 
        [
          'id' => $value['id'],
          'text' => $value['employee_id_no'] . ' : ' . $value['employee_fullname'] . ' - ' . $value['designation_name'] . ' - ' . $value['department_name'] . ' - ' . $value['sbu_name']
        ]
      );
    }
    $data['service_length'] = $this->find_service_length($user_employee_data->employee_joining_date, $user_employee_data->last_working_date);
    return response($data);
  }

  public function find_service_length($joining_date = null, $last_working_date = null){
    $date1 = $joining_date;
    $date2 = $last_working_date;
    if (!empty($date1) && !empty($date2)) {
        $Joining = new DateTime($date1);
        $today = new Datetime(date('Y-m-d'));
        $diff = $today->diff($Joining);
        $service_length = $diff->y . '.' . $diff->m. 'Y';
    } else {
        $service_length = '';
    }
    return $service_length;
  }
  public function store(Request $request)
  {
    // return response($request);
    // $validate = [
    //   'separation_type' => 'required'
    // ];
    // $request->validate($validate);
    $data = $request->only(
      'fs_gross_amount',
      'fs_service_length',
      'unpaid_salary_from',
      'unpaid_salary_to',
      'unpaid_salary_days',
      'unpaid_salary_amount',
      'unpaid_salary_pf',
      'unpaid_overtime_hour',
      'unpaid_overtime_rate',
      'pf_profit_forfeited',
      'pf_employee_contribution',
      'pf_employer_contribution',
      'annual_leave_days',
      'annual_leave_rate',
      'gf_9_16_years',
      'gf_17_end_years',
      'gf_9_16_gross',
      'gf_17_end_basic',
      'cashier_deposit',
      'uniform_deposit',
      'notice_pay_month',
      'notice_pay_amount',
      'covid_adjustment_amount',
      'due_oneoff_bonus_month',
      'due_oneoff_bonus_rate',
      'income_tax',
      'loan_advance',
      'bonus_reimbursement',
      'uniform_deduction',
      'excess_mobile_bill',
      'notice_pay_deduct_rate',
      'notice_pay_deduct_days',
      'pf_advance_paid',
      'fs_others_deduction',
      'fs_remarks',
    );
    $data['fs_net_payable'] = 0;
    $data['settlement_status'] = 1;
    if (!empty($request->id)) {
      $update_data = FinalSettlement::valid()->project()->findOrFail($request->id);
      $data['updated_by'] = Auth::guard('user')->user()->id;
      $data['updated_at'] = date('Y-m-d H:i:s');
      $save_data = $update_data->update($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
    } else {
      $data['fs_employee_id'] = $request->employee_id;
      $data['fs_resign_id'] = $request->resign_id;
      $data['project_id'] = Auth::guard('user')->user()->project_id;
      $data['branch_id'] = Auth::guard('user')->user()->branch_id;
      $data['created_by'] = Auth::guard('user')->user()->id;
      $data['created_at'] = date('Y-m-d H:i:s');
      $save_data = FinalSettlement::create($data);
      // DB::table('resignation_attachments')->insert($attachments);
      $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
    }
    if (!$save_data) {
      $message = ['status' => 0, 'message' => 'Opps! Something went wrong!'];
    }
    return response($message);
  }

  public function edit($id)
  {
    $employee_list = new Employee();
    $employee_ids = $employee_list->Employee_id();
    $data = FinalSettlement::valid()->project()->findOrFail($id);
    $data['created_at_custom'] = date('D, j M Y, h:i A', strtotime($data->created_at));
    $user_employee_data = Employee::project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
      ->leftJoin('resignations', 'resignations.employee_id', '=', 'employees.id')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name',
        'job_grades.jobgrade_name',
        'resignations.last_working_date',
        'resignations.separation_date',
        'resignations.effective_date',
      )
      ->where('employees.id', $data->fs_employee_id)->first();
    if (!empty($user_employee_data->employee_joining_date)) {
      $data['employee_joining_date_custom'] = date('j M Y', strtotime($user_employee_data->employee_joining_date));
    } else {
      $data['employee_joining_date_custom'] = '';
    }
    $data['user_employee_data'] = $user_employee_data;
    $resigned_month_days = date('t', strtotime($data->separation_date));
    // return response(date('Y', strtotime($user_employee_data->employee_joining_date)));
    $data['employee_basic_salary'] = $data->fs_gross_amount * 0.6;
    if(!empty($data->unpaid_salary_from) && !empty($data->unpaid_salary_to)){
      $unpaid_salary_from = strtotime($data->unpaid_salary_from);
      $unpaid_salary_to = strtotime($data->unpaid_salary_to);
      $datediff = $unpaid_salary_to - $unpaid_salary_from ;
      $data['unpaid_salary_days'] =  round($datediff / (60 * 60 * 24));
      $unpaid_month_days = date('t', strtotime($data->unpaid_salary_from));
      // return response([$data['unpaid_salary_days'],$unpaid_month_days, $data->fs_gross_amount]);
      $unpaid_salary_amount =  round(($data->fs_gross_amount / $unpaid_month_days) * $data['unpaid_salary_days']);
      $data['unpaid_salary_amount'] = $unpaid_salary_amount ?? 0;
    }else{
      $data['unpaid_salary_days'] = 0;
      $data['unpaid_salary_amount'] = 0;
    }
    if(!empty($data->fs_service_length) >= 3){
      $data['unpaid_salary_pf'] = round(($unpaid_salary_amount * 0.6) * 0.1) ?? 0;
    }else{
      $data['unpaid_salary_pf'] = 0;
    }
    $data['total_leave_encashment'] = 0;
    if(!empty($data->annual_leave_days)){
      $data['annual_leave_rate'] = round($data->fs_gross_amount / 30) ?? 0;
      $data['total_leave_encashment'] = round($data['annual_leave_rate'] * $data->annual_leave_days) ?? 0;
    }
    if(date('Y', strtotime($user_employee_data->employee_joining_date)) >= '2009' 
    || date('Y', strtotime($user_employee_data->employee_joining_date)) <= '2016'){
      $data['gratuity_9_16_view'] = 1;
    }
    $data['total_gratuity_amount'] = 0;
    if(!empty($data->gf_9_16_years) || !empty($data->gf_17_end_years)){
      $total_9_16_gratuity = $data->gf_9_16_years * $data->fs_gross_amount ?? 0;
      $total_17_16_end = $data->gf_17_end_years * $data['employee_basic_salary'] ?? 0;
      $data['total_gratuity_amount'] = round($total_9_16_gratuity + $total_17_16_end) ?? 0;
    }
    $data['oneoffbonus_month_year'] =  "Apr' ".date('Y', strtotime($user_employee_data->separation_date));
    $data['joining_month_year'] =  date('M\' Y', strtotime($user_employee_data->employee_joining_date));

    // $resigning_year = date('Y', strtotime($user_employee_data->separation_date));
    $data['profit_forfeited_year'] =  date('Y', strtotime('-1 year', strtotime($user_employee_data->separation_date)));
   
    $data['notice_pay_deduct_rate'] = round(($data->fs_gross_amount * 0.6) / $resigned_month_days) ?? round($data->notice_pay_deduct_rate);
    $data['notice_pay_deduct_amount'] = round($data['notice_pay_deduct_rate'] * $data->notice_pay_deduct_days);

    $data['fs_gross_amount'] = round($data->fs_gross_amount) ?? 0;

    $data['unpaid_overtime_amount'] = round($data->unpaid_overtime_hour * $data->unpaid_overtime_rate) ?? 0;
    $data['total_due_oneoff_bonus'] = round($data->due_oneoff_bonus_month * $data->due_oneoff_bonus_rate) ?? 0;
    
    $data['total_payable'] = round($data['unpaid_salary_amount'] + $data->unpaid_salary_pf + $data['unpaid_overtime_amount'] + $data->pf_profit_forfeited + $data->pf_employee_contribution + $data->pf_employer_contribution + $data['total_leave_encashment'] + $data['total_gratuity_amount'] + $data->cashier_deposit + $data->uniform_deposit + $data->notice_pay_amount + $data->covid_adjustment_amount + $data['total_due_oneoff_bonus']) ?? 0;

    $data['total_deduction'] = round($data->income_tax + $data->loan_advance + $data->bonus_reimbursement + $data->uniform_deduction + $data->excess_mobile_bill +$data['notice_pay_deduct_amount'] + $data['notice_pay_amount'] + $data->pf_advance_paid + $data->fs_others_deduction) ?? 0;

    $data['net_payable'] = $data['total_payable'] - $data['total_deduction'] ?? 0;

    if($data['net_payable'] > 0){
      $data['net_payable_inword'] = self::inword($data['net_payable']);
    }else{
      $data['net_payable_inword'] = 0;
    }

    $employee_data_list = Employee::valid()->project()->whereIn('employee_sbu', $employee_ids['sub'])->whereIn('employee_department', $employee_ids['department'])->get()->keyBy('id')->all();
    $employee_data = array();
    foreach ($employee_data_list as $value) {
      array_push($employee_data, ['id' => $value['id'], 'text' => $value['employee_fullname']]);
    }
    $data->employee_data =  $employee_data;
    return response($data);
  }
  public function destroy($id)
  {
    $delete_data = FinalSettlement::valid()->project()->findOrFail($id);
    if ($delete_data->settlement_status == 2) {
      $message = ['status' => 0, 'message' => 'Approved data, you can not delete!'];
      return response($message);
    }
    if ($delete_data->delete()) {
      $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
    }
    return response($message);
  }
    public static function inword($Total_Credit_Amount)
    {
      $number = $Total_Credit_Amount;
      $no = round($number);
      $hundred = null;
      $digits_1 = strlen($no);
      $i = 0;
      $str = array();
      $words = array('0' => '', '1' => 'One', '2' => 'Two',
      '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
      '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
      '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
      '13' => 'Thirteen', '14' => 'Fourteen',
      '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
      '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
      '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
      '60' => 'Sixty', '70' => 'Seventy',
      '80' => 'Eighty', '90' => 'Ninety');
      $digits = array('', 'Hundred', 'Thousand', 'Lac', 'Crore');
      while ($i < $digits_1) {
          $divider=($i==2) ? 10 : 100;
          $number=floor($no % $divider);
          $no=floor($no / $divider);
          $i +=($divider==10) ? 1 : 2;
          if ($number) {
              $plural=(($counter=count($str)) && $number> 9) ? '' : null;
              $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
              $str [] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred;
          } else {
              $str[]=null;
          }
      } $str=array_reverse($str);
      $result=implode('', $str);
      $p=$result . "Taka Only" ;
      return $p;
  }
}
