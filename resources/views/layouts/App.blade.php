<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TelUVent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Khusus yang Anda Sediakan */
        .navbar-custom {
            background-color: #C60C30; /* Warna merah Telkom */
            color: white;
            padding: 15px 40px; /* Padding ini menentukan tinggi Navbar */
            /* Tambahan: Pastikan Navbar Full Width dan kontennya berada di tengah */
            width: 100%;
            display: flex;
            justify-content: space-between; 
            align-items: center;
        }
        
        /* Tambahkan class container jika Anda ingin kontennya terpusat, 
           tapi kita pertahankan desain asli Anda yang menggunakan padding */
        
        .logo h3 {
             font-size: 1.8rem; /* Memperbesar logo */
        }
        
        .navbar-custom a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 500;
        }
        .navbar-custom a:hover {
            color: #f0f0f0;
        }
        .btn-light-custom {
            background-color: white;
            color: #C60C30;
            border-radius: 20px;
            padding: 5px 20px;
            font-weight: bold;
        }
        
        /* ... SISA CSS KONTEN UTAMA (page-shell, hero-section, dll.) harus ada di sini ... */
        /* Karena Anda menggunakan mode satu file, pastikan semua CSS ini ada di bawah */
        
    </style>
</head>
<body>

    <nav class="navbar-custom d-flex justify-content-between align-items-center">
        <div class="logo">
            <h3 class="m-0 fw-bold">TelEVent</h3>
        </div>
        
        <div class="d-flex align-items-center">
            
            {{-- 1. BERANDA KONDISIONAL (SOLUSI NAVIGASI) --}}
            @auth
                {{-- Sudah Login: Beranda mengarah ke dashboard user (/home) --}}
                <a href="{{ route('user.home') }}">Beranda</a> 
            @else
                {{-- Belum Login: Beranda mengarah ke landing page (/) --}}
                <a href="{{ route('dashboard') }}">Beranda</a>
            @endauth
            
            {{-- 2. LINK UMUM --}}
            <a href="{{ url('/events') }}">Semua Acara</a>
            <a href="{{ url('/about') }}">Tentang Kami</a>

            {{-- 3. LOGIKA GUEST --}}
            @guest
                <a href="{{ route('login') }}" class="btn btn-light-custom ms-3">Login</a>
                <a href="{{ route('register.show') }}" class="btn btn-light-custom ms-2">Register</a>
            @endguest
            
            {{-- 4. LOGIKA AUTHENTICATED USER --}}
            @auth
                
                {{-- PROFIL KONDISIONAL (SOLUSI ADMIN DASHBOARD) --}}
                @if(auth()->user()->role == 'admin')
                    {{-- ADMIN: Tautan mengarah ke Admin Dashboard --}}
                    <a href="{{ route('admin.dashboard') }}">Beranda Admin</a>
                @else
                    {{-- USER BIASA: Tautan mengarah ke User Profile --}}
                    <a href="{{ route('profile.show') }}">Profil</a>
                @endif

                <span class="ms-3">Halo, {{ Auth::user()->name }} 👋</span>
                
                <form action="{{ route('logout') }}" method="POST" class="d-inline ms-3">
                    @csrf
                    <button type="submit" class="btn btn-light-custom border-0">Keluar</button>
                </form>
            @endauth
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

</body>
</html>