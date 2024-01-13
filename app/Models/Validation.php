<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "type",
        "description",
        "status",
        "validator_id",
        "validateable_id",
        "validateable_type",
        "validated_at"
    ];

    protected $casts = [
        'validated_at' => 'datetime',
    ];

    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_id', 'id');
    }

    public function artist()
    {
        return $this->hasOne(Artist::class, 'validateable_id')->where('validateable_type', 'ArtistValidation');
    }
    public function track()
    {
        return $this->hasOne(Track::class, 'validateable_id', "id")->where('validateable_type', 'TrackValidation');
    }
    public function album()
    {
        return $this->hasOne(Album::class, 'validateable_id')->where('validateable_type', 'AlbumValidation');
    }

    function histories()
    {
        return $this->belongsToMany(History::class, 'historyable_id')->where('historyable_type', 'ValidationHistory');
    }
}
