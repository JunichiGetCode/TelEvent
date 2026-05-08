@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')

{{-- CSS KHUSUS HALAMAN DASHBOARD --}}
<style>
    :root {
        --red-light: #D2042D;
        --red-mid:   #A8092D;
        --red-dark:  #450C1C;
        --bg-soft:   #FFF5F6;
    }

    /* Mengatur background halaman spesifik ini */
    body {
        background-color: var(--bg-soft);
    }

    .page-shell {
        max-width: 98%; 
        margin: 0 auto; 
        background: white;
        padding: 3rem 1rem; 
        border-radius: 30px; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        min-height: 80vh;
    }

    .content-container {
        max-width: 1180px; margin: 0 auto; padding: 0 15px;
    }

    /* Banner Styling */
    .banner {
        /* Fallback color jika gambar tidak ada */
        background-color: #A8092D; 
        
        /* Mengambil gambar dari storage */
        background-image: url("{{ asset('storage/banner/Banner-1.jpeg') }}");
        
        background-size: cover; 
        background-position: center center; 
        background-repeat: no-repeat;
        padding: 80px 20px; 
        border-radius: 20px; 
        color: white;
        position: relative;
        overflow: hidden;
    }

    /* Overlay agar teks lebih terbaca di atas gambar */
    .banner::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(168, 9, 45, 0.1); /* Overlay Merah Transparan */
        z-index: 1;
    }

    .banner-content {
        position: relative;
        z-index: 2; /* Agar teks muncul di atas overlay */
    }

    .hero-section {
        text-align: center; 
        border-bottom: 1px solid #f0dce0;
        padding-bottom: 2rem; 
        margin-bottom: 3rem;
    }

    .hero-title { font-size: 2.8rem; font-weight: 800; color: white; margin-bottom: 1rem; text-shadow: 0 2px 4px rgba(0,0,0,0.2); }
    .hero-subtitle { color: rgba(255,255,255,0.95); max-width: 500px; margin: 0 auto 2rem auto; font-size: 1.1rem; }

    .btn-event {
        background-color: #D2042D; color: white; border-radius: 50px;
        padding: 12px 35px; font-weight: bold; border: 2px solid white; 
        transition: 0.3s; text-decoration: none; display: inline-block;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .btn-event:hover { background: white; color: #D2042D; border: 2px solid white; transform: translateY(-2px); }

    /* Info Panel (Stats) */
    .hero-panel {
        background: white; border-radius: 20px; border: 2px solid #F4D7DD;
        padding: 2rem; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); 
        height: 100%;
        display: flex; flex-direction: column; justify-content: center; align-items: center;
        transition: transform 0.3s ease;
    }
    .hero-panel:hover { transform: translateY(-5px); border-color: #D2042D; }

    .hero-panel strong {
        font-size: 3.5rem; color: #D2042D; display: block; margin-bottom: 5px; line-height: 1;
    }
    .hero-panel span { font-size: 1.2rem; color: #666; font-weight: 500; }
    .hero-panel i { font-size: 2rem; color: #D2042D; opacity: 0.2; margin-bottom: 15px; }

    /* Upcoming Events Scroll */
    .upcoming-events-container {
        display: flex; flex-direction: row; overflow-x: auto; gap: 20px;
        margin-top: 1rem; padding-bottom: 20px; 
        border-radius: 10px; padding: 10px 5px; max-width: 100%;
        scrollbar-width: none; /* Hide scrollbar Firefox */
    }
    .upcoming-events-container::-webkit-scrollbar { display: none; /* Hide scrollbar Chrome */ }

    .event-card {
        width: 260px; height: 380px; background-color: #fff;
        border-radius: 20px; text-align: center; flex-shrink: 0;
        overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        position: relative; transition: transform 0.3s;
        border: 1px solid #eee;
    }
    .event-card:hover { transform: scale(1.02); }

    .event-card img { width: 100%; height: 100%; object-fit: cover; }
    
    .event-title-overlay {
        position: absolute; bottom: 0; left: 0; width: 100%;
        background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
        color: white; padding: 20px 15px; text-align: left;
    }
    .event-title-overlay h5 { font-size: 18px; margin: 0; font-weight: bold; line-height: 1.3; }
    .event-title-overlay span { font-size: 12px; opacity: 0.8; }

</style>

{{-- KONTEN DASHBOARD --}}
<div class="page-shell">
    
    <div class="content-container">

        {{-- HERO SECTION --}}
        <section class="hero-section">
            <div class="banner">
                <div class="banner-content">
                    <h1 class="hero-title">
                        Bangun dan kelola <br> Acara-mu Dengan Mudah!
                    </h1>

                    <p class="hero-subtitle">
                        Platform satu pintu untuk mahasiswa Telkom University. <br>
                        Kelola acara dengan sistem terstruktur, profesional, dan efisien.
                    </p>

                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <a href="{{ route('events.create') }}" class="btn btn-event"><i class="fas fa-edit me-2"></i> 📝Buat Acara</a>
                        <a href="{{ route('events.index') }}" class="btn btn-event"><i class="fas fa-search me-2"></i> 🔎Cari Acara</a>
                    </div>
                </div>
            </div>
        </section>


        {{-- RINGKASAN STATISTIK --}}
        <div class="row g-4 text-center mb-5">
            <div class="col-md-6">
                <div class="hero-panel">
                    <i class="fas fa-hourglass-half"></i>
                    <strong>{{ $pendingCount ?? 0 }}</strong> 
                    <span>Acara Sedang Ditinjau</span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="hero-panel">
                    <i class="fas fa-running"></i>
                    <strong>{{ $ongoingCount ?? 0 }}</strong> 
                    <span>Acara Sedang Berjalan</span>
                </div>
            </div>
        </div>

        {{-- ACARA YANG AKAN DATANG --}}
        <div class="mt-5">
            <h3 class="fw-bold mb-3 border-start border-4 border-danger ps-3" style="color: #A8092D;">
                Acara yang Akan Datang
            </h3>

            <div class="upcoming-events-container" id="scrollContainer">
                
                @if(isset($upcomingEvents) && count($upcomingEvents) > 0)
                    @foreach($upcomingEvents as $event)
                    <div class="event-card">
                        {{-- LINK DIHAPUS, HANYA MENAMPILKAN GAMBAR DAN TEXT --}}
                        @if($event->poster)
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}">
                        @else
                            <div style="width:100%; height:100%; background:#f8f9fa; display:flex; align-items:center; justify-content:center; color:#ccc;">
                                <i class="fas fa-image fa-3x"></i>
                            </div>
                        @endif

                        <div class="event-title-overlay">
                            <h5>{{ Str::limit($event->title, 40) }}</h5>
                            <span><i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="w-100 text-center py-5 rounded-4" style="background: #fdfdfd; border: 2px dashed #eee;">
                        <i class="fas fa-calendar-times fa-3x mb-3 text-muted"></i>
                        <h5 class="text-muted">Belum ada acara yang akan datang.</h5>
                    </div>
                @endif

            </div>
        </div>

    </div>

</div>

{{-- SCRIPT SCROLL OTOMATIS --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let scrollContainer = document.getElementById('scrollContainer');
        
        // Cek jika container ada isinya
        if(scrollContainer) {
            let scrollAmount = 0;
            let isHovering = false;

            scrollContainer.addEventListener('mouseenter', () => isHovering = true);
            scrollContainer.addEventListener('mouseleave', () => isHovering = false);

            function scrollAutomatically() {
                if (!isHovering) {
                    // Jika sudah mentok kanan, balik ke 0
                    if (scrollContainer.scrollLeft >= (scrollContainer.scrollWidth - scrollContainer.clientWidth - 1)) {
                        scrollAmount = 0;
                        scrollContainer.scrollLeft = 0;
                    } else {
                        scrollAmount += 1; // Kecepatan scroll
                        scrollContainer.scrollLeft = scrollAmount;
                    }
                } else {
                    // Update posisi scrollAmount saat user manual scroll agar tidak loncat saat mouse leave
                    scrollAmount = scrollContainer.scrollLeft;
                }
            }

            // Jalankan interval hanya jika konten melebihi lebar container
            if (scrollContainer.scrollWidth > scrollContainer.clientWidth) {
                setInterval(scrollAutomatically, 30); 
            }
        }
    });
</script>

@endsection