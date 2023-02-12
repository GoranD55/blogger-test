<?php

namespace App\Http\Resources;

use App\Models\Blog;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property-read Blog $resource */
class BlogResource extends JsonResource
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
            'userId' => $this->resource->user_id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'isPublic' => $this->resource->is_public,
            'author' => new UserResource($this->whenLoaded('author')),
            'createdAt' => $this->resource->created_at,
            'updatedAt' => $this->resource->updated_at,
            'isDeleted' => $this->resource->deleted_at !== null,
        ];
    }
}
