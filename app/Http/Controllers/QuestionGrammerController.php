<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

use App\Http\Requests\QuestionRequest;
use App\Http\Requests\QuestionWithAnswerRequest;
use App\Models\Question;
use Illuminate\Support\Facades\Validator;
use App\Models\Grammer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionGrammerController extends Controller
{
    use GeneralTrait;

    public function showForm()
    {
        return view('addQuestionGrammer');
    }

    public function getAll($grammer_id){
        $questions = Question::with('answers')->get();
        return $this->returnData("questions", $questions);
    }



    public function getById($question_id)
    {

        $question=Question::find($question_id);

        if(!$question)
        {
            return response()->json("question not found");
        }

        $answers=Question::with('answers')->where('id', $question_id)->get();
            return $this->returnData("question", $answers);
        }


        public function submitForm(Request $request)
        {
           // dd($request->status);
            try {

                $validatedData = $request->validate([
                    'grammer' => 'required|string',
                    'question_text' => 'required|array',
                    'question_text.*' => 'required|string',
                    'answer_text' => 'required|array',
                    'answer_text.*' => 'required|array',
                    'answer_text.*.*' => 'string',
                    'status' => 'required',
                    'status.*' => 'required',
                    'status.*.*' => 'required',
                ]);
               // dd($validatedData['status']);
           // return redirect()->back()->with('success', 'Form submitted successfully');
        } catch (\Exception $e) {
            // Log or display the error message
            dd($e->getMessage());
        }
        $user = Auth::user();

        if( $user->role_id == 1)
        {

            $grammer = $validatedData['grammer'];
            $grammer_id = Grammer::where('text', $grammer)->value('id');

            foreach ($validatedData['question_text'] as $index => $question_text) {
                $question = new Question();
                $question->question_text = $question_text;

                if ($grammer_id) {
                    $question->grammer_id = $grammer_id;
                }
                $question->save();

                $answers = [];
                if (isset($validatedData['answer_text'][$index])) {
                    foreach ($validatedData['answer_text'][$index] as $answerIndex => $answer) {
                        $status = isset($validatedData['status'][$index][$answerIndex]) ? $validatedData['status'][$index][$answerIndex] : false;
                        if($status == 'true')
                       {


                        $status = 1;

                       }
                       if($status == 'false' OR $status == false)
                       {
                        $status = 0;
                       }
                        $answers[] = [
                            'answer_text' => $answer,
                            'status' => $status,
                        ];
                    }
                }

                 $question->answers()->createMany($answers);
            }

            return redirect()->route('show_form')->with('success', 'Form submitted successfully!');
        }
        else{
            return view('unAuth');
        }

        }


    public function save(Request $request){
        $request->validate([
            'grammer'=>['required','string'],
            'question_text'=>['required','string'],
            'answers'=>['required','array'],
            'answers.*.answer_text'=>['string','required'],
            'answers.*.status'=>['boolean','required'],
        ]);

        $user = Auth::user();

        if( $user->role_id == 1)
        {
        $grammer_id=DB::table('grammers')->where('text','=',$request->grammer)->value('id');
        if(is_null($grammer_id))
        {
            return response()->json("grammer not found");
        }
        $question=Question::create([

            'question_text'=>$request->question_text,
            'grammer_id'=>$grammer_id,

        ]);



        $question->answers()->createMany($request->answers);
        return $this->returnSuccessMessage("save successfully");
        }
        else{
            return view('unAuth');
        }
    }



    public function update(Request $request,$id){
        $question = Question::find($id);
        if(is_null($question))
        {
            return response()->json("not found");
        }

        $validator=Validator::make($request->all(),[
            'question_text'=>['required','string'],
            //'status'=>['boolean|required',],
            //'question'=>['required','string'],
            'grammer'=>['required','string'],

        ]);


        /*if(is_null($question))
        {
            return response()->json("not found");
        }*/

        $grammer_id=Grammer::query()
        ->select('id')
        ->where('text','=', $request->grammer)
        ->first()['id'];
        //return response()->json($grammer_id);
        if(is_null($grammer_id))
        {
            return response()->json("the grammer not found");
        }

        //if ($question) {
            $question->update([
                'question_text'=>$request->question_text,
                //'status'=>$request->status,
                //'question'=>$request->question,
                'grammer_id'=>$grammer_id,
            ]);
            return $this->returnData("question",$question);
        //} else
           // return $this->returnError("404", "There is no question with id:" . $id . " not found!");

    }




    public function delete($id){
        $question = Question::find($id);
        if ($question) {
            $question->delete();
            return $this->returnSuccessMessage("delete successfully");
        } else
            return $this->returnError("404", "There is no question with id:" . $id . " not found!");

    }
}
