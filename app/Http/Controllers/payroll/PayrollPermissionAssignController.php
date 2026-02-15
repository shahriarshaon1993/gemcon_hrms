<?php
namespace App\Http\Controllers\payroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\payroll\PayrollPermissionAssign;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\JobGrade;
use Cache;
use permission;
use DB;
class PayrollPermissionAssignController extends Controller
{
  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Contracts\Support\Renderable
  */
  public function index(Request $request){
    $paginate_num = $request->input('paginate_num');
    $search_key = $request->input('search_key');
    $order = $request->input('order');
    $sort = $request->input('sort');

    $employee_list = new Employee();
    $employee_ids=$employee_list->Employee_id();
    $employee_id=$employee_ids['employee_id'];
    $cache=Cache::get('permission');
    $permission=collect($cache)->where('menu_uid','=','payrollPermissionAssign')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
    $paginate_data = PayrollPermissionAssign::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'payroll_permissions_assign.company_sbu_id')
      ->leftJoin('payroll_permissions', 'payroll_permissions.id', '=', 'payroll_permissions_assign.assign_id')
      ->leftJoin('employees', 'employees.id', '=', 'payroll_permissions_assign.employee_id')
      ->leftJoin('job_grades', 'job_grades.priority', '=', 'payroll_permissions.permission_grade_start')
      ->leftJoin('job_grades as lgs', 'lgs.priority', '=', 'payroll_permissions.permission_grade_end')
      ->select(
        'payroll_permissions_assign.*',
        'employees.employee_fullname',
        'employees.employee_id_no',
        'company_sbus.sbu_name',
        'payroll_permissions.permission_group',
        'job_grades.jobgrade_name as grade_first',
        'lgs.jobgrade_name as grade_last'
      )
      ->when($search_key, function($query, $search_key){
        $query->where(function($query2)use($search_key){
          $query2->where('payroll_permissions.permission_group','LIKE','%'.$search_key.'%');
        });
        return $query;
      })->whereIn('employees.id',$employee_id)->orderBy($sort,$order);
    $sortData=$paginate_data;
    $sortGetData=$sortData->get();
    $data['total_data']=count($sortGetData);
    $data['inactive_data']=count(collect($sortGetData)->whereIn('status',0)->toArray());
    $data['active_data']=count(collect($sortGetData)->where('status',1)->toArray());
    $data['paginate_data'] =$sortData->paginate($paginate_num);
    return response()->json($data);
  }
  public function store(Request $request)
  {    
    $validate=[
      'employee_id'=>'required',
      'assign_id'=>'required'
    ];
    $request->validate($validate);
    $data=$request->only('company_sbu_id','employee_id','assign_id','permission_grade_start','permission_grade_end','permission_status');

    if(!empty($request->id))
    {
      $update_data=PayrollPermissionAssign::valid()->project()->findOrFail($request->id);
      $data['updated_by']=Auth::guard('user')->user()->id; 
      $save_data=$update_data->update($data);
      $message=['status' => 1, 'message' => 'Your data is successfully updated'];
    }
    else {
      $data['project_id']=Auth::guard('user')->user()->project_id;
      $data['branch_id']=Auth::guard('user')->user()->branch_id; 
      $data['created_by']=Auth::guard('user')->user()->id; 
      $data['permission_status']=1; 
      $save_data=PayrollPermissionAssign::create($data);
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
    $employee_list = new Employee();
    $employee_ids=$employee_list->Employee_id();
    $employee_id=$employee_ids['employee_id'];


    $data=PayrollPermissionAssign::valid()->project()->findOrFail($id);

    $payrollPermissionassing=DB::table('payroll_permissions')->where('valid',1)->get()->keyBy('id')->all();
    $employeedatas=Employee::valid()->project()->whereIn('id',$employee_id)->get()->keyBy('id')->all();

    if(!$data->employee_id){
      $data->sbu_name_value = ['id'=>'','text'=>'']; 
    }else{
      $data->sbu_name_value = ['id'=>$data->employee_id,'text'=>$employeedatas[$data->employee_id]->employee_fullname];
    }

     if(!$data->assign_id){
      $data->Permission_groups = ['id'=>'','text'=>'']; 
    }else{
      $data->Permission_groups = ['id'=>$data->assign_id,'text'=>$payrollPermissionassing[$data->assign_id]->permission_group];
    }


    $employee_data=array();
    $payrollPermission=array();

    foreach ($employeedatas as $value) {
      array_push($employee_data,['id'=>$value['id'],'sbu_id'=>$value['employee_sbu'],'text'=>$value['employee_id_no']."-".$value['employee_fullname']]);
    }


    foreach ($payrollPermissionassing as $value) {
        array_push($payrollPermission,['id'=>$value->id,'grade_start'=>$value->permission_grade_start,'grade_end'=>$value->permission_grade_end,'text'=>$value->permission_group]);
      }

    $data->employee_data =  $employee_data;
    $data->payrollPermission =  $payrollPermission;
    return response($data);
  }

  public function destroy($id)
  {
    $delete_data=PayrollPermissionAssign::valid()->project()->findOrFail($id);
    if($delete_data->delete())
    {
      $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
    }
    return response($message);
  }

  public function create(){
      $employee_list = new Employee();
      $employee_ids=$employee_list->Employee_id();
      $employee_id=$employee_ids['employee_id'];

      $data['employee_data']=array();
      $data['payrollPermission']=array();
      $payrollPermissionassing=DB::table('payroll_permissions')->where('valid',1)->get();
      foreach ($payrollPermissionassing as $value) {
        array_push($data['payrollPermission'],['id'=>$value->id,'grade_start'=>$value->permission_grade_start,'grade_end'=>$value->permission_grade_end,'text'=>$value->permission_group]);
      }

      $employee_data=Employee::valid()->project()->whereIn('id',$employee_id)->get();
      foreach ($employee_data as $value) {
        array_push($data['employee_data'],['id'=>$value['id'],'sbu_id'=>$value['employee_sbu'],'text'=>$value['employee_id_no']."-".$value['employee_fullname']]);
      }

      return response($data);
  }

  public function findDepartmentMaxCode(){
    $last_entry_data=PayrollPermissionAssign::latest()->first();
    $department_last_code = $last_entry_data['department_code'];
    if ($department_last_code==0) {
      $department_last_code = 101;
    }else{
      $department_last_code = $department_last_code+1;
    }
    return $department_last_code;
  }

}
