<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TelEVent - Platform Manajemen Acara')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --telu-red: #C60C30;
            --telu-red-dark: #A00926;
            --bg-color: #F8F9FA;
            --text-main: #2D3748;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            scroll-behavior: smooth;
        }
        .navbar-custom {
            background: linear-gradient(135deg, var(--telu-red), var(--telu-red-dark));
            padding: 15px 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: #ffffff !important;
            letter-spacing: -0.5px;
        }
        .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-weight: 500;
            margin: 0 5px;
            transition: 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
            transform: translateY(-1px);
        }
        .btn-light-custom {
            background-color: #ffffff;
            color: var(--telu-red);
            border-radius: 50px;
            padding: 8px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .btn-light-custom:hover {
            background-color: transparent;
            color: #ffffff;
            border-color: #ffffff;
        }
        .btn-outline-light-custom {
            background-color: transparent;
            color: #ffffff;
            border-radius: 50px;
            padding: 8px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid #ffffff;
        }
        .btn-outline-light-custom:hover {
            background-color: #ffffff;
            color: var(--telu-red);
        }
        .main-container {
            flex: 1;
        }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ auth()->check() ? route('user.home') : route('dashboard') }}">
                <i class="fa-solid fa-calendar-check me-2"></i>TelEVent
            </a>
            <button class="navbar-toggler border-0 shadow-none text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fa-solid fa-bars fs-3"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        @auth
                            <a class="nav-link" href="{{ route('user.home') }}">Beranda</a>
                        @else
                            <a class="nav-link" href="{{ route('dashboard') }}">Beranda</a>
                        @endauth
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/events') }}">Semua Acara</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ url('/about') }}">Tentang Kami</a>
                    </li>
                    
                    @guest
                        <li class="nav-item mt-2 mt-lg-0">
                            <a href="{{ route('login') }}" class="btn btn-outline-light-custom me-2">Login</a>
                        </li>
                        <li class="nav-item mt-2 mt-lg-0">
                            <a href="{{ route('register.show') }}" class="btn btn-light-custom">Register</a>
                        </li>
                    @endguest
                    
                    @auth
                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-circle-user fs-5 align-middle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3 mt-2">
                                @if(auth()->user()->role == 'admin')
                                    <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-pie me-2 text-muted"></i> Dashboard Admin</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @else
                                    <li><a class="dropdown-item py-2" href="{{ route('profile.show') }}"><i class="fa-solid fa-user me-2 text-muted"></i> Profil Saya</a></li>
                                    <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="fa-solid fa-gear me-2 text-muted"></i> Pengaturan Profil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i> Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-container">
        @yield('content')
    </div>

    <footer style="background:#0F0F1A; color: rgba(255,255,255,0.5); padding: 40px 0; margin-top: auto;">
        <div class="container text-center">
            <div style="font-size:1.3rem; font-weight:800; color:#fff; margin-bottom:8px;"><i class="fa-solid fa-calendar-check text-danger me-2"></i>TelEVent</div>
            <p class="mb-0" style="font-size:0.875rem;">&copy; {{ date('Y') }} TelEVent — Telkom University. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
