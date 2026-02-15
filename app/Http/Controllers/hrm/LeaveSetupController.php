<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\LeaveSetup;
use App\Model\LeaveType;
use Cache;
use permission;
// use App\Model\UserRoleAccess;

class LeaveSetupController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','LeaveSetup')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
  $paginate_data =LeaveSetup::valid()->project()
   ->leftJoin('leave_types', 'leave_types.id', '=', 'leave_setups.leave_type')
   ->select('leave_setups.*','leave_types.leave_type_name')
  ->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('leave_setups.leave_group','LIKE','%'.$search_key.'%');
    });
    return $query;

  })->where('leave_setups.project_id',$project_id) ->orderBy($sort,$order);
  // ->paginate($paginate_num);
  $sortData=$paginate_data;

  $sortGetData=$sortData->get();
  $data['total_data']=count($sortGetData);
  $data['inactive_data']=count(collect($sortGetData)->whereIn('leave_status',0)->toArray());
  $data['active_data']=count(collect($sortGetData)->where('leave_status',1)->toArray());
    $data['paginate_data'] =$sortData->paginate($paginate_num);
  return response()->json($data);
}


public function store(Request $request)
{
  // echo "<pre>";print_r($this->findDepartmentMaxCode()); die();
  $validate=[
    'leave_group'=>'required',
    'leave_type'=>'required|unique:leave_setups,leave_type,'.$request->id,
    'leave_day_no'=>'required'
  ];

  $request->validate($validate);
  $data=$request->only('leave_group','leave_type','leave_day_no','leave_note','leave_status');

  if(!empty($request->id))
  {
    $update_data=LeaveSetup::valid()->project()->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->branch_id; 
    $save_data=$update_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    // $data['department_code'] = $this->findDepartmentMaxCode();
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
    $data['leave_status']=1; 
    $save_data=LeaveSetup::create($data);
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
  $edit_data=LeaveSetup::valid()->project()->findOrFail($id);
    $leave_type_data_list=LeaveType::valid()->project()->get()->keyBy('id')->all();;

    if(!$edit_data->leave_type){
      $edit_data->leave_type_value = ['id'=>'','text'=>'']; 
    }else{
      $edit_data->leave_type_value = ['id'=>$edit_data->leave_type,'text'=>$leave_type_data_list[$edit_data->leave_type]->leave_type_name];
    }
    
  // return response($edit_data);
    $leave_type_data=array();
    foreach ($leave_type_data_list as $value) {
      array_push($leave_type_data,['id'=>$value['id'],'text'=>$value['leave_type_name']]);
    }
    $edit_data->leave_type_data =  $leave_type_data;
  return response($edit_data);

}

public function destroy($id)
{

  $delete_data=LeaveSetup::valid()->project()->findOrFail($id);
  if($delete_data->delete())
  {
    $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
  }
  return response($message);

}

 public function create(){
      $data['leave_type_data']=array();
      $leave_type_data=LeaveType::valid()->project()->get();
       // return response($attendance_machine_data);
      foreach ($leave_type_data as $value) {
        array_push($data['leave_type_data'],['id'=>$value['id'],'text'=>$value['leave_type_name']]);
      }
      return response($data);
  }

  

}
