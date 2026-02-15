<?php
namespace App\Http\Controllers\hrm;
use App\Http\Controllers\Controller;
use App\Model\CompanySbu;
use App\Model\Department;
use App\Model\Employee;
use App\Model\UnitModel;
use Auth;
use Cache;
use DB;
use Illuminate\Http\Request;
class GeneralStationaryController extends Controller
{
/**
* Show the application dashboard.
*
* @return \Illuminate\Contracts\Support\Renderable
*/

public function index(Request $request){
  $cache=Cache::get('permission');
  $permission=collect($cache)->where('menu_uid','=','StationaryService')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
  foreach($permission as $child) {
      if($child['link_uid']=='add'){
          $data['add']=$child['link_uid'];
      }elseif($child['link_uid']=='view'){
          $data['view']=$child['link_uid'];
      }elseif($child['link_uid']=='edit'){
          $data['edit']=$child['link_uid'];
      }elseif($child['link_uid']=='delete') {
          $data['delete']=$child['link_uid'];
      }elseif($child['link_uid']=='approve')  {
          $data['approve']=$child['link_uid'];
      }elseif($child['link_uid']=='reject')  {
          $data['reject']=$child['link_uid'];
      }elseif($child['link_uid']=='hod_approve')  {
          $data['hod_approve']=$child['link_uid'];
      }elseif($child['link_uid']=='hr_approve')  {
          $data['hr_approve']=$child['link_uid'];
      }
  }
  $paginate_num = $request->input('paginate_num');
  $search_key = $request->input('search_key');
  if ($request->input('sort') =='id') {
    $order = 'DESC';
    $sort = 'id';
  } else {
    $order = $request->input('order');
    $sort = $request->input('sort');
  }
  $project_id = Auth::guard('user')->user()->project_id;
  $branch_id = Auth::guard('user')->user()->branch_id;

  $paginate_data = DB::connection('mysql2')->table('hr_stationary_summary')->
  when($search_key, function($query, $search_key){
      $query->where(function($query2)use($search_key){
        $query2->where('employee_id_no','LIKE','%'.$search_key.'%');
        $query2->orWhere('employee_name','LIKE','%'.$search_key.'%');
        $query2->orWhere('department_name','LIKE','%'.$search_key.'%');
        $query2->orWhere('sbu_name','LIKE','%'.$search_key.'%');
        // $query2->orWhere('request_date','LIKE','%'.$search_key.'%');
        // $query2->orWhere('hss2.requestion_qty','LIKE','%'.$search_key.'%');
        // $query2->orWhere('hss2.status','LIKE','%'.$search_key.'%');
      });
    return $query;
  })->where('valid', 1)->orderBy($sort,$order);

  $sortData = $paginate_data;
  $sortGetData = $sortData->get();
  $data['paginate_data'] = $sortData->paginate($paginate_num);
  $data['total_data']=count($sortGetData);
  $data['inactive_data']=count(collect($sortGetData)->whereIn('employee_status',0)->toArray());
  $data['active_data']=count(collect($sortGetData)->where('employee_status',1)->toArray());

  $data['requestApplications']=count($sortGetData);
  $data['onlyRequested']=count(collect($sortGetData)->where('status',1)->toArray());
  $data['pendingApplications']=count(collect($sortGetData)->whereIn('status',['1','2'])->toArray());
  $data['acceptedApplications']=count(collect($sortGetData)->where('status', 3)->toArray());
  $data['rejectedApplications']=count(collect($sortGetData)->where('status',6)->toArray());
  $data['my_team_employees']=count(collect($sortGetData)->where('employee_reporting_to', Auth::guard('user')->user()->employee_card_no)->where('project_id', $project_id)->toArray());

  return response()->json($data);
}


public function store(Request $request)
{
  $validate=[
    'unit_name'=>'required'
  ];

  $request->validate($validate);
  $data=$request->only('unit_name','unit_status','priority');

  if(!empty($request->id))
  {
    $update_data = UnitModel::valid()->project()->findOrFail($request->id);
    $data['updated_by'] = Auth::guard('user')->user()->branch_id;
    $save_data = $update_data->update($data);
    $message=['status' => 1, 'message' => 'Your data is successfully updated'];
  }
  else {
    $data['unit_code'] = $this->findMaxCode();
    $data['project_id'] = Auth::guard('user')->user()->project_id;
    $data['branch_id'] = Auth::guard('user')->user()->branch_id;
    $data['created_by'] = Auth::guard('user')->user()->id;
    $data['unit_status'] = 1;
    $save_data = UnitModel::create($data);
    $message=['status' => 1, 'message' => 'Your data is successfully saved'];
  }

  if(!$save_data)

  {
    $message=['status' => 0, 'message' => 'Ops! Something went worng.'];

  }
  return response($message);

}

public function destroy($id)
{

  // $delete_data=UnitModel::valid()->project()->findOrFail($id);
  if($id)
  {
    $delete = DB::connection('mysql2')->table('hr_stationary_summary')->where('id', $id)->delete();
    $delete1 = DB::connection('mysql2')->table('hr_stationary_details')->where('summary_primary_id', $id)->delete();
    $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
  }
  return response($message);

}


