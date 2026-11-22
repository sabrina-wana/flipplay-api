<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    // GET /api/media atau /api/media?search=attack
    public function index(Request $request)
    {
        $media = Media::with('users')
            ->search($request->query('search'))
            ->paginate(10);

        return MediaResource::collection($media);
    }

    // POST /api/media
    public function store(StoreMediaRequest $request)
    {
        $media = Media::create($request->validated());

        return (new MediaResource($media))->response()->setStatusCode(201);
    }

    // GET /api/media/{media}
    public function show(Media $media)
    {
        return new MediaResource($media->load('users'));
    }

    // PATCH /api/media/{media}
    public function update(StoreMediaRequest $request, Media $media)
    {
        $media->update($request->validated());

        return new MediaResource($media->load('users'));
    }

    // DELETE /api/media/{media}
    public function destroy(Media $media)
    {
        $media->delete();

        return response()->json(['message' => 'Media berhasil dihapus']);
    }
}
