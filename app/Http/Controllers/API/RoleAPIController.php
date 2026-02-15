<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMOSAPIRequest;
use App\Http\Requests\API\UpdateMOSAPIRequest;
use App\Models\Role;
use App\Repositories\MOSRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth;

/**
 * Class MOSController
 * @package App\Http\Controllers\API
 */

class RoleAPIController extends AppBaseController
{
    /** @var  MOSRepository */
    private $mOSRepository;

    public function __construct(MOSRepository $mOSRepo)
    {
        $this->mOSRepository = $mOSRepo;
    }

    /**
     * Display a listing of the MOS.
     * GET|HEAD /mOS
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {   
       
        $role = Role::select(); 
        $user_data = Auth::guard('user')->user();
        if($user_data->role_id == 1 ){
            $role->where('guard_name','web'); 
        }elseif($user_data->role_id == 5){
            $role->whereIn('id', array(6,7))->get();
        }elseif($user_data->role_id == 6){
            $role->whereIn('id', array(7))->get();
        }
        $result  = $role->get();
         
        return $this->sendResponse($result->toArray(), 'Role retrieved successfully');
    }

    
}
