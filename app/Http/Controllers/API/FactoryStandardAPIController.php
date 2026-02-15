<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFactoryStandardAPIRequest;
use App\Http\Requests\API\UpdateFactoryStandardAPIRequest;
use App\Models\FactoryStandard;
use App\Imports\FactoryStandardImport;
use App\Http\Resources\FactoryStandardResource;
use App\Repositories\FactoryStandardRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Maatwebsite\Excel\Facades\Excel;
use Response;

/**
 * Class FactoryStandardController
 * @package App\Http\Controllers\API
 */

class FactoryStandardAPIController extends AppBaseController
{
    /** @var  FactoryStandardRepository */
    private $factoryStandardRepository;

    public function __construct(FactoryStandardRepository $factoryStandardRepo)
    {
        $this->factoryStandardRepository = $factoryStandardRepo;
    }

    /**
     * Display a listing of the FactoryStandard.
     * GET|HEAD /factoryStandards
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $factoryStandards = $this->factoryStandardRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        $items = FactoryStandardResource::collection($factoryStandards);    

        return $this->sendResponse($items, 'Factory Standards retrieved successfully');
    }
    public function fileUpload(Request $request){ 
        if ($request->hasFile('csvFile')) { 
            $data = Excel::import(new FactoryStandardImport, request()->file('csvFile'));
            return $this->sendResponse($data, 'Standards Data retrieved successfully'); 
        }else{
            return $this->sendResponse(0, 'Erro'); 
        } 
    }
 
    /**
     * Store a newly created FactoryStandard in storage.
     * POST /factoryStandards
     *
     * @param CreateFactoryStandardAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFactoryStandardAPIRequest $request)
    {
        $input = $request->all();

        $factoryStandard = $this->factoryStandardRepository->create($input);

        return $this->sendResponse($factoryStandard->toArray(), 'Factory Standard saved successfully');
    }

    /**
     * Display the specified FactoryStandard.
     * GET|HEAD /factoryStandards/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FactoryStandard $factoryStandard */
        $factoryStandard = $this->factoryStandardRepository->find($id);

        if (empty($factoryStandard)) {
            return $this->sendError('Factory Standard not found');
        }

        return $this->sendResponse($factoryStandard->toArray(), 'Factory Standard retrieved successfully');
    }

    /**
     * Update the specified FactoryStandard in storage.
     * PUT/PATCH /factoryStandards/{id}
     *
     * @param int $id
     * @param UpdateFactoryStandardAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFactoryStandardAPIRequest $request)
    {
        $input = $request->all();

        /** @var FactoryStandard $factoryStandard */
        $factoryStandard = $this->factoryStandardRepository->find($id);

        if (empty($factoryStandard)) {
            return $this->sendError('Factory Standard not found');
        }

        $factoryStandard = $this->factoryStandardRepository->update($input, $id);

        return $this->sendResponse($factoryStandard->toArray(), 'FactoryStandard updated successfully');
    }

    /**
     * Remove the specified FactoryStandard from storage.
     * DELETE /factoryStandards/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FactoryStandard $factoryStandard */
        $factoryStandard = $this->factoryStandardRepository->find($id);

        if (empty($factoryStandard)) {
            return $this->sendError('Factory Standard not found');
        }

        $factoryStandard->delete();

        return $this->sendSuccess('Factory Standard deleted successfully');
    }
}
