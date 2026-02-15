<?php
namespace App\Http\Controllers\payroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\payroll\Salary;
use App\Model\payroll\Increment;
use App\Model\payroll\GratuityFund;
use App\Model\Employee;
use App\Model\UsersPersonModel;
use Cache;
use permission;
// use App\Model\UserRoleAccess;

class GratuityFundController extends Controller
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
  $permission=collect($cache)->where('menu_uid','=','GratuityFund')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
  $paginate_data =GratuityFund::valid()->project()
  ->leftJoin('employees',  'employees.id', '=', 'gratuity_funds.employee_id')
  ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
  ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
  ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
  ->selectRaw(
    'gratuity_funds.*,
     employees.employee_id_no,
     employees.employee_fullname,
     employees.employee_joining_date,
     company_sbus.sbu_name,
     departments.department_name,
     designations.designation_name
    '
  )
  ->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('gratuity_funds.gf_amount','LIKE','%'.$search_key.'%')
      ->orWhere('employees.employee_id_no','LIKE','%'.$search_key.'%')
      ->orWhere('employees.employee_fullname','LIKE','%'.$search_key.'%')
      ->orWhere('company_sbus.sbu_name','LIKE','%'.$search_key.'%')
      ->orWhere('departments.department_name','LIKE','%'.$search_key.'%')
      ->orWhere('designations.designation_name','LIKE','%'.$search_key.'%')
      ;
    });
    return $query;
  })->whereIn('employees.id',$employee_id)->groupBy('gratuity_funds.employee_id')->where('gratuity_funds.project_id',$project_id)->orderBy($sort,$order);
  // ->paginate($paginate_num);
  $sortData=$paginate_data;
  $sortGetData=$sortData->get();
  $data['total_data']=count($sortGetData);
  $data['active_data']=count(collect($sortGetData)->where('gf_status',1)->toArray());
  $data['inactive_data']=count(collect($sortGetData)->whereIn('gf_status',2)->toArray());
  $data['total_gf']=collect($sortGetData)->sum('gf_amount');
  $data['paginate_data'] =$sortData->paginate($paginate_num);

  $data['employee_salary']=Salary::valid()->project()
   ->groupBy('employee_id')
   ->selectRaw('employee_id,sum(gross_salary) as total_salary, sum(basic_salary) as total_basic, sum(housing_allowance) as total_house, sum(medical_allowance) as total_medical, sum(conveyance_allowance) as total_transport')
   ->get();
  return response()->json($data);
}


public function store(Request $request)
{
  // echo "<pre>";print_r($this->findDepartmentMaxCode()); die();
  $validate=[
    'employee_id'=>'required',
    'gross_salary'=>'required'
  ];

  $request->validate($validate);
  $data=$request->only('employee_id','gross_salary','confirmation_date','basic_salary','housing_allowance','medical_allowance','conveyance_allowance','overtime_work_compensation','salary_status','provident_fund','car_allowance_status','car_allowance_amount','others_allowance','gratuity_fund');

  if(!empty($request->id))
  {
    $update_data=GratuityFund::valid()->project()->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->branch_id; 
    $save_data=$update_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    // $data['department_code'] = $this->findDepartmentMaxCode();
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
    $data['salary_status']=1; 
    $data['type']=1; 
    $save_data=GratuityFund::create($data);
    $message=['status' => 1, 'message' => 'Your data is successfully saved'];
  }

  if(!$save_data)

  {
    $message=['status' => 0, 'message' => 'Ops! Something went worng.'];

  }
  return response($message);

}

public function edit($id)
{
  // $edit_data=GratuityFund::valid()->project()->findOrFail($id);
  // return response($edit_data);
 // return response($id);
  $data=GratuityFund::valid()->project()->where('type',1)->findOrFail($id);
  $employee_data=array();
  $employee_data_list=Employee::valid()->project()->get()->keyBy('id')->all();
  foreach ($employee_data_list as $value) {
    array_push($employee_data,['id'=>$value['id'],'text'=>$value['employee_id_no']." - ". $value['employee_fullname']]);
  }

  $employee_list = new Employee();
  $employee_ids=$employee_list->Employee_id();
  $employee_id=$employee_ids['employee_id'];

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
    ->where('employees.id',$data->employee_id)->first();

   
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
       'sections.section_name',
       'departments.department_name',
       'designations.designation_name',
       'sub_units.sub_unit_name',
       'work_locations.work_location_name',
        'employee_personal_infos.employee_gender'
     )->whereIn('employee_sbu',$employee_ids['sub'])
       ->whereIn('employee_department',$employee_ids['department'])
     ->get()->keyBy('id');

     if(!$data->employee_id){
       $data->employee_name_value = ['id'=>'','text'=>'']; 
     }else{
       $data->employee_name_value = ['id'=>$data->employee_id,'text'=>$employee_data_list[$data->employee_id]->employee_fullname];
     }

    // $salary_setting=SalarySetting::valid()->project()->where('status', 1)->first();
    // $data->salary_setting = $salary_setting;  
    $data->user_employee_data_all = $user_employee_data_all;  
    $data->user_employee_data = $user_employee_data;
    $data->employee_data =  $employee_data;
     // return response($salary_setting);
  return response($data);

}

public function destroy($id)
{

  $delete_data=GratuityFund::valid()->project()->where('type',2)->findOrFail($id);
  if($delete_data->delete())
  {
    $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
  }
  return response($message);

}

  public function create(){
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

      $data['employee_data']=array();
      $employee_data=Employee::valid()->project()->get();
      foreach ($employee_data as $value) {
        array_push($data['employee_data'],['id'=>$value['id'],'text'=>$value['employee_id_no']." - ". $value['employee_fullname']]);
      }
      $data['user_employee_data'] = $user_employee_data;
      return response($data);
  }

  public function findDepartmentMaxCode(){
    $last_entry_data=GratuityFund::latest()->where('type',2)->first();
    $department_last_code = $last_entry_data['department_code'];
    if ($department_last_code==0) {
      $department_last_code = 101;
    }else{
      $department_last_code = $department_last_code+1;
    }
    return $department_last_code;
  }

  public function salary_details($employee_id){
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

    $emp_salary=GratuityFund::valid()->project()->where('employee_id', $employee_id)->get();

    $data['emp_info']=Employee::valid()->project()->where('id', $employee_id)->first();
    $data['user_employee_data'] = $user_employee_data;
    $data['emp_salary'] = $emp_salary;
    return response($data);
  }

  public function gratuity_fund_details(Request $request){
    // return response($request);
    $user_employee_data=Employee::valid()->project()
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
      ->where('employees.id',$request->page_ref_id)->where('salaries.type',1)->first();
    $emp_gratuity_fund=GratuityFund::valid()->project()->where('employee_id', $request->page_ref_id)->get();
    $emp_salary=Salary::valid()->project()->where('employee_id', $request->page_ref_id)->get();
    $data['user_employee_data'] = $user_employee_data;
    $data['emp_salary'] = $emp_salary;
    $data['emp_gratuity_fund'] = $emp_gratuity_fund;
    return response($data);
  }


}
