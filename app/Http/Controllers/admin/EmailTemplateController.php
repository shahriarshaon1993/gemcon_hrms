<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\EmailTemplate;
use App\Model\EmailTemplateCCInfo;
use App\Model\CompanySbu;
use App\Model\Employee;
use Cache;
use Auth;
use DB;

class EmailTemplateController extends Controller
{
    public function index(Request $request){

      // dd(Auth::guard('admin')->user()->role_id);
      $paginate_num = $request->input('paginate_num');
      $search_key = $request->input('search_key');
      // $order = $request->input('order');
      $order = 'ASC';
      $sort = $request->input('sort');
      // $project_id=Auth::guard('admin')->user()->project_id;
      // $branch_id=Auth::guard('admin')->user()->branch_id;
      // $employee_list = new Employee();
      // $employee_ids=$employee_list->Employee_id();
      $cache=Cache::get('permission');
      $permission=collect($cache)->where('menu_uid','=','EmailTemplates')->where('role_id',Auth::guard('admin')->user()->role_id)->toArray();
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
  

      $paginate_data =EmailTemplate::valid()->when($search_key, function($query, $search_key){
        $query->where(function($query2)use($search_key){
          $query2->where('subject','LIKE','%'.$search_key.'%');
        });
        return $query;

      }) 
      // ->orderBy()
      ->orderBy($sort,$order);
      // ->paginate($paginate_num);

      $sortData=$paginate_data;
     
      $sortGetData=$sortData->get();
      $data['total_data']=count($sortGetData);
      $data['inactive_data']=count(collect($sortGetData)->whereIn('status',2)->toArray());
      $data['active_data']=count(collect($sortGetData)->where('status',1)->toArray());

      $data['paginate_data'] =$sortData->paginate($paginate_num);
      return response()->json($data);
    }