  public function getGeneralStationaryNo(){
    $last_entry_data = DB::connection('mysql2')->table('hr_stationary_summary')->where('branch_id', Auth::guard('user')->user()->branch_id)->where('valid', 1)->latest()->first();
    $dateString = date('Ymd'); //Generate a datestring.
    $branchNumber = Auth::guard('user')->user()->branch_id; //Get the branch number somehow.
    $stationery_code = $last_entry_data->id;
    if($stationery_code < 9999) {
      $stationery_code = $stationery_code + 1;
    }else{
      $stationery_code = 00001;
    }
    $stationer_no = 'GS'.$dateString.$branchNumber.$stationery_code;
    return $stationer_no;
  }

  public function send_general_stationery_request(Request $request){
    // return response($request);

    $validate = [
      'employee_id'=>'required',
      'product_item'=>'required',
    ];
    $request->validate($validate);
    $data= $request->only('employee_id');
    if(!empty($request->employee_id)){
      if($request->id){
        $delete = DB::connection('mysql2')->table('hr_stationary_summary')->where('id', $request->id)->delete();
        $delete1 = DB::connection('mysql2')->table('hr_stationary_details')->where('summary_primary_id', $request->id)->delete();
      }

      if(!empty($request->product_price) && count($request->product_price) > 0){
        $total_product_price = 0;
        foreach ($request->product_item as $key => $value) {
          $amount = $request->product_price[$key] * $request->product_qty[$key];
          $total_product_price += $amount;
        }
      }else{
        $total_product_price = 0;
      }
      $total_product = array_sum($request->product_qty);
      $stationery_number = $this->getGeneralStationaryNo();
      if(!empty($request->id)){
        $stationery_number = $request->stationery_no;
      }
      $employee_basic_info = Employee::valid()->where('id', $request->employee_id)->first();
      $employee_department_info = Department::valid()->where('id', $employee_basic_info->employee_department)->first();
      $employee_sbu_info = CompanySbu::valid()->where('id', $employee_basic_info->employee_sbu)->first();
      if(!empty($employee_basic_info->employee_reporting_to)){
        $employee_reporting_boss = Employee::valid()->select('id')->where('employee_id_no', $employee_basic_info->employee_reporting_to)->first();
      }else{
        $employee_reporting_boss = 0;
      }
      $data['stationery_no'] = $stationery_number;
      $data['employee_id_no'] = $employee_basic_info->employee_id_no;
      $data['employee_name'] = $employee_basic_info->employee_fullname;
      $data['emp_department_id'] = $employee_basic_info->employee_department;
      $data['department_head_id'] = $employee_reporting_boss->id ?? 0;
      $data['employee_reporting_id'] = $employee_reporting_boss->id ?? 0;
      $data['department_name'] = $employee_department_info->department_name;
      $data['emp_sbu_id'] = $employee_basic_info->employee_sbu;
      $data['sbu_name'] = $employee_sbu_info->sbu_name;
      $data['requestion_qty'] = $total_product;
      $data['stationary_remarks'] = $request->stationary_remarks;
      $data['total_amount'] = $total_product_price;
      $data['request_date'] = date('Y-m-d');
      // $data['request_by'] = $request->employee_id;
      $data['project_id'] = $request->project_id;
      $data['branch_id'] = Auth::guard('user')->user()->branch_id;
      $data['created_by'] = Auth::guard('user')->user()->id;
      $data['created_at'] = date('Y-m-d H:i:s');
      $data['status']=1;
      // $save_data=HrStationarySummary::create($data);
      // DB::table('hr_stationary_summary')->insert($data);
      $save_data = DB::connection('mysql2')->table('hr_stationary_summary')->insertGetId($data);

      if($save_data){
        $last_insert_id = $save_data;
        foreach ($request->product_item as $key =>$value):
          // return response($request->product_qty[$key]);
              $stationary_details = [
              'summary_primary_id'=> $last_insert_id,
              'product_id'=>$value,
              'requestion_qty'=> $request->product_qty[$key],
              'qty_unit_price'=> $request->product_price[$key],
              'request_by'=> $request->employee_id,
              'status'=>1,
              'project_id'=> $request->project_id,
              'branch_id'=>Auth::guard('user')->user()->branch_id,
              'created_by'=>Auth::guard('user')->user()->id,
              'created_at'=> date('Y-m-d H:i:s'),
              ];
              // HrStationaryDetails::create($stationary_details);
              $save_data = DB::connection('mysql2')->table('hr_stationary_details')->insert($stationary_details);
        endforeach;
      }else{
        $message=['status' => 0, 'message' => 'Ops! Something went worng.'];
      }
      $message=['status' => 1, 'message' => 'Your data is successfully saved'];
    }
    return response($message);
  }

