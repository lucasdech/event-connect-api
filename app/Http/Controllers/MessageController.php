<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;


class MessageController extends Controller
{
    public function index()
    {
        $message = Message::all();
        return response()->json($message, 201);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $message = $request->message()->create($validated);

        return response()->json($message, 201);
    }


    public function update(Request $request, Message $message)
    {
        $validated = $request->validate([
            'content' => 'sometimes|string'
        ]);

        $message->update($validated);

        return response()->json($message);
    }

    public function show(Message $message)
    {
        return response()->json($message);
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return response()->json(null, 204);
    }
}
