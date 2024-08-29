<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(Participant $participant)
    {
        $participant = Participant::all();
        return response()->json($participant, 201);
    }

    // public function show(Participant $participant)
    // {
    //     return response()->json($participant->eventID($participant->event_id));
    // }

    public function show(Participant $participant)
    {
        // Récupérer l'événement associé au participant
        $event = $participant->events_id;
    
        return response()->json($event);
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();
        return response()->json(null, 204);
    }
}
