<?php
namespace App\Http\Controllers\hrm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\DocumentFile;
use App\Model\FileType;
use App\Model\FileAccessLog;
use Cache;
use DB;
use permission;

class FileAccessLogController extends Controller
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
  

      $paginate_data =FileAccessLog::project()
        ->leftJoin('document_files', 'document_files.id', '=', 'file_access_log.file_id')
        ->leftJoin('file_types', 'file_types.id', '=', 'document_files.file_type')
        ->leftJoin('employees', 'employees.id', '=', 'file_access_log.employee_id')
        ->select(
          'file_access_log.*',
          'document_files.file_name',
          'file_types.type_name',
          'employees.employee_id_no',
          'employees.employee_fullname'
        )
        ->when($search_key, function($query, $search_key){
        $query->where(function($query2)use($search_key){
          $query2->where('file_name','LIKE','%'.$search_key.'%');
        });
        return $query;

      })->where('file_access_log.project_id',$project_id) ->orderBy('file_access_log.priority','ASC') ->orderBy($sort,$order);
      // ->paginate($paginate_num);
      $sortData=$paginate_data;
      $sortGetData=$sortData->get();
       // return response()->json($sortGetData);
      // $data['total_data']=count($sortGetData);
      $data['total_view_data']=count(collect($sortGetData)->where('access_type','View')->toArray());
      $data['total_download_data']=count(collect($sortGetData)->where('access_type','Download')->toArray());
      $data['total_edit_data']=count(collect($sortGetData)->where('access_type','Edit')->toArray());
      $data['total_delete_data']=count(collect($sortGetData)->where('access_type','Delete')->toArray());

      $data['paginate_data'] =$sortData->paginate($paginate_num);
      // return response()->json($data);
      return response()->json($data);
    }

    public function store(Request $request)
    {
      // echo "sf"; die();
      $validate=[
        'file_name'=>'required'
      ];

      $request->validate($validate);
      $data=$request->only('file_name','file_status','file_type','expiration_date','notification_period','email_notify','file_attachment','folder_id');

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
        }
      }else{
        $data['file_attachment']='';
      }

      if(!empty($request->id))
      {
        $update_data=FileAccessLog::valid()->project()->findOrFail($request->id);
        $data['updated_by']=Auth::guard('user')->user()->branch_id; 
        $save_data=$update_data->update($data);
        $message=['status' => 1, 'message' => 'Your data is successfully updated'];
      }
      else {
        // $data['designation_code'] = $this->findMaxCode();
        $data['project_id']=Auth::guard('user')->user()->project_id;
        $data['branch_id']=Auth::guard('user')->user()->branch_id; 
        $data['created_by']=Auth::guard('user')->user()->id; 
        $data['file_status']=1; 
        $save_data=FileAccessLog::create($data);
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
      $edit_data=FileAccessLog::valid()->project()->findOrFail($id);
      $file_type_list=FileType::valid()->project()->get()->keyBy('id')->all();
      if(!$edit_data->file_type){
        $edit_data->file_type_value = ['id'=>'','text'=>'']; 
      }else{
        $edit_data->file_type_value = ['id'=>$edit_data->file_type,'text'=>$file_type_list[$edit_data->file_type]->type_name];
      }

      $file_type_data=array();
      
      foreach ($file_type_list as $value) {
        array_push($file_type_data,['id'=>$value['id'],'text'=>$value['type_name']]);
      }
      $edit_data->file_type_data =  $file_type_data;
      return response($edit_data);

    }

    public function destroy($id)
    {

      $delete_data=FileAccessLog::valid()->project()->findOrFail($id);
      if($delete_data->delete())
      {
        $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
      }
      return response($message);

    }

    public function findMaxCode(){
      $last_entry_data=FileAccessLog::latest()->first();
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
      $data['priority'] = $this->findPriority();
      return response($data);
    }

    public function findPriority(){
      $last_entry_data=FileAccessLog::max('priority');
      $last_code = $last_entry_data;
      if ($last_code==0) {
        $last_code = 1;
      }else{
        $last_code = $last_code+1;
      }
      return $last_code;
    }

    public function veiw_or_download($file_id, $type){
      // return response($type); 
        if ($type==1) {
          $access_type = 'View';
        }elseif($type==2){
          $access_type = 'Download';
        }elseif($type==3){
          $access_type = 'Edit';
        }elseif($type==4){
          $access_type = 'Delete';
        }else{
          $access_type = '';
        }
        $data_insert= DB::table('file_access_log')
            ->insert([
              'file_id' =>$file_id,
              'employee_id' =>Auth::guard('user')->user()->employee_id,
              'access_time' =>date('H:m:s'),
              'access_date' =>date('Y-m-d'),
              'access_type' =>$access_type,
              'project_id'  =>Auth::guard('user')->user()->project_id,
              'branch_id'   =>Auth::guard('user')->user()->branch_id,
              'created_by'  =>Auth::guard('user')->user()->id
            ]);
        if ($data_insert) {
          $data['success'] = 1;
          return response($data); 
        }else{
          $data['wrong'] = 0;
           return response($data); 
        }  
    }

}
