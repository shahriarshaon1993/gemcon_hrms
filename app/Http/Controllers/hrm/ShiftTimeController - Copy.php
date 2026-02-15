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
use App\Model\AttendanceSetup;
use App\Model\OfficeTimeSetup;
use Cache;
use permission;
use DB;
use DateTime;
use DateInterval;
use DatePeriod;
// use App\Model\UserRoleAccess;

class ShiftTimeController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','ShiftingSetup')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
  $project_id=Auth::guard('user')->user()->project_id;
  $paginate_num = $request->input('paginate_num');
  $search_key = $request->input('search_key');
  $order = $request->input('order');
  $sort = $request->input('sort');
  $employee_list = new Employee();
  $employee_ids=$employee_list->Employee_id();
  $employee_id=$employee_ids['employee_id'];
  

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

  $paginate_data=OfficeTimeSetup::valid()->project()
                        ->select('office_time_setups.*',
                          DB::raw('DATE_FORMAT(office_end_time, "%h:%i %p") as office_end_time'),
                          DB::raw('DATE_FORMAT(office_start_time, "%h:%i %p") as office_start_time'))
                        ->whereIn('type',['2','3'])->where('office_time_status',1)
                        ->orderBy($sort,$order);
                        // ->paginate($paginate_num);
  
  $sortData=$paginate_data;

  $sortGetData=$sortData->get();
  $data['total_data']=count($sortGetData);
  $data['inactive_data']=count(collect($sortGetData)->whereIn('office_time_status',0)->toArray());
  $data['active_data']=count(collect($sortGetData)->where('office_time_status',1)->toArray());

  $data['paginate_data'] =$sortData->paginate($paginate_num);
  return response()->json($data);
}

