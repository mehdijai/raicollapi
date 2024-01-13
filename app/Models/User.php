<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'username',
        'picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id', 'id');
    }

    function followings()
    {
        return $this->hasMany(Follower::class, 'user_id', 'id');
    }

    public function artists(): HasMany
    {
        return $this->hasMany(Artist::class, 'creator_id', 'id');
    }

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class, 'creator_id', 'id');
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class, 'creator_id', 'id');
    }

    public function playlists(): HasMany
    {
        return $this->hasMany(Playlist::class, 'creator_id', 'id');
    }

    public function playlistCollaborations()
    {
        return $this->hasMany(PlaylistCollaborator::class, 'role_user_table', 'user_id', 'role_id');
    }

    public function validations(): HasMany
    {
        return $this->hasMany(Validation::class, 'user_id', 'id');
    }
}
