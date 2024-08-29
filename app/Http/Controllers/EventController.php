<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{

    public function index(Request $request)
    {
        $event = Event::all();
        return response()->json($event, 201);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'starting_point' => 'required|string',
            'ending_point' => 'required|string',
            'starting_at' => 'required|date',
            'available_seats' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $event = $request->event()->event()->create($validated);

        return response()->json($event, 201);
    }


    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'starting_point' => 'sometimes|string',
            'ending_point' => 'sometimes|string',
            'starting_at' => 'sometimes|date',
            'available_seats' => 'sometimes|integer|min:1',
            'price' => 'sometimes|numeric|min:0',
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
