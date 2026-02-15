<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\Department;
use App\Model\Employee;
use App\Model\DepartmentHead;
use Cache;
use permission;
use DB;
// use App\Model\UserRoleAccess;

class DepartmentController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','Department')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
  $paginate_num = $request->input('paginate_num');
  $search_key = $request->input('search_key');
  if ($request->input('sort') =='id') {
    $order = 'ASC';
    $sort = 'priority';
  } else {
    $order = $request->input('order');
    $sort = $request->input('sort');
  }
  $project_id=Auth::guard('user')->user()->project_id;
  $branch_id=Auth::guard('user')->user()->branch_id;

  $employee_list = new Employee();
  $employee_ids=$employee_list->Employee_id();
  $paginate_data =Department::valid()->project()
  ->leftJoin('employees', 'departments.id', '=', 'employees.employee_department')
  ->leftJoin('department_heads', 'department_heads.dh_head_id', '=', 'employees.id')
  // ->leftJoin('employees as emp2', 'emp2.id', '=', 'departments.department_head')
  ->select(
    'departments.*',
    'employees.employee_fullname',
    DB::raw('COUNT(employees.id) as total_dep_emp')
  )
  ->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('departments.department_name','LIKE','%'.$search_key.'%');
      $query2->orWhere('employees.employee_fullname','LIKE','%'.$search_key.'%');
      $query2->orWhere('departments.department_code','LIKE','%'.$search_key.'%');
    });
    return $query;

  })->whereIn('departments.id',$employee_ids['department'])->where('departments.project_id',$project_id)->groupBy('employees.employee_department')->orderBy($sort,$order);
  // ->paginate($paginate_num);

  $sortData=$paginate_data;
   $data['paginate_data'] =$sortData->paginate($paginate_num);
   $sortGetData=$sortData->get();
   $data['total_data']=count($sortGetData);
   $data['inactive_data']=count(collect($sortGetData)->whereIn('department_status',0)->toArray());
   $data['active_data']=count(collect($sortGetData)->where('department_status',1)->toArray());
   return response()->json($data);
}


public function store(Request $request)
{
  // echo "<pre>";print_r($this->findDepartmentMaxCode()); die();
  $validate=[
    'department_name'=>'required'
  ];

  $request->validate($validate);
  $data=$request->only('department_name','department_status','department_head','priority');

  if(!empty($request->id))
  {
    $update_data=Department::valid()->project()->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->id; 
    $save_data=$update_data->update($data);
    $approval_infos=collect($request['approval_infos'])->where('dh_head_id','!=','')->toArray();
    if ($approval_infos!=='') {
      DB::table('department_heads')->where('dh_department_id', '=', $request->id)->delete();
      $i=0;
      foreach ($approval_infos as $key => $value) {
        $i++;
        $approval_data['dh_department_id']=$request->id;
        $approval_data['dh_level']=$i;
        $approval_data['dh_head_id']=$value['dh_head_id']; 
        $approval_data['project_id']=Auth::guard('user')->user()->project_id;
        $approval_data['branch_id']=Auth::guard('user')->user()->branch_id; 
        $approval_data['created_by']=Auth::guard('user')->user()->id; 
        DB::table('department_heads')->insert($approval_data);
      }
    }

    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    $data['department_code'] = $this->findDepartmentMaxCode();
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
    $data['department_status']=1; 
    $save_data=Department::create($data);
    $approval_infos=collect($request['approval_infos'])->where('dh_head_id','!=','')->toArray();
    if ($approval_infos!=='') {
      $i=0;
      foreach ($approval_infos as $key => $value) {
        $i++;
        $approval_data['dh_department_id']=$save_data->id;
        $approval_data['dh_level']=$i;
        $approval_data['dh_head_id']=$value['dh_head_id']; 
        $approval_data['project_id']=Auth::guard('user')->user()->project_id;
        $approval_data['branch_id']=Auth::guard('user')->user()->branch_id; 
        $approval_data['created_by']=Auth::guard('user')->user()->id; 
        DB::table('department_heads')->insert($approval_data);
      }
    }
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
  $edit_data=Department::valid()->project()->findOrFail($id);
  $employee_data_list=Employee::valid()->project()->get()->keyBy('id')->all();

   $edit_data->approval_infos=DepartmentHead::valid()->project()
                              ->join('employees', 'employees.id', '=', 'department_heads.dh_head_id')
                              ->select('employees.employee_id_no as employees_ids','employees.employee_fullname as dh_head_id_name')
                              ->where('department_heads.dh_department_id',$id)
                              ->get();
                              // dh_head_id_name,employees_ids

  $employee_data_approval=Employee::valid()->project()->whereIn('employee_sbu',$employee_ids['sub'])->whereIn('employee_department',$employee_ids['department'])->get();

  $employee_data_approval=array();
  if(!$edit_data->department_head){
    $edit_data->employee_name_value = ['id'=>'','text'=>'']; 
  }else{
    $edit_data->employee_name_value = ['id'=>$edit_data->department_head,'text'=>$employee_data_list[$edit_data->department_head]->employee_fullname];
  }
  $employee_data=array();
  foreach ($employee_data_list as $value) {
    array_push($employee_data,['id'=>$value['id'],'text'=>$value['employee_fullname']]);
  }
  foreach ($employee_data_list as $value) {
    array_push($employee_data_approval,['id'=>$value['id'],'employee_name'=>$value['employee_fullname'],'employee_ids'=>$value['employee_id_no'],'text'=>$value['employee_id_no'].' : '.$value['employee_fullname']]);
  }
  $edit_data->employee_data =  $employee_data;
  if (!empty($employee_data_approval)) {
    $edit_data->employee_data_approval =  $employee_data_approval;
  }
  return response($edit_data);

}

public function destroy($id)
{

  $delete_data=Department::valid()->project()->findOrFail($id);
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
      $employee_data=Employee::valid()->project()->get();
      $employee_data_approval=Employee::valid()->project()->whereIn('employee_sbu',$employee_ids['sub'])->whereIn('employee_department',$employee_ids['department'])->get();
      foreach ($employee_data as $value) {
        array_push($data['employee_data'],['id'=>$value['id'],'text'=>$value['employee_fullname']]);
      }
      foreach ($employee_data_approval as $value) {
        array_push($data['employee_data_approval'],['id'=>$value['id'],'employee_name'=>$value['employee_fullname'],'employee_ids'=>$value['employee_id_no'],'text'=>$value['employee_id_no'].' : '.$value['employee_fullname']]);
      }
      $data['approval_infos']=['0' =>['id'=>0,'dh_head_id'=>'','employees_ids'=>'','dh_head_id_name'=>'']];
      $data['priority'] = $this->findPriority();
      return response($data);
  }

  public function findDepartmentMaxCode(){
    $last_entry_data=Department::max('department_code');
    $department_last_code = isset($last_entry_data)?$last_entry_data:0;
    if ($department_last_code==0) {
      $department_last_code = 101;
    }else{
      $department_last_code = $department_last_code+1;
    }
    return $department_last_code;
  }

  public function findPriority(){
    $last_entry_data=Department::max('priority');
    $last_code = $last_entry_data;
    if ($last_code==0) {
      $last_code = 1;
    }else{
      $last_code = $last_code+1;
    }
    return $last_code;
  }


}
