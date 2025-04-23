<?php

namespace Database\Seeders\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Role\Miniral;

class miniralSeeder extends Seeder
{ use \Database\Seeders\Traits\UserSeeder;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mineral = [
            ['name' => 'Tigist Tarekegn Yazewu', 'email' => 'kochinvestment122@gmail.com', 'phone_no'=>' 0333512167', 'role' =>"miniral", 'position' => 'miniral director',],

        ];
        try {
            DB::beginTransaction();

            foreach ($mineral as $miner) {
                $user = $this->createUser($miner, createdBy: $mineral);

                $deps = new Miniral();
                $deps->user_id = $user->id;
                $deps->save();
            }

            DB::commit();
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            echo "Unable to seed mineral user";
        }   
    }
}
