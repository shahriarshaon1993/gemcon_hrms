<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\PorjectModel;
use App\Model\SalesPersonModel;
use Auth;

class ProjectListController extends Controller
{
   public function index(Request $request)
    {
        
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        // return response()->json($paginate_num);

        $data['paginate_data'] =PorjectModel::valid()->when($search_key, function($query, $search_key){
                    $query->where(function($query2) use ($search_key){
                        $query2->where('company_code','LIKE','%'.$search_key.'%')
                        ->orWhere('company_name','LIKE', '%'.$search_key.'%')
                          ->orWhere('email','LIKE', '%'.$search_key.'%');
                    });
                    return $query;

            })->orderBy($sort,$order)->paginate($paginate_num);    
  
        return response()->json($data);
    }

    public function store(Request $request)
    {

        $validation = [
           'company_name' =>  'required|unique:project_info,company_name,'.$request->id,
            'address' =>  'required',
            'company_name' =>  'required',
            'phone' =>  'required',
            'email' =>  'required|unique:project_info,email,'.$request->id
        ];

        $data = $request->only('address','company_name','company_code','phone','email');

        if(!empty($request->id)){



            $data['updated_by']=Auth::guard('admin')->user()->id; 
            $request->validate($validation);
            $save =  PorjectModel::findOrFail($request->id)->update($data);

            if($save){
                $output = ['status' => 1, 'message' => 'Your data is successfully saved'];
            }else{
                $output = ['status' => 0, 'message' => 'Ops! Something went worng.'];     
            }

        }else{

            $data['created_by']=Auth::guard('admin')->user()->id;
            $save = PorjectModel::create($data);  

            	if($save){
                    $output = ['status' => 1, 'message' => 'Your data is successfully saved'];
            	}else{
                    $output = ['status' => 0, 'message' => 'Ops! Something went worng.'];
                }
            // }
        }
        return response()->json($output);

    }
    public function edit(Request $request)
    {

        $project = PorjectModel::findOrFail($request->id);
        $project->password = "";
        return response($project);
    }

    public function destroy(Request $request)
    {
        
        $project = PorjectModel::findOrFail($request->id);
        $data['deleted_by']=Auth::guard('admin')->user()->id;
        $data['valid'] = 0;
        $data['deleted_at']= date('Y-m-d H:i:s');

        if($project->update($data)){
            return response(['status' => 1, 'message' => 'Your data is successfully deleted']);
        }

        // $project = PorjectModel::findOrFail($request->id);

        // $data['deleted_by']=Auth::guard('admin')->user()->id;
        // $data['valid'] = 0;
        // $data['deleted_at']= date('Y-m-d H:i:s');

        //   if($project->update($data)){
        //     return response(['status' => 1, 'message' => 'Your data is successfully deleted']);
        // }

    }

}
