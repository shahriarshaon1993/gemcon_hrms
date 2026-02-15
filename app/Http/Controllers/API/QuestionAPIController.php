<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateQuestionAPIRequest;
use App\Http\Requests\API\UpdateQuestionAPIRequest;
use App\Models\Question;
use App\Repositories\QuestionRepository;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\QuestionResource;
use Response, Auth, DB;

/**
 * Class QuestionController
 * @package App\Http\Controllers\API
 */

class QuestionAPIController extends AppBaseController
{
    /** @var  QuestionRepository */
    private $questionRepository;
    /** @var  AnswerRepository */
    private $answerRepository;

    public function __construct(QuestionRepository $questionRepo, AnswerRepository $answerRepo)
    {
        $this->questionRepository = $questionRepo;
        $this->answerRepository = $answerRepo;
    }

    /**
     * Display a listing of the Question.
     * GET|HEAD /questions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $questions = $this->questionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(QuestionResource::collection($questions), 'Questions retrieved successfully');
    }
    public function jd_qus($user_id)
    {
        // $questions = $this->questionRepository->all(
        //     $request->except(['skip', 'limit']),
        //     $request->get('skip'),
        //     $request->get('limit')
        // );
        $questions = Question::join('user_m_os', 'user_m_os.mos_id', '=', 'questions.mos_id')
            ->where('user_m_os.emp_id', $user_id)
            ->select('questions.*')
            ->get();

        return $this->sendResponse(QuestionResource::collection($questions), 'Questions retrieved successfully');
    }

    /**
     * Store a newly created Question in storage.
     * POST /questions
     *
     * @param CreateQuestionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateQuestionAPIRequest $request)
    {
        $input = $request->all();
        // $user_data = Auth::guard('user')->user();

        // $input['employee_unit'] = $user_data->unit;
        // $input['employee_sub_unit'] = $user_data->sub_unit;
        // $input['dept_id'] = $user_data->department;
        // $input['employee_section'] = $user_data->section;
        // $input['employee_sub_section'] = $user_data->sub_section;
        // $input['employee_work_location'] = $user_data->work_location;
        $question = $this->questionRepository->create($input);
        //  print_r($request->arrayData['children']); die;
        foreach ($request->arrayData['children'] as $answer) {
            $answerInput['question_id'] = $question->id;
            $answerInput['vAnswer'] = $answer['name'];
            $answerInput['mark'] = $answer['mark'];
            $this->answerRepository->create($answerInput);
        }

        return $this->sendResponse(new QuestionResource($question), 'Question saved successfully');
    }

    public function update_store(CreateQuestionAPIRequest $request)
    {
        $question_find = $this->questionRepository->find($id);

        if (empty($question_find)) {
            return $this->sendError('Question not found');
        }
        DB::table('answers')->where('question_id', $question_find->id)->delete();

        $question_find->delete();

        $input = $request->all();
        $user_data = Auth::guard('user')->user();

        $input['employee_unit'] = $user_data->unit;
        $input['employee_sub_unit'] = $user_data->sub_unit;
        $input['dept_id'] = $user_data->department;
        $input['employee_section'] = $user_data->section;
        $input['employee_sub_section'] = $user_data->sub_section;
        // $input['employee_work_location'] = $user_data->work_location;
        // $question = $this->questionRepository->create($input);
        //  print_r($request->arrayData['children']); die;
        foreach ($request->arrayData['children'] as $answer) {
            $answerInput['question_id'] = $question->id;
            $answerInput['vAnswer'] = $answer['name'];
            $answerInput['mark'] = $answer['mark'];
            $this->answerRepository->create($answerInput);
        }

        return $this->sendResponse(new QuestionResource($question), 'Question saved successfully');
    }

    /**
     * Display the specified Question.
     * GET|HEAD /questions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Question $question */
        $question = $this->questionRepository->find($id);

        if (empty($question)) {
            return $this->sendError('Question not found');
        }

        return $this->sendResponse(new QuestionResource($question), 'Question retrieved successfully');
    }

    /**
     * Update the specified Question in storage.
     * PUT/PATCH /questions/{id}
     *
     * @param int $id
     * @param UpdateQuestionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQuestionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Question $question */
        $question = $this->questionRepository->find($id);

        if (empty($question)) {
            return $this->sendError('Question not found');
        }

        // $user_data = Auth::guard('user')->user();

        // $input['employee_unit'] = $user_data->unit;
        // $input['employee_sub_unit'] = $user_data->sub_unit;
        // $input['dept_id'] = $user_data->department;
        // $input['employee_section'] = $user_data->section;
        // $input['employee_sub_section'] = $user_data->sub_section;
        $input['mos_id'] = $request->mos_id;

        $question = $this->questionRepository->update($input, $id);
        DB::table('answers')->where('question_id', $id)->delete();
        foreach ($request->arrayData['children'] as $answer) {
            $answerInput['question_id'] = $id;
            $answerInput['vAnswer'] = $answer['name'];
            $answerInput['mark'] = $answer['mark'];
            $this->answerRepository->create($answerInput);
        }

        return $this->sendResponse(new QuestionResource($question), 'Question updated successfully');
    }

    /**
     * Remove the specified Question from storage.
     * DELETE /questions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Question $question */
        $question = $this->questionRepository->find($id);

        if (empty($question)) {
            return $this->sendError('Question not found');
        }

        $question->delete();

        return $this->sendSuccess('Question deleted successfully');
    }
}
