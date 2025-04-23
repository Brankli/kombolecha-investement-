<?php

namespace Database\Seeders\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Role\Expansition;
class ExpansionSeeder extends Seeder
{
    use \Database\Seeders\Traits\UserSeeder;    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expansion = [
            ['name' => 'Hashem seid', 'email' => 'seidhashim3@gmail.com', 'phone_no'=>' +0333512933', 'role' =>"Expansition", 'position' => 'expansion director', ],

        ];
        try {
            DB::beginTransaction();

            foreach ($expansion as $expans) {
                $user = $this->createUser($expans, createdBy: $expansion);

                $deps = new Expansition();
                $deps->user_id = $user->id;
                $deps->save();
            }

            DB::commit();
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            echo "Unable to seed expansion user";
        }   
    }
}