  public function find_type_category_product($service_type = NULL){
    $data['inventory_product'] = DB::connection('mysql2')->table('inv_product')->where("project_id", 5)->where("valid", 1)->where('inv_product_type', 3)->get();
    $data['product_type'] = DB::connection('mysql2')->table('catgory_type')->where("id", 3)->where("valid", 1)->where('status', 1)->get();
    $data['product_category'] = DB::connection('mysql2')->table('inv_product_category')->where("project_id", 5)->where("valid", 1)->where('types', 3)->get();
    return $data;
  }

  public function find_pcategory_product_list($id = NULL){
    $data['inventory_product'] = DB::connection('mysql2')->table('inv_product')->where("project_id", 5)->where('category_id', $id)->get();
    return $data;
  }

  public function findGeneralStaioneryData($id = NULL){
    $data = DB::connection('mysql2')->table('hr_stationary_summary')->select('*')->where('id', $id)->get();
    $data['stationery_summary'] = DB::connection('mysql2')->table('hr_stationary_details')
    ->leftJoin('inv_product', 'inv_product.id', '=', 'hr_stationary_details.product_id')
    ->leftJoin('inv_product_category', 'inv_product_category.id', '=', 'inv_product.category_id')
    ->leftJoin('catgory_type', 'catgory_type.id', '=', 'inv_product.inv_product_type')
    ->select('hr_stationary_details.*', 'inv_product_category.category_name as category_text', 'inv_product_category.id as category_id', 'catgory_type.catgory_name as type_text', 'catgory_type.id as type_id', 'inv_product.inv_product_name as item_text', 'inv_product.unit_name')->where('summary_primary_id', $id)->get()->toArray();
    $data['inventory_product'] = DB::connection('mysql2')->table('inv_product')->where("project_id", 5)->where("valid", 1)->where('inv_product_type', 3)->get();
    $data['product_type'] = DB::connection('mysql2')->table('catgory_type')->where("id", 3)->where("valid", 1)->where('status', 1)->get();
    $data['product_category'] = DB::connection('mysql2')->table('inv_product_category')->where("project_id", 5)->where("valid", 1)->where('types', 3)->get();
    return $data;
  }

