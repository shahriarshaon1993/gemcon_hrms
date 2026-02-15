<?php
namespace App\Http\Controllers\payroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\NoticeModel;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\Section;
use App\Model\SubSection;
use App\Model\EmployeeGroup;
use App\Model\Department;
use App\Model\Designation;
use App\Model\JobGrade;
use App\Model\SubUnit;
use App\Model\UnitModel;
use App\Model\WorkLocation;
use App\Model\NoticePermission;
use App\Model\AttendanceSetup;
use App\Model\OfficeTimeSetup;
use App\Model\payroll\Salary;
use App\Model\payroll\SalarySetting;
use App\Model\payroll\TaxSetting;
use App\Model\payroll\PayrollPermission;
use App\Model\payroll\ProvidentFund;
use App\Model\payroll\LoanTransaction;
use App\Model\payroll\PayrollList;
use App\Model\payroll\BonusProcessList;
use Cache;
use permission;
use DB;
use DateTime;
use DateInterval;
use DatePeriod;
// use App\Model\UserRoleAccess;

class BonusProcessController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','ShiftingSetup')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
  $project_id=Auth::guard('user')->user()->project_id;
  $paginate_num = $request->input('paginate_num');
  $search_key = $request->input('search_key');
  $order = $request->input('order');
  $sort = $request->input('sort');
  $employee_list = new Employee();
  $employee_ids=$employee_list->Employee_id();
  $employee_id=$employee_ids['employee_id'];
  

  $data['company_sbu_data']=array();
  $data['section_data']=array();
  $data['sub_section_data']=array();
  $data['sub_unit_data']=array();
  $data['unit_data']=array();
  $data['work_location_data']=array();
  $data['department_data']=array();
  $data['designation_data']=array();
  $data['jobgrade_data']=array();
  $data['employee_data']=array();
  $data['employee_data_approval']=array();
  $data['employee_group_data']=array();

  $payroll_permissions=PayrollPermission::valid()->project()->whereIn('id',['2','3'])->get();
  $data['payroll_permissions']=array();
  foreach ($payroll_permissions as $value) {
    array_push($data['payroll_permissions'],['id'=>$value['id'],'text'=>$value['permission_group']]);
  } 
  $company_sbu_data=CompanySbu::valid()->project()->whereIn('id',$employee_ids['sub'])->get();
  foreach ($company_sbu_data as $value) {
    array_push($data['company_sbu_data'],['id'=>$value['id'],'text'=>$value['sbu_name']]);
  } 
  $data['approval_infos']=['0' =>['id'=>0,'permission_type'=>'','permission_id'=>'']];
     $data['months_array']=[];
     array_push($data['months_array'],['id'=>date('m', strtotime('-2 months')),'text'=>date('F', strtotime('-2 months'))]);
     array_push($data['months_array'],['id'=>date('m', strtotime('-1 months')),'text'=>date('F', strtotime('-1 months'))]);
     array_push($data['months_array'],['id'=>date('m'),'text'=>date('F')]);
     array_push($data['months_array'],['id'=>date('m', strtotime('+1 months')),'text'=>date('F', strtotime('+1 months'))]);
     array_push($data['months_array'],['id'=>date('m', strtotime('+2 months')),'text'=>date('F', strtotime('+2 months'))]);
  $payrollPermissionassing=collect(DB::table('payroll_permissions_assign')->where('employee_id',Auth::guard('user')->user()->employee_id)->where('valid',1)->get())->pluck('assign_id')->toArray();
  $data['payrollPermissions']=array();
  $payrollPermission=PayrollPermission::valid()->project()->whereIn('id',$payrollPermissionassing)->get();
  foreach ($payrollPermission as $value) {
    array_push($data['payrollPermissions'],['id'=>$value['id'],'text'=>$value['permission_group']]);
  } 
  return response()->json($data);
}

