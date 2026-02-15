<?php

namespace App\Http\Controllers\hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\FiscalYear;
use App\Model\Employee;
use Cache;
use permission;
// use App\Model\UserRoleAccess;

class FiscalYearController extends Controller
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
  $data['paginate_data'] =FiscalYear::valid()->project()->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('fy_start_date','LIKE','%'.$search_key.'%');
    });
    return $query;

  })->where('project_id',$project_id) ->orderBy($sort,$order)->paginate($paginate_num);

  return response()->json($data);
}


public function store(Request $request)
{
  // echo "<pre>";print_r($this->findMaxCode()); die();
  $validate=[
    'fy_start_date'=>'required',
    'fy_end_date'=>'required'
  ];

  $request->validate($validate);
  $data=$request->only('fy_start_date','fy_end_date','fy_is_closed');

  if(!empty($request->id))
  {
    $update_data=FiscalYear::valid()->project()->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->branch_id; 
    $save_data=$update_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    $data['fixcal_year_code'] = $this->findMaxCode();
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
    $save_data=FiscalYear::create($data);
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
  $edit_data=FiscalYear::valid()->project()->findOrFail($id);
  return response($edit_data);

}

public function destroy($id)
{

  $delete_data=FiscalYear::valid()->project()->findOrFail($id);
  if($delete_data->delete())
  {
    $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
  }
  return response($message);

}

  public function create(){
      $data['employee_data']=array();
      $employee_data=Employee::valid()->project()->get();
      foreach ($employee_data as $value) {
        array_push($data['employee_data'],['id'=>$value['id'],'text'=>$value['employee_fullname']]);
      }
      return response($data);
  }

  public function findMaxCode(){
    $last_entry_data=FiscalYear::latest()->first();
    $department_last_code = isset($last_entry_data['fixcal_year_code'])?$last_entry_data['fixcal_year_code']:0;
    if ($department_last_code==0) {
      $department_last_code = 101;
    }else{
      $department_last_code = $department_last_code+1;
    }
    return $department_last_code;
  }


}
