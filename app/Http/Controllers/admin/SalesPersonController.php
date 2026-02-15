<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SalesPersonModel;
use App\Model\MenuTable;
use Image;
use Auth;

class SalesPersonController extends Controller
{

	public function index(Request $request)
    {
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $paginate_data = SalesPersonModel::valid()->when($search_key, function($query, $search_key){
                    $query->where(function($query2)use($search_key){
                        $query2->where('name','LIKE','%'.$search_key.'%')
                        ->orWhere('number','LIKE', '%'.$search_key.'%')
                        ->orWhere('username','LIKE', '%'.$search_key.'%')
                        ->orWhere('email','LIKE', '%'.$search_key.'%');
                    });
                    return $query;

            })->where('role_id','=','1')->orderBy($sort,$order)->paginate($paginate_num);
        foreach ($paginate_data as $v) {
            $v->number = self::getNumber($v->number);
        } 
        $data['paginate_data'] = $paginate_data;
        $data['formData']['number'] = self::getNumber();
        $data['formData']['commission_on'] = 'profit';
        return response()->json($data);
    }

    public function create()
    {
        $data['number'] = self::getNumber();
        $data['commission_on'] = 'profit';
        return response($data);
    }
    
    public function store(Request $request)
    {
        $validation = [
            'number' => 'required|numeric|min:1|unique:inv_sales_person,number,'.$request->id,
            'name' => 'required',
            'username' =>  'required|unique:inv_sales_person,username,'.$request->id,
            'commission_percentage' => 'required|numeric',
            'commission_on' => 'required'
        ];

        $data = $request->only('number','name', 'username','address_line_1', 'address_line_2','city', 'state','zip', 'phone', 'email', 'ssn', 'commission_percentage', 'commission_on', 'comments');

        if(empty($chk)){
            if(!empty($request->id)){

                if(!empty($request->password)){
                    $data['password'] = bcrypt($request->password);  
                    $validation['password'] = 'required';
                    $data['role_id'] = 1;
                }
                $data['updated_by']=Auth::guard('admin')->user()->id;
                $request->validate($validation);
                $save =  SalesPersonModel::valid()->findOrFail($request->id)->update($data);
            }else{

                $data['password'] = bcrypt($request->password);  
                $validation['password'] = 'required';
                $data['created_by']=Auth::guard('admin')->user()->id;
                $data['role_id'] = 1;
                $request->validate($validation);
                $save =   SalesPersonModel::create($data); 
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

    public function edit(Request $request)
    {

        $salesPerson = SalesPersonModel::findOrFail($request->id);
        $salesPerson->password = "";
        return response($salesPerson);
    }

    public function destroy(Request $request)
    {
       
        $salesPerson = SalesPersonModel::valid()->findOrFail($request->id);
        $data['deleted_by']=Auth::guard('admin')->user()->id;
        $data['valid'] = 0;
        $data['deleted_at']= date('Y-m-d H:i:s');
        if($salesPerson->update($data)){
            return response(['status' => 1, 'message' => 'Your data is successfully deleted']);
        }

    }
    
    public static  function getNumber($num=0){
        if($num>0){
           $number = $num;   
        }else{
           $sales_person_info = SalesPersonModel::valid()->orderBy('number','desc')->first();
           $number = (!empty($sales_person_info)) ? $sales_person_info->number + 1 : 1;  
        }
        $numlength = strlen((string)$number);
        if($numlength<4){
            if($numlength ==1){
              $number = '000'.$number;  
            }else if($numlength ==2){
              $number = '00'.$number; 
            }else{
             $number = '0'.$number; 
            } 
        }else{
           $number = $number;  
        }
        return $number;
    }

    
    
}
