<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Artist;
use App\Models\ArtistSong;
use App\Models\Request as ModelRequest;
use Illuminate\Http\Request as HttpRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modelRequests = ModelRequest::with(['users', 'artist_song.songs', 'artist_song.artists'])->orderByDesc('created_at')->get();

        // Fetch all songs with artist names
        $titles = Song::join('artist_song', 'songs.id', '=', 'artist_song.song_id')
            ->join('artists', 'artists.id', '=', 'artist_song.artist_id')
            ->select('artist_song.id', DB::raw("CONCAT(artists.name, ' - ', songs.name) as name"))
            ->get();

        // Return the data to the Inertia view
        return Inertia::render('RequestVueFile', [
            'requests' => $modelRequests,
            'titles' => $titles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HttpRequest $request)
    {
        $validated = $request->validate([
            'comment' => 'nullable|string', // Corrected 'null' to 'nullable'
            'artist_song_id' => 'required|integer',
        ]);

        $requestItem = ModelRequest::create($validated);

        return response()->json($requestItem, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HttpRequest $request, string $id)
    {
        $validatedData = $request->validate([
            'comment' => 'nullable|string',
            'artist_song_id' => 'required|integer',
        ]);

        $requestItem = ModelRequest::findOrFail($id);
        $requestItem->comment = $validatedData['comment'];
        $requestItem->artist_song_id = $validatedData['artist_song_id'];
        $requestItem->save();

        return response()->json($requestItem);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $requestItem = ModelRequest::findOrFail($id);
        $requestItem->delete();

        return response()->json(['message' => 'Request deleted successfully']);
    }
}