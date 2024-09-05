<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Repositories\EventRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EventController extends Controller
{

    public function __construct(private EventRepository $eventRepository){}

    public function index()
    {
        $event = Event::all();
        return $this->jsonResponse('success', 'Event List', ['event' => $event], 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['user_id'] = auth('api')->user()->id;
        $event = $this->eventRepository->create($input);
        return $this->jsonResponse('success', 'Event created', ['event' => $event], 201);
    }

    public function update(Request $request, Event $event)
    {
        $input = $request->all();
        $event = $this->eventRepository->update($input, $event->id);
        return $this->jsonResponse('success', 'Event Updated', ['event' => $event], 201);
    }

    public function show(Event $event)
    {
        return $this->jsonResponse('success', 'Event Details', ['event' => $event], 201);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return $this->jsonResponse('success', 'Event Deleted', ['event' => $event], 201);
    }
}
