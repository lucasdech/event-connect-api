<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'is_private',
        'password',
        'description',
        'starting_at',
        'location',
    ];

    protected $date = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function message()
    {
        return $this->hasMany(Message::class);
    }

    public function participant()
    {
        return $this->belongsTo(participant::class);
    }
}
