<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\EmailConfigModel;
use Auth;

class EmailConfigurationController extends Controller
{
    public function index(Request $request)
    {
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        // $data['paginate_data'] = EmailConfigModel::valid()
        $data['form_data'] = EmailConfigModel::valid()
        // ->when($search_key, function($query, $search_key){
        //             $query->where(function($query2) use ($search_key){
        //                 $query2->where('name','LIKE','%'.$search_key.'%')
        //                   ->orWhere('email','LIKE', '%'.$search_key.'%');
        //             });
        //             return $query;

        //     })
        //     ->orderBy($sort,$order)
        // ->paginate($paginate_num);  
        ->first();  
  
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = $request->only('mail_driver', 'mail_host','mail_port','mail_username','mail_password', 'mail_encryption', 'mail_from_name', 'status');            
        if(!empty($request->id)){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by']=Auth::guard('admin')->user()->id;
            $save =  EmailConfigModel::valid()->findOrFail($request->id)->update($data);
            
        }else{
            $data['status'] = 1;
            $data['created_by']=Auth::guard('admin')->user()->id;
            $data['created_at'] = date('Y-m-d H:i:s');
            $save =   EmailConfigModel::create($data); 
        }
        
        if($save){
            $output = ['status' => 1, 'message' => 'Your data is successfully saved'];
        }else{
            $output = ['status' => 0, 'message' => 'Ops! Something went worng.'];     
        }        
        return response()->json($output);
    }

    public function show($id)
    {

        $admin = EmailConfigModel::findOrFail($id);
        return response($admin);
    }

    public function destroy($id)
    {
        
        $admin = EmailConfigModel::valid()->findOrFail($id);
        $data['deleted_by']=Auth::guard('admin')->user()->id;
        $data['valid'] = 0;
        $data['deleted_at']= date('Y-m-d H:i:s');

        if($admin->update($data)){
            return response(['status' => 1, 'message' => 'Your data is successfully deleted']);
        }

    }

    public function create()
    {
        $admin = ['status' => "1"];
        return response($admin);
    }

}
