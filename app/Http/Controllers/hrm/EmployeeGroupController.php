<?php

namespace App\Http\Controllers\hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\EmployeeGroup;
use Cache;
use permission;
// use App\Model\UserRoleAccess;

class EmployeeGroupController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','EmployeeGroup')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
  $paginate_data =EmployeeGroup::valid()->project()->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('employee_group_name','LIKE','%'.$search_key.'%');
      $query2->orWhere('employee_group_code','LIKE','%'.$search_key.'%');
    });
    return $query;

  })->where('project_id',$project_id)->orderBy($sort,$order);
  // ->paginate($paginate_num);
  $sortData=$paginate_data;

  $sortGetData=$sortData->get();
  $data['total_data']=count($sortGetData);
  $data['inactive_data']=count(collect($sortGetData)->whereIn('employee_group_status',0)->toArray());
  $data['active_data']=count(collect($sortGetData)->where('employee_group_status',1)->toArray());
    $data['paginate_data'] =$sortData->paginate($paginate_num);

  return response()->json($data);
}


public function store(Request $request)
{
  // echo "<pre>";print_r($this->findMaxCode()); die();
  // $validate=[
  //   'employee_group_name'=>'required|unique:employee_groups,employee_group_name'
  // ];
  $validate=[
    'employee_group_name'=>'required'
  ];

  $request->validate($validate);
  $data=$request->only('employee_group_name','employee_group_status','priority');

  if(!empty($request->id))
  {
    $update_data=EmployeeGroup::valid()->project()->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->branch_id; 
    $save_data=$update_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    $data['employee_group_code'] = $this->findMaxCode();
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
    $data['employee_group_status']=1; 
    $save_data=EmployeeGroup::create($data);
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
  $edit_data=EmployeeGroup::valid()->project()->findOrFail($id);
  return response($edit_data);

}

public function destroy($id)
{

  $delete_data=EmployeeGroup::valid()->project()->findOrFail($id);
  if($delete_data->delete())
  {
    $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
  }
  return response($message);

}

  public function findMaxCode(){
    $last_entry_data=EmployeeGroup::max('employee_group_code');
    $department_last_code = isset($last_entry_data)?$last_entry_data:0;
    if ($department_last_code==0) {
      $department_last_code = 101;
    }else{
      $department_last_code = $department_last_code+1;
    }
    return $department_last_code;
  }

  public function create(){
    $data['priority'] = $this->findPriority();
    return response($data);
  }

  public function findPriority(){
    $last_entry_data=EmployeeGroup::max('priority');
    $last_code = $last_entry_data;
    if ($last_code==0) {
      $last_code = 1;
    }else{
      $last_code = $last_code+1;
    }
    return $last_code;
  }


}
