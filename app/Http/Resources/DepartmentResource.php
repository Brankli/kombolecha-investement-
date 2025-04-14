<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DepartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_no' => $this->phone_no,
            'mission' => $this->mission,
            'vision' => $this->vission,
            'goal' => $this->goal,
            'position' => $this->position,

            'profile' => $this->profile ? Storage::disk('public')->url($this->profile) : null,
        ];
    }
}