public function find_employee_data(Request $request){
  // return response()->json($request);
  $employee_list = new Employee();
  $employee_ids=$employee_list->Employee_id();
  $employee_id=$employee_ids['employee_id'];
  $employee_data_approval=[];
  $fist_date_of_month=date('Y').'-'.$request->months_id.'-'.'01';
  $dt=date_create($fist_date_of_month);
  $dt->modify('last day of this month');
  $last_date_of_month= date_format($dt,"Y-m-d");
  $payrolInfo=Salary::valid()->where('salary_sbu_id',$request['id'])
            ->where('confirmation_date','<=',date('Y-m-d'))
            ->where('salary_goes_to',$request['salary_type_id'])->get();
  $payrolInfo_employee_id=collect($payrolInfo)->pluck('employee_id')->toArray();
  // return response()->json($payrolInfo_employee_id);
  $payrollPermission=PayrollPermission::valid()->project()
              ->where('id',$request['salary_grade'])->first();
  $jobGrade=array();
  if(!empty($payrollPermission)){
    for ($x =$payrollPermission['permission_grade_start']; $x <= $payrollPermission['permission_grade_end']; $x++) {
      $jobGrade[]=$x;
    }
  }
  $payroll_employee=DB::table('payroll_process')
                    ->join('payroll','payroll_process.id','=','payroll.procsid')
                    ->whereDate('startdate', '=', $fist_date_of_month)
                    ->whereDate('enddate', '=', $last_date_of_month) 
                    ->where('payroll_process.valid',1)
                    ->where('payroll_process.type',$request['salary_type_id'])
                    ->where('settlement',2)
                    ->get();
  $payrollEmployyId=collect($payroll_employee)->pluck('empid')->toArray();

  $employee_data=Employee::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
      ->leftJoin('employee_bank_account_details', 'employee_bank_account_details.ebc_employee_id', '=', 'employees.id')
      ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'job_grades.jobgrade_name',
        'employee_bank_account_details.ebc_account_number',
        'employee_personal_infos.employee_gender',
        'employee_personal_infos.employee_dob_certificate',
        'designations.designation_name'
      )
      ->whereNotIn('employees.id',$payrollEmployyId)
      ->whereIn('employees.id',$payrolInfo_employee_id)
      ->whereIn('job_grades.priority',$jobGrade)
      ->get();
    $employee_all_id=collect($employee_data)->pluck('employee_id_no')->toArray();
    $employee_all_idno=collect($employee_data)->pluck('id')->toArray();
    $attendanceInfo=DB::table('attendance')
                    ->whereDate('pdate', '>=', $fist_date_of_month)
                    ->whereDate('pdate', '<=', $last_date_of_month)
                    ->whereIn('employee_card_no',$employee_all_id)
                    ->get();
    $additionalAllowances=DB::table('additional_allowances')
                  ->where('company_sbu_id',$request['id'])
                  ->whereDate('additional_date', '>=', $fist_date_of_month)
                  ->whereDate('additional_date', '<=', $last_date_of_month)
                  ->where('salary_goes_to',$request['salary_type_id'])
                  ->where('valid',1)->get();
    $mobileAddition=DB::table('sim_assignings')
                  ->where('company_sbu_id',$request['id'])
                  ->where('sim_assign_status',1)
                  ->where('valid',1)->get();
     $mobileInternetBills=DB::table('mobile_internet_bills')
                  ->where('company_sbu_id',$request['id'])
                  ->whereDate('bill_date', '>=', $fist_date_of_month)
                  ->whereDate('bill_date', '<=', $last_date_of_month)
                  ->where('bill_status',1)
                  ->where('bill_types',3)
                  ->where('valid',1)->get();
    $salary_deductions=DB::table('salary_deductions')
                  ->where('company_sbu_id',$request['id'])
                  ->whereDate('deduction_date', '>=', $fist_date_of_month)
                  ->whereDate('deduction_date', '<=', $last_date_of_month)
                  ->where('valid',1)->get();
    $employee_loans=DB::table('employee_loans')
                  ->where('company_sbu_id',$request['id'])
                  ->where('loan_status',1)
                  ->where('loan_clearance_status',2)
                  ->where('valid',1)->get();
    $loan_adv_transactions=DB::table('loan_adv_transactions')
                  ->where('company_sbu_id',$request['id'])
                  ->whereDate('trns_date', '>=', $fist_date_of_month)
                  ->whereDate('trns_date', '<=', $last_date_of_month)
                  ->where('valid',1)->get();
    $salary_setting=DB::table('salary_settings')
                  ->where('company_sbu_id',$request['id'])
                  ->where('status',1)
                  ->where('valid',1)->first();   
                  // return response()->json($salary_setting);        
    $total_salary=0;
    $tax_amount = 0;
    $total_employee = 0;
    $employee = 0;
    foreach ($employee_data as $key => $value) {
      $employee++;
      // $employee_data[$key]['prtot']=collect($attendanceInfo)->where('employee_id',$value->id)->where('pstatus',1)->count();
      // $employee_data[$key]['lttot']=collect($attendanceInfo)->where('employee_id',$value->id)->where('pstatus',2)->count();
      // $employee_data[$key]['abtot']=collect($attendanceInfo)->where('employee_id',$value->id)->where('pstatus',3)->count();
      // $employee_data[$key]['whtot']=collect($attendanceInfo)->where('employee_id',$value->id)->whereIn('pstatus',['4','5'])->count();
      // $employee_data[$key]['levtot']=collect($attendanceInfo)->where('employee_id',$value->id)->where('pstatus',6)->count();
      // $employee_data[$key]['total']=collect($attendanceInfo)->where('employee_id',$value->id)->count();
      // $employee_data[$key]['pay_day']=(collect($attendanceInfo)->where('employee_id',$value->id)->count()-collect($attendanceInfo)->where('employee_id',$value->id)->where('pstatus',3)->count());

      $bonus_percentage = $salary_setting->bonus_percentage;
      $bonus_maturity_month = $salary_setting->bonus_maturity_month;
      $g_salary=collect($payrolInfo)->where('employee_id',$value->id)->sum('gross_salary');
      $employee_data[$key]['g_salary']=$g_salary;
      $employee_data[$key]['bonus_amount']= $bonus_amount_ind = $g_salary*$bonus_percentage/100;
      $employee_data[$key]['bonus_percentage']=$bonus_percentage;
      $b_salary=collect($payrolInfo)->where('employee_id',$value->id)->sum('basic_salary');
      $employee_data[$key]['b_salary']=$b_salary;
      $h_allowance=collect($payrolInfo)->where('employee_id',$value->id)->sum('housing_allowance');
      $employee_data[$key]['h_allowance']=$h_allowance;
      $m_allowance=collect($payrolInfo)->where('employee_id',$value->id)->sum('medical_allowance');
      $employee_data[$key]['m_allowance']=$m_allowance;
      $c_allowance=collect($payrolInfo)->where('employee_id',$value->id)->sum('conveyance_allowance');
      $employee_data[$key]['c_allowance']=$c_allowance;
      $g_payble=($c_allowance+$b_salary+$h_allowance+$m_allowance);
      $employee_data[$key]['g_payble']=$g_payble;
      $overTime_comperensation=collect($payrolInfo)->where('employee_id',$value->id)->sum('overtime_work_compensation');
     $employee_data[$key]['overTime_comperensation']=$overTime_comperensation;
    $p_fund=collect($payrolInfo)->where('employee_id',$value->id)->sum('provident_fund_amount');
     $arrear_amount=collect($additionalAllowances)->where('additional_allow_type',1)->where('employee_id',$value->id)->sum('additional_amount');
    $employee_data[$key]['arrear_amount']=$arrear_amount;
    if($request['salary_type_id']==2){  
         // Addition allowance
        $mobile_addition=collect($mobileAddition)->where('sim_assign_to',$value->id)->sum('sim_ceiling_limit');
        $employee_data[$key]['mobile_addition']=$mobile_addition;
        $car_allowance=collect($payrolInfo)->where('employee_id',$value->id)->sum('car_allowance_amount');
        $employee_data[$key]['car_allowance']=$car_allowance;
        $other_allowance=collect($payrolInfo)->where('employee_id',$value->id)->sum('others_allowance');
        $employee_data[$key]['other_allowance']=$other_allowance;
        $totalAddition=($arrear_amount+$mobile_addition+$car_allowance+$other_allowance);
         // Addition allowance
         // Deduction
        $employeeLoans=collect($employee_loans)->where('employee_id',$value->id)->first();
        if(!empty($employeeLoans)){
          if($employeeLoans->loan_deduct_policy == 1){
            $ad_or_lone=round(($employeeLoans->loan_amount/$employeeLoans->no_of_installment));
            $employee_data[$key]['ad_or_lone']=$ad_or_lone;
            $employee_data[$key]['loan_deduct_policy']=1;
          }else{
             $ad_or_lone=collect($loan_adv_transactions)->where('employee_id',$value->id)->sum('loan_adv_amount');
              $employee_data[$key]['loan_deduct_policy']=2;
              $employee_data[$key]['ad_or_lone']=$ad_or_lone;
          }
        }else{
          $ad_or_lone=0;
          $employee_data[$key]['ad_or_lone']=$ad_or_lone;
        }  
        $uniform=collect($salary_deductions)->where('deduction_types',1)->where('employee_id',$value->id)->sum('deduction_amount');
        $employee_data[$key]['uniform']=$uniform;
        $deposit=collect($salary_deductions)->where('deduction_types',2)->where('employee_id',$value->id)->sum('deduction_amount');
        $employee_data[$key]['deposit']=$deposit;
        // $tax_amount=$this->tax_calculation($g_salary,$b_salary,$h_allowance,$m_allowance,$c_allowance,$p_fund,$value->employee_gender,$value->employee_dob_certificate);
        $employee_data[$key]['tax_amount']=$tax_amount;
        $mobileBills=collect($mobileInternetBills)->where('employee_id',$value->id)->where('bill_types',3)->sum('bill_amount');
        if(($mobileBills-$mobile_addition) > 0){
            $mobile_amount=$mobileBills-$mobile_addition;
            $employee_data[$key]['mobile_amount']=$mobile_amount;
        }else{
           $mobile_amount=0;
           $employee_data[$key]['mobile_amount']=$mobile_amount;
        }
        $other_amount=collect($salary_deductions)->where('deduction_types',3)->where('employee_id',$value->id)->sum('deduction_amount');
        $employee_data[$key]['other_amount']=$other_amount;
  }else{
      $ad_or_lone=0;
      $employee_data[$key]['ad_or_lone']=$ad_or_lone;
      $uniform=0;
      $employee_data[$key]['uniform']=$uniform;
      $deposit=0;
      $employee_data[$key]['deposit']=$deposit;
      // $tax_amount=0;
      $employee_data[$key]['tax_amount']=$tax_amount;
      $mobile_amount=0;
      $employee_data[$key]['mobile_amount']=$mobile_amount;
      $other_amount=0;
      $employee_data[$key]['other_amount']=$other_amount;
      $mobile_addition=0;
      $employee_data[$key]['mobile_addition']=$mobile_addition;
      $car_allowance=collect($payrolInfo)->where('employee_id',$value->id)->sum('car_allowance_amount');
      $employee_data[$key]['car_allowance']=$car_allowance;
      $other_allowance=0;
      $employee_data[$key]['other_allowance']=$other_allowance;
      $totalAddition=($arrear_amount+$p_fund+$p_fund+$mobile_addition+$car_allowance+$other_allowance);
  }
    $employee_data[$key]['p_fund']=$p_fund;
    $employee_data[$key]['c_p_fund']=$p_fund;
    $totalDeduction=($p_fund+$ad_or_lone+$uniform+$deposit+$tax_amount+$mobile_amount+$other_amount);
    // // Deduction
    $employee_data[$key]['net_payable']=(($g_payble+$totalAddition)-$totalDeduction);
    $total_salary += $bonus_amount_ind;
  }
  $total_employee += $employee;

  // return response($bonus_amount_ind);   
  $employeeData['fist_date_of_month']=$fist_date_of_month;
  $employeeData['last_date_of_month']=$last_date_of_month;
  $employeeData['employee_sbu_id']=$request['id'];
  $employeeData['salary_type_id']=$request['salary_type_id'];
  $employeeData['bonus_for']=$request['bonus_for'];
  $employeeData['months_id']=$request->months_id;
  $employeeData['total_salary']=$total_salary;
  $employeeData['total_employee']=$total_employee;
  $employeeData['salary_type']=$request['salary_type_id'];
  $data['employee_data']=$employee_data;
  $data['employeeData']=$employeeData;
  return response()->json($data);
}

