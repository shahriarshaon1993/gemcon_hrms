<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDepartmentAPIRequest;
use App\Http\Requests\API\UpdateDepartmentAPIRequest;
use App\Models\Department;
use App\Model\Department as DepartmentSelect2;
use App\Models\MosData;
use App\Models\MOS;
use App\Repositories\DepartmentRepository;
use Illuminate\Http\Request;
use App\Http\Resources\DepartmentActivityResource;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\MosTreeResource;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Model\Employee;
use App\Models\DepartmentAssign;
use Auth;
use DB;

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
        // if ($user_data->role_id == 6 ||  $user_data->role_id == 7) {
        //     $request['id'] = $user_data->department;
        // } else {
        // $request['id'] = $user_data->department;
        // }
        $request['status'] = 1;

        $q = Department::where('department_status', 1);
        // if ($user_data->role_id == 6 ||  $user_data->role_id == 7) {
        // $q->where('id', $user_data->department);
        // } else {
        //     $q->whereIn('id', DepartmentAssign::select('dept_id')->where('user_id', $user_data->id)->get()->toArray());
        // }
        $departments = $q->get();

        return $this->sendResponse($departments->toArray(), 'Departments retrieved successfully');
    }


    function user_wise_emp(Request $request)
    {
        $sort_by = 'employees.' . $request->get('sortby');
        $sort_type = $request->get('sorttype');
        $employee_data = Employee::valid()->project()
            ->select(
                'employees.*',
                'employees.id as emp_id',
                'employee_personal_infos.*',
                'employee_personal_infos.id as emp_per_id',
                'employees.employee_mobile as employee_mobile',
                'departments.department_name',
                'designations.designation_name',
                'sections.section_name',
                'company_sbus.sbu_name'
            )
            ->leftJoin('employees as employees2', 'employees2.employee_id_no', '=', 'employees.employee_reporting_to')
            ->leftJoin('users_person', 'users_person.employee_id', '=', 'employees.id')
            ->leftJoin('employee_personal_infos', 'employee_personal_infos.employee_id', '=', 'employees.id')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->where('employees.employee_status', 1)
            ->where('employees.employee_sbu', Auth::guard('user')->user()->company_sbu)
            ->where('employees.employee_department', Auth::guard('user')->user()->department);
        // ->orWhere('post_description', 'like', '%'.$query.'%')
        if ($sort_type) {
            $employee_data->orderBy($sort_by, $sort_type);
        }
        if ($request->paginate) {
            $employee_data_directory = $employee_data->paginate(8);
            return $this->sendResponse($employee_data_directory->toArray(), 'User updated successfully');
        } else {
            $data = array();
            $employee_data_directory = $employee_data->get();
            // array_push($data, ['id' => '', 'text' => 'Deselect']);
            foreach ($employee_data_directory as $value) {
                array_push($data, ['id' => $value->emp_id, 'text' => $value->employee_fullname,]);
            }
            return $this->sendResponse($data, 'User updated successfully');
        }

    


        
    }

    public function department_setting(Request $request)
    {
        $user_data = Auth::guard('user')->user();
        // if ($user_data->role_id == 6 ||  $user_data->role_id == 7) {
        //     $request['id'] = $user_data->department;
        // } else {
        $request['id'] = $user_data->department;
        // }
        $request['status'] = 1;

        $q = Department::where('department_status', 1);
        // if ($user_data->role_id == 6 ||  $user_data->role_id == 7) {
        // $q->where('id', $user_data->department);
        // } else {
        // $q->whereIn('id', DepartmentAssign::select('dept_id')->where('user_id', $user_data->id)->get()->toArray());
        // }
        $departments = $q->get();
        $departments = DepartmentResource::collection($departments);
        return $this->sendResponse($departments, 'Departments retrieved successfully');
    }


    public function monthly_date_range(Request $request)
    {
        $user_data = Auth::guard('user')->user();
        // if ($user_data->role_id == 6 ||  $user_data->role_id == 7) {
        $request['id'] = $user_data->department;
        // } else {
        //     $request['id'] = $user_data->department;
        // }
        $request['status'] = 1;

        $q = Department::where('department_status', 1);
        // if ($user_data->role_id == 6 ||  $user_data->role_id == 7) {
        $q->where('id', $user_data->department);
        // } else {
        //     $q->whereIn('id', DepartmentAssign::select('dept_id')->where('user_id', $user_data->id)->get()->toArray());
        // }
        $departments = $q->get();
        $departments = DepartmentResource::collection($departments);
        return $this->sendResponse($departments, 'Departments retrieved successfully');
    }
    public function singel_dept($id, Request $request)
    {
        $department = $this->departmentRepository->find($id);
        $departments = new DepartmentResource($department);
        return $this->sendResponse($departments, 'Department retrieved successfully');
    }
    public function allDept(Request $request)
    {
        $user_data = Auth::guard('user')->user();
        // if ($user_data->role_id == 5 || $user_data->role_id == 6 ||  $user_data->role_id == 7) {
        $request['id'] = $user_data->department;
        // }
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
        $query =  Department::select('departments.*', 'department_assigns.id as  ass_id');
        $query->where('departments.status', 1);
        $query->where('department_assigns.user_id', $request['user_id']);
        $query->leftjoin('department_assigns', 'department_assigns.dept_id', '=', 'departments.id');
        $departments =  $query->get();
        return $this->sendResponse($departments->toArray(), 'Departments retrieved successfully');
    }


    public function monthly_activity(Request $request)
    {

        $user_data = Auth::guard('user')->user();


        // if($user_data->role_id == 5 || $user_data->role_id == 6 || $user_data->role_id == 7 ){
        //     $request['id'] = $user_data->department ;  
        // } 
        // $departments = $this->departmentRepository->all(
        //     $request->except(['skip', 'limit']),
        //     $request->get('skip'),
        //     $request->get('limit')
        // ); 

        $q = Department::where('department_status', 1);
        $q->where('iskra', 1);
        // if ($user_data->role_id == 6 ||  $user_data->role_id == 7) {
        $q->where('id', $user_data->department);
        // } else {
        //     $q->whereIn('id', DepartmentAssign::select('dept_id')->where('user_id', $user_data->id)->get()->toArray());
        // }
        // if($request->dept_id){
        //     $q->where('id',$request->dept_id);
        // }
        $departments = $q->get();



        foreach ($departments as $key => $value) {
            $task = MOS::limit(300);
            $task->where('dept_id', $value->id);
            $task->where('year', $request->year);
            $task->orderBy('kra_id', 'ASC');
            $task->orderBy('kpi_id', 'ASC');
            $task->orderBy('id', 'ASC');
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


            $monthwise_mos_january = 0;
            $monthwise_mos_february = 0;
            $monthwise_mos_march = 0;
            $monthwise_mos_april = 0;
            $monthwise_mos_may = 0;
            $monthwise_mos_june = 0;
            $monthwise_mos_july = 0;
            $monthwise_mos_august = 0;
            $monthwise_mos_september = 0;
            $monthwise_mos_october = 0;
            $monthwise_mos_november = 0;
            $monthwise_mos_december = 0;

            $total_kpi_weight = 0;
            $total_mos_weightage = 0;
            $value->mos = $data_return;

            if (sizeof($data_return) > 0) {
                foreach ($data_return  as $key2 => $value2) {
                    //if($value2->iskra == '1'){
                    $achievement = $value2->mosachievementjoin($request);
                    $target = $value2->mostargetjoin($request);
                    $kpi = $value2->kpijoin;



                    if (!empty($target)) {
                        if ($value2->weightage != '') {
                            $total_mos_weightage += $value2->weightage;
                        }
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
                        //}

                        //echo "$target->january  && $achievement->january ||";
                        //echo "$kpi";
                        $total_kpi_weight += $kpi->kpi_weight;





                        if ($target->january > 0) {
                            if ($achievement->january > 0) {
                                //echo " $kpi->weight ||";

                                if ($value2->mos_calculation == '1' || $value2->mos_calculation ==  '3') {
                                    $tscore = (($target->january / $achievement->january) * $value2->weightage);
                                } elseif ($value2->mos_calculation == '0' || $value2->mos_calculation == '2' || $value2->mos_calculation == '') {
                                    $tscore = (($achievement->january / $target->january) * $value2->weightage);
                                } else {
                                    $tscore = 0;
                                }
                            }


                            $monthwise_score_january += ($tscore > $value2->weightage ? $value2->weightage : $tscore);

                            $monthwise_mos_january += $value2->weightage;
                            //$monthwise_score_january += 1;
                        }
                        if ($target->february > 0) {
                            if ($achievement->february > 0) {
                                if ($value2->mos_calculation == '1' || $value2->mos_calculation ==  '3') {
                                    $tscore = (($target->february / $achievement->february) * $value2->weightage);
                                } elseif ($value2->mos_calculation == '0' || $value2->mos_calculation == '2' || $value2->mos_calculation == '') {
                                    $tscore = (($achievement->february / $target->february) * $value2->weightage);
                                }
                            } else {
                                $tscore = 0;
                            }
                            $monthwise_score_february += ($tscore > $value2->weightage ? $value2->weightage : $tscore);
                            $monthwise_mos_february += $value2->weightage;
                        }
                        if ($target->march > 0) {
                            if ($achievement->march > 0) {
                                if ($value2->mos_calculation == '1' || $value2->mos_calculation ==  '3') {
                                    $tscore = (($target->march / $achievement->march) * $value2->weightage);
                                } elseif ($value2->mos_calculation == '0' || $value2->mos_calculation == '2' || $value2->mos_calculation == '') {
                                    $tscore = (($achievement->march / $target->march) * $value2->weightage);
                                }
                            } else {
                                $tscore = 0;
                            }
                            $monthwise_score_march += ($tscore > $value2->weightage ? $value2->weightage : $tscore);
                            $monthwise_mos_march += $value2->weightage;
                        }

                        if ($target->april > 0) {
                            if ($achievement->april > 0) {
                                if ($value2->mos_calculation == '1' || $value2->mos_calculation ==  '3') {
                                    $tscore = (($target->april / $achievement->april) * $value2->weightage);
                                } elseif ($value2->mos_calculation == '0' || $value2->mos_calculation == '2' || $value2->mos_calculation == '') {
                                    $tscore = (($achievement->april / $target->april) * $value2->weightage);
                                }
                            } else {
                                $tscore = 0;
                            }
                            $monthwise_score_april += ($tscore > $value2->weightage ? $value2->weightage : $tscore);
                            $monthwise_mos_april += $value2->weightage;
                        }
                        if ($target->may > 0) {
                            if ($achievement->may > 0) {
                                if ($value2->mos_calculation == '1' || $value2->mos_calculation ==  '3') {
                                    $tscore = (($target->may / $achievement->may) * $value2->weightage);
                                } elseif ($value2->mos_calculation == '0' || $value2->mos_calculation == '2' || $value2->mos_calculation == '') {
                                    $tscore = (($achievement->may / $target->may) * $value2->weightage);
                                }
                            } else {
                                $tscore = 0;
                            }
                            $monthwise_score_may += ($tscore > $value2->weightage ? $value2->weightage : $tscore);
                            $monthwise_mos_may += $value2->weightage;
                        }
                        if ($target->june > 0) {
                            if ($achievement->june > 0) {
                                if ($value2->mos_calculation == '1' || $value2->mos_calculation ==  '3') {
                                    $tscore = (($target->june / $achievement->june) * $value2->weightage);
                                } elseif ($value2->mos_calculation == '0' || $value2->mos_calculation == '2' || $value2->mos_calculation == '') {
                                    $tscore = (($achievement->june / $target->june) * $value2->weightage);
                                }
                            } else {
                                $tscore = 0;
                            }
                            $monthwise_score_june += ($tscore > $value2->weightage ? $value2->weightage : $tscore);
                            $monthwise_mos_june += $value2->weightage;
                        }
                        if ($target->july > 0) {
                            if ($achievement->july > 0) {
                                if ($value2->mos_calculation == '1' || $value2->mos_calculation ==  '3') {
                                    $tscore = (($target->july / $achievement->july) * $value2->weightage);
                                } elseif ($value2->mos_calculation == '0' || $value2->mos_calculation == '2' || $value2->mos_calculation == '') {
                                    $tscore = (($achievement->july / $target->july) * $value2->weightage);
                                }
                            } else {
                                $tscore = 0;
                            }
                            $monthwise_score_july += ($tscore > $value2->weightage ? $value2->weightage : $tscore);
                            $monthwise_mos_july += $value2->weightage;
                        }
                        if ($target->august > 0) {
                            if ($achievement->august > 0) {
                                if ($value2->mos_calculation == '1' || $value2->mos_calculation ==  '3') {
                                    $tscore = (($target->august / $achievement->august) * $value2->weightage);
                                } elseif ($value2->mos_calculation == '0' || $value2->mos_calculation == '2' || $value2->mos_calculation == '') {
                                    $tscore = (($achievement->august / $target->august) * $value2->weightage);
                                }
                            } else {
                                $tscore = 0;
                            }
                            $monthwise_score_august += ($tscore > $value2->weightage ? $value2->weightage : $tscore);
                            $monthwise_mos_august += $value2->weightage;
                        }

                        if ($target->september > 0) {
                            if ($achievement->september > 0) {
                                if ($value2->mos_calculation == '1' || $value2->mos_calculation ==  '3') {
                                    $tscore = (($target->september / $achievement->september) * $value2->weightage);
                                } elseif ($value2->mos_calculation == '0' || $value2->mos_calculation == '2' || $value2->mos_calculation == '') {
                                    $tscore = (($achievement->september / $target->september) * $value2->weightage);
                                }
                            } else {
                                $tscore = 0;
                            }
                            $monthwise_score_september += ($tscore > $value2->weightage ? $value2->weightage : $tscore);
                            $monthwise_mos_september += $value2->weightage;
                        }

                        if ($target->october > 0) {
                            if ($achievement->october > 0) {
                                if ($value2->mos_calculation == '1' || $value2->mos_calculation ==  '3') {
                                    $tscore = (($target->october / $achievement->october) * $value2->weightage);
                                } elseif ($value2->mos_calculation == '0' || $value2->mos_calculation == '2' || $value2->mos_calculation == '') {
                                    $tscore = (($achievement->october / $target->october) * $value2->weightage);
                                }
                            } else {
                                $tscore = 0;
                            }
                            $monthwise_score_october += ($tscore > $value2->weightage ? $value2->weightage : $tscore);
                            $monthwise_mos_october += $value2->weightage;
                        }
                        if ($target->november > 0) {
                            if ($achievement->november > 0) {
                                if ($value2->mos_calculation == '1' || $value2->mos_calculation ==  '3') {
                                    $tscore = (($target->november / $achievement->november) * $value2->weightage);
                                } elseif ($value2->mos_calculation == '0' || $value2->mos_calculation == '2' || $value2->mos_calculation == '') {
                                    $tscore = (($achievement->november / $target->november) * $value2->weightage);
                                }
                            } else {
                                $tscore = 0;
                            }
                            $monthwise_score_november += ($tscore > $value2->weightage ? $value2->weightage : $tscore);
                            $monthwise_mos_november += $value2->weightage;
                        }

                        if ($target->december > 0) {
                            if ($achievement->december > 0) {
                                if ($value2->mos_calculation == '1' || $value2->mos_calculation ==  '3') {
                                    $tscore = (($target->december / $achievement->december) * $value2->weightage);
                                } elseif ($value2->mos_calculation == '0' || $value2->mos_calculation == '2' || $value2->mos_calculation == '') {
                                    $tscore = (($achievement->december / $target->december) * $value2->weightage);
                                }
                            } else {
                                $tscore = 0;
                            }
                            $monthwise_score_december += ($tscore > $value2->weightage ? $value2->weightage : $tscore);
                            $monthwise_mos_december += $value2->weightage;
                        }
                    }
                }



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
                $value->mos_weightage = array(
                    'january' => $monthwise_mos_january,
                    'february' => $monthwise_mos_february,
                    'march' => $monthwise_mos_march,
                    'april' => $monthwise_mos_april,
                    'may' => $monthwise_mos_may,
                    'june' => $monthwise_mos_june,
                    'july' => $monthwise_mos_july,
                    'august' => $monthwise_mos_august,
                    'september' => $monthwise_mos_september,
                    'october' => $monthwise_mos_october,
                    'november' => $monthwise_mos_november,
                    'december' => $monthwise_mos_december,
                );
                $value->total_kpi_weight = $total_kpi_weight;
                //$value->mos_weightage = $total_mos_weightage ;
            }
        }
        //echo json_decode(json_encode($departments));exit;

        // $items = DepartmentActivityResource::collection($departments); 
        return $this->sendResponse($departments, 'Departments retrieved successfully 111111');
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
        //$department = $this->departmentRepository->find($id);

        $department = $this->departmentRepository->getListById($id);


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

        //DELETE PREVIOUS ASSIGNED FACTORY
        DB::table('department_factories')->where('dept_id', $id)->delete();


        //INSERT ASSIGNED NEW FACTORY
        $departmentFactoryAssignArrayData = array();
        if (isset($request->factory_id)) {
            foreach ($request->factory_id as $factory) {
                $departmentFactoryAssignData['dept_id'] = $id;
                $departmentFactoryAssignData['factory_id'] = $factory;

                $departmentFactoryAssignArrayData[] = $departmentFactoryAssignData;
            }

            DB::table('department_factories')->insert($departmentFactoryAssignArrayData);
        }


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

    public function departmentSelect2()
    {
        $data = array();
        $department_data = DepartmentSelect2::valid()->project()->orderBy('department_name', 'asc')->get();
        array_push($data, ['id' => '', 'text' => 'Deselect']);
        foreach ($department_data as $value) {
            array_push($data, ['id' => $value['id'], 'text' => $value['department_name'],]);
        }
        return $this->sendResponse($data, 'Department updated successfully');
    }
}
