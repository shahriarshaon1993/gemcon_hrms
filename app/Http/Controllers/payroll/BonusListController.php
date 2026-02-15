<?php
namespace App\Http\Controllers\payroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
// use Session;
// use App\Model\payroll\PayrollList;
use App\Model\payroll\BonusProcessList;
use App\Model\payroll\BonusProcessListDetails;
// use App\Model\payroll\ProvidentFund;
use App\Model\Employee;
// use App\Model\CompanySbu;
// use App\Model\Department;
// use App\Model\Designation;
// use App\Model\JobGrade;
// use App\Model\LeaveType;
// use App\Model\LeaveApplication;
// use App\Model\EmployeeApproval;
// use App\Model\UsersPersonModel;
// use App\Model\payroll\SalarySetting;
use App\Model\payroll\Salary;
use Cache;
use permission;
use DB;
// use App\Model\UserRoleAccess;

class BonusListController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $employee_list = new Employee();
  $employee_ids=$employee_list->Employee_id();
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','BonusProcessList')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
  foreach($permission as $child) {
      if($child['link_uid']=='add'){
          $data['add']=$child['link_uid'];
      }elseif($child['link_uid']=='edit'){
          $data['edit']=$child['link_uid'];
      }elseif($child['link_uid']=='delete') {
          $data['delete']=$child['link_uid'];
      }else {
          $data['view']=$child['link_uid'];
      }
  }

  $paginate_num = $request->input('paginate_num');
  $search_key = $request->input('search_key');
  $order = $request->input('order');
  $sort = $request->input('sort');
  $project_id=Auth::guard('user')->user()->project_id;
  $branch_id=Auth::guard('user')->user()->branch_id;
  $paginate_data =BonusProcessList::valid()->project()
  ->leftJoin('company_sbus',  'company_sbus.id', '=', 'bonus_process.companysbu_id')
  ->select(
    'bonus_process.*',
    'company_sbus.sbu_name'
  )
  ->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('bonus_process.paymonth','LIKE','%'.$search_key.'%')
      ->orWhere('company_sbus.sbu_name','LIKE','%'.$search_key.'%')
      ;
    });
    return $query;
  })->where('bonus_process.project_id',$project_id) ->orderBy($sort,$order);
  $sortData=$paginate_data;
  $sortGetData=$sortData->get();
  $data['total_data']=count($sortGetData);
  $data['active_data']=count(collect($sortGetData)->where('employee_status',1)->toArray());
  $data['inactive_data']=count(collect($sortGetData)->whereIn('employee_status',2)->toArray());
  $data['paginate_data'] =$sortData->paginate($paginate_num);

  return response()->json($data);
}




  public function bonus_process_list_details(Request $request){
    $payrolInfo=BonusProcessListDetails::valid()->where('bonus_process_id',$request['page_ref_id'])->get();
    $employee_all_id=collect($payrolInfo)->pluck('employee_id')->toArray();
    $payrollData=BonusProcessList::valid()->where('id',$request['page_ref_id'])->first();
    $data['processing_date']= date('d F Y',strtotime($payrollData->process_date));
    $data['processing_year']= date('Y',strtotime($payrollData->process_date));
    if($payrollData->bonus_for==1){
      $data['bonus_for_eid']='Eid-Ul-Fitr';
    }elseif($payrollData->bonus_for==2){
      $data['bonus_for_eid']='Eid-Ul-Adha';
    }else{
      $data['bonus_for_eid']='';
    }
    $data['month_name']=$payrollData['paymonth'];
    $SalaryInfo=Salary::valid()->whereIn('employee_id',$employee_all_id)->where('salary_sbu_id',$payrollData['companysbu_id'])->where('salary_goes_to',$payrollData['type'])->get();
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
        'designations.designation_name',
        )->whereIn('employees.id',$employee_all_id)->get();
    foreach ($payrolInfo as $key => $value) {
        $employeeInfo=collect($employee_data)->where('id',$value->employee_id)->first();
        $payrolInfo[$key]['employee_id_no']=isset($employeeInfo)?$employeeInfo['employee_id_no']:'-';
        $payrolInfo[$key]['employee_fullname']=isset($employeeInfo)?$employeeInfo['employee_fullname']:'-';
        $payrolInfo[$key]['designation_name']=isset($employeeInfo)?$employeeInfo['designation_name']:'-';
        $payrolInfo[$key]['jobgrade_name']=isset($employeeInfo)?$employeeInfo['jobgrade_name']:'-';
        $payrolInfo[$key]['employee_joining_date']=isset($employeeInfo)?$employeeInfo['employee_joining_date']:'-';
        $payrolInfo[$key]['ebc_account_number']=isset($employeeInfo)?$employeeInfo['ebc_account_number']:'-';
        $g_salary=collect($SalaryInfo)->where('employee_id',$value->employee_id)->sum('gross_salary');
        $b_salary=collect($SalaryInfo)->where('employee_id',$value->employee_id)->sum('basic_salary');
        $payrolInfo[$key]['g_salary']=isset($g_salary)?$g_salary:'0';
        $payrolInfo[$key]['b_salary']=isset($b_salary)?$b_salary:'0';
        $payrolInfo[$key]['g_payble']=($value['basic']+$value['houserent']+$value['medical']+$value['transport']);
    }
    
    $data['report_date']=date('d F Y',strtotime($payrollData['startdate'])).' to '. date('d F Y',strtotime($payrollData['enddate']));
    $data['employee_data']=$payrolInfo;
    return response()->json($data);
  }

  

  public function final_process($id=false){
    $data['id'] = $id;
    return response()->json($data);
  }
  public function final_process_submit(Request $request){
    // return response()->json($request);
    if(!empty($request->id))
     {
        $update_data=BonusProcessList::valid()->project()->findOrFail($request->id);
        $data['updated_by']=Auth::guard('user')->user()->id; 
        $data['settlement']=2; 
        $data['remarks']='Processed'; 
        $save_data=$update_data->update($data);
        $message=['status' => 1, 'message' => 'Your data is successfully updated'];
     }else{
        $message=['status' => 0, 'message' => 'Ops! Something went worng.'];
     }
    return response()->json($message);
  }

  public function destroy($id)
  {
    try {
      DB::beginTransaction();
      $delete_data=BonusProcessList::valid()->project()->findOrFail($id);
      if($delete_data->delete())
      {
        DB::table('bonus_process_datas')->where('bonus_process_id', '=', $id)->delete();
        DB::table('bonus_process')->where('id', '=', $id)->delete();
        $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
      }
      DB::commit();
      $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
      return response($message);
    } catch (\Exception $exception) {
      DB::rollBack();
      $message=['status' => 0, 'message' => 'Ops! Something went worng.'];
      return response($exception);
    }
  }
}
