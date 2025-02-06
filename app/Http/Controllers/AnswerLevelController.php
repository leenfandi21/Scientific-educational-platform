<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AnswerRequest;
use App\Models\Answerlevel;
use App\Models\Questionlevel;
use App\Models\Levelchoice;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AnswerLevelController extends Controller
{
    use GeneralTrait;


    public function clac_lev()
    {
        $user_id=Auth::id();

        /*$number=DB::table('questionlevels')->join('answerlevels','questionlevels.id','=','answerlevels.questionlevel_id')
        ->where('answerlevels.status','=',true)
        ->where('answerlevels.user_id','=',$user_id)
        ->count();*/

        $number=DB::table('questionlevels')->join('levelchoices','questionlevels.id','=','levelchoices.questionlevel_id')
        ->where('levelchoices.status','=',true)
        ->where('levelchoices.user_id','=',$user_id)
        ->distinct()
        ->count();

        if($number==24 | $number==23)
           return response()->json("B6");
        elseif($number==21 | $number==22)
           return response()->json("A6");
        elseif($number==19 | $number==20)
           return response()->json("B5");
        elseif($number==17 | $number==18)
           return response()->json("A5");
        elseif($number==15 | $number==16)
           return response()->json("B4");
        elseif($number==13 | $number==14)
           return response()->json("A4");
        elseif($number==11 | $number==12)
           return response()->json("B3");
        elseif($number==9 | $number==10)
           return response()->json("A3");
        elseif($number==7 | $number==8)
           return response()->json("B2");
        elseif($number==5 | $number==6)
           return response()->json("A2");
        elseif($number==3 | $number==4)
           return response()->json("B1");
        else
           return response()->json("A1");




    }

    public function getAll(){
        /*$answers = DB::table('questionlevel')->join('answerslevel','answerslevel.question_id','=','questionlevel.id')
        ->where('questionlevel.grammer_id','=',null)
        ->where('answerslevel.user_id','=',null)
        ->select('answerslevel.status','answerslevel.text');*/

        $answers =Answerlevel::all();
        return $this->returnData("answers", $answers);

        /*$questions=Questionlevel::all();
        foreach($questions as $question)
        {
            $answers = Answerlevel::where('question_id','=',$question->id)
            ->where('user_id','=',null)
            ->get();
            return $this->returnData("answers", $answers);
        }*/

        //return $this->returnData("answers", $answers);
    }



    public function getById($id)
    {
        $answer = Answerlevel::find($id);
        //$answer =DB::table('answerslevel')->where('id','=',$id)->get();
        if ($answer)
            return $this->returnData("answer", $answer);
        else
            return $this->returnError("404", "There is no answer with id:" . $id . " not found!");

    }



    public function save(Request  $request)
    {

        $validator=Validator::make($request->all(),[
            'answer_text'=>['required','string'],
            'status'=>['boolean','required'],
            'question'=>['required','string']

        ]);

        $questionlevel_id = Questionlevel::
        select('id')
        ->where('level_text','=', $request->question)
        ->first()['id'];

        //return response()->json($question_id);

        //$question = Question::find($question_id);

        if(is_null($questionlevel_id))
        {
            return $this->returnError("404", "There is no question with id:" . $questionlevel_id . " not found!");
        }

        //if ($question_id) {
            Answerlevel::create([
            'answer_text'=>$request->answer_text,
            'status'=>$request->status,
            'questionlevel_id'=>$questionlevel_id
        ]);
            return $this->returnSuccessMessage("save successfully");
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


            $answer_old = Answerlevel::find($id);
            if(is_null($answer_old))
            {
                return response()->json("answer not found");
            }

            $questionlevel_id = Questionlevel::
            select('id')
            ->where('level_text','=', $request->question)
            ->first()['id'];



        $answer_old->update([
            'answer_text'=>$request->answer_text,
            'status'=>$request->status,
            'questionlevel_id'=>$questionlevel_id
        ]);

        return response()->json($answer_old);
        //"id":13,

    }


    public function answer(Request $request,$questionlevel_id)
    {
        $request->validate([

            'answer'=>['required','string'],

        ]);
        //$answers= Questionlevel::find($questionlevel_id)->answers;

        $an=$request->answer;

        $questions=DB::table('answerlevels')->join('questionlevels','answerlevels.questionlevel_id','=','questionlevels.id')
        ->where('answerlevels.status','=',1)->value('answerlevels.answer_text');
        //return response()->json($questions);

        $ans=Str::slug($questions);

        $user_id=Auth::id();
        if($request->answer == $ans)
        {
            /*Answerlevel::create([
                'answer_text'=>$request->answer,
                'status'=>true,
                'user_id'=>$user_id,
                'questionlevel_id'=>$questionlevel_id

            ]);*/
            Levelchoice::create([
                'answer_text'=>$request->answer,
                'status'=>true,
                'user_id'=>$user_id,
                'questionlevel_id'=>$questionlevel_id

            ]);
            return response()->json("true");
        }
        else
        {
            /*Answerlevel::create([
                'answer_text'=>$request->answer,
                'status'=>false,
                'user_id'=>$user_id,
                'questionlevel_id'=>$questionlevel_id

            ]);*/
            Levelchoice::create([
                'answer_text'=>$request->answer,
                'status'=>false,
                'user_id'=>$user_id,
                'questionlevel_id'=>$questionlevel_id

            ]);
            return response()->json("false");
        }


    }




    public function delete($id){
        $answer = Answerlevel::find($id);
         //return response()->json($answer);
        if ($answer) {
            $answer->delete();
            return $this->returnSuccessMessage("delete successfully");
        } else
            return $this->returnError("404", "There is no answer with id:" . $id . " not found!");
    }




}

