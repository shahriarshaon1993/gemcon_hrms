<?php

namespace App\Http\Controllers\hrm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Model\SubSection;
use App\Helper\ResponseUtil;
use Response;
use Cache;
use permission;
// use App\Model\UserRoleAccess;

class SubSectionController extends Controller
{
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */

  public function index(Request $request)
  {
    $cache = Cache::get('permission');
    $permission = collect($cache)->where('menu_uid', '=', 'SubSection')->where('role_id', Auth::guard('user')->user()->role_id)->toArray();
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
    if ($request->input('sort') =='id') {
      $order = 'ASC';
      $sort = 'priority';
    } else {
      $order = $request->input('order');
      $sort = $request->input('sort');
    }
    $project_id = Auth::guard('user')->user()->project_id;
    $branch_id = Auth::guard('user')->user()->branch_id;
    $paginate_data = SubSection::valid()->project()->when($search_key, function ($query, $search_key) {
      $query->where(function ($query2) use ($search_key) {
        $query2->where('sub_section_name', 'LIKE', '%' . $search_key . '%');
        $query2->orWhere('sub_section_code', 'LIKE', '%' . $search_key . '%');
      });
      return $query;
    })->where('project_id', $project_id)->orderBy('priority', 'DESC')->orderBy($sort, $order);
    // ->paginate($paginate_num);
    $sortData = $paginate_data;

    $sortGetData = $sortData->get();
    $data['total_data'] = count($sortGetData);
    $data['inactive_data'] = count(collect($sortGetData)->whereIn('sub_section_status', 0)->toArray());
    $data['active_data'] = count(collect($sortGetData)->where('sub_section_status', 1)->toArray());
    $data['paginate_data'] = $sortData->paginate($paginate_num);
    // return response()->json($data);
    return response()->json($data);
  }


  public function store(Request $request)
  {
    // echo "<pre>";print_r($this->findMaxCode()); die();
    // $validate=[
    //   'sub_section_name'=>'required|unique:sub_sections,sub_section_name'
    // ];

    $validate = [
      'sub_section_name' => 'required'
    ];

    $request->validate($validate);
    $data = $request->only('sub_section_name', 'sub_section_status', 'priority');

    if (!empty($request->id)) {
      $update_data = SubSection::valid()->project()->findOrFail($request->id);
      $data['updated_by'] = Auth::guard('user')->user()->branch_id;
      $save_data = $update_data->update($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
    } else {
      $data['sub_section_code'] = $this->findMaxCode();
      $data['project_id'] = Auth::guard('user')->user()->project_id;
      $data['branch_id'] = Auth::guard('user')->user()->branch_id;
      $data['created_by'] = Auth::guard('user')->user()->id;
      $data['sub_section_status'] = 1;
      $save_data = SubSection::create($data);
      $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
    }

    if (!$save_data) {
      $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
    }
    return response($message);
  }

  public function edit($id)
  {
    $edit_data = SubSection::valid()->project()->findOrFail($id);
    return response($edit_data);
  }

  public function destroy($id)
  {

    $delete_data = SubSection::valid()->project()->findOrFail($id);
    if ($delete_data->delete()) {
      $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
    }
    return response($message);
  }


  public function findMaxCode()
  {
    $last_entry_data = SubSection::max('sub_section_code');
    $department_last_code = isset($last_entry_data) ? $last_entry_data : 0;
    if ($department_last_code == 0) {
      $department_last_code = 101;
    } else {
      $department_last_code = $department_last_code + 1;
    }
    return $department_last_code;
  }

  public function create()
  {
    $data['priority'] = $this->findPriority();
    return response($data);
  }

  public function findPriority()
  {
    $last_entry_data = SubSection::max('priority');
    $last_code = $last_entry_data;
    if ($last_code == 0) {
      $last_code = 1;
    } else {
      $last_code = $last_code + 1;
    }
    return $last_code;
  }

  public function subSectionSelect2()
  {
    $data = array();
    $datas = SubSection::valid()->project()->orderBy('sub_section_name', 'desc')->get();
    array_push($data, ['id' => '', 'text' => 'Deselect']);
    foreach ($datas as $value) {
      array_push($data, ['id' => $value['id'], 'text' => $value['sub_section_name'],]);
    }
    $result = $data;
    return Response::json(ResponseUtil::makeResponse($message = NULL, $result));
  }
}
