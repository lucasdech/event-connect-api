<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class SupabaseService
{
    protected $supabaseUrl;
    protected $supabaseKey;
    protected $httpClient;

    public function __construct()
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

    public function addUser($request)
    {
        $response = $this->httpClient->post('users', [
            'json' => [
                $request
            ]
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function getUserById($id)
    {
        $response = $this->httpClient->get('users', [
            'query' => [
                'id' => 'eq.' . $id
            ]
        ]);

        return json_decode($response->getBody()->getContents());
    }

    // Méthode pour ajouter un message à la table Supabase
    public function addMessage($request)
    {
        $response = $this->httpClient->post('messages', [
            'json' => [
                $request
            ]
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