  public function edit($id)
  {
    $data = DB::connection('mysql2')->table('hr_stationary_summary')->select('*')->where('id', $id)->get();
    // return response($data);

    $user_employee_data = Employee::valid()->project()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
      ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
      ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
      ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
      ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
      ->select(
        'employees.*',
        'company_sbus.sbu_name',
        'sections.section_name',
        'departments.department_name',
        'designations.designation_name',
        'sub_units.sub_unit_name',
        'work_locations.work_location_name'
      )
      ->where('employees.id', $data[0]->employee_id)->first();
    $data['user_employee_data'] = $user_employee_data;
    $data['product_details_data'] =  DB::connection('mysql2')->table('hr_stationary_details')
      ->leftJoin('hr_stationary_summary','hr_stationary_details.summary_primary_id','=','hr_stationary_summary.id')
      ->leftJoin('inv_product','hr_stationary_details.product_id','=','inv_product.id')
      ->leftJoin('inv_product_category','inv_product.category_id','=','inv_product_category.id')
      ->leftJoin('catgory_type','inv_product.inv_product_type','=','catgory_type.id')
      ->select('hr_stationary_details.*', 'catgory_type.catgory_name as type_name', 'inv_product_category.category_name', 'inv_product.inv_product_name', 'hr_stationary_summary.stationary_remarks', 'hr_stationary_details.requestion_qty as request_qty')
      ->where('hr_stationary_details.summary_primary_id', $id)
      ->where('hr_stationary_details.valid', 1)
      ->get();
    $data['derptment_approve_id'] = isset($data[0]->derptment_approve_id) ? $data[0]->derptment_approve_id : '';
    $data['hr_approve_id'] = isset($data[0]->hr_approve_id) ? $data[0]->hr_approve_id : '';
    $data['stationery_no'] = isset($data[0]->stationery_no) ? $data[0]->stationery_no : '';
    $data['stationary_remarks'] = isset($data[0]->stationary_remarks) ? $data[0]->stationary_remarks : '';
    $data['employee_id'] = isset($data[0]->employee_id) ? $data[0]->employee_id : '';
    $data['id'] = isset($data[0]->id) ? $data[0]->id : '';
    $data['status'] = isset($data[0]->status) ? $data[0]->status : '';
    $data['approve_by_user'] = Auth::guard('user')->user()->id;
    $data['hod_comments'] = isset($data[0]->hod_comments) ? $data[0]->hod_comments : '';
    $data['hr_comments'] = isset($data[0]->hr_comments) ? $data[0]->hr_comments : '';
    $hod_id = isset($data[0]->derptment_approve_id) ? $data[0]->derptment_approve_id : '';
    $hr_id = isset($data[0]->hr_approve_id) ? $data[0]->hr_approve_id : '';
    $deliver_id = isset($data[0]->delivery_by_id) ? $data[0]->delivery_by_id : '';
    $hod_info = Employee::valid()->leftJoin('users_person', 'users_person.employee_id', '=', 'employees.id')->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')->select(
      'employees.employee_fullname',
      'company_sbus.sbu_name',
      'departments.department_name',
    )->where('employees.id', $hod_id)->first();
    $hr_info = Employee::valid()->leftJoin('users_person', 'users_person.employee_id', '=', 'employees.id')->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')->select(
      'employees.employee_fullname',
      'company_sbus.sbu_name',
      'departments.department_name',
    )->where('employees.id', $hr_id)->first();
    $deliver_info = DB::connection('mysql2')->table('inv_sales_person')->select(
      'inv_sales_person.name as employee_fullname'
    )->where('inv_sales_person.id', $deliver_id)->first();
    $data['hod_employee_fullname'] = isset($hod_info->employee_fullname) ? $hod_info->employee_fullname : '';
    $data['hod_sbu_name'] = isset($hod_info->sbu_name) ? $hod_info->sbu_name : '';
    $data['hod_department_name'] = isset($hod_info->department_name) ? $hod_info->department_name : '';
    $data['hr_employee_fullname'] = isset($hr_info->employee_fullname) ? $hr_info->employee_fullname : '';
    $data['hr_sbu_name'] = isset($hr_info->sbu_name) ? $hr_info->sbu_name : '';
    $data['hr_department_name'] = isset($hr_info->department_name) ? $hr_info->department_name : '';
    $data['deliver_employee_fullname'] = isset($deliver_info->employee_fullname) ? $deliver_info->employee_fullname : '';
    return response($data);
  }

  public function approveOrReject1(Request $request){
    // return response($request);
      $id = $request->id;
      $employee_id = $request->employee_id;
      if($request->approve_by_menu == 1){
        $hod_user_id = $request->approve_by_user;
        $status = 2;
        $hod_comments = $request->approval_comments;
        $message=['status' => 1, 'message' => 'Request forwarded!'];
      }else{
        $hr_user_id = $request->approve_by_user;
        $status = 3;
        $hr_comments = $request->approval_comments;
        $message=['status' => 1, 'message' => 'Request approved!'];
      }
      if($request->approve_reject_status == 3){
        $status = 6;
        $message=['status' => 1, 'message' => 'Request rejected!'];
      }
      $total_product_qty = 0;
      foreach ($request->product_details_data as $key => $value) {
        $total_product_qty += $value['requestion_qty'];
      }


      $data['total_approve_qty'] = $total_product_qty;
      $data['derptment_approve_id'] = isset($hod_user_id) ? $hod_user_id : NULL;
      $data['hr_approve_id'] = isset($hr_user_id) ? $hr_user_id : NULL;
      $data['dh_date_time'] = date("Y-m-d H:i:s");
      $data['ha_date_time'] = date("Y-m-d H:i:s");
      $data['status'] = $status;
      $data['hod_comments']= $hod_comments ?? '';
      $data['hr_comments']= $hr_comments ?? '';
      $data['updated_by'] = Auth::guard('user')->user()->id;
      $data['updated_at'] = date("Y-m-d H:i:s");
      $udate_data = DB::connection('mysql2')->table('hr_stationary_summary')->where('id', $id)->update($data);
      foreach ($request->product_details_data as $key => $value) {
        $s_data['approve_qty'] = $value['requestion_qty'];
        $s_data['derptment_approve_id'] = isset($hod_user_id) ? $hod_user_id : NULL;
        $s_data['hr_approve_id'] = isset($hr_user_id) ? $hr_user_id : NULL;
        $s_data['dh_date_time'] = date("Y-m-d H:i:s");
        $s_data['ha_date_time'] = date("Y-m-d H:i:s");
        $s_data['status']= $status;
        $s_data['updated_by'] = Auth::guard('user')->user()->id;
        $s_data['updated_at'] = date("Y-m-d H:i:s");
        $udate_data = DB::connection('mysql2')->table('hr_stationary_details')->where('summary_primary_id', $id)->where('product_id', $value['product_id'])->update($s_data);
      }
      return response($message);

  }

  public function approveOrReject(Request $request){
    // return response($request);
      $id = $request->id;
      $employee_id = $request->employee_id;
      if($request->approve_by_menu == 1){
        $hod_user_id = $request->approve_by_user;
        $status = 2;
        $hod_comments = $request->approval_comments;
        $message=['status' => 1, 'message' => 'Request forwarded!'];
      }else{
        $hod_user_id = $request->derptment_approve_id;
        $hr_user_id = $request->approve_by_user;
        $status = 3;
        $hr_comments = $request->approval_comments;
        $message=['status' => 1, 'message' => 'Request approved!'];
      }
      if($request->approve_reject_status == 3){
        $hod_user_id = $request->derptment_approve_id;
        $status = 6;
        $message=['status' => 1, 'message' => 'Request rejected!'];
      }
      $total_product_qty = 0;
      foreach ($request->product_details_data as $key => $value) {
        $total_product_qty += $value['requestion_qty'];
        if($value['requestion_qty'] > $value['request_qty']){
          $message=['status' => 0, 'message' => 'Approve qty ('.$value['inv_product_name'].') can`t exceed than request qty!'];
          return response($message);
        }
      }

      $data['total_approve_qty'] = $total_product_qty;
      $data['derptment_approve_id'] = isset($hod_user_id) ? $hod_user_id : NULL;
      $data['hr_approve_id'] = isset($hr_user_id) ? $hr_user_id : NULL;
      $data['dh_date_time'] = date("Y-m-d H:i:s");
      $data['ha_date_time'] = date("Y-m-d H:i:s");
      $data['status'] = $status;
      $data['hod_comments']= $hod_comments ?? '';
      $data['hr_comments']= $hr_comments ?? '';
      $data['updated_by'] = Auth::guard('user')->user()->id;
      $data['updated_at'] = date("Y-m-d H:i:s");
      $udate_data = DB::connection('mysql2')->table('hr_stationary_summary')->where('id', $id)->update($data);
      foreach ($request->product_details_data as $key => $value) {
        $s_data['approve_qty'] = $value['requestion_qty'];
        $s_data['derptment_approve_id'] = isset($hod_user_id) ? $hod_user_id : NULL;
        $s_data['hr_approve_id'] = isset($hr_user_id) ? $hr_user_id : NULL;
        $s_data['dh_date_time'] = date("Y-m-d H:i:s");
        $s_data['ha_date_time'] = date("Y-m-d H:i:s");
        $s_data['status']= $status;
        $s_data['updated_by'] = Auth::guard('user')->user()->id;
        $s_data['updated_at'] = date("Y-m-d H:i:s");
        $udate_data = DB::connection('mysql2')->table('hr_stationary_details')->where('summary_primary_id', $id)->where('product_id', $value['product_id'])->update($s_data);
      }
      return response($message);

  }

}
