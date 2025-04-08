<?php

namespace Database\Seeders;

use App\Models\DepartmentContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DepartmentContent::create(['position'=>'deparment head', 'email'=>'kombolcha112@gmail.com','phone_no'=>'+251922687847','mission'=>'mission','vission'=>'vission','name'=>'add director name here','profile'=>'defaultassets/image/profile.jpg','author_id'=>'1','goal'=>'goal' ]);
        DepartmentContent::create(['position'=>'expansion director', 'email'=>'expansion@gmail.com','phone_no'=>'+251922687848','mission'=>'mission','vission'=>'vission','name'=>'add director name here','profile'=>'defaultassets/image/profile.jpg','author_id'=>'1','goal'=>'goal' ]);
        DepartmentContent::create(['position'=>'development director', 'email'=>'development@gmail.com','phone_no'=>'+251922687849','mission'=>'mission','vission'=>'vission','name'=>'add director name here','profile'=>'defaultassets/image/profile.jpg','author_id'=>'1','goal'=>'goal' ]);
        DepartmentContent::create(['position'=>'miniral director', 'email'=>'miniral@gmail.com','phone_no'=>'+251922687857','mission'=>'mission','vission'=>'vission','name'=>'add director name here','profile'=>'defaultassets/image/profile.jpg','author_id'=>'1','goal'=>'goal' ]);
    }
}


