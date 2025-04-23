<?php

namespace Database\Seeders\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role\ourStaff;
use Exception;

class ourStaffSeeder extends Seeder
{ use \Database\Seeders\Traits\UserSeeder;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ourStaff = [
            ['name' => 'Biniyam Demesie', 'email' => 'bini123@gmail.com', 'phone_no'=>'0911953358', 'role' =>"ourStaff", 'position' => 'communication director',],

        ];
        try {
            DB::beginTransaction();

            foreach ($ourStaff as $staff) {
                $user = $this->createUser($staff, createdBy: $ourStaff);

                $deps = new ourStaff();
                $deps->user_id = $user->id;
                $deps->save();
            }

            DB::commit();
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            echo "Unable to seed our staff user";
        }   
    }
}
