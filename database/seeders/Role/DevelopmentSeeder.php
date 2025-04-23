<?php

namespace Database\Seeders\Role;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Role\Development;


class DevelopmentSeeder extends Seeder
{
    use \Database\Seeders\Traits\UserSeeder;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $development = [
            ['name'=> 'Jemal Mohamed Ali', 'email'=>'kochinvestment123@gmail.com', 'phone_no'=>'0333510111', 'role' =>"Development", 'position' =>'development', ],

        ];

        try {
            DB::beginTransaction();

            foreach ($development as $develop) {
                $user = $this->createUser($develop, createdBy: $development);

                $deps = new Development();
                $deps->user_id = $user->id;
                $deps->save();
            }

            DB::commit();
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            echo "Unable to seed development user";
        }
    
    }
}
