<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'type'       => $this->type,
            'title'      => $this->title,
            'genres'     => $this->genres,
            'year'       => $this->year,
            'score'      => $this->score,
            'unit_count' => $this->unit_count,
            'country'    => $this->country,
            'author'     => $this->author,
            'added_at'   => $this->whenPivotLoaded('media_user', fn () => $this->pivot->created_at),
            'users'      => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
