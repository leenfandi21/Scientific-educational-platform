<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\QuestionRequest;
use App\Http\Requests\QuestionWithAnswerRequest;
use App\Models\Questionlevel;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;


class QuestionLevelController extends Controller
{
    use GeneralTrait;
    public function getAll(){
        $questions = Questionlevel::with('answers')->get();
        //->get();

        /*$questions = Questionlevel::with('choices')//->get();
        ->where('answerlevels.user_id','=',null)
        ->get();*/



        //$questions=Questionlevel::all();

        /*$questions=DB::table('questionlevels')
        ->join('answerlevels','questionlevels.id','=','answerlevels.questionlevel_id')
        ->whereNull('answerlevels.user_id')
        ->select('questionlevels.level_text','answerlevels.answer_text','answerlevels.status')
        //->whereNull('answerlevels.user_id')
        ->get();*/


        //$questions = Questionlevel::where('grammer_id','=',$grammer_id)->get();

        return $this->returnData("questions", $questions);
    }



    public function getById($question_id)
    {
        //$question = Questionlevel::find($id);
        //$question=Questionlevel::where('id','=',$question_id)->with('answers')->get();
        $question=Questionlevel::find($question_id);
        if(!$question)
        {
            return response()->json("question not found");
        }
        $answers=Questionlevel::with('answers')->where('id', $question_id)->get();
        return $this->returnData("question", $answers);
        /*if ($question){
            $question->answers;
            return $this->returnData("question", $question);
        }*/
        //else
            //return $this->returnError("404", "There is no question with id:" . $question_id . " not found!");


    }



    public function save(Request $request){
        $request->validate([
            'level_text'=>['required','string'],
            'answers'=>['required','array'],
            'answers.*.answer_text'=>['string','required'],
            'answers.*.status'=>['boolean','required'],
        ]);


        $question=Questionlevel::create([

            'level_text'=>$request->level_text,

        ]);
        $question->answers()->createMany($request->answers);
        return $this->returnSuccessMessage("save successfully");
    }



    public function update(Request $request,$id){
        $question = Questionlevel::find($id);

        $validator=Validator::make($request->all(),[
            'level_text'=>['required','string'],

        ]);


        if(is_null($question))
        {
            return response()->json("not found");
        }



        //if ($question) {
            $question->update([
                'level_text'=>$request->level_text,

            ]);
            return response()->json($question);
        //} else
           // return $this->returnError("404", "There is no question with id:" . $id . " not found!");

    }




    public function delete($id){
        $question = Questionlevel::find($id);
        if ($question) {
            $question->delete();
            return $this->returnSuccessMessage("delete successfully");
        } else
            return $this->returnError("404", "There is no question with id:" . $id . " not found!");

    }
}
