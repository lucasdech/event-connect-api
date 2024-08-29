<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

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

    public function event(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function message(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(participant::class);
    }

    // Code to use Filament in prod
    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, 'https://eventconnectapi.projets.p8.garage404.com/') && $this->hasVerifiedEmail();
    }
}
