<?php
namespace App\Http\Controllers\payroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\payroll\WeeklyBonusSetting;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\OfficeTimeSetup;
use Cache;
use permission;
class WeeklyBonusSettingController extends Controller
{
  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Contracts\Support\Renderable
  */
  public function index(Request $request){
    $paginate_num = $request->input('paginate_num');
    $search_key = $request->input('search_key');
    $order = $request->input('order');
    $sort = $request->input('sort');
    $project_id=Auth::guard('user')->user()->project_id;
    $branch_id=Auth::guard('user')->user()->branch_id;

    $employee_list = new Employee();
    $employee_ids=$employee_list->Employee_id();
    $cache=Cache::get('permission');
    $permission=collect($cache)->where('menu_uid','=','WeeklyBonusOvertimeSetting')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
    foreach($permission as $child) {
        if($child['link_uid']=='add'){
            $data['add']=$child['link_uid'];
        }elseif($child['link_uid']=='edit'){
            $data['edit']=$child['link_uid'];
        }elseif($child['link_uid']=='delete') {
            $data['delete']=$child['link_uid'];
        }else {
            $data['view']=$child['link_uid'];
        }
    }
    $paginate_data = WeeklyBonusSetting::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'weekly_bonus_settings.company_sbu_id')
      ->leftJoin('office_time_setups', 'office_time_setups.id', '=', 'weekly_bonus_settings.shift_id')
      ->select(
        'weekly_bonus_settings.*',
        'company_sbus.sbu_name',
        'office_time_setups.title as shift_name'
      )
      ->when($search_key, function($query, $search_key){
        $query->where(function($query2)use($search_key){
          $query2->where('company_sbus.sbu_name','LIKE','%'.$search_key.'%');
        });
        return $query;
      })->whereIn('company_sbus.id',$employee_ids['sub'])->where('weekly_bonus_settings.project_id',$project_id) ->orderBy($sort,$order);
    $sortData=$paginate_data;
    $sortGetData=$sortData->get();
    $data['total_data']=count($sortGetData);
    $data['inactive_data']=count(collect($sortGetData)->whereIn('status',0)->toArray());
    $data['active_data']=count(collect($sortGetData)->where('status',1)->toArray());
    $data['paginate_data'] =$sortData->paginate($paginate_num);
    return response()->json($data);
  }
  public function store(Request $request)
  {
    // return response()->json($request);
    $check_data=WeeklyBonusSetting::valid()->project()->where('company_sbu_id',$request->company_sbu_id)->first();
    if ($check_data) {
      $message=['status' => 0, 'message' => 'Oops! Already data exist!'];
    }
    $validate=[
      'company_sbu_id'=>'required'
    ];
    $request->validate($validate);
    $data=$request->only('company_sbu_id','shift_id','working_day','office_day','bonus_ot_amount','bonus_ot_type','status');
    if(!empty($request->id))
    {
      $update_data=WeeklyBonusSetting::valid()->project()->findOrFail($request->id);
      $data['updated_by']=Auth::guard('user')->user()->id; 
      $save_data=$update_data->update($data);
      $message=['status' => 1, 'message' => 'Your data is successfully updated'];
    }
    else {
      $data['project_id']=Auth::guard('user')->user()->project_id;
      $data['branch_id']=Auth::guard('user')->user()->branch_id; 
      $data['created_by']=Auth::guard('user')->user()->id; 
      $data['status']=1; 
      $save_data=WeeklyBonusSetting::create($data);
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
    $data=WeeklyBonusSetting::valid()->project()->findOrFail($id);
    $companysbu_data_list=CompanySbu::valid()->project()->whereIn('id',$employee_ids['sub'])->get()->keyBy('id')->all();
    if(!$data->company_sbu_id){
      $data->sbu_name_value = ['id'=>'','text'=>'']; 
    }else{
      $data->sbu_name_value = ['id'=>$data->company_sbu_id,'text'=>$companysbu_data_list[$data->company_sbu_id]->sbu_name];
    }
    $company_sbu_data=array();
    foreach ($companysbu_data_list as $value) {
      array_push($company_sbu_data,['id'=>$value['id'],'text'=>$value['sbu_name']]);
    }

    $employee_data_shift_list=OfficeTimeSetup::valid()->project()->get()->keyBy('id')->all();
    if(!$data->shift_id){
      $data->employee_shift_value = ['id'=>'','text'=>'']; 
    }else{

      $data->employee_shift_value = ['id'=>$data->shift_id,'text'=>$employee_data_shift_list[$data->shift_id]->title];
    }
    $employeeShift=array();
    foreach ($employee_data_shift_list as $value) {
        array_push(
          $employeeShift,
          [
            'id'=>$value['id'],
            'text'=>$value['title']
          ]);
      }
    $data->company_sbu_data =  $company_sbu_data;
    $data->employeeShift =  $employeeShift;
    return response($data);
  }

  public function destroy($id)
  {
    $delete_data=WeeklyBonusSetting::valid()->project()->findOrFail($id);
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
      $data['company_sbu_data']=array();
      $company_sbu_data=CompanySbu::valid()->project()->whereIn('id',$employee_ids['sub'])->get();
      foreach ($company_sbu_data as $value) {
        array_push($data['company_sbu_data'],[
          'id'=>$value['id'],
          'text'=>$value['sbu_name']
        ]);
      }
      $data['employee_data']=array();
      $employee_data=Employee::valid()->project()->get();
      foreach ($employee_data as $value) {
        array_push($data['employee_data'],['id'=>$value['id'],'text'=>$value['employee_fullname']]);
      }

      $data['employeeShift']=array();
      $employee_data_shift=OfficeTimeSetup::valid()->project()->where('type',2)->get();
      foreach ($employee_data_shift as $value) {
        array_push(
          $data['employeeShift'],
          [
            'id'=>$value['id'],
            'text'=>$value['title']
          ]);
      }
      return response($data);
  }

  public function findDepartmentMaxCode(){
    $last_entry_data=WeeklyBonusSetting::latest()->first();
    $department_last_code = $last_entry_data['department_code'];
    if ($department_last_code==0) {
      $department_last_code = 101;
    }else{
      $department_last_code = $department_last_code+1;
    }
    return $department_last_code;
  }

}
