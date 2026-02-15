<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Models\User;

use App\Repositories\UserRepository;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
// use Illuminate\Support\Facades\Hash;
use Response;
use Auth, DB;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */
class UserAPIController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     * GET|USER /users
     *
     * @param Request $request
     * @return Response
     */


    public function index(Request $request)
    {
        $user_data = Auth::guard('user')->user();
        // if ($user_data->role_id == 5) {
        //     $request['dept_id'] = $user_data->department;
        // } elseif ($user_data->role_id == 6) {
        //     $request['wing_id'] = $user_data->wing_id;
        // } elseif ($user_data->role_id == 7) {
        //     $request['id'] = $user_data->id;
        // }
        $request['status'] = 1;
        $users = $this->userRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        $users = UserResource::collection($users);

        return $this->sendResponse($users, 'Users retrieved successfully');
    }

    /**
     * Store a newly created User in storage.
     * POST /Users
     *
     * @param CreateUserAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserAPIRequest $request)
    {
        $input = $request->except(['password']);
        $input['password'] = bcrypt($request->password);

        $user = $this->userRepository->create($input);

        return $this->sendResponse($user->toArray(), 'User saved successfully');
    }


    public function show($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse($user->toArray(), 'User retrieved successfully');
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /users/{id}
     *
     * @param int $id
     * @param UpdateUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserAPIRequest $request)
    {
        //GET ALL INPUT WITHOUT is_password_change INPUT VALUE
        $input = $request->except(['is_password_change']);

        //IF PASSWORD INPUT NOT EMPTY
        if (!empty($request->password)) {
            $input['password'] = bcrypt($request->password);
        }
        /** @var Head $head */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user = $this->userRepository->update($input, $id);

        //UPDATE TOUR USER PROFILE
        DB::table('tour_user_profiles')
            ->where('user_id', $id)
            ->update(['base_station_address' => $request->base_station_address]);

        return $this->sendResponse($user->toArray(), 'User updated successfully');
    }


    public function profile_update($id, Request $request)
    {
        $user = User::find($id);
        $input = $request->all();

        //IF PASSWORD INPUT NOT EMPTY
        if (!empty($request->current_password)) {
            if (Hash::check('passwordToCheck', $user->password)) {
                $input['password'] = bcrypt($request->password);
            } else {
                return $this->sendError('Current password not match!');
            }
        }

        $user = $this->userRepository->update($input, $id);

        return $this->sendResponse($user, 'User updated successfully');
    }

    /**
     * Remove the specified Head from storage.
     * DELETE /users/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->delete();

        //TOUR USER PROFILE DELETE
        \Illuminate\Support\Facades\DB::table('tour_user_profiles')->where('user_id', $id)->delete();

        return $this->sendSuccess('User deleted successfully');
    }

}
