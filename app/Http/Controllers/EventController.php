<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // Menampilkan dashboard user (5 event terbaru milik user)
    public function dashboard()
    {
        $events = Event::where('user_id', auth()->id()) 
            ->latest()
            ->take(5)
            ->get();
        
        return view('dashboard', compact('events'));
    }

    // ------------------------------------------------------------------
    // PERUBAHAN 1: Halaman Index (Semua Event)
    // Hanya menampilkan event yang sudah DISETUJUI (APPROVED) admin
    // ------------------------------------------------------------------
   // Menampilkan semua event (HANYA YANG APPROVED)
    public function index()
    {
        // HAPUS 'withCount(...)' karena kita tidak punya model Timeline/Budget
        $events = Event::where('status', 'approved')
                       ->latest()
                       ->paginate(10);
                       
        return view('events.index', compact('events'));
    }

    // Menampilkan form buat event
    public function create()
    {
        return view('events.create');
    }

    // ------------------------------------------------------------------
    // PERUBAHAN 2: Proses Simpan Event
    // Redirect ke Profile User setelah simpan agar bisa cek status
    // ------------------------------------------------------------------
    public function store(Request $r)
    {
        $data = $r->validate([
            'type'       => 'required|in:Exhibition,Festival,Lomba,Seminar,Webinar',
            'title'      => 'required',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'proposal'   => 'required|file|mimes:pdf,doc,docx',
            'timeline'   => 'required|file|mimes:pdf,doc,docx',
            'budgeting'  => 'required|file|mimes:pdf,doc,docx',
            'poster'     => 'nullable|file|mimes:jpeg,png,pdf,jpg',
            'other_data' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $data['user_id'] = auth()->id();

        // Upload File
        $data['proposal']  = $r->file('proposal')->store('proposals', 'public');
        $data['timeline']  = $r->file('timeline')->store('timelines', 'public');
        $data['budgeting'] = $r->file('budgeting')->store('budgeting', 'public');

        if ($r->hasFile('poster')) {
            $data['poster'] = $r->file('poster')->store('posters', 'public');
        }

        if ($r->hasFile('other_data')) {
            $data['other_data'] = $r->file('other_data')->store('other_data', 'public');
        }

        // Set status awal jadi PENDING
        $data['status'] = 'pending';
        Event::create($data);

        // Redirect ke PROFILE USER dengan pesan sukses
        return redirect()->route('profile.show')
                         ->with('success', 'Event berhasil diajukan! Status saat ini: Menunggu Review Admin.');
    }

    // Menampilkan detail event
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    // Edit event
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    // Update event
    public function update(Request $r, Event $event)
    {
        $data = $r->validate([
            'type'       => 'required|in:Exhibition,Festival,Lomba,Seminar,Webinar',
            'title'      => 'required',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'proposal'   => 'nullable|file|mimes:pdf,doc,docx',
            'timeline'   => 'nullable|file|mimes:pdf,doc,docx',
            'budgeting'  => 'nullable|file|mimes:pdf,doc,docx',
            'poster'     => 'nullable|file|mimes:jpeg,png,pdf',
            'other_data' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        // Logic update file
        if ($r->hasFile('proposal')) {
            if ($event->proposal) Storage::delete('public/proposals/' . $event->proposal);
            $data['proposal'] = $r->file('proposal')->store('proposals', 'public');
        }

        if ($r->hasFile('timeline')) {
            if ($event->timeline) Storage::delete('public/timelines/' . $event->timeline);
            $data['timeline'] = $r->file('timeline')->store('timelines', 'public');
        }

        if ($r->hasFile('budgeting')) {
            if ($event->budgeting) Storage::delete('public/budgeting/' . $event->budgeting);
            $data['budgeting'] = $r->file('budgeting')->store('budgeting', 'public');
        }

        if ($r->hasFile('poster')) {
            if ($event->poster) Storage::delete('public/posters/' . $event->poster);
            $data['poster'] = $r->file('poster')->store('posters', 'public');
        }

        if ($r->hasFile('other_data')) {
            if ($event->other_data) Storage::delete('public/other_data/' . $event->other_data);
            $data['other_data'] = $r->file('other_data')->store('other_data', 'public');
        }
        
        // Jika user mengupdate event, status bisa dikembalikan ke pending atau tetap (opsional)
        // Di sini kita biarkan statusnya tetap seperti sebelumnya
        $event->update($data);

        // Redirect ke Profile atau Index
        return redirect()->route('profile.show')->with('success', 'Event berhasil diperbarui.');
    }

    // Hapus event
    public function destroy(Event $event)
    {
        if ($event->proposal) Storage::delete('public/proposals/' . $event->proposal);
        if ($event->timeline) Storage::delete('public/timelines/' . $event->timeline);
        if ($event->budgeting) Storage::delete('public/budgeting/' . $event->budgeting);
        if ($event->poster) Storage::delete('public/posters/' . $event->poster);
        if ($event->other_data) Storage::delete('public/other_data/' . $event->other_data);

        $event->delete();

        return redirect()->back()->with('success', 'Event berhasil dihapus.');
    }

    public function timeline(Event $event)
    {
        $timelines = $event->timelines ?? collect();
        return view('events.timeline', compact('event', 'timelines'));
    }

    public function budget(Event $event)
    {
        $budgetItems = $event->budgetItems ?? collect();
        return view('events.budget', compact('event', 'budgetItems'));
    }

    public function files(Event $event)
    {
        $documents = $event->documents ?? collect();
        return view('events.files', compact('event', 'documents'));
    }

    // ------------------------------------------------------------------
    // PERUBAHAN 3: Pencarian
    // Hanya mencari event yang APPROVED
    // ------------------------------------------------------------------
    public function search(Request $request)
    {
        $keyword = $request->input('q');

        $events = Event::where('status', 'approved') // Filter Approved
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%");
            })
            ->orderBy('start_date', 'desc')
            ->get();

        return view('events.index', compact('events', 'keyword'));
    }

    // Update status oleh Admin
    public function updateStatus($eventId, $status)
    {
        $event = Event::findOrFail($eventId);
        $event->status = $status;
        $event->save();

        return redirect()->back()->with('success', 'Proposal telah di-' . $status);
    }
}