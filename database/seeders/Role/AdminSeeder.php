<?php

    namespace Database\Seeders\Role;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use App\Models\Role\Admin;
    use Exception;

    class AdminSeeder extends Seeder
    {
        use \Database\Seeders\Traits\UserSeeder;        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            $admin = [
                ['name' => 'admin', 'email' => 'hre4422@gmail.com', 'phone_no'=>'0937669612', 'role' =>"admin", 'position' => 'admin', ],

            ];
            try {
                DB::beginTransaction();

                foreach ($admin as $admins) {
                    $user = $this->createUser($admins, createdBy: $admin);

                    $deps = new Admin();
                    $deps->user_id = $user->id;
                    $deps->save();
                }

                DB::commit();
            } catch (Exception $e) {
                dd($e);
                DB::rollBack();
                echo "Unable to seed admin user";
            }
        }
    }
