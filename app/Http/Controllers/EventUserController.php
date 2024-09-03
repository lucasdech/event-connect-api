<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventUser;
use Illuminate\Http\Request;

class EventUserController extends Controller
{
    public function index(EventUser $EventUser)
    {
        $EventUser = EventUser::all();
        return response()->json($EventUser, 201);
    }

    public function show()
    {
        // $user = auth()->user;
        $participations = EventUser::where('user_id', 14)
            ->with(['event'])
            ->get(); //le 14 c'est le users ID, il fautdrait quil corresponde a l'id de luser connecter apres ca serait cool !
        // $event_user = [];

        // foreach ($participations as $value) {
        //     $events_id = $value->event_id;
        //     $one_event_user = Event::where('id', $events_id)->get();
        //     array_push($event_user, $one_event_user);
        // }    

        return response()->json($participations);
    }

    public function store(Request $request)
    {
        dd($request);

        return response()->json($request, 201);
    }

    public function destroy(EventUser $EventUser)
    {
        $EventUser->delete();
        return response()->json(null, 204);
    }
}
