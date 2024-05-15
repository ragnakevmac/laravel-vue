<?php

namespace App\Http\Controllers;

use App\Models\Request as ModelRequest;
use Illuminate\Http\Request as HttpRequest;
use Inertia\Inertia;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modelRequests = ModelRequest::with(['users', 'artist_song.songs'])->get();
        return Inertia::render('RequestVueFile', ['requests' => $modelRequests]);
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
    public function store(HttpRequest $apiRequest)
    {
        // $modelRequest = new ModelRequest;
        // $modelRequest->comment = $apiRequest->comment;
        // $modelRequest->save();

        // return response()->json(['message' => 'Comment created successfully!', 'data' => $modelRequest], 201);


        $apiRequest->validate([
            'comment' => 'required',
        ]);

        ModelRequest::create($apiRequest->all());

        // Redirect using Inertia's response to prevent a full page reload
        return redirect()->back()->with('success', 'Comment posted.');
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
    public function update(HttpRequest $apiRequest, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = ModelRequest::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted.');
    }
}
