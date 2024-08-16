<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;


    public function userID()
    {
        return $this->hasMany(User::class);
    }

    public function eventID()
    {
        return $this->hasMany(Event::class);
    }
}
