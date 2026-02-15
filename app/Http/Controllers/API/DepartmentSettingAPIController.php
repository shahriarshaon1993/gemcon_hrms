<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDepartmentSettingAPIRequest;
use App\Http\Requests\API\UpdateDepartmentSettingAPIRequest;
use App\Models\DepartmentSetting;
use App\Repositories\DepartmentSettingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response, DB;

/**
 * Class DepartmentSettingController
 * @package App\Http\Controllers\API
 */

class DepartmentSettingAPIController extends AppBaseController
{
    /** @var  DepartmentSettingRepository */
    private $departmentSettingRepository;

    public function __construct(DepartmentSettingRepository $departmentSettingRepo)
    {
        $this->departmentSettingRepository = $departmentSettingRepo;
    }

    /**
     * Display a listing of the DepartmentSetting.
     * GET|HEAD /departmentSettings
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $departmentSettings = $this->departmentSettingRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($departmentSettings->toArray(), 'Department Settings retrieved successfully');
    }

    public function department_settings_update(Request $request)
    {
        $items  = $request->items;
        foreach ($items as $key => $value) {
            // print_r( $value);
            // exit();
            // // $data = array( 
            // // "jan" =>$value['jan'], 
            // // "feb" =>$value['feb'], 
            // // "mar" =>$value['mar'], 
            // // "apr" =>$value['apr'], 
            // // "may" =>$value['may'], 
            // // "jun" =>$value['jun'], 
            // // "jul" =>$value['jul'], 
            // // "aug" =>$value['aug'], 
            // // "sep" =>$value['sep'], 
            // // "oct" =>$value['oct'], 
            // // "nov" =>$value['nov'], 
            // // "dec" =>$value['dec'] );
            // DepartmentSetting::where('id', $value['id']) 
            // ->update($data);
            if ($value['setting']) {
                $this->departmentSettingRepository->update($value['setting'], $value['setting']['id']);
            } else {
                $data = array(
                    "jan" => 0,
                    "feb" => 0,
                    "mar" => 0,
                    "apr" => 0,
                    "may" => 0,
                    "jun" => 0,
                    "jul" => 0,
                    "aug" => 0,
                    "sep" => 0,
                    "oct" => 0,
                    "nov" => 0,
                    "dec" => 0,
                    "dept_id" => $value['id']
                );
                $departmentSetting = $this->departmentSettingRepository->create($data);
            }
        }
        return $this->sendResponse($request, 'Department Settings Update retrieved successfully');
    }

    /**
     * Store a newly created DepartmentSetting in storage.
     * POST /departmentSettings
     *
     * @param CreateDepartmentSettingAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDepartmentSettingAPIRequest $request)
    {
        $input = $request->all();

        $departmentSetting = $this->departmentSettingRepository->create($input);

        return $this->sendResponse($departmentSetting->toArray(), 'Department Setting saved successfully');
    }

    /**
     * Display the specified DepartmentSetting.
     * GET|HEAD /departmentSettings/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var DepartmentSetting $departmentSetting */
        $departmentSetting = $this->departmentSettingRepository->find($id);

        if (empty($departmentSetting)) {
            return $this->sendError('Department Setting not found');
        }

        return $this->sendResponse($departmentSetting->toArray(), 'Department Setting retrieved successfully');
    }

    /**
     * Update the specified DepartmentSetting in storage.
     * PUT/PATCH /departmentSettings/{id}
     *
     * @param int $id
     * @param UpdateDepartmentSettingAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDepartmentSettingAPIRequest $request)
    {
        $input = $request->all();

        /** @var DepartmentSetting $departmentSetting */
        $departmentSetting = $this->departmentSettingRepository->find($id);

        if (empty($departmentSetting)) {
            return $this->sendError('Department Setting not found');
        }

        $departmentSetting = $this->departmentSettingRepository->update($input, $id);

        return $this->sendResponse($departmentSetting->toArray(), 'DepartmentSetting updated successfully');
    }

    /**
     * Remove the specified DepartmentSetting from storage.
     * DELETE /departmentSettings/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var DepartmentSetting $departmentSetting */
        $departmentSetting = $this->departmentSettingRepository->find($id);

        if (empty($departmentSetting)) {
            return $this->sendError('Department Setting not found');
        }

        $departmentSetting->delete();

        return $this->sendSuccess('Department Setting deleted successfully');
    }
}
