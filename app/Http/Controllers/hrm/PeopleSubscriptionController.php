<?php

namespace App\Http\Controllers\hrm;

use App\Http\Controllers\Controller;
use App\JobAlert;
use App\Model\JobCircular;
use App\Models\Talent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PeopleSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $authUser = Auth::guard('user')->user();

        // Fetch and filter permissions from cache
        $permissions = collect(Cache::get('permission'))
            ->where('menu_uid', 'JobCircular')
            ->where('role_id', $authUser->role_id)
            ->toArray();

        // Map permissions to data array
        $data = [];
        foreach ($permissions as $permission) {
            $link_uid = $permission['link_uid'];
            $data[$link_uid] = $link_uid;
        }

        // Retrieve request parameters
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $project_id = Auth::guard('user')->user()->project_id;

        $query = JobAlert::query()->with('department');

        // Apply search filter if search_key is provided
        if ($search_key) {
            $query->where(function ($query) use ($search_key) {
                $query->where('name', 'LIKE', "%{$search_key}%")
                    ->orWhere('phone', 'LIKE', "%{$search_key}%")
                    ->orWhere('email', 'LIKE', "%{$search_key}%");
            });
        }

        // Fetch and process data
//        $peoples = $query->orderBy($sort, $order)->get();
        $data['paginate_data'] = $query->paginate($paginate_num);

        return response()->json($data);
    }

    /**
     * @throws Exception
     */
    public function destroy($id)
    {
        $message = [];

        $alert = JobAlert::query()->findOrFail($id);

        if ($alert->delete()) {
            $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
        }

        return response($message);
    }
}
