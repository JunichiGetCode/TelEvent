<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TelUVent – Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --red-light: #D2042D;
            --red-mid:   #A8092D;
            --red-dark:  #450C1C;
            --bg-soft:   #FFF5F6;
            --card-bg:   #FFFFFF;
            --text-soft: #6B6B6B;
        }

        body {
            background-color: var(--bg-soft);
            font-family: system-ui, sans-serif;
        }

        .nav-shell {
            background: linear-gradient(90deg, var(--red-light), var(--red-mid));
            padding: 1rem;
        }

        .navbar-brand {
            font-weight: 800;
            color: #fff !important;
            font-size: 30px;
        }

        .nav-link {
            color: #fff !important;
            font-weight: 500;
        }

        .logout-btn {
            background-color: #ffffff;
            color: #D2042D;
            border-radius: 50px;
            border: 2px solid #D2042D;
            padding: 8px 24px;
            font-weight: bold;
        }

        .logout-btn:hover {
            background-color: #D2042D;
            color: white;
        }

        .page-shell {
            max-width: 96%;
            margin: 2rem auto;
            background: white;
            padding: 3rem;
            border-radius: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

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
        }

        .hero-title {
            font-size: 2.4rem;
            font-weight: 800;
            color: var(--white);
        }

        .hero-subtitle {
            color: var(--white);
            max-width: 420px;
            margin: 0 auto 1.5rem;
        }

        .btn-event {
            background-color: #D2042D;
            color: white;
            border-radius: 50px;
            padding: 12px 32px;
            font-weight: bold;
            border: 2px solid white;
            transition: 0.3s;
        }

        .btn-event:hover {
            background: white;
            color: #D2042D;
            border: 2px solid #D2042D;
        }

       .hero-panel {
            background: white;
            border-radius: 16px;              
            border: 1.5px solid #F4D7DD;      
            padding: 1rem;                    
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06); 
        }

        .hero-panel-box {
            background: #FFF5F6;
            border: 1px solid #F2D7DB;
            border-radius: 12px;              
            padding: 0.8rem 1rem;            
            font-size: 20px;                
        }
    </style>
</head>

<body>

{{-- NAVBAR --}}
<div class="nav-shell">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="{{ route('dashboard') }}">TelEVent</a>

        <div class="d-flex gap-3 align-items-center">
            <a href="{{ route('dashboard') }}" class="nav-link">Beranda</a>
            <a href="{{ route('events.index') }}" class="nav-link">Semua Acara</a>

            <a href="{{ route('login') }}" class="logout-btn text-decoration-none">
                Masuk
            </a>

            <a href="{{ route('register.show') }}" class="logout-btn text-decoration-none">
                Daftar
            </a>
        </div>
    </div>
</div>

{{-- DASHBOARD --}}
<main class="page-shell">

    {{-- HERO --}}
    <section class="hero-section mb-4">
        <div class="banner">
            <div class="banner-content">
                <h1 class="hero-title">
                    Bangun dan kelola Acara-mu <br> Dengan mudah!
                </h1>
                <p></p>
                <p></p>
                <p class="hero-subtitle">
                    Platform satu pintu untuk mahasiswa Telkom University. <br>
                    Kelola acara dengan sistem terstruktur, profesional, dan efisien.

                <div class="d-flex justify-content-center gap-3 mt-3 mb-5">
                    <a href="{{ route('login') }}" class="btn btn-event">📝Buat Acara</a>
                    <a href="{{ route('register.show') }}" class="btn btn-event">🔎Cari Acara</a>
                </div>
            </div>
        </div>
    </section>

    {{-- RINGKASAN --}}
    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="hero-panel">
                <div class="hero-panel-box">
                    <strong>Event</strong> terkelola dengan rapi
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="hero-panel">
                <div class="hero-panel-box">
                    <strong>Monitoring</strong> untuk panitia
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="hero-panel">
                <div class="hero-panel-box">
                    <strong>Akses mudah</strong> untuk mahasiswa
                </div>
            </div>
        </div>
    </div>

</main>

</body>
</html>