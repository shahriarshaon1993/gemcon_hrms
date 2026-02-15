<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMOSAPIRequest;
use App\Http\Requests\API\UpdateMOSAPIRequest;
use App\Models\MOS;
use App\Models\MosData;
use App\Models\MosFeadback;
use App\Repositories\MOSRepository;
use App\Repositories\MosDataRepository;
use App\Http\Resources\MosTreeResource;
use App\Http\Resources\MosItemResource;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\MosUserTreeResource;
use App\Models\DepartmentSetting;
use Response;
use DB;
use Auth;

/**
 * Class MOSController
 * @package App\Http\Controllers\API
 */

class MOSAPIController extends AppBaseController
{
    /** @var  MOSRepository */
    private $mOSRepository;
    private $mosDataRepository;



    public function __construct(MOSRepository $mOSRepo, MosDataRepository $mosDataRepo)
    {
        $this->mOSRepository = $mOSRepo;
        $this->mosDataRepository = $mosDataRepo;
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
        $mOS = $this->mOSRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($mOS->toArray(), 'M O S retrieved successfully');
    }
    public function kra_kpi_mos_list2(Request $request)
    {
        $user_data = Auth::guard('user')->user();




        // if($user_data->role_id == 5 || $user_data->role_id == 6 || $user_data->role_id == 7 ){
        //     $request['dept_id'] = $user_data->department ; 
        //    // $request['kra_id'] =  143 ; 
        // } 
        // $task =MOS::orderBy('kra_id','DESC');
        // $task =MOS::orderBy('kpi_id','ASC');

        // if($user_data->role_id == 5 || $user_data->role_id == 6 || $user_data->role_id == 7 ){
        //     $task->where('dept_id',$user_data->department );
        // }
        // if($request->dept_id ){
        //     $task->where('dept_id',$request->dept_id );
        // }
        // if($request->kra_id ){
        //     $task->where('kra_id',$request->kra_id );
        // }
        // if($request->kpi_id ){
        //     $task->where('kpi_id',$request->kpi_id );
        // }
        // if($request->mos_id ){
        //     $task->where('mos_id',$request->mos_id );
        // }
        // $result  = $task->get();
        // $data_return  =   MosTreeResource::collection($result);
        return $this->sendResponse($data_return, 'K P I S retrieved successfully');
    }

