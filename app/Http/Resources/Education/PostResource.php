<?php

namespace App\Http\Resources\Education;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'video_url' => $this->video_url,
            'description' => $this->description,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'created_at' => $this->created_at->format('d M Y'),
        ];
    }
}
