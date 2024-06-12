<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use GuzzleHttp\Client;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Kontak;

class UlasanController extends Controller
{
    private $hasura_url = 'https://saved-gobbler-16.hasura.app/v1/graphql';
    private $hasura_secret = 'AmuOgpRQoZgd3Gvk2hybZiqEAZbGeqOv2g7VLzZCMM6S9FwHXlmwg8TZaTpPHNNm';

    public function index(): View
    {
        // Ambil data dari Hasura
        $ulasans = $this->fetchUlasanFromHasura();

        // Ambil data kontak
        $kontaks = Kontak::all();

        $uniques = [];
        foreach ($kontaks as $kontak) {
            $uniques[] = $kontak->kelompok;
        }
        $uniques = array_unique($uniques);

        // Mendapatkan daftar layanan untuk setiap kelompok
        $services = [];
        foreach ($uniques as $unique) {
            $services[$unique] = collect($kontaks)->where('kelompok', $unique)->values();
        }

        // Render view dengan data dari Hasura dan kontak
        return view('page.ulasan', compact('ulasans', 'uniques', 'kontaks', 'services'));
    }

    // Fungsi untuk mengambil data ulasan dari Hasura
    private function fetchUlasanFromHasura()
    {
        $client = new Client();
        $query = '
        query {
            ulasans {
                id
                judul
                rating
                ulasan
                user_id
                nama
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

            return $data['data']['ulasans'];
        } catch (\Exception $e) {
            return [];
        }
    }

    // Fungsi untuk menyimpan ulasan ke Hasura
    public function store(Request $request)
    {
        // Memastikan pengguna telah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk memberikan ulasan.');
        }

        // Generate random ID
        $randomId = random_int(1000, 9999);

        // Validasi data
        $request->validate([
            'Nama' => 'required|string|max:255',
            'Rating' => 'required|integer|min:1|max:5',
            'JudulUlasan' => 'required|string|max:255',
            'Ulasan' => 'required|string',
            'UserID' => 'required|exists:users,id'
        ]);

        // Data untuk dikirim ke Hasura
        $data = [
            'id' => $randomId,
            'judul' => $request->input('JudulUlasan'),
            'rating' => $request->input('Rating'),
            'ulasan' => $request->input('Ulasan'),
            'user_id' => $request->input('UserID'),
            'nama' => $request->input('Nama')
        ];

        // dd($data);

        // Kirim ulasan ke Hasura dengan ID yang dihasilkan secara acak
        $response = $this->submitReviewToHasura($data);

        if ($response) {
            return redirect()->back()->with('success', 'Ulasan berhasil ditambahkan')->with('randomId', $randomId);
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan ulasan')->with('randomId', $randomId);
        }
    }

    // Fungsi untuk mengirim ulasan ke Hasura
    private function submitReviewToHasura($data)
    {
        $client = new Client();
        $mutation = '
        mutation AddUlasan($id: Int!, $judul: String!, $rating: Int!, $ulasan: String!, $user_id: Int!, $nama: String!) {
            insert_ulasans(objects: {id: $id, judul: $judul, rating: $rating, ulasan: $ulasan, user_id: $user_id, nama: $nama}) {
                affected_rows
            }
        }';

        try {
            $response = $client->post($this->hasura_url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-hasura-admin-secret' => $this->hasura_secret
                ],
                'json' => [
                    'query' => $mutation,
                    'variables' => $data
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return isset($data['data']['insert_ulasans']['affected_rows']) && $data['data']['insert_ulasans']['affected_rows'] > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    // Fungsi untuk memperbarui ulasan di Hasura
    public function update(Request $request, $id)
    {
        // Memastikan pengguna telah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk memperbarui ulasan.');
        }

        // Validasi data
        $request->validate([
            'Nama' => 'required|string|max:255',
            'Rating' => 'required|integer|min:1|max:5',
            'JudulUlasan' => 'required|string|max:255',
            'Ulasan' => 'required|string',
        ]);

        // Data untuk dikirim ke Hasura
        $data = [
            'id' => (int) $id,
            'judul' => $request->input('JudulUlasan'),
            'rating' => $request->input('Rating'),
            'ulasan' => $request->input('Ulasan'),
            'user_id' => auth()->user()->id, // Menggunakan ID pengguna yang sedang login
            'nama' => $request->input('Nama')
        ];

        // Kirim ulasan yang diperbarui ke Hasura
        $response = $this->updateReviewInHasura($data);

        if ($response) {
            return redirect()->back()->with('success', 'Ulasan berhasil diperbarui')->with('randomId', $id);
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui ulasan')->with('randomId', $id);
        }
    }

    // Fungsi untuk mengirim ulasan yang diperbarui ke Hasura
    private function updateReviewInHasura($data)
    {
        $client = new Client();
        $mutation = '
        mutation UpdateUlasan($id: Int!, $judul: String!, $rating: Int!, $ulasan: String!, $user_id: Int!, $nama: String!) {
            update_ulasans(where: {id: {_eq: $id}}, _set: {judul: $judul, rating: $rating, ulasan: $ulasan, user_id: $user_id, nama: $nama}) {
                affected_rows
            }
        }';

        try {
            $response = $client->post($this->hasura_url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-hasura-admin-secret' => $this->hasura_secret
                ],
                'json' => [
                    'query' => $mutation,
                    'variables' => $data
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return isset($data['data']['update_ulasans']['affected_rows']) && $data['data']['update_ulasans']['affected_rows'] > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    // Fungsi untuk mengirim permintaan penghapusan ke Hasura
    public function deleteReviewInHasura($id)
    {
        // Memastikan pengguna telah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk menghapus ulasan.');
        }

        // Kirim permintaan penghapusan ke Hasura
        $response = $this->deleteReviewFromHasura($id);

        if ($response) {
            return redirect()->back()->with('success', 'Ulasan berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus ulasan');
        }
    }

    // Fungsi untuk mengirim permintaan penghapusan ke Hasura
    private function deleteReviewFromHasura($id)
    {
        $client = new Client();
        $mutation = '
        mutation DeleteUlasan($id: Int!) {
            delete_ulasans(where: {id: {_eq: $id}}) {
                affected_rows
            }
        }';

        try {
            $response = $client->post($this->hasura_url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-hasura-admin-secret' => $this->hasura_secret
                ],
                'json' => [
                    'query' => $mutation,
                    'variables' => ['id' => (int) $id]
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return isset($data['data']['delete_ulasans']['affected_rows']) && $data['data']['delete_ulasans']['affected_rows'] > 0;
        } catch (\Exception $e) {
            return false;
        }
    }
}
