<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMosFeadbackAPIRequest;
use App\Http\Requests\API\UpdateMosFeadbackAPIRequest;
use App\Models\Department;
use App\Models\MOS;
use App\Models\MosFeadback;
use App\Myclass\PHPMailer;
use App\Repositories\MosFeadbackRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class MosFeadbackController
 * @package App\Http\Controllers\API
 */

class MosFeadbackAPIController extends AppBaseController
{
    /** @var  MosFeadbackRepository */
    private $mosFeadbackRepository;

    public function __construct(MosFeadbackRepository $mosFeadbackRepo)
    {
        $this->mosFeadbackRepository = $mosFeadbackRepo;
    }

    /**
     * Display a listing of the MosFeadback.
     * GET|HEAD /mosFeadbacks
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        /*$mosFeadbacks = $this->mosFeadbackRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );*/

        $mosFeadbacks = MosFeadback::with('feedbackUser')->where('mos_id', $request->mos_id)
            ->whereYear('date', '=', date('Y'))
            ->get();

        return $this->sendResponse($mosFeadbacks->toArray(), 'Mos Feedbacks retrieved successfully');
    }

    /**
     * Store a newly created MosFeadback in storage.
     * POST /mosFeadbacks
     *
     * @param CreateMosFeadbackAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateMosFeadbackAPIRequest $request)
    {
        //MONTH CONVERT FROM STRING TO INT
        $monthArray = array('jan'=>1,'feb'=>2,'mar'=>3,'apr'=>4,'may'=>5,'jun'=>6,'jul'=>7,'aug'=>8,'sep'=>9,'oct'=>10,'nov'=>11,'dec'=>12);

        $user_data = Auth::guard('user')->user();
        $input = $request->all();
        $input['user_id'] = $user_data->id;
        $input['date'] = date('Y-m-d');

        if(isset($request->fmonth)){
            $input['fmonth'] = $monthArray[$request->fmonth];
        }else{
            $input['fmonth'] = NULL;
        }

        $mosFeadback = $this->mosFeadbackRepository->create($input);

        //SEND EMAIL
        if(isset($request->msg) && !empty($request->msg))
        {
            $phpMail=new PHPMailer();
            $message="";

            $to="<b> ATENTION: </b> ";

            //GET DEPARTMENT INFO
            $deptInfo = Department::where('id', $request->dept_id)->first();

            $phpMail->AddAddress($deptInfo->hod_email, $deptInfo->hod_name);
            $phpMail->AddCC("khushbu@ssgbd.com","Khushbu Moni Lopa");
            $phpMail->AddCC("ceo.office@ssgbd.com","MD & CEO Office");
            $phpMail->AddCC("muntasir.shovon@ssgbd.com","Muntasir Mamun Shovon");

            if($request->mailcc1!="")
            {
                $phpMail->AddCC($request->mailcc1,"System CC");
            }
            if($request->mailcc2!="")
            {
                $phpMail->AddCC($request->mailcc2,"System CC");
            }
            if($request->mailcc3!="")
            {
                $phpMail->AddCC($request->mailcc3,"System CC");
            }

            //GET MOS INFO
            $mosInfo = MOS::with('krajoin','kpijoin')->where('id', $request->mos_id)->first();

           //MAIL BODY DATA
            $kra = $mosInfo->krajoin->kra_name;
            $kpi = $mosInfo->kpijoin->kpi_name;
            $taskid = $mosInfo->mos_name;
            $comments = $request->msg;
            $to = $to. $deptInfo->hod_name.'.';

            $message = $message."<strong> KRA: </strong>".$kra;
            $message = $message."<br/>";
            $message = $message."<strong> KPI: </strong>".$kpi;
            $message = $message."<br/>";
            $message = $message."<strong> MOS: </strong>".$taskid;
            $message = $message."<br/><br/>";
            $message = $message."<span style='background-color:#F0FFFF'><strong>".$comments."</strong></span>";
            $message = $message."<br/>";

            $user="MD & CEO's Office";
            $user_email="ceo.office@ssgbd.com";

            $phpMail->AddCC("ceo.office@ssgbd.com","MD & CEO Office");// CEO OFFICE
            $phpMail->AddReplyTo("ceo.office@ssgbd.com","MD & CEO's Office");

            $msg=nl2br($message);

            $phpMail->FromName = $user;
            $phpMail->From="ceo.office@ssgbd.com";

            $phpMail->Sender= $user_email;
            $phpMail->IsHTML(true);
            $phpMail->Host = "mail.ssgbd.com:25";
            $phpMail->IsSMTP();
            $phpMail->Mailer  = "smtp";
            $phpMail->Subject="Monthly Activity Feedback";
            $phpMail->Body=$msg;
            $phpMail->SMTPAuth=false;

            //WILL OPEN
           if(!$phpMail->Send())
            {
                echo "Message could not be sent.";
                echo "Mailer Error: " . $phpMail->ErrorInfo;
                exit;
            }

            $phpMail->ClearAddresses();
            $phpMail->ClearAttachments();

        }


        return $this->sendResponse($mosFeadback->toArray(), 'Mos Feedback saved successfully');
    }

    /**
     * Display the specified MosFeadback.
     * GET|HEAD /mosFeadbacks/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var MosFeadback $mosFeadback */
        $mosFeadback = $this->mosFeadbackRepository->find($id);

        if (empty($mosFeadback)) {
            return $this->sendError('Mos Feedback not found');
        }

        return $this->sendResponse($mosFeadback->toArray(), 'Mos Feedback retrieved successfully');
    }

    /**
     * Update the specified MosFeadback in storage.
     * PUT/PATCH /mosFeadbacks/{id}
     *
     * @param int $id
     * @param UpdateMosFeadbackAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMosFeadbackAPIRequest $request)
    {
        $input = $request->all();

        /** @var MosFeadback $mosFeadback */
        $mosFeadback = $this->mosFeadbackRepository->find($id);

        if (empty($mosFeadback)) {
            return $this->sendError('Mos Feadback not found');
        }

        $mosFeadback = $this->mosFeadbackRepository->update($input, $id);

        return $this->sendResponse($mosFeadback->toArray(), 'MosFeadback updated successfully');
    }

    /**
     * Remove the specified MosFeadback from storage.
     * DELETE /mosFeadbacks/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var MosFeadback $mosFeadback */
        $mosFeadback = $this->mosFeadbackRepository->find($id);

        if (empty($mosFeadback)) {
            return $this->sendError('Mos Feadback not found');
        }

        $mosFeadback->delete();

        return $this->sendSuccess('Mos Feadback deleted successfully');
    }
}
