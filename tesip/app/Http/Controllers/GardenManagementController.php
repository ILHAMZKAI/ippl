<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GardenManagementController extends Controller
{
    public function index()
    {
        $numRows = 10; // Jumlah baris awal (default)
        $numColumns = 10; // Jumlah kolom awal (default)
        return view('/pages/garden-management', compact('numRows', 'numColumns'));
    }

    public function update(Request $request)
    {
        // Validasi input agar jumlah baris dan kolom selalu positif
        $request->validate([
            'num_rows' => 'required|integer|min:1',
            'num_columns' => 'required|integer|min:1',
        ]);

        // Ambil jumlah baris dan kolom dari input
        $numRows = $request->input('num_rows');
        $numColumns = $request->input('num_columns');

        // Kirim jumlah baris dan kolom ke tampilan
        return view('/pages/garden-management', compact('numRows', 'numColumns'));
    }
}
