<?php

namespace App\Http\Controllers;

use App\Http\Requests\Albums\CreateAlbumRequest;
use App\Http\Requests\Albums\UpdateAlbumRequest;
use App\Models\Album;
use App\Services\FileManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    function index()
    {
        $data = Cache::remember('albums_list', now()->addHours(env("CACHE_THRESHOLD")), function () {
            return Album::with("artist")->withCount("likes", "tracks")->validated()->get();
        });

        return response()->json($data);
    }
    function view(string $id)
    {
        $data = Cache::remember('album_' . $id, now()->addHours(env("CACHE_THRESHOLD")), function () use ($id) {
            $album = Album::validated()->with("tracks", "artist")->find($id);

            if (!$album) abort(404, "Album not found");

            return $album;
        });

        return response()->json($data);
    }
    function create(CreateAlbumRequest $request)
    {
        Cache::forget("albums_list");
        $validated = $request->validated();

        $cover_path = null;

        if ($validated->cover) {
            $cover_path = FileManager::upload($validated->cover, "album-covers", null, File::extension($validated->cover));
        }

        $album = Album::create([
            "creator_id" => Auth::user()->id,
            "artist_id" => $validated->artist_id,
            "name" => $validated->name,
            "type" => $validated->type,
            "year" => $validated->year,
            "cover" => $cover_path,
        ]);

        return response()->json($album);
    }
    function update(string $id, UpdateAlbumRequest $request)
    {
        Cache::forget("albums_list");
        Cache::forget("album_" . $id);

        $validated = $request->validated();

        $album = Album::find($id);

        $cover_path = null;

        if ($validated->cover) {
            FileManager::remove(storage_path($album->cover));
            $cover_path = FileManager::upload($validated->cover, "album-covers", null, File::extension($validated->cover));
        }

        $album->artist_id = $validated->artist_id;
        $album->name = $validated->name;
        $album->type = $validated->type;
        $album->year = $validated->year;

        if ($validated->cover !== null) {
            $album->cover = $cover_path;
        }

        $album->save();

        return response()->json($album);
    }
    function delete(string $id)
    {
        Cache::forget("albums_list");
        Cache::forget("album_" . $id);

        $album = Album::find($id)->delete();

        return response()->json($album);
    }
}
