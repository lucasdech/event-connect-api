<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;


class MessageController extends Controller
{

    public function __construct(private MessageRepository $messsageRepository){}

    public function index()
    {
        $message = Message::all();
        return $this->jsonResponse('success', 'All message list', ['messages' => $message], 200) ;

    }

    public function store(Request $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = auth('api')->user()->id;
        $message = $this->messsageRepository->create($inputs);
        return $this->jsonResponse('success', 'Created Mesage ', ['message' => $message], 200) ;

    }

    public function update(Request $request, Message $message)
    {
        $inputs = $request->all();
        $message = $this->messsageRepository->update($inputs, $message->id);
        return $this->jsonResponse('success', 'Message Updated', ['message' => $message], 200) ;

    }

    public function show(Message $message)
    {
        return $this->jsonResponse('success', 'Details Message', ['message' => $message], 200) ;

    }

    public function destroy(Message $message)
    {
        $message->delete();
        return $this->jsonResponse('success', 'Message deleted', ['message' => $message], 200) ;

    }
}
