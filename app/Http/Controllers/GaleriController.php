<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\DaftarHarga;
use App\Models\Kontak;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class GaleriController extends Controller
{
    private $hasura_url = 'https://saved-gobbler-16.hasura.app/v1/graphql';
    private $hasura_secret = 'AmuOgpRQoZgd3Gvk2hybZiqEAZbGeqOv2g7VLzZCMM6S9FwHXlmwg8TZaTpPHNNm';

    public function index(): View
    {
        // Ambil data dari Hasura
        $galeris = $this->fetchGaleriFromHasura();

        // Ambil data kontak
        $kontaks = Kontak::all();

        // Mengelompokkan daftar harga berdasarkan kelompok
        $uniques = [];
        foreach ($galeris as $galeri) {
            if (isset($galeri['kelompok'])) {
                $uniques[] = $galeri['kelompok'];
            }
        }
        $uniques = array_unique($uniques);

        // Render view dengan data dari Hasura dan kontak
        return view('page.galeri', compact('galeris', 'uniques', 'kontaks'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'tambahGambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'Judul' => 'required|string',
            'Deskripsi' => 'required|string',
        ]);

        // Upload the image
        $imagePath = $request->file('tambahGambar')->store('galeris', 'public');

        // Create a new Galeri instance
        $galeri = new Galeri([
            'img' => $imagePath,
            'judul' => $request->input('Judul'),
            'deskripsi' => $request->input('Deskripsi'),
        ]);

        // Save the Galeri instance to the database
        $galeri->save();

        // Redirect or perform any other actions as needed
        return redirect()->back()->with('success', 'Proses added successfully');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'editJudul' => 'required|string',
            'editDeskripsi' => 'required|string',
            'editFoto' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust image validation as needed
        ]);

        // Find the Galeri by ID
        $galeri = Galeri::findOrFail($id);

        // Update Galeri data
        $galeri->judul = $request->input('editJudul');
        $galeri->deskripsi = $request->input('editDeskripsi');

        // Handle the photo upload if a new photo is provided
        if ($request->hasFile('editFoto')) {
            // Delete the old photo, if exists
            if ($galeri->img) {
                // Adjust the path based on your storage configuration
                Storage::delete('galeris' . $galeri->img);
            }

            // Store the new photo
            $fotoPath = $request->file('editFoto')->store('galeris', 'public');

            // Save the photo path to the Galeri model
            $galeri->img = $fotoPath;
        }

        // Save the changes
        $galeri->save();

        // Redirect back or return a response
        return redirect()->back()->with('success', 'Galeri updated successfully');
    }

    public function destroy(string $id)
    {
        //
    }

    public function softDelete($id)
    {
        $galeri = Galeri::findOrFail($id);
        $galeri->delete(); // This will set the 'deleted_at' timestamp

        return redirect()->back()->with('success', 'User soft deleted successfully');
    }

    private function fetchGaleriFromHasura()
    {
        $client = new Client();
        $query = '
        query MyQuery {
            galeris {
              deskripsi
              id
              img
              judul
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

            return $data['data']['galeris'];
        } catch (\Exception $e) {
            return [];
        }
    }
}
