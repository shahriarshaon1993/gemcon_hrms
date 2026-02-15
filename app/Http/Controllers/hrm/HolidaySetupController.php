<?php

namespace App\Http\Controllers\hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\HolidaySetup;
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
use App\Model\HolidayPermission;
use Cache;
use permission;
use DB;
// use App\Model\UserRoleAccess;

class HolidaySetupController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
   $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','HolidaySetup')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
    $order = 'DESC';
    $sort = 'priority';
  } else {
    $order = $request->input('order');
    $sort = $request->input('sort');
  }
  $project_id=Auth::guard('user')->user()->project_id;
  $branch_id=Auth::guard('user')->user()->branch_id;
  $paginate_data =HolidaySetup::valid()->project()->when($search_key, function($query, $search_key){
    $query->where(function($query2)use($search_key){
      $query2->where('holiday_event','LIKE','%'.$search_key.'%');
      $query2->orWhere('holiday_start_date','LIKE','%'.$search_key.'%');
      $query2->orWhere('holiday_end_date','LIKE','%'.$search_key.'%');
      $query2->orWhere('holiday_note','LIKE','%'.$search_key.'%');
    });
    return $query;

  })->where('project_id',$project_id)->orderBy($sort,$order);
  // ->paginate($paginate_num);

  $sortData=$paginate_data;
   
   $sortGetData=$sortData->get();
   $data['total_data']=count($sortGetData);
   $data['inactive_data']=count(collect($sortGetData)->whereIn('holiday_status',0)->toArray());
   $data['active_data']=count(collect($sortGetData)->where('holiday_status',1)->toArray());
   $data['paginate_data'] =$sortData->paginate($paginate_num);
   return response()->json($data);
}


