<?php
namespace App\Http\Controllers\payroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\payroll\SimInventory;
use Cache;
use DB;
use permission;
// use App\Model\UserRoleAccess;

class SimInventoryController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','SimInventory')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
  $paginate_data =SimInventory::valid()->project()
  // ->leftJoin('sim_assignings',  'sim_assignings.sim_inventory_id', '=', 'sim_inventory.id')
  ->leftJoin('sim_assignings', function($join)
                         {
                             $join->on('sim_assignings.sim_inventory_id', '=', 'sim_inventory.id');
                             $join->on('sim_assignings.sim_assign_status','=',DB::raw(1));
                         })
  ->leftJoin('employees',  'employees.id', '=', 'sim_assignings.sim_assign_to')
  ->select('sim_inventory.*','sim_assignings.sim_ceiling_limit','employees.employee_fullname','employees.employee_id_no')
  ->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('sim_number','LIKE','%'.$search_key.'%');
    });
    return $query;

  })->orderBy($sort,$order);
  // ->paginate($paginate_num);
  $sortData=$paginate_data;
  $sortGetData=$sortData->get();
  $data['total_data']=count($sortGetData);
  $data['inactive_data']=count(collect($sortGetData)->whereIn('sim_status',"!=",1)->toArray());
  $data['active_data']=count(collect($sortGetData)->where('sim_status',1)->toArray());
  $data['assign_no']=count(collect($sortGetData)->where('employee_id_no','!=',null)->toArray());
  $data['not_assign_bo']=count(collect($sortGetData)->where('employee_id_no',null)->toArray());
  $data['total_ceiling']=collect($sortGetData)->where('sim_status',1)->sum('sim_ceiling_limit');
  $data['paginate_data'] =$sortData->paginate($paginate_num);
  return response()->json($data);
}


public function store(Request $request)
{
  // return response($request);
  $validate=[
    'sim_number'=>'required',
    'operator_name'=>'required'
  ];

  $request->validate($validate);
  $data=$request->only('sim_number','operator_name','sim_status');

  if(!empty($request->id))
  {
    $update_data=SimInventory::valid()->project()->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->id; 
    $save_data=$update_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    // $data['loan_type_code'] = $this->findMaxCode();
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
    $data['sim_status']=1; 
    $save_data=SimInventory::create($data);
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
  $edit_data=SimInventory::valid()->project()->findOrFail($id);
  return response($edit_data);

}

public function destroy($id)
{

  $delete_data=SimInventory::valid()->project()->findOrFail($id);
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
    $last_entry_data=SimInventory::max('loan_type_code');
    $department_last_code = isset($last_entry_data)?$last_entry_data:0;
    if ($department_last_code==0) {
      $department_last_code = 101;
    }else{
      $department_last_code = $department_last_code+1;
    }
    return $department_last_code;
  }

  public function create(){
    // $data['priority'] = $this->findPriority();
    // return response($data);
  }

  public function findPriority(){
    $last_entry_data=SimInventory::max('priority');
    $last_code = $last_entry_data;
    if ($last_code==0) {
      $last_code = 1;
    }else{
      $last_code = $last_code+1;
    }
    return $last_code;
  }


}
