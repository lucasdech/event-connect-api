<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EventUser;
use Illuminate\Http\Request;

class EventUserController extends Controller
{
    public function index(EventUser $EventUser)
    {
        $EventUser = EventUser::all();
        return response()->json($EventUser, 201);
    }

    public function show(EventUser $EventUser)
    {
        $participations = EventUser::where('user_id', 14)->get(); //le 4 c'est le users ID, il fautdrait quil corresponde a l'id de luser connecter apres ca serait cool !
        return response()->json($participations);
    }

    public function destroy(EventUser $EventUser)
    {
        $EventUser->delete();
        return response()->json(null, 204);
    }
}
