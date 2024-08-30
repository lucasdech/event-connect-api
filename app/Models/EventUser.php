<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    use HasFactory;

    public function user_id()
    {
        return $this->hasMany(User::class);
    }

    public function event_id()
    {
        return $this->hasMany(Event::class);
    }
}
