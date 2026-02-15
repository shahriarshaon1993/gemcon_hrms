<?php
namespace App\Http\Controllers\payroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\Employee;
use App\Model\payroll\AttendanceBonusModel;
use App\Model\AttendanceMachine;
use App\Model\OfficeTimeSetup;
use Cache;
use permission;
use DB;
// use App\Model\UserRoleAccess;

class AttendanceBonusController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','AttendanceBonus')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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

  $paginate_data =AttendanceBonusModel::valid()->project()
    ->leftJoin('employees', 'employees.id', '=', 'attendance_bonuses.employee_id')
    ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
    ->select('attendance_bonuses.*','employees.employee_fullname','designations.designation_name','employees.employee_id_no')
    ->when($search_key, function($query, $search_key){
      $query->where(function($query2)use($search_key){
        $query2->where('attendance_bonuses.attendance_type','LIKE','%'.$search_key.'%');
        $query2->orWhere('employees.employee_id_no','LIKE','%'.$search_key.'%');
      });
      return $query;

    })->where('attendance_bonuses.project_id',$project_id)->whereIn('attendance_bonuses.employee_id',$employee_id)->orderBy($sort,$order);
    $sortData=$paginate_data;
    $sortGetData=$sortData->get();
    $data['total_data']=count($sortGetData);
    $data['inactive_data']=count(collect($sortGetData)->whereIn('bonus_status',2)->toArray());
    $data['active_data']=count(collect($sortGetData)->where('bonus_status',1)->toArray());
    $data['paginate_data'] =$sortData->paginate($paginate_num);
    return response()->json($data);
}


public function store(Request $request)
{
  // echo "<pre>";print_r($this->findDepartmentMaxCode()); die();
  $validate=[
    'employee_id'=>'required',
    'bonus_type'=>'required',
    'bonus_amount'=>'required'
  ];

  $request->validate($validate);
  $data=$request->only('employee_id','bonus_type','bonus_amount','bonus_status');

  if(!empty($request->id))
  {
    $update_data=AttendanceBonusModel::valid()->project()->findOrFail($request->id);
    $data['updated_by']=Auth::guard('user')->user()->id; 
    $save_data=$update_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    // $data['department_code'] = $this->findDepartmentMaxCode();
    $data['project_id']=Auth::guard('user')->user()->project_id;
    $data['branch_id']=Auth::guard('user')->user()->branch_id; 
    $data['created_by']=Auth::guard('user')->user()->id; 
    $data['bonus_status']=1; 
    $save_data=AttendanceBonusModel::create($data);
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
  $data=AttendanceBonusModel::valid()->project()->findOrFail($id);
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

  $delete_data=AttendanceBonusModel::valid()->project()->findOrFail($id);
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