public function shifting_fiends(Request $request){
  $employee_list = new Employee();
  $employee_ids=$employee_list->Employee_id();
  $employee_id=$employee_ids['employee_id'];
  $employee_data_approval=[];
  $section_id=$request['section_id'];
  $subsection_id=$request['subsection_id'];
  $employee_groupsubunit_id=$request['employee_groupsubunit_id'];
  $subunit_id=$request['subunit_id'];
  $unit_id=$request['unit_id'];
  $employee_work_location=$request['employee_work_location'];
  $department_id=$request['department_id'];


  // if($request['types']==1){
  //   $employee_data_approval=Employee::valid()->project()->where('employee_sbu',$request['id'])->get();
  // }else if($request['types']==2){
  //    $employee_data_approval=Employee::valid()->project()->where('employee_department',$request['id'])->get();
  // }else if($request['types']==3){
  //    $employee_data_approval=Employee::valid()->project()->where('employee_unit',$request['id'])->get();
  // }else if($request['types']==4){
  //     $employee_data_approval=Employee::valid()->project()->where('employee_sub_unit',$request['id'])->get();
  // }else if($request['types']==5){
  //     $employee_data_approval=Employee::valid()->project()->where('employee_section',$request['id'])->get();
  // }else if($request['types']==6){
  //     $employee_data_approval=Employee::valid()->project()->where('employee_sub_section',$request['id'])->get();
  // }else if($request['types']==7){
  //     $employee_data_approval=Employee::valid()->project()->where('employee_id_no',$request['id'])->get();
  // }
  

  $employee_data_approval=Employee::valid()->project()
              ->where('employee_sbu',$request['sbu_id'])
              ->where('employee_status',1)
              ->where(function($loanInfo)use($section_id,$subsection_id,$employee_groupsubunit_id,$subunit_id,$unit_id,$employee_work_location,$department_id){
                    if(!empty($section_id)){
                        $loanInfo->where('employee_section',$section_id);
                    }
                    if(!empty($subsection_id)){
                        $loanInfo->where('employee_sub_section',$subsection_id);
                    }
                    if(!empty($employee_groupsubunit_id)){
                        $loanInfo->where('employee_group',$employee_groupsubunit_id);
                    }
                    if(!empty($subunit_id)){
                        $loanInfo->where('employee_sub_unit',$subunit_id);
                    }
                    if(!empty($unit_id)){
                        $loanInfo->where('employee_unit',$unit_id);
                    } 
                    if(!empty($employee_work_location)){
                        $loanInfo->where('employee_work_location',$employee_work_location);
                    }
                    if(!empty($department_id)){
                        $loanInfo->where('employee_department',$department_id);
                    }
                })
              ->get();
         // return response()->json($employee_data_approval);    
    $year=date('Y');

    if(!empty($request['week_id'])){
      $aa=$this->weeks_in_month($request->months_id, $year);
      $found_key=[];
      $found_date=[];
      foreach ($aa as $key => $value) {
           if($key==$request['week_id']){
                $found_key =$value;
           }
        }
        $start=current($found_key)['date'];
        $end=end($found_key)['date'];
    }else{
        $firstDate=$year."-". $request->months_id."-"."01";
        $date = new DateTime($firstDate);
        $date->modify('last day of this month');
        $lastDate= $date->format('Y-m-d');
        $start=$firstDate;
        $end=$lastDate;
    }
    
//     if($request['roaster_id']==0){
      

//     }else if($request['roaster_id']==1){
      

//     }
// // $qq=collect($found_key)->pluck('date');
// // return response()->json($lastDate);

      $start=$start;
      $end=$end;
      $start= new DateTime($start);
      $end = new DateTime($end);
      $diff = $start->diff($end);
      $interval = DateInterval::createFromDateString('+1 day');
      $period_main = new DatePeriod($start, $interval, $diff->days);
      $employee_ids=collect($employee_data_approval)->pluck('id')->toArray();
      $roasterData=AttendanceSetup::valid()->project()
                  ->where('start_date','>=',$start)
                  ->where('start_date','<=',$end)
                  ->whereIn('employee_id',$employee_ids)
                  ->get();
      $shiftData=OfficeTimeSetup::valid()->project()->whereIn('type',['2','3'])->where('office_time_status',1)->get();
      $pay_days_count = 0;
      $dataLength = 0;
      $employee_data_approvaldat=[];

      
      if(count($employee_data_approval) > 0){
      foreach ($employee_data_approval as $key => $value) {
        $datesList=[];
        foreach ($period_main as $key => $date) {
          $find_emply=collect($roasterData)->where('employee_id',$value['id'])->where('start_date',$date->format('Y-m-d'))->first();
         
          if(!empty($find_emply)){
             $shiftDatas=collect($shiftData)->where('id',$find_emply['attendance_office_time'])->first();
            $datesList[]=[
                'date'=>$date->format('Y-m-d'),
                'days'=>$date->format('l'),
                'dates'=>$date->format('d F'),
                'shiftTimeid'=>['id'=>$find_emply['attendance_office_time'],'text'=>$shiftDatas['title']."   [ ".date('h:i A', strtotime($shiftDatas['office_start_time']))." - ".date('h:i A', strtotime($shiftDatas['office_end_time'])). " ] "],
                // 'shiftTimeid'=>office_time_value = ['id'=>'','text'=>'']; ,
                
            ]; 
          }else{
            $datesList[]=[
                'date'=>$date->format('Y-m-d'),
                'days'=>$date->format('l'),
                'dates'=>$date->format('d F'),
                'shiftTimeid'=>$value['employee_id_no'].$date->format('d'),
                
            ]; 
          }
          
        }
        $employee_data_approvaldat[]=[
          'employee_fullname'=>$value['employee_fullname'],
          'employee_id_no'=>$value['employee_id_no'],
          'id'=>$value['id'],
          'datesLists'=>$datesList,
        ];
      }
      
      $data['datesList']=$datesList;
      $data['employee_data_approvaldat']=$employee_data_approvaldat;
    }else{
      $data['datesList']=[];
      $data['employee_data_approvaldat']=[];
    }
      
  return response()->json($data);
}