public function store(Request $request)
{
  // return response($request);
  try {
    DB::beginTransaction();
      $existing_bonus_data = DB::table('bonus_process_datas')->where('company_sbu_id',$request->employeeData['employee_sbu_id'])->where('bonus_month',$request->employeeData['months_id'])->get();
      if(!empty($existing_bonus_data) && count($existing_bonus_data) > 0){
        $message=['status' => 0, 'message' => 'Bonus already processed for this month'];
        return response($message);
      }
      $employee_data=collect($request->employee_data)->where('employee_sbu','!=','')->toArray();
      $month_num =date("F", mktime(0, 0, 0, $request->employeeData['months_id'], 10));
      
      $bonus_process=[
        "companysbu_id"=>$request->employeeData['employee_sbu_id'],
        "bonus_month"=>$month_num,
        "process_date"=>date('Y-m-d'),
        "startdate"=>$request->employeeData['fist_date_of_month'],
        "enddate"=>$request->employeeData['last_date_of_month'],
        "remarks"=>'Not Processed',
        "type"=>$request->employeeData['salary_type_id'],
        "bonus_for"=>$request->employeeData['bonus_for'],
        "total_employee"=>isset($request->employeeData['total_employee'])?$request->employeeData['total_employee']:0,
        "total_bonus_amount"=>isset($request->employeeData['total_salary'])?$request->employeeData['total_salary']:0,
        "status"=>1,
        "settlement"=>1,
        "project_id"=>Auth::guard('user')->user()->project_id,
        "branch_id"=>Auth::guard('user')->user()->branch_id,
        "created_by"=>Auth::guard('user')->user()->id,
        "created_at"=>date('Y-m-d H:i:s'),
      ];
      // return response($bonus_process);
      $save_id=BonusProcessList::create($bonus_process);
      // $save_id = DB::table('bonus_process')->insert($bonus_process);
    
      foreach ($employee_data as $key => $value) {
            $payroll[]=[
              "employee_id"=>$value['id'],
              "bonus_process_id"=>$save_id['id'],
              "company_sbu_id"=>$value['employee_sbu'],
              "salary_sbu_id"=>$value['employee_sbu'],
              "entry_date"=> date('Y-m-d'),
              "bonus_month"=> $request->employeeData['months_id'],
              "bonus_type"=> $request->employeeData['salary_type_id'],
              "bonus_percentage"=>$value['bonus_percentage'],
              "bonus_amount"=>$value['bonus_amount'],
              "project_id"=>Auth::guard('user')->user()->project_id,
              "branch_id"=>Auth::guard('user')->user()->branch_id,
              "created_by"=>Auth::guard('user')->user()->id,
              "created_at"=>date('Y-m-d H:i:s'),
            ]; 
      }
      DB::table('bonus_process_datas')->insert($payroll);
      DB::commit();
      $message=['status' => 1, 'message' => 'Your data is successfully saved'];
      return response($message);
    } catch (\Exception $exception) {
        DB::rollBack();
        $message=['status' => 0, 'message' => 'Ops! Something went worng.'];
        return response($exception);
    }
}

