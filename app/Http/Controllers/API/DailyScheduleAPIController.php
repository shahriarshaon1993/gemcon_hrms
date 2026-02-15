<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDailyScheduleAPIRequest;
use App\Http\Requests\API\UpdateDailyScheduleAPIRequest;
use App\Models\DailySchedule;
use App\Models\DepartmentAssign;
use App\Models\Department;
use App\Models\Daily_schedule_header;
use App\Http\Resources\DailyScheduleResource;
use App\Repositories\DailyScheduleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth, DB;
use App\Models\User;
use App\Myclass\PHPMailer;
use App\Myclass\SMTP;

/**
 * Class DailyScheduleController
 * @package App\Http\Controllers\API
 */

class DailyScheduleAPIController extends AppBaseController
{
    /** @var  DailyScheduleRepository */
    private $dailyScheduleRepository;

    public function __construct(DailyScheduleRepository $dailyScheduleRepo)
    {
        $this->dailyScheduleRepository = $dailyScheduleRepo;
    }

    /**
     * Display a listing of the DailySchedule.
     * GET|HEAD /dailySchedules
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {


        
        $user_data = Auth::guard('user')->user();
        $dept_info = Department::find($user_data->department);
        $taskQ = DailySchedule::limit('200');
        $taskQ->select('daily_schedules.*'); 
        if ((isset($request['date']) && $request['date'] != '') and (isset($request['toDate']) && $request['toDate'] != '')) {
            $taskQ->whereBetween('date', [$request['date'], $request['toDate']]);
        } else {
            $taskQ->whereBetween('date', date('Y-m-d'), date('Y-m-d'));
        } 
        if ($user_data->role_id == 5 || $user_data->role_id == 6 || $user_data->role_id == 7) {
            if ($dept_info->is_factory == 1) {
                $taskQ->leftjoin('daily_schedule_headers', 'daily_schedule_headers.id', '=', 'daily_schedules.factory_format_id');
                $taskQ->orderBy('daily_schedule_headers.serialno', 'ASC');
            }
            $taskQ->orderBy('role_id', 'ASC');
            $taskQ->orderBy('top_priority', 'DESC');
            // $user_data 
            $taskQ->where('daily_schedules.dept_id', $user_data->department);
            if ($user_data->role_id == 5) {
                if ($request['wing_id'] && !$request['user_id']) {
                    $taskQ->where('wing_id', $request['wing_id']);
                }
                if ($request['user_id']) {
                    $taskQ->where('user_id', $request['user_id']);
                }
            } else if ($user_data->role_id == 6) {
                $user_data->wing_id;
                $taskQ->where('wing_id', $user_data->wing_id);
                //$request['wing_id'] = $user_data->wing_id ;
            } else if ($user_data->role_id == 7) {
                // $request['user_id'] = $user_data->id ; 
                $taskQ->where('user_id', $user_data->id);
            }
        } else if ($user_data->role_id == 3 || $user_data->role_id == 8 || $user_data->role_id == 1 || $user_data->role_id == 2) {
            $taskQ->orderBy('top_priority', 'DESC');
           
            if (!$request['dept_id'] && !$request['wing_id']  &&  !$request['user_id']) {
                // if ($request['dept_id'] == $user_data->department) {
                //     $taskQ->where('user_id', $user_data->id);
                // } else {
                //     $taskQ->where('role_id', 5);
                // }
                $taskQ->where('user_id', $user_data->id);
            }
            
            if ($request['dept_id'] && !$request['wing_id']) {
                
                $taskQ->whereIn('role_id',[1,2,3,4,5,8]);
                $taskQ->where('daily_schedules.dept_id', $request['dept_id']);
            }
            if ($request['wing_id'] && !$request['user_id']) {
                
                // $request['role_id'] = 6  ;
                $taskQ->where('daily_schedules.wing_id', $request['wing_id']);
                $taskQ->where('role_id', 6);
            }
            if ($request['user_id']) {
                // $request['role_id'] = 7  ; 
                $taskQ->where('user_id', $request['user_id']);
            }
            if ($user_data->id == 1027) {
                //echo  'Test'; 
                //$task =  DepartmentAssign::select('dept_id')->where('user_id',$user_data->id)->get()->toArray() ; 
                $taskQ->whereIn('daily_schedules.dept_id', DepartmentAssign::select('dept_id')->where('user_id', $user_data->id)->get()->toArray());
            }
        }


        //$task = $taskQ->get();

        $task = $taskQ->orderBy('date', 'DESC')->get();

        $data_return  =   DailyScheduleResource::collection($task);
        return $this->sendResponse($data_return, 'Schedule retrieved successfully');


        // return $this->sendResponse($dailySchedules->toArray(), 'Daily Schedules retrieved successfully');
    }
    public function my_daily_schedules(Request $request)
    {
        // $dailySchedules = $this->dailyScheduleRepository->all(
        //     $request->except(['skip', 'limit']),
        //     $request->get('skip'),
        //     $request->get('limit')
        // );
        $user_data = Auth::guard('user')->user();

        $request['user_id'] = $user_data->id;
        if (!$request['date']) {
            $request['date'] =   date('Y-m-d');
        }

        $task = $this->dailyScheduleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        $data_return  =   DailyScheduleResource::collection($task);
        return $this->sendResponse($data_return, 'Schedule retrieved successfully');


        // return $this->sendResponse($dailySchedules->toArray(), 'Daily Schedules retrieved successfully');
    }

    public function daliy_not_update(Request $request)
    {
        $to_date = ($request->to_date != '' ? date('Y-m-d', strtotime($request->to_date)) : date('Y-m-d'));
        $user_data = Auth::guard('user')->user();
        // $q = User::where('status', 1);
        // $q->where('role_id', 5);
        // if($request->dept_id){
        //     $q->where('dept_id', $request->dept_id);
        // } 
        // $q->where('wing_id', 0);
        // $q->whereNotIn('id', function ($query) use ($to_date) {
        //         $query->select('user_id')->where('date', $to_date)->from('daily_schedules');
        //     });

        // $q->with('deptjoin');
        // //if($user_data->id == 1027){ 
        // $q->whereIn('dept_id', DepartmentAssign::select('dept_id')->where('user_id',$user_data->id)->get()->toArray()); 
        // //} 
        // $data = $q->get();
        $q = DepartmentAssign::select('dept_id')->where('user_id', $user_data->id);
        $q->whereNotIn('dept_id', function ($query) use ($to_date) {
            // $query->select('dept_id')
            //     ->where('month', $month)
            //     ->where('year', $year)
            //     ->from('monthly_reports');
            $query->select('dept_id')->where('date', $to_date)->from('daily_schedules');
        });
        $q->with('deptjoin');
        $data = $q->get();


        return $this->sendResponse($data->toArray(), 'Daliy not update List');
    }

    public function daliy_mail(Request $request)
    {
        $to_date = ($request->to_date != '' ? date('Y-m-d', strtotime($request->to_date)) : date('Y-m-d'));

        // if ($request->dept_selects) {
        // $departments = User::where('status', 1)
        //     ->where('role_id', 5)
        //     ->whereNotIn('id', function ($query) use ($to_date) {
        //         $query->select('user_id')->where('date', $to_date)->from('daily_schedules');
        //     })
        //     ->get();
        $departments =  $request->dept_selects;
        foreach ($departments as $key => $value) {
            $phpMail = new PHPMailer();
            $message = "";
            //print_r($value['deptjoin']['hod_email']);
            // echo  $value->deptjoin->hod_name ;
            // exit; 
            $phpMail->AddAddress($value['deptjoin']['hod_email'],  $value['deptjoin']['hod_name']);
            //$phpMail->AddAddress("sayed@ssgbd.com", "Sayem islam");
            if ($request->mailcc1 != "") {
                $phpMail->AddCC($request->mailcc1, "System CC");
            }
            if ($request->mailcc2 != "") {
                $phpMail->AddCC($request->mailcc2, "System CC");
            }
            if ($request->mailcc3 != "") {
                $phpMail->AddCC($request->mailcc3, "System CC");
            }

            $nextmonth = "";


            $data['nextmonth'] = $to_date;
            $data['all_dept_comm'] = $request->all_dept_comm;
            $message = view('mail.daily_mail')->with(['data' => $data]);

            $user = "MD & CEO";
            $user_email = "ceo.office@ssgbd.com";

            $phpMail->AddReplyTo("ceo.office@ssgbd.com", "MD & CEO");

            $msg = nl2br($message);

            $phpMail->FromName = $user;
            $phpMail->From = "ceo.office@ssgbd.com";
            $phpMail->Sender = $user_email;
            $phpMail->IsHTML(true);
            $phpMail->Host = "mail.ssgbd.com:25";
            $phpMail->IsSMTP();
            $phpMail->Mailer  = "smtp";
            $phpMail->Subject = "Comment on Daily Task";
            $phpMail->Body = $msg;
            $phpMail->SMTPAuth = false;


            if (!$phpMail->Send()) {
                echo "Message could not be sent.";
                echo "Mailer Error: " . $phpMail->ErrorInfo;
                exit;
            }

            $phpMail->ClearAddresses();
            $phpMail->ClearAttachments();
        }
        // } else {

        //     $departments = User::where('status', 1)
        //         ->where('role_id', 5)
        //         ->whereNotIn('id', function ($query) use ($to_date) {
        //             $query->select('user_id')->where('date', $to_date)->from('daily_schedules');
        //         })
        //         ->get();
        //     foreach ($departments as $key => $value) {
        //         if (isset($request->dept_check[$value->id])) {

        //             $phpMail = new PHPMailer();
        //             $message = "";
        //             $phpMail->AddAddress($value->ad_mail, $value->name);
        //             $phpMail->AddAddress("sazzadul.islam@ssgbd.com", "Sazzadul islam");
        //             if ($request->mailcc1 != "") {
        //                 $phpMail->AddCC($request->mailcc1, "System CC");
        //             }
        //             if ($request->mailcc2 != "") {
        //                 $phpMail->AddCC($request->mailcc2, "System CC");
        //             }
        //             if ($request->mailcc3 != "") {
        //                 $phpMail->AddCC($request->mailcc3, "System CC");
        //             }
        //             $data['nextmonth'] = $to_date;
        //             $data['all_dept_comm'] = $request->comm[$value->id];
        //             $message = view('mail.daily_mail')->with(['data' => $data]);

        //             $user = "MD & CEO";
        //             $user_email = "ceo.office@ssgbd.com";

        //             $phpMail->AddReplyTo("ceo.office@ssgbd.com", "MD & CEO");

        //             $msg = nl2br($message);

        //             $phpMail->FromName = $user;
        //             $phpMail->From = "ceo.office@ssgbd.com";
        //             $phpMail->Sender = $user_email;
        //             $phpMail->IsHTML(true);
        //             $phpMail->Host = "mail.ssgbd.com:25";
        //             $phpMail->IsSMTP();
        //             $phpMail->Mailer  = "smtp";
        //             $phpMail->Subject = "Comment on Daily Task";
        //             $phpMail->Body = $msg;
        //             $phpMail->SMTPAuth = false;


        //             if (!$phpMail->Send()) {
        //                 echo "Message could not be sent.";
        //                 echo "Mailer Error: " . $phpMail->ErrorInfo;
        //                 exit;
        //             }

        //             $phpMail->ClearAddresses();
        //             $phpMail->ClearAttachments();
        //         }

        //     }
        // }
        return $this->sendResponse([], 'Mail send successfully');
    }

    public function getTask()
    {
        return 9;
    }

    /**
     * Store a newly created DailySchedule in storage.
     * POST /dailySchedules
     *
     * @param CreateDailyScheduleAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDailyScheduleAPIRequest $request)
    {
        $user_data = Auth::guard('user')->user();
        $request['user_id'] = $user_data->id;

        if (!$request['date']) {
            $request['date'] = date("Y-m-d");
        }
        if ($user_data->role_id == 6 || $user_data->role_id == 7) {
            $request['wing_id'] = $user_data->wing_id;
        }
        if ($user_data->role_id == 6 || $user_data->role_id == 7) {
            $request['wing_id'] = $user_data->wing_id;
        }
        $request['dept_id'] = $user_data->department ? $user_data->department : null;
        $request['user_id'] = $user_data->id;
        $request['role_id'] = $user_data->role_id;

        $input = $request->all();
        $dailySchedule = $this->dailyScheduleRepository->create($input);

        return $this->sendResponse($dailySchedule->toArray(), 'Daily Schedule saved successfully');
    }

    /**
     * Display the specified DailySchedule.
     * GET|HEAD /dailySchedules/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var DailySchedule $dailySchedule */
        $dailySchedule = $this->dailyScheduleRepository->find($id);

        if (empty($dailySchedule)) {
            return $this->sendError('Daily Schedule not found');
        }

        return $this->sendResponse($dailySchedule->toArray(), 'Daily Schedule retrieved successfully');
    }

    /**
     * Update the specified DailySchedule in storage.
     * PUT/PATCH /dailySchedules/{id}
     *
     * @param int $id
     * @param UpdateDailyScheduleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDailyScheduleAPIRequest $request)
    {
        $input = $request->all();

        /** @var DailySchedule $dailySchedule */
        $dailySchedule = $this->dailyScheduleRepository->find($id);

        if (empty($dailySchedule)) {
            return $this->sendError('Daily Schedule not found');
        }

        $dailySchedule = $this->dailyScheduleRepository->update($input, $id);

        return $this->sendResponse($dailySchedule->toArray(), 'DailySchedule updated successfully');
    }

    /**
     * Remove the specified DailySchedule from storage.
     * DELETE /dailySchedules/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var DailySchedule $dailySchedule */
        $dailySchedule = $this->dailyScheduleRepository->find($id);

        if (empty($dailySchedule)) {
            return $this->sendError('Daily Schedule not found');
        }

        $dailySchedule->delete();

        return $this->sendSuccess('Daily Schedule deleted successfully');
    }
}
