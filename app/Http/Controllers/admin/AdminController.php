<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdminModel;
use Auth;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $data['paginate_data'] =AdminModel::valid()->when($search_key, function($query, $search_key){
                    $query->where(function($query2) use ($search_key){
                        $query2->where('name','LIKE','%'.$search_key.'%')
                          ->orWhere('email','LIKE', '%'.$search_key.'%');
                    });
                    return $query;

            })->orderBy($sort,$order)->paginate($paginate_num);    
  
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validation = [
            'name' => 'required',
            'email' =>  'required|unique:admins,email,'.$request->id,/*not same id adnd password in edit*/
            'username' =>  'required|unique:admins,username,'.$request->id,
            'status' =>  'required'
        ];
        $data = $request->only('name', 'email','username','status');            
        if(!empty($request->id)){
            if(!empty($request->password)){
                $data['password'] = bcrypt($request->password);
                $validation['password'] = 'required|min:6';
            }

            $request->validate($validation);
            $data['updated_by']=Auth::guard('admin')->user()->id;
            $save =  AdminModel::valid()->findOrFail($request->id)->update($data);
            
        }else{
            $data['password'] = bcrypt($request->password);
            $data['created_by']=Auth::guard('admin')->user()->id;
            $validation['password'] = 'required|min:6';
            $request->validate($validation);
            $save =   AdminModel::create($data); 
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

        $admin = AdminModel::findOrFail($id);
        $admin->password = "";
        return response($admin);
    }

    public function destroy($id)
    {
        
        $admin = AdminModel::valid()->findOrFail($id);
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
