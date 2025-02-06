<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Exam;
use App\Models\Course;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;

class ExamController extends Controller
{
    public function addcourse(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'course_name' => 'required',
            'course_code' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $course = Course::create([
            'course_name' => $request->course_name,
            'course_code' => $request->course_code
        ]);
        return response()->json([
            'data' => $course->only(['course_name', 'course_code', 'id'])
        ]);
    }
    public function addexam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        'time_of_exam' => 'required',
        'date_of_exam' => 'required|date',
        'course_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $exam = Exam::create([
            'name' => $request->name,
            'time_of_exam' => $request->time_of_exam,
            'date_of_exam' =>$request->date_of_exam,
            'course_id' =>$request->course_id
        ]);

        return response()->json([
            'data' => $exam->only(['id','name',
            'time_of_exam' ,
            'date_of_exam', 'course_id'])
        ]);

    }
    public function addequestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_text'=> 'required',
        'grammer_id'=> 'required',
        'exam_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $question = Question::create([
            'question_text'=>$request->question_text,
            'grammer_id'=>$request->grammer_id,
            'exam_id'=>$request->exam_id
        ]);

        return response()->json([
            'data' => $question->only(['id' , 'question_text', 'grammer_id', 'exam_id' ])
        ]);

    }
    public function addeanswer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'answer_text'=>'required',
            'question_id'=> 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $answer = Answer::create([
            'answer_text'=>$request->answer_text,
            'question_id'=>$request->question_id
        ]);

        return response()->json([
            'data' => $answer->only(['id' , 'answer_text', 'question_id' ])
        ]);

    }

    public function getExam(Request $request)
    {
        $exam = Exam::find($request->exam_id);

        if (!$exam) {
            return response()->json(['error' => 'Exam not found'], 404);
        }

        $questionsWithAnswers = Question::where('exam_id', $exam->id)
            ->with('answers')
            ->get()
            ->map(function ($question) {
                return [
                    'question' => $question->question_text,
                    'answers' => $question->answers->pluck('answer_text')->toArray(),
                ];
            });

        return response()->json([
            'data' => [ 'message'=>'the exam contains',
            'questions' => $questionsWithAnswers]
        ]);
    }

}
