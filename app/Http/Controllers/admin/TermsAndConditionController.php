<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\BranchModel;
use App\Model\TermsAndConditionModel;
use Auth;
use App\Model\PorjectModel;

class TermsAndConditionController extends Controller
{
   public function index(Request $request)
    {
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $data['company']=PorjectModel::valid()->orderBy($sort,$order)->paginate($paginate_num);
        $data['paginate_data'] =TermsAndConditionModel::valid()->when($search_key, function($query, $search_key){
                    $query->where(function($query2) use ($search_key){
                        $query2->where('name','LIKE','%'.$search_key.'%');
                        //   ->orWhere('email','LIKE', '%'.$search_key.'%');
                    });
                    return $query;

            })->orderBy($sort,$order)->paginate($paginate_num);  
        return response()->json($data);
    }

    public function store(Request $request)
    {

        $validation = [
        //    'name' =>  'required|unique:item_unit,name,'.$request->id,
            'project_id'=> 'required',
        ];

        $data = $request->only('po_terms_condition','pos_terms_condition','project_id');
        $findsData=TermsAndConditionModel::valid()->where('project_id',$request->project_id)->first();
        if(!empty($findsData)){
            $data['updated_by']=Auth::guard('admin')->user()->id; 
            $request->validate($validation);
            $save =  TermsAndConditionModel::where('project_id',$request->project_id)->update($data);

            if($save){
                $output = ['status' => 1, 'message' => 'Your data is successfully saved'];
            }else{
                $output = ['status' => 0, 'message' => 'Ops! Something went worng.'];     
            }

        }else{
            $data['created_by']=Auth::guard('admin')->user()->id; 
            // $data['branch_id']=Auth::guard('admin')->user()->id; 
            $save = TermsAndConditionModel::create($data);  
           
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

        $project = TermsAndConditionModel::valid()->findOrFail($request->id);
        $project->password = "";
        return response($project);
    }

    public function destroy(Request $request)
    {
        $project = TermsAndConditionModel::findOrFail($request->id);

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
