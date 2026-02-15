<?php

namespace App\Http\Controllers\hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\CompanySbu;
use App\Model\Employee;
use App\Model\WorkLocation;
use App\Helper\ResponseUtil;
use Response;
use Cache;
use permission;
use DB;

// use App\Model\UserRoleAccess;

class CompanySbuController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request)
    {
        $cache = Cache::get('permission');
        $permission = collect($cache)->where('menu_uid', '=', 'CompanySBU')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
        foreach ($permission as $child) {
            if ($child['link_uid'] == 'add') {
                $data['add'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'edit') {
                $data['edit'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'delete') {
                $data['delete'] = $child['link_uid'];
            } else {
                $data['approve'] = $child['link_uid'];
            }
        }
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        if ($request->input('sort') == 'id') {
            $order = 'ASC';
            $sort = 'priority';
        } else {
            $order = $request->input('order');
            $sort = $request->input('sort');
        }
        // dd(Auth::guard('user')->user());
        $project_id = Auth::guard('user')->user()->project_id;
        $branch_id = Auth::guard('user')->user()->branch_id;
        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();
        // $paginate_data=CompanySbu::valid()->project()
        // ->leftJoin('employees','company_sbus.id','=','employees.employee_sbu')
        // ->select('company_sbus.*',DB::raw("count(employee_number) as totalEmply"))
        // ->when($search_key, function($query, $search_key){
        //   $query->where(function($query2)use($search_key){
    //     $query2->where('sbu_name','LIKE','%'.$search_key.'%');
        //   });
        //   return $query;

        // })->whereIn('company_sbus.id',$employee_ids['sub'])->groupBy('employee_sbu')->orderBy($sort,$order);

        $paginate_data = CompanySbu::valid()->project()
          ->when($search_key, function ($query, $search_key) {
              $query->where('sbu_name', 'LIKE', '%' . $search_key . '%');
          })
          ->whereIn('company_sbus.id', $employee_ids['sub'])
          ->orderBy($sort, $order)->withCount('employees');
        $sortData = $paginate_data;

        $sortGetData = $sortData->get();
        $data['total_data'] = count($sortGetData);
        $data['inactive_data'] = count(collect($sortGetData)->whereIn('sbu_status', 0)->toArray());
        $data['active_data'] = count(collect($sortGetData)->where('sbu_status', 1)->toArray());
        $data['paginate_data'] = $sortData->paginate($paginate_num);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        // return response()->json($request->weekend);
        $validate = [
          'sbu_name' => 'required'
        ];

        $request->validate($validate);
        $data = $request->only('sbu_name', 'sbu_short_name', 'sbu_status', 'priority', 'office_start_time', 'office_end_time', 'lateConsiderTime', 'modal_header_color', 'header_font_color', 'header_font_size', 'casual_absent');

        $data['location_permission'] = json_encode(collect($request->workLocationData)->where('id', '!=', '')->pluck('id')->toArray());
        if (!empty($request->weekend)) {
            $weekend_arr = array();
            foreach ($request->weekend as $key => $value) {
                array_push($weekend_arr, $value['id']);
            }
            $weekend = implode(",", $weekend_arr);
            $data['weekend'] = $weekend;
        }
        if ($request->sbu_logo) {
            $image = $request->sbu_logo;
        }
        if (!empty($image)) {
            $exploded = explode(',', $image);
            if (strlen($request->sbu_logo) >= 800) {
                $decoded = base64_decode($exploded[1]);
                $exploded1 = explode(';', $exploded[0]);
                $exploded2 = explode('/', $exploded1[0]);
                if (str_contains($exploded2[1], 'jpeg')) {
                    $str_contains = 'jpeg';
                } else {
                    $str_contains = 'png';
                }
                $fileName = str_random() . '.' . $str_contains;
                $path = public_path() . '/company_logo/' . $fileName;
                file_put_contents($path, $decoded);
                $data['sbu_logo'] = $fileName;
            }
        }

        if (!empty($request->id)) {
            $update_data = CompanySbu::valid()->project()->findOrFail($request->id);
            $data['updated_by'] = Auth::guard('user')->user()->id;
            $data['updated_at'] = date('Y-m-d H:i:s');
            // return response($data);
            if (empty($update_data->weekend)) {
                $weekend = implode(",", $request->weekend);
                $data['weekend'] = $weekend;
            }

            $save_data = $update_data->update($data);
            $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
        } else {
            $data['office_start_time'] = $request['office_start_time']['HH'] . ':' . $request['office_start_time']['mm'] . ':' . '00';
            $data['office_end_time'] = $request['office_end_time']['HH'] . ':' . $request['office_end_time']['mm'] . ':' . '00';
            $data['lateConsiderTime'] = $request['lateConsiderTime']['HH'] . ':' . $request['lateConsiderTime']['mm'] . ':' . '00';

            $data['sbu_code'] = $this->findMaxCode();
            $data['project_id'] = Auth::guard('user')->user()->project_id;
            $data['branch_id'] = Auth::guard('user')->user()->branch_id;
            $data['created_by'] = Auth::guard('user')->user()->id;
            $data['sbu_status'] = 1;
            // $data['weekend']='Fri';


            $save_data = CompanySbu::create($data);
            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
        }

        if (!$save_data) {
            $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
        }
        return response($message);
    }

    public function edit($id)
    {
        $edit_data = CompanySbu::valid()->project()->findOrFail($id);
        $workLocationData = WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $work_location_data = array();
        foreach ($workLocationData as $value) {
            array_push($work_location_data, ['id' => $value['id'], 'text' => $value['work_location_name']]);
        }
        $edit_data->work_location_data = $work_location_data;
        if (!empty($edit_data->location_permission)) {
            $locationPermission = json_decode($edit_data->location_permission, true);
            $dataArry = [];
            foreach ($locationPermission as $key => $value) {
              array_push($dataArry, ['id' => $value, 'text' => $workLocationData[$value]->work_location_name]);
            }
            $edit_data->workLocationData = $dataArry;
        } else {
            $edit_data->workLocationData = ['0' => ['id' => 0,'text' => '']];
        }

        $weekend = explode(',', $edit_data->weekend);
        $arr = array();
        $dayNames = array(
          "Sat" => "Saturday",
          "Sun" => "Sunday",
          "Mon" => "Monday",
          "Tue" => "Tuesday",
          "Wed" => "Wednesday",
          "Thu" => "Thursday",
          "Fri" => "Friday"
        );

        foreach ($weekend as $key => $value) {
            $new_arr = array();
            $new_arr['id'] = $value;
            $new_arr['text'] = $dayNames[$value];
            array_push($arr, $new_arr);
        }
        $edit_data->weekend = $arr;
        $weekendList = array();
        $dayNames = array(
          "Sat" => "Saturday",
          "Sun" => "Sunday",
          "Mon" => "Monday",
          "Tue" => "Tuesday",
          "Wed" => "Wednesday",
          "Thu" => "Thursday",
          "Fri" => "Friday"
        );
        foreach ($dayNames as $key => $value) {
            $new_arr = array();
            $new_arr['id'] = $key;
            $new_arr['text'] = $value;
            array_push($arr, $new_arr);
        }
        $edit_data->weekendList = $weekendList;


        return response($edit_data);
    }

    public function destroy($id)
    {
        $delete_data = CompanySbu::valid()->project()->findOrFail($id);
        if ($delete_data->delete()) {
            $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
        }
        return response($message);
    }

    public function findMaxCode()
    {
        // $last_entry_data=CompanySbu::latest()->first();
        $last_entry_data = CompanySbu::max('sbu_code');
        $last_code = $last_entry_data;
        if ($last_code == 0) {
            $last_code = 101;
        } else {
            $last_code = $last_code + 1;
        }
        return $last_code;
    }

    public function create()
    {
        $arr = array();
        $dayNames = array(
          "Sat" => "Saturday",
          "Sun" => "Sunday",
          "Mon" => "Monday",
          "Tue" => "Tuesday",
          "Wed" => "Wednesday",
          "Thu" => "Thursday",
          "Fri" => "Friday"
        );
        foreach ($dayNames as $key => $value) {
            $new_arr = array();
            $new_arr['id'] = $key;
            $new_arr['text'] = $value;
            array_push($arr, $new_arr);
        }
        $data['weekendList'] = $arr;
        // echo  '<pre>';
        // print_r($value);
        // echo  '<pre>';
        $work_location_data = WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get();
        $data['work_location_data'] = array();
        foreach ($work_location_data as $value) {
            array_push($data['work_location_data'], ['id' => $value['id'], 'text' => $value['work_location_name']]);
        }
        $data['priority'] = $this->findPriority();
        return response($data);
    }

    public function findPriority()
    {
        $last_entry_data = CompanySbu::max('priority');
        $last_code = $last_entry_data;
        if ($last_code == 0) {
            $last_code = 1;
        } else {
            $last_code = $last_code + 1;
        }
        return $last_code;
    }

    public function sbuSelect2()
    {
        $data = array();
        $datas = CompanySbu::valid()->project()->orderBy('sbu_name', 'asc')->get();
        array_push($data, ['id' => '', 'text' => 'Deselect']);
        foreach ($datas as $value) {
            array_push($data, ['id' => $value['id'], 'text' => $value['sbu_name'],]);
        }
        $result = $data;
        return Response::json(ResponseUtil::makeResponse($message = null, $result));
    }
}
