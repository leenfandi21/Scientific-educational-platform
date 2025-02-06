<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grammer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\level;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class GrammerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   // public function index($level_id)

   public function indexView()
   {

       $grammers = Grammer::with('course')->get();

       return view('grammers', compact('grammers'));
   }


   public function edit(Grammer $grammer)
    {
        $user = Auth::user();

       if( $user->role_id == 1)
       {
       return view('grammers_edit', compact('grammer'));
       }
       return view('unAuth');
    }

    public function update(Request $request, Grammer $grammer)
    {
        $user = Auth::user();

        if( $user->role_id == 1)
        {
        $courseId = Course::where('course_name',$request->course_id)->first()->id;
        $grammer->text = $request->text;
        $grammer->course_id = $courseId;

        $grammer->save();

        return redirect()->route('grammers.index')->with('success', 'Grammer updated successfully.');
        }
        return view('unAuth');
    }

    public function destroy(Grammer $grammer)
    {
        $user = Auth::user();

        if( $user->role_id == 1)
        {
        $grammer->delete();

        return redirect()->route('grammers.index')->with('success', 'Grammer deleted successfully.');
        }
        return view('unAuth');
    }
    public function index($course_id)
    {

        $grammers=DB::table('grammers')->where('course_id','=',$course_id)->get();


        $true=Course::find($course_id)->get();

        if(!$true)
        {
            return response()->json("error");
        }

        return response()->json($grammers);
    }

    public function storeView(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'text' => 'required',
        ]);

        $grammer = new Grammer();

        $coursID = Course::where('course_name',$request->input('course_id'))->first()->id;
        $grammer->course_id =  $coursID;
        $grammer->text = $request->input('text');
        $grammer->save();
        return redirect()->route('grammers.index')->with('success', 'Grammer added successfully');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

           'course'=>['required','string'],
            'text'=>['required','string'],
        ]);


        $course_id=Course::query()
        ->select('id')
        ->where('course_name','=', $request->course)
        ->first()['id'];



        if(is_null($course_id))
        {
             return response()->json("course not found");
        }




        $grammer=Grammer::create([
            'text'=>$request->text,
            'course_id'=>$course_id
        ]);

        return response()->json($grammer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grammer  $grammer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

      $grammer=Grammer::where('id','=',$id)->get();

        if(is_null($grammer))
        {
            return "grammer not found";
        }

        return response()->json($grammer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grammer  $grammer
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grammer  $grammer
     * @return \Illuminate\Http\Response
     */


}
