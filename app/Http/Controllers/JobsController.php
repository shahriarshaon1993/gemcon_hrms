<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreJobAlertRequest;
use App\Http\Requests\StoreTalentRequest;
use App\JobAlert;
use App\Mail\ApplyMail;
use App\Mail\SubscriptionMail;
use App\Mail\TalentedPeopleMail;
use App\Model\Department;
use App\Model\JobApplyCandidate;
use App\Models\Talent;
use Carbon\Carbon;
use DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Redirect;


class JobsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(request $request)
    {
        $data['jobs'] = DB::table('job_circulars')
            ->leftJoin('employees', 'employees.id', '=', 'job_circulars.jc_person_assign')
            ->leftJoin('designations', 'designations.id', '=', 'job_circulars.jc_job_position')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'job_circulars.jc_job_location')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'job_circulars.jc_company_name')
            ->select(
                'job_circulars.*',
                'employees.employee_fullname',
                'designations.designation_name',
                'work_locations.work_location_name',
                'company_sbus.sbu_name'
            )
            ->where('job_circulars.jc_circular_status', 1)
            ->orderBy('job_circulars.id', 'desc')
            ->get();

        $data['university_lists_data'] = DB::table('university_lists')
            ->orderBy('university_name', 'ASC')
            ->get();

        $departmentIds = [
            3, 6, 8, 9, 10, 13, 17, 20, 27, 28, 31, 33, 35, 36, 37, 38, 39,
            42, 46, 48, 60, 63, 65, 66, 68, 69, 78, 93, 96, 107, 121
        ];

        $data['departments'] = Department::valid()
            ->whereIn('id', $departmentIds)
            ->orderBy('department_name', 'ASC')
            ->get();

        return view('jobs/index', $data);
    }

    public function getCircular(Request $request)
    {
        $job = DB::table('job_circulars')
            ->leftJoin('employees', 'employees.id', '=', 'job_circulars.jc_person_assign')
            ->leftJoin('designations', 'designations.id', '=', 'job_circulars.jc_job_position')
            ->leftJoin('work_locations', 'work_locations.id', '=', 'job_circulars.jc_job_location')
            ->leftJoin('company_sbus', 'company_sbus.id', '=', 'job_circulars.jc_company_name')
            ->select(
                'job_circulars.*',
                'employees.employee_fullname',
                'designations.designation_name',
                'work_locations.work_location_name',
                'company_sbus.sbu_name'
            )
            ->where('job_circulars.jc_circular_status', 1)
            ->where('job_circulars.id', $request->id)
            ->orderBy('job_circulars.id', 'desc')
            ->first();

        return response()->json($job);
    }

    public function apply(request $request)
    {
        $request->validate(['jac_candidate_name' => 'required']);

        $data = $request->only(
            'jac_candidate_name',
            'jac_job_circular_id',
            'jac_job_position',
            'jac_company_name',
            'jac_gender',
            'jac_contact_no',
            'jac_email_address',
            'jac_last_employment',
            'jac_last_designation',
            'jac_last_experience',
            'jac_expected_salary',
            'jac_highest_education',
            'jac_universitgy_name',
            'jac_candidate_address'
        );
        $data['jac_birth_day'] = date("Y-m-d", strtotime($request->jac_birth_day));
        $dob = Carbon::parse($data['jac_birth_day']);
        $data['jac_age'] = $dob->age;

        if (!empty($request['jac_image'])) {
            $imageName = time() . '.' . $request->jac_image->extension();
            $request->jac_image->move(public_path('/recruitment/img'), $imageName);
            $path = '/recruitment/img';
            $data['jac_image'] = $path . '/' . $imageName;
        }

        if (!empty($request['jac_cv'])) {
            $fileName = time() . '.' . $request->jac_cv->extension();
            $request->jac_cv->move(public_path('/recruitment/cv'), $fileName);
            $path = '/recruitment/cv';
            $data['jac_cv'] = $path . '/' . $fileName;
        }

        $candidate = JobApplyCandidate::create($data);

        $candidate->load(['circular', 'position', 'company']);

        $message = 'Your data is successfully submitted!';

        Mail::to($request->jac_email_address)->send(new ApplyMail($candidate));

        return redirect()->back()->with('message', $message);
    }

    public function applyTalent(StoreTalentRequest $request)
    {
        $data = $request->validated();

        $data['is_agree'] = $request->has('is_agree');

        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('recruitment/cv'), $fileName);
            $data['cv'] = 'recruitment/cv/' . $fileName;
        }

        Talent::create($data);

        Mail::to($request->input('email'))->send(new TalentedPeopleMail($data['name']));

        return redirect()->back()->with('message', 'Application submitted successfully!');
    }

    public function storeJobAlert(StoreJobAlertRequest $request)
    {
        $data = $request->validated();

        JobAlert::create($data);

        Mail::to($request->input('email'))->send(new SubscriptionMail());

        return redirect()->back()->with(
            'message',
            'You have successfully subscribed to job alerts!'
        );
    }
}
