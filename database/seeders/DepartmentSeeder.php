<?php

namespace Database\Seeders;

use App\Models\DepartmentContent;
use App\Models\User;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()
            ->has('admin')
            ->first();
        DepartmentContent::create([ 
            'author_id' => $user->id,
            'mission'=>'mission',
            'vission'=>'vission',
            'goal'=>'goal' 
        ]);

    }  
}



