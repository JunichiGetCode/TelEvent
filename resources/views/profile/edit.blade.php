@extends('layouts.app')

@section('title', 'Edit Profile')

@section('styles')


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .about-section {
            background: #F4D7DD;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .about-title {
            font-size: 2rem;
            font-weight: bold;
            color: #D2042D;
        }

        .about-content {
            font-size: 1.2rem;
            color: #6B6B6B;
            line-height: 2.5;
        }

        .navbar {
            background: linear-gradient(90deg, #D2042D, #A8092D);
            padding: 1rem;
        }

        .navbar .navbar-brand {
            color: #fff !important;
            font-weight: 800;
            font-size: 1rem;
        }

        .navbar .nav-link {
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
            max-width: 1180px;
            margin: 2rem auto;
            background: white;
            padding: 3rem;
            border-radius: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .hero-section {
            text-align: left;
            border-bottom: 1px solid #f0dce0;
            padding-bottom: 2rem;
            margin-bottom: 3rem;
        }

        .hero-title {
            font-size: 2.4rem;
            font-weight: 800;
            color: var(--red-dark);
        }

        .hero-subtitle {
            color: var(--text-soft);
            max-width: 420px;
            margin: 0 0 1.5rem 0;
            text-align: left;
            width: 100%;
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

        .required-label::after {
            content: " *";
            color: red;
            font-weight: bold;
        }

        
        
    </style>
</head>
<body>

    {{-- NAVBAR --}}
<div class="navbar navbar-light bg-light">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="{{ route('user.home') }}">TelUVent</a>

        <div class="d-flex gap-3 align-items-center">
            <a href="{{ route('user.home') }}" class="nav-link">Beranda</a>
            <a href="{{ route('events.index') }}" class="nav-link">Semua Acara</a>
            <a href="{{ route('about') }}" class="nav-link">About</a>
            <a href="{{ route('profile.show') }}" class="nav-link">Profile</a>

            <span class="text-white fw-semibold">
                Halo, {{ Auth::user()->name }} 👋
            </span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="logout-btn">Keluar</button>
            </form>
        </div>
    </div>
</div>

@section('content')
<div class="container" style="padding-top: 40px;">
    <h1 class="text-center mb-4" style="color: #D2042D; font-weight: 800;">
        Edit Profil
    </h1>

    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
    <div class="container d-flex justify-content-center align-items-center min-vh-50">
        
            <!-- LEFT -->
                <div class="form-section bg-secondary-subtle p-4 rounded-3 shadow-sm">

                    <div class="mb-3">
                        <label class="form-label text-dark required-label">Foto Profil</label>
                        <input type="file" name="avatar" class="form-control" >
                    </div>


                    <div class="mb-3">
                        <label class="form-label text-dark required-label">Nama</label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama-mu" >
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark required-label">Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Masukkan email-mu" >
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark required-label">No. Telepon</label>
                        <input type="text" name="phone" class="form-control" placeholder="Masukkan no. telepon-mu" >
                    </div>
                </div>
            </div>

        <div class="text-center mt-4">
            <button class="btn btn-danger px-5 py-2">Simpan Event</button>
        </div>

    </form>
</div>
@endsection