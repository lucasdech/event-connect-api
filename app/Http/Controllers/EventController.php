<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Repositories\EventRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Criteria\RequestCriteria;

class EventController extends Controller
{

    /**
     * @OA\Tags(
     *     name="Event",
     *     description="Operations related to Event"
     * )
     */
    
    public function __construct(private EventRepository $eventRepository) {}

    /**
     * @OA\Get(
     *     path="/events",
     *     summary="Get list of events",
     *     tags={"Event"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Event List"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Event"))
     *         )
     *     )
     * )
     */
    public function index(request $request) 
    {
        $events = $this->eventRepository->pushCriteria(new RequestCriteria($request))->all();
        return $this->jsonResponse('success', 'Event List', ['events' => $events], 200);
    }
    

    /**
     * @OA\Post(
     *     path="/events",
     *     summary="Create a new event",
     *     tags={"Event"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Event")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Event created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Event created"),
     *             @OA\Property(property="data", ref="#/components/schemas/Event")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['user_id'] = auth('api')->user()->id;
        $event = $this->eventRepository->create($input);
        return $this->jsonResponse('success', 'Event created', ['event' => $event], 201);
    }

    /**
     * @OA\Put(
     *     path="/events/{id}",
     *     summary="Update an existing event",
     *     tags={"Event"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Event")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Event Updated"),
     *             @OA\Property(property="data", ref="#/components/schemas/Event")
     *         )
     *     )
     * )
     */
    public function update(Request $request, Event $event)
    {
        $input = $request->all();
        $event = $this->eventRepository->update($input, $event->id);
        return $this->jsonResponse('success', 'Event Updated', ['event' => $event], 201);
    }

    /**
     * @OA\Get(
     *     path="/events/{id}",
     *     summary="Get details of a specific event",
     *     tags={"Event"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Event Details"),
     *             @OA\Property(property="data", ref="#/components/schemas/Event")
     *         )
     *     )
     * )
     */
    public function show(Event $event)
    {
        return $this->jsonResponse('success', 'Event Details', ['event' => $event], 201);
    }

    /**
     * @OA\Delete(
     *     path="/events/{id}",
     *     summary="Delete an event",
     *     tags={"Event"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Event deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Event Deleted"),
     *             @OA\Property(property="data", ref="#/components/schemas/Event")
     *         )
     *     )
     * )
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return $this->jsonResponse('success', 'Event Deleted', ['event' => $event], 204);
    }

}
