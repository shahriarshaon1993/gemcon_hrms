<?php

namespace App\Http\Controllers\hrm;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Model\UsersPersonModel;
use App\Model\Employee;
use App\Model\CompanySbu;
use permission;
use Session;
use Cache;
use Auth;
// use App\Model\UserRoleAccess;

class UserSettingController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
   $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','UserSetting')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
  $data['paginate_data'] =UsersPersonModel::valid()->project()
    ->leftJoin('employees', 'employees.id', '=', 'users_person.employee_id')
    ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
    ->leftJoin('user_roel', 'user_roel.id', '=', 'users_person.role_id')
    ->select(
      'users_person.*',
      'employees.employee_fullname',
      'company_sbus.sbu_name',
      'user_roel.role_name'
    )
    ->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('users_person.name','LIKE','%'.$search_key.'%');
      $query2->orWhere('users_person.employee_card_no','LIKE','%'.$search_key.'%');
      $query2->orWhere('users_person.employee_fullname','LIKE','%'.$search_key.'%');
      $query2->orWhere('users_person.role_id','LIKE','%'.$search_key.'%');
      $query2->orWhere('users_person.user_type','LIKE','%'.$search_key.'%');
      $query2->orWhere('users_person.company_sbu','LIKE','%'.$search_key.'%');
    });
    return $query;

  })->where('users_person.project_id',$project_id) ->orderBy($sort,$order)->paginate($paginate_num);

  return response()->json($data);
}


public function store(Request $request)
{
  $validate=[
    'name'=>'required',
    'email'=>'required',
    'password'=>'required',
    'company_id'=>'required',
    'role_id'=>'required',
    'employee_id'=>'required',
    'status'=>'required',
  ];
  $request->validate($validate);
  $data=$request->only(
  	'name',
  	'email',
  	'password',
  	'company_id',
  	'role_id',
  	'employee_id',
  	'status'
  );
  $data['username']= $data['email'];
  $data['password']= Hash::make($data['password']);
  if(!empty($request->id))
  {
  // return response($request->id);
    $update_data=UsersPersonModel::valid()->project()->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->id; 
    $save_data=$update_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    // $data['department_code'] = $this->findMaxCode();
    
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
    $save_data=UsersPersonModel::create($data);
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
  $data=UsersPersonModel::valid()->project()
        // ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        ->findOrFail($id);
  $employee_data_list=Employee::valid()->project()->get()->keyBy('id')->all();
  $companysbu_data_list=CompanySbu::valid()->project()->get()->keyBy('id')->all();
   // return response($data);
   if(!$data->company_id){
     $data->sbu_name_value = ['id'=>'','text'=>'']; 
   }else{
     $data->sbu_name_value = ['id'=>$data->company_id,'text'=>$companysbu_data_list[$data->company_id]->sbu_name];
   }

  if(!$data->employee_id){
    $data->employee_name_value = ['id'=>'','text'=>'']; 
  }else{
    $data->employee_name_value = ['id'=>$data->employee_id,'text'=>$employee_data_list[$data->employee_id]->employee_fullname];
  }


  $company_sbu_data=array();
  $employee_data=array();
  foreach ($companysbu_data_list as $value) {
    array_push($company_sbu_data,['id'=>$value['id'],'text'=>$value['sbu_name']]);
  }
  foreach ($employee_data_list as $value) {
    array_push($employee_data,['id'=>$value['id'],'text'=>$value['employee_fullname']]);
  }
  $data->company_sbu_data =  $company_sbu_data;
  $data->employee_data =  $employee_data;
  return response($data);

}

public function destroy($id)
{

  $delete_data=UsersPersonModel::valid()->project()->findOrFail($id);
  if($delete_data->delete())
  {
    $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
  }
  return response($message);

}

  public function create(){
        // return response($department_data);
        $data['company_sbu_data']=array();
        $data['employee_data']=array();
        $company_sbu_data=CompanySbu::valid()->project()->get();
        $employee_data=Employee::valid()->project()->get();
        foreach ($company_sbu_data as $value) {
          array_push($data['company_sbu_data'],['id'=>$value['id'],'text'=>$value['sbu_name']]);
        } 
        foreach ($employee_data as $value) {
          array_push($data['employee_data'],['id'=>$value['id'],'text'=>$value['employee_fullname']]);
        }
        return response($data);
    }

  // public function findMaxCode(){
  //   $last_entry_data=UsersPersonModel::latest()->first();
  //   $department_last_code = $last_entry_data['department_code'];
  //   if ($department_last_code==0) {
  //     $department_last_code = 101;
  //   }else{
  //     $department_last_code = $department_last_code+1;
  //   }
  //   return $department_last_code;
  // }


}
