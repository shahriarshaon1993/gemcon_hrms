<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\BranchModel;
use App\Model\SalesPersonModel;
use Auth;
use App\Model\PorjectModel;
use App\Model\InventoryItemModel;
use App\Model\ItemsPermisionModel;
use DB;
use App\Model\CatgoryTypeModel;

class BranchListController extends Controller
{
   public function index(Request $request)
    {
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        
        $data['paginate_data'] =BranchModel::valid()->when($search_key, function($query, $search_key){
                    $query->where(function($query2) use ($search_key){
                        $query2->where('branch_code','LIKE','%'.$search_key.'%')
                        ->orWhere('branch_name','LIKE', '%'.$search_key.'%')
                        ->orWhere('branch_type','LIKE', '%'.$search_key.'%');
                    });
                    return $query;

            })->orderBy($sort,$order)->paginate($paginate_num);  
        $data['company']=PorjectModel::valid()->get();
        return response()->json($data);
    }
    public function create()
    {
        $invoice_id =BranchModel::get()->count('id');
        //  $date=date('my');
        //  $date=Auth::guard('user')->user()->project_id;
         if($invoice_id < 10){
            $ints=$invoice_id+1;
            $invoice_ids='BIN'.'10000'.$ints;
         }elseif((int)$invoice_id < 100){
            $ints=$invoice_id+1;
            $invoice_ids='BIN'.'1000'.$ints; 
         }elseif((int)$invoice_id < 1000){
            $ints=$invoice_id+1;
            $invoice_ids='BIN'.'1000'.$ints;
         }elseif((int)$invoice_id < 10000){
            $ints=$invoice_id+1;
            $invoice_ids='BIN'.'100'.$ints;
         }
         $data['branch_code'] = $invoice_ids;
         $data['company']=PorjectModel::valid()->get();
         $data['CatgoryType']=CatgoryTypeModel::valid()->where('status',1)->get();
         $data['progses']=0;
        return response($data);
    }



    public function store(Request $request)
    {
        // return response()->json($request);
        
        $validate = [
           'branch_name' =>  'required|unique:branch_info,branch_name,'.$request->id,
            'address' =>  'required',
            'company_id'=> 'required',
            'branch_type' =>  'required',
            'branch_code'=>'required|unique:branch_info,branch_code,'.$request->id,
            'phone' =>  'required',
            'branch_reg'=>  'required|unique:branch_info,branch_reg,'.$request->id,
            'email' =>  'required|unique:branch_info,email,'.$request->id
        ];
        $request->validate($validate);
        $data = $request->only('branch_name','address','branch_reg','branch_code','branch_size','branch_type','company_id','phone','email','coustomer_id','vendor_id');

        if(!empty($request->id)){

            $data['updated_by']=Auth::guard('admin')->user()->id; 
            $request->validate($validate);
            $save =  BranchModel::findOrFail($request->id)->update($data);
            
           
            // return response()->json($permisions);
           
            if(!empty($request->permision)){
                $permisions=collect($request->permision)->where('id',0)->pluck('id')->count('id');
                if($permisions ==1){
                    DB::table('items_permision')->where('branchs',$request->id)->delete();
                    $item_finds=InventoryItemModel::valid()->get();
                }else{
                    $permisions1=collect($request->permision)->pluck('id')->toArray();
                    DB::table('items_permision')->where('branchs',$request->id)->delete();
                    $item_finds=InventoryItemModel::valid()->whereIn('inv_product_type',$permisions1)->get();
                }
            }else{
                $item_finds=[];
            }
            if(!empty($item_finds)){
                $item_permitio=[];
                foreach ($item_finds as $v) {
                    $item_permitio[]=[
                        'item_id'=>$v->id,
                        'branchs'=>$request->id,
                        'qty_hand'=>0,
                        'reorder_level'=>0,
                        'last_cost'=>0,
                        'avg_cost'=>0,
                        'sale_price'=>0,
                        'branch_id'=>Auth::guard('user')->user()->branch_id,
                        'project_id'=>Auth::guard('user')->user()->project_id,
                        'created_by'=>Auth::guard('user')->user()->branch_id,
                        ];
                        
                }   
                $save_=ItemsPermisionModel::insert($item_permitio);
            }

            if($save){
                $output = ['status' => 1, 'message' => 'Your data is successfully saved'];
            }else{
                $output = ['status' => 0, 'message' => 'Ops! Something went worng.'];     
            }

        }else{
            $data['created_by']=Auth::guard('admin')->user()->id; 
            $save = BranchModel::create($data);  
            if(!empty($request->permision)){
                $permisions=collect($request->permision)->where('id',0)->pluck('id')->count('id');
                if($permisions ==1){
                    DB::table('items_permision')->where('branchs',$request->id)->delete();
                    $item_finds=InventoryItemModel::valid()->get();
                }else{
                    $permisions1=collect($request->permision)->pluck('id')->toArray();
                    DB::table('items_permision')->where('branchs',$request->id)->delete();
                    $item_finds=InventoryItemModel::valid()->whereIn('inv_product_type',$permisions1)->get();
                }
            }else{
                $item_finds=[];
            }

            if(!empty($item_finds)){
                $item_permitio=[];
                foreach ($item_finds as $v) {
                    $item_permitio[]=[
                        'item_id'=>$v->id,
                        'branchs'=>$save->id,
                        'qty_hand'=>0,
                        'reorder_level'=>0,
                        'last_cost'=>0,
                        'avg_cost'=>0,
                        'sale_price'=>0,
                        'branch_id'=>Auth::guard('user')->user()->branch_id,
                        'project_id'=>Auth::guard('user')->user()->project_id,
                        'created_by'=>Auth::guard('user')->user()->branch_id,
                        ];
                        
                }   
                $save_=ItemsPermisionModel::insert($item_permitio);
            }

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

        $project = BranchModel::findOrFail($request->id);
        $project->company=PorjectModel::valid()->get();
        $project->CatgoryType=CatgoryTypeModel::valid()->where('status',1)->get();
        $project->password = "";
        $project->progses =$project['branch_size'];
        return response($project);
    }

    public function destroy(Request $request)
    {

        $project = BranchModel::findOrFail($request->id);
        $users = SalesPersonModel::valid()->where('branch_id',$project['id'])->where('project_id',$project['company_id'])->get();
        // return response( $users);
        $data['deleted_by']=Auth::guard('admin')->user()->id;
        $data['valid'] = 0;
        $data['deleted_at']= date('Y-m-d H:i:s');
          if($project->update($data)){
            foreach ($users as $value){
                $user = SalesPersonModel::findOrFail($value->id);
                // return response( $user);
                $user->update($data);
            }
            return response(['status' => 1, 'message' => 'Your data is successfully deleted']);
        }

    }
    public function approve(Request $request)
    {
        $vendor = BranchModel::valid()->findOrFail($request->id);
        $data['approve_by']=Auth::guard('admin')->user()->id;
        $data['approve_at']= date('Y-m-d H:i:s');
        if($vendor->status !=0){
            $data['status'] = 0;
            if($vendor->update($data)){
                return response(['status' => 1, 'message' => 'Your data is successfully Unapproved']);
            }
        }else{
            $data['status'] = 1;
            if($vendor->update($data)){
                return response(['status' => 1, 'message' => 'Your data is successfully Approve']);
            }
        }
       

         
    }

}
