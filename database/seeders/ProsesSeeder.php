<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ProsesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		DB::table('proses')->insert(
			[
				[
					'tema' => 'Proses Kami',
					'sub_tema' => 'Bagaimana kami bekerja',
					'icon' => '/img/icon/time-fast-svgrepo-com.svg',
					'judul' => 'Pengerjaan Cepat',
					'deskripsi' => "Liquid Laundry menawarkan keunggulan dalam kecepatan proses laundry, memastikan cucian Anda siap dalam waktu singkat."
				],
				[
					'tema' => 'Proses Kami',
					'sub_tema' => 'Bagaimana kami bekerja',
					'icon' => '/img/icon/services-icon2.svg',
					'judul' => 'Laundry Premium',
					'deskripsi' => "Liquid Laundry menjamin pakaian Anda dirawat dengan cermat menggunakan deterjen berkualitas tinggi."
				],
				[
					'tema' => 'Proses Kami',
					'sub_tema' => 'Bagaimana kami bekerja',
					'icon' => '/img/icon/indonesian-rupiah-indonesia-svgrepo-com.svg',
					'judul' => 'Harga Terjangkau',
					'deskripsi' => "Liquid Laundry menawarkan tarif yang kompetitif, memberikan nilai terbaik untuk kualitas layanan kami."
				]
			]
		);
	}
}
