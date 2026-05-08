@extends('layouts.app')

@section('title', 'Pengaturan Profil')

@push('styles')
<style>
    :root {
        --telu-red: #C60C30;
        --telu-red-dark: #A00926;
        --bg-soft: #F8F9FA;
    }

    body {
        background-color: var(--bg-soft);
    }

    .settings-container {
        max-width: 800px;
        margin: 40px auto;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .settings-header {
        background: linear-gradient(135deg, var(--telu-red), var(--telu-red-dark));
        color: white;
        padding: 40px;
        text-align: center;
        position: relative;
    }

    .settings-header h2 {
        font-weight: 800;
        margin: 0;
        letter-spacing: 0.5px;
    }

    .settings-header p {
        opacity: 0.9;
        margin-top: 5px;
        margin-bottom: 0;
    }

    .settings-body {
        padding: 40px;
    }

    .avatar-wrapper {
        text-align: center;
        margin-top: -80px;
        margin-bottom: 30px;
        position: relative;
        z-index: 10;
    }

    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid #ffffff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        object-fit: cover;
        background: #fff;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .required-label::after {
        content: " *";
        color: var(--telu-red);
    }

    .form-control {
        border: 2px solid #E5E7EB;
        border-radius: 10px;
        padding: 12px 15px;
        transition: 0.3s;
        font-size: 15px;
    }

    .form-control:focus {
        border-color: var(--telu-red);
        box-shadow: 0 0 0 4px rgba(198, 12, 48, 0.1);
        outline: none;
    }

    .btn-save {
        background: var(--telu-red);
        color: white;
        font-weight: 600;
        border-radius: 50px;
        padding: 14px 40px;
        border: none;
        transition: 0.3s;
        font-size: 16px;
        width: 100%;
        margin-top: 20px;
    }

    .btn-save:hover {
        background: var(--telu-red-dark);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(198, 12, 48, 0.2);
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="settings-container">
        <div class="settings-header">
            <h2>Pengaturan Profil</h2>
            <p>Perbarui informasi profil Anda di sini.</p>
        </div>
        
        <div class="settings-body">
            @if ($errors->any())
                <div class="alert alert-danger rounded-3 border-0 shadow-sm mb-4">
                    <div class="fw-bold mb-2"><i class="fa-solid fa-triangle-exclamation me-2"></i> Terdapat kesalahan:</div>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="avatar-wrapper">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/profile/' . Auth::user()->avatar) }}" alt="User Avatar" class="avatar-preview">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=C60C30&color=fff" alt="Avatar" class="avatar-preview">
                    @endif
                </div>

                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label text-dark">Ubah Foto Profil</label>
                        <input type="file" name="avatar" class="form-control" accept=".jpg,.jpeg,.png">
                        <small class="text-muted mt-1 d-block">Maksimal ukuran file 2MB (.jpg, .jpeg, .png)</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label required-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama Anda" value="{{ old('name', Auth::user()->name) }}" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label required-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" value="{{ old('email', Auth::user()->email) }}" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="phone" class="form-control" placeholder="Masukkan nomor telepon" value="{{ old('phone', Auth::user()->phone) }}">
                    </div>
                </div>

                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
