<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMosDataAPIRequest;
use App\Http\Requests\API\UpdateMosDataAPIRequest;
use App\Models\MosData;
use App\Repositories\MosDataRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class MosDataController
 * @package App\Http\Controllers\API
 */

class MosDataAPIController extends AppBaseController
{
    /** @var  MosDataRepository */
    private $mosDataRepository;

    public function __construct(MosDataRepository $mosDataRepo)
    {
        $this->mosDataRepository = $mosDataRepo;
    }

    /**
     * Display a listing of the MosData.
     * GET|HEAD /mosDatas
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $mosDatas = $this->mosDataRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        ); 
        return $this->sendResponse($mosDatas->toArray(), 'Mos Datas retrieved successfully');
    }

    /**
     * Store a newly created MosData in storage.
     * POST /mosDatas
     *
     * @param CreateMosDataAPIRequest $request
     *
     * @return Response
     */
    // public function store(CreateMosDataAPIRequest $request)
    // {
    //     $input = $request->all();

    //     $mosData = $this->mosDataRepository->create($input);

    //     return $this->sendResponse($mosData->toArray(), 'Mos Data saved successfully');
    // }

    /**
     * Display the specified MosData.
     * GET|HEAD /mosDatas/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var MosData $mosData */
        $mosData = $this->mosDataRepository->find($id);

        if (empty($mosData)) {
            return $this->sendError('Mos Data not found');
        }

        return $this->sendResponse($mosData->toArray(), 'Mos Data retrieved successfully');
    }

    /**
     * Update the specified MosData in storage.
     * PUT/PATCH /mosDatas/{id}
     *
     * @param int $id
     * @param UpdateMosDataAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMosDataAPIRequest $request)
    {
        $input = $request->all();

        /** @var MosData $mosData */
        $mosData = $this->mosDataRepository->find($id);

        if (empty($mosData)) {
            return $this->sendError('Mos Data not found');
        }

        $mosData = $this->mosDataRepository->update($input, $id);

        return $this->sendResponse($mosData->toArray(), 'MosData updated successfully');
    }

    /**
     * Remove the specified MosData from storage.
     * DELETE /mosDatas/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var MosData $mosData */
        $mosData = $this->mosDataRepository->find($id);

        if (empty($mosData)) {
            return $this->sendError('Mos Data not found');
        }

        $mosData->delete();

        return $this->sendSuccess('Mos Data deleted successfully');
    }
}
