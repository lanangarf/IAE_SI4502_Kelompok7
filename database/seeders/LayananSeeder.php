<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class LayananSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		DB::table('layanans')->insert([

			[
				'tema' => 'Layanan',
				'sub_tema' => 'Layanan yang kami tawarkan',
				'img1' => '/img/gallery/offers4.png',
				'img2' => '/img/gallery/offers2.png',
				'judul' => 'Layanan Standar',
				'deskripsi' => 'Nikmati kepraktisan layanan pencucian standar kami dengan harga terjangkau, membawa kembali kesegaran pakaian Anda hanya dengan Rp6.000 per kilogram!'
			],
			[
				'tema' => 'Layanan',
				'sub_tema' => 'Layanan yang kami tawarkan',
				'img1' => '/img/gallery/offers2.png',
				'img2' => '/img/gallery/offers1.png',
				'judul' => 'Layanan Ekspres',
				'deskripsi' => 'Dengan layanan pencucian ekspres kami, nikmati kemudahan pengiriman pakaian Anda dengan cepat dan efisien. Mulai dari Rp10.000 per kilogram!'
			]


		]);
	}
}
