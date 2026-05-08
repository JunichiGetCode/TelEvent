<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} - Detail Event</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* =========================================
           1. CSS LAYOUT ADMIN (Sidebar & Main)
           ========================================= */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
            color: #333;
        }

        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(135deg, #800000, #b30000);
            color: white;
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar .avatar { text-align: center; margin-bottom: 30px; }
        .sidebar .avatar img { width: 80px; height: 80px; border-radius: 50%; border: 3px solid rgba(255,255,255,0.3); }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar ul li { margin: 15px 0; }
        .sidebar ul li a { color: rgba(255,255,255,0.8); text-decoration: none; font-size: 16px; display: block; padding: 10px 15px; border-radius: 5px; transition: all 0.3s; }
        .sidebar ul li a:hover, .sidebar ul li a.active { color: #fff; background-color: rgba(255,255,255,0.1); transform: translateX(5px); }
        .sidebar-footer { position: absolute; bottom: 20px; left: 20px; font-size: 14px; color: rgba(255,255,255,0.6); }

        /* Main Content Styles */
        .main-content {
            margin-left: 290px; /* Lebar sidebar + spacing */
            padding: 40px;
        }

        /* Card Styles */
        .card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #444;
            margin: 0 0 20px 0;
            border-left: 5px solid #800000;
            padding-left: 15px;
        }

        /* =========================================
           2. CSS KHUSUS TOMBOL FILE
           ========================================= */
        .file-buttons-container {
            display: flex;
            gap: 15px;
            flex-wrap: wrap; /* Agar turun ke bawah jika layar sempit */
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .btn-file {
            display: inline-flex;
            align-items: center;
            padding: 12px 20px;
            border-radius: 8px;
            background-color: #fff;
            color: #555;
            text-decoration: none;
            font-weight: 500;
            border: 1px solid #ddd;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .btn-file i {
            margin-right: 10px;
            font-size: 18px;
        }

        /* Warna spesifik saat hover */
        .btn-file:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-color: #800000;
            color: #800000;
        }

        /* Warna icon spesifik */
        .fa-file-pdf { color: #dc3545; }
        .fa-calendar-alt { color: #007bff; }
        .fa-file-invoice-dollar { color: #28a745; }
        .fa-folder-open { color: #ffc107; }

        .back-btn {
            display: inline-flex;
            align-items: center;
            color: #666;
            text-decoration: none;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .back-btn:hover { color: #800000; }

    </style>
</head>
<body>

    <div class="sidebar">
        <div class="avatar">
            <img src="https://ui-avatars.com/api/?name=Admin&background=random" alt="Admin Avatar"> 
        </div>
        <ul>
            <li><a href="{{ route('user.home') }}"><i class="fas fa-arrow-left"></i> &nbsp; Dashboard</a></li>
            
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> &nbsp; Admin Home</a></li>
            <li><a href="{{ route('admin.events.index') }}" class="active"><i class="fas fa-calendar-alt"></i> &nbsp; Kelola Event</a></li>
            <li><a href="#"><i class="fas fa-envelope"></i> &nbsp; Pesan Masuk</a></li>
        </ul>
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="background:none; border:none; color:white; cursor:pointer;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        
        <a href="{{ route('admin.events.index') }}" class="back-btn">
            <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Kembali ke Daftar Event
        </a>

        <div class="card">
            <h1 class="section-title">{{ $event->title }}</h1>
            
            <div style="color: #555; line-height: 1.6;">
                <p><strong>Diajukan Oleh:</strong> {{ $event->user->name ?? 'User' }}</p>
                <p><strong>Tanggal Pengajuan:</strong> {{ $event->created_at->format('d F Y, H:i') }} WIB</p>
                <p><strong>Status Saat Ini:</strong> 
                    @if($event->status == 'approved')
                        <span style="color: green; font-weight: bold;">Disetujui</span>
                    @elseif($event->status == 'rejected')
                        <span style="color: red; font-weight: bold;">Ditolak</span>
                    @else
                        <span style="color: orange; font-weight: bold;">Menunggu Review</span>
                    @endif
                </p>
                @if($event->description)
                    <p><strong>Deskripsi:</strong><br>{{ $event->description }}</p>
                @endif
            </div>

            <h3 style="margin-top: 30px; font-size: 18px; color: #444;">Dokumen Pendukung:</h3>
            
            <div class="file-buttons-container">
                
                @if ($event->proposal)
                    <a href="{{ asset('storage/' . $event->proposal) }}" target="_blank" class="btn-file">
                        <i class="fas fa-file-pdf"></i> Lihat Proposal
                    </a>
                @endif

                @if ($event->timeline)
                    <a href="{{ asset('storage/' . $event->timeline) }}" target="_blank" class="btn-file">
                        <i class="fas fa-calendar-alt"></i> Lihat Timeline
                    </a>
                @endif

                @if ($event->budgeting)
                    <a href="{{ asset('storage/' . $event->budgeting) }}" target="_blank" class="btn-file">
                        <i class="fas fa-file-invoice-dollar"></i> Lihat Budgeting
                    </a>
                @endif

                @if ($event->other_data)
                    <a href="{{ asset('storage/' . $event->other_data) }}" target="_blank" class="btn-file">
                        <i class="fas fa-folder-open"></i> Lihat Data Lainnya
                    </a>
                @endif

                {{-- Jika tidak ada file sama sekali --}}
                @if(!$event->proposal && !$event->timeline && !$event->budgeting && !$event->other_data)
                    <p style="color: #999; font-style: italic;">Tidak ada dokumen yang dilampirkan.</p>
                @endif

            </div>
        </div>

    </div>

</body>
</html>