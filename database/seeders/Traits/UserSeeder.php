<?php

namespace Database\Seeders\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait UserSeeder{

    public function createUser($info, $createdBy) {
        $user = new User();
        $user->name = $info['name'];
        $user->email = $info['email'];
        $user->password = Hash::make('Degan@123456');
        $user->phone_no = $info['phone_no'];
        $user->position = $info['position'];
        $user->email_verified_at = date("Y-m-d H:i:s");

        $user->save();

        return $user;
    }
}