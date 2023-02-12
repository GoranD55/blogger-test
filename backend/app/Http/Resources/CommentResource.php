<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property-read Comment $resource */
class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'text' => $this->resource->text,
            'createAt' => $this->resource->created_at,
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'user' =>  new UserResource($this->whenLoaded('user')),
        ];
    }
}
