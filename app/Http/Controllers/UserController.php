<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCollectionRequest;
use App\Http\Resources\MediaResource;
use App\Http\Resources\UserResource;
use App\Models\Media;
use App\Models\User;

class UserController extends Controller
{
    // GET /api/users
    public function index()
    {
        return UserResource::collection(User::paginate(10));
    }

    // GET /api/users/{user}  -> data user beserta koleksinya
    public function show(User $user)
    {
        return new UserResource($user->load('media'));
    }

    // GET /api/users/{user}/collection  -> hanya daftar media di koleksi
    public function collection(User $user)
    {
        return MediaResource::collection($user->media()->paginate(10));
    }

    // POST /api/users/{user}/collection   body: { "media_id": 1 }
    public function addToCollection(AddToCollectionRequest $request, User $user)
    {
        $mediaId = $request->validated('media_id');

        // Cek duplikat -> 409 Conflict
        if ($user->media()->where('media.id', $mediaId)->exists()) {
            return response()->json(['message' => 'Media sudah ada di koleksi'], 409);
        }

        $user->media()->attach($mediaId);

        return (new UserResource($user->load('media')))
            ->additional(['message' => 'Media berhasil ditambahkan ke koleksi'])
            ->response()
            ->setStatusCode(201);
    }

    // DELETE /api/users/{user}/collection/{media}
    public function removeFromCollection(User $user, Media $media)
    {
        if (!$user->media()->where('media.id', $media->id)->exists()) {
            return response()->json(['message' => 'Media tidak ada di koleksi pengguna'], 404);
        }

        $user->media()->detach($media->id);

        return response()->json(['message' => 'Media berhasil dihapus dari koleksi']);
    }
}
