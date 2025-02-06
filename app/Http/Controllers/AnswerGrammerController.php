<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AnswerRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Choice;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AnswerGrammerController extends Controller
{
    use GeneralTrait;


    public function ret_true($grammer_id)
    {
        $user_id=Auth::id();

        /*$ansewrs=DB::table('questions')->join('answers','answers.question_id','=','questions.id')
        ->where('answers.user_id','=',$user_id)
        ->where('questions.grammer_id','=',$grammer_id)
        ->where('answers.status','=',false)
        ->select('questions.question_text','answers.answer_text')
        ->get();*/
        //->where(fuction($query)
        //{
            //$query->select('questions.text','answers.text')
           // ->where('answers.status','=',true);
        //})
        //->get();

        $ansewrs=DB::table('questions')->join('choices','choices.question_id','=','questions.id')
        ->join('answers','answers.question_id','=','questions.id')
        ->where('choices.user_id','=',$user_id)
        ->where('questions.grammer_id','=',$grammer_id)
        ->where('choices.status','=',false)
        ->select('questions.question_text','answers.answer_text')
        ->where('answers.status','=',true)
        ->get();



        /*$ansewrs = Question::whereHas('choices', function ($query) use ($user_id)
        { $query->where('user_id', $user_id) ->where('status', false); })
        ->where('grammerid', $grammer_id)
         ->whereHas('choices.answers', function ($query)
         { $query->where('status', true); })
          ->with(['choices.answers' => function ($query)
        { $query->select('answertext'); }]) ->select('question_text') ->get();*/

        /*->where(fuction($query)
        {
            $query->select('questions.text','answers.text')
            ->where('answers.status','=',true);
        })
        ->get();*/
        if(is_null($ansewrs))
        {
             return response()->json("not found");
        }
        return response()->json($ansewrs);
    }



    public function getAll($grammer_id){
        //$answers = Answer::all();
        /*$answers = DB::table('questions')->join('answers','answers.question_id','=','questions.id')
        ->where('questions.grammer_id','=',$grammer_id)
        ->where('answers.user_id','=',null)
        ->value('answers.status','answers.text');*/

        //$question=Question::find($question_id)->where();
        //$answers=Question::with('answers')->where('id', $question_id)->get();

        $questions=Question::where('grammer_id','=',$grammer_id)->get();
        foreach($questions as $question)
        {
            $answers = Answer::where('question_id','=',$question->id)
            ->get();
            return $this->returnData("answers", $answers);
        }

        /*foreach($questions as $question)
        {

            $x=Question::with('answers')->where('id', $question->id)->get();
            return response()->json($x);
        }*/

        //return $this->returnData("answers", $answers);
    }



    public function getById($id)
    {
        $answer =DB::table('answers')->where('id','=',$id)->get();
        if ($answer)
            return $this->returnData("answer", $answer);
        else
            return $this->returnError("404", "There is no answer with id:" . $id . " not found!");

    }



    public function save(Request  $request)
    {

        $validator=Validator::make($request->all(),[
            '_answer_text'=>['required','string'],
            'status'=>['boolean|required',],
            'question'=>['required','string']

        ]);

        $question_id = Question::
        select('id')
        ->where('question_text','=', $request->question)
        ->where('grammer_id','!=',null)
        ->first()['id'];
        //return response()->json($question_id);

        //$user_id=Auth::id();
        //return response()->json($question_id);

        //$question = Question::find($question_id);

        if(is_null($question_id))
        {
            return $this->returnError("404", "There is no question with id:" . $question_id . " not found!");
        }

        //if ($question_id) {
            $answer=Answer::create([
            'answer_text'=>$request->answer_text,
            'status'=>$request->status,
            'question_id'=>$question_id,
            //'user_id'=>$user_id
        ]);
            return response()->json($answer);
        //}
        //else{
            //if(!$question_id)
            //return response()->json("false");
            //return $this->returnError("404", "There is no question with id:" . $question_id . " not found!");
        //}
    }


    public function update(Request  $request,$id){

                $validator=Validator::make($request->all(),[
                'answer_text'=>['required','string'],
                'status'=>['boolean|required',],
                'question'=>['required','string']

            ]);

            $question_id = Question::
            select('id')
            ->where('question_text','=', $request->question)
            ->where('grammer_id','!=',null)
            ->first()['id'];

            if(is_null($question_id))
            {
                return response()->json("question not found");
            }


            $answer_old = Answer::find($id);
            if(is_null($answer_old))
            {
                return response()->json("answer not found");
            }


        $answer_old->update([
            'answer_text'=>$request->answer_text,
            'status'=>$request->status,
            'question_id'=>$question_id
        ]);

        return response()->json($answer_old);
        //"id":13,

    }




    public function answer(Request $request,$question_id)
    {
        $request->validate([

            'answer'=>['required','string'],

        ]);
        //$answers= Question::find($question_id)->answers;

        $an=$request->answer;

        $questions=DB::table('answers')->join('questions','answers.question_id','=','questions.id')
        ->where('answers.status','=',1)->value('answers.answer_text');
        //return response()->json($questions);

        $ans=Str::slug($questions);

        $user_id=Auth::id();
        if($request->answer == $ans)
        {
            /*Answer::create([
                'answer_text'=>$request->answer,
                'status'=>true,
                'user_id'=>$user_id,
                'question_id'=>$question_id

            ]);*/

            Choice::create([
                'answer_text'=>$request->answer,
                'status'=>true,
                'user_id'=>$user_id,
                'question_id'=>$question_id

            ]);
            return response()->json("true");
        }
        else
        {
            /*Answer::create([
                'answer_text'=>$request->answer,
                'status'=>false,
                'user_id'=>$user_id,
                'question_id'=>$question_id

            ]);*/

            Choice::create([
                'answer_text'=>$request->answer,
                'status'=>false,
                'user_id'=>$user_id,
                'question_id'=>$question_id

            ]);
            return response()->json("false");
        }


    }





    public function delete($id){
        $answer = Answer::find($id);
        //return response()->json($answer);
        if ($answer) {
            $answer->delete();
            return $this->returnSuccessMessage("delete successfully");
        } else
            return $this->returnError("404", "There is no answer with id:" . $id . " not found!");
    }

}
