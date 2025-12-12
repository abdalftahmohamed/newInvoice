<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
//    public function run(): void
//    {
////        $first_role_id = Role::first()->id;
//
//        Admin::create([
//            'name' => 'admin name',
//            'email' => 'admin@app.com',
//            'password' => bcrypt( '12345678'),
//            'status' => 1,
//            'role_id' => 1
//
//        ]);
//
////        Admin::create([
////            'name' => 'admin name',
////            'email' => 'abdalftahmohamed054@gmail.com',
////            'password' => bcrypt( '12345678'),
////            'status' => 1,
////            'role_id' => 1
////
////        ]);
//    }
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $first_role_id = Role::first()->id;

        User::create([
            'name' => 'admin name',
            'email' => 'app@app.com',
            'password' => bcrypt( '12345678'),
            'status' => 1,
            'role_id' => $first_role_id
        ]);

        // Create 12 users
        for ($i = 1; $i <= 12; $i++) {
            User::create([
                'name' => "User $i",
                'email' => "user$i@app.com",
                'password' => bcrypt('12345678'),
                'status' => 1,
                'role_id' => $first_role_id,
            ]);
        }
    }
}
