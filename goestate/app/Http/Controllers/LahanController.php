<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Lahan;
use App\Models\Data;

use Illuminate\Http\Request;

class LahanController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $lahanData = Lahan::where('user_id', $userId)->get();

        return view('/pages/garden-management', compact('lahanData'));
    }
    public function create(Request $request)
    {
        $namaLahan = $request->input('namaLahan');
        $jumlahBaris = $request->input('jumlahBaris');
        $jumlahKolom = $request->input('jumlahKolom');
        $userId = auth()->id();

        if (
            !is_numeric($jumlahBaris) || !is_numeric($jumlahKolom) ||
            $jumlahBaris <= 0 || $jumlahKolom <= 0 || $jumlahBaris > 16 || $jumlahKolom > 26
        ) {
            return redirect('/garden-management')->with('error', 'Harap masukkan nilai yang valid untuk baris (maksimum 16) dan kolom (maksimum 26)');
        }

        $lahan = new Lahan;
        $lahan->nama = $namaLahan;
        $lahan->jumlah_baris = $jumlahBaris;
        $lahan->jumlah_kolom = $jumlahKolom;
        $lahan->user_id = $userId;
        $lahan->save();

        return redirect('/garden-management')->with('success', 'Lahan berhasil dibuat');
    }
    public function delete($id)
    {
        $userId = auth()->id();

        $lahan = Lahan::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$lahan) {
            return redirect('/garden-management')->with('error', 'Data lahan tidak ditemukan atau Anda tidak memiliki akses ke data lahan ini');
        }

        $lahan->delete();

        return redirect('/garden-management')->with('success', 'Data lahan berhasil dihapus');
    }

    public function updateLahan(Request $request)
    {
        $request->validate([
            'idLahan' => 'required',
            'namaLahan' => 'required',
            'jumlahBaris' => 'required|numeric|min:1|max:16',
            'jumlahKolom' => 'required|numeric|min:1|max:26',
        ]);

        $user = Auth::user();

        if ($user) {
            $lahan = Lahan::where('user_id', $user->id)
                ->where('id', $request->input('idLahan'))
                ->first();

            if ($lahan) {
                $lahan->update([
                    'nama' => $request->input('namaLahan'),
                    'jumlah_baris' => $request->input('jumlahBaris'),
                    'jumlah_kolom' => $request->input('jumlahKolom'),
                ]);

                return redirect('/garden-management')->with('success', 'Data Lahan berhasil diperbarui');
            } else {
                return redirect('/garden-management')->with('error', 'ID Lahan tidak ditemukan atau tidak sesuai dengan pengguna');
            }
        }
    }

}