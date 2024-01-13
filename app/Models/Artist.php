<?php

namespace App\Models;

use App\Traits\ValidatedTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Artist extends Model
{
    use HasFactory, HasUuids, ValidatedTrait;

    protected $fillable = [
        "creator_id",
        "name",
        "picture",
        "biography",
    ];

    protected $hidden = ['pivot', 'creator_id'];

    function tracks()
    {
        return $this->belongsToMany(Track::class, 'artist_track', "artist_id", "track_id");
    }

    function albums()
    {
        return $this->hasMany(Album::class, 'artist_id', 'id');
    }

    function followers()
    {
        return $this->hasMany(Follower::class, 'artist_id', 'id');
    }

    function validations()
    {
        return $this->hasMany(Validation::class, "validateable_id", "id")->where('validateable_type', 'ArtistValidation');
    }

    function histories()
    {
        return $this->belongsToMany(History::class, 'historyable_id')->where('historyable_type', 'ArtistHistory');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }
}