// public function final_process_submit(Request $request){
//   if(!empty($request->id))
//    {
//       $update_data=BonusProcessList::valid()->project()->findOrFail($request->id);
//       $data['updated_by']=Auth::guard('user')->user()->id; 
//       $data['settlement']=2; 
//       $save_data=$update_data->update($data);
//       $message=['status' => 1, 'message' => 'Your data is successfully updated'];
//    }else{
//       $message=['status' => 0, 'message' => 'Ops! Something went worng.'];
//    }
//   return response()->json($message);
// }

public function edit($id)
{
  $data=NoticeModel::valid()->project()->findOrFail($id);
  $companysbu_data_list=CompanySbu::valid()->project()->get()->keyBy('id')->all();
  $section_data_list=Section::valid()->project()->get()->keyBy('id')->all();
  $sub_section_data_list=SubSection::valid()->project()->get()->keyBy('id')->all();
  $employee_group_data_list=EmployeeGroup::valid()->project()->get()->keyBy('id')->all();
  $department_list=Department::valid()->project()->get()->keyBy('id')->all();
  $designation_data_list=Designation::valid()->project()->get()->keyBy('id')->all();
  $jobgrade_data_list=JobGrade::valid()->project()->get()->keyBy('id')->all();
  $employee_data_list=Employee::valid()->project()->get()->keyBy('id')->all();
  $employee_reporting=Employee::valid()->project()->get()->keyBy('employee_id_no')->all();
  $sub_unit_data_list=SubUnit::valid()->project()->get()->keyBy('id')->all();
  $unit_data_list=UnitModel::valid()->project()->get()->keyBy('id')->all();
  $work_location_data_list=WorkLocation::valid()->project()->get()->keyBy('id')->all();
  if(!$data->sbu_id){
    $data->sbu_name_value = ['id'=>'','text'=>'']; 
  }else{
    $data->sbu_name_value = ['id'=>$data->sbu_id,'text'=>$companysbu_data_list[$data->sbu_id]->sbu_name];
  }
  if(!$data->section_id){
    $data->section_value = ['id'=>'','text'=>'']; 
  }else{
    $data->section_value = ['id'=>$data->section_id,'text'=>$section_data_list[$data->section_id]->section_name];
  }
  if(!$data->subsection_id){
    $data->sub_section_value = ['id'=>'','text'=>'']; 
  }else{
    $data->sub_section_value = ['id'=>$data->subsection_id,'text'=>$sub_section_data_list[$data->subsection_id]->sub_section_name];
  }
  if(!$data->employee_id){
    $data->employee_name_value = ['id'=>'','text'=>'']; 
  }else{
    $data->employee_name_value = ['id'=>$data->employee_id,'text'=>$employee_data_list[$data->employee_id]->employee_fullname];
  }
  if(!$data->department_id){
    $data->department_name_value = ['id'=>'','text'=>'']; 
  }else{
    $data->department_name_value = ['id'=>$data->department_id,'text'=>$department_list[$data->department_id]->department_name];
  }
  
  if(!$data->subunit_id){
    $data->sub_unit_value = ['id'=>'','text'=>'']; 
  }else{
    $data->sub_unit_value = ['id'=>$data->subunit_id,'text'=>$sub_unit_data_list[$data->subunit_id]->sub_unit_name];
  }
  if(!$data->unit_id){
    $data->unit_value = ['id'=>'','text'=>'']; 
  }else{
    $data->unit_value = ['id'=>$data->unit_id,'text'=>$unit_data_list[$data->unit_id]->unit_name];
  }
 
  $company_sbu_data=array();
  $section_data=array();
  $sub_section_data=array();
  $employee_group_data=array();
  $department_data=array();
  $designation_data=array();
  $jobgrade_data=array();
  $employee_data=array();
  $employee_data_approval=array();
  $unit_data=array();
  $sub_unit_data=array();
  $work_location_data=array();
  foreach ($companysbu_data_list as $value) {
    array_push($company_sbu_data,['id'=>$value['id'],'text'=>$value['sbu_name']]);
  }
  foreach ($section_data_list as $value) {
    array_push($section_data,['id'=>$value['id'],'text'=>$value['section_name']]);
  }
  foreach ($sub_section_data_list as $value) {
    array_push($sub_section_data,['id'=>$value['id'],'text'=>$value['sub_section_name']]);
  }
  foreach ($employee_group_data_list as $value) {
    array_push($employee_group_data,['id'=>$value['id'],'text'=>$value['employee_group_name']]);
  }
  foreach ($department_list as $value) {
    array_push($department_data,['id'=>$value['id'],'text'=>$value['department_name']]);
  }
  foreach ($designation_data_list as $value) {
    array_push($designation_data,['id'=>$value['id'],'text'=>$value['designation_name']]);
  }
  foreach ($jobgrade_data_list as $value) {
    array_push($jobgrade_data,['id'=>$value['id'],'text'=>$value['jobgrade_name']]);
  }
  foreach ($employee_data_list as $value) {
    array_push($employee_data,['id'=>$value['id'],'text'=>$value['employee_id_no'].' - '.$value['employee_fullname']]);
  }
  foreach ($sub_unit_data_list as $value) {
    array_push($sub_unit_data,['id'=>$value['id'],'text'=>$value['sub_unit_name']]);
  }
  foreach ($unit_data_list as $value) {
    array_push($unit_data,['id'=>$value['id'],'text'=>$value['unit_name']]);
  }
  foreach ($work_location_data_list as $value) {
    array_push($work_location_data,['id'=>$value['id'],'text'=>$value['department_name']]);
  }

  $approvalInfos=NoticePermission::valid()->project()->where('notice_id',$id)->get();
// return response($approvalInfos);
  if(!empty($approvalInfos)){
    $data->approval_infos=$approvalInfos;
  }else{
     $date->approval_infos=['0' =>['id'=>0,'permission_type'=>'','permission_id'=>'']];
  }

  $data->company_sbu_data =  $company_sbu_data;
  $data->section_data =  $section_data;
  $data->sub_section_data =  $sub_section_data;
  $data->employee_group_data =  $employee_group_data;
  $data->department_data =  $department_data;
  $data->designation_data =  $designation_data;
  $data->jobgrade_data =  $jobgrade_data;
  $data->employee_data =  $employee_data;
  $data->sub_unit_data =  $sub_unit_data;
  $data->unit_data =  $unit_data;
  $data->work_location_data =  $work_location_data;
  return response($data);

}

