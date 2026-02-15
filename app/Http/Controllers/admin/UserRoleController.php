<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\UserRole;
use App\Model\MenuTable;
use App\Model\MenuInternalLink;
use App\Model\UserRoleAccess;
use App\Model\AdminModel;
use Auth;
use Cache;
use DB;
use App\Model\ModuleModel;

class UserRoleController extends Controller
{
	public function index(Request $request)
    {
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $data['paginate_data'] =UserRole::valid()->when($search_key, function($query, $search_key){
                    $query->where('role_name','LIKE','%'.$search_key.'%');
                    return $query;

            })->orderBy($sort,$order)->paginate($paginate_num);  

        $menuList = MenuTable::whereIn('panel_type',['2','3'])->get(); 
        $data['Module']=ModuleModel::valid()->get();
        $data['formData']['access'] = array();
        $data['formData']['selectAll'] = array(); 
  
        return response()->json($data);
    }

    public function store(Request $request)
    {

        $validation = [
            'role_name' => 'required',
            'module' => 'required'
        ];
        $request->validate($validation);
        $data = $request->only('role_name','module');
                    
        if(!empty($request->id)){
            $save =  UserRole::valid()->findOrFail($request->id);


            $delete_access = collect($request->pre_access)->diff($request->access)->all();

            foreach ($delete_access as $key => $value) {
                $acces = explode('-',$value);
                $deleted_id = UserRoleAccess::where([['menu_id',$acces[0]],['interlink_id',$acces[1]],['role_id',$save->id]])->first();
                UserRoleAccess::findOrFail($deleted_id->id)->delete();
            }

            $save->update($data);
        }else{
            $save =   UserRole::create($data); 
        }

        foreach ($request->access as $value) {
            $acces = explode('-',$value);

            $acces_data=[
                "menu_id"=>$acces[0],
                "role_id"=>$save->id,
                "interlink_id"=>$acces[1],
            ];
            
            $exist_id = UserRoleAccess::where([['menu_id', $acces[0]],['interlink_id',$acces[1]],['role_id',$save->id]])->first();
           
            if($exist_id){
                $updated_id = UserRoleAccess::findOrFail($exist_id->id)->update($acces_data);
            }else{
               UserRoleAccess::create($acces_data);
            }
        }

        
        if($save){
            cache()->forget('permission');
            $permission=UserRoleAccess::join('menu_internal_link','user_access_role.interlink_id','=','menu_internal_link.id')->get();
            Cache::add('permission',$permission);
            // return response()->json($permissions);

            $output = ['status' => 1, 'message' => 'Your data is successfully saved'];
        }else{
            $output = ['status' => 0, 'message' => 'Ops! Something went worng.'];     
        }        
        return response()->json($output);
    }

    public function show(Request $request)
    {

        $role = UserRole::findOrFail($request->id);
        $menuList = MenuTable::whereIn('panel_type',['2','3'])->get(); 
        $role->menu_list = MenuController::buildMenu($menuList->all());
        $role->internal_link = MenuInternalLink::get()->groupBy('menu_id')->all();
        $access_role = UserRoleAccess::valid()->where('role_id',$request->id)->get();
        $access = array();
        $role->Module=ModuleModel::valid()->get();

        foreach ($access_role as $key => $value) {
            array_push($access,$value['menu_id']."-".$value['interlink_id']); 
        }

        $role->pre_access = $access;
        $role->access = $access;
        $role->selectAll=array();
        return response($role);
    }

    public function destroy($id)
    {
       
        $role = UserRole::valid()->findOrFail($id);

        $access_role = UserRoleAccess::where('role_id',$id)->get();

        foreach ($access_role as $key => $value) {
            UserRoleAccess::where('id',$value['id'])->delete();
        }

        if($role->delete()){
            return response(['status' => 1, 'message' => 'Your data is successfully deleted']);
        }

    }

    public function create()
    {
        $menuList = MenuTable::whereIn('panel_type',['2','3'])->get();

        $data['menu_list'] = MenuController::buildMenu($menuList->all());

        $data['internal_link'] = MenuInternalLink::get()->groupBy('menu_id')->all();
        $data['access']=array();
        $data['selectAll']=array();
        $data['Module']=ModuleModel::valid()->get();
        return response()->json($data);
    }

   
}
