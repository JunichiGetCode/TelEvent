@extends('layouts.app')

@section('title', 'Semua Acara - TelEVent')

@push('styles')
<style>
    :root { --telu-red: #C60C30; }

    .page-hero {
        background: linear-gradient(135deg, var(--telu-red) 0%, #A00926 60%, #1A1A2E 100%);
        padding: 70px 0;
        color: white;
        border-radius: 0 0 40px 40px;
        margin-top: -24px;
        margin-bottom: 50px;
        text-align: center;
        box-shadow: 0 10px 40px rgba(198,12,48,0.25);
        position: relative;
        overflow: hidden;
    }
    .page-hero::before { content: ''; position: absolute; width: 600px; height: 600px; background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%); top: -200px; right: -200px; border-radius: 50%; }
    .page-hero h1 { font-size: 2.8rem; font-weight: 900; margin-bottom: 12px; }
    .page-hero p { opacity: 0.9; font-size: 1.1rem; }

    .filter-bar {
        background: #fff;
        border-radius: 20px;
        padding: 24px 28px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.06);
        margin-bottom: 40px;
        border: 1px solid #F1F5F9;
    }
    .form-label { font-weight: 600; color: #374151; font-size: 0.85rem; margin-bottom: 8px; }
    .form-select, .form-control { border: 2px solid #E5E7EB; border-radius: 12px; padding: 11px 16px; transition: 0.3s; font-size: 0.95rem; }
    .form-select:focus, .form-control:focus { border-color: var(--telu-red); box-shadow: 0 0 0 4px rgba(198,12,48,0.1); }

    .events-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px; }

    .event-card {
        background: #fff; border-radius: 20px; overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        transition: 0.4s;
        display: flex; flex-direction: column;
        border: 1px solid #F1F5F9;
    }
    .event-card:hover { transform: translateY(-10px); box-shadow: 0 20px 60px rgba(0,0,0,0.1); }

    .event-img-wrap { height: 220px; position: relative; overflow: hidden; }
    .event-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .event-card:hover .event-img-wrap img { transform: scale(1.08); }
    .event-img-placeholder { width: 100%; height: 100%; background: linear-gradient(135deg, #F1F5F9, #E2E8F0); display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94A3B8; }

    .event-badge {
        position: absolute; top: 14px; left: 14px;
        background: rgba(198,12,48,0.95); backdrop-filter: blur(10px);
        color: #fff; border-radius: 50px; padding: 5px 14px;
        font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;
    }

    .event-body { padding: 22px; flex-grow: 1; display: flex; flex-direction: column; }
    .event-name { font-size: 1.1rem; font-weight: 700; color: #1A1A2E; margin-bottom: 10px; line-height: 1.4; }
    .event-date { font-size: 0.875rem; color: #64748B; display: flex; align-items: center; gap: 8px; margin-bottom: auto; }

    .empty-state { grid-column: 1/-1; text-align: center; padding: 80px 20px; background: #fff; border-radius: 20px; border: 2px dashed #E2E8F0; }
    .empty-state i { font-size: 3.5rem; color: #CBD5E1; margin-bottom: 20px; }
    .results-info { font-size: 0.9rem; color: #64748B; margin-bottom: 20px; }
</style>
@endpush

@section('content')
<div class="page-hero">
    <div class="container position-relative" style="z-index:1;">
        <h1><i class="fa-solid fa-calendar-days me-3"></i>Semua Acara</h1>
        <p>Temukan dan ikuti berbagai acara menarik di Telkom University</p>
    </div>
</div>

<div class="container mb-5">

    @if(session('success'))
    <div class="alert border-0 rounded-3 py-3 mb-4 d-flex align-items-center" style="background: rgba(16,185,129,0.1); color: #065F46;">
        <i class="fa-solid fa-circle-check fs-5 me-2"></i> {{ session('success') }}
    </div>
    @endif

    <!-- FILTER BAR -->
    <div class="filter-bar">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Kategori Acara</label>
                <select id="category" class="form-select">
                    <option value="all">🎯 Semua Kategori</option>
                    <option value="Exhibition">🏛 Exhibition</option>
                    <option value="Festival">🎪 Festival</option>
                    <option value="Lomba">🏆 Lomba</option>
                    <option value="Seminar">📚 Seminar</option>
                    <option value="Webinar">💻 Webinar</option>
                </select>
            </div>
            <div class="col-md-8">
                <label class="form-label">Cari Acara</label>
                <div class="position-relative">
                    <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left:15px; top:50%; transform:translateY(-50%); pointer-events:none;"></i>
                    <input type="text" id="search" class="form-control" style="padding-left:45px;" placeholder="Ketik nama acara...">
                </div>
            </div>
        </div>
    </div>

    @if(isset($keyword) && $keyword)
        <p class="results-info">Hasil pencarian untuk: <strong>"{{ $keyword }}"</strong></p>
    @endif

    <div class="events-grid" id="eventsGrid">
        @forelse($events as $event)
            <div class="event-card" data-category="{{ $event->type }}">
                <div class="event-img-wrap">
                    <span class="event-badge">{{ $event->type }}</span>
                    @if($event->poster)
                        <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}">
                    @else
                        <div class="event-img-placeholder">
                            <i class="fa-solid fa-image fa-2x mb-2"></i>
                            <span style="font-size:0.8rem;">Tidak Ada Poster</span>
                        </div>
                    @endif
                </div>
                <div class="event-body">
                    <h3 class="event-name">{{ $event->title }}</h3>
                    <div class="event-date">
                        <i class="fa-regular fa-calendar text-danger"></i>
                        {{ \Carbon\Carbon::parse($event->start_date)->format('d F Y') }}
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fa-solid fa-folder-open d-block"></i>
                <h4 style="font-weight:700; color:#94A3B8;">Belum Ada Acara</h4>
                <p style="color:#CBD5E1;">Belum ada acara yang tersedia saat ini. Silakan kembali lagi nanti.</p>
            </div>
        @endforelse
    </div>

    @if(method_exists($events, 'links'))
    <div class="mt-5 d-flex justify-content-center">
        {{ $events->links() }}
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const categoryFilter = document.getElementById('category');
    const searchInput = document.getElementById('search');

    function filterEvents() {
        const cat = categoryFilter.value;
        const term = searchInput.value.toLowerCase();
        document.querySelectorAll('.event-card').forEach(el => {
            const matchCat = cat === 'all' || el.dataset.category === cat;
            const matchSearch = el.querySelector('.event-name').textContent.toLowerCase().includes(term);
            el.style.display = (matchCat && matchSearch) ? 'flex' : 'none';
        });
    }

    categoryFilter.addEventListener('change', filterEvents);
    searchInput.addEventListener('input', filterEvents);
</script>
@endpush
