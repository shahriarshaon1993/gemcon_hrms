<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateKPIAPIRequest;
use App\Http\Requests\API\UpdateKPIAPIRequest;
use App\Models\KPI;
use App\Repositories\KPIRepository;
use App\Http\Resources\KpiItemResource; 
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class KPIController
 * @package App\Http\Controllers\API
 */

class KPIAPIController extends AppBaseController
{
    /** @var  KPIRepository */
    private $kPIRepository;

    public function __construct(KPIRepository $kPIRepo)
    {
        $this->kPIRepository = $kPIRepo;
    }

    /**
     * Display a listing of the KPI.
     * GET|HEAD /kPIS
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $kPIS = $this->kPIRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($kPIS->toArray(), 'K P I S retrieved successfully');
    }

    /**
     * Store a newly created KPI in storage.
     * POST /kPIS
     *
     * @param CreateKPIAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateKPIAPIRequest $request)
    {
        $input = $request->all();

        $kPI = $this->kPIRepository->create($input);

        return $this->sendResponse($kPI->toArray(), 'K P I saved successfully');
    }

    /**
     * Display the specified KPI.
     * GET|HEAD /kPIS/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var KPI $kPI */
        $kPI = KPI::find($id);

        // if (empty($kPI)) {
        //     return $this->sendError('K P I not found');
        // }
        $data_return  =   New KpiItemResource ($kPI);
        return $this->sendResponse($data_return, 'K P I S retrieved successfully');

       // return $this->sendResponse($kPI->toArray(), 'K P I retrieved successfully');
    }

    /**
     * Update the specified KPI in storage.
     * PUT/PATCH /kPIS/{id}
     *
     * @param int $id
     * @param UpdateKPIAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateKPIAPIRequest $request)
    {
        $input = $request->all();

        /** @var KPI $kPI */
        $kPI = $this->kPIRepository->find($id);

        if (empty($kPI)) {
            return $this->sendError('K P I not found');
        }

        $kPI = $this->kPIRepository->update($input, $id);

        return $this->sendResponse($kPI->toArray(), 'KPI updated successfully');
    }

    /**
     * Remove the specified KPI from storage.
     * DELETE /kPIS/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var KPI $kPI */
        $kPI = $this->kPIRepository->find($id);

        if (empty($kPI)) {
            return $this->sendError('K P I not found');
        }

        $kPI->delete();

        return $this->sendSuccess('K P I deleted successfully');
    }
}
