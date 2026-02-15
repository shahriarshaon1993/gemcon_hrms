<?php
namespace App\Http\Controllers\payroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\payroll\PayrollProcessList;
use App\Model\payroll\PayrollList;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\Department;
use App\Model\Designation;
use App\Model\JobGrade;
use App\Model\LeaveType;
use App\Model\LeaveApplication;
use App\Model\EmployeeApproval;
use App\Model\UsersPersonModel;
use App\Model\payroll\SalarySetting;
use App\Model\payroll\Salary;
use Cache;
use permission;
// use App\Model\UserRoleAccess;

class PaySlipController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $employee_list = new Employee();
  $employee_ids=$employee_list->Employee_id();
  $employee_id=$employee_ids['employee_id'];
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','PaySlip')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
  $paginate_data = PayrollList::valid()->project()
      ->leftJoin('payroll_process',  'payroll_process.id', '=', 'payroll.procsid')
      ->leftJoin('employees',  'employees.id', '=', 'payroll.empid')
      ->leftJoin('company_sbus',  'company_sbus.id', '=', 'payroll.companysbu_id')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->selectRaw(
        'payroll.*,
        employees.employee_id_no,
        employees.employee_fullname,
        designations.designation_name,
        departments.department_name,
        company_sbus.sbu_name,
        work_locations.work_location_name,
        payroll_process.paymonth,
        sum(payroll.gross_salary) as gross_salary,
        sum(payroll.netpay) as netpay,
         sum((payroll.arear+payroll.additional_mobile+payroll.allowance+payroll.car_allowance)) as total_additions,
        sum((payroll.deduction_pfbasic+payroll.deduction_others+payroll.deduction_uniform+payroll.deduction_deposit+payroll.deduction_mobilebill+payroll.deduction_loan+payroll.deduction_tax)) as total_deduction
        '
      )
  ->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('payroll.companysbu_id','LIKE','%'.$search_key.'%')
      ->orWhere('company_sbus.sbu_name','LIKE','%'.$search_key.'%')
      ->orWhere('employees.employee_fullname','LIKE','%'.$search_key.'%')
      ->orWhere('company_sbus.sbu_name','LIKE','%'.$search_key.'%')
      ->orWhere('departments.department_name','LIKE','%'.$search_key.'%')
      ->orWhere('designations.designation_name','LIKE','%'.$search_key.'%')
      ->orWhere('work_locations.work_location_name','LIKE','%'.$search_key.'%')
      ;
    });
    return $query;
  })->whereIn('employees.id',$employee_id)->whereIn('company_sbus.id',$employee_ids['sub'])->where('payroll_process.settlement', 2)->groupBy('payroll_process.paymonth')->groupBy('employees.employee_id_no')->where('payroll.project_id',$project_id) ->orderBy($sort,$order);
  $sortData=$paginate_data;
  $sortGetData=$sortData->get();
  $data['total_data']=count($sortGetData);
  $data['inactive_data']=count(collect($sortGetData)->whereIn('salary_status',"!=",1)->toArray());
  $data['active_data']=count(collect($sortGetData)->where('salary_status',1)->toArray());
  $data['paginate_data'] =$sortData->paginate($paginate_num);
  return response()->json($data);
}



  public function create($id=False){
     $user_id = Auth::guard('user')->user()->id;
     $employee_list = new Employee();
     $employee_ids=$employee_list->Employee_id();
     $employee_id=$employee_ids['employee_id'];

     $user_data=UsersPersonModel::valid()->project()->where('id', $user_id)->first();
     if (!empty($id)) {
       $employee_id = $id;
     }else{
       $employee_id = $user_data->employee_id;
     }
     $user_employee_data=Employee::valid()->project()
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
       ->where('employees.id',$employee_id)->first();
        // return response($user_employee_data->employee_sbu);
      $data['employee_data']=array();
      $employee_data=Employee::valid()->project()->get();
      foreach ($employee_data as $value) {
        array_push($data['employee_data'],['id'=>$value['id'],'text'=>$value['employee_id_no']." - ". $value['employee_fullname']]);
      }

      $user_employee_data_all=Employee::valid()->project()
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
        )->whereIn('employee_sbu',$employee_ids['sub'])
          ->whereIn('employee_department',$employee_ids['department'])
        ->get()->keyBy('id');

       $salary_setting=SalarySetting::valid()->project()->where('status', 1)->where('company_sbu_id', $user_employee_data->employee_sbu)->first();
       $employee_salary=PayrollList::valid() 
       // ->selectRaw(
       //   'payroll.*
       //   '
       // )
       ->project()->where('employee_id',$id)->get();

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

  public function payroll_list_details(Request $request){
    
  }

  public function pay_slip_details(Request $request){
    
  }

}
