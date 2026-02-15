<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\AdminRole;
use App\Model\MenuTable;
use App\Model\MenuInternalLink;
use App\Model\AdminRoleAccess;
use App\Model\AdminModel;
use Auth;

class AdminRoleCocntroller extends Controller
{
	public function index(Request $request)
    {
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $data['paginate_data'] =AdminRole::valid()->when($search_key, function($query, $search_key){
                $query->where('role_name','LIKE','%'.$search_key.'%');
                return $query;

            })->orderBy($sort,$order)->paginate($paginate_num);  

        $menuList = MenuTable::where('panel_type',"1")->get(); 
        $data['formData']['access'] = array();
        $data['formData']['selectAll'] = array();
  
        return response()->json($data);
    }

    public function store(Request $request)
    {

        $validation = [
            'role_name' => 'required'
        ];
        $request->validate($validation);
        $data = $request->only('role_name');
                    
        if(!empty($request->id)){
            $save =  AdminRole::valid()->findOrFail($request->id);

            $delete_access = collect($request->pre_access)->diff($request->access)->all();

            foreach ($delete_access as $key => $value) {
                $acces = explode('-',$value);
                $deleted_id = AdminRoleAccess::where([['menu_id', $acces[0]],['interlink_id', $acces[1]]])->first();

                AdminRoleAccess::findOrFail($deleted_id->id)->delete();                

            }

            $save->update($data);

        }else{
            $save =   AdminRole::create($data); 
        }

        foreach ($request->access as $value) {
            $acces = explode('-',$value);

            $acces_data=[
                "menu_id"=>$acces[0],
                "role_id"=>$save->id,
                "interlink_id"=>$acces[1],
            ];

            $exist_id = AdminRoleAccess::where([['menu_id', $acces[0]],['interlink_id',$acces[1]]])->first();
           
            if($exist_id){
                $updated_id = AdminRoleAccess::findOrFail($exist_id->id)->update($acces_data);
            }else{
               AdminRoleAccess::create($acces_data);
            }
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

        $role = AdminRole::findOrFail($id);
        $menuList = MenuTable::where('panel_type',"1")->get(); 
        $role->menu_list = MenuController::buildMenu($menuList->all());
        $role->internal_link = MenuInternalLink::get()->groupBy('menu_id')->all();
        $access_role = AdminRoleAccess::valid()->where('role_id',$id)->get();
        $access = array();
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
       
        $role = AdminRole::valid()->findOrFail($id);

        $access_role = AdminRoleAccess::where('role_id',$id)->get();

        foreach ($access_role as $key => $value) {
            AdminRoleAccess::where('id',$value['id'])->delete();
        }

        if($role->delete()){
            return response(['status' => 1, 'message' => 'Your data is successfully deleted']);
        }

    }

    public function create()
    {
        $menuList = MenuTable::where('panel_type',"1")->get();

        $data['menu_list'] = MenuController::buildMenu($menuList->all());

        $data['internal_link'] = MenuInternalLink::get()->groupBy('menu_id')->all();
        $data['access']=array();
        $data['selectAll']=array();
        return response()->json($data);
    }
}
