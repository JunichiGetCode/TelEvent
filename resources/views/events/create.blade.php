@extends('layouts.app')

@section('title', 'Buat Event Baru')

@section('content')

{{-- CSS Khusus Halaman Ini --}}
<style>
    .form-section {
        background-color: #E9ECEF; /* Abu-abu lebih jelas */
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        height: 100%;
    }

    .required-label::after {
        content: " *";
        color: #D2042D;
        font-weight: bold;
    }

    .btn-simpan {
        background-color: #D2042D;
        color: white;
        border-radius: 50px;
        padding: 12px 50px;
        font-weight: bold;
        border: 2px solid #D2042D;
        transition: all 0.3s ease;
        font-size: 1.1rem;
    }

    .btn-simpan:hover {
        background-color: white;
        color: #D2042D;
    }

    .form-control:focus, .form-select:focus {
        border-color: #D2042D;
        box-shadow: 0 0 0 0.2rem rgba(210, 4, 45, 0.25);
    }
</style>

<div class="container py-5">
    
    {{-- Judul Halaman --}}
    <h2 class="text-center mb-5 fw-extra-bold" style="color: #D2042D; font-weight: 800; letter-spacing: 1px;">
        AYO BUAT ACARA-MU
    </h2>

    {{-- Pesan Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger mb-4 rounded-3 shadow-sm border-0">
            <h6 class="fw-bold"><i class="bi bi-exclamation-triangle-fill"></i> Ada kesalahan input:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Mulai --}}
    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            
            {{-- KOLOM KIRI: Data Acara --}}
            <div class="col-md-6">
                <div class="form-section">
                    <h5 class="mb-4 text-dark fw-bold border-bottom pb-2 border-secondary">Detail Acara</h5>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold required-label">Jenis Acara</label>
                        <select name="type" class="form-select" required>
                            <option value="" disabled selected>Pilih jenis acara...</option>
                            <option value="Exhibition" {{ old('type') == 'Exhibition' ? 'selected' : '' }}>Exhibition</option>
                            <option value="Festival" {{ old('type') == 'Festival' ? 'selected' : '' }}>Festival</option>
                            <option value="Lomba" {{ old('type') == 'Lomba' ? 'selected' : '' }}>Lomba</option>
                            <option value="Seminar" {{ old('type') == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                            <option value="Webinar" {{ old('type') == 'Webinar' ? 'selected' : '' }}>Webinar</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold required-label">Nama Acara</label>
                        <input type="text" name="title" class="form-control" placeholder="Masukkan nama kegiatan" value="{{ old('title') }}" required>
                    </div>

                    {{-- Tanggal Mulai (Sekarang Full Width ke Bawah) --}}
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold required-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                    </div>

                    {{-- Tanggal Selesai (Sekarang Full Width ke Bawah) --}}
                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold required-label">Tanggal Selesai</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Upload File --}}
            <div class="col-md-6">
                <div class="form-section">
                    <h5 class="mb-4 text-dark fw-bold border-bottom pb-2 border-secondary">Dokumen Pendukung</h5>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold required-label">Upload File Proposal</label>
                        <input type="file" name="proposal" class="form-control" accept=".pdf" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold required-label">Upload File Poster</label>
                        <input type="file" name="poster" class="form-control" accept=".jpg,.jpeg,.png" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold required-label">Upload File Timeline</label>
                        <input type="file" name="timeline" class="form-control" accept=".pdf" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold required-label">Upload File Budgeting</label>
                        <input type="file" name="budgeting" class="form-control" accept=".pdf" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark fw-semibold">Upload File Data Lainnya</label>
                        <input type="file" name="other_data" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted d-block mt-1" style="font-size: 0.85rem;">*Opsional (Jika ada dokumen tambahan)</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Simpan --}}
        <div class="text-center mt-5 mb-5">
            <button type="submit" class="btn btn-simpan shadow">Simpan Event</button>
        </div>

    </form>
</div>
@endsection