<?php
namespace App\Http\Controllers\payroll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\payroll\BundleSetting;
use App\Model\CompanySbu;
use App\Model\Employee;
use Cache;
use permission;
class BundleSettingController extends Controller
{
    public function index(Request $request){
    $cache=Cache::get('permission');
    $permission=collect($cache)->where('menu_uid','=','BundleSetting')->where('role_id',Auth::guard('user')->user()->role_id)->toArray();
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
        $order = 'ASC';
        $sort = 'priority';
    } else {
        $order = $request->input('order');
        $sort = $request->input('sort');
    }
    $project_id=Auth::guard('user')->user()->project_id;
    $branch_id=Auth::guard('user')->user()->branch_id;
    $paginate_data =BundleSetting::valid()->project()->when($search_key, function($query, $search_key){
        $query->where(function($query2)use($search_key){
        $query2->where('bundle_name','LIKE','%'.$search_key.'%');
        });
        return $query;
    })->where('project_id',$project_id)->orderBy($sort,$order);
    $sortData=$paginate_data;
    $sortGetData=$sortData->get();
    $data['total_data']=count($sortGetData);
    $data['inactive_data']=count(collect($sortGetData)->whereIn('bundle_status',2)->toArray());
    $data['active_data']=count(collect($sortGetData)->where('bundle_status',1)->toArray());
    $data['paginate_data'] =$sortData->paginate($paginate_num);
    return response()->json($data);
    }

    public function create(){

    }

    public function store(Request $request)
    {
        $validate=[
            'bundle_name'=>'required'
        ];
        $request->validate($validate);
        $data=$request->only('sbu_id','bundle_name','bundle_status','priority');
    if(!empty($request->id))
    {
        $update_data=BundleSetting::valid()->project()->orderBy('priority', 'ASC')->findOrFail($request->id);
        $data['updated_by']=Auth::guard('user')->user()->id; 
        $data['updated_at']= date('Y-m-d H:i:s');
        $data['sbu_id']= $request->sbu_id;
        $save_data=$update_data->update($data);
        $message=['status' => 1, 'message' => 'Your data is successfully updated'];
    }
    else {
        $data['bundle_code'] = $this->findMaxCode();
        $data['sbu_id']=Auth::guard('user')->user()->company_sbu;
        $data['project_id']=Auth::guard('user')->user()->project_id;
        $data['branch_id']=Auth::guard('user')->user()->branch_id; 
        $data['created_by']=Auth::guard('user')->user()->id; 
        $data['bundle_status']=1; 
        // $save_data = '';
        $save_data=BundleSetting::create($data);
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
        $edit_data=BundleSetting::valid()->project()->orderBy('priority', 'ASC')->findOrFail($id);
        $companysbu_data_list=CompanySbu::valid()->project()->whereIn('id',$employee_ids['sub'])->get()->keyBy('id')->all();
        if(!$edit_data->sbu_id){
            $edit_data->sbu_name_value = ['id'=>'','text'=>'']; 
        }else{
            $edit_data->sbu_name_value = ['id'=>$edit_data->sbu_id,'text'=>$companysbu_data_list[$edit_data->sbu_id]->sbu_name];
        }
        $company_sbu_data=array();
        array_push($company_sbu_data,['id'=>'','text'=>'Deselect']);
        foreach ($companysbu_data_list as $value) {
          array_push($company_sbu_data,['id'=>$value['id'],'text'=>$value['sbu_name']]);
        }
        $edit_data->company_sbu_data =  $company_sbu_data;
        return response($edit_data);
    }

    public function destroy($id)
    {
        $delete_data=BundleSetting::valid()->project()->orderBy('priority', 'ASC')->findOrFail($id);
        if($delete_data->delete())
        {
            $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
        }
        return response($message);
    }

    public function findMaxCode(){
        $last_entry_data=BundleSetting::latest()->first();
        // return response($last_entry_data);
        $last_code = isset($last_entry_data['bundle_code']) ? $last_entry_data['bundle_code'] : 0;
        if ($last_code==0) {
            $last_code = 101;
        }else{
            $last_code = $last_code+1;
        }
        return $last_code;
    }
}
