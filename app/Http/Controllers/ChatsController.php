<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatsController extends Controller
{
    public function index( )
    {
        return view('vendor.voyager.slug-name.chats');
    }
}
