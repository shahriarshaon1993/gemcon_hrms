<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\MenuTable;
use App\Model\MenuInternalLink;

class MenuController extends Controller
{

    public function index(Request $request)
    {
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $selected_panel = $request->input('selected_panel');
        $menu =MenuTable::select('menu_tabe.*', 'menu_panel.type_name')
            ->join('menu_panel', 'menu_tabe.panel_type', '=', 'menu_panel.id')
            ->when($search_key, function($query, $search_key){
                $query->where('menu_name','LIKE','%'.$search_key.'%');
                return $query;
            })->when($selected_panel,function($query2,$selected_panel){
                $query2->where('panel_type',$selected_panel);
                return $query2;
            })->orderBy($sort,$order)->paginate($paginate_num);
  
        $menu_ids = $menu->pluck('id')->all(); 

        $data['internal_link'] = MenuInternalLink::whereIn('menu_id',$menu_ids)->get()->groupBy('menu_id')->all();

        $data['paginate_data'] = $menu;
        $data['panels'] = DB::table('menu_panel')->where('status', '1')->get();
        $data['formData']['add_row']=['0' =>['id'=>0,'order_no'=>'','link_name'=>'','link_uid'=>'']];
        $data['formData']['parents']= MenuTable::select('menu_tabe.*', 'menu_panel.type_name')
            ->join('menu_panel', 'menu_tabe.panel_type', '=', 'menu_panel.id')
            ->where('has_child','1')->get();
        $order_info = MenuTable::orderBy('order_no','desc')->first();
        $data['formData']['order_no']=(!empty($order_info)) ? $order_info->order_no + 1 : 1;

        $menuList = MenuTable::get()->all();
         
        return response()->json($data);
    }

    public static function buildMenu(array $elements, $parentId = 0) {
        $menuGrid = array();
        $s_type = 1;
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
            'has_child'=>'required',
            'menu_icon'=>'required',
            'menu_name'=>'required',
            'order_no'=>'required|numeric',
            'panel_type'=>'required',
            'status'=>'required',
            'uid'=>'required',
            'is_top_bar'=>'required'
        ];
        $request->validate($validation);
        $data = $request->only('has_child','menu_icon','menu_link','menu_name','order_no','panel_type','status','uid','parent_id','is_top_bar');
            
        if(!empty($request->id)){

            $save =  MenuTable::findOrFail($request->id);
            $save->update($data);

            $post_row = collect($request->add_row)->pluck('id')->all();
            $deleted_row = collect($request->pre_ids)->diff($post_row)->all();

            if(count($deleted_row) > 0){
                foreach ($deleted_row as $delete_value) {
                    MenuInternalLink::where('id', $delete_value)->delete(); 
                }
            }

        }else{
            $save =   MenuTable::create($data);
        }

            foreach ($request->add_row as $value) {

                if(!empty($value['link_name'])&&!empty($value['order_no'])&&!empty($value['link_uid'])){

                    $internal_data=[
                       'link_name'=>$value['link_name'],
                       'order_no'=>$value['order_no'],
                       'link_uid'=>$value['link_uid'],
                       'menu_uid'=>$request->uid,
                       'panel_type'=>$request->panel_type,
                       'menu_id'=>$save->id,
                       'status'=>$request->status
                    ];


                    if($value['id'] > 0){

                        $internal_save = MenuInternalLink::findOrFail($value['id'])->update($internal_data);

                    }else{
                        $internal_save = MenuInternalLink::create($internal_data);
                    }
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

        $menu= MenuTable::findOrFail($id);

        $menu->add_row = MenuInternalLink::where('menu_id',$id)->get();
        $menu->pre_ids = $menu->add_row->pluck('id')->all();
        $menu->parents = MenuTable::select('menu_tabe.*', 'menu_panel.type_name')
            ->join('menu_panel', 'menu_tabe.panel_type', '=', 'menu_panel.id')
            ->where('has_child','1')->get();
        $menu->panels = DB::table('menu_panel')->where('status', '1')->get();
        if(count($menu->add_row) === 0){
            $menu->add_row = ['0' =>['id'=>0,'order_no'=>'','link_name'=>'','link_uid'=>'']];
            return response($menu);
        }

        return response($menu);
    
    }

    public function create()
    {
        //$menu = ['parent_id' => 0,'panel_type'=>'','has_child'=>1,'status'=>1];
        $menu = ['parent_id' => '0','panel_type'=>'','status'=>1,'has_child'=>1,'is_top_bar'=>0];

        $order_info = MenuTable::orderBy('order_no','desc')->first();

        $menu['order_no'] = (!empty($order_info)) ? $order_info->order_no + 1 : 1;
        $menu['parents'] =  MenuTable::select('menu_tabe.*', 'menu_panel.type_name')
            ->join('menu_panel', 'menu_tabe.panel_type', '=', 'menu_panel.id')
            ->where('has_child','1')->get();
        $menu['add_row'] = ['0' =>['id'=>0,'order_no'=>'','link_name'=>'','link_uid'=>'']];
        $menu['panels'] = DB::table('menu_panel')->where('status', '1')->get();

        return response($menu);
        
    }

    public function destroy($id)
    {
       
        $menu = MenuTable::findOrFail($id);

        $del_internal = MenuInternalLink::where('menu_id',$menu->id)->get();

       foreach ($del_internal as $value) {
            MenuInternalLink::where('id',$value['id'])->delete();
        }


       if($menu->delete()){
            return response($menu);
        }

    }

    public function getAdminMenuList(){
        // return response()->json('ddd');
        $menuList = MenuTable::where('panel_type',"1")->orderBy('order_no', 'asc')->get();

        $data['menu_list'] = self::buildMenu($menuList->all());
        return response()->json($data);

    }

}
