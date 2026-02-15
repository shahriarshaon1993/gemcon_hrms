<?php

namespace App\Http\Controllers\payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\payroll\PayrollPermission;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\JobGrade;
use Cache;
use permission;

class PayrollPermissionController extends Controller
{
    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index(Request $request)
    {
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $project_id = Auth::guard('user')->user()->project_id;
        $branch_id = Auth::guard('user')->user()->branch_id;

        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        $employee_id = $employee_ids['employee_id'];
        $cache = Cache::get('permission');
        $permission = collect($cache)->where('menu_uid', '=', 'PayrollPermission')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
        foreach ($permission as $child) {
            if ($child['link_uid'] == 'add') {
                $data['add'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'edit') {
                $data['edit'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'delete') {
                $data['delete'] = $child['link_uid'];
            } else {
                $data['view'] = $child['link_uid'];
            }
        }

        $paginate_data = PayrollPermission::valid()->project()
          ->leftJoin('company_sbus', 'company_sbus.id', '=', 'payroll_permissions.company_sbu_id')
          ->leftJoin('job_grades', 'job_grades.id', '=', 'payroll_permissions.permission_grade_start')
          ->leftJoin('job_grades as lgs', 'lgs.id', '=', 'payroll_permissions.permission_grade_end')
          ->select(
              'payroll_permissions.*',
              'company_sbus.sbu_name',
              'job_grades.jobgrade_name as grade_first',
              'lgs.jobgrade_name as grade_last'
          )
          ->when($search_key, function ($query, $search_key) {
              $query->where(function ($query2) use ($search_key) {
                  $query2->where('payroll_permissions.permission_group', 'LIKE', '%'.$search_key.'%');
              });
              return $query;
          })->where('payroll_permissions.project_id', $project_id) ->orderBy($sort, $order);
        $sortData=$paginate_data;
        $sortGetData=$sortData->get();
        $data['total_data']=count($sortGetData);
        $data['inactive_data']=count(collect($sortGetData)->whereIn('status', 0)->toArray());
        $data['active_data']=count(collect($sortGetData)->where('status', 1)->toArray());
        $data['paginate_data'] =$sortData->paginate($paginate_num);
        return response()->json($data);
    }
    public function store(Request $request)
    {
        
        $validate=[
          'permission_group'=>'required'
        ];
        $request->validate($validate);
        $data=$request->only('company_sbu_id', 'permission_entry_date', 'permission_group', 'permission_grade_start', 'permission_grade_end', 'permission_status', 'permission_remarks');

        if (!empty($request->id)) {
            $update_data=PayrollPermission::valid()->project()->findOrFail($request->id);
            $data['updated_by']=Auth::guard('user')->user()->id;
            $save_data=$update_data->update($data);
            $message=['status' => 1, 'message' => 'Your data is successfully updated'];
        } else {
            $data['project_id']=Auth::guard('user')->user()->project_id;
            $data['branch_id']=Auth::guard('user')->user()->branch_id;
            $data['created_by']=Auth::guard('user')->user()->id;
            $data['permission_status']=1;
            $save_data=PayrollPermission::create($data);
            $message=['status' => 1, 'message' => 'Your data is successfully saved'];
        }
        if (!$save_data) {
            $message=['status' => 0, 'message' => 'Ops! Something went worng.'];
        }
        return response($message);
    }

    public function edit($id)
    {
        $employee_list = new Employee();
        $employee_ids=$employee_list->Employee_id();
        $employee_id=$employee_ids['employee_id'];
        $data=PayrollPermission::valid()->project()->findOrFail($id);
        // $companysbu_data_list=CompanySbu::valid()->project()->whereIn('id',$employee_ids['sub'])->get()->keyBy('id')->all();
        $jobgrade_data_list=JobGrade::valid()->project()->get()->keyBy('id')->all();
        // if(!$data->company_sbu_id){
        //   $data->sbu_name_value = ['id'=>'','text'=>''];
        // }else{
        //   $data->sbu_name_value = ['id'=>$data->company_sbu_id,'text'=>$companysbu_data_list[$data->company_sbu_id]->sbu_name];
        // }

        if (!$data->permission_grade_start) {
            $data->jobgrade_name_value_start = ['id'=>'','text'=>''];
        } else {
            $data->jobgrade_name_value_start = ['id'=>$data->permission_grade_start,'text'=>$jobgrade_data_list[$data->permission_grade_start]->jobgrade_name];
        }

        if (!$data->permission_grade_end) {
            $data->jobgrade_name_value_end = ['id'=>'','text'=>''];
        } else {
            $data->jobgrade_name_value_end = ['id'=>$data->permission_grade_end,'text'=>$jobgrade_data_list[$data->permission_grade_end]->jobgrade_name];
        }

        // $company_sbu_data=array();
        $jobgrade_data=array();
        // foreach ($companysbu_data_list as $value) {
        //   array_push($company_sbu_data,['id'=>$value['id'],'text'=>$value['sbu_name']]);
        // }

        foreach ($jobgrade_data_list as $value) {
            array_push($jobgrade_data, ['id'=>$value['id'],'text'=>$value['jobgrade_name']]);
        }

        $data->jobgrade_data =  $jobgrade_data;
        // $data->company_sbu_data =  $company_sbu_data;
        return response($data);
    }

    public function destroy($id)
    {
        $delete_data=PayrollPermission::valid()->project()->findOrFail($id);
        if ($delete_data->delete()) {
            $message=['status' => 1, 'message' => 'Your data is successfully deleted'];
        }
        return response($message);
    }

    public function create()
    {
        $employee_list = new Employee();
        $employee_ids=$employee_list->Employee_id();
        $employee_id=$employee_ids['employee_id'];
        $data['company_sbu_data']=array();
        // $company_sbu_data=CompanySbu::valid()->project()->whereIn('id',$employee_ids['sub'])->get();
        // foreach ($company_sbu_data as $value) {
        //   array_push($data['company_sbu_data'],[
      //     'id'=>$value['id'],
      //     'text'=>$value['sbu_name']
        //   ]);
        // }
        $data['employee_data']=array();
        $data['jobgrade_data']=array();
        $jobgrade_data=JobGrade::orderBy('priority', 'ASC')->get();
        foreach ($jobgrade_data as $value) {
            array_push($data['jobgrade_data'], ['id'=>$value['id'],'text'=>$value['priority']."-".$value['jobgrade_name']]);
        }
        $employee_data=Employee::valid()->project()->get();
        foreach ($employee_data as $value) {
            array_push($data['employee_data'], ['id'=>$value['id'],'text'=>$value['employee_fullname']]);
        }
        return response($data);
    }

    public function findDepartmentMaxCode()
    {
        $last_entry_data=PayrollPermission::latest()->first();
        $department_last_code = $last_entry_data['department_code'];
        if ($department_last_code==0) {
            $department_last_code = 101;
        } else {
            $department_last_code = $department_last_code+1;
        }
        return $department_last_code;
    }
}
