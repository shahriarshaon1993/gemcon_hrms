<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFactoryCapacityAPIRequest;
use App\Http\Requests\API\UpdateFactoryCapacityAPIRequest;
use App\Models\FactoryCapacity;
use App\Imports\FactoryCapacityImport;
use App\Repositories\FactoryCapacityRepository;
use Illuminate\Http\Request;
use App\Http\Resources\FactoryCapacityResource;
use App\Http\Controllers\AppBaseController;
use Maatwebsite\Excel\Facades\Excel;
use Auth ;
use Response;

/**
 * Class FactoryCapacityController
 * @package App\Http\Controllers\API
 */

class FactoryCapacityAPIController extends AppBaseController
{
    /** @var  FactoryCapacityRepository */
    private $factoryCapacityRepository;

    public function __construct(FactoryCapacityRepository $factoryCapacityRepo)
    {
        $this->factoryCapacityRepository = $factoryCapacityRepo;
    }

    /**
     * Display a listing of the FactoryCapacity.
     * GET|HEAD /factoryCapacities
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $factoryCapacities = $this->factoryCapacityRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        
        $items = FactoryCapacityResource::collection($factoryCapacities);    
        return $this->sendResponse($items, 'Factory Capacities retrieved successfully');
    }


    public function fileUpload(Request $request){ 
        if ($request->hasFile('csvFile')) { 
            $data = Excel::import(new FactoryCapacityImport, request()->file('csvFile'));
 
            return $this->sendResponse($data, 'Capacity retrieved successfully'); 
        }else{
            return $this->sendResponse( 0 , 'Error'); 
        } 
    }

    /**
     * Store a newly created FactoryCapacity in storage.
     * POST /factoryCapacities
     *
     * @param CreateFactoryCapacityAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateFactoryCapacityAPIRequest $request)
    {
        $input = $request->all();

        $factoryCapacity = $this->factoryCapacityRepository->create($input);

        return $this->sendResponse($factoryCapacity->toArray(), 'Factory Capacity saved successfully');
    }

    /**
     * Display the specified FactoryCapacity.
     * GET|HEAD /factoryCapacities/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var FactoryCapacity $factoryCapacity */
        $factoryCapacity = $this->factoryCapacityRepository->find($id);

        if (empty($factoryCapacity)) {
            return $this->sendError('Factory Capacity not found');
        }

        return $this->sendResponse($factoryCapacity->toArray(), 'Factory Capacity retrieved successfully');
    }

    /**
     * Update the specified FactoryCapacity in storage.
     * PUT/PATCH /factoryCapacities/{id}
     *
     * @param int $id
     * @param UpdateFactoryCapacityAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFactoryCapacityAPIRequest $request)
    {
        $input = $request->all();

        /** @var FactoryCapacity $factoryCapacity */
        $factoryCapacity = $this->factoryCapacityRepository->find($id);

        if (empty($factoryCapacity)) {
            return $this->sendError('Factory Capacity not found');
        }

        $factoryCapacity = $this->factoryCapacityRepository->update($input, $id);

        return $this->sendResponse($factoryCapacity->toArray(), 'FactoryCapacity updated successfully');
    }

    /**
     * Remove the specified FactoryCapacity from storage.
     * DELETE /factoryCapacities/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var FactoryCapacity $factoryCapacity */
        $factoryCapacity = $this->factoryCapacityRepository->find($id);

        if (empty($factoryCapacity)) {
            return $this->sendError('Factory Capacity not found');
        }

        $factoryCapacity->delete();

        return $this->sendSuccess('Factory Capacity deleted successfully');
    }
}
