<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Artists",
 *     description="API Endpoints for Artists"
 * )
 */
class ArtistController extends Controller
{
    /**
     * @OA\Get(
     *     path="/artists",
     *     tags={"Artists"},
     *     summary="Get list of artists",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="genre",
     *         in="query",
     *         description="Filter artists by genre",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="artists",
     *                 type="object",
     *                 @OA\Property(property="data", type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Artist Name"),
     *                         @OA\Property(property="genre", type="string", example="Rock"),
     *                         @OA\Property(property="country", type="string", example="USA")
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="Artists Fetched Successfully")
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/create-artist",
     *     tags={"Artists"},
     *     summary="Create a new artist",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","genre","country"},
     *             @OA\Property(property="name", type="string", example="New Artist"),
     *             @OA\Property(property="genre", type="string", example="Rock"),
     *             @OA\Property(property="country", type="string", example="France")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Artist created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="artist", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="New Artist"),
     *                 @OA\Property(property="genre", type="string", example="Rock"),
     *                 @OA\Property(property="country", type="string", example="France")
     *             ),
     *             @OA\Property(property="message", type="string", example="Artist Created Successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
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
     * @OA\Get(
     *     path="/artist/{id}",
     *     tags={"Artists"},
     *     summary="Get artist by ID with their albums and songs",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Artist ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="artist", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Artist Name"),
     *                 @OA\Property(property="genre", type="string", example="Rock"),
     *                 @OA\Property(property="country", type="string", example="USA"),
     *                 @OA\Property(
     *                     property="albums",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Album Title"),
     *                         @OA\Property(
     *                             property="songs",
     *                             type="array",
     *                             @OA\Items(
     *                                 type="object",
     *                                 @OA\Property(property="id", type="integer", example=1),
     *                                 @OA\Property(property="title", type="string", example="Song Title")
     *                             )
     *                         )
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="Artist Fetched Successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Artist not found"
     *     )
     * )
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
     * @OA\Put(
     *     path="/update-artist/{id}",
     *     tags={"Artists"},
     *     summary="Update existing artist",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Artist ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","genre","country"},
     *             @OA\Property(property="name", type="string", example="Updated Artist Name"),
     *             @OA\Property(property="genre", type="string", example="Jazz"),
     *             @OA\Property(property="country", type="string", example="France")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Artist updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="artist", type="object"),
     *             @OA\Property(property="message", type="string", example="Artist Updated Successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Artist not found"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/delete-artist/{id}",
     *     tags={"Artists"},
     *     summary="Delete an artist",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Artist ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Artist deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Artist Deleted Successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Artist not found"
     *     )
     * )
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
