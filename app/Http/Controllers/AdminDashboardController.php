<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $pendingEvents = Event::where('status', 'pending')->latest()->get();
        $menungguReview = $pendingEvents->count();

        $reviewedEvents = Event::where('status', '!=', 'pending')->latest()->get();
        $sudahReview = $reviewedEvents->count();

        $recentEvents = Event::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'pendingEvents',
            'menungguReview',
            'reviewedEvents',
            'sudahReview',
            'recentEvents'
        ));
    }
}
