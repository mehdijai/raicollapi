<?php

namespace App\Models;

use App\Traits\ValidatedTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory, HasUuids, ValidatedTrait;

    protected $fillable = [
        "creator_id",
        "artist_id",
        "name",
        "type",
        "year",
        "cover",
    ];

    protected $hidden = [
        "creator_id"
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id', 'id');
    }

    public function tracks()
    {
        return $this->hasMany(Track::class, 'album_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, "likeable_id", "id")->where('likeable_type', 'AlbumLike');
    }

    function validations()
    {
        return $this->hasMany(Validation::class, "validateable_id", "id")->where('validateable_type', 'AlbumValidation');
    }

    function histories()
    {
        return $this->belongsToMany(History::class, 'historyable_id')->where('historyable_type', 'AlbumHistory');
    }
}
