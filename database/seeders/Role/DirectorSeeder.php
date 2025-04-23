<?php

namespace Database\Seeders\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role\Director;
use Exception;

class DirectorSeeder extends Seeder
{
    use \Database\Seeders\Traits\UserSeeder;    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $director = [
        ['name' => 'Hussien Muhe Yimer', 'email' => 'kochinvestment12@gmail.com', 'phone_no'=>'+0333519009', 'role' =>"Director", 'position' => 'deparment head',],

    ];
        try {
            DB::beginTransaction();

            foreach ($director as $direct) {
                $user = $this->createUser($direct, createdBy: $director);

                $deps = new Director();
                $deps->user_id = $user->id;
                $deps->save();
            }

            DB::commit();
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            echo "Unable to seed director user";
        }   
    }
}
