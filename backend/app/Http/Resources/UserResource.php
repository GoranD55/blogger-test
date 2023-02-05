<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'firstName' => $this->resource->first_name,
            'lastName' => $this->resource->last_name,
            'email' => $this->resource->email,
            'role' => $this->resource->role,
            'avatar' => $this->resource->avatar,
            'blog' => new BlogResource($this->whenLoaded('blogs')),
        ];
    }
}
