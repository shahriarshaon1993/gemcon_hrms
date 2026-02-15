<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\OfficeTimeSetup;
use Cache;
use permission;
// use App\Model\UserRoleAccess;

class ShiftTimeController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','ShiftTime')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
  $paginate_data =OfficeTimeSetup::valid()->project()->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('title','LIKE','%'.$search_key.'%');
    });
    return $query;

  })->where('project_id',$project_id) ->where('type',2)  ->orderBy($sort,$order);
  // ->paginate($paginate_num);

  // return response()->json($paginate_data);
  $sortData=$paginate_data;
  $sortGetData=$sortData->get();
  $data['total_data']=count($sortGetData);
  $data['inactive_data']=count(collect($sortGetData)->whereIn('office_time_status',2)->toArray());
  $data['active_data']=count(collect($sortGetData)->where('office_time_status',1)->toArray());
   $data['paginate_data'] =$sortData->paginate($paginate_num);

  // return response()->json($data);
  return response()->json($data);
}


public function store(Request $request)
{
  // echo "<pre>";print_r($this->findDepartmentMaxCode()); die();
  // return response($request['office_start_time']['HH']);

  $validate=[
    'office_start_time'=>'required'
  ];

  $request->validate($validate);
  $data=$request->only('title','office_start_time','office_end_time','office_time_note','office_time_status','lateConsiderTime','office_type');

  if(!empty($request->id))
  {
    $update_data=OfficeTimeSetup::valid()->project()->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->branch_id; 
    $save_data=$update_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    // $data['department_code'] = $this->findDepartmentMaxCode();
    if (!empty($request['office_start_time'])) {
      $data['office_start_time']=$request['office_start_time']['HH'].':'.$request['office_start_time']['mm'].':'.'00';
    }
    if (!empty($request['office_end_time'])) {
      $data['office_end_time']=$request['office_end_time']['HH'].':'.$request['office_end_time']['mm'].':'.'00';
    }
    if ($request['lateConsiderTime']) {
      $data['lateConsiderTime']=$request['lateConsiderTime']['HH'].':'.$request['lateConsiderTime']['mm'].':'.'00';
    }
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
    $data['type']=2; 
    $data['office_time_status']=1; 
    $save_data=OfficeTimeSetup::create($data);
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
  $edit_data=OfficeTimeSetup::valid()->project()->findOrFail($id);
  return response($edit_data);

}

public function destroy($id)
{

  $delete_data=OfficeTimeSetup::valid()->project()->findOrFail($id);
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

  // public function findDepartmentMaxCode(){
  //   $last_entry_data=OfficeTimeSetup::latest()->first();
  //   $department_last_code = $last_entry_data['department_code'];
  //   if ($department_last_code==0) {
  //     $department_last_code = 101;
  //   }else{
  //     $department_last_code = $department_last_code+1;
  //   }
  //   return $department_last_code;
  // }


}
