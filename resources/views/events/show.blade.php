@extends('layouts.app')

@section('title', '{{ $event->title }} - TelEVent')

@push('styles')
<style>
    :root { --red: #C60C30; }
    .event-hero {
        background: linear-gradient(135deg, #1A1A2E 0%, #A00926 50%, var(--red) 100%);
        padding: 60px 0;
        color: white;
        border-radius: 0 0 40px 40px;
        margin-top: -24px;
        box-shadow: 0 10px 40px rgba(198,12,48,0.3);
        margin-bottom: 50px;
        position: relative;
        overflow: hidden;
    }
    .event-hero::before { content: ''; position: absolute; width: 600px; height: 600px; background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%); top: -200px; right: -200px; border-radius: 50%; }
    .event-type-badge { display: inline-block; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); color: #fff; border-radius: 50px; padding: 6px 18px; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 16px; }
    .event-title-h { font-size: 2.5rem; font-weight: 900; margin-bottom: 16px; line-height: 1.2; }
    .event-meta-row { display: flex; gap: 24px; flex-wrap: wrap; }
    .event-meta-item { display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.85); font-size: 0.9rem; }

    .detail-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-bottom: 50px; }
    @media (max-width: 768px) { .detail-grid { grid-template-columns: 1fr; } }

    .detail-card { background: #fff; border-radius: 20px; padding: 30px; box-shadow: 0 8px 30px rgba(0,0,0,0.05); border: 1px solid #F1F5F9; }
    .detail-card-title { font-size: 1rem; font-weight: 800; color: #1A1A2E; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1px solid #F1F5F9; display: flex; align-items: center; gap: 10px; }
    .detail-card-title i { color: var(--red); }

    .info-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #F8FAFC; align-items: flex-start; }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-size: 0.82rem; font-weight: 600; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.5px; }
    .info-value { font-size: 0.9rem; font-weight: 600; color: #1A1A2E; text-align: right; max-width: 200px; }

    .status-badge { padding: 6px 14px; border-radius: 50px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; }
    .status-approved { background: rgba(16,185,129,0.1); color: #10B981; }
    .status-rejected { background: rgba(239,68,68,0.1); color: #EF4444; }
    .status-pending { background: rgba(245,158,11,0.1); color: #F59E0B; }

    .doc-btn { display: flex; align-items: center; gap: 12px; padding: 14px 16px; border-radius: 12px; border: 2px solid #E5E7EB; background: #fff; color: #1A1A2E; text-decoration: none; transition: 0.3s; font-weight: 600; font-size: 0.875rem; margin-bottom: 10px; }
    .doc-btn:hover { border-color: var(--red); color: var(--red); background: rgba(198,12,48,0.03); transform: translateX(4px); }
    .doc-btn .doc-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
    .doc-icon.pdf { background: rgba(239,68,68,0.1); color: #EF4444; }
    .doc-icon.img { background: rgba(59,130,246,0.1); color: #3B82F6; }
    .doc-icon.file { background: rgba(16,185,129,0.1); color: #10B981; }

    .admin-action-bar { background: linear-gradient(135deg, #1A1A2E, #2D2D44); border-radius: 16px; padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px; flex-wrap: wrap; gap: 12px; }
    .admin-action-label { color: rgba(255,255,255,0.8); font-size: 0.9rem; font-weight: 500; }
    .admin-action-label strong { color: #fff; }
    .admin-btns { display: flex; gap: 10px; }
    .btn-approve { background: #10B981; color: #fff; border: none; padding: 10px 24px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.3s; font-family: inherit; font-size: 0.875rem; }
    .btn-approve:hover { background: #059669; }
    .btn-reject-action { background: rgba(239,68,68,0.15); color: #F87171; border: 1px solid rgba(239,68,68,0.2); padding: 10px 24px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.3s; font-family: inherit; font-size: 0.875rem; }
    .btn-reject-action:hover { background: rgba(239,68,68,0.3); }
    .btn-edit-ev { background: rgba(245,158,11,0.15); color: #F59E0B; border: 1px solid rgba(245,158,11,0.2); padding: 10px 20px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.3s; font-family: inherit; font-size: 0.875rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .btn-edit-ev:hover { background: rgba(245,158,11,0.3); color: #F59E0B; }
    .btn-back-link { display: inline-flex; align-items: center; gap: 8px; color: #64748B; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: 0.2s; }
    .btn-back-link:hover { color: var(--red); }
</style>
@endpush

@section('content')
<!-- HERO -->
<div class="event-hero">
    <div class="container position-relative" style="z-index:1;">
        <span class="event-type-badge"><i class="fa-solid fa-tag me-2"></i>{{ $event->type }}</span>
        <h1 class="event-title-h">{{ $event->title }}</h1>
        <div class="event-meta-row">
            <div class="event-meta-item"><i class="fa-solid fa-user"></i> {{ $event->user->name ?? 'Tidak diketahui' }}</div>
            @if($event->start_date)
            <div class="event-meta-item"><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($event->start_date)->format('d F Y') }}</div>
            @endif
            <div class="event-meta-item"><i class="fa-solid fa-clock-rotate-left"></i> Diajukan {{ $event->created_at->diffForHumans() }}</div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <a href="{{ url()->previous() }}" class="btn-back-link mb-4 d-inline-flex">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>

    @if(auth()->check() && auth()->user()->role == 'admin')
    <div class="admin-action-bar">
        <div class="admin-action-label">Panel Admin: <strong>Tinjau Proposal ini</strong></div>
        <div class="admin-btns">
            <a href="{{ route('admin.events.edit', $event->id) }}" class="btn-edit-ev"><i class="fa-solid fa-pen"></i>Edit</a>
            <form action="{{ route('admin.event.status', ['id' => $event->id, 'status' => 'approved']) }}" method="POST" style="display:inline">
                @csrf <button type="submit" class="btn-approve"><i class="fa-solid fa-check me-2"></i>Setujui</button>
            </form>
            <form action="{{ route('admin.event.status', ['id' => $event->id, 'status' => 'rejected']) }}" method="POST" style="display:inline">
                @csrf <button type="submit" class="btn-reject-action"><i class="fa-solid fa-xmark me-2"></i>Tolak</button>
            </form>
        </div>
    </div>
    @endif

    <div class="detail-grid">
        <!-- LEFT: Info -->
        <div>
            <div class="detail-card mb-4">
                <div class="detail-card-title"><i class="fa-solid fa-circle-info"></i> Informasi Acara</div>
                <div class="info-row">
                    <span class="info-label">Judul Acara</span>
                    <span class="info-value">{{ $event->title }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jenis</span>
                    <span class="info-value">{{ $event->type }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Penyelenggara</span>
                    <span class="info-value">{{ $event->user->name ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Mulai</span>
                    <span class="info-value">{{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->format('d M Y') : '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Selesai</span>
                    <span class="info-value">{{ $event->end_date ? \Carbon\Carbon::parse($event->end_date)->format('d M Y') : '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Pengajuan</span>
                    <span class="info-value">{{ $event->created_at->format('d M Y, H:i') }} WIB</span>
                </div>
                @if($event->description)
                <div class="info-row" style="flex-direction:column; align-items:flex-start; gap:8px;">
                    <span class="info-label">Deskripsi</span>
                    <p style="color:#64748B; line-height:1.7; font-size:0.9rem; margin:0;">{{ $event->description }}</p>
                </div>
                @endif
            </div>

            <!-- DOKUMEN -->
            <div class="detail-card">
                <div class="detail-card-title"><i class="fa-solid fa-folder-open"></i> Dokumen Pendukung</div>
                @if($event->proposal)
                    <a href="{{ asset('storage/' . $event->proposal) }}" target="_blank" class="doc-btn">
                        <div class="doc-icon pdf"><i class="fa-solid fa-file-pdf"></i></div>
                        <div><div style="font-weight:700;">Proposal</div><div style="font-size:0.78rem; color:#94A3B8;">Klik untuk membuka</div></div>
                        <i class="fa-solid fa-external-link ms-auto" style="color:#CBD5E1;"></i>
                    </a>
                @endif
                @if($event->timeline)
                    <a href="{{ asset('storage/' . $event->timeline) }}" target="_blank" class="doc-btn">
                        <div class="doc-icon file"><i class="fa-solid fa-calendar-lines"></i></div>
                        <div><div style="font-weight:700;">Timeline</div><div style="font-size:0.78rem; color:#94A3B8;">Klik untuk membuka</div></div>
                        <i class="fa-solid fa-external-link ms-auto" style="color:#CBD5E1;"></i>
                    </a>
                @endif
                @if($event->budgeting)
                    <a href="{{ asset('storage/' . $event->budgeting) }}" target="_blank" class="doc-btn">
                        <div class="doc-icon file"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                        <div><div style="font-weight:700;">Budgeting</div><div style="font-size:0.78rem; color:#94A3B8;">Klik untuk membuka</div></div>
                        <i class="fa-solid fa-external-link ms-auto" style="color:#CBD5E1;"></i>
                    </a>
                @endif
                @if($event->other_data)
                    <a href="{{ asset('storage/' . $event->other_data) }}" target="_blank" class="doc-btn">
                        <div class="doc-icon file"><i class="fa-solid fa-folder"></i></div>
                        <div><div style="font-weight:700;">Data Lainnya</div><div style="font-size:0.78rem; color:#94A3B8;">Klik untuk membuka</div></div>
                        <i class="fa-solid fa-external-link ms-auto" style="color:#CBD5E1;"></i>
                    </a>
                @endif
                @if(!$event->proposal && !$event->timeline && !$event->budgeting && !$event->other_data)
                    <p style="text-align:center; color:#CBD5E1; padding: 20px 0; font-size:0.9rem;">Tidak ada dokumen yang dilampirkan.</p>
                @endif
            </div>
        </div>

        <!-- RIGHT: Status & Poster -->
        <div>
            <div class="detail-card mb-4">
                <div class="detail-card-title"><i class="fa-solid fa-signal"></i> Status Pengajuan</div>
                @if($event->status == 'approved')
                    <div class="text-center py-3">
                        <div style="font-size:3rem; margin-bottom:10px;">✅</div>
                        <span class="status-badge status-approved" style="font-size:1rem; padding: 10px 24px;"><i class="fa-solid fa-circle-check"></i> Disetujui</span>
                        <p style="color:#64748B; font-size:0.85rem; margin-top:12px;">Proposal telah disetujui oleh Admin.</p>
                    </div>
                @elseif($event->status == 'rejected')
                    <div class="text-center py-3">
                        <div style="font-size:3rem; margin-bottom:10px;">❌</div>
                        <span class="status-badge status-rejected" style="font-size:1rem; padding: 10px 24px;"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>
                        <p style="color:#64748B; font-size:0.85rem; margin-top:12px;">Proposal tidak disetujui oleh Admin.</p>
                    </div>
                @else
                    <div class="text-center py-3">
                        <div style="font-size:3rem; margin-bottom:10px;">⏳</div>
                        <span class="status-badge status-pending" style="font-size:1rem; padding: 10px 24px;"><i class="fa-solid fa-hourglass-half"></i> Menunggu</span>
                        <p style="color:#64748B; font-size:0.85rem; margin-top:12px;">Proposal sedang dalam proses peninjauan.</p>
                    </div>
                @endif
            </div>

            @if($event->poster)
            <div class="detail-card">
                <div class="detail-card-title"><i class="fa-solid fa-image"></i> Poster Acara</div>
                <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster {{ $event->title }}" style="width:100%; border-radius:12px; object-fit:cover; max-height:350px;">
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
