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
use App\Model\ModuleModel;

class ModuleDataController extends Controller
{

	public function index(Request $request)
    {
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $data['paginate_data'] =ModuleModel::valid()->when($search_key, function($query, $search_key){
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

    //  return response()->json($request);
        $validation = [
            'module_name' => 'required|unique:module_data,module_name,'.$request->id,
            // 'ledger_account_head' => 'required|unique:payment_mode,ledger_account_head,'.$request->id,
            'project_id' => 'required',
            // 'branch_id' => 'required',
            // 'status' => 'required',
        ];
        $data = $request->only('module_name','project_id');
        $image = $request->image;
        if($image){
            $exploded=explode(',',$image);
            if(strlen($request->image) >=800){
            $decoded = base64_decode($exploded[1]);
            $exploded1=explode(';',$exploded[0]);
            $exploded2=explode('/',$exploded1[0]);
            
     
              if(str_contains($exploded2[1],'jpeg')){
                  $str_contains='jpeg';
              }else{
                  $str_contains='png';
              }
          
            $fileName=str_random().'.'.$str_contains;
            $data['icon']=$fileName; 
            $path=public_path().'/assets/icon/'.$fileName;
            file_put_contents( $path,$decoded);
            
            // return response()->json($data);
           }
           }else{
            $message=['status' => 0, 'message' => 'Ops! Select Your Product Image...'];
           }


       
        // $data['number']=$request->number;
        // $data['status']=$request->status;
        if(empty($chk)){
            
            if(!empty($request->id)){

                $data['updated_by']=Auth::guard('admin')->user()->id;
                $request->validate($validation);
                
                $user = ModuleModel::findOrFail($request->id);

                $save =  ModuleModel::valid()->findOrFail($request->id)->update($data);
            }else{

                $data['created_by']=Auth::guard('admin')->user()->id;
                // $data['role_id'] = 2;
                $request->validate($validation);
               
                $save =   ModuleModel::create($data); 
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

        $user = ModuleModel::valid()->findOrFail($id);
        $data['CompanyList']=PorjectModel::valid()->get();
        $data['BranchList']=BranchModel::valid()->get();
        $data['userRole']=UserRole::all();
        return response($user);
    }

    public function destroy(Request $request)
    {
        
        $project = ModuleModel::findOrFail($request->id);

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
