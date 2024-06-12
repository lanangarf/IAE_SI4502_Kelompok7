<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class KontakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('kontaks')->insert([
            'judul' => 'Butuh jasa kami?',
            'deskripsi' => 'Kami jamin pakaian Anda kembali seperti baru'  ,
            'no_hp' => '085890584822',
            'alamat' => 'Jalan Diponegoro No. 22, Bandung, Jawa Barat, Indonesia'
        ]);
    }
}
