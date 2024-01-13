<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory, HasUuids;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function artist()
    {
        return $this->hasOne(Artist::class, 'historyable_id')->where('historyable_type', 'ArtistHistory');
    }
    public function track()
    {
        return $this->hasOne(Track::class, 'historyable_id')->where('historyable_type', 'TrackHistory');
    }
    public function album()
    {
        return $this->hasOne(Album::class, 'historyable_id')->where('historyable_type', 'AlbumHistory');
    }

    public function playlist()
    {
        return $this->hasOne(Playlist::class, 'historyable_id')->where('historyable_type', 'PlaylistHistory');
    }

    public function validation()
    {
        return $this->hasOne(Validation::class, 'historyable_id')->where('historyable_type', 'ValidationHistory');
    }
}
