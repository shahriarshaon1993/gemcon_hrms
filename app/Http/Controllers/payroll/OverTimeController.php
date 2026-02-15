<?php
namespace App\Http\Controllers\payroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\Employee;
use App\Model\payroll\OverTimeModel;
use App\Model\AttendanceMachine;
use App\Model\OfficeTimeSetup;
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
use App\Model\AttendanceSetup;
use Cache;
use permission;
use DB;
// use App\Model\UserRoleAccess;

class OverTimeController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','OverTime')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
  $employee_list = new Employee();
  $employee_ids=$employee_list->Employee_id();
  $employee_id=$employee_ids['employee_id'];

  $paginate_data =OverTimeModel::valid()->project()
    ->leftJoin('employees', 'employees.id', '=', 'over_times.employee_id')
    ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
    ->select('over_times.*','employees.employee_fullname','employees.employee_id_no','designations.designation_name')
    ->when($search_key, function($query, $search_key){
      $query->where(function($query2)use($search_key){
        $query2->where('over_times.attendance_type','LIKE','%'.$search_key.'%');
        $query2->orWhere('employees.employee_id_no','LIKE','%'.$search_key.'%');
      });
      return $query;

    })->where('over_times.project_id',$project_id)->whereIn('over_times.employee_id',$employee_id)->orderBy($sort,$order);
    $sortData=$paginate_data;
    $sortGetData=$sortData->get();
    $data['total_data']=count($sortGetData);
    $data['inactive_data']=count(collect($sortGetData)->whereIn('attendance_setup_status',2)->toArray());
    $data['active_data']=count(collect($sortGetData)->where('attendance_setup_status',1)->toArray());
     $data['paginate_data'] =$sortData->paginate($paginate_num);

  return response()->json($data);
}


