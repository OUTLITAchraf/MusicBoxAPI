<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $songs = Song::with('album.artist')->get();

        return response()->json([
            'songs' => $songs,
            'message' => 'Songs Fetched Successfully'
        ], 200);
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'duration' => 'required|integer|min:1',
            'album_id' => 'required|exists:albums,id',
        ]);

        $song = Song::create($validated);

        return response()->json([
            'song' => $song,
            'message' => 'Song Created Successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Song $song)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string',
            'duration' => 'sometimes|required|integer|min:1',
            'album_id' => 'sometimes|required|exists:albums,id',
        ]);

        $song = Song::findOrFail($id);
        $song->update($validated);

        return response()->json([
            'song' => $song,
            'message' => 'Song Updated Successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $song = Song::findOrFail($id);
        $song->delete();

        return response()->json([
            'message' => 'Song Deleted Successfully'
        ], 200);
    }
}
