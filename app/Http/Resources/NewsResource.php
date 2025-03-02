<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'title' => $this->title,
            'content' => $this->content,
            'author' => $this->author,
            'category' => $this->category,
            'source' => $this->source,
            'url'=>$this->url,
            'image_url'=>$this->image_url,
            'published_at' => $this->published_at,
        ];
    }
}
