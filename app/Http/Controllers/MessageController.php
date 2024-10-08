<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Message;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Pusher\Pusher;
use Illuminate\Support\Facades\Log; // Ajoutez cette ligne en haut du fichier

class MessageController extends Controller
{

    /**
     * @OA\Tag(
     *     name="Messages",
     *     description="Operations related to Messages"
     * )
     */
    
    public function __construct(private MessageRepository $messageRepository) {}

    /**
     * @OA\Get(
     *     path="/api/messages",
     *     summary="Get list of messages",
     *     tags={"Messages"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="All message list"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Message"))
     *         )
     *     )
     * )
     */

    public function index()
    {
        $message = Message::all();
        return $this->jsonResponse('success', 'All message list', ['messages' => $message], 200);
    }

    /**
     * @OA\Post(
     *     path="/messages",
     *     summary="Create a new message",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Message")
     *         )
     *     ),
     *     tags={"Messages"},
     *     @OA\Response(
     *         response=200,
     *         description="Message created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Created Message"),
     *             @OA\Property(property="data", ref="#/components/schemas/Message")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
{
    try {
        $inputs = $request->all();
        $inputs['user_id'] = auth('api')->user()->id;

        $message = $this->messageRepository->create($inputs);
        $this->broadcastMessage($message);

        return $this->jsonResponse('success', 'Created Message', ['message' => $message], 200);
    } catch (\Exception $e) {
        // Log l'erreur et renvoie une réponse appropriée
        Log::error('Erreur lors de la création du message: ' . $e->getMessage());
        return $this->jsonResponse('error', 'Internal Server Error', null, 500);
    }
}

    private function broadcastMessage($message)
    {
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ]
        );

        $data = [
            'id' => $message->id,
            'content' => $message->content,
            'user_id' => $message->user_id,
            'event_id' => $message->event_id,
            'created_at' => $message->created_at,
            // Ajoute d'autres champs si nécessaire
        ];

        // Émettre l'événement sur le canal
        $pusher->trigger('chat-channel', 'message-sent', $data);
    }

    /**
     * @OA\Put(
     *     path="/messages/{id}",
     *     summary="Update an existing message",
     *     tags={"Messages"},
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
     *             @OA\Schema(ref="#/components/schemas/Message")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Message updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Message Updated"),
     *             @OA\Property(property="data", ref="#/components/schemas/Message")
     *         )
     *     )
     * )
     */
    public function update(Request $request, Message $message)
    {
        $inputs = $request->all();
        $message = $this->messageRepository->update($inputs, $message->id);
        return $this->jsonResponse('success', 'Message Updated', ['message' => $message], 200);
    }

    /**
     * @OA\Get(
     *     path="/messages/{id}",
     *     summary="Get details of a specific message",
     *     tags={"Messages"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Message details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Details Message"),
     *             @OA\Property(property="data", ref="#/components/schemas/Message")
     *         )
     *     )
     * )
     */
    public function show(Message $message)
    {
        return $this->jsonResponse('success', 'Details Message', ['message' => $message], 200);
    }

    public function showEventMessages(Event $event)
    {
        $messages = Message::where('event_id', $event->id)->with('user')->get();
        return $this->jsonResponse('success', 'Event Messages', ['messages' => $messages], 200);
    }

    /**
     * @OA\Delete(
     *     path="/messages/{id}",
     *     summary="Delete a message",
     *     tags={"Messages"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Message deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Message deleted"),
     *             @OA\Property(property="data", ref="#/components/schemas/Message")
     *         )
     *     )
     * )
     */
    public function destroy(Message $message)
    {
        $message->delete();
        return $this->jsonResponse('success', 'Message deleted', ['message' => $message], 200);
    }
}
