<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
