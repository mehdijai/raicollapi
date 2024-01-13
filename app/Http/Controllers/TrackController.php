<?php

namespace App\Http\Controllers;

use App\Events\RangeRequested;
use App\Http\Requests\Tracks\CreateTrackRequest;
use App\Http\Requests\Tracks\UpdateTrackRequest;
use App\Models\Track;
use App\Services\FileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class TrackController extends Controller
{
    function index()
    {
        $data = Cache::remember('tracks_list', now()->addHours(env("CACHE_THRESHOLD")), function () {
            return Track::with("album", "artists")->withCount("likes")->validated()->get();
        });
        return response()->json($data);
    }

    function metadata(string $id)
    {
        $track = Cache::remember('track_' . $id, now()->addHours(env("CACHE_THRESHOLD")), function () use ($id) {
            return Track::with('artists', "album")->withCount("likes")->findOrFail($id);
        });
        return response()->json($track);
    }

    function streamRange(Request $request)
    {
        $trackId = $request->header("x-track-id");


        $track = Track::with('artists', "album")->find($trackId);

        if (!$track)  abort(404, "Track not found");

        $path = Cache::remember('track_file_' . $track->id, now()->addHours(env("CACHE_THRESHOLD")), function () use ($track) {
            return Storage::path($track->filePath);
        });

        $headers = [
            'Content-Type' => $track->mimetype ?? "audio/mp3",
            'Accept-Ranges' => 'bytes',
        ];

        $range = request()->header('Range');

        if ($range) {
            $fileSize = filesize($path);
            $ranges = explode('-', substr($range, 6));

            $start = $ranges[0];
            $end = $ranges[1] ?? $fileSize - 1;

            $headers['Content-Range'] = "bytes $start-$end/$fileSize";
            $headers['Content-Length'] = $end - $start + 1;

            broadcast(new RangeRequested($start));

            return response()->json($track);
        }
    }

    function stream(Request $request)
    {
        $trackId = $request->header("x-track-id");


        $track = Track::with('artists', 'album')->find($trackId);

        if (!$track)  abort(404, "Track not found");

        $filePath = Cache::remember('track_file_' . $track->id, now()->addHours(env("CACHE_THRESHOLD")), function () use ($track) {
            return Storage::path($track->filePath);
        });


        if (!file_exists($filePath)) {
            abort(404, "Track not found");
        }

        $headers = [
            'Content-Type' => $track->mimetype ?? "audio/mp3",
            'Content-Length' => filesize($filePath),
            'Accept-Ranges' => 'bytes',
        ];

        return response()->stream(
            function () use ($filePath) {
                $stream = fopen($filePath, "rb");

                if ($stream) {
                    fpassthru($stream);
                    fclose($stream);
                }
            },
            200,
            $headers
        );
    }

    function create(CreateTrackRequest $request)
    {
        Cache::forget('tracks_list');

        $validated = $request->validated();

        $cover_path = null;

        if ($validated->cover) {
            $cover_path = FileManager::upload($validated->cover, "tracks-covers", null, File::extension($validated->cover));
        }

        $track_file_path = FileManager::upload($validated->file, "tracks");

        $track = Track::create([
            "filePath" => $track_file_path,
            "mimetype" => File::mimeType($validated->file),
            "creator_id" => Auth::user()->id,
            "album_id" => $validated->album_id,
            "title" => $validated->title,
            "year" => $validated->year,
            "trackNb" => $validated->yearNb,
            "genres" => $validated->genres,
            "cover" => $cover_path,
        ]);

        $track->artists()->attach($validated['artists']);

        return response()->json($track);
    }

    function update(string $id, UpdateTrackRequest $request)
    {
        $track = Track::findOrFail($id);
        Cache::forget('track_file_' . $id);
        Cache::forget('track' . $id);
        Cache::forget('tracks_list');

        $validated = $request->validated();


        $cover_path = null;

        if ($validated->cover) {
            FileManager::remove(storage_path($validated->cover));
            $cover_path = FileManager::upload($validated->cover, "tracks-covers", null, File::extension($validated->cover));
        }

        $track->title = $validated->title;
        $track->album_id = $$validated->album_id;
        $track->year = $$validated->year;
        $track->trackNb = $$validated->trackNb;
        $track->genres = $$validated->genres;

        if ($validated->cover !== null) {
            $track->cover = $cover_path;
        }

        $track->save();

        $track->artists()->detach();
        $track->artists()->attach($validated['artists']);

        return response()->json($track);
    }
    function delete(string $id, Request $request)
    {
        Cache::forget('tracks_list');
        Cache::forget('track_file_' . $id);
        Cache::forget('track_' . $id);
        $track = Track::find($id)->delete();

        return response()->json($track);
    }
}
