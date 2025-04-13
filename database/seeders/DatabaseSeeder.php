<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\UserSeeder;
use Database\Seeders\BannerSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\TestimonailSeeder;
use Database\Seeders\WebContentSeeder;
use Database\Seeders\ContentSeeder;




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
            UserSeeder::class,
            DepartmentSeeder::class,    
            ServiceSeeder::class,
            ContentSeeder::class,
            BannerSeeder::class,
            TestimonailSeeder::class,
            WebContentSeeder::class,
        ]);
    }
}
