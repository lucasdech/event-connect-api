<?php

namespace App\Http\Controllers;

use App\Entities\Event;
use App\Http\Controllers\Controller;
use App\Models\EventUser;
use App\Repositories\EventUserRepository;
use Illuminate\Http\Request;

class EventUserController extends Controller
{

    public function __construct(private EventUserRepository $eventUserRepository){}

    public function index(EventUser $EventUser)
    {
        $EventUser = EventUser::all();
        return $this->jsonResponse('success', 'User Event Details', ['User Event' => $EventUser], 201);
    }

    public function show()
    {
        $user_id = auth('api')->user()->id;
        $participations = EventUser::where('user_id', $user_id)->with(['event'])->get();
        return $this->jsonResponse('success', 'User Event Details', ['User Event' => $participations], 201);
    }

    public function showUserInEvent(int $eventId)
    {
        $participations = EventUser::where('event_id', $eventId)->with(['user'])->get();
        return $this->jsonResponse('success', 'User in Same Event', ['User Event' => $participations], 201);
    }
   
    public function store(Request $request)
    {
        $inputs = $request->all();
        // $inputs['user_id'] = auth('api')->user()->id;
        $EventUser = $this->eventUserRepository->create($inputs);
        return $this->jsonResponse('success', 'Eventuser crated', ['EventUser' => $EventUser], 200) ;
    }

    public function destroy(int $userId)
    {
        $EventUser = EventUser::where('user_id', $userId)->first();
        $EventUser = $this->eventUserRepository->delete($EventUser);
        return $this->jsonResponse('success', 'Eventuser deleted', ['users' => $EventUser], 204) ;
    }
}
