@extends('layouts.app')

@section('title', 'Dashboard - TelEVent')

@push('styles')
<style>
    :root { --telu-red: #C60C30; --telu-red-dark: #A00926; }
    .hero-section {
        background: linear-gradient(135deg, var(--telu-red) 0%, var(--telu-red-dark) 50%, #1A1A2E 100%);
        padding: 70px 0 80px;
        color: white;
        border-radius: 0 0 40px 40px;
        margin-top: -24px;
        box-shadow: 0 10px 40px rgba(198,12,48,0.3);
        margin-bottom: 0;
        position: relative;
        overflow: hidden;
    }
    .hero-section::before { content: ''; position: absolute; width: 600px; height: 600px; background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%); top: -200px; right: -200px; border-radius: 50%; }
    .greeting-text { font-size: 1.05rem; color: rgba(255,255,255,0.8); margin-bottom: 8px; }
    .greeting-name { font-size: 2.5rem; font-weight: 900; margin-bottom: 12px; line-height: 1.2; }
    .greeting-name span { color: #FFD700; }
    .greeting-sub { font-size: 1rem; opacity: 0.85; }
    .quick-actions { display: flex; gap: 12px; margin-top: 30px; flex-wrap: wrap; }
    .btn-qa { border-radius: 50px; padding: 12px 28px; font-weight: 600; font-size: 0.95rem; transition: 0.3s; }
    .btn-qa-primary { background: #fff; color: var(--telu-red); border: none; }
    .btn-qa-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
    .btn-qa-outline { background: transparent; color: #fff; border: 2px solid rgba(255,255,255,0.5); }
    .btn-qa-outline:hover { background: rgba(255,255,255,0.15); border-color: #fff; }

    /* STATS ROW */
    .stats-row { margin-top: -50px; margin-bottom: 50px; }
    .stat-card {
        background: #fff; border-radius: 20px; padding: 30px 25px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.08);
        display: flex; align-items: center; gap: 20px;
        border: 1px solid rgba(0,0,0,0.03);
        transition: 0.3s; height: 100%;
    }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 20px 50px rgba(0,0,0,0.12); }
    .stat-icon { width: 64px; height: 64px; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 26px; flex-shrink: 0; }
    .stat-icon.pending { background: rgba(245,158,11,0.1); color: #F59E0B; }
    .stat-icon.approved { background: rgba(16,185,129,0.1); color: #10B981; }
    .stat-number { font-size: 2.2rem; font-weight: 900; color: #1A1A2E; line-height: 1; margin-bottom: 6px; }
    .stat-label { font-size: 0.875rem; color: #64748B; font-weight: 500; }

    /* EVENTS */
    .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 25px; }
    .section-title { font-size: 1.5rem; font-weight: 800; color: #1A1A2E; margin: 0; display: flex; align-items: center; gap: 10px; }
    .section-title::before { content: ''; display: inline-block; width: 5px; height: 24px; background: var(--telu-red); border-radius: 10px; }

    .events-scroll-wrapper { display: flex; gap: 20px; overflow-x: auto; padding-bottom: 20px; scrollbar-width: none; cursor: grab; }
    .events-scroll-wrapper::-webkit-scrollbar { display: none; }
    .events-scroll-wrapper:active { cursor: grabbing; }

    .event-card-slide { width: 260px; flex-shrink: 0; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 30px rgba(0,0,0,0.06); transition: 0.3s; border: 1px solid rgba(0,0,0,0.04); position: relative; }
    .event-card-slide:hover { transform: translateY(-8px); box-shadow: 0 20px 50px rgba(0,0,0,0.1); }
    .event-img { width: 100%; height: 180px; object-fit: cover; }
    .event-img-placeholder { width: 100%; height: 180px; background: #F1F5F9; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94A3B8; }
    .event-category { position: absolute; top: 12px; left: 12px; background: rgba(198,12,48,0.9); backdrop-filter: blur(10px); color: #fff; border-radius: 50px; padding: 4px 12px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px; }
    .event-body { padding: 18px; }
    .event-title-slide { font-weight: 700; font-size: 0.95rem; color: #1A1A2E; margin-bottom: 8px; line-height: 1.4; }
    .event-date-slide { font-size: 0.82rem; color: #64748B; display: flex; align-items: center; gap: 6px; }

    .empty-state { text-align: center; padding: 60px 20px; background: #fff; border-radius: 20px; border: 2px dashed #E5E7EB; }
    .empty-state i { font-size: 3rem; color: #CBD5E1; margin-bottom: 16px; }
    .empty-state h5 { font-weight: 700; color: #94A3B8; margin-bottom: 8px; }
    .empty-state p { color: #CBD5E1; font-size: 0.9rem; }
</style>
@endpush

@section('content')

<!-- HERO -->
<section class="hero-section">
    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="greeting-text"><i class="fa-solid fa-sun text-warning me-2"></i>Selamat datang kembali,</div>
                <div class="greeting-name">Halo, <span>{{ Auth::user()->name }}</span>! 👋</div>
                <div class="greeting-sub">Pantau dan kelola acara Anda melalui dashboard ini.</div>
                <div class="quick-actions">
                    <a href="{{ route('events.create') }}" class="btn btn-qa btn-qa-primary">
                        <i class="fa-solid fa-plus me-2"></i>Buat Acara Baru
                    </a>
                    <a href="{{ route('profile.show') }}" class="btn btn-qa btn-qa-outline">
                        <i class="fa-solid fa-user me-2"></i>Profil Saya
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <i class="fa-solid fa-calendar-star" style="font-size:8rem; opacity:0.15;"></i>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <!-- STATS -->
    <div class="stats-row">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="stat-card">
                    <div class="stat-icon pending"><i class="fa-solid fa-hourglass-half"></i></div>
                    <div>
                        <div class="stat-number">{{ $pendingCount ?? 0 }}</div>
                        <div class="stat-label">Acara Sedang Ditinjau</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-card">
                    <div class="stat-icon approved"><i class="fa-solid fa-calendar-check"></i></div>
                    <div>
                        <div class="stat-number">{{ $ongoingCount ?? 0 }}</div>
                        <div class="stat-label">Acara Sedang Berjalan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- UPCOMING EVENTS -->
    <div class="mb-5">
        <div class="section-header">
            <h2 class="section-title">Acara yang Akan Datang</h2>
            <a href="{{ route('events.index') }}" style="color:var(--telu-red); text-decoration:none; font-weight:600; font-size:0.9rem;">
                Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        @if(isset($upcomingEvents) && count($upcomingEvents) > 0)
            <div class="events-scroll-wrapper" id="scrollContainer">
                @foreach($upcomingEvents as $event)
                <div class="event-card-slide">
                    <span class="event-category">{{ $event->type }}</span>
                    @if($event->poster)
                        <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}" class="event-img">
                    @else
                        <div class="event-img-placeholder">
                            <i class="fa-solid fa-image fa-2x mb-2"></i>
                            <span style="font-size:0.8rem;">Tidak Ada Poster</span>
                        </div>
                    @endif
                    <div class="event-body">
                        <div class="event-title-slide">{{ Str::limit($event->title, 45) }}</div>
                        <div class="event-date-slide">
                            <i class="fa-regular fa-calendar text-danger"></i>
                            {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fa-solid fa-calendar-xmark"></i>
                <h5>Belum Ada Acara</h5>
                <p>Belum ada acara yang akan datang saat ini.</p>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let sc = document.getElementById('scrollContainer');
        if (!sc) return;
        let isDragging = false, startX, scrollLeft, autoScroll, amount = 0;
        sc.addEventListener('mousedown', e => { isDragging = true; startX = e.pageX - sc.offsetLeft; scrollLeft = sc.scrollLeft; sc.style.cursor = 'grabbing'; clearInterval(autoScroll); });
        sc.addEventListener('mouseup', () => { isDragging = false; sc.style.cursor = 'grab'; startAutoScroll(); });
        sc.addEventListener('mouseleave', () => { isDragging = false; sc.style.cursor = 'grab'; });
        sc.addEventListener('mousemove', e => { if (!isDragging) return; e.preventDefault(); const x = e.pageX - sc.offsetLeft; sc.scrollLeft = scrollLeft - (x - startX) * 1.5; amount = sc.scrollLeft; });
        function startAutoScroll() {
            if (sc.scrollWidth <= sc.clientWidth) return;
            autoScroll = setInterval(() => {
                if (isDragging) return;
                if (sc.scrollLeft >= sc.scrollWidth - sc.clientWidth - 1) { sc.scrollLeft = 0; amount = 0; }
                else { amount += 0.8; sc.scrollLeft = amount; }
            }, 20);
        }
        startAutoScroll();
    });
</script>
@endpush
