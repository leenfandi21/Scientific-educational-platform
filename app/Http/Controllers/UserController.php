<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getColumnLabels()
    {

        $columnLabels = User::getTableColumns();


        return response()->json($columnLabels);
    }

    public function getUsers()
    {
        $users = User::select('id','name','phone_number','email')->get();

        return response()->json($users);
    }
}
