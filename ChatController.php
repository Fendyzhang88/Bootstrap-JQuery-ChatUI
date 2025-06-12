<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function fetch()
    {
        $chats = Chat::where("session_id", session()->getId())->get();
        return $chats;
    }

    public function fetchAI()
    {   
        $chat = Chat::where("session_id", session()->getId())->latest()->first();
        if($chat->user == "Guest"){
            Chat::create([
               'user' => 'AI Bot',
               'session_id' => session()->getId(),
               'message' => 'Hallo Selamat Datang',
            ]);
        }
        
        $chats = Chat::where("session_id", session()->getId())->get();   
        return $chats;
    }

    public function send(Request $request)
    {
        Chat::create([
            'user' => 'Guest', // bisa diganti jika pakai auth
            'session_id' => session()->getId(),
            'message' => $request->message,
        ]);

        return response()->json(['status' => 'Message Sent']);
    }
}
