<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMosDataUserAPIRequest;
use App\Http\Requests\API\UpdateMosDataUserAPIRequest;
use App\Models\MosDataUser;
use App\Repositories\MosDataUserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class MosDataUserController
 * @package App\Http\Controllers\API
 */

class MosDataUserAPIController extends AppBaseController
{
    /** @var  MosDataUserRepository */
    private $mosDataRepository;

    public function __construct(MosDataUserRepository $mosDataRepo)
    {
        $this->mosDataRepository = $mosDataRepo;
    }

    /**
     * Display a listing of the MosDataUser.
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
     * Store a newly created MosDataUser in storage.
     * POST /mosDatas
     *
     * @param CreateMosDataUserAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $months = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
        $input = $request->all();

        foreach ($request->ids as $key => $id) {
            $mosinput = [
                'mos_id' => $id,
                'year' => 2022,
                'type' => "user_achievement",
                'january' => $request->january[$id] ?? 0,
                'february' => $request->february[$id] ?? 0,
                'march' => $request->march[$id] ?? 0,
                'april' => $request->april[$id] ?? 0,
                'may' => $request->may[$id] ?? 0,
                'june' => $request->june[$id] ?? 0,
                'july' => $request->july[$id] ?? 0,
                'august' => $request->august[$id] ?? 0,
                'september' => $request->september[$id] ?? 0,
                'october' => $request->october[$id] ?? 0,
                'november' => $request->november[$id] ?? 0,
                'december' => $request->december[$id] ?? 0,
            ];
            $mosData = MosDataUser::updateOrCreate(['mos_id' => $id], $mosinput);
        }

        return back()->with('status', "Mos Data user saved successfully");
    }

    /**
     * Display the specified MosDataUser.
     * GET|HEAD /mosDatas/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var MosDataUser $mosData */
        $mosData = $this->mosDataRepository->find($id);

        if (empty($mosData)) {
            return $this->sendError('Mos Data not found');
        }

        return $this->sendResponse($mosData->toArray(), 'Mos Data retrieved successfully');
    }

    /**
     * Update the specified MosDataUser in storage.
     * PUT/PATCH /mosDatas/{id}
     *
     * @param int $id
     * @param UpdateMosDataUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMosDataUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var MosDataUser $mosData */
        $mosData = $this->mosDataRepository->find($id);

        if (empty($mosData)) {
            return $this->sendError('Mos Data not found');
        }

        $mosData = $this->mosDataRepository->update($input, $id);

        return $this->sendResponse($mosData->toArray(), 'MosDataUser updated successfully');
    }

    /**
     * Remove the specified MosDataUser from storage.
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
        /** @var MosDataUser $mosData */
        $mosData = $this->mosDataRepository->find($id);

        if (empty($mosData)) {
            return $this->sendError('Mos Data not found');
        }

        $mosData->delete();

        return $this->sendSuccess('Mos Data deleted successfully');
    }
}
