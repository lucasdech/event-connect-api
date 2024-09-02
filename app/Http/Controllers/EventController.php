<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

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
            'password' => 'nulable|string',
            'descripton' => 'required|text',
            'starting_at' => 'required|date',
            'location' => 'required|string',
        ]);

        $event = $request->event()->create($validated);

        return response()->json($event, 201);
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
