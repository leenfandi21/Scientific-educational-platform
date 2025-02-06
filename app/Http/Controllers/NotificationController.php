<?php

namespace App\Http\Controllers;

use App\Models\MarkA1;
use App\Models\User;
use App\Notifications\TotalNotification;

class NotificationController extends Controller
{
    public function sendNotifications()
    {
        $marks = MarkA1::select('total', 'phone_number')->get();

        foreach ($marks as $mark) {
            $user = User::where('phone_number', $mark->phone_number)->first();
            if ($user) {
                $user->notify(new TotalNotification($mark->total));
            }
        }

        // Return a response or redirect as needed
    }
}
