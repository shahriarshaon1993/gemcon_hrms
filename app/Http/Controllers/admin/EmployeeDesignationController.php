<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\BranchModel;
use App\Model\EmployeeDesignationModel;
use Auth;
use App\Model\PorjectModel;

class EmployeeDesignationController extends Controller
{
   public function index(Request $request)
    {
        // return response()->json($request);
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $sorts='id';
        $data['paginate_data'] =EmployeeDesignationModel::valid()->when($search_key, function($query, $search_key){
                    $query->where(function($query2) use ($search_key){
                        $query2->where('emp_designation','LIKE','%'.$search_key.'%');
                        //   ->orWhere('email','LIKE', '%'.$search_key.'%');
                    });
                    return $query;

            })->orderBy($sort,$order)->paginate($paginate_num); 
            $data['company']=PorjectModel::valid()->orderBy($sorts,$order)->paginate($paginate_num); 
            $data['status']=1;  
        return response()->json($data);
    }

    public function store(Request $request)
    {

        $validate = [
           'emp_designation' =>  'required|unique:employee_designation,emp_designation,'.$request->id,
           'emloyee_design_code' =>  'required|unique:employee_designation,emloyee_design_code,'.$request->id,
            'project_id'=> 'required',
        ];
        $request->validate($validate);

        $data = $request->only('emp_designation','status','project_id','emloyee_design_code');

        if(!empty($request->id)){

            $data['updated_by']=Auth::guard('admin')->user()->id; 
            $request->validate($validation);
            $save =  EmployeeDesignationModel::findOrFail($request->id)->update($data);

            if($save){
                $output = ['status' => 1, 'message' => 'Your data is successfully saved'];
            }else{
                $output = ['status' => 0, 'message' => 'Ops! Something went worng.'];     
            }

        }else{
            $data['created_by']=Auth::guard('admin')->user()->id; 
            $data['branch_id']=Auth::guard('admin')->user()->id; 
            $save = EmployeeDesignationModel::create($data);  
           
            	if($save){
                    $output = ['status' => 1, 'message' => 'Your data is successfully saved'];
            	}else{
                    $output = ['status' => 0, 'message' => 'Ops! Something went worng.'];
                }
            // }
        }
        return response()->json($output);

    }
    public function create()
    {
     $invoice_id =EmployeeDesignationModel::pluck('id')->count('id');
     $date=date('dy');
  
      if($invoice_id < 10){
         $ints=$invoice_id+1;
         $invoice_ids='ED'.'200'.$ints;
      }elseif((int)$invoice_id < 100){
         $ints=$invoice_id+1;
         $invoice_ids='ED'.'20'.$ints;
      }elseif((int)$invoice_id < 1000){
         $ints=$invoice_id+1;
         $invoice_ids='ED'.'2'.$ints;
      }
      $data['emloyee_design_code']=$invoice_ids;
    // 
      return response($data);
    }
    public function edit(Request $request)
    {

        $project = EmployeeDesignationModel::valid()->findOrFail($request->id);
        $project->password = "";
        return response($project);
    }

    public function destroy(Request $request)
    {
        $project = EmployeeDesignationModel::findOrFail($request->id);

        $data['deleted_by']=Auth::guard('admin')->user()->id;
        $data['valid'] = 0;
        $data['deleted_at']= date('Y-m-d H:i:s');

          if($project->update($data)){
            return response(['status' => 1, 'message' => 'Your data is successfully deleted']);
        }


        // $project = ItemUnitModel::findOrFail($request->id);

        // if($project->delete()){
        //     return response(['status' => 1, 'message' => 'Your data is successfully deleted']);
        // }

    }

}
