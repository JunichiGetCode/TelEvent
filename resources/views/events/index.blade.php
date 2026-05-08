@extends('layouts.app')

@section('content')

    {{-- Link External --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    {{-- CSS Khusus Halaman Ini --}}
    <style>
        /* Container */
        .container-custom { max-width: 1200px; margin: 30px auto; padding: 0 20px; }

        /* Filter & Search */
        .controls { display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 30px; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .control-group { display: flex; align-items: center; }
        .control-group label { margin-right: 10px; font-weight: bold; }
        .control-group select, .control-group input { padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; }
        .control-group input { width: 300px; }

        /* Event List Grid */
        .event-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; }
        
        /* Kartu Event */
        .event {
            background-color: #fff; border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden; transition: transform 0.3s ease;
            display: flex; flex-direction: column;
        }
        .event:hover { transform: translateY(-5px); }

        /* Gambar Poster */
        .event-image-wrapper {
            height: 200px; background-color: #eee; overflow: hidden; position: relative;
        }
        .event-image-wrapper img {
            width: 100%; height: 100%; object-fit: cover;
        }

        /* Detail Event */
        .event-details { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; }
        .event-category { font-size: 0.8rem; color: #D2042D; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .event-name { font-size: 1.25rem; font-weight: bold; margin-bottom: 10px; color: #222; line-height: 1.3; }
        .event-date { font-size: 0.95rem; color: #666; margin-bottom: 15px; display: flex; align-items: center; gap: 8px; }

        /* Tombol Admin (Hapus) */
        .admin-actions { margin-top: auto; border-top: 1px solid #f0f0f0; padding-top: 15px; display: flex; justify-content: flex-end; }
        .btn-delete { background-color: #ffe6e6; color: #D2042D; border: 1px solid #D2042D; padding: 6px 12px; border-radius: 5px; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 5px; }
        .btn-delete:hover { background-color: #D2042D; color: white; }
    </style>

    {{-- KONTEN UTAMA --}}
    <div class="container-custom">
        
        {{-- Pesan Sukses --}}
        @if(session('success'))
        <div style="background:#d4edda; color:#155724; padding:15px; margin-bottom:20px; border-radius:5px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        {{-- Filter & Search --}}
        <div class="controls">
            <div class="control-group">
                <label for="category">Kategori:</label>
                <select id="category">
                    <option value="all">Semua</option>
                    <option value="Exhibition">Exhibition</option>
                    <option value="Festival">Festival</option>
                    <option value="Lomba">Lomba</option>
                    <option value="Seminar">Seminar</option>
                    <option value="Webinar">Webinar</option>
                </select>
            </div>
            <div class="control-group">
                <input type="text" id="search" placeholder="Cari nama acara...">
            </div>
        </div>

        {{-- Grid Event --}}
        <div class="event-list">
            @forelse($events as $event)
                <div class="event" data-category="{{ $event->type }}">
                    
                    <div class="event-image-wrapper">
                        @if($event->poster)
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster {{ $event->title }}">
                        @else
                            <img src="https://via.placeholder.com/400x300?text=No+Poster" alt="No Image">
                        @endif
                    </div>

                    <div class="event-details">
                        <div class="event-category">{{ $event->type }}</div>
                        <h3 class="event-name">{{ $event->title }}</h3>
                        
                        <p class="event-date">
                            <i class="far fa-calendar-alt"></i> 
                            {{ \Carbon\Carbon::parse($event->start_date)->format('d F Y') }}
                        </p>

                        @if(auth()->check() && auth()->user()->role == 'admin')
                        <div class="admin-actions">
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="form-delete-{{ $event->id }}">
                                @csrf
                                @method('DELETE')
                                
                                <button type="button" class="btn-delete" onclick="confirmDelete({{ $event->id }})">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #888;">
                    <i class="fas fa-folder-open fa-3x mb-3"></i>
                    <h3>Belum ada acara yang tersedia.</h3>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div style="margin-top: 40px; display: flex; justify-content: center;">
            {{ $events->links() }} 
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT --}}
    <script>
        // 1. Script Filter Kategori
        document.getElementById('category').addEventListener('change', function() {
            let selected = this.value;
            document.querySelectorAll('.event').forEach(el => {
                el.style.display = (selected === 'all' || el.dataset.category === selected) ? 'flex' : 'none';
            });
        });

        // 2. Script Search
        document.getElementById('search').addEventListener('input', function() {
            let term = this.value.toLowerCase();
            document.querySelectorAll('.event').forEach(el => {
                let title = el.querySelector('.event-name').textContent.toLowerCase();
                el.style.display = title.includes(term) ? 'flex' : 'none';
            });
        });

        // 3. Script SweetAlert Konfirmasi Hapus
        function confirmDelete(eventId) {
            Swal.fire({
                title: 'Hapus Event ini?',
                text: "Event yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#D2042D', // Merah sesuai tema
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Cari form berdasarkan ID dan submit
                    document.querySelector(`.form-delete-${eventId}`).submit();
                }
            });
        }
    </script>
@endsection