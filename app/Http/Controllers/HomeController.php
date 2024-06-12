<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\Proses;
use App\Models\Layanan;
use App\Models\Kontak;
use App\Models\TentangKami;
use App\Models\Ulasan;
use App\Models\DaftarHarga;
use GuzzleHttp\Client;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    private $hasura_url = 'https://saved-gobbler-16.hasura.app/v1/graphql';
    private $hasura_secret = 'AmuOgpRQoZgd3Gvk2hybZiqEAZbGeqOv2g7VLzZCMM6S9FwHXlmwg8TZaTpPHNNm';

    public function index(): View
    {
        $homes = $this->fetchHomeFromHasura('homes');
        $prosess = $this->fetchProsesFromHasura('proses');
        $layanans = $this->fetchLayananFromHasura('layanans');
        $kontaks = $this->fetchKontakFromHasura('kontaks');
        $data_tentang_kami = $this->fetchTentangKamiFromHasura('tentang_kamis');
        $ulasans = $this->fetchUlasanFromHasura('ulasans');

        $uniques = [];
        foreach ($homes as $home) {
            if (isset($home['kelompok'])) {
                $uniques[] = $home['kelompok'];
            }
        }
        $uniques = array_unique($uniques);

        return view('page.home', compact('homes', 'prosess', 'layanans', 'kontaks', 'data_tentang_kami', 'ulasans', 'uniques'));
    }



    private function fetchHomeFromHasura()
    {
        $client = new Client();
        $query = '
        query query MyQuery {
            homes {
              deskripsi
              id
              img_banner
              judul
              user_id
            }
          }';

        try {
            $response = $client->post($this->hasura_url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-hasura-admin-secret' => $this->hasura_secret,
                ],
                'json' => ['query' => $query],
            ]);

            $data = json_decode($response->getBody(), true);
            if (isset($data['errors'])) {
                return [];
            }

            return $data['data']['homes'];
        } catch (\Exception $e) {
            return [];
        }
    }

    private function fetchProsesFromHasura()
    {
        $client = new Client();
        $query = '
        query MyQuery {
            proses {
              deskripsi
              icon
              id
              judul
              sub_tema
              tema
              user_id
            }
          }';

        try {
            $response = $client->post($this->hasura_url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-hasura-admin-secret' => $this->hasura_secret,
                ],
                'json' => ['query' => $query],
            ]);

            $data = json_decode($response->getBody(), true);
            if (isset($data['errors'])) {
                return [];
            }

            return $data['data']['proses'];
        } catch (\Exception $e) {
            return [];
        }
    }

    private function fetchLayananFromHasura()
    {
        $client = new Client();
        $query = '
        query MyQuery {
            layanans {
              deskripsi
              id
              img1
              img2
              img_icon
              judul
              sub_tema
              tema
              user_id
            }
          }';

        try {
            $response = $client->post($this->hasura_url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-hasura-admin-secret' => $this->hasura_secret,
                ],
                'json' => ['query' => $query],
            ]);

            $data = json_decode($response->getBody(), true);
            if (isset($data['errors'])) {
                return [];
            }

            return $data['data']['layanans'];
        } catch (\Exception $e) {
            return [];
        }
    }

    private function fetchKontakFromHasura()
    {
        $client = new Client();
        $query = '
        query MyQuery {
            kontaks {
              alamat
              deskripsi
              id
              judul
              no_hp
              user_id
            }
          }';

        try {
            $response = $client->post($this->hasura_url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-hasura-admin-secret' => $this->hasura_secret,
                ],
                'json' => ['query' => $query],
            ]);

            $data = json_decode($response->getBody(), true);
            if (isset($data['errors'])) {
                return [];
            }

            return $data['data']['kontaks'];
        } catch (\Exception $e) {
            return [];
        }
    }

    private function fetchTentangKamiFromHasura()
    {
        $client = new Client();
        $query = '
    query MyQuery {
        tentang_kamis {
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
                    'x-hasura-admin-secret' => $this->hasura_secret,
                ],
                'json' => ['query' => $query],
            ]);

            $data = json_decode($response->getBody(), true);
            if (isset($data['errors'])) {
                return [];
            }

            return $data['data']['tentang_kamis'];
        } catch (\Exception $e) {
            return [];
        }
    }

    private function fetchUlasanFromHasura()
    {
        $client = new Client();
        $query = '
        query MyQuery {
            ulasans {
              id
              judul
              rating
              ulasan
              user_id
            }
          }';

        try {
            $response = $client->post($this->hasura_url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-hasura-admin-secret' => $this->hasura_secret,
                ],
                'json' => ['query' => $query],
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

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'editFoto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'editJudul' => 'required|string|max:255',
            'editDeskripsi' => 'required|string',
        ]);

        $home = Home::findOrFail($id);
        $home->judul = $request->input('editJudul');
        $home->deskripsi = $request->input('editDeskripsi');

        if ($request->hasFile('editFoto')) {
            if ($home->foto && Storage::exists($home->foto)) {
                Storage::delete($home->foto);
            }
            $imagePath = $request->file('editFoto')->store('home_banners', 'public');
            $home->foto = $imagePath;
        }

        $home->save();

        return redirect()->back()->with('success', 'Banner updated successfully');
    }
}
