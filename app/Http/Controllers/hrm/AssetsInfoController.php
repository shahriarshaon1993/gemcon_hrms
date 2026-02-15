<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\AssetsInfo;
use App\Model\Designation;
use App\Model\Employee;
use Cache;
use permission;

class AssetsInfoController extends Controller
{
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
      $permission=collect($cache)->where('menu_uid','=','designation')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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

      $url = 'http://172.16.1.151/api/employee_asset';
      $obj = json_decode(file_get_contents($url), true);
      $distinct_employee = collect($obj['fitAssetsUsedinfo'])->where('asset_assign_type',8)->unique('asset_assign_parson_id')->values()->all();

      $filtered_employee_id = array();
      foreach ($distinct_employee as $key => $val) {
          $filtered_employee_id[] = $val['asset_assign_parson_id'];
      }

      $paginate_data =Employee::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('sub_sections', 'sub_sections.id', '=', 'employees.employee_section')
      ->leftJoin('employee_groups', 'employee_groups.id', '=', 'employees.employee_section')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_sub_unit')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'sub_sections.sub_section_name',
        'employee_groups.employee_group_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name'
      )
      ->when($search_key, function($query, $search_key){
        $query->where(function($query2)use($search_key){
          $query2->where('employees.employee_fullname','LIKE','%'.$search_key.'%')
          ->orWhere('employees.employee_mobile','LIKE','%'.$search_key.'%')
          ->orWhere('employees.employee_joining_date','LIKE','%'.$search_key.'%')
          ->orWhere('employees.employee_id_no','LIKE','%'.$search_key.'%')
          ->orWhere('company_sbus.sbu_name','LIKE','%'.$search_key.'%')
          ->orWhere('departments.department_name','LIKE','%'.$search_key.'%')
          ->orWhere('designations.designation_name','LIKE','%'.$search_key.'%')
          ->orWhere('sub_units.sub_unit_name','LIKE','%'.$search_key.'%')
          ->orWhere('work_locations.work_location_name','LIKE','%'.$search_key.'%')
          ->orWhere('sections.section_name','LIKE','%'.$search_key.'%')
          ;
        });
        return $query;
      })->whereIn('employees.employee_id_no',$filtered_employee_id);
      $employeeAll=$paginate_data;
      $data['paginate_data'] = $employeeAll->orderBy($sort,$order)->paginate($paginate_num);
      return response()->json($data);
    }

    public function store(Request $request)
    {
      // echo "sf"; die();
      $validate=[
        'designation_name'=>'required'
      ];

      $request->validate($validate);
      $data=$request->only('designation_name','designation_status');
      if(!empty($request->id))
      {
        $update_data=AssetsInfo::valid()->project()->findOrFail($request->id);
        $data['updated_by']=Auth::guard('user')->user()->branch_id; 
        $save_data=$update_data->update($data);
        $message=['status' => 1, 'message' => 'Your data is successfully updated'];
      }
      else {
        $data['designation_code'] = $this->findMaxCode();
        $data['project_id']=Auth::guard('user')->user()->project_id;
        $data['branch_id']=Auth::guard('user')->user()->branch_id; 
        $data['created_by']=Auth::guard('user')->user()->id; 
        $data['designation_status']=1; 
        $save_data=AssetsInfo::create($data);
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
      $edit_data['user_employee_data'] = $employee_info = Employee::valid()->project()
        ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
        ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
        ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
        ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
        ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
        ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_sub_unit')
        ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
        ->select(
          'employees.*',
          'company_sbus.sbu_name',
          'sections.section_name',
          'departments.department_name',
          'designations.designation_name',
          'sub_units.sub_unit_name',
          'work_locations.work_location_name',
          'employee_personal_infos.employee_gender'
        )
        ->where('employees.id',$id)->first();

        $url = 'http://172.16.1.151/api/employee_asset';
        $obj = json_decode(file_get_contents($url), true);
        if (!empty($obj)) {
          $assets_assign_ids = collect($obj['fitAssetsUsedinfo'])->where('asset_assign_parson_id',$employee_info->employee_id_no)->pluck('id')->toArray();
          $asset_ids = collect($obj['fitAssetsUsedinfoDetails'])->whereIn('asset_assign_info_id',$assets_assign_ids)->toArray();
          $assets_detail_array=[];
          foreach ($asset_ids as $key => $value) {
            $fixtAssets=collect($obj['fixtAssets'])->where('id',$value['assets_id'])->first();
            $fitAssetsUsedinfo=collect($obj['fitAssetsUsedinfo'])->where('id',$value['asset_assign_info_id'])->first();
             $assets_detail_array[]= array(
                  'assets_id' => $value['assets_master'], 
                  'asset_checkout'=> $value['asset_checkout'], 
                  'assets_master_description'=> $fixtAssets['assets_master_description'], 
                  'brand_or_model'=> $fixtAssets['brand_or_model'], 
                  'condidtion'=> $fixtAssets['condidtion'], 
                  // 'assing_date' => $fitAssetsUsedinfo['assing_date'],
                  'assign_create_at' => date("d M, Y, g:i a", strtotime($fitAssetsUsedinfo['created_at'])),
                );
          }
          $edit_data['assets_detail'] = $assets_detail_array;
        }
      return response($edit_data);
    }

    public function destroy($id)
    {

      $delete_data=AssetsInfo::valid()->project()->findOrFail($id);
      if($delete_data->delete())
      {
        $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
      }
      return response($message);

    }

    public function findMaxCode(){
      $last_entry_data = AssetsInfo::latest()->first();
      $last_code = $last_entry_data['designation_code'];
      if ($last_code==0) {
        $last_code = 101;
      }else{
        $last_code = $last_code+1;
      }
      return $last_code;
    }

    public function create(){
      $data['priority'] = $this->findPriority();
      return response($data);
    }

    public function findPriority(){
      $last_entry_data=AssetsInfo::max('priority');
      $last_code = $last_entry_data;
      if ($last_code==0) {
        $last_code = 1;
      }else{
        $last_code = $last_code+1;
      }
      return $last_code;
    }

}