    public function store(Request $request)
    {
      // echo "sf"; die();

      // return response($request);
      
      $validate=[
        'subject'=>'required'
      ];

      $request->validate($validate);
      $data=$request->only('template_name','subject','status','email_body','email_bcc');
      $company_ids = collect($request->sbu_name_value)->pluck('id')->toArray();
      $company_ids = implode (",", $company_ids);

      $employee_cc_id = collect($request->employee_name_value)->pluck('id')->toArray();
      // $employee_cc_id = implode (",", $employee_cc_id);
      // return response($request->employee_name_value);

      $employee_wise_cc = collect($request->employee_name_value)->pluck('email_address')->toArray();

      // dd($employee_wise_cc);

      // $employee_wise_cc = implode (",", $employee_wise_cc);
      // return response($company_ids);
      if(!empty($request->id))
      {
        $update_data=EmailTemplate::valid()->findOrFail($request->id);
        $data['company_id'] = $company_ids; 
        $data['email_cc'] = $request->email_cc; 
        // $data['employee_wise_cc'] = $employee_wise_cc; 
        // $data['employee_cc_id'] = $employee_cc_id; 
        $data['updated_by']=Auth::guard('admin')->user()->branch_id; 
        $data['updated_at']= date('Y-m-d H:i:s'); 
        $save_data=$update_data->update($data);

        // dd($request->id);
        EmailTemplateCCInfo::where('email_template_id', $request->id)->delete();
        $et_cc_info=[];
        foreach($request->employee_name_value as $key=>$value){
            $input['company_id'] = $value['employee_sbu'];
            $input['email_template_id'] = $request->id;
            $input['employee_cc_id'] = $value['id'];
            $input['employee_wise_cc'] = $value['email_address'];
            $input['status'] = 1;
            $input['created_at'] = date('Y-m-d H:i:s');
            $input['created_by'] = Auth::guard('admin')->user()->id;
            $add_product = EmailTemplateCCInfo::updateOrCreate(
              [
                'email_template_id' => $request->id,
                'employee_cc_id' => $value['id'],
              ]
            , $input);

        }

        // EmailTemplateCCInfo::where('email_template_id', $request->id)->update($et_cc_info);
        // EmailTemplateCCInfo::insert($et_cc_info);
        
        // $save_data=DB::table('email_templates_cc_info')->where('email_template_id')->udpate($et_cc_info);
       

        

        $message=['status' => 1, 'message' => 'Your data is successfully updated'];
      }
      else {
        // $data['designation_code'] = $this->findMaxCode();
        $data['company_id'] = $company_ids; 
        $data['email_cc'] = $request->email_cc; 
        // $data['employee_wise_cc'] = $employee_wise_cc; 
        // $data['employee_cc_id'] = $employee_cc_id; 
        $data['project_id']=Auth::guard('admin')->user()->project_id;
        $data['branch_id']=Auth::guard('admin')->user()->branch_id; 
        $data['created_by']=Auth::guard('admin')->user()->id; 
        $data['created_at']= date('Y-m-d H:i:s'); 
        $data['status']=1; 
        $save_data=EmailTemplate::create($data);

        $et_cc_info=[];
        foreach($employee_cc_id as $key=>$value){
            $et_cc_info[]=[
                'email_template_id' => $save_data->id,
                'employee_cc_id' => $value,
                'employee_wise_cc' => $employee_wise_cc[$key],
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => Auth::guard('admin')->user()->id,
            ];
        }
        $save_data=DB::table('email_templates_cc_info')->insert($et_cc_info);
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
      $edit_data = EmailTemplate::valid()
      ->findOrFail($id);

      $template_cc_data = DB::table('email_templates_cc_info')->where('email_template_id', $id)->get();
      $employee_cc_ids = collect($template_cc_data)->pluck('employee_cc_id')->toArray();

      $company_sbu_data = array();
      $employee_data = array();
      $company_sbu_data_list = CompanySbu::valid()->select('id', 'sbu_name', 'sbu_short_name')->get();
      $employee_data_list = Employee::valid()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->select('employees.id', 'employee_id_no', 'employee_fullname', 'employee_sbu','official_email_id', 'sbu_name')->orderBy('employee_fullname', 'asc')->get();

      // $employee_cc_ids = explode(",", $edit_data->employee_cc_id);
      $selected_employee_list = Employee::valid()
      ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
      ->select(
        'employees.id as id',
        'employees.employee_sbu',
        DB::raw("CONCAT(employee_id_no,'-',employee_fullname,'-',sbu_name,'-',official_email_id) AS text"),
        'official_email_id as email_address',
      // 'employee_id_no', 'employee_fullname', 'official_email_id', 'sbu_name'
      )
      ->whereIn('employees.id', $employee_cc_ids)->get();
      $edit_data->employee_name_value = $selected_employee_list;

      $company_ids = explode(",", $edit_data->company_id);
      $selected_sbu_data_list = CompanySbu::valid()->select('id', 'sbu_name as text')->whereIn('id', $company_ids)->get();
      $edit_data->sbu_name_value = $selected_sbu_data_list;

      foreach ($company_sbu_data_list as $value) {
        array_push($company_sbu_data, [
          'id' => $value['id'],
          'text' => $value['sbu_name']
        ]);
      }
      foreach ($employee_data_list as $value) {
        array_push($employee_data, [
          'id' => $value['id'],
          'text' => $value['employee_id_no'].'-'.$value['employee_fullname'].'-'.$value['sbu_name'].'-'.$value['official_email_id'],
          'email_address' => $value['official_email_id'],
          'employee_sbu' => $value['official_email_id']
        ]);
      }
      $edit_data->employee_data =  $employee_data;
      $edit_data->company_sbu_data =  $company_sbu_data;
      return response($edit_data);

    }

    public function destroy($id)
    {

      $delete_data=EmailTemplate::valid()->findOrFail($id);
      if($delete_data->delete())
      {
        $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
      }
      return response($message);

    }

    public function findMaxCode(){
      $last_entry_data=EmailTemplate::latest()->first();
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
      $last_entry_data=EmailTemplate::max('priority');
      $last_code = $last_entry_data;
      if ($last_code==0) {
        $last_code = 1;
      }else{
        $last_code = $last_code+1;
      }
      return $last_code;
    }

}
