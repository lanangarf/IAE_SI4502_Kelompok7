<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UlasanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ulasans')->insert([
            [
                'judul' => 'Senang',
                'rating' => 5,
                'ulasan' => 'Proses Laundry cepat -Lanang',
                'user_id' => 1
            ],
            [
                'judul' => 'Bersih dan tidak tertukar',
                'rating' => 5,
                'ulasan' => 'Saya suka tertukar di tempat laundry lain, disini aman. -Zhillan',
                'user_id' => 2
            ],
        ]);
    }
}
