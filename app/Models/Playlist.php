<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Playlist extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "creator_id",
        "name",
        "cover",
        "public",
        "description",
    ];

    protected $hidden = [
        "creator_id",
        "public"
    ];

    protected $casts = [
        'public' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'playlist_track', 'playlist_id', 'track_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, "likeable_id", "id")->where('likeable_type', 'PlaylistLike');
    }

    public function collaborators()
    {
        return $this->hasMany(PlaylistCollaborator::class, 'playlist_id', 'id');
    }

    function histories()
    {
        return $this->belongsToMany(History::class, 'historyable_id')->where('historyable_type', 'PlaylistHistory');
    }
}
