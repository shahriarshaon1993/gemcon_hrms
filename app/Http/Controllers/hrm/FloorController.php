<?php

namespace App\Http\Controllers\hrm;

use App\Http\Controllers\Controller;
use App\Model\Floor;
use App\Model\WorkLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class FloorController extends Controller
{
    public function index(Request $request)
    {
        $cache = Cache::get('permission');

        $permission = collect($cache)
            ->where('menu_uid', '=', 'FloorList')
            ->where('role_id', Auth::guard('user')->user()->role_id)
            ->toArray();

        foreach ($permission as $child) {
            if ($child['link_uid'] == 'add') {
                $data['add'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'edit') {
                $data['edit'] = $child['link_uid'];
            } elseif ($child['link_uid'] == 'delete') {
                $data['delete'] = $child['link_uid'];
            }
        }

        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');

        if ($request->input('sort') =='id') {
            $order = 'ASC';
            $sort = 'floors.priority';
        } else {
            $order = $request->input('order');
            $sort = $request->input('sort');
        }

        // $project_id = Auth::guard('user')->user()->project_id;
        // $branch_id = Auth::guard('user')->user()->branch_id;

        $paginate_data = Floor::query()
            ->select('floors.*', 'work_locations.work_location_name')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'floors.work_location_id')
            ->with('workLocation')
            ->when($search_key, function($query, $search_key) {
                $query->where(function($query2) use ($search_key) {
                    $query2->where('floor_number','LIKE','%'.$search_key.'%')
                            ->orWhere('work_location_name','LIKE','%'.$search_key.'%');
                });

                return $query;
            })->orderBy($sort, $order);

        $sortData = $paginate_data;

        $sortGetData = $sortData->get();
        $data['total_data'] = count($sortGetData);
        $data['inactive_data'] = count(collect($sortGetData)->whereIn('floor_status',0)->toArray());
        $data['active_data'] = count(collect($sortGetData)->where('floor_status',1)->toArray());
        $data['paginate_data'] = $sortData->paginate($paginate_num);

        // $data['locations'] = WorkLocation::query()
        //     ->select('id', 'work_location_name', 'work_location_status')
        //     // ->where('project_id',$project_id)
        //     ->where('work_location_status', 1)
        //     ->get();

        return response()->json($data);
    }

    public function create(){
        $data['locations'] = WorkLocation::query()
            ->select('id', 'work_location_name', 'work_location_status')
            // ->where('project_id',$project_id)
            ->where('work_location_status', 1)
            ->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {
//        $validate = [
//            'floor_number' => 'required|unique:floors,floor_number,' . $request->id,
//        ];
//        $request->validate($validate);

        $data = $request->only(
            'floor_code',
            'work_location_id',
            'floor_number',
            'floor_status',
            'priority',
            'project_id',
            'branch_id'
        );

        if(! empty($request->id)) {
            $update_data = Floor::query()->findOrFail($request->id);
            $data['updated_by'] = Auth::guard('user')->user()->branch_id;

            $save_data = $update_data->update($data);

            $message = ['status' => 1, 'message' => 'Your data is successfully updated'];
        } else {
            $data['floor_code'] = $this->findMaxCode();

            $data['project_id'] = Auth::guard('user')->user()->project_id;
            $data['branch_id'] = Auth::guard('user')->user()->branch_id;
            $data['created_by'] = Auth::guard('user')->user()->id;

            $save_data = Floor::query()->create($data);

            $message = ['status' => 1, 'message' => 'Your data is successfully saved'];
        }

        if(!$save_data) {
            $message = ['status' => 0, 'message' => 'Ops! Something went worng.'];
        }

        return response($message);
    }

    public function edit($id)
    {
        $edit_data = Floor::query()->findOrFail($id);

        $project_id = Auth::guard('user')->user()->project_id;

        $edit_data['locations'] = WorkLocation::query()
            ->select('id', 'work_location_name', 'work_location_status')
            ->where('project_id', $project_id)
            ->where('work_location_status', 1)
            ->get();

        return response($edit_data);
    }

    public function destroy($id)
    {
        $delete_data = Floor::query()->findOrFail($id);

        $message = [];
        if($delete_data->delete()) {
            $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
        }

        return response($message);
    }

    public function findMaxCode()
    {
        $floor = Floor::query()->latest()->first();

        $code = isset($floor['floor_code']) ? $floor['floor_code'] : 0;

        return $code === 0 ? 101 : $code + 1;
    }
}
