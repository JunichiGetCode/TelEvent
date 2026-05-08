@extends('layouts.app')

@section('title', 'Profil Saya - TelEVent')

@push('styles')
<style>
    :root { --red: #C60C30; }
    body { background: #F4F7FE; }

    .profile-hero {
        background: linear-gradient(135deg, var(--red) 0%, #A00926 60%, #1A1A2E 100%);
        padding: 60px 0 80px;
        color: white;
        border-radius: 0 0 40px 40px;
        margin-top: -24px;
        box-shadow: 0 10px 40px rgba(198,12,48,0.3);
        position: relative;
        overflow: hidden;
    }
    .profile-hero::before { content: ''; position: absolute; width: 500px; height: 500px; background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%); top: -200px; right: -100px; border-radius: 50%; }
    .profile-hero-content { position: relative; z-index: 1; }
    .profile-avatar-big { width: 110px; height: 110px; border-radius: 50%; border: 4px solid rgba(255,255,255,0.5); box-shadow: 0 10px 30px rgba(0,0,0,0.2); object-fit: cover; }
    .profile-name-h { font-size: 1.8rem; font-weight: 900; margin-top: 16px; }
    .profile-email-h { color: rgba(255,255,255,0.8); font-size: 0.95rem; }

    .profile-stats-row { margin-top: -50px; margin-bottom: 40px; }
    .stat-pill { background: #fff; border-radius: 16px; padding: 20px 24px; display: flex; align-items: center; gap: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.07); border: 1px solid rgba(0,0,0,0.03); height: 100%; transition: 0.3s; }
    .stat-pill:hover { transform: translateY(-4px); box-shadow: 0 15px 40px rgba(0,0,0,0.1); }
    .stat-pill-icon { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
    .stat-pill-icon.green { background: rgba(16,185,129,0.1); color: #10B981; }
    .stat-pill-icon.red { background: rgba(239,68,68,0.1); color: #EF4444; }
    .stat-pill-icon.orange { background: rgba(245,158,11,0.1); color: #F59E0B; }
    .stat-pill-num { font-size: 1.8rem; font-weight: 900; color: #1A1A2E; line-height: 1; }
    .stat-pill-label { font-size: 0.8rem; color: #64748B; font-weight: 600; margin-top: 4px; }

    .section-card { background: #fff; border-radius: 20px; padding: 28px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #F1F5F9; margin-bottom: 24px; }
    .section-card-title { font-size: 1rem; font-weight: 800; color: #1A1A2E; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
    .section-card-title i { color: var(--red); }
    .section-card-title a { color: var(--red); font-size: 0.85rem; margin-left: auto; text-decoration: none; font-weight: 600; }
    .section-card-title a:hover { text-decoration: underline; }

    .profile-info-item { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid #F8FAFC; }
    .profile-info-item:last-child { border-bottom: none; }
    .profile-info-icon { width: 36px; height: 36px; background: rgba(198,12,48,0.07); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 14px; color: var(--red); flex-shrink: 0; }
    .profile-info-label { font-size: 0.78rem; color: #94A3B8; font-weight: 600; letter-spacing: 0.5px; }
    .profile-info-value { font-size: 0.9rem; color: #1A1A2E; font-weight: 600; margin-top: 2px; }

    /* Event items */
    .event-item { display: flex; align-items: center; gap: 16px; padding: 14px 0; border-bottom: 1px solid #F8FAFC; transition: 0.2s; }
    .event-item:last-child { border-bottom: none; }
    .event-item:hover { background: #FAFBFF; margin: 0 -28px; padding-left: 28px; padding-right: 28px; border-radius: 12px; }
    .event-thumb { width: 56px; height: 56px; border-radius: 12px; object-fit: cover; flex-shrink: 0; }
    .event-thumb-placeholder { width: 56px; height: 56px; border-radius: 12px; background: #F1F5F9; display: flex; align-items: center; justify-content: center; color: #CBD5E1; flex-shrink: 0; }
    .event-item-title { font-weight: 700; color: #1A1A2E; font-size: 0.9rem; margin-bottom: 4px; }
    .event-item-meta { font-size: 0.78rem; color: #94A3B8; }
    .event-item-actions { margin-left: auto; display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
    .status-dot { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; }
    .dot-approved { background: rgba(16,185,129,0.1); color: #10B981; }
    .dot-rejected { background: rgba(239,68,68,0.1); color: #EF4444; }
    .dot-pending { background: rgba(245,158,11,0.1); color: #F59E0B; }
    .btn-view-ev { color: #3B82F6; background: rgba(59,130,246,0.1); border: none; border-radius: 8px; padding: 6px 12px; font-size: 0.78rem; font-weight: 600; text-decoration: none; transition: 0.2s; }
    .btn-view-ev:hover { background: #3B82F6; color: #fff; }

    .btn-edit-profile { display: inline-flex; align-items: center; gap: 8px; background: var(--red); color: #fff; border-radius: 50px; padding: 10px 24px; font-weight: 600; font-size: 0.875rem; text-decoration: none; transition: 0.3s; }
    .btn-edit-profile:hover { background: #A00926; transform: translateY(-2px); color: #fff; box-shadow: 0 8px 20px rgba(198,12,48,0.25); }

    .empty-events { text-align: center; padding: 40px; color: #CBD5E1; }
    .empty-events i { font-size: 2.5rem; display: block; margin-bottom: 12px; }
</style>
@endpush

@section('content')

<!-- HERO -->
<div class="profile-hero">
    <div class="container profile-hero-content text-center">
        @if(Auth::user()->avatar)
            <img src="{{ asset('storage/profile/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="profile-avatar-big">
        @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=C60C30&color=fff&size=200" alt="{{ Auth::user()->name }}" class="profile-avatar-big">
        @endif
        <div class="profile-name-h">{{ Auth::user()->name }}</div>
        <div class="profile-email-h">{{ Auth::user()->email }}</div>
        <div class="mt-3">
            <a href="{{ route('profile.edit') }}" class="btn-edit-profile">
                <i class="fa-solid fa-pen-to-square"></i> Edit Profil
            </a>
        </div>
    </div>
</div>

<div class="container pb-5">

    @if(session('success'))
    <div class="alert border-0 rounded-3 py-3 mb-4 d-flex align-items-center" style="background: rgba(16,185,129,0.1); color: #065F46;">
        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
    </div>
    @endif

    <!-- STATS -->
    <div class="profile-stats-row">
        <div class="row g-3">
            <div class="col-4">
                <div class="stat-pill">
                    <div class="stat-pill-icon green"><i class="fa-solid fa-check-circle"></i></div>
                    <div>
                        <div class="stat-pill-num">{{ $approved ?? 0 }}</div>
                        <div class="stat-pill-label">Disetujui</div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-pill">
                    <div class="stat-pill-icon red"><i class="fa-solid fa-times-circle"></i></div>
                    <div>
                        <div class="stat-pill-num">{{ $rejected ?? 0 }}</div>
                        <div class="stat-pill-label">Ditolak</div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-pill">
                    <div class="stat-pill-icon orange"><i class="fa-solid fa-hourglass-half"></i></div>
                    <div>
                        <div class="stat-pill-num">{{ $pending ?? 0 }}</div>
                        <div class="stat-pill-label">Menunggu</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <!-- PROFILE INFO -->
            <div class="section-card">
                <div class="section-card-title"><i class="fa-solid fa-user"></i> Info Pribadi</div>
                <div class="profile-info-item">
                    <div class="profile-info-icon"><i class="fa-solid fa-user"></i></div>
                    <div>
                        <div class="profile-info-label">NAMA LENGKAP</div>
                        <div class="profile-info-value">{{ Auth::user()->name }}</div>
                    </div>
                </div>
                <div class="profile-info-item">
                    <div class="profile-info-icon"><i class="fa-regular fa-envelope"></i></div>
                    <div>
                        <div class="profile-info-label">EMAIL</div>
                        <div class="profile-info-value">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="profile-info-item">
                    <div class="profile-info-icon"><i class="fa-solid fa-phone"></i></div>
                    <div>
                        <div class="profile-info-label">NO. TELEPON</div>
                        <div class="profile-info-value">{{ Auth::user()->phone ?? 'Belum diisi' }}</div>
                    </div>
                </div>
                <div class="profile-info-item">
                    <div class="profile-info-icon"><i class="fa-solid fa-shield"></i></div>
                    <div>
                        <div class="profile-info-label">PERAN</div>
                        <div class="profile-info-value" style="text-transform:capitalize;">{{ Auth::user()->role ?? 'Mahasiswa' }}</div>
                    </div>
                </div>
            </div>

            <a href="{{ route('events.create') }}" style="display:block; background: linear-gradient(135deg, var(--red), #A00926); color:#fff; border-radius:16px; padding:20px 24px; text-decoration:none; text-align:center; transition:0.3s; font-weight:700;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
                <i class="fa-solid fa-plus-circle fa-lg mb-2 d-block"></i>
                Ajukan Acara Baru
            </a>
        </div>

        <div class="col-lg-8">
            <!-- EVENTS LIST -->
            <div class="section-card">
                <div class="section-card-title">
                    <i class="fa-solid fa-list-check"></i> Riwayat Pengajuan Acara
                </div>

                @forelse($myEvents as $event)
                <div class="event-item">
                    @if($event->poster)
                        <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}" class="event-thumb">
                    @else
                        <div class="event-thumb-placeholder"><i class="fa-solid fa-image"></i></div>
                    @endif
                    <div style="flex:1; min-width:0;">
                        <div class="event-item-title">{{ Str::limit($event->title, 45) }}</div>
                        <div class="event-item-meta">
                            <i class="fa-regular fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($event->created_at)->format('d M Y') }}
                            &bull; <span style="color:var(--red); font-weight:600;">{{ $event->type }}</span>
                        </div>
                    </div>
                    <div class="event-item-actions">
                        @if($event->status == 'approved')
                            <span class="status-dot dot-approved"><i class="fa-solid fa-circle fa-xs"></i> Disetujui</span>
                        @elseif($event->status == 'rejected')
                            <span class="status-dot dot-rejected"><i class="fa-solid fa-circle fa-xs"></i> Ditolak</span>
                        @else
                            <span class="status-dot dot-pending"><i class="fa-solid fa-circle fa-xs"></i> Menunggu</span>
                        @endif
                        <a href="{{ route('events.show', $event->id) }}" class="btn-view-ev"><i class="fa-solid fa-eye me-1"></i>Lihat</a>
                    </div>
                </div>
                @empty
                <div class="empty-events">
                    <i class="fa-solid fa-calendar-plus"></i>
                    <p style="font-weight:600; margin:0 0 12px;">Belum ada pengajuan acara</p>
                    <a href="{{ route('events.create') }}" style="color:var(--red); font-weight:600; text-decoration:none;">Buat Acara Pertama →</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
