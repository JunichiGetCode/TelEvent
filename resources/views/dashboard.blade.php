<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TelEVent - Platform Manajemen Acara Telkom University</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --telu-red: #C60C30;
            --telu-red-dark: #A00926;
            --telu-red-light: #FF1744;
            --bg-color: #F8F9FA;
            --text-main: #1A1A2E;
            --text-muted: #64748B;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-color); color: var(--text-main); min-height: 100vh; display: flex; flex-direction: column; }

        /* NAVBAR */
        .navbar-custom {
            background: linear-gradient(135deg, var(--telu-red), var(--telu-red-dark));
            padding: 16px 0;
            box-shadow: 0 4px 20px rgba(198,12,48,0.25);
            position: sticky; top: 0; z-index: 1000;
        }
        .navbar-brand { font-weight: 800; font-size: 1.5rem; color: #fff !important; letter-spacing: -0.5px; }
        .nav-link { color: rgba(255,255,255,0.85) !important; font-weight: 500; margin: 0 4px; transition: 0.3s; }
        .nav-link:hover { color: #fff !important; transform: translateY(-1px); }
        .btn-light-custom { background: #fff; color: var(--telu-red); border-radius: 50px; padding: 8px 24px; font-weight: 600; transition: 0.3s; border: 2px solid transparent; }
        .btn-light-custom:hover { background: transparent; color: #fff; border-color: #fff; }
        .btn-outline-light-custom { background: transparent; color: #fff; border-radius: 50px; padding: 8px 24px; font-weight: 600; transition: 0.3s; border: 2px solid #fff; }
        .btn-outline-light-custom:hover { background: #fff; color: var(--telu-red); }

        /* HERO */
        .hero-section {
            background: linear-gradient(135deg, var(--telu-red) 0%, var(--telu-red-dark) 40%, #1A1A2E 100%);
            min-height: 90vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            width: 700px; height: 700px;
            background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
            top: -200px; right: -200px; border-radius: 50%;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.04) 0%, transparent 70%);
            bottom: -100px; left: -100px; border-radius: 50%;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.15); backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff; border-radius: 50px; padding: 8px 20px; font-size: 0.85rem; font-weight: 600;
            margin-bottom: 24px;
        }
        .hero-title { font-size: 4rem; font-weight: 900; color: #fff; line-height: 1.1; margin-bottom: 20px; }
        .hero-title span { color: #FFD700; }
        .hero-subtitle { font-size: 1.2rem; color: rgba(255,255,255,0.8); line-height: 1.8; margin-bottom: 40px; max-width: 500px; }
        .btn-hero-primary { background: #fff; color: var(--telu-red); border: none; border-radius: 50px; padding: 16px 40px; font-weight: 700; font-size: 1rem; transition: 0.3s; }
        .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.2); }
        .btn-hero-outline { background: transparent; color: #fff; border: 2px solid rgba(255,255,255,0.5); border-radius: 50px; padding: 16px 40px; font-weight: 700; font-size: 1rem; transition: 0.3s; }
        .btn-hero-outline:hover { background: rgba(255,255,255,0.15); border-color: #fff; transform: translateY(-3px); }

        .hero-stats { display: flex; gap: 40px; margin-top: 50px; }
        .hero-stat { text-align: center; }
        .hero-stat .number { font-size: 2rem; font-weight: 800; color: #FFD700; line-height: 1; }
        .hero-stat .label { font-size: 0.85rem; color: rgba(255,255,255,0.7); margin-top: 4px; }

        .hero-illustration {
            position: relative; z-index: 1;
        }
        .floating-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px; padding: 20px 25px;
            color: #fff; margin-bottom: 16px;
            animation: float 3s ease-in-out infinite;
        }
        .floating-card:nth-child(2) { animation-delay: 1.5s; }
        .floating-card .fc-icon { font-size: 2rem; margin-bottom: 10px; }
        .floating-card .fc-title { font-weight: 700; font-size: 1rem; }
        .floating-card .fc-sub { font-size: 0.8rem; opacity: 0.8; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

        /* FEATURES */
        .features-section { padding: 100px 0; }
        .section-badge { display: inline-block; background: rgba(198,12,48,0.1); color: var(--telu-red); border-radius: 50px; padding: 6px 20px; font-size: 0.85rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 16px; }
        .section-title-main { font-size: 2.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 16px; line-height: 1.2; }
        .section-desc { font-size: 1.05rem; color: var(--text-muted); max-width: 500px; }

        .feature-card { background: #fff; border-radius: 24px; padding: 40px 30px; height: 100%; transition: 0.4s; border: 1px solid #F1F5F9; position: relative; overflow: hidden; }
        .feature-card::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--telu-red), var(--telu-red-light)); opacity: 0; transition: 0.4s; }
        .feature-card:hover { transform: translateY(-10px); box-shadow: 0 20px 60px rgba(0,0,0,0.08); border-color: rgba(198,12,48,0.1); }
        .feature-card:hover::after { opacity: 1; }
        .feature-icon { width: 70px; height: 70px; background: linear-gradient(135deg, rgba(198,12,48,0.1), rgba(198,12,48,0.05)); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 28px; color: var(--telu-red); margin-bottom: 24px; transition: 0.4s; }
        .feature-card:hover .feature-icon { background: linear-gradient(135deg, var(--telu-red), var(--telu-red-dark)); color: #fff; transform: rotate(5deg) scale(1.1); }
        .feature-title { font-size: 1.2rem; font-weight: 700; margin-bottom: 12px; }
        .feature-desc { color: var(--text-muted); line-height: 1.7; font-size: 0.95rem; }

        /* HOW IT WORKS */
        .steps-section { padding: 100px 0; background: linear-gradient(135deg, #1A1A2E 0%, #2D2D44 100%); }
        .step-card { text-align: center; padding: 40px 20px; position: relative; }
        .step-number { font-size: 4rem; font-weight: 900; color: rgba(198,12,48,0.3); line-height: 1; margin-bottom: 20px; }
        .step-icon-wrap { width: 80px; height: 80px; background: var(--telu-red); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 30px; color: #fff; margin: 0 auto 20px; box-shadow: 0 10px 30px rgba(198,12,48,0.4); }
        .step-title { font-size: 1.15rem; font-weight: 700; color: #fff; margin-bottom: 12px; }
        .step-desc { color: rgba(255,255,255,0.6); font-size: 0.9rem; line-height: 1.7; }
        .step-connector { position: absolute; top: 60px; right: -30px; color: rgba(255,255,255,0.2); font-size: 2rem; z-index: 1; }

        /* CTA */
        .cta-section { padding: 100px 0; }
        .cta-card { background: linear-gradient(135deg, var(--telu-red), var(--telu-red-dark)); border-radius: 30px; padding: 80px 60px; text-align: center; position: relative; overflow: hidden; }
        .cta-card::before { content: ''; position: absolute; width: 500px; height: 500px; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%); top: -200px; right: -100px; border-radius: 50%; }
        .cta-title { font-size: 2.5rem; font-weight: 800; color: #fff; margin-bottom: 16px; position: relative; z-index: 1; }
        .cta-desc { font-size: 1.1rem; color: rgba(255,255,255,0.85); margin-bottom: 40px; max-width: 500px; margin-left: auto; margin-right: auto; position: relative; z-index: 1; }
        .btn-cta { background: #fff; color: var(--telu-red); border: none; border-radius: 50px; padding: 16px 50px; font-weight: 700; font-size: 1.1rem; transition: 0.3s; position: relative; z-index: 1; }
        .btn-cta:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.3); }

        /* FOOTER */
        footer { background: #0F0F1A; color: rgba(255,255,255,0.6); padding: 60px 0 30px; margin-top: auto; }
        .footer-brand { font-size: 1.5rem; font-weight: 800; color: #fff; margin-bottom: 12px; }
        .footer-desc { font-size: 0.9rem; line-height: 1.7; max-width: 280px; }
        .footer-title { font-weight: 700; color: #fff; margin-bottom: 20px; font-size: 0.95rem; letter-spacing: 0.5px; text-transform: uppercase; }
        .footer-links { list-style: none; padding: 0; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a { color: rgba(255,255,255,0.6); text-decoration: none; transition: 0.3s; font-size: 0.9rem; }
        .footer-links a:hover { color: #fff; padding-left: 5px; }
        .footer-divider { border-color: rgba(255,255,255,0.1); margin: 40px 0 20px; }
        .main-container { flex: 1; }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-calendar-check me-2"></i>TelEVent
            </a>
            <button class="navbar-toggler border-0 shadow-none text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fa-solid fa-bars fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">Semua Acara</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Tentang Kami</a></li>
                </ul>
                <div class="d-flex gap-2 align-items-center mt-2 mt-lg-0">
                    <a href="{{ route('login') }}" class="btn-outline-light-custom">Login</a>
                    <a href="{{ route('register.show') }}" class="btn-light-custom">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero-section">
        <div class="container position-relative" style="z-index:1;">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-badge">
                        <i class="fa-solid fa-star text-warning"></i>
                        Platform Acara #1 Telkom University
                    </div>
                    <h1 class="hero-title">
                        Wujudkan Acara <span>Luar Biasa</span> Bersama Kami
                    </h1>
                    <p class="hero-subtitle">
                        TelEVent — Platform satu pintu bagi mahasiswa Telkom University untuk mengajukan, mengelola, dan memantau status acara secara profesional dan efisien.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('register.show') }}" class="btn btn-hero-primary">
                            <i class="fa-solid fa-rocket me-2"></i>Mulai Sekarang
                        </a>
                        <a href="{{ route('events.index') }}" class="btn btn-hero-outline">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>Lihat Acara
                        </a>
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <div class="number">100+</div>
                            <div class="label">Acara Berhasil</div>
                        </div>
                        <div class="hero-stat">
                            <div class="number">500+</div>
                            <div class="label">Mahasiswa Aktif</div>
                        </div>
                        <div class="hero-stat">
                            <div class="number">20+</div>
                            <div class="label">UKM Terdaftar</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1 mt-5 mt-lg-0">
                    <div class="hero-illustration">
                        <div class="floating-card">
                            <div class="fc-icon">🎯</div>
                            <div class="fc-title">Pengajuan Mudah</div>
                            <div class="fc-sub">Ajukan proposal dalam hitungan menit</div>
                        </div>
                        <div class="floating-card ms-4">
                            <div class="fc-icon">📊</div>
                            <div class="fc-title">Monitor Real-time</div>
                            <div class="fc-sub">Pantau status pengajuan kapan saja</div>
                        </div>
                        <div class="floating-card">
                            <div class="fc-icon">✅</div>
                            <div class="fc-title">Disetujui Lebih Cepat</div>
                            <div class="fc-sub">Admin merespons dengan cepat dan transparan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="features-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6">
                    <span class="section-badge">Fitur Unggulan</span>
                    <h2 class="section-title-main">Semua yang Kamu Butuhkan untuk Mengelola Acara</h2>
                </div>
                <div class="col-lg-6 d-flex align-items-end">
                    <p class="section-desc">Dari pengajuan proposal hingga pemantauan progres, kami menyediakan semua alat yang kamu butuhkan.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa-solid fa-file-circle-check"></i></div>
                        <h3 class="feature-title">Pengajuan Proposal Digital</h3>
                        <p class="feature-desc">Upload semua dokumen pendukung acara — proposal, timeline, budgeting, dan poster — langsung dari platform kami.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa-solid fa-gauge-high"></i></div>
                        <h3 class="feature-title">Dashboard Monitoring</h3>
                        <p class="feature-desc">Lacak status pengajuan acara secara real-time. Ketahui apakah proposal sedang ditinjau, disetujui, atau ditolak.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <h3 class="feature-title">Peninjauan Terpusat Admin</h3>
                        <p class="feature-desc">Admin mengelola seluruh pengajuan dari satu dashboard. Proses persetujuan menjadi lebih cepat, transparan, dan terstruktur.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa-solid fa-calendar-days"></i></div>
                        <h3 class="feature-title">Direktori Acara Publik</h3>
                        <p class="feature-desc">Semua acara yang telah disetujui tampil di direktori publik. Mahasiswa bisa menemukan dan mengikuti acara dengan mudah.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa-solid fa-user-circle"></i></div>
                        <h3 class="feature-title">Profil Penyelenggara</h3>
                        <p class="feature-desc">Kelola profil Anda, lihat riwayat pengajuan, dan pantau semua acara yang pernah Anda ajukan dalam satu tempat.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fa-solid fa-layer-group"></i></div>
                        <h3 class="feature-title">Multi-kategori Acara</h3>
                        <p class="feature-desc">Dukung berbagai jenis acara: Exhibition, Festival, Lomba, Seminar, hingga Webinar — semua dalam satu ekosistem.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="steps-section">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-badge" style="background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.9);">Cara Kerja</span>
                <h2 class="section-title-main text-white mt-2">Mulai dalam 3 Langkah Mudah</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-number">01</div>
                        <div class="step-icon-wrap"><i class="fa-solid fa-user-plus"></i></div>
                        <h3 class="step-title">Daftar & Login</h3>
                        <p class="step-desc">Buat akun dengan email mahasiswa Telkom University dan lengkapi profil Anda untuk memulai.</p>
                        <div class="step-connector d-none d-md-block"><i class="fa-solid fa-arrow-right"></i></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-number">02</div>
                        <div class="step-icon-wrap"><i class="fa-solid fa-file-arrow-up"></i></div>
                        <h3 class="step-title">Ajukan Proposal</h3>
                        <p class="step-desc">Isi detail acara, upload semua dokumen pendukung, dan kirim pengajuan Anda ke Admin.</p>
                        <div class="step-connector d-none d-md-block"><i class="fa-solid fa-arrow-right"></i></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-number">03</div>
                        <div class="step-icon-wrap"><i class="fa-solid fa-party-horn"></i></div>
                        <h3 class="step-title">Acara Disetujui!</h3>
                        <p class="step-desc">Admin meninjau dan menyetujui proposal Anda. Acara tampil di direktori publik dan siap dihadiri!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-card">
                <h2 class="cta-title">Siap Menggelar Acara Luar Biasa?</h2>
                <p class="cta-desc">Bergabung dengan ratusan mahasiswa Telkom University yang telah mempercayakan pengelolaan acara mereka kepada TelEVent.</p>
                <a href="{{ route('register.show') }}" class="btn btn-cta">
                    <i class="fa-solid fa-rocket me-2"></i>Daftar Gratis Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-brand"><i class="fa-solid fa-calendar-check text-danger me-2"></i>TelEVent</div>
                    <p class="footer-desc">Platform manajemen acara digital terpadu untuk mahasiswa Telkom University. Dari proposal hingga pelaksanaan, kami siap membantu.</p>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="footer-title">Platform</div>
                    <ul class="footer-links">
                        <li><a href="{{ route('events.index') }}">Semua Acara</a></li>
                        <li><a href="{{ route('register.show') }}">Daftar</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="footer-title">Info</div>
                    <ul class="footer-links">
                        <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                        <li><a href="#">Panduan</a></li>
                        <li><a href="#">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <div class="footer-title">Tentang Kami</div>
                    <p style="font-size:0.9rem; line-height:1.7;">TelEVent dikembangkan sebagai solusi digital untuk memudahkan administrasi dan pengelolaan acara di lingkungan Telkom University.</p>
                </div>
            </div>
            <hr class="footer-divider">
            <div class="text-center" style="font-size:0.875rem;">
                &copy; {{ date('Y') }} TelEVent — Telkom University. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
