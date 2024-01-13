<?php

namespace App\Models;

use App\Traits\ValidatedTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory, HasUuids, ValidatedTrait;

    protected $fillable = [
        "creator_id",
        "album_id",
        "filePath",
        "title",
        "year",
        "trackNb",
        "genres",
        "cover",
        "mimetype",
    ];

    protected $hidden = ['pivot', "creator_id", "filePath", "mimetype"];

    function artists()
    {
        return $this->belongsToMany(Artist::class, 'artist_track', "track_id", "artist_id");
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }

    public function validations()
    {
        return $this->hasMany(Validation::class, "validateable_id", "id")->where('validateable_type', 'TrackValidation');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, "likeable_id", "id")->where('likeable_type', 'TrackLike');
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_track', 'track_id', 'playlist_id');
    }

    function histories()
    {
        return $this->belongsToMany(History::class, 'histories', "historyable_id", "id")->where('historyable_type', 'TrackHistory');
    }
}