public function destroy($id)
{

  $delete_data=NoticeModel::valid()->project()->findOrFail($id);
  if($delete_data->delete())
  {
    $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
  }
  return response($message);

}

  public function create(){
      $data['company_sbu_data']=array();
      $data['section_data']=array();
      $data['sub_section_data']=array();
      $data['sub_unit_data']=array();
      $data['unit_data']=array();
      $data['work_location_data']=array();
      $data['department_data']=array();
      $data['designation_data']=array();
      $data['jobgrade_data']=array();
      $data['employee_data']=array();
      $data['employee_data_approval']=array();
      $data['employee_group_data']=array();
      $company_sbu_data=CompanySbu::valid()->project()->get();
      $section_data=Section::valid()->project()->get();
      $sub_section_data=SubSection::valid()->project()->get();
      $department_data=Department::valid()->project()->get();
      $designation_data=Designation::valid()->project()->get();
      $jobgrade_data=JobGrade::valid()->project()->get();
      $employee_data_approval=Employee::valid()->project()->get();
      // return response($employee_data_approval);
      $employee_data=Employee::valid()->project()->get()->keyBy('id')->all();
      $unit_data=UnitModel::valid()->project()->get();
      $sub_unit_data=SubUnit::valid()->project()->get();
      $work_location_data=WorkLocation::valid()->project()->get();
      $employee_group_data=EmployeeGroup::valid()->project()->get();
      foreach ($company_sbu_data as $value) {
        array_push($data['company_sbu_data'],['id'=>$value['id'],'text'=>$value['sbu_name']]);
      } 
      foreach ($section_data as $value) {
        array_push($data['section_data'],['id'=>$value['id'],'text'=>$value['section_name']]);
      } 
      foreach ($sub_section_data as $value) {
        array_push($data['sub_section_data'],['id'=>$value['id'],'text'=>$value['sub_section_name']]);
      }
      foreach ($employee_group_data as $value) {
        array_push($data['employee_group_data'],['id'=>$value['id'],'text'=>$value['employee_group_name']]);
      }
      foreach ($department_data as $value) {
        array_push($data['department_data'],['id'=>$value['id'],'text'=>$value['department_name'],]);
      }
      foreach ($designation_data as $value) {
        array_push($data['designation_data'],['id'=>$value['id'],'text'=>$value['designation_name']]);
      }
      foreach ($jobgrade_data as $value) {
        array_push($data['jobgrade_data'],['id'=>$value['id'],'text'=>$value['jobgrade_name']]);
      }
      foreach ($employee_data as $value) {

        array_push($data['employee_data'],['id'=>$value['id'],'text'=>$value['employee_id_no'].' - '.$value['employee_fullname']]);
      }

      foreach ($sub_unit_data as $value) {
        array_push($data['sub_unit_data'],['id'=>$value['id'],'text'=>$value['sub_unit_name']]);
      }

      foreach ($unit_data as $value) {
         // return response($value);
        array_push($data['unit_data'],['id'=>$value['id'],'text'=>$value['unit_name']]);
      }

      foreach ($work_location_data as $value) {
        array_push($data['work_location_data'],['id'=>$value['id'],'text'=>$value['work_location_name']]);
      }

      $data['approval_infos']=['0' =>['id'=>0,'permission_type'=>'','permission_id'=>'']];





      return response($data);
  }

  // public function findDepartmentMaxCode(){
  //   $last_entry_data=NoticeModel::latest()->first();
  //   $department_last_code = isset($last_entry_data['department_code'])?$last_entry_data['department_code']:0;
  //   if ($department_last_code==0) {
  //     $department_last_code = 101;
  //   }else{
  //     $department_last_code = $department_last_code+1;
  //   }
  //   return $department_last_code;
  // }


}