public function store(Request $request)
{
  
  $validate=[
    'holiday_event'=>'required',
    'holiday_start_date'=>'required',
    'holiday_end_date'=>'required',
    'holiday_note'=>'required'
  ];
  $request->validate($validate);
  $data=$request->only('holiday_event','holiday_start_date','holiday_end_date','holiday_note','holiday_status','priority');
  // $permissionInfo=collect($request->userPermission)->where('permission_id','!=','')->toArray();
  // return response($request);
  $userPermission=collect($request->userPermission)->where('sbu_permission','!=','')->toArray();
  if(!empty($request->id))
  {
    
    $update_data=HolidaySetup::valid()->project()->findOrFail($request->id);
   
    $data['updated_by']=Auth::guard('user')->user()->branch_id;
    $save_data=$update_data->update($data);
    DB::table('holiday_permissions')->where('holiday_id', '=', $request->id)->delete();
    if(!empty($userPermission)){
     
      // if(!empty($userPermission)){
        $insert_array=[];
        foreach ($userPermission as $key => $value) {
            if(!empty($value['sbu_permission'])){
              $insert_array=[
              "holiday_id"=>$request->id,
              "employee_id"=>$value['employee_id_permission'] ?? $value['employee_id'] ?? '',
              "sbu_permission"=>$value['sbu_permission'] ?? "",
              "unit_permission"=>$value['unit_permission'] ?? "",
              "sub_unit_permission"=>$value['sub_unit_permission'] ?? "",
              "department_permission"=>$value['department_permission'] ?? "",
              "section_permission"=>$value['section_permission'] ?? " ",
              "sub_section_permission"=>$value['sub_section_permission'] ?? "",
              "work_location_permission"=>$value['work_location_permission'] ?? "",
              "project_id"=>Auth::guard('user')->user()->project_id,
              "branch_id"=>Auth::guard('user')->user()->branch_id,
              "created_by"=>Auth::guard('user')->user()->id,
              "created_by"=>date('Y-m-d H:i:s'),
            ];
             DB::table('holiday_permissions')->insert($insert_array);  
            } 
          }
         
      //  }  
    // }else{
      //  $save_data=$update_data->update($data);
    }
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
    return response($message);
  }
  else {
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
    $data['holiday_status']=1;
    $save_data=HolidaySetup::create($data);
    if(!empty($userPermission)){
      $insert_array=[];
      foreach ($userPermission as $key => $value) {
          $unit_permission='';
          $sub_unit_permission='';
          $department_permission='';
          $section_permission='';
          $sub_section_permission='';
          $work_location_permission='';
          $employee_id_permission='';
          $group_permission=Auth::guard('user')->user()->project_id;
          if(!empty($value['unit_permission'])){
            $unit_permission=$value['unit_permission'];
          }
          if(!empty($value['sub_unit_permission'])){
            $sub_unit_permission=$value['sub_unit_permission'];
          }
          if(!empty($value['department_permission'])){
            $department_permission=$value['department_permission'];
          }
          if(!empty($value['section_permission'])){
            $section_permission=$value['section_permission'];
          }
          if(!empty($value['sub_section_permission'])){
            $sub_section_permission=$value['sub_section_permission'];
          }
          if(!empty($value['work_location_permission'])){
            $work_location_permission=$value['work_location_permission'];
          }
          if(!empty($value['employee_id_permission'])){
            $employee_id_permission=$value['employee_id_permission'] ?? $value['employee_id'] ?? '';
          }

          if(!empty($value['sbu_permission'])){
            $insert_array[]=[
              "holiday_id"=>$save_data->id,
              "employee_id"=>$employee_id_permission,
              "sbu_permission"=>$value['sbu_permission'],
              "unit_permission"=>$unit_permission,
              "sub_unit_permission"=>$sub_unit_permission,
              "department_permission"=>$department_permission,
              "section_permission"=>$section_permission,
              "sub_section_permission"=>$sub_section_permission,
              "work_location_permission"=>$work_location_permission,
              "project_id"=>Auth::guard('user')->user()->project_id,
              "branch_id"=>Auth::guard('user')->user()->branch_id,
              "created_by"=>Auth::guard('user')->user()->id,
              "created_by"=>date('Y-m-d H:i:s'),
            ];
          }   
      }
      HolidayPermission::insert($insert_array);
    // }else{
      
    }
    $message=['status' => 1, 'message' => 'Your data is successfully saved'];
  }
  if(!$save_data)
  {
    $message=['status' => 0, 'message' => 'Ops! Something went worng.'];
  }
  return response($message);
}



// public function store(Request $request)
// {
//   $validate=[
//     'holiday_event'=>'required',
//     'holiday_start_date'=>'required',
//     'holiday_end_date'=>'required',
//     'holiday_note'=>'required'
//   ];

//   $request->validate($validate);
//   $data=$request->only('holiday_event','holiday_start_date','holiday_end_date','holiday_note','holiday_status','priority');

//   $permissionInfo=collect($request->approval_infos)->where('permission_id','!=','')->toArray();

//   if(!empty($request->id))
//   {
//     $update_data=HolidaySetup::valid()->project()->findOrFail($request->id);
//     $data['updated_by']=Auth::guard('user')->user()->branch_id;
//     DB::table('holiday_permissions')->where('holiday_id', '=', $request->id)->delete();
//     if(!empty($permissionInfo)){
//       $save_data=$update_data->update($data);
//       $permissionInfodata=[];
      