    public function kra_kpi_mos_list(Request $request)
    {
        $user_data = Auth::guard('user')->user();
        // if($user_data->role_id == 5 || $user_data->role_id == 6 || $user_data->role_id == 7 ){
        //     $request['dept_id'] = $user_data->department ; 
        //    // $request['kra_id'] =  143 ; 
        $dept_id = $user_data->department;
        // }else{
        //    $dept_id = $request->dept_id; 
        // }
        $task = MOS::limit(300);
        $task->orderBy('kra_id', 'ASC');
        $task->orderBy('kpi_id', 'ASC');
        $task->orderBy('id', 'ASC');
        if ($user_data->role_id == 5 || $user_data->role_id == 6 || $user_data->role_id == 7) {
            $task->where('dept_id', $user_data->department);
        }
        if ($request->dept_id) {
            $task->where('dept_id', $request->dept_id);
        }
        if ($request->kra_id) {
            $task->where('kra_id', $request->kra_id);
        }
        if ($request->kpi_id) {
            $task->where('kpi_id', $request->kpi_id);
        }
        if ($request->mos_id) {
            $task->where('mos_id', $request->mos_id);
        }
        if ($request->year) {
            $task->where('year', $request->year);
        }

        // echo  $task->toSql();
        // exit();




        $result  = $task->get();

        $data_return  =   MosTreeResource::collection($result);
        return $this->sendResponse($data_return, 'K P I S retrieved successfully');
    }
    public function kra_kpi_mos_list_user(Request $request)
    {
        $user_data = Auth::guard('user')->user();
        // dd($user_data);
        $dept_id = $user_data->department;

        $task = MOS::select('m_o_s.*')->join('user_m_os', 'm_o_s.id', 'user_m_os.mos_id')->limit(300);
        $task->where('user_m_os.emp_id', $user_data->employee_id);
        $task->orderBy('m_o_s.id', 'ASC');

        $result  = $task->get();
        // dd($result);

        $data['departmentsetting'] = DepartmentSetting::where('dept_id', $dept_id)->first();


        $data['data_return']  =   MosUserTreeResource::collection($result);
        return view('layouts.mos_data', $data);
        // return view('layouts.mos_user_dashboard', $data);
        // dd($data);

        // return $this->sendResponse($data, 'K P I S retrieved successfully');
    }
    public function kra_kpi_mos_dashboard_user(Request $request)
    {
        $user_data = Auth::guard('user')->user();
        // dd($user_data);
        $dept_id = $user_data->department;

        $task = MOS::select('m_o_s.*')->join('user_m_os', 'm_o_s.id', 'user_m_os.mos_id')->limit(300);
        $task->where('user_m_os.emp_id', $user_data->employee_id);
        $task->orderBy('m_o_s.id', 'ASC');

        $result  = $task->get();
        // dd($result);

        $data['departmentsetting'] = DepartmentSetting::where('dept_id', $dept_id)->first();


        $data['data_return']  =   MosUserTreeResource::collection($result);
        $variable = MosUserTreeResource::collection($result);
        $sumTotalTarget = 0;
        $sumTotalAchievement = 0;
        $sumTotalDue = 0;
        foreach ($variable as $key => $value) {
            $sumTotalTarget += $value['mostargetjoin']->january??0 + $value['mostargetjoin']->february??0 + $value['mostargetjoin']->march??0 + $value['mostargetjoin']->april??0 + $value['mostargetjoin']->may??0 + $value['mostargetjoin']->june??0 + $value['mostargetjoin']->july??0 + $value['mostargetjoin']->august??0 + $value['mostargetjoin']->september??0 + $value['mostargetjoin']->october??0 + $value['mostargetjoin']->november??0 + $value['mostargetjoin']->december??0;
            $sumTotalAchievement += ($value['mosuserachievementjoin']?$value['mosuserachievementjoin']->january:0) + ($value['mosuserachievementjoin']?$value['mosuserachievementjoin']->february:0) + ($value['mosuserachievementjoin']?$value['mosuserachievementjoin']->march:0) + ($value['mosuserachievementjoin']?$value['mosuserachievementjoin']->april:0) + ($value['mosuserachievementjoin']?$value['mosuserachievementjoin']->may:0) + ($value['mosuserachievementjoin']?$value['mosuserachievementjoin']->june:0) + ($value['mosuserachievementjoin']?$value['mosuserachievementjoin']->july:0) + ($value['mosuserachievementjoin']?$value['mosuserachievementjoin']->august:0) + ($value['mosuserachievementjoin']?$value['mosuserachievementjoin']->september:0) + ($value['mosuserachievementjoin']?$value['mosuserachievementjoin']->october:0) + ($value['mosuserachievementjoin']?$value['mosuserachievementjoin']->november:0) + ($value['mosuserachievementjoin']?$value['mosuserachievementjoin']->december:0);
            // $sumTotalAchievement += ($value['mosuserachievementjoin']?$value['mosuserachievementjoin']->total:0);
            
        }
        $sumTotalDue += $sumTotalTarget - $sumTotalAchievement;
        $data['sumTotalTarget'] = $sumTotalTarget;
        $data['sumTotalAchievement'] = $sumTotalAchievement;
        $data['sumTotalDue'] = $sumTotalDue;
        // echo $sumTotalTarget . "/" . $sumTotalAchievement;
        // return view('layouts.mos_data', $data);
        return view('layouts.mos_user_dashboard', $data);
        // dd($data);

        // return $this->sendResponse($data, 'K P I S retrieved successfully');
    }

