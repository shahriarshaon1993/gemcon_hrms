<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidateApplicationRequest;
use App\Model\JobApplyCandidate;
use App\Model\JobCircular;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class KaziCircularController extends Controller
{
    public function getCirculars()
    {
        $circulars = JobCircular::query()->valid()
            ->with(['company', 'position', 'workLocation'])
            ->where('jc_company_name', 1)
            ->get();

        return response()->json($circulars);
    }

    public function show($id)
    {
        $circular = JobCircular::findOrFail($id);

        $circular->load(['company', 'position', 'workLocation']);

        return response()->json([
            'message' => 'Circular data get successfully!',
            'data' => $circular,
        ], 200);
    }

    public function apply(StoreCandidateApplicationRequest $request, $id)
    {
        $data = $request->validated();

        $birthDate = date("Y-m-d", strtotime($data['jac_birth_day']));
        $birthDate = Carbon::parse($birthDate);
        $age = $birthDate->age;

        $apply = new JobApplyCandidate();

        if($request->hasFile('jac_image')) {
            $path = '/recruitment/img';
            $imageName = time() . '.' . $request->jac_image->extension();
            $request->jac_image->move(public_path('/recruitment/img'), $imageName);

            $apply->jac_image = (string) $path . '/' . $imageName;
        }

        if($request->hasFile('jac_cv')) {
            $path = '/recruitment/cv';
            $fileName = time() . '.' . $request->jac_cv->extension();
            $request->jac_cv->move(public_path('/recruitment/cv'), $fileName);

            $apply->jac_cv = (string) $path . '/' . $fileName;
        }

        $apply->jac_age = $age;
        $apply->jac_candidate_name = $request->jac_candidate_name;
        $apply->jac_job_circular_id = $request->jac_job_circular_id;
        $apply->jac_job_position = $request->jac_job_position;
        $apply->jac_company_name = $request->jac_company_name;
        $apply->jac_gender = $request->jac_gender;
        $apply->jac_contact_no = $request->jac_contact_no;
        $apply->jac_email_address = $request->jac_email_address;
        $apply->jac_last_employment = $request->jac_last_employment;
        $apply->jac_last_designation = $request->jac_last_designation;
        $apply->jac_last_experience = $request->jac_last_experience;
        $apply->jac_expected_salary = $request->jac_expected_salary;
        $apply->jac_highest_education = $request->jac_highest_education;
        $apply->jac_universitgy_name = $request->jac_universitgy_name;
        $apply->jac_candidate_address = $request->jac_candidate_address;
        $apply->jac_birth_day = $request->jac_birth_day;

        $apply->save();

        return response()->json([
            'message' => 'Your application is successfully submitted!',
            'data' => $apply,
        ], 201);
    }
}
