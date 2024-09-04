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

    public function show()
    {
        $user_id = auth('api')->user()->id;

        $participations = EventUser::where('user_id', $user_id)
            ->with(['event'])
            ->get();

        return response()->json($participations);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
           'event_id' => 'required|int'
        ]);

        $validated['user_id'] = auth('api')->user()->id;

        $EventUser = EventUser::create($validated);

        return $this->jsonResponse('success', 'Eventuser crated', ['EventUser' => $EventUser], 200) ;
    }

    public function destroy(EventUser $EventUser)
    {
        $EventUser->delete();
        return $this->jsonResponse('success', 'Eventuser deleted', ['users' => $EventUser], 204) ;
    }
}
