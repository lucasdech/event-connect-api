<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Message",
 *     type="object",
 *     title="Message",
 *     description="Message Model",
 *     required={"content", "user_id", "event_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="content", type="string", example="Message content here"),
 *     @OA\Property(property="event_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-09-09T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-09-09T12:00:00Z"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", example="2024-09-09T12:00:00Z")
 * )
 */
class Message extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'content',
        'event_id',
    ];

    protected $date = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
