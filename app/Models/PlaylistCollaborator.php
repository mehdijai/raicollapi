<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistCollaborator extends Model
{
    use HasFactory, HasUuids;

    protected $table = "playlist_collaborator";

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function playlist()
    {
        return $this->belongsTo(Playlist::class, 'playlist_id', 'id');
    }
}
