<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $events = Event::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        $pending  = $events->where('status', 'pending')->count();
        $approved = $events->where('status', 'approved')->count();
        $rejected = $events->where('status', 'rejected')->count();

        return view('profile.show', [
            'user' => $user,
            'myEvents' => $events,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected
        ]);
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone'     => 'nullable|string|max:15',
            'avatar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::exists('public/profile/' . $user->avatar)) {
                Storage::delete('public/profile/' . $user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('profile', 'public');
            $user->avatar = basename($avatarPath);
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    public function proposals()
    {
        $events = Auth::user()->events()->latest()->get();

        $approved = $events->where('status', 'approved')->count();
        $pending  = $events->where('status', 'pending')->count();
        $rejected = $events->where('status', 'rejected')->count();

        return view('profile.proposals', compact('events', 'approved', 'pending', 'rejected'));
    }
}
