<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        // 1. Event Menunggu Review (GLOBAL / Semua Event di Database)
        // Menghitung semua event status 'pending' punya siapa saja
        $pendingCount = Event::where('status', 'pending')->count();

        // 2. Event Sedang Berjalan (GLOBAL / Semua Event di Database)
        // Menghitung semua event status 'approved' punya siapa saja
        $ongoingCount = Event::where('status', 'approved')->count();


        // 3. Data Carousel (Global)
        $upcomingEvents = Event::where('status', 'approved')
                               ->latest()
                               ->take(10)
                               ->get();

        return view('user.dashboard', compact('pendingCount', 'ongoingCount', 'upcomingEvents'));
    }
}