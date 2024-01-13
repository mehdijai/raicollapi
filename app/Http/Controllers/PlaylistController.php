<?php

namespace App\Http\Controllers;

use App\Http\Requests\Playlists\CreatePlaylistRequest;
use App\Http\Requests\Playlists\UpdatePlaylistRequest;
use App\Models\Playlist;
use App\Services\FileManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class PlaylistController extends Controller
{
    function index()
    {
        $data = Cache::remember('playlists_list', now()->addHours(env("CACHE_THRESHOLD")), function () {
            return Playlist::where("public", true)->withCount("likes", "tracks")->with(["creator" => function($query) {
                $query->select("id", "name", "username", "picture");
            }, "collaborators"])->get();
        });

        return response()->json($data);
    }
    function myPlaylists()
    {
        $data = Cache::remember('user_playlists_list_' . Auth::user()->id, now()->addHours(env("CACHE_THRESHOLD")), function () {
            return Playlist::where("creator_id", Auth::user()->id)->whereHas('collaborators', function ($subQuery) {
                $subQuery->where('creator_id', Auth::user()->id);
            })->get();
        });

        return response()->json($data, 200);
    }
    function view(string $id)
    {
        $data = Cache::remember('playlist_' . $id, now()->addHours(env("CACHE_THRESHOLD")), function () use ($id) {
            $playlist = Playlist::where("creator_id", Auth::user()->id)->whereHas('collaborators', function ($subQuery) {
                $subQuery->where('creator_id', Auth::user()->id);
            })->find($id);
            if(!$playlist) abort(404, "Playlist not found");
            return $playlist;
        });

        return response()->json($data, 200);
    }
    function create(CreatePlaylistRequest $request)
    {
        $validated = $request->validated();

        Cache::forget('user_playlists_list_' . Auth::user()->id);
        Cache::forget("playlists_list");

        $cover_path = null;

        if ($validated->cover) {
            $cover_path = FileManager::upload($validated->cover, "playlists-covers", null, File::extension($validated->cover));
        }

        $playlist = Playlist::create([
            "creator_id" => Auth::user()->id,
            "name" => $validated->name,
            "public" => $validated->public,
            "description" => $validated->description ?? "",
            "cover" => $cover_path,
        ]);

        if ($validated->collaborators) {
            $playlist->collaborators()->attach($validated->collaborators);
        }

        if ($validated->trackId) {
            $playlist->tracks()->attach([$validated->trackId]);
        }

        return response()->json($playlist, 200);
    }
    function update(string $id, UpdatePlaylistRequest $request)
    {
        $validated = $request->validated();

        Cache::forget('user_playlists_list_' . Auth::user()->id);
        Cache::forget("playlists_list");
        Cache::forget("playlist_" . $id);

        $playlist = Playlist::find($id);

        $cover_path = null;

        if ($validated->cover) {
            FileManager::remove(storage_path($playlist->cover));
            $cover_path = FileManager::upload($validated->cover, "playlists-covers", null, File::extension($validated->cover));
        }

        $playlist->name = $validated->name;
        $playlist->public = $validated->public;
        $playlist->description = $validated->description;

        if ($validated->cover !== null) {
            $playlist->cover = $cover_path;
        }

        $playlist->save();

        return response()->json($playlist, 200);
    }
    function delete(string $id)
    {
        Cache::forget('user_playlists_list_' . Auth::user()->id);
        Cache::forget("playlists_list");
        Cache::forget("playlist_" . $id);

        $playlist = Playlist::find($id)->delete();

        return response()->json($playlist, 200);
    }
}