    /**
     * Store a newly created MOS in storage.
     * POST /mOS
     *
     * @param CreateMOSAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateMOSAPIRequest $request)
    {

        try {
            DB::beginTransaction();
            $input = $request->all();
            $mOS = $this->mOSRepository->create($input);
            $data['mos_id'] = $mOS->id;
            $data['type'] = 'target';
            $data['dept_id'] = $request->dept_id;
            $data['year'] = $request->year;
            $this->mosDataRepository->create($data);

            $data2['mos_id'] = $mOS->id;
            $data2['type'] = 'module';
            $data2['dept_id'] = $request->dept_id;
            $data2['year'] = $request->year;
            $this->mosDataRepository->create($data2);

            $data3['mos_id'] = $mOS->id;
            $data3['type'] = 'achievement';
            $data3['dept_id'] = $request->dept_id;
            $data3['year'] = $request->year;
            $this->mosDataRepository->create($data3);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendError('Something went wrong');
        }

        return $this->sendResponse($mOS->toArray(), 'M O S saved successfully');
    }
    public function mos_update(Request $request)
    {
        $data = $request->all();
        $mosjoin = $data['arrayData']['mosjoin'];
        foreach ($mosjoin as $key => $value) {
            //`mos_id`, `user_id`, `dept_id`, `date`, `msg`, `month`, `fmonth`, `status`, `created_at`, `updated_at`, `deleted_at`SELECT * FROM `mos_feadbacks` WHERE 1
            $mos = array(
                'mos_name' => $value['mos_name'],
                'weightage' =>  $value['weightage'],
                'isvalorper' =>  $value['isvalorper'],
                'mos_calculation' =>  $value['mos_calculation']
            );
            if (isset($data['feedback'])) {
                $feedback = $data['feedback'];
                $user_data = Auth::guard('user')->user();
                $feed = array(
                    'mos_id' => $value['id'],
                    'user_id' => $user_data->id,
                    'dept_id' => $user_data->department,
                    'date' => Now()
                );
                if (isset($feedback['january_' . $value['id']])) {

                    $feed['msg'] =  $feedback['january_' . $value['id']];
                    $feed['fmonth'] = 1;

                    if (MosFeadback::where(['fmonth' => 1, 'mos_id' => $value['id']])->count() == 0) {
                        MosFeadback::create($feed);
                    } else {
                        MosFeadback::where(['fmonth' => 1, 'mos_id' => $value['id']])->update(['msg' => $feed['msg']]);
                    }
                }
                if (isset($feedback['february_' . $value['id']])) {
                    $feed['msg'] =  $feedback['february_' . $value['id']];
                    $feed['fmonth'] = 2;
                    //MosFeadback::create($feed); 

                    if (MosFeadback::where(['fmonth' => 2, 'mos_id' => $value['id']])->count() == 0) {
                        MosFeadback::create($feed);
                    } else {
                        MosFeadback::where(['fmonth' => 2, 'mos_id' => $value['id']])->update(['msg' => $feed['msg']]);
                    }
                }
                if (isset($feedback['march_' . $value['id']])) {
                    $feed['msg'] =  $feedback['march_' . $value['id']];
                    $feed['fmonth'] = 3;
                    //MosFeadback::create($feed); 
                    if (MosFeadback::where(['fmonth' => 3, 'mos_id' => $value['id']])->count() == 0) {
                        MosFeadback::create($feed);
                    } else {
                        MosFeadback::where(['fmonth' => 3, 'mos_id' => $value['id']])->update(['msg' => $feed['msg']]);
                    }
                }
                if (isset($feedback['april_' . $value['id']])) {
                    $feed['msg'] =  $feedback['april_' . $value['id']];
                    $feed['fmonth'] = 4;
                    //MosFeadback::create($feed); 
                    if (MosFeadback::where(['fmonth' => 4, 'mos_id' => $value['id']])->count() == 0) {
                        MosFeadback::create($feed);
                    } else {
                        MosFeadback::where(['fmonth' => 4, 'mos_id' => $value['id']])->update(['msg' => $feed['msg']]);
                    }
                }
                if (isset($feedback['may_' . $value['id']])) {
                    $feed['msg'] =  $feedback['may_' . $value['id']];
                    $feed['fmonth'] = 5;
                    //MosFeadback::create($feed); 
                    if (MosFeadback::where(['fmonth' => 5, 'mos_id' => $value['id']])->count() == 0) {
                        MosFeadback::create($feed);
                    } else {
                        MosFeadback::where(['fmonth' => 5, 'mos_id' => $value['id']])->update(['msg' => $feed['msg']]);
                    }
                }
                if (isset($feedback['june_' . $value['id']])) {
                    $feed['msg'] =  $feedback['june_' . $value['id']];
                    $feed['fmonth'] = 6;
                    //MosFeadback::create($feed); 
                    if (MosFeadback::where(['fmonth' => 6, 'mos_id' => $value['id']])->count() == 0) {
                        MosFeadback::create($feed);
                    } else {
                        MosFeadback::where(['fmonth' => 6, 'mos_id' => $value['id']])->update(['msg' => $feed['msg']]);
                    }
                }
                if (isset($feedback['july_' . $value['id']])) {
                    $feed['msg'] =  $feedback['july_' . $value['id']];
                    $feed['fmonth'] = 7;
                    // MosFeadback::create($feed); 

                    if (MosFeadback::where(['fmonth' => 7, 'mos_id' => $value['id']])->count() == 0) {
                        MosFeadback::create($feed);
                    } else {
                        MosFeadback::where(['fmonth' => 7, 'mos_id' => $value['id']])->update(['msg' => $feed['msg']]);
                    }
                }
                if (isset($feedback['august_' . $value['id']])) {
                    $feed['msg'] =  $feedback['august_' . $value['id']];
                    $feed['fmonth'] = 8;
                    //MosFeadback::create($feed); 
                    if (MosFeadback::where(['fmonth' => 8, 'mos_id' => $value['id']])->count() == 0) {
                        MosFeadback::create($feed);
                    } else {
                        MosFeadback::where(['fmonth' => 8, 'mos_id' => $value['id']])->update(['msg' => $feed['msg']]);
                    }
                }
                if (isset($feedback['september_' . $value['id']])) {
                    $feed['msg'] =  $feedback['september_' . $value['id']];
                    $feed['fmonth'] = 9;
                    //MosFeadback::create($feed); 
                    if (MosFeadback::where(['fmonth' => 9, 'mos_id' => $value['id']])->count() == 0) {
                        MosFeadback::create($feed);
                    } else {
                        MosFeadback::where(['fmonth' => 9, 'mos_id' => $value['id']])->update(['msg' => $feed['msg']]);
                    }
                }
                if (isset($feedback['october_' . $value['id']])) {
                    $feed['msg'] =  $feedback['october_' . $value['id']];
                    $feed['fmonth'] = 10;
                    // MosFeadback::create($feed); 
                    if (MosFeadback::where(['fmonth' => 10, 'mos_id' => $value['id']])->count() == 0) {
                        MosFeadback::create($feed);
                    } else {
                        MosFeadback::where(['fmonth' => 10, 'mos_id' => $value['id']])->update(['msg' => $feed['msg']]);
                    }
                }
                if (isset($feedback['november_' . $value['id']])) {
                    $feed['msg'] =  $feedback['november_' . $value['id']];
                    $feed['fmonth'] = 11;
                    // MosFeadback::create($feed); 
                    if (MosFeadback::where(['fmonth' => 11, 'mos_id' => $value['id']])->count() == 0) {
                        MosFeadback::create($feed);
                    } else {
                        MosFeadback::where(['fmonth' => 11, 'mos_id' => $value['id']])->update(['msg' => $feed['msg']]);
                    }
                }
                if (isset($feedback['december_' . $value['id']])) {
                    $feed['msg'] =  $feedback['december_' . $value['id']];
                    $feed['fmonth'] = 12;
                    // MosFeadback::create($feed); 
                    if (MosFeadback::where(['fmonth' => 12, 'mos_id' => $value['id']])->count() == 0) {
                        MosFeadback::create($feed);
                    } else {
                        MosFeadback::where(['fmonth' => 12, 'mos_id' => $value['id']])->update(['msg' => $feed['msg']]);
                    }
                }


                // print_r($feedback['july_'.$value['id']]);
            }
            $this->mOSRepository->update($mos, $value['id']);
            // MosData::where('id', $value['mostargetjoin']['id']) 
            //         ->update($value['mostargetjoin']);
            // MosData::where('id', $value['mosmodulejoin']['id']) 
            //         ->update($value['mosmodulejoin']);
            // MosData::where('id', $value['mosachievementjoin']['id']) 
            //         ->update($value['mosachievementjoin']);
            if ($value['mostargetjoin']) {
                $this->mosDataRepository->update($value['mostargetjoin'], $value['mostargetjoin']['id']);
            }
            if ($value['mosmodulejoin']) {
                $this->mosDataRepository->update($value['mosmodulejoin'], $value['mosmodulejoin']['id']);
            }
            if ($value['mosachievementjoin']) {
                $this->mosDataRepository->update($value['mosachievementjoin'], $value['mosachievementjoin']['id']);
            }
        }

        return $this->sendResponse($data, 'MOS retrieved successfully');
    }

    /**
     * Display the specified MOS.
     * GET|HEAD /mOS/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id, Request $request)
    {
        /** @var MOS $mOS */
        $mOS = $this->mOSRepository->find($id);

        if (empty($mOS)) {
            return $this->sendError('M O S not found');
        }


        $mOS = new MosItemResource($mOS);
        return $this->sendResponse($mOS, 'M O S retrieved successfully');
    }

    /**
     * Update the specified MOS in storage.
     * PUT/PATCH /mOS/{id}
     *
     * @param int $id
     * @param UpdateMOSAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMOSAPIRequest $request)
    {
        $input = $request->all();

        /** @var MOS $mOS */
        $mOS = $this->mOSRepository->find($id);

        if (empty($mOS)) {
            return $this->sendError('M O S not found');
        }

        $mOS = $this->mOSRepository->update($input, $id);

        return $this->sendResponse($mOS->toArray(), 'MOS updated successfully');
    }

    /**
     * Remove the specified MOS from storage.
     * DELETE /mOS/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var MOS $mOS */
        $mOS = $this->mOSRepository->find($id);

        if (empty($mOS)) {
            return $this->sendError('M O S not found');
        }

        $mOS->delete();

        return $this->sendSuccess('M O S deleted successfully');
    }
}
