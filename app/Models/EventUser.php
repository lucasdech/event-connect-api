<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id'
    ];
    public function user_id()
    {
        return $this->hasOne(User::class);
    }

    public function event()
    {
        return $this->hasOne(Event::class, 'id', 'event_id');
    }
}
