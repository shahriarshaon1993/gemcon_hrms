<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNotificationAPIRequest;
use App\Http\Requests\API\UpdateNotificationAPIRequest;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\User;
use Response;
use Auth;

/**
 * Class NotificationController
 * @package App\Http\Controllers\API
 */

class NotificationAPIController extends AppBaseController
{
    /** @var  NotificationRepository */
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepo)
    {
        $this->notificationRepository = $notificationRepo;
    }

    /**
     * Display a listing of the Notification.
     * GET|HEAD /notifications
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $notifications = $this->notificationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($notifications->toArray(), 'Notifications retrieved successfully');
    }

    /**
     * Store a newly created Notification in storage.
     * POST /notifications
     *
     * @param CreateNotificationAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateNotificationAPIRequest $request)
    {
        $input = $request->all();

        $notification = $this->notificationRepository->create($input);

        return $this->sendResponse($notification->toArray(), 'Notification saved successfully');
    }

    /**
     * Display the specified Notification.
     * GET|HEAD /notifications/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Notification $notification */
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        return $this->sendResponse($notification->toArray(), 'Notification retrieved successfully');
    }

    /**
     * Update the specified Notification in storage.
     * PUT/PATCH /notifications/{id}
     *
     * @param int $id
     * @param UpdateNotificationAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNotificationAPIRequest $request)
    {
        $input = $request->all();

        /** @var Notification $notification */
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        $notification = $this->notificationRepository->update($input, $id);

        return $this->sendResponse($notification->toArray(), 'Notification updated successfully');
    }

    /**
     * Remove the specified Notification from storage.
     * DELETE /notifications/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Notification $notification */
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        $notification->delete();

        return $this->sendSuccess('Notification deleted successfully');
    }


    public function getNotification(Request $request){
        //
        $user = Auth::guard('user')->user();
        //$user = User::find($request->get('user_id'));
        // print_r($userid);

        if($user->role_id == '5'){
            $notification = Notification::where('dept_id', $user->dept_id)
            ->whereIn('notif_receiver',  [$user->id, ''])
            ->orderBy('created_at', 'DESC')
            ->get();

            $notificationCount = Notification::where('dept_id', $user->dept_id)
            ->where('status', '=', '0')
            ->whereIn('notif_receiver',  [$user->id, ''])
            //->orWhereNull('notif_receiver')
            ->count();
       
        }else{
            //$notification = Notification::where('dept_id', $user->dept_id)->where('notif_receiver', '=', $user->id)->orderBy('created_at', 'DESC')->get();
            //$notificationCount = Notification::where('dept_id', $user->dept_id)->where('notif_receiver', '=', $user->id)->orderBy('created_at', 'DESC') ->where('status', '=', 0)->count();

            $notification = Notification::where('notif_receiver', '=', $user->id)->orderBy('created_at', 'DESC')->get();
            $notificationCount = Notification::where('notif_receiver', '=', $user->id)->orderBy('created_at', 'DESC') ->where('status', '=', 0)->count();
        }
        //dd($notification);

        return response()->json(['notification' => $notification, 'unread' => $notificationCount,  'msg'=>'Notification retrieved successfully']);

    }

    public function readNotification(Request $request){
        $user = Auth::guard('user')->user();
        $notificationid = $request->get('nid');
        Notification::where('id', $notificationid)->update(['status' => 1]);
        return $this->sendSuccess('Notification read successfully');

    }
}
