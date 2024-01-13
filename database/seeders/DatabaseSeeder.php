<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Follower;
use App\Models\Like;
use App\Models\Playlist;
use App\Models\Privilege;
use App\Models\Role;
use App\Models\Track;
use App\Models\User;
use App\Models\Validation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::factory()->admin()->create();
        $validatorRole = Role::factory()->validator()->create();
        $userRole = Role::factory()->user()->create();

        User::factory()->state([
            "role_id" => $adminRole->id
        ])->create();

        $validator = User::factory()->state([
            "role_id" => $validatorRole->id
        ])->create();

        Privilege::factory()->manage_users()->state([
            "role_id" => $adminRole->id
        ])->create();

        Privilege::factory()->validate()->state([
            "role_id" => $validatorRole->id
        ])->create();

        Privilege::factory()->create_entity()->state([
            "role_id" => $userRole->id
        ])->create();

        Privilege::factory()->listen()->state([
            "role_id" => $userRole->id
        ])->create();

        $user = User::factory()->state([
            "role_id" => $userRole->id
        ])->create();

        $this->handleMedia($user->id, $validator->id);
    }

    function handleMedia(string $userId, string $validatorId)
    {
        $artist = Artist::factory()->state([
            'creator_id' => $userId
        ])->create();

        Validation::factory()->artist()->state([
            'validator_id' => $validatorId,
            'validateable_id' => $artist->id
        ])->create();

        Follower::factory()->state([
            'user_id' => $userId,
            'artist_id' => $artist->id
        ])->create();

        $album = Album::factory()->state([
            'creator_id' => $userId,
            'artist_id' => $artist->id,
        ])->create();

        Validation::factory()->album()->state([
            'validator_id' => $validatorId,
            'validateable_id' => $album->id
        ])->create();

        Like::factory()->album()->state([
            "likeable_id" => $album->id,
            "user_id" => $userId
        ])->create();

        $playlist = Playlist::factory()->state([
            'creator_id' => $userId
        ])->create();

        Like::factory()->playlist()->state([
            "likeable_id" => $playlist->id,
            "user_id" => $userId
        ])->create();

        for ($i = 0; $i < 5; $i++) {
            $this->generateTracks($userId, $validatorId, $album->id, $artist->id, $playlist->id);
        }
    }

    function generateTracks(string $user, string $validator, string $album, string $artist, string $playlist)
    {
        $track = Track::factory()->state([
            'creator_id' => $user,
            'album_id' => $album,
        ])->create();

        $track->artists()->attach([$artist]);

        Validation::factory()->track()->state([
            'validator_id' => $validator,
            'validateable_id' => $track->id
        ])->create();

        Like::factory()->track()->state([
            "likeable_id" => $track->id,
            "user_id" => $user
        ])->create();

        $track->playlists()->attach($playlist);
    }
}