public function store(Request $request)
{
  // echo "<pre>";print_r($this->findDepartmentMaxCode()); die();
  $validate=[
    'employee_id'=>'required',
    'hour_rate'=>'required',
    'ot_type'=>'required'
  ];

  $request->validate($validate);
  $data=$request->only('employee_id','hour_rate','ot_type','ot_status');

  if(!empty($request->id))
  {
    $update_data=OverTimeModel::valid()->project()->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->id; 
    $save_data=$update_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
    $data['ot_status']=1; 
    $save_data=OverTimeModel::create($data);
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
   $employee_list = new Employee();
   $employee_ids=$employee_list->Employee_id();
   $employee_id=$employee_ids['employee_id'];
  $data=OverTimeModel::valid()->project()->findOrFail($id);
  $employee_data_list=Employee::valid()->project()->whereIn('employee_sbu',$employee_ids['sub'])->whereIn('employee_department',$employee_ids['department'])->get()->keyBy('id')->all();

  // return response($employee_data_list);
  $attendance_machine_list=AttendanceMachine::valid()->project()->get()->keyBy('id')->all();
  $office_time_list=OfficeTimeSetup::valid()->project()->get()->keyBy('id')->all();
  if(!$data->employee_id){
    $data->employee_name_value = ['id'=>'','text'=>'']; 
  }else{
    $data->employee_name_value = ['id'=>$data->employee_id,'text'=>$employee_data_list[$data->employee_id]->employee_fullname];
  }
  if(!$data->attendance_machine_no){
    $data->attendance_machine_value = ['id'=>'','text'=>'']; 
  }else{
    $data->attendance_machine_value = ['id'=>$data->attendance_machine_no,'text'=>$attendance_machine_list[$data->attendance_machine_no]->attendance_machine_name];
  }
  if(!$data->attendance_office_time){
    $data->office_time_value = ['id'=>'','text'=>'']; 
  }else{
    $data->office_time_value = [
      'id'=>$data->attendance_office_time,
      'text'=>$office_time_list[$data->attendance_office_time]->office_start_time.'-'.$office_time_list[$data->attendance_office_time]->office_end_time
    ];
  }
  
// return response($data);
  $employee_data=array();
  $attendance_machine_data=array();
  $office_time_data=array();
  foreach ($employee_data_list as $value) {
    array_push($employee_data,['id'=>$value['id'],'text'=>$value['employee_fullname']]);
  }

  foreach ($attendance_machine_list as $value) {
    array_push($attendance_machine_data,['id'=>$value['id'],'text'=>$value['attendance_machine_name']]);
  }
  foreach ($office_time_list as $value) {
    array_push($office_time_data,['id'=>$value['id'],'text'=>$value['office_start_time'].'-'.$value['office_end_time']]);
  }
  $data->employee_data =  $employee_data;
  $data->attendance_machine_data =  $attendance_machine_data;
  $data->office_time_data =  $office_time_data;
  return response($data);

}

public function destroy($id)
{

  $delete_data=OverTimeModel::valid()->project()->findOrFail($id);
  if($delete_data->delete())
  {
    $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
  }
  return response($message);

}

  public function create(){
      $employee_list = new Employee();
      $employee_ids=$employee_list->Employee_id();
      $employee_id=$employee_ids['employee_id'];

      $data['employee_data']=array();
      $data['attendance_machine_data']=array();
      $data['office_time_data']=array();
      $data['company_sbu_data']=array();
      $data['section_data']=array();
      $data['sub_section_data']=array();
      $data['sub_unit_data']=array();
      $data['unit_data']=array();
      $data['work_location_data']=array();
      $data['department_data']=array();
      $data['designation_data']=array();
      $data['jobgrade_data']=array();
      $data['employee_data_approval']=array();
      $data['employee_group_data']=array();
      $company_sbu_data=CompanySbu::valid()->project()->get();
      $section_data=Section::valid()->project()->get();
      $sub_section_data=SubSection::valid()->project()->get();
      $department_data=Department::valid()->project()->get();
      $designation_data=Designation::valid()->project()->get();
      $jobgrade_data=JobGrade::valid()->project()->get();
      $employee_data_approval=Employee::valid()->project()->get();
      $employee_data=Employee::valid()->project()->get()->keyBy('id')->all();
      $unit_data=UnitModel::valid()->project()->get();
      $sub_unit_data=SubUnit::valid()->project()->get();
      $work_location_data=WorkLocation::valid()->project()->get();
      $employee_group_data=EmployeeGroup::valid()->project()->get();
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
        array_push($data['unit_data'],['id'=>$value['id'],'text'=>$value['unit_name']]);
      }

      foreach ($work_location_data as $value) {
        array_push($data['work_location_data'],['id'=>$value['id'],'text'=>$value['work_location_name']]);
      }

      // $employee_data=Employee::valid()->project()->get();
      $employee_data=Employee::valid()->project()
                    ->whereIn('employee_sbu',$employee_ids['sub'])
                    ->whereIn('employee_department',$employee_ids['department'])
                    ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
                    ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
                    ->select(
                      'employees.*',
                      'designations.designation_name',
                      'departments.department_name'
                    )
                    ->get();
      $attendance_machine_data=AttendanceMachine::valid()->project()->get();
      $office_time_data=OfficeTimeSetup::valid()->project()->get();
       // return response($attendance_machine_data);  
      foreach ($employee_data as $value) {
        // array_push($data['employee_data'],['id'=>$value['id'],'text'=>$value['employee_fullname']]);
        array_push($data['employee_data'],['id'=>$value['id'],'employee_id_no'=>$value['employee_id_no'],'text'=>$value['employee_id_no'].': '.$value['employee_fullname'].' - '.$value['designation_name'].' - '.$value['department_name']]);
      }
      foreach ($attendance_machine_data as $value) {
        array_push($data['attendance_machine_data'],['id'=>$value['id'],'text'=>$value['attendance_machine_name']]);
      }
      foreach ($office_time_data as $value) {
        array_push($data['office_time_data'],['id'=>$value['id'],'text'=>$value['office_start_time'].' - '.$value['office_end_time']]);
      }
      return response($data);
  }

  public function attendance_log(Request $request){
    $paginate_num = $request->input('paginate_num');
    $search_key = $request->input('search_key');
    $order = $request->input('order');
    $sort = $request->input('sort');
    $project_id=Auth::guard('user')->user()->project_id;
    $branch_id=Auth::guard('user')->user()->branch_id;
   $employee_list = new Employee();
   $employee_ids=$employee_list->Employee_id();
   $employee_id=$employee_ids['employee_id'];
    $data['paginate_data'] =DB::table('attendance_log')
      ->leftJoin('employees', 'employees.employee_id_no', '=', 'attendance_log.employee_id')
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->select(
        'attendance_log.*',
        'employees.employee_fullname',
        'company_sbus.sbu_name',
        'departments.department_name',
        'designations.designation_name'
        // 'employees.id as employeeId'
      )
      ->when($search_key, function($query, $search_key){
        $query->where(function($query2)use($search_key){
          $query2->where('attendance_log.TransactionDate','LIKE','%'.$search_key.'%');
        });
        return $query;

      })->whereIn('employees.id',$employee_id)
      ->where('TransactionDate',date('Y-m-d'))
      ->orderBy($sort,$order)->paginate($paginate_num);

    return response()->json($data);
  }

  // public function attendance_report(Request $request){
  //   $paginate_num = $request->input('paginate_num');
  //   $search_key = $request->input('search_key');
  //   $order = $request->input('order');
  //   $sort = $request->input('sort');
  //   $project_id=Auth::guard('user')->user()->project_id;
  //   $branch_id=Auth::guard('user')->user()->branch_id;
  //   $data['paginate_data'] =DB::table('attendance_log')
  //     ->leftJoin('employees', 'employees.id', '=', 'attendance_log.employee_id')
  //     ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
  //     ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
  //     ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
  //     ->select(
  //       'attendance_log.*',
  //       'employees.employee_fullname',
  //       'company_sbus.sbu_name',
  //       'departments.department_name',
  //       'designations.designation_name'
  //     )
  //     ->when($search_key, function($query, $search_key){
  //       $query->where(function($query2)use($search_key){
  //         $query2->where('attendance_log.TransactionDate','LIKE','%'.$search_key.'%');
  //       });
  //       return $query;

  //     })->orderBy($sort,$order)->paginate($paginate_num);

  //   return response()->json($data);
  // }












}
