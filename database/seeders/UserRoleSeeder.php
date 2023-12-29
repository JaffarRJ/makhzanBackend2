<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('user_roles')->truncate();
        DB::table('user_roles')->insert([
            [
                'id' => 1,
                'user_id' => 1, // Admin
                'role_id' => 1, // Admin
                'is_active' => 1,
                'is_show' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'user_id' => 2, // User
                'role_id' => 2, // User
                'is_active' => 1,
                'is_show' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
