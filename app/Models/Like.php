<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "likeable_id",
        "likeable_type"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function playlist()
    {
        return $this->hasOne(Playlist::class, 'likeable_id')->where('likeable_type', 'ArtistLike');
    }

    public function track()
    {
        return $this->hasOne(Track::class, 'likeable_id')->where('likeable_type', 'TrackLike');
    }

    public function album()
    {
        return $this->hasOne(Album::class, 'likeable_id')->where('likeable_type', 'AlbumLike');
    }
}
