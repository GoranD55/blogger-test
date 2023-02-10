<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'text' => $this->resource->text,
            'author' => $this->whenLoaded('author'),
            'categoriesIds' => $this->resource->categories_ids,
            'createdAt' => $this->resource->created_at,
            //todo: add images from morph relation
        ];
    }
}
