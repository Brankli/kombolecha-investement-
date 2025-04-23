<?php

namespace Database\Seeders;
use App\Models\Content;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()
            ->has('admin')
            ->first();
            
        Content::create([
            'about'=>'about', 
            'email'=>'kchainvestments@gmail.com', 
            'amharicname'=>'kocha',
            'adress'=>'Wollo-Kombolcha, Ethiopia',
            'phone_no'=>'+011352111','mission'=>'mission',
            'vission'=>'vission','name'=>'Kombolcha Industry And Investment Office',
            'logo'=>'defaultassets/image/logo.png',
            'author_id' => $user->id,
        ]);
    }
}
