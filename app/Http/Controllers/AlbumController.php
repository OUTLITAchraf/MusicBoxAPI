<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $albums = Album::all();

        return response()->json([
            'albums' => $albums,
            'message' => 'Albums Fetched Successfully'
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
            'genre' => 'required|string',
            'release_date' => 'required|date',
            'artist_id' => 'required|exists:artists,id',
        ]);

        $album = Album::create($validated);

        return response()->json([
            'album' => $album,
            'message' => 'Album Created Successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $album = Album::findOrFail($id);
        $album->load('artist','songs');

        return response()->json([
            'album' => $album,
            'message' => 'Album Fetched Successfully',
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'genre' => 'required|string',
            'release_date' => 'required|date',
            'artist_id' => 'required|exists:artists,id',
        ]);

        $album = Album::findOrFail($id);
        $album->update($validated);

        return response()->json([
            'album' => $album,
            'message' => 'Album Updated Successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        $album->delete();

        return response()->json([
            'message' => 'Album Deleted Successfully'
        ], 200);
    }
}
