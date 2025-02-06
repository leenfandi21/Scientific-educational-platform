<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarkA1;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;
use App\Notifications\TotalNotification;
use Illuminate\Support\Facades\Auth;

class MarkA1Controller extends Controller
{
    public function create()
    {
        return view('insert_data');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name.*' => 'required|string',
            'phone_number.*' => 'required',
            'project.*' => 'required|integer',
            'homework.*' => 'required|integer',
            'write.*' => 'required|integer',
            'final.*' => 'required|integer',
        ]);

        $rows = count($validatedData['name']);
        $user = Auth::user();

        if( $user->role_id == 1)
        {
        for ($i = 0; $i < $rows; $i++) {
            $total = $validatedData['project'][$i] + $validatedData['homework'][$i] + $validatedData['write'][$i] + $validatedData['final'][$i];

            $data = [
                'name' => $validatedData['name'][$i],
                'phone_number' => $validatedData['phone_number'][$i],
                'project' => $validatedData['project'][$i],
                'homework' => $validatedData['homework'][$i],
                'write' => $validatedData['write'][$i],
                'final' => $validatedData['final'][$i],
                'total' => $total,
            ];


            MarkA1::create($data);
        }
        return redirect()->back()->with('success', 'Data inserted successfully.');

        }
        else{
            return view('unAuth');
        }
    }


    private function triggerPusherEvent($userId, $total)
    {
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            [
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                'encrypted' => true
            ]
        );

        $pusher->trigger('Golden', 'total-notification', [
            'userId' => $userId,
            'total' => $total
        ]);
    }
}