//           foreach ($permissionInfo as $key => $value) {
//             if($value['permission_id'] != 0){
//             $permissionInfodata[]=[
//               'holiday_id'=>$request->id, 
//               'permission_id'=>$value['permission_id'],
//               'permission_type_name'=>$value['permission_type_name'], 
//               'permission_type'=>$value['permission_type'], 
//               'permission_id_name'=>$value['permission_id_name'],
//               'holiday_sdate'=>$request['holiday_start_date'],
//               'holiday_edate'=>$request['holiday_end_date'],
//               'project_id'=>Auth::guard('user')->user()->project_id,
//               'branch_id'=>Auth::guard('user')->user()->branch_id,
//               'created_by'=>Auth::guard('user')->user()->id,
//             ];
//           }else{
//             if($value['permission_type'] == 1){
//               $allsbu=CompanySbu::valid()->project()->get();
//                 foreach ($allsbu as $key => $value1) {
//                   $permissionInfodata[]=[
//                     'holiday_id'=>$request->id, 
//                     'permission_id'=>$value1['id'],
//                     'permission_type_name'=>$value['permission_type_name'], 
//                     'permission_type'=>$value['permission_type'], 
//                     'permission_id_name'=>$value['permission_id_name'],
//                     'holiday_sdate'=>$request['holiday_start_date'],
//                     'holiday_edate'=>$request['holiday_end_date'],
//                     'project_id'=>Auth::guard('user')->user()->project_id,
//                     'branch_id'=>Auth::guard('user')->user()->branch_id,
//                     'created_by'=>Auth::guard('user')->user()->id,
//                   ];
//                 }
//               }
//             }
//           }
//       $saveData=HolidayPermission::insert($permissionInfodata);

//     }else{
//        $save_data=$update_data->update($data);
//     } 
//     // $save_data=$update_data->update($data);
//     $message=['status' => 1, 'message' => 'Your data is successfully updated'];
//   }
//   else {


    
//     // $Attendancefinds=DB::table('attendance')
//     //                   ->where('pdate','>=',date("Y-m-d", strtotime($request['holiday_start_date'])))
//     //                   ->where('pdate','<=',date("Y-m-d", strtotime($request['holiday_end_date'])))
//     //                   ->get();
//     // if(!empty($Attendancefinds)){
//     //   foreach ($Attendancefinds as $key => $value) {
//     //     $attendances =[
//     //       'pstatus'=>5,
//     //       'remarks'=>$request['holiday_event'],
//     //      ];
//     //     $findesId=DB::table('attendance')->where('id',$value->id)
//     //           ->update($attendances);
//     //   }
//     // }

//     // $data['department_code'] = $this->findDepartmentMaxCode();
//     $data['project_id']=Auth::guard('user')->user()->project_id;
//     $data['branch_id']=Auth::guard('user')->user()->branch_id; 
//     $data['created_by']=Auth::guard('user')->user()->id; 
//     $data['holiday_status']=1; 
//     // $save_data=HolidaySetup::create($data);
//     if(!empty($permissionInfo)){
//       $save_data=HolidaySetup::create($data);
//       $permissionInfodata=[];
//       foreach ($permissionInfo as $key => $value) {
//           if($value['permission_id'] != 0){
//             $permissionInfodata[]=[
//               'holiday_id'=>$save_data->id, 
//               'permission_id'=>$value['permission_id'],
//               'permission_type_name'=>$value['permission_type_name'], 
//               'permission_type'=>$value['permission_type'], 
//               'permission_id_name'=>$value['permission_id_name'],
//               'holiday_sdate'=>$request['holiday_start_date'],
//               'holiday_edate'=>$request['holiday_end_date'],
//               'project_id'=>Auth::guard('user')->user()->project_id,
//               'branch_id'=>Auth::guard('user')->user()->branch_id,
//               'created_by'=>Auth::guard('user')->user()->id,
//             ];
//           }else{
//             if($value['permission_type'] == 1){
//               $allsbu=CompanySbu::valid()->project()->get();
//                 foreach ($allsbu as $key => $value1) {
//                   $permissionInfodata[]=[
//                     'holiday_id'=>$save_data->id, 
//                     'permission_id'=>$value1['id'],
//                     'permission_type_name'=>$value['permission_type_name'], 
//                     'permission_type'=>$value['permission_type'], 
//                     'permission_id_name'=>$value['permission_id_name'],
//                     'holiday_sdate'=>$request['holiday_start_date'],
//                     'holiday_edate'=>$request['holiday_end_date'],
//                     'project_id'=>Auth::guard('user')->user()->project_id,
//                     'branch_id'=>Auth::guard('user')->user()->branch_id,
//                     'created_by'=>Auth::guard('user')->user()->id,
//                   ];
//                 }
//               }
//           }
//       }
//       $saveData=HolidayPermission::insert($permissionInfodata);
//     }else{
//        $save_data=HolidaySetup::create($data);
//     }
    
