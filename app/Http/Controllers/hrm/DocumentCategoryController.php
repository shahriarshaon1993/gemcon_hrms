<?php
namespace App\Http\Controllers\hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\DocumentCategory;
use App\Model\Employee;
use Cache;
use permission;
use DB;
// use App\Model\UserRoleAccess;

class DocumentCategoryController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','DocCategory')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
  $paginate_data =DocumentCategory::valid()->project()
  ->select(
    'document_categories.*'
  )
  ->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('document_categories.category_name','LIKE','%'.$search_key.'%');
      $query2->orWhere('document_categories.category_note','LIKE','%'.$search_key.'%');
    });
    return $query;

  })->where('document_categories.project_id',$project_id)->orderBy('priority','ASC')->orderBy($sort,$order);
  $sortData=$paginate_data;
  $sortGetData=$sortData->get();
  $data['total_data']=count($sortGetData);
  $data['active_data']=count(collect($sortGetData)->where('category_status',1)->toArray());
  $data['inactive_data']=count(collect($sortGetData)->whereIn('category_status',2)->toArray());
  $data['paginate_data'] =$sortData->paginate($paginate_num);

  return response()->json($data);
}


public function store(Request $request)
{
  // echo "<pre>";print_r($this->findDepartmentMaxCode()); die();
  $validate=[
    'category_name'=>'required'
  ];

  $request->validate($validate);
  $data=$request->only('category_name','category_note','category_status','priority');

  if(!empty($request->id))
  {
    $update_data=DocumentCategory::valid()->project()->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->branch_id; 
    $save_data=$update_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    // $data['category_note'] = $this->findDepartmentMaxCode();
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
     $data['category_status']=1; 
    $save_data=DocumentCategory::create($data);
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
  $edit_data=DocumentCategory::valid()->project()->findOrFail($id);
  // $employee_data_list=Employee::valid()->project()->get()->keyBy('id')->all();
  // if(!$edit_data->department_head){
  //   $edit_data->employee_name_value = ['id'=>'','text'=>'']; 
  // }else{
  //   $edit_data->employee_name_value = ['id'=>$edit_data->department_head,'text'=>$employee_data_list[$edit_data->department_head]->employee_fullname];
  // }
  // $employee_data=array();
  // foreach ($employee_data_list as $value) {
  //   array_push($employee_data,['id'=>$value['id'],'text'=>$value['employee_fullname']]);
  // }
  // $edit_data->employee_data =  $employee_data;
  return response($edit_data);

}

public function destroy($id)
{

  $delete_data=DocumentCategory::valid()->project()->findOrFail($id);
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

  public function findDepartmentMaxCode(){
    $last_entry_data=DocumentCategory::latest()->first();
    $department_last_code = isset($last_entry_data['category_note'])?$last_entry_data['category_note']:0;
    if ($department_last_code==0) {
      $department_last_code = 101;
    }else{
      $department_last_code = $department_last_code+1;
    }
    return $department_last_code;
  }


}

