<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Team;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

            $orders=DB::table('orders')->join('appointments','orders.appointment_id','=','appointments.id')->join('users','orders.user_id','=','users.id')->select('time_appointment','date_appointment','place_appointment','name')->get();
            if(is_null($orders))
            {
               return response()->json("not found");
            }


            return response()->json($orders);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    //public function store(Request $request,$ap_id)
    //public function store(Request $request,Appointment $appointment)
    //public function store(Appointment $appointment)
    public function store($ap_id)
    {

        //$request->validate([
            $user_id = Auth::id(); // تحديد معرف المستخدم

            //$date = Carbon::today(); // تحديد التاريخ الحالي
                    $currentDatetime=now();// التاريخ والوقت
        $date=Carbon::parse($currentDatetime)->format('Y-m-d'); //التاريخ

                    $notAllow = Order::query()
                    ->where('user_id','=',$user_id)
                    //->join('appointments', 'appointments.id', 'orders.appointment_id')
                    ->select('date_order')
                    // ->where('date_appointment', '=', '2024-06-07')
                    ->where('date_order', '=', $date)
                    ->exists();


        if ($notAllow) {
            return response()->json('You have reached the maximum number of appointments for today');
        }


            $order=Order::create([
                  'appointment_id'=>$ap_id,
                  //'user_id'=>Auth::id(),
                  'user_id'=>$user_id,
                  'date_order'=>$date
            ]);

             return response()->json($order);
        }





    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order=Order::find($id);

        if(is_null($order))
        {
            return "order not found";
        }

        return response()->json($order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order,$id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order,$id)
    {




    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order,$id)
    {
        $order=Order::find($id);
        $order->delete();
        if(is_null($order))
        {
            return "not found";
        }
        return response()->json("deleted");
    }

    public function st()
    {


    }
}