//     $message=['status' => 1, 'message' => 'Your data is successfully saved'];
//   }

//   if(!$save_data)

//   {
//     $message=['status' => 0, 'message' => 'Ops! Something went worng.'];

//   }
//   return response($message);

// }

public function edit($id)
{
  $data=HolidaySetup::valid()->project()->findOrFail($id);

  $companysbu_data_list=CompanySbu::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $section_data_list=Section::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $sub_section_data_list=SubSection::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $employee_group_data_list=EmployeeGroup::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $department_list=Department::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $designation_data_list=Designation::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $jobgrade_data_list=JobGrade::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $employee_data_list=Employee::valid()->project()->where('employee_status',1)->get()->keyBy('id')->all();
  // $employee_reporting=Employee::valid()->project()->where('employee_status',1)->get()->keyBy('employee_id_no')->all();
  $sub_unit_data_list=SubUnit::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $unit_data_list=UnitModel::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
  $worklocation_data_list=WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
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
  array_push($company_sbu_data, ['id' => '0', 'text' => 'All Select']);
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
  foreach ($worklocation_data_list as $value) {
    array_push($work_location_data,['id'=>$value['id'],'text'=>$value['work_location_name']]);
  }

  $approvalInfos=HolidayPermission::valid()->project()->where('holiday_id',$id)->get();
  if(!empty($approvalInfos)){
    foreach ($approvalInfos as $key => $value) {
      $sbu=collect($companysbu_data_list)->where('id',$value['sbu_permission'])->first();
      $section=collect($section_data_list)->where('id',$value['section_permission'])->first();
      $sub_section=collect($sub_section_data_list)->where('id',$value['sub_section_permission'])->first();
      $department=collect($department_list)->where('id',$value['department_permission'])->first();
      $unit=collect($unit_data_list)->where('id',$value['unit_permission'])->first();
      $sub_unit=collect($sub_unit_data_list)->where('id',$value['sub_unit_permission'])->first();
      $work=collect($worklocation_data_list)->where('id',$value['work_location_permission'])->first();
      $employee=collect($employee_data_list)->where('id',$value['employee_id'])->first();
      // return response()->json($employee);

      if(!empty($sbu)){
        $approvalInfos[$key]['sbu_name']=$sbu['sbu_name'];
      }else{
         $approvalInfos[$key]['sbu_name']='';
      }
      if(!empty($section)){
         $approvalInfos[$key]['section_name']=$section['section_name'];
      }else{
         $approvalInfos[$key]['section_name']='';
      }
      if(!empty($sub_section)){
        $approvalInfos[$key]['sub_section_name']=$sub_section['sub_section_name'];
      }else{
         $approvalInfos[$key]['sub_section_name']='';
      }
      if(!empty($department)){
        $approvalInfos[$key]['department_name']=$department['department_name'];
      }else{
         $approvalInfos[$key]['department_name']='';
      }
      if(!empty($unit)){
        $approvalInfos[$key]['unit_name']=$unit['unit_name'];
      }else{
        $approvalInfos[$key]['unit_name']='';
      }
      if(!empty($sub_unit)){
        $approvalInfos[$key]['sub_unit_name']=$sub_unit['sub_unit_name'];
      }else{
         $approvalInfos[$key]['sub_unit_name']='';
      }
      if(!empty($work)){
        $approvalInfos[$key]['work_location_name']=$work['work_location_name'];
      }else{
        $approvalInfos[$key]['work_location_name']='';
      }
      if(!empty($employee)){
        $approvalInfos[$key]['employee_fullname']= $employee['employee_id_no'].' - '.$employee['employee_fullname'];
      }else{
        $approvalInfos[$key]['employee_fullname']='';
      }
    }
    $data->userPermission=$approvalInfos;
  }else{
     $date->userPermission=['0' =>['id'=>0,'employee_id'=>'','group_permission'=>'','sbu_permission'=>'','unit_permission'=>'','sub_unit_permission'=>'','department_permission'=>'','section_permission'=>'','sub_section_permission'=>'','work_location_permission'=>'','employee_id_permission'=>'']];
  }
  // $data['userPermission']=['0' =>['id'=>0,'employee_id'=>'','group_permission'=>'','sbu_permission'=>'','unit_permission'=>'','sub_unit_permission'=>'','department_permission'=>'','section_permission'=>'','sub_section_permission'=>'','work_location_permission'=>'','employee_id_permission'=>'']];


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

  $delete_data=HolidaySetup::valid()->project()->findOrFail($id);
  if($delete_data->delete())
  {
    DB::table('holiday_permissions')->where('holiday_id',$id)->delete();
    $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
  }
  return response($message);

}

  public function create(){
    $data['priority'] = $this->findPriority();
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
    $employee_data=Employee::valid()->project()->where('employee_status',1)->get()->keyBy('id')->all();
    $unit_data=UnitModel::valid()->project()->orderBy('priority', 'ASC')->get();
    $sub_unit_data=SubUnit::valid()->project()->orderBy('priority', 'ASC')->get();
    $workLocation_data=WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get();
    $employee_group_data=EmployeeGroup::valid()->project()->orderBy('priority', 'ASC')->get();
    array_push($data['company_sbu_data'], ['id' => '0', 'text' => 'All Select']);
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
    foreach ($workLocation_data as $value) {
      array_push($data['work_location_data'],['id'=>$value['id'],'text'=>$value['work_location_name']]);
    }
    // $employee_list = new Employee();
    // $employee_ids = $employee_list->Employee_id();
    // $employee_id = $employee_ids['employee_id'];
    // $data['AllcompanySbuData']=$employee_list->report_filter_data()['Allcompany_sbu_data'];
    // $data['company_sbu_data']=$employee_list->report_filter_data()['company_sbu_data'];
    // $data['AllsectionData']=$employee_list->report_filter_data()['Allsection_data'];
    // $data['section_data'] = $employee_list->report_filter_data()['section_data'];
    // $data['AllsubSectionData']=$employee_list->report_filter_data()['Allsub_section_data'];
    // $data['sub_section_data'] = $employee_list->report_filter_data()['sub_section_data'];
    // $data['AllsubUnitData']= $employee_list->report_filter_data()['Allsub_unit_data'];
    // $data['sub_unit_data'] = $employee_list->report_filter_data()['sub_unit_data'];
    // $data['AllunitData']= $employee_list->report_filter_data()['Allunit_data'];
    // $data['unit_data'] = $employee_list->report_filter_data()['unit_data'];
    // $data['AllworkLocationData']= $employee_list->report_filter_data()['Allwork_location_data'];
    // $data['work_location_data'] = $employee_list->report_filter_data()['work_location_data'];
    // $data['AlldepartmentData']=$employee_list->report_filter_data()['Alldepartment_data'];
    // $data['department_data'] =$employee_list->report_filter_data()['department_data'];
    // $data['AllemployeeData']=$data['employee_data'] = $employee_list->report_filter_data()['employee_data'];

    $data['notice_sdate']=date('Y-m-d');
    $data['notice_edate']=date('Y-m-d');
    $data['userPermission']=['0' =>['id'=>0,'employee_id'=>'','group_permission'=>'','sbu_permission'=>'','unit_permission'=>'','sub_unit_permission'=>'','department_permission'=>'','section_permission'=>'','sub_section_permission'=>'','work_location_permission'=>'','employee_id_permission'=>'']];
    return response($data);
  }
  public function userPermissionGet($id){
    $employee_list = new Employee();
    $employee_ids=$employee_list->Employee_id();
    $employee_id=$employee_ids['employee_id'];
    $UserMultiLevel=UserMultiLevelPermission::valid()->project()->where('employee_id',$id)->get();

    if(!empty($UserMultiLevel[0]['id'])){
       $company_sbu_data=CompanySbu::valid()->project()->whereIn('id',$employee_ids['sub'])->get();
        $section_data=Section::valid()->project()->whereIn('id',$employee_ids['section'])->get();
        $sub_section_data=SubSection::valid()->project()->whereIn('id',$employee_ids['subsection'])->get();
        $department_data=Department::valid()->project()->whereIn('id',$employee_ids['department'])->get();
        $unit_data=UnitModel::valid()->project()->whereIn('id',$employee_ids['unit'])->get();
        $sub_unit_data=SubUnit::valid()->project()->whereIn('id',$employee_ids['subunit'])->get();
        $work_location_data=WorkLocation::valid()->project()->get();
        // ->whereIn('id',$employee_ids['work_location'])

        foreach ($UserMultiLevel as $key => $value) {
          $sbu=collect($company_sbu_data)->where('id',$value['sbu_permission'])->first();
          $section=collect($section_data)->where('id',$value['section_permission'])->first();
          $sub_section=collect($sub_section_data)->where('id',$value['sub_section_permission'])->first();
          $department=collect($department_data)->where('id',$value['department_permission'])->first();
          $unit=collect($unit_data)->where('id',$value['unit_permission'])->first();
          $sub_unit=collect($sub_unit_data)->where('id',$value['sub_unit_permission'])->first();
          $work=collect($work_location_data)->where('id',$value['work_location_permission'])->first();

          // return response()->json($sub_section);
          if(!empty($sbu)){
            $UserMultiLevel[$key]['sbu_name']=$sbu['sbu_name'];
          }else{
             $UserMultiLevel[$key]['sbu_name']='';
          }
          if(!empty($section)){
             $UserMultiLevel[$key]['section_name']=$section['section_name'];
          }else{
             $UserMultiLevel[$key]['section_name']='';
          }
          if(!empty($sub_section)){
            $UserMultiLevel[$key]['sub_section_name']=$sub_section['sub_section_name'];
          }else{
             $UserMultiLevel[$key]['sub_section_name']='';
          }
          if(!empty($department)){
            $UserMultiLevel[$key]['department_name']=$department['department_name'];
          }else{
             $UserMultiLevel[$key]['department_name']='';
          }
          if(!empty($unit)){
            $UserMultiLevel[$key]['unit_name']=$unit['unit_name'];
          }else{
            $UserMultiLevel[$key]['unit_name']='';
          }
          if(!empty($sub_unit)){
            $UserMultiLevel[$key]['sub_unit_name']=$sub_unit['sub_unit_name'];
          }else{
             $UserMultiLevel[$key]['sub_unit_name']='';
          }
          if(!empty($work)){
            $UserMultiLevel[$key]['work_location_name']=$work['work_location_name'];
          }else{
            $UserMultiLevel[$key]['work_location_name']='';
          }
        }

      }else{

         $UserMultiLevel=['0' =>['id'=>0,'employee_id'=>'','group_permission'=>'','sbu_permission'=>'','unit_permission'=>'','sub_unit_permission'=>'','department_permission'=>'','section_permission'=>'','sub_section_permission'=>'','work_location_permission'=>'']];
      }

  
    return response()->json($UserMultiLevel);
  }

  public function findPriority(){
    $last_entry_data=HolidaySetup::max('priority');
    $last_code = $last_entry_data;
    if ($last_code==0) {
      $last_code = 1;
    }else{
      $last_code = $last_code+1;
    }
    return $last_code;
  }


}
