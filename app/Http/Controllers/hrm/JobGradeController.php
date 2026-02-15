<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\JobGrade;
use Cache;
use permission;
// use App\Model\UserRoleAccess;

class JobGradeController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','JobGrade')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
  $paginate_data =JobGrade::valid()->project()->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('jobgrade_name','LIKE','%'.$search_key.'%');
    });
    return $query;

  })->where('project_id',$project_id)->orderBy($sort,$order);
  // ->orderBy($sort,$order);
  // ->paginate($paginate_num);
  $sortData=$paginate_data;
 

  $sortGetData=$sortData->get();
  $data['total_data']=count($sortGetData);
  $data['inactive_data']=count(collect($sortGetData)->whereIn('jobgrade_status',2)->toArray());
  $data['active_data']=count(collect($sortGetData)->where('jobgrade_status',1)->toArray());
   $data['paginate_data'] =$sortData->paginate($paginate_num);

  return response()->json($data);
}

public function create(){

}

public function store(Request $request)
{
  // echo "ok_now"; die();
  $validate=[
    'jobgrade_name'=>'required'
  ];

  $request->validate($validate);
  $data=$request->only('jobgrade_name','jobgrade_status','insurance_amount','yearly_premium_cost','priority');
  if(!empty($request->id))
  {
    $update_data=JobGrade::valid()->project()->orderBy('priority', 'ASC')->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->branch_id; 
    $save_data=$update_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    $data['jobgrade_code'] = $this->findMaxCode();
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
    $data['jobgrade_status']=1; 
    $save_data=JobGrade::create($data);
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
  $edit_data=JobGrade::valid()->project()->orderBy('priority', 'ASC')->findOrFail($id);
  return response($edit_data);

}

public function destroy($id)
{

  $delete_data=JobGrade::valid()->project()->orderBy('priority', 'ASC')->findOrFail($id);
  if($delete_data->delete())
  {
    $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
  }
  return response($message);

}

public function findMaxCode(){
  $last_entry_data=JobGrade::latest()->first();
  $last_code = $last_entry_data['jobgrade_code'];
  if ($last_code==0) {
    $last_code = 101;
  }else{
    $last_code = $last_code+1;
  }
  return $last_code;
}


}
