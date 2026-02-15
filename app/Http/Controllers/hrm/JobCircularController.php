<?php
namespace App\Http\Controllers\hrm;
use App\JobAlert;
use App\Mail\JobAlertMail;
use App\Mail\ShortlistMail;
use App\Models\Talent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UsersPersonModel;
use App\Model\JobCircular;
use App\Model\Employee;
use App\Model\CompanySbu;
use App\Model\Section;
use App\Model\Department;
use App\Model\Designation;
use App\Model\JobGrade;
use App\Model\SubUnit;
use App\Model\WorkLocation;
use App\Model\EmployeePersonalInfo;
use App\Model\EmployeeAdressDetail;
use App\Model\EmployeeIdentificationSupporting;
use App\Model\EmployeeEducationalQualification;
use App\Model\EmployeeReference;
use App\Model\EmployeeProfessionalQualification;
use App\Model\EmployeeEmploymentHistory;
use App\Model\EmployeeFamilyDetail;
use App\Model\EmployeeTrainingRecord;
use App\Model\EmployeeProfessionalMembership;
use App\Model\EmployeeBankAccountDetail;
use App\Model\EmployeeEmergencyContact;
use App\Model\JobApplyCandidate;
use App\Mail\DemoMail;
use Illuminate\Support\Facades\Mail;
use permission;
use Cache;
use Auth;
use DB;
// use Request;

class JobCircularController extends Controller
{
    public function index(Request $request)
    {
        $authUser = Auth::guard('user')->user();

        // Fetch and filter permissions from cache
        $permissions = collect(Cache::get('permission'))
            ->where('menu_uid', 'JobCircular')
            ->where('role_id', $authUser->role_id)
            ->toArray();

        // Map permissions to data array
        $data = [];
        foreach ($permissions as $permission) {
            $link_uid = $permission['link_uid'];
            $data[$link_uid] = $link_uid;
        }

        // Retrieve request parameters
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $project_id = Auth::guard('user')->user()->project_id;

        // Build base query for job circulars
        $query = JobCircular::valid()
            ->project()
            ->leftJoin('employees', 'employees.id', '=', 'job_circulars.jc_person_assign')
            ->leftJoin('designations', 'designations.id', '=', 'job_circulars.jc_job_position')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'job_circulars.jc_job_location')
            ->select(
                'job_circulars.*',
                'employees.employee_fullname',
                'designations.designation_name',
                'work_locations.work_location_name'
            )
            ->where('job_circulars.project_id', $project_id);

        // Apply search filter if search_key is provided
        if ($search_key) {
            $query->where(function ($query) use ($search_key) {
                $query->where('job_circulars.jc_company_name', 'LIKE', "%{$search_key}%")
                    ->orWhere('employees.employee_fullname', 'LIKE', "%{$search_key}%");
            });
        }

        // Apply sorting
        $query->orderBy($sort, $order);

        // Fetch and process data
        $job_circulars = $query->get();
        $data['total_data'] = count($job_circulars);
        $data['active_data'] = count(collect($job_circulars)->where('jc_circular_status', 1));
        $data['inactive_data'] = count(collect($job_circulars)->where('jc_circular_status', 0));
        $data['paginate_data'] = $query->paginate($paginate_num);

        // Fetch candidate counts
        $data['apply_candidate_count'] = DB::table('job_apply_candidates')
            ->leftJoin('job_circulars', 'job_circulars.id', '=', 'job_apply_candidates.jac_job_circular_id')
            ->select('job_circulars.id as circular_id', DB::raw('count(job_apply_candidates.id) as total_candidate'))
            ->where('job_circulars.jc_circular_status', 1)
            ->groupBy('job_apply_candidates.jac_job_circular_id')
            ->get();

        $data['shorlist_candidate_count'] = DB::table('job_apply_candidates')
            ->leftJoin('job_circulars', 'job_circulars.id', '=', 'job_apply_candidates.jac_job_circular_id')
            ->select('job_circulars.id as circular_id', DB::raw('count(job_apply_candidates.id) as total_candidate'))
            ->where('job_circulars.jc_circular_status', 1)
            ->where('job_apply_candidates.jac_status', 2)
            ->groupBy('job_apply_candidates.jac_job_circular_id')
            ->get();

        $data['selected_candidate_count'] = DB::table('job_apply_candidates')
            ->leftJoin('job_circulars', 'job_circulars.id', '=', 'job_apply_candidates.jac_job_circular_id')
            ->select('job_circulars.id as circular_id', DB::raw('count(job_apply_candidates.id) as total_candidate'))
            ->where('job_circulars.jc_circular_status', 1)
            ->where('job_apply_candidates.jac_status', 3)
            ->groupBy('job_apply_candidates.jac_job_circular_id')
            ->get();

