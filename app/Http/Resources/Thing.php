<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Thing
 * @package App\Http\Resources
 * @property-read \App\Models\Thing $resource
 */
class Thing extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => base64_encode($this->resource->id), // fake string id
            'owner' => $this->whenLoaded('user', function () {
                return new Owner($this->resource->user);
            }),
            'title' => $this->resource->title,
            'created_at' => $this->resource->created_at->format('M d Y'),
        ];
    }
}
