<?php

namespace Database\Seeders;

use App\Models\WebContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WebContent::create(['about'=>'about', 'amharicname'=>'ኮምቦልቻ ኢንዱስትሪ እና ኢንቨስትመንት', 'email'=>'kchainvestments@gmail.com', 'adress'=>'Wollo-Kombolcha, Ethiopia','phone_no'=>'+011352111','mission'=>'mission','vission'=>'vission','name'=>'Kombolcha Industry And Investment Office','logo'=>'defaultassets/image/logo.png','goal'=>'goal','author_id'=>'1' ]);
    }
}