        return response()->json($data);
    }

    public function create()
    {
        $authUser = Auth::guard('user')->user();

        // return response($department_data);
        $data['company_sbu_data'] = array();
        $data['section_data'] = array();
        $data['sub_unit_data'] = array();
        $data['work_location_data'] = array();
        $data['department_data'] = array();
        $data['designation_data'] = array();
        $data['jobgrade_data'] = array();
        $data['employee_data'] = array();
        $company_sbu_data = CompanySbu::valid()->project()->orderBy('priority', 'ASC')->get();
        $section_data = Section::valid()->project()->orderBy('priority', 'ASC')->get();

        $departmentIds = [
            3, 6, 8, 9, 10, 13, 17, 20, 27, 28, 31, 33, 35, 36, 37, 38, 39,
            42, 46, 48, 60, 63, 65, 66, 68, 69, 78, 93, 96, 107, 121
        ];

        $department_data = Department::valid()->project()
            ->whereIn('id', $departmentIds)
            ->orderBy('department_name', 'ASC')
            ->get();

        $designation_data = Designation::valid()->project()->orderBy('priority', 'ASC')->get();

        $jobgrade_data = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get();
        $employee_data = Employee::valid()->project()->get();
        $sub_unit_data = SubUnit::valid()->project()->orderBy('priority', 'ASC')->get();
        $work_location_data = WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get();
        foreach ($company_sbu_data as $value) {
            array_push($data['company_sbu_data'], ['id' => $value['id'], 'text' => $value['sbu_name']]);
        }
        foreach ($section_data as $value) {
            array_push($data['section_data'], ['id' => $value['id'], 'text' => $value['section_name']]);
        }
        foreach ($department_data as $value) {
            array_push($data['department_data'], ['id' => $value['id'], 'text' => $value['department_name']]);
        }
        foreach ($designation_data as $value) {
            array_push($data['designation_data'], ['id' => $value['id'], 'text' => $value['designation_name']]);
        }
        foreach ($jobgrade_data as $value) {
            array_push($data['jobgrade_data'], ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
        }
        foreach ($employee_data as $value) {
            array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_fullname']]);
        }
        foreach ($sub_unit_data as $value) {
            array_push($data['sub_unit_data'], ['id' => $value['id'], 'text' => $value['sub_unit_name']]);
        }
        foreach ($work_location_data as $value) {
            array_push($data['work_location_data'], ['id' => $value['id'], 'text' => $value['work_location_name']]);
        }
        $data['jc_circular_publish_date'] = date('Y-m-d');
        $data['jc_circular_expired_date'] = date('Y-m-d');

        // auth user current sbu
        $currentSbu = CompanySbu::where('id', $authUser->company_sbu)->first();
        $data['sbu_name_value'] = ['id' => $currentSbu->id, 'text' => $currentSbu->sbu_name];

        $data['jc_circular_id'] = $this->generateCustomId($currentSbu->id, $currentSbu->sbu_name);

        return response($data);
    }

    function generateCustomId($id, $name = 'GEM')
    {
        $prefix = strtoupper(substr($name, 0, 3));

        $circular = JobCircular::query()
            ->where('jc_company_name', $id)
            ->orderByDesc('id')
            ->first();

        if ($circular) {
            $lastNumber = (int) substr($circular->jc_circular_id, 3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $newCustomId = $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        return $newCustomId;
    }

    public function store(Request $request)
    {
        $validate = [
            'jc_company_name' => ['required', 'array'],
            'jc_circular_id' => ['required', 'string'],
            'jc_job_position' => ['required', 'array'],
//            'jc_job_department' => ['required', 'array'],
            'jc_job_vacancy' => ['required', 'integer'],
            'jc_job_description' => ['required', 'string'],
            'jc_job_responsibility' => ['required', 'string'],
            'jc_applied_requirements' => ['required', 'string'],
            'jc_job_nature' => ['required', 'integer'],
            'jc_job_requirements' => ['required', 'string'],
            'jc_educational_requirements' => ['required', 'string'],
            'jc_experience_requirements' => ['required', 'string'],
            'jc_job_location' => ['required', 'array'],
            'jc_salary_range' => ['required', 'string'],
            'jc_other_benefits' => ['required', 'string'],
            'jc_circular_publish_date' => ['required', 'date'],
            'jc_circular_expired_date' => ['required', 'date'],
            'jc_person_assign' => ['required', 'array'],
            'jc_exam_type' => ['required', 'integer'],
            'jc_circular_status' => ['required', 'integer'],
        ];

        $data = $request->validate($validate);

        $auth = Auth::guard('user')->user();

        $data['jac_status'] = 1;
        $data['jac_email_send_status'] = 0;

        $data['project_id'] = $auth->project_id;
        $data['branch_id'] = $auth->branch_id;
        $data['created_by'] = $auth->id;

        $data['jc_job_position'] = $request->input('jc_job_position')['id'];
        $data['jc_job_location'] = $request->input('jc_job_location')['id'];
        $data['jc_company_name'] = $request->input('jc_company_name')['id'];
        $data['jc_person_assign'] = $request->input('jc_person_assign')['id'];

        $circular = JobCircular::create($data);

        $newData = [];

        $newData['position'] = $request->input('jc_job_position')['text'];
        $newData['location'] = $request->input('jc_job_location')['text'];
        $newData['department'] = $request->input('jc_job_department')['text'];
        $newData['expired_date'] = $request->input('jc_circular_expired_date');

        $this->mailSend($newData);

        return response([
            'status' => 1,
            'data' => $circular,
            'message' => 'Your data is successfully saved'
        ]);
    }

    public function edit($id)
    {
        $data = JobCircular::valid()->project()->orderBy('priority', 'ASC')->findOrFail($id);
        $companysbu_data_list = CompanySbu::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $section_data_list = Section::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $department_list = Department::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $designation_data_list = Designation::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $jobgrade_data_list = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $employee_data_list = Employee::valid()->project()->get()->keyBy('id')->all();
        $sub_unit_data_list = SubUnit::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        $work_location_data_list = WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get()->keyBy('id')->all();
        if (!$data->jc_company_name) {
            $data->sbu_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->sbu_name_value = ['id' => $data->jc_company_name, 'text' => $companysbu_data_list[$data->jc_company_name]->sbu_name];
        }
        if (!$data->employee_section) {
            $data->section_value = ['id' => '', 'text' => ''];
        } else {
            $data->section_value = ['id' => $data->employee_section, 'text' => $section_data_list[$data->employee_section]->section_name];
        }
        if (!$data->employee_department) {
            $data->department_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->department_name_value = ['id' => $data->employee_department, 'text' => $department_list[$data->employee_department]->department_name];
        }
        if (!$data->jc_job_position) {
            $data->designation_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->designation_name_value = ['id' => $data->jc_job_position, 'text' => $designation_data_list[$data->jc_job_position]->designation_name];
        }
        if (!$data->employee_job_grade) {
            $data->jobgrade_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->jobgrade_name_value = ['id' => $data->employee_job_grade, 'text' => $jobgrade_data_list[$data->employee_job_grade]->jobgrade_name];
        }
        if (!$data->jc_person_assign) {
            $data->employee_name_value = ['id' => '', 'text' => ''];
        } else {
            $data->employee_name_value = ['id' => $data->jc_person_assign, 'text' => $employee_data_list[$data->jc_person_assign]->employee_fullname];
        }
        if (!$data->employee_sub_unit) {
            $data->sub_unit_value = ['id' => '', 'text' => ''];
        } else {
            $data->sub_unit_value = ['id' => $data->employee_sub_unit, 'text' => $sub_unit_data_list[$data->employee_sub_unit]->sub_unit_name];
        }
        if (!$data->employee_work_location) {
            $data->work_location_value = ['id' => '', 'text' => ''];
        } else {
            $data->work_location_value = ['id' => $data->employee_work_location, 'text' => $work_location_data_list[$data->employee_work_location]->work_location_name];
        }
        $company_sbu_data = array();
        $section_data = array();
        $department_data = array();
        $designation_data = array();
        $jobgrade_data = array();
        $employee_data = array();
        $sub_unit_data = array();
        $work_location_data = array();
        foreach ($companysbu_data_list as $value) {
            array_push($company_sbu_data, ['id' => $value['id'], 'text' => $value['sbu_name']]);
        }
        foreach ($section_data_list as $value) {
            array_push($section_data, ['id' => $value['id'], 'text' => $value['section_name']]);
        }
        foreach ($department_list as $value) {
            array_push($department_data, ['id' => $value['id'], 'text' => $value['department_name']]);
        }
        foreach ($designation_data_list as $value) {
            array_push($designation_data, ['id' => $value['id'], 'text' => $value['designation_name']]);
        }
        foreach ($jobgrade_data_list as $value) {
            array_push($jobgrade_data, ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
        }
        foreach ($employee_data_list as $value) {
            array_push($employee_data, ['id' => $value['id'], 'text' => $value['employee_fullname']]);
        }
        foreach ($sub_unit_data_list as $value) {
            array_push($sub_unit_data, ['id' => $value['id'], 'text' => $value['sub_unit_name']]);
        }
        foreach ($work_location_data_list as $value) {
            array_push($work_location_data, ['id' => $value['id'], 'text' => $value['department_name']]);
        }

        $data->company_sbu_data = $company_sbu_data;
        $data->section_data = $section_data;
        $data->department_data = $department_data;
        $data->designation_data = $designation_data;
        $data->jobgrade_data = $jobgrade_data;
        $data->employee_data = $employee_data;
        $data->sub_unit_data = $sub_unit_data;
        $data->work_location_data = $work_location_data;

        return response($data);
    }

    public function destroy($id)
    {
        $delete_data = JobCircular::valid()->project()->findOrFail($id);
        if ($delete_data->delete()) {
            $message = ['status' => 1, 'message' => 'Your data is successfully deleted'];
        }
        return response($message);
    }

    public function moreinfo()
    {
        $data['company_sbu_data'] = array();
        $data['section_data'] = array();
        $data['sub_unit_data'] = array();
        $data['work_location_data'] = array();
        $data['department_data'] = array();
        $data['designation_data'] = array();
        $data['jobgrade_data'] = array();
        $data['employee_data'] = array();
        $company_sbu_data = CompanySbu::valid()->project()->orderBy('priority', 'ASC')->get();
        $section_data = Section::valid()->project()->orderBy('priority', 'ASC')->get();
        $department_data = Department::valid()->project()->orderBy('priority', 'ASC')->get();
        $designation_data = Designation::valid()->project()->orderBy('priority', 'ASC')->get();
        $jobgrade_data = JobGrade::valid()->project()->orderBy('priority', 'ASC')->get();
        $employee_data = JobCircular::valid()->project()->orderBy('priority', 'ASC')->get();
        $sub_unit_data = SubUnit::valid()->project()->orderBy('priority', 'ASC')->get();
        $work_location_data = WorkLocation::valid()->project()->orderBy('priority', 'ASC')->get();
        foreach ($company_sbu_data as $value) {
            array_push($data['company_sbu_data'], ['id' => $value['id'], 'text' => $value['sbu_name']]);
        }
        foreach ($section_data as $value) {
            array_push($data['section_data'], ['id' => $value['id'], 'text' => $value['section_name']]);
        }
        foreach ($department_data as $value) {
            array_push($data['department_data'], ['id' => $value['id'], 'text' => $value['department_name']]);
        }
        foreach ($designation_data as $value) {
            array_push($data['designation_data'], ['id' => $value['id'], 'text' => $value['designation_name']]);
        }
        foreach ($jobgrade_data as $value) {
            array_push($data['jobgrade_data'], ['id' => $value['id'], 'text' => $value['jobgrade_name']]);
        }
        foreach ($employee_data as $value) {
            array_push($data['employee_data'], ['id' => $value['id'], 'text' => $value['employee_fullname']]);
        }
        foreach ($sub_unit_data as $value) {
            array_push($data['sub_unit_data'], ['id' => $value['id'], 'text' => $value['sub_unit_name']]);
        }
        foreach ($work_location_data as $value) {
            array_push($data['work_location_data'], ['id' => $value['id'], 'text' => $value['work_location_name']]);
        }
        return response($data);
    }

    public function profile()
    {
        //
    }

    public function profileDetails($id)
    {
        $data['employee_info'] = JobCircular::valid()->project()
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'employees.employee_sbu')
            ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            ->leftJoin('designations', 'designations.id', '=', 'employees.employee_designation')
            ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'employees.employee_work_location')
            ->leftJoin('job_grades', 'job_grades.id', '=', 'employees.employee_job_grade')
            ->select(
                'employees.*',
                'company_sbus.sbu_name',
                'sections.section_name',
                'departments.department_name',
                'designations.designation_name',
                'sub_units.sub_unit_name',
                'work_locations.work_location_name',
                'job_grades.jobgrade_name'
            )->where('employees.id', $id)->first();
        $data['personal_infos'] = EmployeePersonalInfo::valid()->project()->where('employee_id', $id)->first();
        $data['address_info'] = EmployeeAdressDetail::valid()->project()->where('ead_employee_id', $id)->first();
        $data['identification_supporting'] = EmployeeIdentificationSupporting::valid()->project()->where('eis_employee_id', $id)->first();
        $data['educational_infos'] = EmployeeEducationalQualification::valid()->project()->where('eeq_employee_id', $id)->get();
        $data['professional_infos'] = EmployeeProfessionalQualification::valid()->project()->where('pq_employee_id', $id)->get();
        $data['employment_history'] = EmployeeEmploymentHistory::valid()->project()->where('eeh_employee_id', $id)->get();
        $data['family_details'] = EmployeeFamilyDetail::valid()->project()->where('efd_employee_id', $id)->get();
        $data['training_records'] = EmployeeTrainingRecord::valid()->project()->where('etr_employee_id', $id)->get();
        $data['professinal_memberships'] = EmployeeProfessionalMembership::valid()->project()->where('epm_employee_id', $id)->get();
        $data['bank_accounts'] = EmployeeBankAccountDetail::valid()->project()->where('ebc_employee_id', $id)->get();
        $data['emergency_contacts'] = EmployeeEmergencyContact::valid()->project()->where('eec_employee_id', $id)->get();
        return response($data);
    }

    public function viewAllJob(Request $request)
    {
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $project_id = Auth::guard('user')->user()->project_id;
        $branch_id = Auth::guard('user')->user()->branch_id;
        $data['paginate_data'] = JobCircular::valid()->project()
            ->leftJoin('employees', 'employees.id', '=', 'job_circulars.jc_person_assign')
            ->leftJoin('designations', 'designations.id', '=', 'job_circulars.jc_job_position')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'job_circulars.jc_job_location')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'job_circulars.jc_company_name')
            // ->leftJoin('sections', 'sections.id', '=', 'employees.employee_section')
            // ->leftJoin('departments', 'departments.id', '=', 'employees.employee_department')
            // ->leftJoin('sub_units', 'sub_units.id', '=', 'employees.employee_sub_unit')
            ->select(
                'job_circulars.*',
                'employees.employee_fullname',
                'designations.designation_name',
                'work_locations.work_location_name',
                'company_sbus.sbu_name'
            // 'sections.section_name',
            // 'departments.department_name',
            // 'sub_units.sub_unit_name',
            )
            ->when($search_key, function ($query, $search_key) {
                $query->where(function ($query2) use ($search_key) {
                    $query2->where('job_circulars.jc_company_name', 'LIKE', '%' . $search_key . '%')
                        // ->orWhere('employees.employee_mobile','LIKE','%'.$search_key.'%')
                        // ->orWhere('employees.employee_joining_date','LIKE','%'.$search_key.'%')
                        // ->orWhere('employees.employee_id_no','LIKE','%'.$search_key.'%')
                        ->orWhere('company_sbus.sbu_name', 'LIKE', '%' . $search_key . '%')
                        // ->orWhere('departments.department_name','LIKE','%'.$search_key.'%')
                        ->orWhere('designations.designation_name', 'LIKE', '%' . $search_key . '%')
                        // ->orWhere('sub_units.sub_unit_name','LIKE','%'.$search_key.'%')
                        // ->orWhere('work_locations.work_location_name','LIKE','%'.$search_key.'%')
                        // ->orWhere('sections.section_name','LIKE','%'.$search_key.'%')
                    ;
                });
                return $query;

            })->where('job_circulars.project_id', $project_id)->orderBy($sort, $order)->paginate($paginate_num);


        return response()->json($data);
    }

    public function cvlist(Request $request)
    {
        $auth = Auth::guard('user')->user();

        $branchId = $auth->branch_id;
        $projectId = $auth->project_id;
        $companyId = $auth->company_sbu;
        $sort = $request->input('sort');
        $gander = $request->input('gander');
        $status = $request->input('status');
        $order = $request->input('order');
        $search = $request->input('search');
        $circularId = $request->input('page_ref_id');
        $paginateNum = $request->input('paginate_num');

        $minAge = $request->input('min_age');
        $maxAge = $request->input('max_age');
        $minSalary = $request->input('min_salary');
        $maxSalary = $request->input('max_salary');
        $minExperience = $request->input('min_experience');
        $maxExperience = $request->input('max_experience');

        $query = JobApplyCandidate::query()
            ->with(['circular', 'university'])
            ->where('jac_job_circular_id', $circularId)
            // ->where('jac_company_name', $companyId)
            ->when($search, function ($q) use ($search) {
                $q->where(function($sub) use ($search) {
                    $sub->where('jac_candidate_name', 'LIKE', "%{$search}%")
                        ->orWhere('jac_birth_day', 'LIKE', "%{$search}%");
                });
            })
            ->when($minAge || $maxAge, function ($q) use ($minAge, $maxAge) {
                $q->whereBetween('jac_age', [$minAge ?? 0, $maxAge ?? 200]);
            })
            ->when($minExperience || $maxExperience, function ($q) use ($minExperience, $maxExperience) {
                $q->whereBetween('jac_last_experience', [$minExperience ?? 0, $maxExperience ?? 200]);
            })
            ->when($minSalary || $maxSalary, function ($q) use ($minSalary, $maxSalary) {
                $q->whereBetween('jac_expected_salary', [$minSalary ?? 0, $maxSalary ?? 999999999]);
            });

        // Total Counts
        $totalCounts = [
            'applied'     => (clone $query)->count(),
            'shortlisted' => (clone $query)->where('jac_status', 2)->count(),
            'selected'    => (clone $query)->where('jac_status', 3)->count(),
            'rejected'    => (clone $query)->where('jac_status', 4)->count(),
        ];

        if ($status && $status != 1) {
            $query->where('jac_status', $status);
        }

        if ($gander) {
            $query->where('jac_gender', $gander);
        }

        $query->orderBy($sort, $order);

        $data['counts'] = $totalCounts;
        $data['candidates'] = $query->paginate($paginateNum);

        // Designation
        // $data['designations'] = Designation::valid()->select('id', 'designation_name')->get()
        //     ->map(function ($item) {
        //         return [
        //             'id'   => $item->id,
        //             'text' => $item->designation_name
        //         ];
        //     });

        return response()->json($data);
    }

    public function allcvlist(Request $request)
    {
        // return response($request->page_ref_id);
        $page_ref_id = $request->page_ref_id;
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $project_id = Auth::guard('user')->user()->project_id;
        $branch_id = Auth::guard('user')->user()->branch_id;
        // $paginate_data =JobCircular::valid()->project()
        ## All candidate data
        // $data['all_candidate_data'] = DB::table('job_apply_candidates')
        $all_candidate_data = JobApplyCandidate::valid()
            ->leftJoin('job_circulars', 'job_circulars.id', '=', 'job_apply_candidates.jac_job_circular_id')
            ->leftJoin('designations', 'designations.id', '=', 'job_apply_candidates.jac_job_position')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'job_apply_candidates.jac_company_name')
            ->select(
                'job_apply_candidates.*',
                'job_circulars.jc_circular_id',
                'designations.designation_name',
                'company_sbus.sbu_name'
            )
            ->when($search_key, function ($query, $search_key) {
                $query->where(function ($query2) use ($search_key) {
                    $query2->where('job_apply_candidates.jac_candidate_name', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('job_apply_candidates.jac_birth_day', 'LIKE', '%' . $search_key . '%')
                    ;
                });
                return $query;
            })->where('job_apply_candidates.jac_job_circular_id', $page_ref_id)->where('job_apply_candidates.project_id', $project_id)->orderBy($sort, $order);
        $sortData = $all_candidate_data;
        $sortGetData = $sortData->get();
        $data['all_candidate_count'] = count($sortGetData);
        $data['paginate_data'] = $sortData->paginate($paginate_num);

        // $data['all_candidate_count'] = DB::table('job_apply_candidates')->where('job_apply_candidates.jac_job_circular_id', $page_ref_id)->count();

        ## Shortlisted data
        // $data['shortlist_candidate'] = DB::table('job_apply_candidates')
        $shortlist_candidate_data = JobApplyCandidate::valid()
            ->leftJoin('job_circulars', 'job_circulars.id', '=', 'job_apply_candidates.jac_job_circular_id')
            ->leftJoin('candidate_interview_marks', 'candidate_interview_marks.cim_candidate_id', '=', 'job_apply_candidates.id')
            ->leftJoin('designations', 'designations.id', '=', 'job_apply_candidates.jac_job_position')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'job_apply_candidates.jac_company_name')
            ->select(
                'job_apply_candidates.*',
                'job_circulars.jc_circular_id',
                'designations.designation_name',
                'company_sbus.sbu_name',
                'candidate_interview_marks.cim_total_mark'
            )
            ->when($search_key, function ($query, $search_key) {
                $query->where(function ($query2) use ($search_key) {
                    $query2->where('job_apply_candidates.jac_candidate_name', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('job_apply_candidates.jac_birth_day', 'LIKE', '%' . $search_key . '%')
                    ;
                });
                return $query;
            })
            ->where('job_apply_candidates.jac_job_circular_id', $page_ref_id)
            ->whereIn('job_apply_candidates.jac_status', [2, 3, 4])
            ->orderBy($sort, $order);
        $sortData1 = $shortlist_candidate_data;
        $sortGetData1 = $sortData1->get();
        $data['shortlist_candidate_count'] = count($sortGetData1);
        $data['paginate_data1'] = $sortData1->paginate($paginate_num);
        // return  $data['total_data'];

        ## Selected data
        // $data['selected_candidate'] = DB::table('job_apply_candidates')
        $selected_candidate_data = JobApplyCandidate::valid()
            ->leftJoin('job_circulars', 'job_circulars.id', '=', 'job_apply_candidates.jac_job_circular_id')
            ->leftJoin('designations', 'designations.id', '=', 'job_apply_candidates.jac_job_position')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'job_apply_candidates.jac_company_name')
            ->select(
                'job_apply_candidates.*',
                'job_circulars.jc_circular_id',
                'designations.designation_name',
                'company_sbus.sbu_name'
            )
            ->when($search_key, function ($query, $search_key) {
                $query->where(function ($query2) use ($search_key) {
                    $query2->where('job_apply_candidates.jac_candidate_name', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('job_apply_candidates.jac_birth_day', 'LIKE', '%' . $search_key . '%')
                    ;
                });
                return $query;
            })
            ->where('job_apply_candidates.jac_job_circular_id', $page_ref_id)
            ->where('job_apply_candidates.jac_status', 3)
            ->orderBy($sort, $order);

        $sortData2 = $selected_candidate_data;
        $sortGetData2 = $sortData2->get();
        $data['selected_candidate_count'] = count($sortGetData2);
        $data['paginate_data2'] = $sortData2->paginate($paginate_num);

        // $data['selected_candidate_count'] = DB::table('job_apply_candidates')->where('job_apply_candidates.jac_status', 3)->where('job_apply_candidates.jac_job_circular_id', $page_ref_id)->count();

        ## Rejected data
        // $data['rejected_candidate'] = DB::table('job_apply_candidates')
        $selected_candidate_data = JobApplyCandidate::valid()
            ->leftJoin('job_circulars', 'job_circulars.id', '=', 'job_apply_candidates.jac_job_circular_id')
            ->leftJoin('designations', 'designations.id', '=', 'job_apply_candidates.jac_job_position')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'job_apply_candidates.jac_company_name')
            ->select(
                'job_apply_candidates.*',
                'job_circulars.jc_circular_id',
                'designations.designation_name',
                'company_sbus.sbu_name'
            )
            ->when($search_key, function ($query, $search_key) {
                $query->where(function ($query2) use ($search_key) {
                    $query2->where('job_apply_candidates.jac_candidate_name', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('job_apply_candidates.jac_birth_day', 'LIKE', '%' . $search_key . '%')
                    ;
                });
                return $query;
            })
            ->where('job_apply_candidates.jac_job_circular_id', $page_ref_id)
            ->where('job_apply_candidates.jac_status', 4)
            ->orderBy($sort, $order);

        $sortData3 = $selected_candidate_data;
        $sortGetData3 = $sortData3->get();
        $data['rejected_candidate_count'] = count($sortGetData3);
        $data['paginate_data3'] = $sortData3->paginate($paginate_num);

        // $data['rejected_candidate_count'] = DB::table('job_apply_candidates')->where('job_apply_candidates.jac_status', 4)->where('job_apply_candidates.jac_job_circular_id', $page_ref_id)->count();
        $data['designation_data'] = array();
        $data['highest_education'] = array();
        $designation_data = Designation::valid()
            ->join('job_circulars', 'job_circulars.jc_job_position', '=', 'designations.id')
            ->get();
        $highest_education = JobCircular::valid()->project()
            ->select('id', 'jc_educational_requirements')
            ->get();
        foreach ($designation_data as $value) {
            array_push($data['designation_data'], ['id' => $value['id'], 'text' => $value['designation_name']]);
        }
        foreach ($highest_education as $value) {
            array_push($data['highest_education'], ['id' => $value['jc_educational_requirements'], 'text' => $value['jc_educational_requirements']]);
        }

        return response($data);
    }

    public function shortList($id)
    {
        $candidate = JobApplyCandidate::findOrFail($id);

        $candidate->update([
            'jac_status' => 2,
            'jac_email_send_status' => 2
        ]);

        return response([
            'status' => 1,
            'data' => $candidate,
            'message' => 'The candidate has been successfully shortlisted.'
        ]);
    }

    public function candidateUnlisted($id)
    {
        $candidate = JobApplyCandidate::findOrFail($id);

        $candidate->update([
            'jac_status' => 5,
            'jac_email_send_status' => 0
        ]);

        return response([
            'status' => 1,
            'data' => $candidate,
            'message' => 'The candidate has been unlisted.'
        ]);
    }

    public function candidateShortWithMail($id)
    {
        $candidate = JobApplyCandidate::findOrFail($id);

        $candidate->load(['circular', 'position', 'company']);

        $candidate->update([
            'jac_status' => 2,
            'jac_email_send_status' => 1
        ]);

        Mail::to($candidate->jac_email_address)
            ->send(new ShortlistMail($candidate));

        return response([
            'status' => 1,
            'data' => $candidate,
            'message' => 'The candidate has been successfully shortlisted.'
        ]);
    }

    public function candidateSendMail($id)
    {
        $candidate = JobApplyCandidate::findOrFail($id);

        $candidate->update(['jac_email_send_status' => 1]);

        $candidate->load(['circular', 'position', 'company']);

        Mail::to($candidate->jac_email_address)
            ->send(new DemoMail($candidate));

        return response([
            'status' => 1,
            'data' => $candidate,
            'message' => 'The candidate has been successfully shortlisted.'
        ]);
    }

    public function selectCandidate($id)
    {
        $candidate = JobApplyCandidate::findOrFail($id);

        $candidate->update([
            'jac_status' => 3,
        ]);

        return response([
            'status' => 1,
            'data' => $candidate,
            'message' => 'The candidate has been selected.'
        ]);
    }

    public function rejectCandidate($id)
    {
        $candidate = JobApplyCandidate::findOrFail($id);

        $candidate->update([
            'jac_status' => 4,
            'jac_email_send_status' => 0
        ]);

        return response([
            'status' => 1,
            'data' => $candidate,
            'message' => 'The candidate has been rejected.'
        ]);
    }

    public function findMarks($candidate_id)
    {
        // return response($candidate_id);
        $data['candidate_marks'] = DB::table('candidate_interview_marks')
            ->where('cim_candidate_id', $candidate_id)
            ->select(
                'candidate_interview_marks.*'
            )
            ->first();
        return response($data);
    }

    public function get_applicant_data(Request $request)
    {
        // return response( $request->input('paginate_num'));
        // return response($request->page_ref_id);
        $candidate_gender = $request->candidate_gender;
        $age_from = $request->age_from;
        $age_to = $request->age_to;
        $candidate_designation = $request->candidate_designation;
        $experience_from = $request->experience_from;
        $experience_to = $request->experience_to;
        $salary_from = $request->salary_from;
        $salary_to = $request->salary_to;
        $candidate_education = $request->candidate_education;


        $page_ref_id = $request->page_ref_id;
        $paginate_num = $request->input('paginate_num');
        $search_key = $request->input('search_key');
        $order = $request->input('order');
        $sort = $request->input('sort');
        $project_id = Auth::guard('user')->user()->project_id;
        $branch_id = Auth::guard('user')->user()->branch_id;
        // $paginate_data =JobCircular::valid()->project()
        ## All candidate data
        // $data['all_candidate_data'] = DB::table('job_apply_candidates')
        $all_candidate_data = JobApplyCandidate::valid()->project()
            ->leftJoin('job_circulars', 'job_circulars.id', '=', 'job_apply_candidates.jac_job_circular_id')
            ->leftJoin('designations', 'designations.id', '=', 'job_apply_candidates.jac_job_position')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'job_apply_candidates.jac_company_name')
            ->select(
                'job_apply_candidates.*',
                'job_circulars.jc_circular_id',
                'designations.designation_name',
                'company_sbus.sbu_name'
            )
            ->when($search_key, function ($query, $search_key) {
                $query->where(function ($query2) use ($search_key) {
                    $query2->where('job_apply_candidates.jac_candidate_name', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('job_apply_candidates.jac_birth_day', 'LIKE', '%' . $search_key . '%')
                    ;
                });
                return $query;
            })
            ->where('job_apply_candidates.jac_job_circular_id', $page_ref_id)
            ->where('job_apply_candidates.project_id', $project_id);
        // ->whereIn('employee_department',$employee_department);

        if (!empty($candidate_gender)) {
            $all_candidate_data->orWhere('jac_gender', $candidate_gender);
        }
        if (!empty($age_from)) {
            $all_candidate_data->orWhere('jac_age', $age_from);
        }
        if (!empty($candidate_designation)) {
            $all_candidate_data->orWhere('jac_highest_education', $candidate_designation);
        }
        if (!empty($experience_from)) {
            $all_candidate_data->orWhere('jac_last_experience', $experience_from);
        }
        if (!empty($salary_from)) {
            $all_candidate_data->orWhere('jac_expected_salary', $salary_from);
        }
        if (!empty($candidate_education)) {
            $all_candidate_data->orWhere('jac_highest_education', $candidate_education);
        }
        $all_candidate_data = $all_candidate_data->orderBy($sort, $order);



        $sortData = $all_candidate_data;
        $sortGetData = $sortData->get();
        $data['all_candidate_count'] = count($sortGetData);
        $data['paginate_data'] = $sortData->paginate($paginate_num);












        ## Shortlisted data
        // $data['shortlist_candidate'] = DB::table('job_apply_candidates')
        $shortlist_candidate_data = JobApplyCandidate::valid()->project()
            ->leftJoin('job_circulars', 'job_circulars.id', '=', 'job_apply_candidates.jac_job_circular_id')
            ->leftJoin('candidate_interview_marks', 'candidate_interview_marks.cim_candidate_id', '=', 'job_apply_candidates.id')
            ->leftJoin('designations', 'designations.id', '=', 'job_apply_candidates.jac_job_position')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'job_apply_candidates.jac_company_name')
            ->select(
                'job_apply_candidates.*',
                'job_circulars.jc_circular_id',
                'designations.designation_name',
                'company_sbus.sbu_name',
                'candidate_interview_marks.cim_total_mark'
            )
            ->when($search_key, function ($query, $search_key) {
                $query->where(function ($query2) use ($search_key) {
                    $query2->where('job_apply_candidates.jac_candidate_name', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('job_apply_candidates.jac_birth_day', 'LIKE', '%' . $search_key . '%')
                    ;
                });
                return $query;
            })
            ->where('job_apply_candidates.jac_job_circular_id', $page_ref_id)
            ->whereIn('job_apply_candidates.jac_status', [2, 3, 4])
            ->orderBy($sort, $order);

        $sortData1 = $shortlist_candidate_data;
        $sortGetData1 = $sortData1->get();
        $data['shortlist_candidate_count'] = count($sortGetData1);
        $data['paginate_data1'] = $sortData1->paginate($paginate_num);
        // return  $data['total_data'];

        ## Selected data
        // $data['selected_candidate'] = DB::table('job_apply_candidates')
        $selected_candidate_data = JobApplyCandidate::valid()->project()
            ->leftJoin('job_circulars', 'job_circulars.id', '=', 'job_apply_candidates.jac_job_circular_id')
            ->leftJoin('designations', 'designations.id', '=', 'job_apply_candidates.jac_job_position')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'job_apply_candidates.jac_company_name')
            ->select(
                'job_apply_candidates.*',
                'job_circulars.jc_circular_id',
                'designations.designation_name',
                'company_sbus.sbu_name'
            )
            ->when($search_key, function ($query, $search_key) {
                $query->where(function ($query2) use ($search_key) {
                    $query2->where('job_apply_candidates.jac_candidate_name', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('job_apply_candidates.jac_birth_day', 'LIKE', '%' . $search_key . '%')
                    ;
                });
                return $query;
            })
            ->where('job_apply_candidates.jac_job_circular_id', $page_ref_id)
            ->where('job_apply_candidates.jac_status', 3)
            ->orderBy($sort, $order);

        $sortData2 = $selected_candidate_data;
        $sortGetData2 = $sortData2->get();
        $data['selected_candidate_count'] = count($sortGetData2);
        $data['paginate_data2'] = $sortData2->paginate($paginate_num);

        // $data['selected_candidate_count'] = DB::table('job_apply_candidates')->where('job_apply_candidates.jac_status', 3)->where('job_apply_candidates.jac_job_circular_id', $page_ref_id)->count();

        ## Rejected data
        // $data['rejected_candidate'] = DB::table('job_apply_candidates')
        $selected_candidate_data = JobApplyCandidate::valid()->project()
            ->leftJoin('job_circulars', 'job_circulars.id', '=', 'job_apply_candidates.jac_job_circular_id')
            ->leftJoin('designations', 'designations.id', '=', 'job_apply_candidates.jac_job_position')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'job_apply_candidates.jac_company_name')
            ->select(
                'job_apply_candidates.*',
                'job_circulars.jc_circular_id',
                'designations.designation_name',
                'company_sbus.sbu_name'
            )
            ->when($search_key, function ($query, $search_key) {
                $query->where(function ($query2) use ($search_key) {
                    $query2->where('job_apply_candidates.jac_candidate_name', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('job_apply_candidates.jac_birth_day', 'LIKE', '%' . $search_key . '%')
                    ;
                });
                return $query;
            })
            ->where('job_apply_candidates.jac_job_circular_id', $page_ref_id)
            ->where('job_apply_candidates.jac_status', 4)
            ->orderBy($sort, $order);

        $sortData3 = $selected_candidate_data;
        $sortGetData3 = $sortData3->get();
        $data['rejected_candidate_count'] = count($sortGetData3);
        $data['paginate_data3'] = $sortData3->paginate($paginate_num);

        $data['rejected_candidate_count'] = DB::table('job_apply_candidates')->where('job_apply_candidates.jac_status', 4)->where('job_apply_candidates.jac_job_circular_id', $page_ref_id)->count();
        return response($data);

    }

    private function mailSend($data)
    {
        $jobAlerts = JobAlert::query()->get();
        $talents = Talent::query()->get();

        // JobAlert: email আছে, name নাই
        $emailsFromJobAlerts = $jobAlerts->filter(function ($item) {
            return !empty($item->email);
        })->mapWithKeys(function ($item) {
            return [
                $item->email => null
            ];
        });

        // Talent: email + name
        $emailsFromTalents = $talents->filter(function ($item) {
            return !empty($item->email);
        })->mapWithKeys(function ($item) {
            return [
                $item->email => $item->name
            ];
        });

        // Merge safely
        $people = $emailsFromJobAlerts->union($emailsFromTalents);

        $mailData = [
            'position'   => $data['position'],
            'department' => $data['department'],
            'location'   => $data['location'],
            'deadline'   => $data['expired_date'],
        ];

        foreach ($people as $email => $name) {
            $finalMailData = $mailData;
            $finalMailData['name'] = $name;

            Mail::to($email)->send(new JobAlertMail($finalMailData));
        }
    }
}
