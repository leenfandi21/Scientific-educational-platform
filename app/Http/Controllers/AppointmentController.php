<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $currentDatetime = Carbon::now();
        $currentDate = $currentDatetime->format('Y-m-d');
        $currentTime = $currentDatetime->format('H:i:s');



        $appointments = Appointment::where('date_appointment', '>', $currentDate)
        //->where('date_appointment', '>', $currentDate)
        //->orWhere('date_appointment', '=', $currentDate)
        ->where('status','=',true)
        //->where('time_appointment', '>=', $currentTime)
        ->get();

        foreach($appointments as $appointment)
        {
            //$answers=$appointment>orders;
            $count=Order::where('appointment_id','=',$appointment->id)->count();
            //return $count;
            if($count >20)
            {
            $appointment->status=false;
            $appointment->save();
            }
        }



        //$appointments=Appointment::all();
        if(is_null($appointments))
        {
            return response()->json("not found");
        }
        return response()->json($appointments);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('appointments');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date_appointment'=>['required','date'],
            'time_appointment'=>['required','time'],
            'time_appointment'=>['required'],
            'place_appointment'=>['required','string'],

        ]);


        $appointments=Appointment::create([
            'date_appointment'=>$request->date_appointment,
            'time_appointment'=>$request->time_appointment,
            'place_appointment'=>$request->place_appointment,


        ]);

        return redirect()->route('appointments.create')->with('success', 'Time aded successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $appointments=Appointment::find($id);

        if(is_null($appointments))
        {
            return "appontment not found";
        }

        return response()->json($appointments);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $validator=Validator::make($request->all(),[

            'date_appointment'=>['required','date'],
            'time_appointment'=>['required'],
            'place_appointment'=>['required','string'],
        ]);


        if($validator->fails())
        {
            return response()->json($validator->errors()->all());
        }


        $appointments=Appointment::find($id);

        if(is_null($appointments))
        {
            return response()->json("not found");
        }


        $appointments->update([

            'date_appointment'=>$request->date_appointment,
            'time_appointment'=>$request->time_appointment,
            'place_appointment'=>$request->place_appointment,

        ]);
        return response()->json($appointments);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $appointments=Appointment::find($id);
        $appointments->delete();
        if(is_null($appointments))
        {
            return "not found";
        }
        return response()->json("deleted");
    }

}
