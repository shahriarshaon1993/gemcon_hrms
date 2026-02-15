<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserAnswerAPIRequest;
use App\Http\Requests\API\UpdateUserAnswerAPIRequest;
use App\Models\UserAnswer;
use App\Repositories\UserAnswerRepository;
use App\Repositories\AnswerResultRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\UserAnswerResource;
use Response, Auth;

/**
 * Class UserAnswerController
 * @package App\Http\Controllers\API
 */

class UserAnswerAPIController extends AppBaseController
{
    /** @var  UserAnswerRepository */
    private $userAnswerRepository;
    /** @var  AnswerResultRepository */
    private $answerResultRepository;

    public function __construct(UserAnswerRepository $userAnswerRepo, AnswerResultRepository $answerResultRepo)
    {
        $this->userAnswerRepository = $userAnswerRepo;
        $this->answerResultRepository = $answerResultRepo;
    }

    /**
     * Display a listing of the UserAnswer.
     * GET|HEAD /userAnswers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userAnswers = $this->userAnswerRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(UserAnswerResource::collection($userAnswers), 'User Answers retrieved successfully');
    }

    /**
     * Store a newly created UserAnswer in storage.
     * POST /userAnswers
     *
     * @param CreateUserAnswerAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserAnswerAPIRequest $request)
    {
        // $input = $request->all();
        $input['user_id'] = $request->user_id;
        $input['assess_by'] = Auth::guard('user')->user()->id;
        // print_r($request->items); die;
        $userAnswer = $this->userAnswerRepository->create($input);
        foreach ($request->items as $answer) {
            $this->answerResultRepository->create([
                'useranswer_id' => $userAnswer->id,
                'answer_id' => $answer['value'],
                'question_id' => $answer['id']
            ]);
        }
        

        return $this->sendResponse(new UserAnswerResource($userAnswer), 'User Answer saved successfully');
    }

    /**
     * Display the specified UserAnswer.
     * GET|HEAD /userAnswers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserAnswer $userAnswer */
        $userAnswer = $this->userAnswerRepository->find($id);

        if (empty($userAnswer)) {
            return $this->sendError('User Answer not found');
        }

        return $this->sendResponse(new UserAnswerResource($userAnswer), 'User Answer retrieved successfully');
    }

    /**
     * Update the specified UserAnswer in storage.
     * PUT/PATCH /userAnswers/{id}
     *
     * @param int $id
     * @param UpdateUserAnswerAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserAnswerAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserAnswer $userAnswer */
        $userAnswer = $this->userAnswerRepository->find($id);

        if (empty($userAnswer)) {
            return $this->sendError('User Answer not found');
        }

        $userAnswer = $this->userAnswerRepository->update($input, $id);

        return $this->sendResponse(new UserAnswerResource($userAnswer), 'UserAnswer updated successfully');
    }

    /**
     * Remove the specified UserAnswer from storage.
     * DELETE /userAnswers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserAnswer $userAnswer */
        $userAnswer = $this->userAnswerRepository->find($id);

        if (empty($userAnswer)) {
            return $this->sendError('User Answer not found');
        }

        $userAnswer->delete();

        return $this->sendSuccess('User Answer deleted successfully');
    }
}
