<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Artist::query();

        // Filter by genre if provided
        if ($request->has('genre')) {
            $query->where('genre', $request->genre);
        }

        // Add pagination (10 artists per page)
        $artists = $query->paginate(10);

        return response()->json([
            'artists' => $artists,
            'message' => 'Artists Fetched Successfully'
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
            'name' => 'required|string',
            'genre' => 'required|string',
            'country' => 'required|string',
        ]);

        $artist = Artist::create($validated);
        return response()->json([
            'artist' => $artist,
            'message' => 'Artist Created Successfully'
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->load('albums.songs');

        return response()->json([
            'artist' => $artist,
            'message' => 'Arist Fetched Successfully'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artist $artist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'name' => 'required|string',
            'genre' => 'required|string',
            'country' => 'required|string',
        ]);

        $artist = Artist::findOrFail($id);
        $artist->update($validated);

        return response()->json([
            'artist' => $artist,
            'message' => 'Artist Updated Successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->delete();

        return response()->json([
            'message' => 'Artist Deleted Successfully'
        ], 200);
    }
}
