<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;

class UserProfileController extends Controller
{
    // Menampilkan halaman profile
    public function show()
    {
        $user = Auth::user();

        // Ambil event milik user, urutkan dari yang terbaru
        // Variabel ini ($events) yang akan dipakai di tabel status di view profile
        $events = Event::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        // Hitung jumlah berdasarkan status (Sesuai dengan EventController)
        $pending  = $events->where('status', 'pending')->count();
        $approved = $events->where('status', 'approved')->count();
        $rejected = $events->where('status', 'rejected')->count();

        // Kita kirim variabel '$events' ini sebagai 'myEvents' agar cocok dengan view sebelumnya
        // Atau kamu bisa ubah di view-nya menjadi $events.
        return view('profile.show', [
            'user' => $user,
            'myEvents' => $events, // Ubah nama jadi myEvents biar cocok sama view
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected
        ]);
    }

    // Menampilkan halaman edit profile
    public function edit()
    {
        return view('profile.edit');
    }

    // Mengupdate data profile
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone'     => 'nullable|string|max:15',
            'avatar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // Update nama, email, dan phone
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        // Jika ada foto profil baru, upload dan simpan path-nya
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada (dan bukan avatar default/url luar)
            if ($user->avatar && Storage::exists('public/profile/' . $user->avatar)) {
                Storage::delete('public/profile/' . $user->avatar);
            }

            // Upload foto baru
            $avatarPath = $request->file('avatar')->store('profile', 'public');
            $user->avatar = basename($avatarPath);
        }

        // Simpan perubahan
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    // (Opsional) Method ini bisa dihapus jika halaman status sudah digabung di method show()
    // Tapi jika kamu masih pakai halaman terpisah, biarkan saja.
    public function proposals()
    {
        $events = Auth::user()->events()->latest()->get();

        $approved = $events->where('status', 'approved')->count();
        $pending  = $events->where('status', 'pending')->count();
        $rejected = $events->where('status', 'rejected')->count();

        return view('profile.proposals', compact('events', 'approved', 'pending', 'rejected'));
    }
}