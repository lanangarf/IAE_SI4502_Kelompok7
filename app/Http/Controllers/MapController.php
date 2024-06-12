<?php

namespace App\Http\Controllers;

use App\Models\DaftarHarga;
use App\Models\Kontak;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $uniques = DaftarHarga::distinct()->pluck('kelompok');
        $kontaks = Kontak::get();

        return view('page.map', compact('uniques', 'kontaks'));
    }

    public function showMap(Request $request)
    {
        $validated = $request->validate([
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);

        $uniques = DaftarHarga::distinct()->pluck('kelompok');
        $kontaks = Kontak::get();

        return view('page.map', [
            'longitude' => $validated['longitude'],
            'latitude' => $validated['latitude'],
            'uniques' => $uniques,
            'kontaks' => $kontaks,
        ]);
        dd('latitude', 'longitude');
    }
}
