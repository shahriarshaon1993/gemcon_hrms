<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAnswerResultAPIRequest;
use App\Http\Requests\API\UpdateAnswerResultAPIRequest;
use App\Models\AnswerResult;
use App\Repositories\AnswerResultRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AnswerResultResource;
use Response;

/**
 * Class AnswerResultController
 * @package App\Http\Controllers\API
 */

class AnswerResultAPIController extends AppBaseController
{
    /** @var  AnswerResultRepository */
    private $answerResultRepository;

    public function __construct(AnswerResultRepository $answerResultRepo)
    {
        $this->answerResultRepository = $answerResultRepo;
    }

    /**
     * Display a listing of the AnswerResult.
     * GET|HEAD /answerResults
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $answerResults = $this->answerResultRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(AnswerResultResource::collection($answerResults), 'Answer Results retrieved successfully');
    }

    /**
     * Store a newly created AnswerResult in storage.
     * POST /answerResults
     *
     * @param CreateAnswerResultAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAnswerResultAPIRequest $request)
    {
        $input = $request->all();

        $answerResult = $this->answerResultRepository->create($input);

        return $this->sendResponse(new AnswerResultResource($answerResult), 'Answer Result saved successfully');
    }

    /**
     * Display the specified AnswerResult.
     * GET|HEAD /answerResults/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AnswerResult $answerResult */
        $answerResult = $this->answerResultRepository->find($id);

        if (empty($answerResult)) {
            return $this->sendError('Answer Result not found');
        }

        return $this->sendResponse(new AnswerResultResource($answerResult), 'Answer Result retrieved successfully');
    }

    /**
     * Update the specified AnswerResult in storage.
     * PUT/PATCH /answerResults/{id}
     *
     * @param int $id
     * @param UpdateAnswerResultAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnswerResultAPIRequest $request)
    {
        $input = $request->all();

        /** @var AnswerResult $answerResult */
        $answerResult = $this->answerResultRepository->find($id);

        if (empty($answerResult)) {
            return $this->sendError('Answer Result not found');
        }

        $answerResult = $this->answerResultRepository->update($input, $id);

        return $this->sendResponse(new AnswerResultResource($answerResult), 'AnswerResult updated successfully');
    }

    /**
     * Remove the specified AnswerResult from storage.
     * DELETE /answerResults/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AnswerResult $answerResult */
        $answerResult = $this->answerResultRepository->find($id);

        if (empty($answerResult)) {
            return $this->sendError('Answer Result not found');
        }

        $answerResult->delete();

        return $this->sendSuccess('Answer Result deleted successfully');
    }
}
