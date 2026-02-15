<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserMOSAPIRequest;
use App\Http\Requests\API\UpdateUserMOSAPIRequest;
use App\Models\UserMOS;
use App\Repositories\UserMOSRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\UserMOSResource;
use Response;

/**
 * Class UserMOSController
 * @package App\Http\Controllers\API
 */

class UserMOSAPIController extends AppBaseController
{
    /** @var  UserMOSRepository */
    private $userMOSRepository;

    public function __construct(UserMOSRepository $userMOSRepo)
    {
        $this->userMOSRepository = $userMOSRepo;
    }

    /**
     * Display a listing of the UserMOS.
     * GET|HEAD /userMOs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userMOs = $this->userMOSRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(UserMOSResource::collection($userMOs), 'User M Os retrieved successfully');
    }

    /**
     * Store a newly created UserMOS in storage.
     * POST /userMOs
     *
     * @param CreateUserMOSAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserMOSAPIRequest $request)
    {
        $input = $request->all();
        foreach ($request->employee_id as $employee_id) {
            if (isset($employee_id['id'])) {
                $input['emp_id'] = $employee_id['id'];
                $userMOS = $this->userMOSRepository->create($input);
            }
        }

        return $this->sendResponse(new UserMOSResource($userMOS), 'User M O S saved successfully');
    }

    /**
     * Display the specified UserMOS.
     * GET|HEAD /userMOs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserMOS $userMOS */
        $userMOS = $this->userMOSRepository->find($id);

        if (empty($userMOS)) {
            return $this->sendError('User M O S not found');
        }

        return $this->sendResponse(new UserMOSResource($userMOS), 'User M O S retrieved successfully');
    }

    /**
     * Update the specified UserMOS in storage.
     * PUT/PATCH /userMOs/{id}
     *
     * @param int $id
     * @param UpdateUserMOSAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserMOSAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserMOS $userMOS */
        $userMOS = $this->userMOSRepository->find($id);

        if (empty($userMOS)) {
            return $this->sendError('User M O S not found');
        }

        $userMOS = $this->userMOSRepository->update($input, $id);

        return $this->sendResponse(new UserMOSResource($userMOS), 'UserMOS updated successfully');
    }

    /**
     * Remove the specified UserMOS from storage.
     * DELETE /userMOs/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserMOS $userMOS */
        $userMOS = $this->userMOSRepository->find($id);

        if (empty($userMOS)) {
            return $this->sendError('User M O S not found');
        }

        $userMOS->delete();

        return $this->sendSuccess('User M O S deleted successfully');
    }
}
