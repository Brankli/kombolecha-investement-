<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role\Director;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\Traits\UserSeeder;
use Database\Seeders\BannerSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\TestimonailSeeder;
use Database\Seeders\WebContentSeeder;
use Database\Seeders\ContentSeeder;


use Database\Seeders\Role\AdminSeeder;
use Database\Seeders\Role\DirectorSeeder;
use Database\Seeders\Role\ExpansionSeeder;
use Database\Seeders\Role\ourStaffSeeder;
use Database\Seeders\Role\DevelopmentSeeder;
use Database\Seeders\Role\miniralSeeder;





class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            DevelopmentSeeder::class,
            ourStaffSeeder::class,
            miniralSeeder::class,
            ExpansionSeeder::class,
            AdminSeeder::class,
            DirectorSeeder::class,
            
            DepartmentSeeder::class,    
            ServiceSeeder::class,
            ContentSeeder::class,
            BannerSeeder::class,
            TestimonailSeeder::class,
            WebContentSeeder::class,
        ]);
    }
}
