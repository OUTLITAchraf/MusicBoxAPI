<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Songs",
 *     description="API Endpoints for Songs"
 * )
 */
class SongController extends Controller
{
    /**
     * @OA\Get(
     *     path="/songs",
     *     tags={"Songs"},
     *     summary="Get list of songs",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="songs",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Song Title"),
     *                     @OA\Property(property="duration", type="integer", example=180),
     *                     @OA\Property(property="album_id", type="integer", example=1)
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="Songs Fetched Successfully")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $songs = Song::all();

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
     * @OA\Post(
     *     path="/songs",
     *     tags={"Songs"},
     *     summary="Create a new song",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","duration","album_id"},
     *             @OA\Property(property="title", type="string", example="New Song"),
     *             @OA\Property(property="duration", type="integer", example=180),
     *             @OA\Property(property="album_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Song created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="song", type="object"),
     *             @OA\Property(property="message", type="string", example="Song Created Successfully")
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
     * @OA\Get(
     *     path="/songs/{id}",
     *     tags={"Songs"},
     *     summary="Get song by ID with album and artist",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Song ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="song",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Song Title"),
     *                 @OA\Property(property="duration", type="integer", example=180),
     *                 @OA\Property(
     *                     property="album",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Album Title"),
     *                     @OA\Property(
     *                         property="artist",
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Artist Name")
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="Song Fetched Successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Song not found"
     *     )
     * )
     */
    public function show($id)
    {
        $song = Song::findOrFail($id);
        $song->load('album.artist');

        return response()->json([
            'song' => $song,
            'message' => 'Song Fetched Successfully'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/songs/{id}",
     *     tags={"Songs"},
     *     summary="Update existing song",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Song ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Song Title"),
     *             @OA\Property(property="duration", type="integer", example=200),
     *             @OA\Property(property="album_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Song updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="song", type="object"),
     *             @OA\Property(property="message", type="string", example="Song Updated Successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Song not found"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/songs/{id}",
     *     tags={"Songs"},
     *     summary="Delete a song",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Song ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Song deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Song Deleted Successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Song not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $song = Song::findOrFail($id);
        $song->delete();

        return response()->json([
            'message' => 'Song Deleted Successfully'
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/songs/search",
     *     tags={"Songs"},
     *     summary="Search songs by title or artist",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Search by song title",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="artist",
     *         in="query",
     *         description="Search by artist name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Song Title"),
     *                     @OA\Property(property="duration", type="integer", example=180)
     *                 )
     *             ),
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="per_page", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No songs found"
     *     )
     * )
     */
    public function search(Request $request)
    {
            $query = Song::with('album.artist');

        if ($request->has('title')) {
            $query->where('title', 'LIKE', '%' . $request->title . '%');
            }

        if ($request->has('artist')) {
            $query->whereHas('album.artist', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->artist . '%');
                });
            }

        $songs = $query->paginate(10);

            if ($songs->isEmpty()) {
                return response()->json([
                'message'=>'No Data Found Match Your Search'
                ], 404);
            }

        return response()->json($songs);
    }
}