public function roaster_report_find(Request $request){
      $employee_list = new Employee();
      $employee_ids=$employee_list->Employee_id();
      $employee_id=$employee_ids['employee_id'];
      $employee_data_approval=[];
      $section_id=$request['section_id'];
      $subsection_id=$request['subsection_id'];
      $employee_groupsubunit_id=$request['employee_groupsubunit_id'];
      $subunit_id=$request['subunit_id'];
      $unit_id=$request['unit_id'];
      $employee_work_location=$request['employee_work_location'];
      $department_id=$request['department_id'];
      $employee_data_approval=Employee::valid()->project()->where('employee_status',1)
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'departments.department_name',
        'designations.designation_name',
        'work_locations.work_location_name'
      )
      ->where('employee_sbu',$request['sbu_id'])
      ->where(function($loanInfo)use($section_id,$subsection_id,$employee_groupsubunit_id,$subunit_id,$unit_id,$employee_work_location,$department_id){
            if(!empty($section_id)){
                $loanInfo->where('employee_section',$section_id);
            }
            if(!empty($subsection_id)){
                $loanInfo->where('employee_sub_section',$subsection_id);
            }
            if(!empty($employee_groupsubunit_id)){
                $loanInfo->where('employee_group',$employee_groupsubunit_id);
            }
            if(!empty($subunit_id)){
                $loanInfo->where('employee_sub_unit',$subunit_id);
            }
            if(!empty($unit_id)){
                $loanInfo->where('employee_unit',$unit_id);
            } 
            if(!empty($employee_work_location)){
                $loanInfo->where('employee_work_location',$employee_work_location);
            }
            if(!empty($department_id)){
                $loanInfo->where('employee_department',$department_id);
            }
        })
      ->get();    
    $year=date('Y');
    if(!empty($request['week_id'])){
      $aa=$this->weeks_in_month($request->months_id, $year);
      $found_key=[];
      $found_date=[];
      foreach ($aa as $key => $value) {
           if($key==$request['week_id']){
                $found_key =$value;
           }
        }
        $start=current($found_key)['date'];
        $end=end($found_key)['date'];
    }else{
        $firstDate=$year."-". $request->months_id."-"."01";
        $date = new DateTime($firstDate);
        $date->modify('last day of this month');
        $lastDate= $date->format('Y-m-d');
        $start=$firstDate;
        $end=$lastDate;
    }
      $start=$start;
      $end=$end;
      $start= new DateTime($start);
      $end = new DateTime($end);
      $diff = $start->diff($end);
      $interval = DateInterval::createFromDateString('+1 day');
      $period_main = new DatePeriod($start, $interval, $diff->days);
      $employee_ids=collect($employee_data_approval)->pluck('id')->toArray();
      $roasterData=AttendanceSetup::valid()->project()
                  ->where('start_date','>=',$start)
                  ->where('start_date','<=',$end)
                  ->whereIn('employee_id',$employee_ids)
                  ->get();
      $shiftData=OfficeTimeSetup::valid()->project()->whereIn('type',['2','3'])->where('office_time_status',1)->get();
      $pay_days_count = 0;
      $dataLength = 0;
      $employee_data_approvaldat=[];
          if(count($employee_data_approval) > 0){
          foreach ($employee_data_approval as $key => $value) {
            $datesList=[];
            foreach ($period_main as $key => $date) {
              $find_emply=collect($roasterData)->where('employee_id',$value['id'])->where('start_date',$date->format('Y-m-d'))->first();
              if(!empty($find_emply)){
                $shiftDatas=collect($shiftData)->where('id',$find_emply['attendance_office_time'])->first();
                $datesList[]=[
                    'date'=>$date->format('Y-m-d'),
                    'days'=>$date->format('l'),
                    'dates'=>$date->format('d F'),
                    'shiftTimeid'=>['id'=>$find_emply['attendance_office_time'],'text'=>$shiftDatas['title']."   [ ".date('h:i A', strtotime($shiftDatas['office_start_time']))." - ".date('h:i A', strtotime($shiftDatas['office_end_time'])). " ] "],
                ]; 
              }else{
                $datesList[]=[
                    'date'=>$date->format('Y-m-d'),
                    'days'=>$date->format('l'),
                    'dates'=>$date->format('d F'),
                    'shiftTimeid'=>$value['employee_id_no'].$date->format('d'),
                ]; 
              } 
            }
            $employee_data_approvaldat[]=[
              'employee_fullname'=>$value['employee_fullname'],
              'employee_id_no'=>$value['employee_id_no'],
              'designation_name'=>$value['designation_name'],
              'department_name'=>$value['department_name'],
              'work_locations'=>$value['work_locations'],
              'sbu_name'=>$value['sbu_name'],
              'empl'=>$value['empl'],
              'id'=>$value['id'],
              'datesLists'=>$datesList,
            ];
          }
          $data['datesList']=$datesList;
          $data['employee_data_approvaldat']=$employee_data_approvaldat;
        }else{
          $data['datesList']=[];
          $data['employee_data_approvaldat']=[];
        }    
    return response()->json($data);
}

