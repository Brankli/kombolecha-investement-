<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PortfolioResource extends JsonResource
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
            'title' => $this->title, 
            'category' => $this->category, 
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'image' => $this->image ? Storage::disk('public')->url($this->image) : null,
        ];
    }
}
