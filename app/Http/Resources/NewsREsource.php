<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class NewsREsource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'author_id' => $this->author_id,
            'hidden' => $this->hidden,
            'title' => $this->title,
            'content' => $this->content,
            'info' => $this->info, 
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'published_date' => $this->created_at->format('l, d-m-Y'),
            'published_at' => $this->created_at->diffForHumans(),

            'image' => $this->image ? Storage::disk('public')->url($this->image) : null,
        ];
    }
}
