<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UsersPersonModel;
use App\Model\MenuTable;
use App\Model\UserRole;
use App\Model\UserRoleAccess;
use Image;
use Auth;
use App\Model\PorjectModel;
use App\Model\BranchModel;
use App\Model\EmployeeDepartmentModel;
use App\Model\EmployeeDesignationModel;

class UserController extends Controller
{
	public function index(Request $request)
    {
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $data['userRole']=UserRole::all();
        $data['designations']=EmployeeDesignationModel::valid()->get()->keyBy('id')->all();
        $data['departments']=EmployeeDepartmentModel::valid()->get()->keyBy('id')->all();
        $data['paginate_data'] =UsersPersonModel::valid()
                    ->leftJoin('employees', 'employees.id', '=', 'users_person.employee_id')
                    ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
                    ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
                    ->select(
                      'users_person.*',
                      'employees.employee_id_no',
                      'departments.department_name',
                      'designations.designation_name'
                    )
                    ->when($search_key, function($query, $search_key){
                    $query->where(function($query2)use($search_key){
                        $query2->where('name','LIKE','%'.$search_key.'%')
                        ->orWhere('employee_id_no','LIKE', '%'.$search_key.'%')
                        ->orWhere('email','LIKE', '%'.$search_key.'%')
                        ;
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
            // 'number' => 'required|unique:users_person,number,'.$request->id,
            'name' => 'required',
            // 'email' => 'required|unique:users_person,email,'.$request->id,
            'employee_card_no' =>  'required|unique:users_person,employee_card_no,'.$request->id,
            // 'project_id' => 'required',
            // 'branch_id' => 'required',
            'role_id' => 'required',
            'user_type' => 'required',
        ];

        $data = $request->only('name','employee_card_no','role_id','user_type','status');

        if(empty($chk)){
            
            if(!empty($request->id)){

                if(!empty($request->password)){
                    $data['password'] = bcrypt($request->password);  
                    $validation['password'] = 'required';
                }
                $data['updated_by']=Auth::guard('admin')->user()->id;
                // $data['role_id'] = 2;
                $request->validate($validation);
                $user = UsersPersonModel::findOrFail($request->id);

                $save =  UsersPersonModel::valid()->findOrFail($request->id)->update($data);
            }else{

                $data['password'] = bcrypt($request->password);  
                $validation['password'] = 'required';
                $data['created_by']=Auth::guard('admin')->user()->id;
                // $data['role_id'] = 2;
                $request->validate($validation);

                $save =   UsersPersonModel::create($data); 
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

        $user = UsersPersonModel::valid()
                ->leftJoin('employees', 'employees.id', '=', 'users_person.employee_id')
                ->select('users_person.*','employees.employee_department','employees.employee_designation')
                ->findOrFail($id);
        $user['CompanyList']=PorjectModel::all();
        $user['BranchList']=BranchModel::all();
        $user['userRole']=UserRole::all();
        $user['designations']=EmployeeDesignationModel::valid()->get()->keyBy('id')->all();
        $user['departments']=EmployeeDepartmentModel::valid()->get()->keyBy('id')->all();
        $user->password = "";
        $path ="../public/images/".$user->photo;
        $user->photo =$path;
        return response($user);
    }

    public function destroy($id)
    {
       
        $user = UsersPersonModel::valid()->findOrFail($id);

        $data['deleted_by']=Auth::guard('admin')->user()->id;
        $data['valid'] = 0;
        $data['deleted_at']= date('Y-m-d H:i:s');

          if($user->update($data)){
            return response(['status' => 1, 'message' => 'Your data is successfully deleted']);
        }

    }
  

    public function create()
    {
        $invoice_id =UsersPersonModel::valid()->count('id');
        $date=date('dy');
        if($invoice_id < 10){
            $int_valu=$invoice_id+1;
           $ints='10000'.$int_valu;
        //    $invoice_ids='PO'.$date.'200'.$ints;
        }elseif((int)$invoice_id < 100){
            $int_valu=$invoice_id+1;
           $ints='1000'.$int_valu;
        //    $invoice_ids='PO'.$date.'20'.$ints;
        }elseif((int)$invoice_id < 1000){
             $int_valu=$invoice_id+1;
           $ints='100'.$int_valu;
        //    $invoice_ids='PO'.$date.'2'.$ints;
        }elseif((int)$invoice_id < 10000){
             $int_valu=$invoice_id+1;
            $ints='10'.$int_valu;
            // $invoice_ids='PO'.$date.'2'.$ints;
         }elseif((int)$invoice_id < 100000){
             $int_valu=$invoice_id+1;
            $ints='1'.$int_valu;
            // $invoice_ids='PO'.$date.'2'.$ints;
         }
        $data['number']=$ints;

        $data['status']=1;
        $data['CompanyList']=PorjectModel::valid()->get();
        $data['BranchList']=BranchModel::valid()->get();
        $data['userRole']=UserRole::valid()->get();
        // $productions_data=ProductionsModel::valid()->project()->get();
        // $data['designation']=array();
        $data['designations']=EmployeeDesignationModel::valid()->where('status',1)->get()->keyBy('id')->all();
        $data['departments']=EmployeeDepartmentModel::valid()->get()->keyBy('id')->all();

        // foreach ($designations as $key => $value) {
        // array_push($data['designation'],['id'=>$value['id'],'text'=>$value['emp_designation']]);
        // }
        // ->where('project',Auth::guard('user')->user()->project_id)
        // $data['department']=array();
        // foreach ($departments as $key => $value) {
        // array_push($data['department'],['id'=>$value['id'],'text'=>$value['department_name']]);
        // }

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
