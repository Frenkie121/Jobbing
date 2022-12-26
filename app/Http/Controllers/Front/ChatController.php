<?php

namespace App\Http\Controllers\Front;

use App\Events\ChatMessageEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('front.chat', [

        ]);
    }

    public function store(Request $request)
    {
        event(new ChatMessageEvent($request->message));

        return response()->json([
            'success' => 'Message sent',
        ]);
    }
}
