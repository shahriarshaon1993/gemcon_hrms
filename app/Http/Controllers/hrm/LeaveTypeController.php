<?php

namespace App\Http\Controllers\hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\LeaveType;
use Cache;
use permission;
// use App\Model\UserRoleAccess;

class LeaveTypeController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','LeaveType')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
  $order = $request->input('order');
  $sort = $request->input('sort');
  $project_id=Auth::guard('user')->user()->project_id;
  $branch_id=Auth::guard('user')->user()->branch_id;
  $paginate_data =LeaveType::valid()->project()->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('leave_type_name','LIKE','%'.$search_key.'%');
    });
    return $query;

  })->where('project_id',$project_id)->orderBy('priority','DESC')->orderBy('priority','ASC')
   ->orderBy($sort,$order);
   // ->paginate($paginate_num);
  $sortData=$paginate_data;
  $sortGetData=$sortData->get();
  $data['total_data']=count($sortGetData);
  $data['inactive_data']=count(collect($sortGetData)->whereIn('leave_type_status',0)->toArray());
  $data['active_data']=count(collect($sortGetData)->where('leave_type_status',1)->toArray());
  $data['paginate_data'] =$sortData->paginate($paginate_num);

  return response()->json($data);
}


public function store(Request $request)
{
  // echo "<pre>";print_r($this->findDepartmentMaxCode()); die();
  $validate=[
    'leave_type_name'=>'required|unique:leave_types,leave_type_name,'.$request->id
  ];

  $request->validate($validate);
  $data=$request->only('leave_type_name','leave_type_status', 'priority','leave_short_type');

  if(!empty($request->id))
  {
    $update_data=LeaveType::valid()->project()->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->branch_id; 
    $save_data=$update_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    $data['leave_type_code'] = $this->findMaxCode();
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
    $data['leave_type_status']=1; 
    $save_data=LeaveType::create($data);
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
  $edit_data=LeaveType::valid()->project()->findOrFail($id);
  return response($edit_data);

}

public function destroy($id)
{

  $delete_data=LeaveType::valid()->project()->findOrFail($id);
  if($delete_data->delete())
  {
    $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
  }
  return response($message);

}

  // public function create(){
  //     $data['employee_data']=array();
  //     $employee_data=Employee::valid()->project()->get();
  //     foreach ($employee_data as $value) {
  //       array_push($data['employee_data'],['id'=>$value['id'],'text'=>$value['employee_fullname']]);
  //     }
  //     return response($data);
  // }

public function findMaxCode(){
  $last_entry_data=LeaveType::latest()->first();
  $last_code = isset($last_entry_data['leave_type_code'])?$last_entry_data['leave_type_code']:0;
  if ($last_code==0) {
    $last_code = 101;
  }else{
    $last_code = $last_code+1;
  }
  return $last_code;
}

  

}
