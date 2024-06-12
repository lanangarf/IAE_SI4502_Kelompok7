<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Rico',
                'email' => 'rico@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ],
            [
                'name' => 'Lanang',
                'email' => 'lanang@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'user'
            ],
            [
                'name' => 'Zhillan',
                'email' => 'zhillan@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'user'
            ],
            [
                'name' => 'Shobarna',
                'email' => 'barna@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'user'
            ]
        ]);
    }
}
