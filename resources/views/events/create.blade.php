@extends('layouts.app')

@section('title', 'Buat Acara Baru - TelEVent')

@push('styles')
<style>
    :root { --red: #C60C30; }
    body { background: #F4F7FE; }
    .form-hero {
        background: linear-gradient(135deg, var(--red) 0%, #A00926 50%, #1A1A2E 100%);
        padding: 60px 0;
        color: white;
        border-radius: 0 0 40px 40px;
        margin-top: -24px;
        box-shadow: 0 10px 40px rgba(198,12,48,0.3);
        margin-bottom: 50px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .form-hero::before { content: ''; position: absolute; width: 500px; height: 500px; background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%); top: -200px; right: -100px; border-radius: 50%; }
    .form-hero h1 { font-size: 2.5rem; font-weight: 900; position: relative; z-index: 1; }
    .form-hero p { opacity: 0.9; font-size: 1rem; position: relative; z-index: 1; }

    .form-wrapper { max-width: 900px; margin: 0 auto; padding-bottom: 60px; }

    .form-section-card { background: #fff; border-radius: 20px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #F1F5F9; margin-bottom: 24px; }
    .form-section-title { font-size: 1rem; font-weight: 800; color: #1A1A2E; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; padding-bottom: 14px; border-bottom: 1px solid #F1F5F9; }
    .form-section-title i { color: var(--red); background: rgba(198,12,48,0.08); width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 15px; }

    .form-label { font-weight: 600; color: #374151; font-size: 0.875rem; margin-bottom: 8px; }
    .required-label::after { content: ' *'; color: var(--red); }
    .form-control, .form-select { border: 2px solid #E5E7EB; border-radius: 12px; padding: 12px 16px; font-size: 0.95rem; transition: 0.3s; background: #fff; font-family: 'Inter', sans-serif; }
    .form-control:focus, .form-select:focus { border-color: var(--red); box-shadow: 0 0 0 4px rgba(198,12,48,0.1); outline: none; }
    .form-control[type="file"] { padding: 10px 14px; cursor: pointer; }
    .form-hint { font-size: 0.78rem; color: #94A3B8; margin-top: 6px; }

    .btn-submit { background: linear-gradient(135deg, var(--red), #A00926); color: #fff; border: none; border-radius: 14px; padding: 16px 50px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: 0.3s; font-family: 'Inter', sans-serif; display: inline-flex; align-items: center; gap: 10px; }
    .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(198,12,48,0.35); }
    .btn-cancel { color: #64748B; background: #F1F5F9; border: none; border-radius: 14px; padding: 16px 30px; font-weight: 600; font-size: 1rem; cursor: pointer; font-family: 'Inter', sans-serif; text-decoration: none; transition: 0.3s; }
    .btn-cancel:hover { background: #E2E8F0; }
</style>
@endpush

@section('content')
<div class="form-hero">
    <div class="container">
        <h1><i class="fa-solid fa-calendar-plus me-3"></i>Buat Acara Baru</h1>
        <p>Isi formulir di bawah ini untuk mengajukan proposal acara Anda.</p>
    </div>
</div>

<div class="container form-wrapper">

    @if ($errors->any())
    <div class="alert border-0 rounded-3 py-3 mb-4" style="background: rgba(239,68,68,0.1); color: #991B1B;">
        <div class="fw-bold mb-2"><i class="fa-solid fa-triangle-exclamation me-2"></i>Terdapat kesalahan:</div>
        <ul class="mb-0 ps-4 small">
            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- DETAIL ACARA -->
        <div class="form-section-card">
            <div class="form-section-title">
                <i class="fa-solid fa-info-circle"></i>
                Detail Acara
            </div>
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label required-label">Nama Acara</label>
                    <input type="text" name="title" class="form-control" placeholder="Masukkan nama kegiatan" value="{{ old('title') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label required-label">Jenis Acara</label>
                    <select name="type" class="form-select" required>
                        <option value="" disabled selected>Pilih jenis...</option>
                        <option value="Exhibition" {{ old('type') == 'Exhibition' ? 'selected' : '' }}>🏛 Exhibition</option>
                        <option value="Festival" {{ old('type') == 'Festival' ? 'selected' : '' }}>🎪 Festival</option>
                        <option value="Lomba" {{ old('type') == 'Lomba' ? 'selected' : '' }}>🏆 Lomba</option>
                        <option value="Seminar" {{ old('type') == 'Seminar' ? 'selected' : '' }}>📚 Seminar</option>
                        <option value="Webinar" {{ old('type') == 'Webinar' ? 'selected' : '' }}>💻 Webinar</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label required-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label required-label">Tanggal Selesai</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                </div>
            </div>
        </div>

        <!-- DOKUMEN WAJIB -->
        <div class="form-section-card">
            <div class="form-section-title">
                <i class="fa-solid fa-folder-open"></i>
                Dokumen Wajib
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label required-label">Proposal</label>
                    <input type="file" name="proposal" class="form-control" accept=".pdf,.doc,.docx" required>
                    <div class="form-hint">Format: PDF, DOC, DOCX</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label required-label">Timeline Kegiatan</label>
                    <input type="file" name="timeline" class="form-control" accept=".pdf,.doc,.docx" required>
                    <div class="form-hint">Format: PDF, DOC, DOCX</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label required-label">Rencana Budgeting</label>
                    <input type="file" name="budgeting" class="form-control" accept=".pdf,.doc,.docx" required>
                    <div class="form-hint">Format: PDF, DOC, DOCX</div>
                </div>
            </div>
        </div>

        <!-- DOKUMEN OPSIONAL -->
        <div class="form-section-card">
            <div class="form-section-title">
                <i class="fa-solid fa-paperclip"></i>
                Dokumen Tambahan (Opsional)
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Poster Acara</label>
                    <input type="file" name="poster" class="form-control" accept=".jpg,.jpeg,.png">
                    <div class="form-hint">Format: JPG, JPEG, PNG. Poster akan ditampilkan di direktori acara.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Data Lainnya</label>
                    <input type="file" name="other_data" class="form-control" accept=".pdf,.doc,.docx">
                    <div class="form-hint">Dokumen pendukung lainnya (jika ada).</div>
                </div>
            </div>
        </div>

        <!-- ACTIONS -->
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-paper-plane"></i> Kirim Pengajuan
            </button>
            <a href="{{ route('user.home') }}" class="btn-cancel">Batal</a>
        </div>
    </form>
</div>
@endsection
