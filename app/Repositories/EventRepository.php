<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository
{
    public function create(array $attributes)
    {
        $event = Event::create($attributes); 
        return $event;
    }

    public function update(array $attributes, Event $event)
    {
        $event->update($attributes);
        return $event;
    }
}