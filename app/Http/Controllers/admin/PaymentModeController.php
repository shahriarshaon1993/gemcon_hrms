<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SalesPersonModel;
use App\Model\MenuTable;
use App\Model\UserRole;
use App\Model\UserRoleAccess;
use Image;
use Auth;
use App\Model\PorjectModel;
use App\Model\BranchModel;
use App\Model\PaymentModeModel;

class PaymentModeController extends Controller
{

	public function index(Request $request)
    {
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $data['paginate_data'] =PaymentModeModel::valid()->when($search_key, function($query, $search_key){
                    $query->where(function($query2)use($search_key){
                        $query2->where('name','LIKE','%'.$search_key.'%')
                        ->orWhere('email','LIKE', '%'.$search_key.'%');
                    });
                    return $query;

            })->orderBy($sort,$order)->paginate($paginate_num); 
  
        return response()->json($data);
    }

    public static function buildMenu(array $elements, $parentId = 0) {
        $menuGrid = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = self::buildMenu($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $menuGrid[] = $element;
            }
        }

        return $menuGrid;
    }

    public function store(Request $request)
    {
     
        $validation = [
            'name' => 'required',
            'ledger_account_head' => 'required|unique:payment_mode,ledger_account_head,'.$request->id,
            // 'project_id' => 'required',
            // 'branch_id' => 'required',
            // 'status' => 'required',
        ];

        $data = $request->only('name','ledger_account_head','project_id','branch_id');
        // $data['number']=$request->number;
        // $data['status']=$request->status;
        if(empty($chk)){
            
            if(!empty($request->id)){

                $data['updated_by']=Auth::guard('admin')->user()->id;
                $request->validate($validation);
                
                $user = PaymentModeModel::findOrFail($request->id);

                $save =  PaymentModeModel::valid()->findOrFail($request->id)->update($data);
            }else{

                $data['created_by']=Auth::guard('admin')->user()->id;
                // $data['role_id'] = 2;
                $request->validate($validation);
                $save =   PaymentModeModel::create($data); 
            }   
            
           if($save){
                $output = ['status' => 1, 'message' => 'Your data is successfully saved'];
            }else{
                $output = ['status' => 0, 'message' => 'Ops! Something went worng.'];     
            }

        }else{
            $output = ['status' => 0, 'message' => 'Sorry! Username already exist.'];     
        }
        return response()->json($output);
    }

    public function show($id)
    {

        $user = PaymentModeModel::valid()->findOrFail($id);
        $data['CompanyList']=PorjectModel::valid()->get();
        $data['BranchList']=BranchModel::valid()->get();
        $data['userRole']=UserRole::all();
        return response($user);
    }

    public function destroy(Request $request)
    {
        
        $project = PaymentModeModel::findOrFail($request->id);

        if($project->delete()){
            return response(['status' => 1, 'message' => 'Your data is successfully deleted']);
        }

    }

    // public function destroy($id)
    // {
               
    //     $user = PaymentModeModel::valid()->findOrFail($id);
       

    //     $data['deleted_by']=Auth::guard('admin')->user()->id;
    //     $data['valid'] = 0;
    //     $data['deleted_at']= date('Y-m-d H:i:s');

    //       if($user->update($data)){
    //         return response(['status' => 1, 'message' => 'Your data is successfully deleted']);
    //     }

    // }

    public function create()
    {
        
        $data['CompanyList']=PorjectModel::valid()->get();
        $data['BranchList']=BranchModel::valid()->get();
        $data['userRole']=UserRole::all();
        $data['user']= ['status' => "1",'photo'=>"../public/images/default.png"];

        return response($data);
    }
    // public function branch_list(Request $request){
    //     return response($request);
    //     $data['BranchList']=BranchModel::where('id','=',$id)->get();
    //     return response($data);
    // }

    public function getUserMenuList(){
        $where = ['panel_type' => 2];
        $menuList = MenuTable::where($where)->where('status',1)->orderBy('order_no', 'asc')->get();
        $data['menu_list'] = self::buildMenu($menuList->all());
        return response()->json($data);

    }
    
}
