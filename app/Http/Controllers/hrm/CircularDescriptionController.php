<?php

namespace App\Http\Controllers\hrm;

use App\Http\Controllers\Controller;
use App\Model\CircularDescription;
use App\Model\Designation;
use App\Model\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CircularDescriptionController extends Controller
{
    public function index(Request $request)
    {
        $data['designations'] = [];
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');

        if ($request->input('sort') == 'id') {
            $order = 'ASC';
            $sort = 'priority';
        } else {
            $order = $request->input('order');
            $sort = $request->input('sort');
        }

        $project_id = Auth::guard('user')->user()->project_id;
        $branch_id = Auth::guard('user')->user()->branch_id;

        $employee_list = new Employee();
        $employee_ids = $employee_list->Employee_id();

        $cache = Cache::get('permission');

        $permission = collect($cache)
            ->where('menu_uid', '=', 'designation')
            ->where('role_id', Auth::guard('user')
                ->user()->role_id)->toArray();

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

        $paginate_data = CircularDescription::query()
            ->with('designation')->valid()->project()
            ->when($search_key, function ($query, $search_key) {
                $query->whereHas('designation', function ($q) use ($search_key) {
                    $q->where('designation_name', 'LIKE', '%' . $search_key . '%');
                });
            })
            ->whereIn('id', $employee_ids['designation'])
            ->where('project_id', $project_id)
            ->orderBy('id');

        $sortData = $paginate_data;

        $sortGetData = $sortData->get();
        $data['total_data'] = count($sortGetData);
        // $data['inactive_data'] = count(collect($sortGetData)->whereIn('designation_status',0)->toArray());
        // $data['active_data'] = count(collect($sortGetData)->where('designation_status',1)->toArray());

        $data['paginate_data'] = $sortData->paginate($paginate_num);

        return response()->json($data);
    }

    public function create()
    {
        $data = [];

        $data['designations'] = Designation::select('id', 'designation_name')
            ->valid()->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->designation_name,
                ];
            });

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validate = ['designation_id' => 'required'];

        $request->validate($validate);
        $data = $request->only('job_description','job_responsibility','applied_requirements','job_requirements', 'other_benefits');

        $created_by = Auth::guard('user')->user()->id;
        $project_id = Auth::guard('user')->user()->project_id;
        $branch_id = Auth::guard('user')->user()->branch_id;
        $designationId = $request->input('designation_id')['id'];

        $data['branch_id'] = $branch_id;
        $data['created_by'] = $created_by;
        $data['project_id'] = $project_id;
        $data['designation_id'] = $designationId;

        $circular = CircularDescription::query()
            ->where('designation_id', $designationId)
            ->first();

        if ($circular) {
            $circular->update($data);
        } else {
            $circular = CircularDescription::create($data);
        }

        return response([
            'status' => 1,
            'data' => $circular,
            'message' => 'Your data is successfully saved'
        ]);
    }

    public function destroy($id)
    {
        $circular = CircularDescription::project()->findOrFail($id);

        if ($circular->delete()) {
            $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
        }

        return response($message);
    }

    public function getCircular(Request $request)
    {
        $circular = CircularDescription::query()
            ->where('designation_id', $request->input('id'))
            ->first();

        return response()->json($circular);
    }
}
