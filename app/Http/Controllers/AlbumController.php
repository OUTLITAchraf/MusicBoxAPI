<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Albums",
 *     description="API Endpoints for Albums"
 * )
 */
class AlbumController extends Controller
{
    /**
     * @OA\Get(
     *     path="/albums",
     *     tags={"Albums"},
     *     summary="Get list of albums",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="albums",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Album Title"),
     *                     @OA\Property(property="genre", type="string", example="Rock"),
     *                     @OA\Property(property="release_date", type="string", format="date", example="2023-09-30"),
     *                     @OA\Property(property="artist_id", type="integer", example=1)
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="Albums Fetched Successfully")
     *         )
     *     )
     * )
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
     * @OA\Post(
     *     path="/albums",
     *     tags={"Albums"},
     *     summary="Create a new album",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","genre","release_date","artist_id"},
     *             @OA\Property(property="title", type="string", example="New Album"),
     *             @OA\Property(property="genre", type="string", example="Rock"),
     *             @OA\Property(property="release_date", type="string", format="date", example="2023-09-30"),
     *             @OA\Property(property="artist_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Album created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="album", type="object"),
     *             @OA\Property(property="message", type="string", example="Album Created Successfully")
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/albums/{id}",
     *     tags={"Albums"},
     *     summary="Get album by ID with artist and songs",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="album", type="object"),
     *             @OA\Property(property="message", type="string", example="Album Fetched Successfully")
     *         )
     *     )
     * )
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
     * @OA\Put(
     *     path="/albums/{id}",
     *     tags={"Albums"},
     *     summary="Update album",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"title","genre","release_date","artist_id"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="genre", type="string"),
     *             @OA\Property(property="release_date", type="string", format="date"),
     *             @OA\Property(property="artist_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="album", type="object"),
     *             @OA\Property(property="message", type="string", example="Album Updated Successfully")
     *         )
     *     )
     * )
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
     * @OA\Delete(
     *     path="/albums/{id}",
     *     tags={"Albums"},
     *     summary="Delete album",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Album Deleted Successfully")
     *         )
     *     )
     * )
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
