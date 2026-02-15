<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDepartmentAPIRequest;
use App\Http\Requests\API\UpdateDepartmentAPIRequest;
use App\Models\Department;
use App\Models\MosData; 
use App\Models\MOS; 
use App\Repositories\DepartmentRepository;
use Illuminate\Http\Request;
use App\Http\Resources\DepartmentActivityResource;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\MosTreeResource;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\DepartmentAssign;
use Auth ;

/**
 * Class DepartmentController
 * @package App\Http\Controllers\API
 */

class DepartmentAPIController extends AppBaseController
{
    /** @var  DepartmentRepository */
    private $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepo)
    {
        $this->departmentRepository = $departmentRepo;
    }

    /**
     * Display a listing of the Department.
     * GET|HEAD /departments
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user_data = Auth::guard('user')->user();
        if($user_data->role_id == 6 ||  $user_data->role_id == 7 ){
            $request['id'] = $user_data->department ;
        }else{
            $request['id'] = $user_data->department ;
        } 
        $request['status'] = 1 ;

        $q = Department::where('status',1);
        if($user_data->role_id == 6 ||  $user_data->role_id == 7 ){
            $q->where('id', $user_data->department) ;
        }else{
            $q->whereIn('id', DepartmentAssign::select('dept_id')->where('user_id',$user_data->id)->get()->toArray());
        }
        $departments = $q->get();
      
        return $this->sendResponse($departments->toArray(), 'Departments retrieved successfully');
    }
    public function department_setting(Request $request)
    {
        $user_data = Auth::guard('user')->user();
        if($user_data->role_id == 6 ||  $user_data->role_id == 7 ){
            $request['id'] = $user_data->department ;
        }else{
            $request['id'] = $user_data->department ;
        } 
        $request['status'] = 1 ;

        $q = Department::where('status',1);
        if($user_data->role_id == 6 ||  $user_data->role_id == 7 ){
            $q->where('id', $user_data->department) ;
        }else{
            $q->whereIn('id', DepartmentAssign::select('dept_id')->where('user_id',$user_data->id)->get()->toArray());
        }
        $departments = $q->get();
        $departments = DepartmentResource::collection($departments);
        return $this->sendResponse($departments, 'Departments retrieved successfully');
    }
    public function monthly_date_range(Request $request)
    {
        $user_data = Auth::guard('user')->user();
        if($user_data->role_id == 6 ||  $user_data->role_id == 7 ){
            $request['id'] = $user_data->department ;
        }else{
            $request['id'] = $user_data->department ;
        } 
        $request['status'] = 1 ;

        $q = Department::where('status',1);
        if($user_data->role_id == 6 ||  $user_data->role_id == 7 ){
            $q->where('id', $user_data->department) ;
        }else{
            $q->whereIn('id', DepartmentAssign::select('dept_id')->where('user_id',$user_data->id)->get()->toArray());
        }
        $departments = $q->get();
        $departments = DepartmentResource::collection($departments);
        return $this->sendResponse($departments, 'Departments retrieved successfully');
    }
    public function singel_dept($id ,Request $request)
    { 
        $department = $this->departmentRepository->find( $id); 
        $departments = New DepartmentResource($department);
        return $this->sendResponse($departments, 'Department retrieved successfully');
    }
    public function allDept(Request $request)
    {
        $user_data = Auth::guard('user')->user();
        if($user_data->role_id == 5 || $user_data->role_id == 6 ||  $user_data->role_id == 7 ){
            $request['id'] = $user_data->department ;
        } 
       // $request['status'] = 1 ;
        
        $departments = $this->departmentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($departments->toArray(), 'Departments retrieved successfully');
    }
    public function dept_permission(Request $request)
    {
        $user_data = Auth::guard('user')->user(); 
        $query =  Department:: select('departments.*', 'department_assigns.id as  ass_id'); 
        $query->where('departments.status',1);
        $query->where('department_assigns.user_id',$request['user_id']);
        $query->leftjoin('department_assigns','department_assigns.dept_id', '=', 'departments.id');
        $departments =  $query->get(); 
        return $this->sendResponse($departments->toArray(), 'Departments retrieved successfully');
    }
    public function monthly_activity(Request $request){
        $user_data = Auth::guard('user')->user();
        // if($user_data->role_id == 5 || $user_data->role_id == 6 || $user_data->role_id == 7 ){
        //     $request['id'] = $user_data->department ;  
        // } 
        // $departments = $this->departmentRepository->all(
        //     $request->except(['skip', 'limit']),
        //     $request->get('skip'),
        //     $request->get('limit')
        // ); 

        $q = Department::where('status',1);
        $q->where('iskra', 1 ) ;
        if($user_data->role_id == 6 ||  $user_data->role_id == 7 ){
            $q->where('id', $user_data->department) ;
        }else{
            $q->whereIn('id', DepartmentAssign::select('dept_id')->where('user_id',$user_data->id)->get()->toArray());
        }
        $departments = $q->get();
        foreach ($departments as $key => $value) {
            $task =MOS::limit(300); 
            $task->where('dept_id', $value->id);
            $task->orderBy('kra_id','ASC');
            $task->orderBy('kpi_id','ASC'); 
            $task->orderBy('id','ASC');  
            $result  = $task->get();
            $data_return  =   MosTreeResource::collection($result);
            $total_target = 0;
            $total_acheivement = 0;
            $total_score = 0;
            $dept_score = [];
            

            $monthwise_target_january = 0;
            $monthwise_target_february = 0;
            $monthwise_target_march = 0;
            $monthwise_target_april = 0;
            $monthwise_target_may = 0;
            $monthwise_target_june = 0;
            $monthwise_target_july = 0;
            $monthwise_target_august = 0;
            $monthwise_target_september = 0;
            $monthwise_target_october = 0;
            $monthwise_target_november = 0;
            $monthwise_target_december = 0;



            $monthwise_achievement_january = 0;
            $monthwise_achievement_february = 0;
            $monthwise_achievement_march = 0;
            $monthwise_achievement_april = 0;
            $monthwise_achievement_may = 0;
            $monthwise_achievement_june = 0;
            $monthwise_achievement_july = 0;
            $monthwise_achievement_august = 0;
            $monthwise_achievement_september = 0;
            $monthwise_achievement_october = 0;
            $monthwise_achievement_november = 0;
            $monthwise_achievement_december = 0;

            $monthwise_score_january = 0;
            $monthwise_score_february = 0;
            $monthwise_score_march = 0;
            $monthwise_score_april = 0;
            $monthwise_score_may = 0;
            $monthwise_score_june = 0;
            $monthwise_score_july = 0;
            $monthwise_score_august = 0;
            $monthwise_score_september = 0;
            $monthwise_score_october = 0;
            $monthwise_score_november = 0;
            $monthwise_score_december = 0;


            foreach ($data_return  as $key2 => $value2) {
                $achievement = $value2->mosachievementjoin ;
                $target = $value2->mostargetjoin;
                $kpi = $value2->kpijoin;

                $monthwise_target_january += $target->january;
                $monthwise_target_february += $target->february;
                $monthwise_target_march += $target->march;
                $monthwise_target_april += $target->april;
                $monthwise_target_may += $target->may;
                $monthwise_target_june += $target->june;
                $monthwise_target_july += $target->july;
                $monthwise_target_august += $target->august;
                $monthwise_target_september += $target->september;
                $monthwise_target_october += $target->october;
                $monthwise_target_november += $target->november;
                $monthwise_target_december += $target->december;



                $monthwise_achievement_january += $achievement->january;
                $monthwise_achievement_february += $achievement->february;
                $monthwise_achievement_march += $achievement->march;
                $monthwise_achievement_april += $achievement->april;
                $monthwise_achievement_may += $achievement->may;
                $monthwise_achievement_june += $achievement->june;
                $monthwise_achievement_july += $achievement->july;
                $monthwise_achievement_august += $achievement->august;
                $monthwise_achievement_september += $achievement->september;
                $monthwise_achievement_october += $achievement->october;
                $monthwise_achievement_november += $achievement->november;
                $monthwise_achievement_december += $achievement->december;


                //echo "$target->january  && $achievement->january ||";
                //echo "$kpi";

                if( $target->january > 0 && $achievement->january > 0 ){
                     //echo " $kpi->weight ||";
                    if($value2->mos_calculation == '' || $value2->mos_calculation == '0' || $value2->mos_calculation == '2'){
                        $monthwise_score_january += (($target->january / $achievement->january) * $kpi->kpi_weight);
                    }elseif($value2->mos_calculation == '1' || $value2->mos_calculation == '3'){
                        $monthwise_score_january += (($achievement->january / $target->january) * $kpi->kpi_weight); 
                    }
                    //$monthwise_score_january += 1;
                }
                if($target->february > 0 && $achievement->february > 0){
                    if($value2->mos_calculation == '' || $value2->mos_calculation == '0' || $value2->mos_calculation == '2'){
                        $tscore = (($target->february / $achievement->february) * $kpi->kpi_weight);
                    }elseif($value2->mos_calculation == '1' || $value2->mos_calculation == '3'){
                        $tscore = (($achievement->february / $target->february) * $kpi->kpi_weight); 
                    }
                    $monthwise_score_february += $tscore;
                }
                if($target->march > 0 && $achievement->march > 0){
                    if($value2->mos_calculation == '' || $value2->mos_calculation == '0' || $value2->mos_calculation == '2'){
                        $tscore = (($target->march / $achievement->march) * $kpi->kpi_weight);
                    }elseif($value2->mos_calculation == '1' || $value2->mos_calculation == '3'){
                        $tscore = (($achievement->march / $target->march) * $kpi->kpi_weight); 
                    }
                    $monthwise_score_march += $tscore;
                }

                if($target->april > 0 && $achievement->april > 0){
                    if($value2->mos_calculation == '' || $value2->mos_calculation == '0' || $value2->mos_calculation == '2'){
                        $tscore = (($target->april / $achievement->april) * $kpi->kpi_weight);
                    }elseif($value2->mos_calculation == '1' || $value2->mos_calculation == '3'){
                        $tscore = (($achievement->april / $target->april) * $kpi->kpi_weight); 
                    }
                    $monthwise_score_april += $tscore;
                }
                if($target->may > 0 && $achievement->may > 0){
                    if($value2->mos_calculation == '' || $value2->mos_calculation == '0' || $value2->mos_calculation == '2'){
                        $tscore = (($target->may / $achievement->may) * $kpi->kpi_weight);
                    }elseif($value2->mos_calculation == '1' || $value2->mos_calculation == '3'){
                        $tscore = (($achievement->may / $target->may) * $kpi->kpi_weight); 
                    }
                    $monthwise_score_may += $tscore;
                }
                if($target->june > 0 && $achievement->june > 0){
                    if($value2->mos_calculation == '' || $value2->mos_calculation == '0' || $value2->mos_calculation == '2'){
                        $tscore = (($target->june / $achievement->june) * $kpi->kpi_weight);
                    }elseif($value2->mos_calculation == '1' || $value2->mos_calculation == '3'){
                        $tscore = (($achievement->june / $target->june) * $kpi->kpi_weight); 
                    }
                    $monthwise_score_june += $tscore;
                }
                if($target->july > 0 && $achievement->july > 0){
                    if($value2->mos_calculation == '' || $value2->mos_calculation == '0' || $value2->mos_calculation == '2'){
                        $tscore = (($target->july / $achievement->july) * $kpi->kpi_weight);
                    }elseif($value2->mos_calculation == '1' || $value2->mos_calculation == '3'){
                        $tscore = (($achievement->july / $target->july) * $kpi->kpi_weight); 
                    }
                    $monthwise_score_july += $tscore;
                }
                if($target->august > 0 && $achievement->august > 0){
                    if($value2->mos_calculation == '' || $value2->mos_calculation == '0' || $value2->mos_calculation == '2'){
                        $tscore = (($target->august / $achievement->august) * $kpi->kpi_weight);
                    }elseif($value2->mos_calculation == '1' || $value2->mos_calculation == '3'){
                        $tscore = (($achievement->august / $target->august) * $kpi->kpi_weight); 
                    }
                    $monthwise_score_august += $tscore;
                }

                if($target->september > 0 && $achievement->september > 0){
                    if($value2->mos_calculation == '' || $value2->mos_calculation == '0' || $value2->mos_calculation == '2'){
                        $tscore = (($target->september / $achievement->september) * $kpi->kpi_weight);
                    }elseif($value2->mos_calculation == '1' || $value2->mos_calculation == '3'){
                        $tscore = (($achievement->september / $target->september) * $kpi->kpi_weight); 
                    }
                    $monthwise_score_september += $tscore;
                }

                if($target->october > 0 && $achievement->october > 0){
                    if($value2->mos_calculation == '' || $value2->mos_calculation == '0' || $value2->mos_calculation == '2'){
                        $tscore = (($target->october / $achievement->october) * $kpi->kpi_weight);
                    }elseif($value2->mos_calculation == '1' || $value2->mos_calculation == '3'){
                        $tscore = (($achievement->october / $target->october) * $kpi->kpi_weight); 
                    }
                    $monthwise_score_october += $tscore;
                }
                if($target->november > 0 && $achievement->november > 0){
                    if($value2->mos_calculation == '' || $value2->mos_calculation == '0' || $value2->mos_calculation == '2'){
                        $tscore = (($target->november / $achievement->november) * $kpi->kpi_weight);
                    }elseif($value2->mos_calculation == '1' || $value2->mos_calculation == '3'){
                        $tscore = (($achievement->november / $target->november) * $kpi->kpi_weight); 
                    }
                    $monthwise_score_november += $tscore;
                }

                if($target->december > 0 && $achievement->december > 0){
                    if($value2->mos_calculation == '' || $value2->mos_calculation == '0' || $value2->mos_calculation == '2'){
                        $tscore = (($target->december / $achievement->december) * $kpi->kpi_weight);
                    }elseif($value2->mos_calculation == '1' || $value2->mos_calculation == '3'){
                        $tscore = (($achievement->december / $target->december) * $kpi->kpi_weight); 
                    }
                    $monthwise_score_october += $tscore;
                }
                



           

                
            }
           // $value->mos = $data_return ;
            
            $value->target = array(
                'january' => $monthwise_target_january,
                'february' => $monthwise_target_february,
                'march' => $monthwise_target_march,
                'april' => $monthwise_target_april,
                'may' => $monthwise_target_may,
                'june' => $monthwise_target_june,
                'july' => $monthwise_target_july,
                'august' => $monthwise_target_august,
                'september' => $monthwise_target_september,
                'october' => $monthwise_target_october,
                'november' => $monthwise_target_november,
                'december' => $monthwise_target_december,
            );
            $value->achievement = array(
                'january' => $monthwise_achievement_january,
                'february' => $monthwise_achievement_february,
                'march' => $monthwise_achievement_march,
                'april' => $monthwise_achievement_april,
                'may' => $monthwise_achievement_may,
                'june' => $monthwise_achievement_june,
                'july' => $monthwise_achievement_july,
                'august' => $monthwise_achievement_august,
                'september' => $monthwise_achievement_september,
                'october' => $monthwise_achievement_october,
                'november' => $monthwise_achievement_november,
                'december' => $monthwise_achievement_december,
            );
            $value->score = array(
                'january' => $monthwise_score_january,
                'february' => $monthwise_score_february,
                'march' => $monthwise_score_march,
                'april' => $monthwise_score_april,
                'may' => $monthwise_score_may,
                'june' => $monthwise_score_june,
                'july' => $monthwise_score_july,
                'august' => $monthwise_score_august,
                'september' => $monthwise_score_september,
                'october' => $monthwise_score_october,
                'november' => $monthwise_score_november,
                'december' => $monthwise_score_december,
            );
            //$value->score = $dept_score ;
        }


       // $items = DepartmentActivityResource::collection($departments); 
        return $this->sendResponse($departments, 'Departments retrieved successfully');
    }

    /**
     * Store a newly created Department in storage.
     * POST /departments
     *
     * @param CreateDepartmentAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDepartmentAPIRequest $request)
    {
        $input = $request->all();

        $department = $this->departmentRepository->create($input);

        return $this->sendResponse($department->toArray(), 'Department saved successfully');
    }

    /**
     * Display the specified Department.
     * GET|HEAD /departments/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Department $department */
        $department = $this->departmentRepository->find($id);

        if (empty($department)) {
            return $this->sendError('Department not found');
        }

        return $this->sendResponse($department->toArray(), 'Department retrieved successfully');
    }

    /**
     * Update the specified Department in storage.
     * PUT/PATCH /departments/{id}
     *
     * @param int $id
     * @param UpdateDepartmentAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDepartmentAPIRequest $request)
    {
        $input = $request->all();

        /** @var Department $department */
        $department = $this->departmentRepository->find($id);

        if (empty($department)) {
            return $this->sendError('Department not found');
        }

        $department = $this->departmentRepository->update($input, $id);

        return $this->sendResponse($department->toArray(), 'Department updated successfully');
    }

    /**
     * Remove the specified Department from storage.
     * DELETE /departments/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Department $department */
        $department = $this->departmentRepository->find($id);

        if (empty($department)) {
            return $this->sendError('Department not found');
        }

        $department->delete();

        return $this->sendSuccess('Department deleted successfully');
    }
}
