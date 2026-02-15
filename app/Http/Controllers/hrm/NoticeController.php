<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\NoticeModel;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\Section;
use App\Model\SubSection;
use App\Model\EmployeeGroup;
use App\Model\Department;
use App\Model\Designation;
use App\Model\JobGrade;
use App\Model\SubUnit;
use App\Model\UnitModel;
use App\Model\WorkLocation;
use App\Model\NoticePermission;
use Cache;
use permission;
use DB;
// use App\Model\UserRoleAccess;

class NoticeController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','Notice')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
  $paginate_data=NoticeModel::valid()->project()
  // ->join('employees', 'departments.id', '=', 'employees.employee_department')
  ->select(
    'notices.*'
  )
  ->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('notices.notice_title','LIKE','%'.$search_key.'%');
    });
    return $query;
  })->where('notices.project_id',$project_id)->orderBy($sort,$order);
  // ->paginate($paginate_num);
  $sortData=$paginate_data;
   $sortGetData=$sortData->get();
   $data['total_data']=count($sortGetData);
   $data['inactive_data']=count(collect($sortGetData)->whereIn('notice_status',2)->toArray());
   $data['active_data']=count(collect($sortGetData)->where('notice_status',1)->toArray());
   $data['paginate_data'] =$sortData->paginate($paginate_num);
   return response()->json($data);
}


