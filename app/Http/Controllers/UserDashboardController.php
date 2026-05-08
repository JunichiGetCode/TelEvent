<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $pendingCount = Event::where('status', 'pending')->count();

        $ongoingCount = Event::where('status', 'approved')->count();


        $upcomingEvents = Event::where('status', 'approved')
                               ->latest()
                               ->take(10)
                               ->get();

        return view('user.dashboard', compact('pendingCount', 'ongoingCount', 'upcomingEvents'));
    }
}
