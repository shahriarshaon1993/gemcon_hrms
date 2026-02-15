<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAnswerAPIRequest;
use App\Http\Requests\API\UpdateAnswerAPIRequest;
use App\Models\Answer;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AnswerResource;
use Response;

/**
 * Class AnswerController
 * @package App\Http\Controllers\API
 */

class AnswerAPIController extends AppBaseController
{
    /** @var  AnswerRepository */
    private $answerRepository;

    public function __construct(AnswerRepository $answerRepo)
    {
        $this->answerRepository = $answerRepo;
    }

    /**
     * Display a listing of the Answer.
     * GET|HEAD /answers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $answers = $this->answerRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(AnswerResource::collection($answers), 'Answers retrieved successfully');
    }

    /**
     * Store a newly created Answer in storage.
     * POST /answers
     *
     * @param CreateAnswerAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAnswerAPIRequest $request)
    {
        $input = $request->all();

        $answer = $this->answerRepository->create($input);

        return $this->sendResponse(new AnswerResource($answer), 'Answer saved successfully');
    }

    /**
     * Display the specified Answer.
     * GET|HEAD /answers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Answer $answer */
        $answer = $this->answerRepository->find($id);

        if (empty($answer)) {
            return $this->sendError('Answer not found');
        }

        return $this->sendResponse(new AnswerResource($answer), 'Answer retrieved successfully');
    }

    /**
     * Update the specified Answer in storage.
     * PUT/PATCH /answers/{id}
     *
     * @param int $id
     * @param UpdateAnswerAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAnswerAPIRequest $request)
    {
        $input = $request->all();

        /** @var Answer $answer */
        $answer = $this->answerRepository->find($id);

        if (empty($answer)) {
            return $this->sendError('Answer not found');
        }

        $answer = $this->answerRepository->update($input, $id);

        return $this->sendResponse(new AnswerResource($answer), 'Answer updated successfully');
    }

    /**
     * Remove the specified Answer from storage.
     * DELETE /answers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Answer $answer */
        $answer = $this->answerRepository->find($id);

        if (empty($answer)) {
            return $this->sendError('Answer not found');
        }

        $answer->delete();

        return $this->sendSuccess('Answer deleted successfully');
    }
}
