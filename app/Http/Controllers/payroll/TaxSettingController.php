<?php
namespace App\Http\Controllers\payroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\payroll\TaxSetting;
use App\Model\Employee;
use Cache;
use permission;
class TaxSettingController extends Controller
{
  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Contracts\Support\Renderable
  */
  public function index(Request $request){
    $employee_list = new Employee();
    $employee_ids=$employee_list->Employee_id();
    $cache=Cache::get('permission');
    $permission=collect($cache)->where('menu_uid','=','TaxSetting')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
    $check_data=TaxSetting::valid()->project()->where('status',1)->first();
    if (empty($check_data)) {
      $data=$request->only('effective_date','taxable_income','taxable_slot1','taxable_slot1_per','taxable_slot2','taxable_slot2_per','taxable_slot3','taxable_slot3_per','taxable_slot4','taxable_slot4_per','taxable_slot5','taxable_slot5_per','status');
      $data['project_id']=Auth::guard('user')->user()->project_id;
      $data['branch_id']=Auth::guard('user')->user()->branch_id; 
      $data['created_by']=Auth::guard('user')->user()->id; 
      $save_data=TaxSetting::create($data);
    }
    $edit_data=TaxSetting::valid()->project()->first();
    // $edit_data=collect($check_data)->where('status',1)->first();
    return response($edit_data);
  }
  public function store(Request $request)
  {
    // return response($request);
    $validate=[
      'taxable_income_male'=>'required'
    ];

    $request->validate($validate);
    $data=$request->only('effective_date','taxable_income_male','taxable_income_female','taxable_income_age','taxable_slot1','taxable_slot1_per','taxable_slot2','taxable_slot2_per','taxable_slot3','taxable_slot3_per','taxable_slot4','taxable_slot4_per','taxable_slot5','taxable_slot5_per','status','taxable_maximum_age');

    if(!empty($request->id))
    {
      $update_data=TaxSetting::valid()->project()->findOrFail($request->id);
      $data['updated_by']=Auth::guard('user')->user()->id; 
      $save_data=$update_data->update($data);
      $message=['status' => 1, 'message' => 'Your data is successfully updated'];
    }
    else {
      $data['project_id']=Auth::guard('user')->user()->project_id;
      $data['branch_id']=Auth::guard('user')->user()->branch_id; 
      $data['created_by']=Auth::guard('user')->user()->id; 
      $data['status']=1; 
      $save_data=TaxSetting::create($data);
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
    $edit_data=TaxSetting::valid()->project()->findOrFail($id);
    return response($edit_data);
  }

  public function destroy($id)
  {
    $delete_data=TaxSetting::valid()->project()->findOrFail($id);
    if($delete_data->delete())
    {
      $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
    }
    return response($message);
  }

  public function create(){
      $data['employee_data']=array();
      $employee_data=Employee::valid()->project()->get();
      foreach ($employee_data as $value) {
        array_push($data['employee_data'],['id'=>$value['id'],'text'=>$value['employee_fullname']]);
      }
      return response($data);
  }

  public function findDepartmentMaxCode(){
    $last_entry_data=TaxSetting::latest()->first();
    $department_last_code = $last_entry_data['department_code'];
    if ($department_last_code==0) {
      $department_last_code = 101;
    }else{
      $department_last_code = $department_last_code+1;
    }
    return $department_last_code;
  }

}
