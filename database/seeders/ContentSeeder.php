<?php

namespace Database\Seeders;
use App\Models\Content;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Content::create(['about'=>'about', 'email'=>'kchainvestments@gmail.com', 'adress'=>'Wollo-Kombolcha, Ethiopia','phone_no'=>'+011352111','mission'=>'mission','vission'=>'vission','name'=>'Kombolcha Industry And Investment Office','logo'=>'defaultassets/image/logo.png','author_id'=>'1' ]);
    }
}