public function store(Request $request)
{
  
  $validate=[
    'notice_title'=>'required'
  ];

  $request->validate($validate);
  $data=$request->only('notice_title','notice_sdate','notice_edate','notice_stime','notice_etime','notice_to','sbu_id','department_id','unit_id','subunit_id','section_id','subsection_id','employee_id','notice_details','notice_status');

   $permissionInfo=collect($request->approval_infos)->where('permission_id','!=','')->toArray();

  if(!empty($request->id))
  {
    $update_data=NoticeModel::valid()->project()->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->id; 
    $data['updated_at']=date('Y-m-d h:m:s'); 
    DB::table('notice_permissions')->where('notice_id', '=', $request->id)->delete();
    if(!empty($permissionInfo)){
      $save_data=$update_data->update($data);
      $permissionInfodata=[];
      foreach ($permissionInfo as $key => $value) {
        $permissionInfodata[]=[
          'notice_id'=>$request->id, 
          'permission_id'=>$value['permission_id'],
          'permission_type_name'=>$value['permission_type_name'], 
          'permission_type'=>$value['permission_type'], 
          'permission_id_name'=>$value['permission_id_name'],
          'notice_sdate'=>$request['notice_sdate'],
          'notice_edate'=>$request['notice_edate'],
          'project_id'=>Auth::guard('user')->user()->project_id,
          'branch_id'=>Auth::guard('user')->user()->branch_id,
          'created_by'=>Auth::guard('user')->user()->id,
        ];
      }
      $saveData=NoticePermission::insert($permissionInfodata);

    }else{
       $save_data=$update_data->update($data);
    }

   
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {

    $data['notice_stime']=$request['notice_stime']['HH'].':'.$request['notice_stime']['mm'].':'.'00';
    $data['notice_etime']=$request['notice_etime']['HH'].':'.$request['notice_etime']['mm'].':'.'00';
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id;  
// return response($permissionInfo);
    if(!empty($permissionInfo)){
      $save_data=NoticeModel::create($data);
      // NoticePermission
      $permissionInfodata=[];
      foreach ($permissionInfo as $key => $value) {
        $permissionInfodata[]=[
                      'notice_id'=>$save_data->id, 
                      'permission_id'=>$value['permission_id'],
                      'permission_type_name'=>$value['permission_type_name'], 
                      'permission_type'=>$value['permission_type'], 
                      'permission_id_name'=>$value['permission_id_name'],
                      'notice_sdate'=>$request['notice_sdate'],
                      'notice_edate'=>$request['notice_edate'],
                      'project_id'=>Auth::guard('user')->user()->project_id,
                      'branch_id'=>Auth::guard('user')->user()->branch_id,
                      'created_by'=>Auth::guard('user')->user()->id,
                    ];
      }
      $saveData=NoticePermission::insert($permissionInfodata);
    }else{
       $save_data=NoticeModel::create($data);
    }
    
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
  $data=NoticeModel::valid()->project()->findOrFail($id);
  $companysbu_data_list=CompanySbu::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $section_data_list=Section::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $sub_section_data_list=SubSection::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $employee_group_data_list=EmployeeGroup::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $department_list=Department::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $designation_data_list=Designation::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $jobgrade_data_list=JobGrade::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $employee_data_list=Employee::valid()->project()->where('employee_status',1)->get()->keyBy('id')->all();
  $employee_reporting=Employee::valid()->project()->where('employee_status',1)->get()->keyBy('employee_id_no')->all();
  $sub_unit_data_list=SubUnit::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $unit_data_list=UnitModel::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $work_location_data_list=WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  if(!$data->sbu_id){
    $data->sbu_name_value = ['id'=>'','text'=>'']; 
  }else{
    $data->sbu_name_value = ['id'=>$data->sbu_id,'text'=>$companysbu_data_list[$data->sbu_id]->sbu_name];
  }
  if(!$data->section_id){
    $data->section_value = ['id'=>'','text'=>'']; 
  }else{
    $data->section_value = ['id'=>$data->section_id,'text'=>$section_data_list[$data->section_id]->section_name];
  }
  if(!$data->subsection_id){
    $data->sub_section_value = ['id'=>'','text'=>'']; 
  }else{
    $data->sub_section_value = ['id'=>$data->subsection_id,'text'=>$sub_section_data_list[$data->subsection_id]->sub_section_name];
  }
  if(!$data->employee_id){
    $data->employee_name_value = ['id'=>'','text'=>'']; 
  }else{
    $data->employee_name_value = ['id'=>$data->employee_id,'text'=>$employee_data_list[$data->employee_id]->employee_fullname];
  }
  if(!$data->department_id){
    $data->department_name_value = ['id'=>'','text'=>'']; 
  }else{
    $data->department_name_value = ['id'=>$data->department_id,'text'=>$department_list[$data->department_id]->department_name];
  }
  
  if(!$data->subunit_id){
    $data->sub_unit_value = ['id'=>'','text'=>'']; 
  }else{
    $data->sub_unit_value = ['id'=>$data->subunit_id,'text'=>$sub_unit_data_list[$data->subunit_id]->sub_unit_name];
  }
  if(!$data->unit_id){
    $data->unit_value = ['id'=>'','text'=>'']; 
  }else{
    $data->unit_value = ['id'=>$data->unit_id,'text'=>$unit_data_list[$data->unit_id]->unit_name];
  }
 
  $company_sbu_data=array();
  $section_data=array();
  $sub_section_data=array();
  $employee_group_data=array();
  $department_data=array();
  $designation_data=array();
  $jobgrade_data=array();
  $employee_data=array();
  $employee_data_approval=array();
  $unit_data=array();
  $sub_unit_data=array();
  $work_location_data=array();
  foreach ($companysbu_data_list as $value) {
    array_push($company_sbu_data,['id'=>$value['id'],'text'=>$value['sbu_name']]);
  }
  foreach ($section_data_list as $value) {
    array_push($section_data,['id'=>$value['id'],'text'=>$value['section_name']]);
  }
  foreach ($sub_section_data_list as $value) {
    array_push($sub_section_data,['id'=>$value['id'],'text'=>$value['sub_section_name']]);
  }
  foreach ($employee_group_data_list as $value) {
    array_push($employee_group_data,['id'=>$value['id'],'text'=>$value['employee_group_name']]);
  }
  foreach ($department_list as $value) {
    array_push($department_data,['id'=>$value['id'],'text'=>$value['department_name']]);
  }
  foreach ($designation_data_list as $value) {
    array_push($designation_data,['id'=>$value['id'],'text'=>$value['designation_name']]);
  }
  foreach ($jobgrade_data_list as $value) {
    array_push($jobgrade_data,['id'=>$value['id'],'text'=>$value['jobgrade_name']]);
  }
  foreach ($employee_data_list as $value) {
    array_push($employee_data,['id'=>$value['id'],'text'=>$value['employee_id_no'].' - '.$value['employee_fullname']]);
  }
  foreach ($sub_unit_data_list as $value) {
    array_push($sub_unit_data,['id'=>$value['id'],'text'=>$value['sub_unit_name']]);
  }
  foreach ($unit_data_list as $value) {
    array_push($unit_data,['id'=>$value['id'],'text'=>$value['unit_name']]);
  }
  foreach ($work_location_data_list as $value) {
    array_push($work_location_data,['id'=>$value['id'],'text'=>$value['department_name']]);
  }

  $approvalInfos=NoticePermission::valid()->project()->where('notice_id',$id)->get();
// return response($approvalInfos);
  if(!empty($approvalInfos)){
    $data->approval_infos=$approvalInfos;
  }else{
     $date->approval_infos=['0' =>['id'=>0,'permission_type'=>'','permission_id'=>'']];
  }

  $data->company_sbu_data =  $company_sbu_data;
  $data->section_data =  $section_data;
  $data->sub_section_data =  $sub_section_data;
  $data->employee_group_data =  $employee_group_data;
  $data->department_data =  $department_data;
  $data->designation_data =  $designation_data;
  $data->jobgrade_data =  $jobgrade_data;
  $data->employee_data =  $employee_data;
  $data->sub_unit_data =  $sub_unit_data;
  $data->unit_data =  $unit_data;
  $data->work_location_data =  $work_location_data;  
  return response($data);

}

public function destroy($id)
{

  $delete_data=NoticeModel::valid()->project()->findOrFail($id);
  if($delete_data->delete())
  {
    $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
  }
  return response($message);

}

  public function create(){
      // $data['employee_data']=array();
      // $employee_data=Employee::valid()->project()->get();
      
      // foreach ($employee_data as $value) {
      //   array_push($data['employee_data'],['id'=>$value['id'],'text'=>$value['employee_fullname']]);
      // }


      $data['company_sbu_data']=array();
      $data['section_data']=array();
      $data['sub_section_data']=array();
      $data['sub_unit_data']=array();
      $data['unit_data']=array();
      $data['work_location_data']=array();
      $data['department_data']=array();
      $data['designation_data']=array();
      $data['jobgrade_data']=array();
      $data['employee_data']=array();
      $data['employee_data_approval']=array();
      $data['employee_group_data']=array();
      $company_sbu_data=CompanySbu::valid()->project()->orderBy('priority', 'ASC')->get();
      $section_data=Section::valid()->project()->orderBy('priority', 'ASC')->get();
      $sub_section_data=SubSection::valid()->project()->orderBy('priority', 'ASC')->get();
      $department_data=Department::valid()->project()->orderBy('priority', 'ASC')->get();
      $designation_data=Designation::valid()->project()->orderBy('priority', 'ASC')->get();
      $jobgrade_data=JobGrade::valid()->project()->orderBy('priority', 'ASC')->get();
      $employee_data_approval=Employee::valid()->project()->get();
      // return response($employee_data_approval);
      $employee_data=Employee::valid()->project()->where('employee_status',1)->get()->keyBy('id')->all();
      $unit_data=UnitModel::valid()->project()->orderBy('priority', 'ASC')->get();
      $sub_unit_data=SubUnit::valid()->project()->orderBy('priority', 'ASC')->get();
      $work_location_data=WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get();
      $employee_group_data=EmployeeGroup::valid()->project()->orderBy('priority', 'ASC')->get();
      foreach ($company_sbu_data as $value) {
        array_push($data['company_sbu_data'],['id'=>$value['id'],'text'=>$value['sbu_name']]);
      } 
      foreach ($section_data as $value) {
        array_push($data['section_data'],['id'=>$value['id'],'text'=>$value['section_name']]);
      } 
      foreach ($sub_section_data as $value) {
        array_push($data['sub_section_data'],['id'=>$value['id'],'text'=>$value['sub_section_name']]);
      }
      foreach ($employee_group_data as $value) {
        array_push($data['employee_group_data'],['id'=>$value['id'],'text'=>$value['employee_group_name']]);
      }
      foreach ($department_data as $value) {
        array_push($data['department_data'],['id'=>$value['id'],'text'=>$value['department_name'],]);
      }
      foreach ($designation_data as $value) {
        array_push($data['designation_data'],['id'=>$value['id'],'text'=>$value['designation_name']]);
      }
      foreach ($jobgrade_data as $value) {
        array_push($data['jobgrade_data'],['id'=>$value['id'],'text'=>$value['jobgrade_name']]);
      }
      foreach ($employee_data as $value) {

        array_push($data['employee_data'],['id'=>$value['id'],'text'=>$value['employee_id_no'].' - '.$value['employee_fullname']]);
      }

      foreach ($sub_unit_data as $value) {
        array_push($data['sub_unit_data'],['id'=>$value['id'],'text'=>$value['sub_unit_name']]);
      }

      foreach ($unit_data as $value) {
         // return response($value);
        array_push($data['unit_data'],['id'=>$value['id'],'text'=>$value['unit_name']]);
      }

      foreach ($work_location_data as $value) {
        array_push($data['work_location_data'],['id'=>$value['id'],'text'=>$value['work_location_name']]);
      }

      $data['approval_infos']=['0' =>['id'=>0,'permission_type'=>'','permission_id'=>'']];

      $data['notice_sdate']=date('Y-m-d');
      $data['notice_edate']=date('Y-m-d');
      
      return response($data);
  }

  // public function findDepartmentMaxCode(){
  //   $last_entry_data=NoticeModel::latest()->first();
  //   $department_last_code = isset($last_entry_data['department_code'])?$last_entry_data['department_code']:0;
  //   if ($department_last_code==0) {
  //     $department_last_code = 101;
  //   }else{
  //     $department_last_code = $department_last_code+1;
  //   }
  //   return $department_last_code;
  // }


}