function weeks_in_month($month, $year)
    {
        $dates = [];

        $week = 1;
        $date = new DateTime("$year-$month-01");
        $days = (int)$date->format('t'); // total number of days in the month

        $oneDay = new DateInterval('P1D');

        for ($day = 1; $day <= $days; $day++) {
            $dates["$week"] []=[
                'date'=>$date->format('Y-m-d'),
                'day_name'=>$date->format('l'),
                'day_names'=>$date->format('D'),
                'day'=>$date->format('d')
                ];

            $dayOfWeek = $date->format('l');
            if ($dayOfWeek === 'Saturday') {
                $week++;
            }

            $date->add($oneDay);
        }

        return $dates;
}

public function week_fiends(request $request)
{
        $year=date('Y');
        $aa=$this->weeks_in_month($request->id, $year);
        $found_key=[];
        $week=[];
        foreach ($aa as $key => $value) {
           if($key==2){
                $found_key=$value;
           }
           // if(){
            $week[]=[
            "id"=>$key,
            "text"=>"Week ".$key,
            ];
           // }
           
        }
        $data['week']=$week;
return response($data);
}

public function store(Request $request)
{
   
  // return response($request);
  try {
      DB::beginTransaction();
      $insert_array=[];
      foreach ($request->employee_data_approvaldat as $key => $value) {
        $emp_name=$value['employee_fullname'];
        $emp_id_no=$value['employee_id_no'];
        $emp_id=$value['id'];
        $emn=0;
        foreach ($value['datesLists'] as $key1 => $value1) {

          if (!empty($value1['shiftTimeid']['id'])) {
             $emn++;
            DB::table('attendance_setups')->where('start_date','=',$value1['date'])
                  ->where('employee_id',$emp_id)->delete();
            if($emn > 0 ){

              $finds=DB::table('attendance_setups')->where('employee_id','=',$emp_id)
              ->where('end_date','>=',$value1['date'])
              ->update([
                 'end_date' =>  date('Y-m-d', strtotime('-1 day', strtotime($value1['date']))),
              ]);
            }      

            $insert_array[]=[
              // "emp_name"=>$emp_name,
              "employee_id"=>$emp_id,
              // "employee_id_no"=>$emp_id_no,
              "start_date"=>$value1['date'],
              "end_date"=>$value1['date'],
              "attendance_office_time"=>$value1['shiftTimeid']['id'],
              "attendance_setup_status"=>1,
              "attendance_type"=>1,
              "attendance_category"=>1,
              "attendance_machine_no"=>4,
              "project_id"=>Auth::guard('user')->user()->project_id,
              "branch_id"=>Auth::guard('user')->user()->branch_id,
              "created_by"=>Auth::guard('user')->user()->id,
              "created_by"=>date('Y-m-d H:i:s'),
            ];
          }else{
            $dates=$request->datesList[$key1];
              DB::table('attendance_setups')->where('start_date','=',$dates['date'])
                  ->where('employee_id',$emp_id)->delete();
            $insert_array[]=[
              // "emp_name"=>$emp_name,
              "employee_id"=>$emp_id,
              // "employee_id_no"=>$emp_id_no,
              "start_date"=>"",
              "end_date"=>"",
              "attendance_office_time"=>"",
              "attendance_setup_status"=>1,
              "attendance_type"=>1,
              "attendance_category"=>1,
              "attendance_machine_no"=>4,
              "project_id"=>Auth::guard('user')->user()->project_id,
              "branch_id"=>Auth::guard('user')->user()->branch_id,
              "created_by"=>Auth::guard('user')->user()->id,
              "created_by"=>date('Y-m-d H:i:s'),
            ];
          }
        }
      }

      $insert_array_find=collect($insert_array)->where('attendance_office_time','!=',"")->toArray();
      AttendanceSetup::insert($insert_array_find);
      DB::commit();
      $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
      return response($message);
    } catch (Throwable $e) {
      DB::rollback();
      throw $e;
    }
    // } catch (\Exception $exception) {
    //     DB::rollBack();
    //     $message=['status' => 0, 'message' => 'Ops! Something went worng.'];
    //     return response($exception);
    // }
      
  return response($message);

}

public function edit($id)
{
  $data=OfficeTimeSetup::valid()->project()->findOrFail($id);
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
     $data->approval_infos=['0' =>['id'=>0,'permission_type'=>'','permission_id'=>'']];
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
      $employee_data=Employee::valid()->project()->get()->keyBy('id')->all();
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