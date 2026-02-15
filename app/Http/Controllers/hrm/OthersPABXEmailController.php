<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Model\OthersPABXEmail;
use App\Model\Employee;
use Cache;
class OthersPABXEmailController extends Controller
{
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
      $employee_list = new Employee();
      $employee_ids=$employee_list->Employee_id();
      $cache=Cache::get('permission');
      $permission=collect($cache)->where('menu_uid','=','OthersPABXEmail')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
      $paginate_data = OthersPABXEmail::valid()->project()->when($search_key, function($query, $search_key){
        $query->where(function($query2)use($search_key){
          $query2->where('sbu_or_others','LIKE','%'.$search_key.'%');
          $query2->orWhere('sbu_others_name','LIKE','%'.$search_key.'%');
          $query2->orWhere('department_or_othes','LIKE','%'.$search_key.'%');
          $query2->orWhere('department_others_name','LIKE','%'.$search_key.'%');
          $query2->orWhere('employee_or_others','LIKE','%'.$search_key.'%');
          $query2->orWhere('pabx_or_email','LIKE','%'.$search_key.'%');
        });
        return $query;
      })->where('ope_type',1)->where('project_id',$project_id)->orderBy($sort,$order);

      $paginate_data1 = OthersPABXEmail::valid()->project()->when($search_key, function($query, $search_key){
        $query->where(function($query2)use($search_key){
          $query2->where('sbu_or_others','LIKE','%'.$search_key.'%');
          $query2->orWhere('sbu_others_name','LIKE','%'.$search_key.'%');
          $query2->orWhere('department_or_othes','LIKE','%'.$search_key.'%');
          $query2->orWhere('department_others_name','LIKE','%'.$search_key.'%');
          $query2->orWhere('employee_or_others','LIKE','%'.$search_key.'%');
          $query2->orWhere('pabx_or_email','LIKE','%'.$search_key.'%');
        });
        return $query;
      })->where('ope_type',2)->where('project_id',$project_id)->orderBy($sort,$order);
      $sortData=$paginate_data;
      $sortData1 = $paginate_data1;
      $sortGetData=$sortData->get();
      $sortGetData1=$sortData1->get();
      $data['total_data']=count($sortGetData);
      $data['active_data']=count(collect($sortGetData)->where('ope_type',1)->where('ope_status',1)->toArray());
      $data['inactive_data']=count(collect($sortGetData)->where('ope_type',1)->whereIn('ope_status',2)->toArray());

      $data['total_data1']=count($sortGetData1);
      $data['active_data1']=count(collect($sortGetData1)->where('ope_type',2)->where('ope_status',1)->toArray());
      $data['inactive_data1']=count(collect($sortGetData1)->where('ope_type',2)->whereIn('ope_status',2)->toArray());
      
      $data['paginate_data'] =$sortData->paginate($paginate_num);
      $data['paginate_data1'] =$sortData1->paginate($paginate_num);
            // return response()->json($data['paginate_data1']);
      return response()->json($data);
    }

    public function store(Request $request)
    {
      // return response()->json($request);
      $validate=[
        'sbu_or_others'=>'required',
        'department_or_othes'=>'required',
        'employee_or_others'=>'required',
        'pabx_or_email'=>'required', 
        'ope_type'=>'required'
      ];
      $request->validate($validate);
      $data=$request->only('sbu_or_others','sbu_others_name','department_or_othes','department_others_name','employee_or_others','pabx_or_email','ope_type','ope_status');
      if(!empty($request->id))
      {
        $update_data=OthersPABXEmail::valid()->project()->findOrFail($request->id);
        $data['updated_by']=Auth::guard('user')->user()->branch_id; 
        $save_data=$update_data->update($data);
        $message=['status' => 1, 'message' => 'Your data is successfully updated'];
      }
      else {
        $data['project_id']=Auth::guard('user')->user()->project_id;
        $data['branch_id']=Auth::guard('user')->user()->branch_id; 
        $data['created_by']=Auth::guard('user')->user()->id; 
        $data['ope_status']=1; 
        $save_data=OthersPABXEmail::create($data);
        $message=['status' => 1, 'message' => 'Your data is successfully saved'];
      }
      if(!$save_data){
        $message=['status' => 0, 'message' => 'Ops! Something went worng.'];
      }
      return response($message);
    }

    public function edit($id)
    {
      $edit_data=OthersPABXEmail::valid()->project()->findOrFail($id);
      // $data['otehrs_sbu_list'] = array();
      $data['otehrs_department_list'] = array();
      $otehrs_sbu_lists=array(
        '1'=>'Corporate Office',
        '2'=>'Khulna Office',
        '3'=>'Panchagarh Office'
      );
      $otehrs_sbu_list=array();
      foreach ($otehrs_sbu_lists as $key => $value) {
        array_push($otehrs_sbu_list,['id'=>$key,'text'=>$value]);
      }
      $otehrs_department_lists=array(
        '1'=>'1st Floor',
        '2'=>'2nd Floor',
        '3'=>'3rd Floor',
        '4'=>'4th Floor',
        '5'=>'5th Floor',
        '6'=>'6th Floor',
        '7'=>'Others'
      );
      $otehrs_department_list=array();
      foreach ($otehrs_department_lists as $key => $value) {
        array_push($otehrs_department_list,['id'=>$key,'text'=>$value]);
      }
      if(!$edit_data->sbu_or_others){
        $edit_data->others_sbu_value = ['id'=>'','text'=>'']; 
      }else{
        $edit_data->others_sbu_value = ['id'=>$edit_data->sbu_or_others,'text'=>$edit_data->sbu_others_name];
      }
      if(!$edit_data->department_or_othes){
        $edit_data->others_department_value = ['id'=>'','text'=>'']; 
      }else{
        $edit_data->others_department_value = ['id'=>$edit_data->department_or_othes,'text'=>$edit_data->department_others_name];
      }
      $edit_data->otehrs_sbu_list =  $otehrs_sbu_list;
      $edit_data->otehrs_department_list =  $otehrs_department_list;
      return response($edit_data);

    }

    public function destroy($id)
    {

      $delete_data=OthersPABXEmail::valid()->project()->findOrFail($id);
      if($delete_data->delete())
      {
        $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
      }
      return response($message);

    }

    public function create(){
      $data['priority'] = $this->findPriority();
      $data['otehrs_sbu_list'] = array();
      $data['otehrs_department_list'] = array();
      $otehrs_sbu_lists=array(
        '1'=>'Corporate Office',
        '2'=>'Khulna Office',
        '3'=>'Panchagarh Office'
      );
      foreach ($otehrs_sbu_lists as $key => $value) {
        $data['otehrs_sbu_list'][]=array(
          'id'=>$key,
          'text'=>$value
        );
      }
      $otehrs_department_lists=array(
        '1'=>'1st Floor',
        '2'=>'2nd Floor',
        '3'=>'3rd Floor',
        '4'=>'4th Floor',
        '5'=>'5th Floor',
        '6'=>'6th Floor',
        '7'=>'Others'
      );
      foreach ($otehrs_department_lists as $key => $value) {
        array_push($data['otehrs_department_list'],['id'=>$key,'text'=>$value]);
      }
      return response($data);
    }

    public function findPriority(){
      $last_entry_data=OthersPABXEmail::max('priority');
      $last_code = $last_entry_data;
      if ($last_code==0) {
        $last_code = 1;
      }else{
        $last_code = $last_code+1;
      }
      return $last_code;
    }

}
