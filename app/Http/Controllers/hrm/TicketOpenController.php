<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\TicketOpen;
use Cache;
use permission;
// use App\Model\UserRoleAccess;

class TicketOpenController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','TicketOpen')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
    $sort = 'id';
  } else {
    $order = $request->input('order');
    $sort = $request->input('sort');
  }

  $project_id=Auth::guard('user')->user()->project_id;
  $branch_id=Auth::guard('user')->user()->branch_id;
  $paginate_data =TicketOpen::valid()->project()->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('total_ticket','LIKE','%'.$search_key.'%');
    });
    return $query;

  })->where('project_id',$project_id)->orderBy($sort,$order);
  // ->orderBy($sort,$order);
  // ->paginate($paginate_num);
  $sortData=$paginate_data;
 

  $sortGetData=$sortData->get();
  $data['total_data']=count($sortGetData);
  $data['inactive_data']=count(collect($sortGetData)->whereIn('ticket_status',2)->toArray());
  $data['active_data']=count(collect($sortGetData)->where('ticket_status',1)->toArray());
   $data['paginate_data'] =$sortData->paginate($paginate_num);

  return response()->json($data);
}

public function create(){

}

public function store(Request $request)
{
  // echo "ok_now"; die();
  $validate=[
    'total_ticket'=>'required',
    'ticket_price_per'=>'required'
  ];

  $request->validate($validate);
  $data=$request->only('total_ticket','ticket_price_per','sell_start_date');
  if(!empty($request->id))
  {
    $update_data=TicketOpen::valid()->project()->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->branch_id; 
    $save_data=$update_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
    $data['ticket_status']=1; 
    $save_data=TicketOpen::create($data);
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
  $edit_data=TicketOpen::valid()->project()->findOrFail($id);
  return response($edit_data);

}

public function destroy($id)
{

  $delete_data=TicketOpen::valid()->project()->findOrFail($id);
  if($delete_data->delete())
  {
    $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
  }
  return response($message);

}



}
