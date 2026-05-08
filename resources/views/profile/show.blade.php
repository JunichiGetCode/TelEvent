@extends('layouts.app')

@section('title', 'Profile Saya')

@section('content')

{{-- CSS Khusus Halaman Profile --}}
<style>
    :root {
        --red-light: #D2042D;
        --red-mid:   #A8092D;
        --bg-soft:   #FFF5F6;
    }

    /* Mengubah background halaman ini menjadi agak pink */
    body {
        background-color: var(--bg-soft);
    }

    /* Profile Card */
    .profile-card {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border-radius: 15px;
        padding: 30px;
        background: white;
        border: none;
    }

    .profile-card img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* Event Card Styling */
    .event-card-item {
        background: white;
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        transition: transform 0.2s;
        margin-bottom: 15px;
    }
    
    .event-card-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-approved { background-color: #d1e7dd; color: #0f5132; }
    .status-rejected { background-color: #f8d7da; color: #842029; }
    .status-pending  { background-color: #fff3cd; color: #664d03; }

</style>

<div class="container pb-5 pt-4">
    
    {{-- Pesan Sukses --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm border-0" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        {{-- KOLOM KIRI: Kartu Profil --}}
        <div class="col-md-4 mb-4">
            <div class="card profile-card text-center">
                <div class="card-body">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/profile/' . Auth::user()->avatar) }}" alt="User Image">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=D2042D&color=fff" alt="Avatar" style="width: 150px; height: 150px; border-radius: 50%;">
                    @endif
                    
                    <h4 class="mt-3 fw-bold">{{ Auth::user()->name }}</h4>
                    <p class="text-muted mb-1">{{ Auth::user()->email }}</p>
                    <p class="text-muted">{{ Auth::user()->phone ?? '-' }}</p>
                    
                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-danger rounded-pill">
                            <i class="fas fa-edit me-1"></i> Atur Profil
                        </a>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Status --}}
            <div class="card border-0 shadow-sm mt-4 rounded-4 p-3 bg-white">
                <h5 class="fw-bold mb-3 ms-2">Ringkasan Status</h5>
                <div class="row g-2 text-center">
                    <div class="col-4">
                        <div class="p-2 rounded-3 bg-success text-white">
                            <small>Disetujui</small>
                            <h4 class="m-0 fw-bold">{{ $approved }}</h4>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 rounded-3 bg-danger text-white">
                            <small>Ditolak</small>
                            <h4 class="m-0 fw-bold">{{ $rejected }}</h4>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 rounded-3 bg-warning text-dark">
                            <small>Menunggu</small>
                            <h4 class="m-0 fw-bold">{{ $pending }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: Riwayat Event --}}
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold m-0" style="color: #A8092D;">Riwayat Pengajuan Acara</h4>
            </div>
            
            @forelse ($myEvents as $event)
                <div class="card event-card-item">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        
                        <div class="d-flex align-items-center">
                            {{-- Thumbnail Event --}}
                            <div class="me-3 bg-light rounded d-flex align-items-center justify-content-center border" style="width: 60px; height: 60px; overflow:hidden;">
                                @if($event->poster)
                                    <img src="{{ asset('storage/' . $event->poster) }}" style="width:100%; height:100%; object-fit:cover;">
                                @else
                                    <i class="fas fa-calendar-alt text-secondary fa-lg"></i>
                                @endif
                            </div>

                            {{-- Info Event --}}
                            <div>
                                <h5 class="card-title mb-1 fw-bold">{{ $event->title }}</h5>
                                <small class="text-muted">
                                    <i class="far fa-clock me-1"></i> 
                                    {{ \Carbon\Carbon::parse($event->created_at)->format('d M Y') }}
                                    &bull; <span class="text-danger fw-bold">{{ ucfirst($event->type) }}</span>
                                </small>
                            </div>
                        </div>

                        {{-- Status & Action --}}
                        <div class="text-end">
                            <div class="mb-2">
                                @if($event->status == 'approved')
                                    <span class="status-badge status-approved">
                                        <i class="fas fa-check-circle me-1"></i> Disetujui
                                    </span>
                                @elseif($event->status == 'rejected')
                                    <span class="status-badge status-rejected">
                                        <i class="fas fa-times-circle me-1"></i> Ditolak
                                    </span>
                                @else
                                    <span class="status-badge status-pending">
                                        <i class="fas fa-hourglass-half me-1"></i> Menunggu
                                    </span>
                                @endif
                            </div>
                            
                            <div>
                                @if($event->status == 'pending' || $event->status == 'rejected')
                                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                @else
                                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="fas fa-eye me-1"></i> Lihat
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                {{-- State Kosong --}}
                <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                    <div class="mb-3 opacity-50">
                        <i class="fas fa-folder-open fa-4x text-muted"></i>
                    </div>
                    <p class="text-muted fw-bold">Anda belum mengajukan acara apapun.</p>
                    <a href="{{ route('events.create') }}" class="btn btn-danger rounded-pill px-4">Mulai Buat Acara</a>
                </div>
            @endforelse

        </div>
    </div>
</div>
@endsection