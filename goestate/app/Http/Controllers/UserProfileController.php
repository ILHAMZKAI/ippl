<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function show()
    {
        return view('pages.user-profile');
    }

    public function deleteImage()
    {
        $user = auth()->user();
        if ($user->gambar) {
            $path = 'user_images/' . $user->gambar;
            Storage::delete('public/user_images/' . $user->gambar);
            $user->update(['gambar' => '']);
            return back()->with('error', 'Gambar profil berhasil dihapus');
        }
        return back()->with('error', 'Tidak ada gambar profil');
    }

    public function update(Request $request)
    {
        $attributes = $request->validate([
            'username' => ['required', 'max:255', 'min:2'],
            'firstname' => ['max:100'],
            'lastname' => ['max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(auth()->user()->id),],
            'address' => ['max:100'],
            'gambar' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'city' => ['max:100'],
            'country' => ['max:100'],
            'postal' => ['max:100'],
            'about' => ['max:255']
        ]);

        $user = auth()->user();

        auth()->user()->update([
            'username' => $request->get('username'),
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'email' => $request->get('email'),
            'address' => $request->get('address'),
            'city' => $request->get('city'),
            'country' => $request->get('country'),
            'postal' => $request->get('postal'),
            'about' => $request->get('about')
        ]);

        if ($request->hasFile('gambar')) {
            $user = auth()->user();
            $file = $request->file('gambar');
            $gambarName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/user_images', $gambarName);
            if ($user->gambar) {
                Storage::delete('public/user_images/' . $user->gambar);
            }
            $user->update(['gambar' => $gambarName]);
        }
        return back()->with('succes', 'Profil sukses diperbarui');
    }
}
