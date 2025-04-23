<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email, 
            'phone_no' => $this->phone_no,
            'role' => $this->getRole(),
            'position' => $this->position,
             
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at, 

            'image' => $this->image ? asset('storage/' . $this->image) : asset('images/no_profile.png'),
        ];
    }
    

    public function getRole() {
        /**
         * @var user 
         */
        
        $user = User::find($this->id);
        if (!$user) {
            return null;
        }

        $ourStaf = $user->ourStaf()->exists();

        if($ourStaf) {
            return 'ourStaf'; 
        }

        $admin = $user->admin()->exists();
        if($admin) {
            return 'admin';
        }

        $director = $user->director()->exists();
        if($director) {
            return 'director';
        }

        $development = $user->development()->exists();
        if($development) {
            return  'development';
        }

        $expansion = $user->expansion()->exists();
        if($expansion) {
            return 'expansion';
        }

        $miniral = $user->miniral()->exists();
        if($miniral) {
            return 'miniral';
        }

        return 'unknown';
    }
}