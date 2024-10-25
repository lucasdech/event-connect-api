<?php

namespace App\Services;

use App\Repositories\UserRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class SupabaseService
{
    protected $supabaseUrl;
    protected $supabaseKey;
    protected $httpClient;

    public function __construct(private UserRepository $userRepository)
    {
        $this->supabaseUrl = env('SUPABASE_URL');
        $this->supabaseKey = env('SUPABASE_KEY');
        $this->httpClient = new Client([
            'base_uri' => $this->supabaseUrl . '/rest/v1/',
            'headers' => [
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    // Méthode pour ajouter un message à la table Supabase
    public function addMessage($request)
    {
        $user_id = $request["user_id"];
        $user = $this->userRepository->find($user_id);

        $dataToSend = [
            'user_id' => $request["user_id"],
            'event_id' => $request["event_id"],
            'content' => $request["content"],
            'profile_picture' => $user->profile_picture,
            'name' => $user->name,
        ];

      
        $response = $this->httpClient->post('messages', [
            'json' => $dataToSend
        ]);

        return json_decode($response->getBody()->getContents());
    }

    // Méthode pour récupérer les messages
    public function getMessagesByEvent($event)
    {
        $response = $this->httpClient->get('messages', [
            'query' => [
                'event_id' => 'eq.' . $event
            ]
        ]);
        return json_decode($response->getBody()->getContents());
    }
}
