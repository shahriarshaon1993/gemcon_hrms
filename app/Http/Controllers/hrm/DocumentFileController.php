<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
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
use App\Model\Employee;
use App\Model\DocumentFile;
use App\Model\FileType;
use App\Model\DocumentCategory;
use App\Model\DocumentFolder;
use App\Model\DocFolderPermission;
use Cache;
use DB;
use permission;

class DocumentFileController extends Controller
{
    public function index(Request $request){
      $paginate_num = $request->input('paginate_num');
      $search_key = $request->input('search_key');
      $order = $request->input('order');
      $sort = $request->input('sort');
      $project_id=Auth::guard('user')->user()->project_id;
      $branch_id=Auth::guard('user')->user()->branch_id;

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
      

        // echo "<pre>";
        // print_r($DocumentFile);
        // exit();


      $paginate_data =DocumentFile::valid()->project()->when($search_key, function($query, $search_key){
        $query->where(function($query2)use($search_key){
          $query2->where('file_name','LIKE','%'.$search_key.'%');
        });
        return $query;

      })->where('project_id',$project_id) ->orderBy('priority','ASC') ->orderBy($sort,$order);
      // ->paginate($paginate_num);
      $sortData=$paginate_data;


      $data['paginate_data'] =$sortData->paginate($paginate_num);
      $sortGetData=$sortData->get();
      $data['total_data']=count($sortGetData);
      $data['inactive_data']=count(collect($sortGetData)->whereIn('file_status',0)->toArray());
      $data['active_data']=count(collect($sortGetData)->where('file_status',1)->toArray());

      // return response()->json($data);
      return response()->json($data);
    }

