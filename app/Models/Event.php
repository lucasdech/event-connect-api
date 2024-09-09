<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Event",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Event Title"),
 *     @OA\Property(property="is_private", type="boolean", example=true),
 *     @OA\Property(property="password", type="string", example="hashed_password"),
 *     @OA\Property(property="description", type="string", example="Event description here"),
 *     @OA\Property(property="starting_at", type="string", format="date-time", example="2024-09-09T12:00:00Z"),
 *     @OA\Property(property="location", type="string", example="Event Location"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-09-09T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-09-09T12:00:00Z"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", example="2024-09-09T12:00:00Z")
 * )
 */
class Event extends Model
{
    use HasFactory, SoftDeletes;

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

    public function eventUser()
    {
        return $this->belongsToMany(EventUser::class);
    }
}

