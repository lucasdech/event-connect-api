<?php

namespace App\Http\Controllers;

use App\Criteria\SearchEventCriteria;
use App\Entities\Event;
use App\Http\Controllers\Controller;
use App\Models\EventUser;
use App\Repositories\EventUserRepository;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

class EventUserController extends Controller
{

    protected $eventUserRepository;

    public function __construct(EventUserRepository $eventUserRepository)
    {
        $this->eventUserRepository = $eventUserRepository;
    }

    public function index(EventUser $EventUser)
    {
        $EventUser = EventUser::all();
        return $this->jsonResponse('success', 'User Event Details', ['User Event' => $EventUser], 201);
    }

    public function show()
    {
        $user_id = auth('api')->user()->id;
        $this->eventUserRepository->pushCriteria(new RequestCriteria(app(Request::class)));
        $participations = $this->eventUserRepository->findWhere(['user_id' => $user_id])->load('event');
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

    public function destroy(int $userId, int $eventId)
    {
        $EventUser = EventUser::where('user_id', $userId)->where('event_id', $eventId)->first();

        $this->eventUserRepository->delete($EventUser->id);
        return $this->jsonResponse('success', 'Eventuser deleted', ['users' => $EventUser], 204) ;
    }
}
