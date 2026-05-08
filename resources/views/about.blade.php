@extends('layouts.app')

@section('title', 'Tentang Kami - TelEVent')

@push('styles')
<style>
    .about-hero {
        background: linear-gradient(135deg, #C60C30 0%, #A00926 50%, #1A1A2E 100%);
        padding: 80px 0;
        color: white;
        text-align: center;
        border-radius: 0 0 40px 40px;
        margin-top: -24px;
        box-shadow: 0 10px 40px rgba(198,12,48,0.3);
        margin-bottom: 80px;
    }
    .about-hero h1 { font-size: 3rem; font-weight: 900; margin-bottom: 16px; }
    .about-hero p { font-size: 1.15rem; opacity: 0.9; max-width: 600px; margin: 0 auto; }

    .info-card {
        background: #fff;
        border-radius: 24px;
        padding: 50px 40px;
        height: 100%;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        border: 1px solid #F1F5F9;
        transition: 0.3s;
        position: relative;
        overflow: hidden;
    }
    .info-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, #C60C30, #FF1744);
    }
    .info-card:hover { transform: translateY(-5px); box-shadow: 0 20px 50px rgba(0,0,0,0.08); }
    .info-card-icon {
        width: 64px; height: 64px;
        background: linear-gradient(135deg, rgba(198,12,48,0.1), rgba(198,12,48,0.05));
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        font-size: 26px; color: #C60C30;
        margin-bottom: 24px;
    }
    .info-card h2 { font-size: 1.5rem; font-weight: 800; color: #1A1A2E; margin-bottom: 20px; }
    .info-card p { color: #64748B; line-height: 1.8; font-size: 1rem; }

    .mission-item {
        display: flex; align-items: flex-start; gap: 16px; margin-bottom: 20px;
    }
    .mission-item .icon { width: 40px; height: 40px; background: #C60C30; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; flex-shrink: 0; font-size: 16px; }
    .mission-item .text { color: #64748B; line-height: 1.7; font-size: 0.95rem; }

    .team-section { background: linear-gradient(135deg, #1A1A2E, #2D2D44); padding: 80px 0; border-radius: 30px; margin: 60px 0; }
    .team-card { background: rgba(255,255,255,0.07); border-radius: 20px; padding: 30px; text-align: center; border: 1px solid rgba(255,255,255,0.1); transition: 0.3s; }
    .team-card:hover { background: rgba(255,255,255,0.12); transform: translateY(-5px); }
    .team-avatar { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #C60C30, #FF1744); display: flex; align-items: center; justify-content: center; font-size: 32px; margin: 0 auto 16px; }
    .team-name { font-size: 1.05rem; font-weight: 700; color: #fff; margin-bottom: 4px; }
    .team-role { font-size: 0.85rem; color: rgba(255,255,255,0.6); }
</style>
@endpush

@section('content')
<!-- HERO -->
<div class="about-hero">
    <div class="container">
        <h1>Tentang TelEVent ✨</h1>
        <p>Platform digital satu pintu untuk manajemen acara mahasiswa Telkom University — lebih cepat, lebih rapi, dan lebih profesional.</p>
    </div>
</div>

<div class="container pb-5">

    <!-- INFO CARDS -->
    <div class="row g-4 mb-5">
        <!-- About -->
        <div class="col-lg-12">
            <div class="info-card">
                <div class="info-card-icon"><i class="fa-solid fa-circle-info"></i></div>
                <h2>Tentang Kami</h2>
                <p>
                    <strong>TelEVent</strong> hadir sebagai solusi inovatif bagi mahasiswa Telkom University yang sering terlibat dalam penyelenggaraan acara. Kami memahami tantangan dalam mengelola acara — dari persiapan awal, pengajuan dokumen, hingga pemantauan progres. Semua proses tersebut kini dapat dilakukan dalam satu platform yang simpel, terorganisir, dan efisien.
                </p>
                <p class="mt-3">Dengan TelEVent, acara kamu akan lebih cepat diproses, lebih rapi terdokumentasi, dan tentu saja — tanpa ribet.</p>
            </div>
        </div>

        <!-- Visi -->
        <div class="col-lg-6">
            <div class="info-card" style="height:100%;">
                <div class="info-card-icon"><i class="fa-solid fa-eye"></i></div>
                <h2>Visi</h2>
                <p>Menjadi platform terdepan dan terpercaya yang memudahkan mahasiswa Telkom University dalam merencanakan, mengelola, dan menyukseskan setiap acara dengan cara yang lebih efisien, praktis, dan terorganisir.</p>
            </div>
        </div>

        <!-- Misi -->
        <div class="col-lg-6">
            <div class="info-card" style="height:100%;">
                <div class="info-card-icon"><i class="fa-solid fa-bullseye"></i></div>
                <h2>Misi</h2>
                <div class="mission-item">
                    <div class="icon"><i class="fa-solid fa-check"></i></div>
                    <div class="text">Menyediakan solusi inovatif yang memudahkan penyelenggaraan acara dari awal hingga akhir.</div>
                </div>
                <div class="mission-item">
                    <div class="icon"><i class="fa-solid fa-check"></i></div>
                    <div class="text">Meningkatkan koordinasi antara penyelenggara dan tim admin secara transparan dan real-time.</div>
                </div>
                <div class="mission-item">
                    <div class="icon"><i class="fa-solid fa-check"></i></div>
                    <div class="text">Memastikan setiap acara berjalan lancar, tepat waktu, dan tanpa hambatan administrasi.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- STATS -->
    <div class="row g-4 text-center mb-5">
        <div class="col-6 col-md-3">
            <div class="info-card py-4">
                <div style="font-size:2.5rem; font-weight:900; color:#C60C30;">100+</div>
                <div style="color:#64748B; font-size:0.9rem; margin-top:6px;">Acara Berhasil</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="info-card py-4">
                <div style="font-size:2.5rem; font-weight:900; color:#C60C30;">500+</div>
                <div style="color:#64748B; font-size:0.9rem; margin-top:6px;">Mahasiswa Aktif</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="info-card py-4">
                <div style="font-size:2.5rem; font-weight:900; color:#C60C30;">20+</div>
                <div style="color:#64748B; font-size:0.9rem; margin-top:6px;">UKM Terdaftar</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="info-card py-4">
                <div style="font-size:2.5rem; font-weight:900; color:#C60C30;">5</div>
                <div style="color:#64748B; font-size:0.9rem; margin-top:6px;">Jenis Acara</div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div style="background: linear-gradient(135deg, #C60C30, #A00926); border-radius: 24px; padding: 60px; text-align: center; color: #fff;">
        <h2 style="font-size:2rem; font-weight:800; margin-bottom:12px;">Siap Bergabung?</h2>
        <p style="opacity:0.9; margin-bottom:30px; font-size:1.05rem;">Daftar sekarang dan mulai kelola acara impianmu bersama TelEVent.</p>
        <a href="{{ route('register.show') }}" style="background:#fff; color:#C60C30; border-radius:50px; padding:14px 40px; font-weight:700; text-decoration:none; display:inline-block; transition:0.3s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
            <i class="fa-solid fa-rocket me-2"></i>Daftar Gratis
        </a>
    </div>

</div>
@endsection
