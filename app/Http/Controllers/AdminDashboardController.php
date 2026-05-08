<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil DATA LIST event yang statusnya 'pending' (Untuk isi Modal "Menunggu Review")
        $pendingEvents = Event::where('status', 'pending')->latest()->get();
        // Hitung jumlahnya untuk angka di Card
        $menungguReview = $pendingEvents->count();

        // 2. Ambil DATA LIST event yang statusnya SUDAH DI-REVIEW (approved/rejected) (Untuk isi Modal "Sudah Direview")
        $reviewedEvents = Event::where('status', '!=', 'pending')->latest()->get();
        // Hitung jumlahnya untuk angka di Card
        $sudahReview = $reviewedEvents->count();

        // 3. Ambil data event terbaru untuk list "Baru saja dibuka" (Maksimal 5)
        $recentEvents = Event::latest()->take(5)->get();

        // Kirim semua variabel (List dan Count) ke view
        return view('admin.dashboard', compact(
            'pendingEvents',    // Data List Pending
            'menungguReview',   // Angka Jumlah Pending
            'reviewedEvents',   // Data List Reviewed
            'sudahReview',      // Angka Jumlah Reviewed
            'recentEvents'      // Data List Terbaru
        ));
    }
}