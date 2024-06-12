<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use App\Models\DaftarHarga;
use App\Models\Kontak;


class DaftarHargaController extends Controller
{
    private $hasura_url = 'https://saved-gobbler-16.hasura.app/v1/graphql';
    private $hasura_secret = 'AmuOgpRQoZgd3Gvk2hybZiqEAZbGeqOv2g7VLzZCMM6S9FwHXlmwg8TZaTpPHNNm';

    public function index(): View
    {
        // Ambil data dari Hasura
        $daftarHargas = $this->fetchDaftarHargaFromHasura();

        // Ambil data kontak
        $kontaks = Kontak::all();

        // Mengelompokkan daftar harga berdasarkan kelompok
        $uniques = [];
        foreach ($daftarHargas as $daftarHarga) {
            $uniques[] = $daftarHarga['kelompok'];
        }
        $uniques = array_unique($uniques);

        // Mendapatkan daftar layanan untuk setiap kelompok
        $services = [];
        foreach ($uniques as $unique) {
            $services[$unique] = collect($daftarHargas)->where('kelompok', $unique)->values();
        }

        // Render view dengan data dari Hasura dan kontak
        return view('page.daftar_harga', compact('daftarHargas', 'uniques', 'services', 'kontaks'));
    }



    public function create()
    {
        // Tampilkan formulir pembuatan
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'editFoto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'editNama' => 'required|string',
            'editMinimal' => 'required|numeric',
            'editEstimasi' => 'required|numeric',
            'editHarga' => 'required|numeric',
        ]);

        // Buat instansi DaftarHarga baru
        $daftarHarga = new DaftarHarga;

        // Handle upload gambar jika ada gambar baru yang diberikan
        if ($request->hasFile('editFoto')) {
            $imagePath = $request->file('editFoto')->store('daftar_harga_images', 'public');
            $daftarHarga->img = $imagePath;
        }

        // Isi bidang-bidang lainnya
        $daftarHarga->kelompok = $request->input('kelompok');
        $daftarHarga->name = $request->input('editNama');
        $daftarHarga->minimal = $request->input('editMinimal');
        $daftarHarga->estimasi = $request->input('editEstimasi');
        $daftarHarga->harga = $request->input('editHarga');

        // Simpan rekaman DaftarHarga baru
        $daftarHarga->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function show(string $id)
    {
        // Tampilkan detail data
    }

    public function edit(string $id)
    {
        // Tampilkan formulir pengeditan
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'editFoto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Sesuaikan aturan validasi untuk file gambar
            'editNama' => 'required|string',
            'editMinimal' => 'required|numeric',
            'editEstimasi' => 'required|numeric',
            'editHarga' => 'required|numeric',
        ]);

        // Temukan rekaman berdasarkan ID
        $daftarHarga = DaftarHarga::findOrFail($id);

        // Handle upload gambar jika ada gambar baru yang diberikan
        if ($request->hasFile('editFoto')) {
            // Hapus gambar lama jika diperlukan
            // Gunakan fasad Storage untuk menghapus file lama dari penyimpanan
            Storage::delete($daftarHarga->img);

            // Upload gambar baru
            $imagePath = $request->file('editFoto')->store('daftar_harga_images', 'public');

            // Perbarui rekaman dengan jalur gambar baru
            $daftarHarga->img = $imagePath;
        }

        // Perbarui bidang lainnya
        $daftarHarga->name = $request->input('editNama');
        $daftarHarga->minimal = $request->input('editMinimal');
        $daftarHarga->estimasi = $request->input('editEstimasi');
        $daftarHarga->harga = $request->input('editHarga');

        // Simpan perubahan
        $daftarHarga->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        // Hapus data
    }

    public function softDelete($id)
    {
        // Soft delete data
    }

    public function softDeleteKelompok($kelompok)
    {
        // Soft delete semua rekaman dengan kelompok tertentu
    }

    private function fetchDaftarHargaFromHasura()
    {
        $client = new Client();
        $query = '
        query MyQuery {
            daftar_hargas {
                estimasi
                harga
                id
                img
                kelompok
                minimal
                name
                user_id
            }
        }';

        try {
            $response = $client->post($this->hasura_url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-hasura-admin-secret' => $this->hasura_secret
                ],
                'json' => [
                    'query' => $query,
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            if (isset($data['errors'])) {
                return [];
            }

            return $data['data']['daftar_hargas'];
        } catch (\Exception $e) {
            return [];
        }
    }
}
