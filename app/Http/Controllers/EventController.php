<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EventController extends Controller
{

    public function index()
    {
        $event = Event::all();
        return response()->json($event, 201);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'is_private' => 'required|boolean',
            'password' => 'nullable|string',
            'description' => 'required|string',
            'starting_at' => 'required|date',
            'location' => 'required|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $validated['user_id'] = auth('api')->user()->id;

        $event = Event::create($validated);

        return $this->jsonResponse('success', 'Event crated', ['users' => $event], 200) ;
    }


    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'is_private' => 'sometimes|boolean',
            'password' => 'sometimes|nulable|string',
            'descripton' => 'sometimes|text',
            'starting_at' => 'sometimes|date',
            'location' => 'sometimes|string',
        ]);

        $event->update($validated);

        return response()->json($event);
    }

    public function show(Event $event)
    {
        return response()->json($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(null, 204);
    }
}
