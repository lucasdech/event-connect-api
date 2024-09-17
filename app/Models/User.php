<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     description="User model",
 *     required={"name", "email", "password", "role"},
 *     @OA\Property(property="id", type="integer", example=1, description="ID of the user"),
 *     @OA\Property(property="name", type="string", example="John Doe", description="Name of the user"),
 *     @OA\Property(property="email", type="string", example="johndoe@example.com", description="Email of the user"),
 *     @OA\Property(property="profile_picture", type="string", example="/path/to/profile.jpg", description="Profile picture URL"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-09-09T13:39:44.000000Z", description="User creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-09-09T13:39:44.000000Z", description="User update timestamp"),
 * )
 */

class User extends Authenticatable implements JWTSubject, FilamentUser, MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'profile_picture',
        'email',
        'password',
        'role',
        'deleted_at',
    ];

    protected $date = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function eventList()
    {
        return $this->hasMany(Event::class);
    }

    public function message()
    {
        return $this->hasMany(Message::class);
    }

    public function eventUser()
    {
        return $this->belongsToMany(EventUser::class);
    }

    // Code to use Filament in prod

    public function canAccessPanelPROD(Panel $panel): bool
    {
        return str_ends_with($this->email, 'lucasdechavanne22@gmail.com');
    }

    /**
     * Determine if the user can access the Filament panel.
     *
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin';
    }

    // FOR JWT
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
