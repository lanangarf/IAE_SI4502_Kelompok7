<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('galeris')->insert([
            [
                'judul' => 'Lokasi yang Mudah Dijangkau',
                'img' => '/gambar/lokasi laundry.jpeg',
                'deskripsi' => 'Layanan laundry kami terletak di lokasi yang mudah diakses oleh pelanggan, menjadikannya sangat nyaman untuk digunakan kapan saja.'
            ],
            [
                'judul' => 'Fasilitas Penyimpanan Terbaik',
                'img' => '/gambar/rak penyimpanan.jpeg',
                'deskripsi' => 'Kami menawarkan fasilitas penyimpanan yang bersih dan terjamin keamanannya, menjaga pakaian pelanggan tetap dalam kondisi optimal. Kebersihan dan keamanan adalah prioritas utama kami.'
            ],
            [
                'judul' => 'Mesin Pencuci Handal',
                'img' => '/gambar/mesin cuci.jpeg',
                'deskripsi' => 'Mesin pencuci kami dirancang untuk menampung beban cucian besar, memungkinkan pencucian banyak pakaian dalam satu kali proses, sehingga mengurangi frekuensi pencucian.'
            ]
        ]);
    }
}
