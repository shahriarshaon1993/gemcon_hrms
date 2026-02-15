<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDepartmentAssignAPIRequest;
use App\Http\Requests\API\UpdateDepartmentAssignAPIRequest;
use App\Models\DepartmentAssign;
use App\Repositories\DepartmentAssignRepository;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\AppBaseController;
use Response , DB ;

/**
 * Class DepartmentAssignController
 * @package App\Http\Controllers\API
 */

class DepartmentAssignAPIController extends AppBaseController
{
    /** @var  DepartmentAssignRepository */
    private $departmentAssignRepository;

    public function __construct(DepartmentAssignRepository $departmentAssignRepo)
    {
        $this->departmentAssignRepository = $departmentAssignRepo;
    }

    /**
     * Display a listing of the DepartmentAssign.
     * GET|HEAD /departmentAssigns
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $departmentAssigns = $this->departmentAssignRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($departmentAssigns->toArray(), 'Department Assigns retrieved successfully');
    }

    public function dept_permission(Request $request){
        if($request['user_id']){
            $user =  User::find($request['user_id']); 
            if($user){ 
                $deletedRows = DB::table('department_assigns')->where('user_id', $request['user_id'])->delete();
               
                $departments =  $request->dept_selects;
                foreach ($departments as $key => $value) { 
                    DepartmentAssign::insert( 
                        ['dept_id' => $value['id'] , 'user_id' => $request['user_id']] 
                    ); 
                }
            } 
        }  
        
        return $this->sendResponse(1, 'Department Assign saved successfully ');
    }

    /**
     * Store a newly created DepartmentAssign in storage.
     * POST /departmentAssigns
     *
     * @param CreateDepartmentAssignAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDepartmentAssignAPIRequest $request)
    {
        $input = $request->all();

        $departmentAssign = $this->departmentAssignRepository->create($input);

        return $this->sendResponse($departmentAssign->toArray(), 'Department Assign saved successfully');
    }

    /**
     * Display the specified DepartmentAssign.
     * GET|HEAD /departmentAssigns/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var DepartmentAssign $departmentAssign */
        $departmentAssign = $this->departmentAssignRepository->find($id);

        if (empty($departmentAssign)) {
            return $this->sendError('Department Assign not found');
        }

        return $this->sendResponse($departmentAssign->toArray(), 'Department Assign retrieved successfully');
    }

    /**
     * Update the specified DepartmentAssign in storage.
     * PUT/PATCH /departmentAssigns/{id}
     *
     * @param int $id
     * @param UpdateDepartmentAssignAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDepartmentAssignAPIRequest $request)
    {
        $input = $request->all();

        /** @var DepartmentAssign $departmentAssign */
        $departmentAssign = $this->departmentAssignRepository->find($id);

        if (empty($departmentAssign)) {
            return $this->sendError('Department Assign not found');
        }

        $departmentAssign = $this->departmentAssignRepository->update($input, $id);

        return $this->sendResponse($departmentAssign->toArray(), 'DepartmentAssign updated successfully');
    }

    /**
     * Remove the specified DepartmentAssign from storage.
     * DELETE /departmentAssigns/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var DepartmentAssign $departmentAssign */
        $departmentAssign = $this->departmentAssignRepository->find($id);

        if (empty($departmentAssign)) {
            return $this->sendError('Department Assign not found');
        }

        $departmentAssign->delete();

        return $this->sendSuccess('Department Assign deleted successfully');
    }
    public function deptjoin()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }
}
