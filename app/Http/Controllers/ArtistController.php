<?php

namespace App\Http\Controllers;

use App\Http\Requests\Artists\CreateArtistRequest;
use App\Http\Requests\Artists\UpdateArtistRequest;
use App\Models\Artist;
use App\Services\FileManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtistController extends Controller
{
    function index()
    {
        $data = Cache::remember('artists_list', now()->addHours(env("CACHE_THRESHOLD")), function () {
            return Artist::validated()->withCount("tracks", "albums", "followers")->get();
        });

        return response()->json($data);
    }

    function view(string $id)
    {
        $artist = Cache::remember('artist_' . $id, now()->addHours(env("CACHE_THRESHOLD")), function () use ($id) {
            $artist = Artist::validated()->with("tracks", "albums")->withCount("followers")->find($id);
            if (!$artist) abort(404, "Artist not found");
            return $artist;
        });

        return response()->json($artist);
    }

    function create(CreateArtistRequest $request)
    {
        Cache::forget('artists_list');
        $validated = $request->validated();

        $picture = null;

        if ($validated->picture) {
            $picture = FileManager::upload($validated->picture, "artists_covers", null, File::extension($validated->picture));
        }

        $artist = Artist::create([
            "creator_id" => Auth::user()->id,
            'name' => $validated->name,
            'biography' => $validated->biography,
            'picture' => $picture
        ]);

        return response()->json($artist);
    }
    function update(string $id, UpdateArtistRequest $request)
    {
        Cache::forget('artists_list');
        Cache::forget('artist_' . $id);
        $artist = Artist::findOrFail($id);

        $validated = $request->validated();

        $picture = null;

        if ($validated->picture) {
            FileManager::remove($artist->picture);
            $picture = FileManager::upload($validated->picture, "artists_covers", null, File::extension($validated->picture));
        }

        $artist->name = $validated->name;
        $artist->biography = $validated->biography;
        if ($validated->picture) {
            $artist->picture = $picture;
        }
        $artist->save();

        return $artist;

        return response()->json($artist);
    }
    function delete(string $id)
    {
        Cache::forget('artists_list');
        Cache::forget('artist_' . $id);
        $artist =  Artist::find($id)->delete();

        return response()->json($artist);
    }
}
