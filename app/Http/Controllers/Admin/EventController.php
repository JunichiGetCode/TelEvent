<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return view('admin.events.index', compact('events'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

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
            'poster'     => 'nullable|file|mimes:jpeg,png,pdf,jpg',
            'other_data' => 'nullable|file|mimes:pdf,doc,docx',
            'status'     => 'required|in:pending,approved,rejected',
        ]);

        if ($r->hasFile('proposal')) {
            if ($event->proposal) Storage::delete('public/' . $event->proposal);
            $data['proposal'] = $r->file('proposal')->store('proposals', 'public');
        }

        if ($r->hasFile('timeline')) {
            if ($event->timeline) Storage::delete('public/' . $event->timeline);
            $data['timeline'] = $r->file('timeline')->store('timelines', 'public');
        }

        if ($r->hasFile('budgeting')) {
            if ($event->budgeting) Storage::delete('public/' . $event->budgeting);
            $data['budgeting'] = $r->file('budgeting')->store('budgeting', 'public');
        }

        if ($r->hasFile('poster')) {
            if ($event->poster) Storage::delete('public/' . $event->poster);
            $data['poster'] = $r->file('poster')->store('posters', 'public');
        }

        if ($r->hasFile('other_data')) {
            if ($event->other_data) Storage::delete('public/' . $event->other_data);
            $data['other_data'] = $r->file('other_data')->store('other_data', 'public');
        }
        
        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->proposal) Storage::delete('public/' . $event->proposal);
        if ($event->timeline) Storage::delete('public/' . $event->timeline);
        if ($event->budgeting) Storage::delete('public/' . $event->budgeting);
        if ($event->poster) Storage::delete('public/' . $event->poster);
        if ($event->other_data) Storage::delete('public/' . $event->other_data);

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }

    public function updateStatus($eventId, $status)
    {
        $event = Event::findOrFail($eventId);
        $event->status = $status;
        $event->save();

        return redirect()->back()->with('success', 'Proposal telah di-' . $status);
    }
}
