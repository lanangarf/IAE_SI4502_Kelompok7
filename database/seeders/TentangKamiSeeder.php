<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class TentangKamiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tentang_kamis')->insert([
            'judul' => 'Tentang kami',
            'deskripsi' => "Liquid Laundry adalah solusi laundry terdepan yang berkomitmen untuk menyediakan layanan cepat, higienis, dan terpercaya. Dengan tim profesional yang berpengalaman dan menggunakan teknologi modern, kami memastikan pakaian Anda dicuci dan dirawat dengan sempurna."
        ]);
    }
}
