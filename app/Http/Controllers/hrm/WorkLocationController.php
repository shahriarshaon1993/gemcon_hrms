<?php

namespace App\Http\Controllers\hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\WorkLocation;
use App\Helper\ResponseUtil;
use Response;
use Cache;
use permission;
// use App\Model\UserRoleAccess;

class WorkLocationController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
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
  $paginate_data =WorkLocation::valid()->project()->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('work_location_name','LIKE','%'.$search_key.'%');
    });
    return $query;

  })->where('project_id',$project_id)->orderBy($sort,$order);

   $sortData=$paginate_data;
   
   $sortGetData=$sortData->get();
   $data['total_data']=count($sortGetData);
   $data['inactive_data']=count(collect($sortGetData)->whereIn('work_location_status',0)->toArray());
   $data['active_data']=count(collect($sortGetData)->where('work_location_status',1)->toArray());
   $data['paginate_data'] =$sortData->paginate($paginate_num);
   return response()->json($data);
}


public function store(Request $request)
{
  // echo "<pre>";print_r($this->findMaxCode()); die();
  $validate=[
    'work_location_name'=>'required|unique:work_locations,work_location_name,' . $request->id,
  ];

  $request->validate($validate);
  $data=$request->only(
    'work_location_name',
    'work_location_bangla',
    'work_location_status',
    'work_location_latitue',
    'work_location_longitude',
    'work_location_radius',
    'priority');

  if(!empty($request->id))
  {
    $update_data=WorkLocation::valid()->project()->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->branch_id; 
    $save_data=$update_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    $data['work_location_code'] = $this->findMaxCode();
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
    $data['work_location_status']=1; 
    $save_data=WorkLocation::create($data);
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
  $edit_data=WorkLocation::valid()->project()->findOrFail($id);
  return response($edit_data);

}

public function destroy($id)
{

  $delete_data=WorkLocation::valid()->project()->findOrFail($id);
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
    $last_entry_data=WorkLocation::latest()->first();
    $department_last_code = isset($last_entry_data['work_location_code'])?$last_entry_data['work_location_code']:0;
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
    $last_entry_data=WorkLocation::max('priority');
    $last_code = $last_entry_data;
    if ($last_code==0) {
      $last_code = 1;
    }else{
      $last_code = $last_code+1;
    }
    return $last_code;
  }

  public function workLocationSelect2()
  {
      $data=array();
      $datas=WorkLocation::valid()->project()->orderBy('work_location_name','asc')->get();
      array_push($data,['id'=>'','text'=>'Deselect']);
        foreach ($datas as $value) {
          array_push($data,['id'=>$value['id'],'text'=>$value['work_location_name'],]);
      }
      $result = $data;
      return Response::json(ResponseUtil::makeResponse($message=NULL, $result));
  }

}
