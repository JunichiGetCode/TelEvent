@extends('layouts.app')

@section('title', 'About Us')

@section('content')

{{-- CSS Khusus Halaman About --}}
<style>
    .about-section {
        background: #F4D7DD; /* Background Pink */
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-top: 50px; /* Jarak dari navbar */
    }

    .about-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: #D2042D; /* Merah Telkom */
        margin-bottom: 20px;
    }

    .about-content {
        font-size: 22px;
        color: #4a4a4a;
        line-height: 1.8;
    }
</style>

<div class="container">
    <div class="about-section">
        <h2 class="about-title">Tentang Kami</h2>
        <div class="about-content">
            <p>
                TELEVENT hadir sebagai solusi inovatif bagi mahasiswa Telkom University yang sering kali terlibat 
                dalam penyelenggaraan acara. Kami memahami tantangan dalam mengelola acara, dari persiapan awal, 
                pendaftaran peserta, hingga pengecekan progres acara. Semua proses tersebut dapat dilakukan dalam 
                satu platform yang simple, terorganisir, dan efisien. Dengan TELEVENT, acara kamu akan menjadi lebih 
                cepat, rapi, dan tentu saja, tanpa ribet.
            </p>
        </div>
    </div>
</div>
<div class="container">
    <div class="about-section">
         <h2 class="about-title">Visi</h2>
        <div class="about-content">
            <p>
                Visi kami Menjadi platform terdepan dan terpercaya yang memudahkan mahasiswa Telkom University dalam merencanakan, 
                mengelola, dan menyukseskan setiap acara dengan cara yang lebih efisien, praktis, dan terorganisir.
            </p>
        </div>
            <h2 class="about-title">Misi</h2>
            <div class="about-content">
            <p>
                Misi kami Menyediakan solusi inovatif yang memudahkan penyelenggaraan acara, mulai dari pendaftaran peserta hingga 
                pemantauan progres, dengan fokus pada kemudahan penggunaan, peningkatan koordinasi antara penyelenggara dan peserta, 
                serta memastikan setiap acara berjalan dengan lancar, tepat waktu, dan tanpa hambatan.
            </p>
        </div>
    </div>
</div>

@endsection