    public function store(Request $request)
    {

      $validate=[
        'file_attachment'=>'required'
      ];
      $request->validate($validate);
      $data=$request->only('file_status','expiration_date','email_notify','file_attachment','folder_id','file_permission_to','sbu_id','department_id','unit_id','subunit_id','section_id','subsection_id','employee_id','file_name');

      // 'file_name',
      // 'notification_period',
      if ($request->file_attachment) {
        $document = $request->file_attachment;
      }else{
        $document ='';
      }
       if(!empty($document)){
         $exploded=explode(',',$document);
         if(strlen($request->file_attachment) >=800){
         $decoded = base64_decode($exploded[1]);
         $exploded1=explode(';',$exploded[0]);
         $exploded2=explode('/',$exploded1[0]);
        

           if(str_contains($exploded2[1],'jpeg')){
               $str_contains='jpeg';
           }elseif(str_contains($exploded2[1],'pdf')){
              $str_contains='pdf';
           }
           elseif(str_contains($exploded2[1],'doc')){
                $str_contains='doc';
           }
           elseif(str_contains($exploded2[1],'docx')){
                $str_contains='docx';
           }
           else{
               $str_contains='png';
           }
         $fileName=str_random().'.'.$str_contains;
         $path=public_path().'/document_file/'.$fileName;
         file_put_contents( $path,$decoded);
         $data['file_attachment']=$fileName;
         $filesize = filesize($path); // bytes
         $data['file_size']=$filesize;
        }
      }else{
        $data['file_attachment']='';
      }
      $permissionInfo=collect($request->approval_infos)->where('permission_id','!=','')->toArray();
      if(!empty($request->id))
      {
        $update_data=DocumentFile::valid()->project()->findOrFail($request->id);
        $data['updated_by']=Auth::guard('user')->user()->id; 
        $data['updated_at']=date('Y-m-d h:m:s'); 
        // $save_data=$update_data->update($data);
        DB::table('doc_folder_permissions')->where('folder_id', '=', $request->id)->delete();
        if(!empty($permissionInfo)){
          $save_data=$update_data->update($data);
          $permissionInfodata=[];
          foreach ($permissionInfo as $key => $value) {
            $permissionInfodata[]=[
              'folder_id'=>$request->id, 
              'permission_id'=>$value['permission_id'],
              'permission_set'=>2,
              'permission_type_name'=>$value['permission_type_name'], 
              'permission_type'=>$value['permission_type'], 
              'permission_id_name'=>$value['permission_id_name'],
              'project_id'=>Auth::guard('user')->user()->project_id,
              'branch_id'=>Auth::guard('user')->user()->branch_id,
              'created_by'=>Auth::guard('user')->user()->id,
            ];
          }
          $saveData=DocFolderPermission::insert($permissionInfodata);

        }else{
           $save_data=$update_data->update($data);
        }
        if ($save_data) {
          app(FileAccessLogController::class)->veiw_or_download($request->id,$type=3);
        }
        $message=['status' => 1, 'message' => 'Your data is successfully updated'];
      }
      else {
        // $data['designation_code'] = $this->findMaxCode();
        $data['project_id']=Auth::guard('user')->user()->project_id;
        $data['branch_id']=Auth::guard('user')->user()->branch_id; 
        $data['created_by']=Auth::guard('user')->user()->id; 
        $data['file_status']=1; 
        // $data['file_name']=$fileName; 
        $data['notification_period']=15; 
        // $data['permission_set']=2; 
        $save_data=DocumentFile::create($data);
        if(!empty($permissionInfo)){
          // $save_data=DocumentFolder::create($data);
          $permissionInfodata=[];
          foreach ($permissionInfo as $key => $value) {
            $permissionInfodata[]=[
              'folder_id'=>$save_data->id, 
              'permission_id'=>$value['permission_id'],
              'permission_type_name'=>$value['permission_type_name'], 
              'permission_type'=>$value['permission_type'], 
              'permission_id_name'=>$value['permission_id_name'],
              'permission_set'=>2,
              'project_id'=>Auth::guard('user')->user()->project_id,
              'branch_id'=>Auth::guard('user')->user()->branch_id,
              'created_by'=>Auth::guard('user')->user()->id,
            ];
          }
          $saveData=DocFolderPermission::insert($permissionInfodata);
        }
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
      $data=DocumentFile::valid()->project()->findOrFail($id);
      $file_type_list=FileType::valid()->project()->get()->keyBy('id')->all();
      if(!$data->file_type){
        $data->file_type_value = ['id'=>'','text'=>'']; 
      }else{
        $data->file_type_value = ['id'=>$data->file_type,'text'=>$file_type_list[$data->file_type]->type_name];
      }

      $file_type_data=array();
      
      foreach ($file_type_list as $value) {
        array_push($file_type_data,['id'=>$value['id'],'text'=>$value['type_name']]);
      }
      $data->file_type_data =  $file_type_data;
      


      $companysbu_data_list=CompanySbu::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
      $section_data_list=Section::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
      $sub_section_data_list=SubSection::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
      $employee_group_data_list=EmployeeGroup::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
      $department_list=Department::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
      $designation_data_list=Designation::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
      $jobgrade_data_list=JobGrade::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
      $employee_data_list=Employee::valid()->project()->get()->keyBy('id')->all();
      $employee_reporting=Employee::valid()->project()->get()->keyBy('employee_id_no')->all();
      $sub_unit_data_list=SubUnit::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
      $unit_data_list=UnitModel::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
      $work_location_data_list=WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();

      $DocumentFile=DocumentFolder::valid()->project()->where('folder_status',1)->orderBy('priority', 'ASC')->get()->toArray();
      $DocumentFilesId=collect($DocumentFile)->pluck('id')->toArray();
      $noticesPasmition=DocFolderPermission::valid()->project()->where('permission_set',1)->whereIn('folder_id',$DocumentFilesId)->orderBy('priority', 'ASC')->get();
        foreach ($DocumentFile as $key => $value) {
            $noticesid=collect($noticesPasmition)->where('folder_id',$value['id'])->toArray();
                    // return response()->json($noticesid);

            if(!empty($noticesid)){
                foreach ($noticesid as $key => $value){
                    if($value['permission_type']==1 && $value['permission_id']==Auth::guard('user')->user()->company_sbu){
                        $DocumentFile[$key]['access']=1;

                    }elseif ($value['permission_type']==2 && $value['permission_id']==Auth::guard('user')->user()->department) {
                       $DocumentFile[$key]['access']=1;
                    }elseif ($value['permission_type']==3 && $value['permission_id']==Auth::guard('user')->user()->unit) {
                        $DocumentFile[$key]['access']=1;
                    }elseif ($value['permission_type']==4 && $value['permission_id']==Auth::guard('user')->user()->sub_unit) {
                        $DocumentFile[$key]['access']=1;
                    }elseif ($value['permission_type']==5 && $value['permission_id']==Auth::guard('user')->user()->section) {
                        $DocumentFile[$key]['access']=1;
                    }elseif ($value['permission_type']==6 && $value['permission_id']==Auth::guard('user')->user()->sub_section) {
                        $DocumentFile[$key]['access']=1;
                    }elseif ($value['permission_type']==7 && $value['permission_id']==Auth::guard('user')->user()->employee_card_no) {
                        $notices[$key]['access']=1;
                    }else{
                        $DocumentFile[$key]['access']=0;
                    }
                }
            }else{
                $DocumentFile[$key]['access']=1;
            }
        }
         
      $folder_list_data_list=collect($DocumentFile)->where('access',1)->keyBy('id')->all();

      // $folder_list_data_list=DocumentFolder::valid()->project()->get()->keyBy('id')->all();
      if(!$data->folder_id){
        $data->folder_name_value = ['id'=>'','text'=>'']; 
      }else{
        $data->folder_name_value = ['id'=>$data['folder_id'],'text'=>$folder_list_data_list[$data['folder_id']]['folder_name']];
      }

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
      $folder_list_data=array();
      

      foreach ($folder_list_data_list as $value) {
        array_push($folder_list_data,['id'=>$value['id'],'text'=>$value['folder_name']]);
      } 

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

      $approvalInfos=DocFolderPermission::valid()->project()->where('folder_id',$id)->get();
    // return response($approvalInfos);
      if(!empty($approvalInfos)){
        $data->approval_infos=$approvalInfos;
      }else{
         $date->approval_infos=['0' =>['id'=>0,'permission_type'=>'','permission_id'=>'']];
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
      $data->folder_list_data =  $folder_list_data;
      return response($data);

    }

    public function hard_destroy($id)
    {

      $delete_data=DocumentFile::valid()->project()->findOrFail($id);
      if($delete_data->delete())
      {
        $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
        app(FileAccessLogController::class)->veiw_or_download($id,$type=4);
      }
      return response($message);
    }

    public function destroy($id)
    {
      $delete_data=DocumentFile::valid()->project()->findOrFail($id);
      $data['updated_by']=Auth::guard('user')->user()->id; 
      $data['valid']=0; 
      $save_data=$delete_data->update($data);
      if($save_data)
      {
        $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
        app(FileAccessLogController::class)->veiw_or_download($id,$type=4);
      }
      return response($message);
    }
    

    public function findMaxCode(){
      $last_entry_data=DocumentFile::latest()->first();
      $last_code = $last_entry_data['designation_code'];
      if ($last_code==0) {
        $last_code = 101;
      }else{
        $last_code = $last_code+1;
      }
      return $last_code;
    }

    public function create(){
      
      $data['file_type_data']=array();
      $file_type=FileType::valid()->project()->get();
      foreach ($file_type as $value) {
        array_push($data['file_type_data'],['id'=>$value['id'],'text'=>$value['type_name']]);
      }
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
      $data['folder_list_data']=array();

      $company_sbu_data=CompanySbu::valid()->project()->orderBy('priority', 'ASC')->get();
      $section_data=Section::valid()->project()->orderBy('priority', 'ASC')->get();
      $sub_section_data=SubSection::valid()->project()->orderBy('priority', 'ASC')->get();
      $department_data=Department::valid()->project()->orderBy('priority', 'ASC')->get();
      $designation_data=Designation::valid()->project()->orderBy('priority', 'ASC')->get();
      $jobgrade_data=JobGrade::valid()->project()->orderBy('priority', 'ASC')->get();
      $employee_data_approval=Employee::valid()->project()->get();
      $employee_data=Employee::valid()->project()->get()->keyBy('id')->all();
      $unit_data=UnitModel::valid()->project()->orderBy('priority', 'ASC')->get();
      $sub_unit_data=SubUnit::valid()->project()->orderBy('priority', 'ASC')->get();
      $work_location_data=WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get();
      $employee_group_data=EmployeeGroup::valid()->project()->orderBy('priority', 'ASC')->get();


      $DocumentFile=DocumentFolder::valid()->project()->where('folder_status',1)->orderBy('priority', 'ASC')->get()->toArray();
      $DocumentFilesId=collect($DocumentFile)->pluck('id')->toArray();
      $noticesPasmition=DocFolderPermission::valid()->project()->where('permission_set',1)->whereIn('folder_id',$DocumentFilesId)->orderBy('priority', 'ASC')->get();
        foreach ($DocumentFile as $key => $value) {
            $noticesid=collect($noticesPasmition)->where('folder_id',$value['id'])->toArray();
                    // return response()->json($noticesid);

            if(!empty($noticesid)){
                foreach ($noticesid as $key => $value){
                    if($value['permission_type']==1 && $value['permission_id']==Auth::guard('user')->user()->company_sbu){
                        $DocumentFile[$key]['access']=1;

                    }elseif ($value['permission_type']==2 && $value['permission_id']==Auth::guard('user')->user()->department) {
                       $DocumentFile[$key]['access']=1;
                    }elseif ($value['permission_type']==3 && $value['permission_id']==Auth::guard('user')->user()->unit) {
                        $DocumentFile[$key]['access']=1;
                    }elseif ($value['permission_type']==4 && $value['permission_id']==Auth::guard('user')->user()->sub_unit) {
                        $DocumentFile[$key]['access']=1;
                    }elseif ($value['permission_type']==5 && $value['permission_id']==Auth::guard('user')->user()->section) {
                        $DocumentFile[$key]['access']=1;
                    }elseif ($value['permission_type']==6 && $value['permission_id']==Auth::guard('user')->user()->sub_section) {
                        $DocumentFile[$key]['access']=1;
                    }elseif ($value['permission_type']==7 && $value['permission_id']==Auth::guard('user')->user()->employee_card_no) {
                        $notices[$key]['access']=1;
                    }else{
                        $DocumentFile[$key]['access']=0;
                    }
                }
            }else{
                $DocumentFile[$key]['access']=1;
            }
        }
         
      $folder_list_data=collect($DocumentFile)->where('access',1)->toArray();

      // $folder_list_data=DocumentFolder::valid()->project()->whereIn('id',$DocumentFiles)->get();

      foreach ($folder_list_data as $value) {
        array_push($data['folder_list_data'],['id'=>$value['id'],'text'=>$value['folder_name']]);
      } 
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

      $data['approval_infos']=['0' =>['id'=>0,'permission_type'=>'','permission_id'=>'']];

      $data['priority'] = $this->findPriority();
      return response($data);
    }

    public function findPriority(){
      $last_entry_data=DocumentFile::max('priority');
      $last_code = $last_entry_data;
      if ($last_code==0) {
        $last_code = 1;
      }else{
        $last_code = $last_code+1;
      }
      return $last_code;
    }

}
